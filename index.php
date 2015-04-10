<?php
include_once("/korbinian/Programmieren/Html/PHP/kamiKatze/autoload.php");

$temp = new DBItemBasicSetupTemplate();
$temp->addStyle("css.css");
$temp->addStyle("mainmenu.css");
$temp->addStyle("DBItem.css");

$temp->addScript("/kkjs/modules/kkjs.load.js?modules=dataset", false);
$temp->addScript("WOL.js", true, true);

$db = DB::getInstance();

$config = new ConfigFile("config.ini");
$config->load();

$ldap = LDAP::createFromConfigFile(new ConfigFile("ldapConfig.ini", true));
$admins = $ldap->getGroupByDN($config->ADMIN_GROUP);

DBItemWrapper::addPluginCLASS("Computer", new ComputerIPPlugin());
DBItemWrapper::addPluginCLASS("Computer", new ComputerWoLPlugin());

$action = array_read_key("action", $_GET, false);
if (!in_array($action, $config->ACTIONS)){
	$action = $config->DEFAULT_ACTION;
}

$class = array_read_key("class", $_POST, false);
if ($class === false){
	$class = array_read_key("class", $_GET, false);
}
if (!in_array($class, $config->DB_ITEMS)){
	$class = false;
}

include("./navigation.php");

if ($class === false){
	include ("./actions/chooseClass.php");
}
else if (is_file("./actions/" . $action . ".php")){
	include("./actions/" . $action . ".php");
}

$temp->write();
?>
