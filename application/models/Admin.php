<?php

class Application_Model_Admin extends App_Model_Abstract
{ 

	public function __construct()
    {
    }
    
    
    public function saveFaq($info)
    {
    	return $this->getResource('Faq')->insertFaq($info);
    }
    
    public function saveModifyFaq($info,$valID)
    {
    	return $this->getResource('Faq')->modifyFaq($info,$valID);
    }
    
    
}