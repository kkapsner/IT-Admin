<?php

if (array_key_exists("id", $_GET) && $_GET["id"] != 0){
	$item = DBItem::getCLASS($class, $_GET["id"]);
	$temp->content .= $item->view(false, false);
}
else {
	if (array_key_exists("column", $_GET) && is_array($_GET["column"])){
		$temp->content = DBItem::getByConditionCLASS($class, false)->view(false, false, $_GET["column"]);
	}
	else {
		$temp->content = '<h1>Choose item</h1>';
		$temp->content .= DBItem::getByConditionCLASS($class, "`visible`")->view("link|singleLine", false);
	}
}
?>