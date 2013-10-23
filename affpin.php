<?php

/**
 * AffPin 
 * 
 * @uses PHPUnit
 * @uses _Extensions_SeleniumTestCase
 * @package 
 * @version $id$
 * @copyright 2013 DoMyOwnPestControl.com
 * @author Jarret Minkler <jarret@domyownpestcontrol.com> 
 * @license License <>
 */
class AffPin extends PHPUnit_Extensions_SeleniumTestCase
{
  /**
   * setUp 
   * 
   * @access protected
   * @return void
   */
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://www.amazon.com/");
  }

  
  /**
   * testMyTestCase 
   * 
   * @access public
   * @return void
   */
  public function testMyTestCase($username, $password)
  {
    $this->open("/");
    $this->click("link=Sign in");
    $this->waitForPageToLoad("30000");
    $this->type("id=ap_email", $username);
    $this->type("id=ap_password", $password);
    $this->click("id=signInSubmit-input");
    $this->waitForPageToLoad("30000");
    $this->click("id=twotabsearchtextbox");
    $this->type("id=twotabsearchtextbox", "PHP in Books");
    $this->click("css=input.nav-submit-input");
    $this->waitForPageToLoad("30000");
    $this->click("//div[@class='data']/h3/a");
    $this->waitForPageToLoad("30000");

    // @todo Get title with getEval
    //$id=btAsinTitle = $this->getHtmlSource();
    
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("link=Link to this page")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->click("link=Link to this page");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("link=Text Only")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->click("link=Text Only");
    $Link = $this->getValue("id=static_txt_html_box");
    print($Link . "\n");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("css=span.ap_closebutton")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->click("css=span.ap_closebutton");
    $this->click("id=nav-item-signout");
    $this->waitForPageToLoad("30000");
    $this->open("http://pinterest.com/");
    $this->waitForPageToLoad("30000");
    $this->click("link=Log in now");
    $this->waitForPageToLoad("30000");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("name=username_or_email")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->type("name=username_or_email", $username);
    $this->type("name=password", $password);
    $this->click("//button[@type='submit']");
    $this->click("xpath=(//button[@type='button'])[2]");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("xpath=(//button[@type='button'])[81]")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->click("xpath=(//button[@type='button'])[81]");
    $this->type("name=url", $Link);
    $this->click("xpath=(//button[@type='submit'])[2]");
    $this->waitForPageToLoad("30000");
    $this->click("//div[2]/div/div/div/div[2]/a/div");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isElementPresent("id=pinDescriptionField")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->type("id=pinDescriptionField", "${Title}");
    $this->type("css=input.boardSelectorInput", "PHP");
    $this->click("xpath=(//button[@type='submit'])[2]");
    $this->click("css=span.profileName");
    $this->click("link=Log Out");

  }


}
?>
