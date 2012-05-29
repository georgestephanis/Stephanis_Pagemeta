<?php
 
class Stephanis_Pagemeta_Model_Mysql4_Pagemeta extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('pagemeta/pagemeta', 'pagemeta_id');
    }
}