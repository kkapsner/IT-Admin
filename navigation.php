<?php


/* @var $temp DBItemBasicSetupTemplate */
$temp;
/* @var $config ConfigFile */
$config;

foreach ($config->ACTIONS as $actionName => $a){
	$item = $temp->mainNavigation->addItem($actionName, "?action=" . $a);
	/* @var $item ViewableHTMLNavigationItem */
	$item->active = $a === $action;
	if (count($config->DB_ITEMS) === 1){
		$item->url .= "&class=" . $config->DB_ITEMS[0];
	}
	else {
		$subNav = $item->addNavigation();
		foreach ($config->DB_ITEMS as $cn => $c){
			if (is_numeric($cn)){
				$cn = $c;
			}
			$subItem = $subNav->addItem($cn, $item->url . "&class=" . $c);
			$subItem->active = $item->active && ($c === $class);
		}
	}
	if (($a === "show" || $a === "edit") && ($a !== $action) && $class && array_key_exists("id", $_GET)){
		$id = $_GET["id"];
		if ($id){
			if (is_numeric($id)){
				$item->url .= "&class=" . $class . "&id=" . $id;
			}
			elseif ($id === "getByName"){
				$item->url .= "&class=" . $class . "&name=" . $_GET["name"];
			}
		}
	}
}

$item = $temp->mainNavigation->addItem("logout", "logout.php");
?>
