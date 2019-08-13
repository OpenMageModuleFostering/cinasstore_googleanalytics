<?php
class Cinasstore_Googleanalytics_Block_Adminhtml_Googleanalytics extends Mage_Adminhtml_Block_Template
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_googleanalytics';
    $this->_blockGroup = 'googleanalytics';
    $this->_headerText = Mage::helper('googleanalytics')->__('Item Manager');
    parent::__construct();
  }
}