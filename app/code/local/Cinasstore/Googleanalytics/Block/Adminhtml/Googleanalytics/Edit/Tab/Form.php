<?php

class Cinasstore_Googleanalytics_Block_Adminhtml_Googleanalytics_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('googleanalytics_form', array('legend'=>Mage::helper('googleanalytics')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('googleanalytics')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('googleanalytics')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('googleanalytics')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('googleanalytics')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('googleanalytics')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('googleanalytics')->__('Content'),
          'title'     => Mage::helper('googleanalytics')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getGoogleanalyticsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getGoogleanalyticsData());
          Mage::getSingleton('adminhtml/session')->setGoogleanalyticsData(null);
      } elseif ( Mage::registry('googleanalytics_data') ) {
          $form->setValues(Mage::registry('googleanalytics_data')->getData());
      }
      return parent::_prepareForm();
  }
}