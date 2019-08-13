<?php

class Cinasstore_Googleanalytics_Block_Adminhtml_Googleanalytics_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('googleanalytics_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('googleanalytics')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('googleanalytics')->__('Item Information'),
          'title'     => Mage::helper('googleanalytics')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('googleanalytics/adminhtml_googleanalytics_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}