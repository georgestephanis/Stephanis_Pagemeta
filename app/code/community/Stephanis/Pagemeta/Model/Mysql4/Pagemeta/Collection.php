<?php

class Stephanis_Pagemeta_Model_Mysql4_Pagemeta_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        // parent::__construct();
        $this->_init('pagemeta/pagemeta');
    }
}