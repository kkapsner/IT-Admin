<?php

/**
 * PHP class dummy
 *
 * @author kkapsner
 */
class ComputerWoLPlugin extends DBItemPlugin{
	public function getName() {
		return "Wake on LAN";
	}

	/**
	 * 
	 * @param DBItemClassSpecifier $classSpecifier
	 */
	public function isValidClass($classSpecifier) {
		return $classSpecifier->getClassName() === "Computer";
	}

}

?>
