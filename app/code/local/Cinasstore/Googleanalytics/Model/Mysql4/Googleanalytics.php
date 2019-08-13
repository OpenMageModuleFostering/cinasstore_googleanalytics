<?php

class Cinasstore_Googleanalytics_Model_Mysql4_Googleanalytics extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the googleanalytics_id refers to the key field in your database table.
        $this->_init('googleanalytics/googleanalytics', 'googleanalytics_id');
    }
}