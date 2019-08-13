<?php

class Cinasstore_Googleanalytics_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isHiddenLike(){
		return Mage::getStoreConfig('googleanalytics/general/hidden_like');
	}
	
	public function isHiddenComment(){
		return Mage::getStoreConfig('googleanalytics/general/hidden_comment');
	}
	
	public function isCustomLike(){
		return Mage::getStoreConfig('googleanalytics/like/custom');
	}
	
	public function isCustomComment(){
		return Mage::getStoreConfig('googleanalytics/comment/custom');
	}
	
	public function getLikeCssStyle(){
		return Mage::getStoreConfig('googleanalytics/like/css_style');
	}
	
	public function getCommentCssStyle(){
		return Mage::getStoreConfig('googleanalytics/comment/css_style');
	}
}