<?php

class Stephanis_Pagemeta_Model_Observer_Opengraph {

	public function prepareForm( Varien_Event_Observer $observer ) {
        $model 		= Mage::registry('cms_page');
		$form 		= $observer->getEvent()->getForm();
		$page_id 	= $model->getPageId();

		if( ! $page_id ) return;

		$fieldset = $form->addFieldset(
			'stephanis_opengraph',
			array(
				'legend' 	=> 'Facebook Open Graph Data',
				'class' 	=> 'fieldset-wide'
			)
		);

		$fieldset->addField( 'og_title', 'text', array(
			'name' 		=> 'og_title',
			'label' 	=> 'Title',
		) );
		$fieldset->addField( 'og_description', 'textarea', array(
			'name' 		=> 'og_description',
			'label' 	=> 'Description',
		) );
		$fieldset->addField( 'og_image_url', 'text', array(
			'name' 		=> 'og_image_url',
			'label' 	=> 'Image URL',
		) );
		$fieldset->addField( 'og_page_url', 'text', array(
			'name' 		=> 'og_page_url',
			'label' 	=> 'Page Canonical URL',
		) );
		$fieldset->addField( 'og_type', 'select', array(
			'name' 		=> 'og_type',
			'label' 	=> 'Type',
			'values' 	=> array(
				array(
					'value' => '',
					'label' => 'Select one ...',
				),
				array(
					'value' => 'article',
					'label' => 'Article',
				),
				array(
					'value' => 'blog',
					'label' => 'Blog',
				),
				array(
					'value' => 'website',
					'label' => 'Website',
				),
				array(
					'value' => 'activity',
					'label' => 'Activity',
				),
			),
			'after_element_html' => '<small>Set as `Article` if you&rsquo;re uncertain.</small>',
		) );

		$defaults = array(
			'og_title' 		=> '',
			'og_description'=> '',
			'og_image_url' 	=> '',
			'og_page_url' 	=> '',
			'og_type' 		=> '',
		);

		$values = array_merge( $defaults, Mage::helper('pagemeta')->getAllForPage( $page_id ) );

		if( is_array( $values ) ){
			foreach( $values as $k => $v ){
				$model->setData( $k, $v );
			}
		}

	}

	public function savePage( Varien_Event_Observer $observer ) {
		$page 		= $observer->getEvent()->getPage();
		$request 	= $observer->getEvent()->getRequest();
		$data 		= $request->getPost();
		$_helper 	= Mage::helper('pagemeta');
		$page_id 	= $page->getId();

		if( ! $page_id ) return;

		$keys = array( 'og_title', 'og_description', 'og_image_url', 'og_page_url', 'og_type' );
		$pagemeta = array();

		foreach( $keys as $key ){
			if( isset( $data[$key] ) && $data[$key] ){
				$_helper->set( $page_id, $key, $data[$key] );
			}
		}

	}

}