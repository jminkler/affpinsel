<?php

$zipFile = 'marketplace_feed_v2.xml.zip';
$xmlFile = 'marketplace_feed_v2.xml';

if ($argv[1] == 'load') {
if (file_exists($xmlFile)) {
	$filetime = filetime($xmlFile);
	if ($filetime < strtotime('-1 days')) {
		exec('rm '.$xmlFile);
		exec('rm '.$zipFile);
		exec('wget https://accounts.clickbank.com/feeds/'.$zipFile);
		exec('unzip '.$zipFile);

	}
	
} else {
	exec('wget https://accounts.clickbank.com/feeds/'.$zipFile);
	exec('unzip '.$zipFile);

}}

$xml = simplexml_load_file($xmlFile);

foreach ($xml->Category as $category) {
	$cat = $category->Name;
	$category = simplexml_load_string($category->asXml());
	foreach ($category->xpath('Site') as $site) {
		$url = 'http://xxx.'.$site->Id.'.hop.clickbank.net/';

		$tags = get_meta_tags($url);
		$title = '';
		if ($fp = @fopen( $url, 'r' )) {

		    $cont = "";
		   
		    // read the contents
		    while( !feof( $fp ) ) {
		       $buf = trim(fgets( $fp, 4096 )) ;
		       $cont .= $buf;
		    }

		    // get tag contents
		    @preg_match( "/<title>([a-z 0-9]*)<\/title>/si", $cont, $match );
		   
		    // tag contents
		    $title = strip_tags(@$match[ 1 ]);
		}

		$insert = sprintf(
			"'%s', %s, %s, %s, '%s', '%s', '%s'",
			$site->Id,
			$site->Gravity,
			$site->PercentPerSale,
			$site->Commission,
			$title,
			$tags['keywords'],
			$tags['description']
		);
		$sql = "insert into sites (id, gravity, pps, comm, title, keywords, desc) values($insert)";
		var_dump($sql);
		exec("sqlite3 cb.db \"$sql\"");
	}
}
