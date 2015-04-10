<?php

if (array_key_exists("action", $_POST) && $_POST["action"] === "search"){
	$db = DB::getInstance();
	$where = $db->quote($_POST["field"], DB::PARAM_IDENT) . " LIKE " . $db->quote("%" . $_POST["value"] . "%", DB::PARAM_STR);

	$temp->content .= '<h1>Search results</h1><ul>';
	$temp->content .= DBItem::getByConditionCLASS($class, $where)->view(false, false);
	/*foreach (DBItem::getByConditionCLASS($class, $where) as $item){
		$temp->content .= '<li>' .
			$item->view("link", false) .
		'</li>';
	}*/
	$temp->content .= '</ul>';
}
else {
	$temp->content = '<h1>Search ' . $class . '</h1>' .
		'<form method="POST">Search in <select name="field">';
	foreach (DBItemField::parseClass($class) as $item){
		/* @var $item DBItemField */
		if ($item->searchable){
			$temp->content .= '<option>' . $item->name . '</option>';
		}
	}
	$temp->content .= '</select> for <input name="value"><br><button type="submit" name="action" value="search">search</button></form>';
}
?>
