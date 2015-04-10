<?php

/**
 * PHP class dummy
 *
 * @author kkapsner
 */
class ComputerIPPlugin extends DBItemPlugin{
	public function getName() {
		return "IP";
	}

	/**
	 * 
	 * @param DBItemClassSpecifier $classSpecifier
	 */
	public function isValidClass($classSpecifier) {
		return $classSpecifier->getClassName() === "Computer";
	}
	
	public function getIP(DBItem $item) {
		return file_get_contents("https://bigmac.e14.ph.tum.de/utils/ipList/singleNameRequest.php?name=" . urlencode($item->name));
	}

}

?>
