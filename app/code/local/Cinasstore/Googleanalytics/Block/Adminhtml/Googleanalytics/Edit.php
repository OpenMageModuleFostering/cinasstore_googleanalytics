<?php

class Cinasstore_Googleanalytics_Block_Adminhtml_Googleanalytics_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'googleanalytics';
        $this->_controller = 'adminhtml_googleanalytics';
        
        $this->_updateButton('save', 'label', Mage::helper('googleanalytics')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('googleanalytics')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('googleanalytics_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'googleanalytics_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'googleanalytics_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('googleanalytics_data') && Mage::registry('googleanalytics_data')->getId() ) {
            return Mage::helper('googleanalytics')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('googleanalytics_data')->getTitle()));
        } else {
            return Mage::helper('googleanalytics')->__('Add Item');
        }
    }
}