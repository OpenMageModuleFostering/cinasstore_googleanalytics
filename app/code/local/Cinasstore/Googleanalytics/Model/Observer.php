<?php

class Cinasstore_Googleanalytics_Model_Observer {

	public function saveGoogleanalyticsConfig($observer)
	{
		$googleanalytics = Mage::getModel('googleanalytics/googleanalytics');
		$googleanalytics->setEditTime(now());
		try{
			$googleanalytics->save();
		}catch(Exception $e){
			Mage::getSingleton('core/session')->addError($e);
		}
	}
	
	public function controller_action_predispatch_adminhtml($observer)
	{
		$controller = $observer->getControllerAction();
		if($controller->getRequest()->getControllerName() != 'system_config'
			|| $controller->getRequest()->getActionName() != 'edit')
			return;
		$section = $controller->getRequest()->getParam('section');
		if($section != 'googleanalytics')
			return;
	}			
}