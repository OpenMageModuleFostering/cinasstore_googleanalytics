<?php

class Cinasstore_Googleanalytics_Model_Mysql4_Googleanalytics_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('googleanalytics/googleanalytics');
    }
}