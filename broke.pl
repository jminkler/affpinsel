#!/usr/bin/perl
use strict;
#use warnings;
use Data::Dumper;
use URI;
use Web::Scraper;
use DBI;

my $dbh = DBI->connect(          
    "dbi:SQLite:dbname=broke.db", 
    "",
    "",
    { RaiseError => 1}
) or die $DBI::errstr;

$dbh->do("DROP TABLE IF EXISTS broke");
$dbh->do("CREATE TABLE broke(Id INTEGER PRIMARY KEY AUTOINCREMENT, Name TEXT CONSTRAINT unq UNIQUE, Price INT)");



  # First, create your scraper block
  my $articles = scraper {
      # Parse all LIs with the class "status", store them into a resulting
      # array 'tweets'.  We embed another scraper for each tweet.
      process "article.post", "articles[]" => scraper {
	process ".title", title => 'TEXT';
	process ".price", price => 'TEXT';
      }
  };

  my $res = $articles->scrape( URI->new("http://www.thisiswhyimbroke.com/gifts/gifts-for-geeks") );

  # The result has the populated tweets array
  for my $tweet (@{$res->{articles}}) {
      $tweet->{price} =~ s/\$//g;
      $tweet->{price} =~ s/,//g;
      if (int($tweet->{price}) < 100) {
	$dbh->do("INSERT INTO broke (name) VALUES('$tweet->{title}')");
      	print "$tweet->{title}|",int($tweet->{price}),"\n";
      }
  }

$dbh->disconnect();
