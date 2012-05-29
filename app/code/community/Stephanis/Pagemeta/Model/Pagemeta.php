<?php

class Stephanis_Pagemeta_Model_Pagemeta extends Mage_Core_Model_Abstract {

	public function _construct() {
		parent::_construct();
		$this->_init('pagemeta/pagemeta');
	}

}