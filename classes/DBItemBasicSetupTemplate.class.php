<?php
class DBItemBasicSetupTemplate extends Template{
	public $stylePlace = "./style/";
	public $scriptPlace = "./script/";
	public $favicon = "";
	public $content;
	public $headContent;
	public $footContent;
	
	/**
	 * @var ViewableHTMLNavigation
	 */
	public $mainNavigation;
	public $headActive = false;
	public $contentIndent = 0;
	public $pureContent = false;
	public $bodyClass = "";
	
	public function __construct(){
		$this->mainNavigation = new ViewableHTMLNavigation();
		$this->mainNavigation->setHTMLAttribute("id", "mainNavigation");
	}
}
?>