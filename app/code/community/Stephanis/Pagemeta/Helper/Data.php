<?php
 
class Stephanis_Pagemeta_Helper_Data extends Mage_Core_Helper_Abstract {

	public function get( int $page_id, string $key, string $default = null ){
		$core_read 	= Mage::getSingleton('core/resource')->getConnection('core_read');
		$table 		= Mage::getSingleton('core/resource')->getTableName('pagemeta');

		$sql = "SELECT 	* 
				FROM 	{$table} 
				WHERE 	`page_id` = '$page_id' 
				AND 	`key` = '$key' 
				LIMIT 	1 ";
		$row = $core_read->fetchRow( $sql );

		if( $row ){
			return $row['value'];
		} else {
			return $default;
		}

	}

	public function getAllForPage( int $page_id, array $defaults = array() ) {
		$core_read 	= Mage::getSingleton('core/resource')->getConnection('core_read');
		$table 		= Mage::getSingleton('core/resource')->getTableName('pagemeta');

		$sql = "SELECT 	* 
				FROM 	{$table} 
				WHERE 	`page_id` = '$page_id' ";
		$res = $core_read->fetchAll( $sql );

		$return = $defaults;
		if( is_array( $res ) ){
			foreach( $res as $row ){
				$return[$row['key']] = $row['value'];
			}
		}

		return $return;
	}

	public function set( int $page_id, string $key, string $value ){
		$core_write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$table 		= Mage::getSingleton('core/resource')->getTableName('pagemeta');

		$previous = $this->get( $page_id, $key );
		
		if( $previous == $value ){
			return $value;
		} elseif( ! is_null( $previous ) ) {
			$sql = "UPDATE 	{$table} 
					SET 	`value` 	= '$value' 
					WHERE 	`page_id` 	= '$page_id' 
					AND 	`key` 		= '$key' 
					LIMIT 	1 ";
			$core_write->query( $sql );
			return $value;
		} elseif( is_null( $previous ) ) {
			$sql = "INSERT INTO	{$table} 
					SET 		`page_id` 	= '$page_id', 
								`key` 		= '$key', 
								`value` 	= '$value' ";
			$core_write->query( $sql );
			return $value;
		}

		return false;

	}

	public function setAllForPage( int $page_id, array $data ) {
		$core_write = Mage::getSingleton('core/resource')->getConnection('core_write');

		$previous = $this->getAllForPage( $page_id );

		if( is_array( $data ) ){
			foreach( $data as $k => $v ){
				if( isset( $previous[$k] ) && ( $v == $previous[$k] ) ) continue;
				$this->set( $page_id, $k, $v );
			}
		}

	}

}