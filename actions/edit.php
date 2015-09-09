<?php
if (include("login.php")){
	if (array_key_exists("id", $_GET) && ($item = DBItem::getCLASS($class, $_GET["id"]))){
		$permission = $admins->isMember($user);
		foreach ($item->administrators as $admin){
			if ($user === $admin->userId){
				$permission = true;
				break;
			}
		}
		if ($permission){
			if (array_key_exists("action", $_POST) && array_key_exists("id", $_POST)){
				switch ($_POST["action"]){
					case "save":
						$item = DBItem::getCLASS($class, $_POST["id"]);
						$data = DBItemField::parseClass($class)->translateRequestData($_POST[$class][$item->DBid]);

						foreach ($data as $name => $value){
							$item->{$name} = $value;
						}

						$temp->content .= $item->view(false, false);
						break;
					case "delete":
						$item = DBItem::getCLASS($class, $_POST["id"]);
						$line = $item->view("singleLine");
						$item->delete();
						$temp->content = '<h1>' . $line . ' deleted</h1>';
						break;
				}
			}
			else {
				$temp->content = '<h1>Edit ' . $item->view("singleLine") . '</h1><form method="POST" enctype="multipart/form-data">';
				$temp->content .= $item->view("edit", false);
				$temp->content .= '<button type="submit" name="action" value="save">save</button>' .
					'<button type="submit" name="action" value="delete">delete</button>' .
					'</form>';
			}
		}
		else {
			$temp->content .= "<b><i>Access denied</i></b>";
		}
	}
	else {
		$temp->content = '<h1>Choose  ' . $class . '</h1>';
		$where = "`id` IN (SELECT `link_id` FROM `computerAdministrators` WHERE `userId` = " . $user->getId() . ")";
//		$temp->content .= DBItem::getByConditionCLASS($class, $where)->view("link|singleLine", false);
		$temp->content .= '<ul>';
		foreach (DBItem::getByConditionCLASS($class, $where) as $item){
			$temp->content .= '<li>' .
				'<a href="?action=' . $action . '&class=' . $class . '&id=' . $item->DBid . '">' .
				$item->view("singleLine", false) .
				'</a></li>';
		}
		$temp->content .= '</ul>';
		
		if ($admins->isMember($user)){
			$temp->content .= '<h1>Choose remaining ' . $class . '</h1>';
			$where = "`id` NOT IN (SELECT `link_id` FROM `computerAdministrators` WHERE `userId` = " . $user->getId() . ")";
//			$temp->content .= DBItem::getByConditionCLASS($class, $where)->view("link|singleLine", false);
			$temp->content .= '<ul>';
			foreach (DBItem::getByConditionCLASS($class, $where) as $item){
				$temp->content .= '<li>' .
					'<a href="?action=' . $action . '&class=' . $class . '&id=' . $item->DBid . '">' .
					$item->view("singleLine", false) .
					'</a></li>';
			}
			$temp->content .= '</ul>';
		}
	}
}
?>