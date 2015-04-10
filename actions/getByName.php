<?php

if (array_key_exists("id", $_GET) && $_GET["id"] === "getByName"){
	if (array_key_exists("name", $_GET)){
		$item = DBItem::getByConditionCLASS(
			$class,
			"
			`name` LIKE " . $db->quote($_GET["name"]) . " OR
			`name` LIKE " . $db->quote("TUPHE14-" . $_GET["name"]) . " OR
			`name` LIKE " . $db->quote("TUPHE14-PC-" . $_GET["name"])
		);
		unset($_GET["name"]);
		if (count($item) > 0){
			$_GET["id"] = $item[0]->DBid;
		}
		else {
			$_GET["id"] = 0;
		}
	}
	else {
		$_GET["id"] = 0;
	}
}
?>