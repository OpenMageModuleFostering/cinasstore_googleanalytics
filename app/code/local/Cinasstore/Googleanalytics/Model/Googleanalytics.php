<?php

class Cinasstore_Googleanalytics_Model_Googleanalytics extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('googleanalytics/googleanalytics');
    }
}