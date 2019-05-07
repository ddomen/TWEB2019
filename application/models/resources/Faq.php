<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract {
    protected $_name    = 'faq';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Faq_Item';

    public function init() { }
    
    public function getTop(){
        $select = $this->select()->order('Punteggio')->limit(10);
        return $this->fetchAll($select);
    }
}

