<?php
class Cinasstore_Googleanalytics_Adminhtml_DashboardController extends Mage_Adminhtml_Controller_action
{

   protected function _initAction()
  {
	 $this->loadLayout()
      ->_setActiveMenu('googleanalytics/dashboard')
      ->_addBreadcrumb(Mage::helper('adminhtml')->__('Settings'), Mage::helper('adminhtml')->__('Settings'));
    return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

}