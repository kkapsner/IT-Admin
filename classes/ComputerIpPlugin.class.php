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

}

?>