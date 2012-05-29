<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
 
$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('pagemeta')};
CREATE TABLE IF NOT EXISTS {$this->getTable('pagemeta')} (
	`pagemeta_id` int(11) unsigned NOT NULL auto_increment,
	`page_id` int(11) unsigned NOT NULL,
	`key` varchar(255) NOT NULL,
	`value` longtext NOT NULL default '',
	PRIMARY KEY (`pagemeta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
 
$installer->endSetup();