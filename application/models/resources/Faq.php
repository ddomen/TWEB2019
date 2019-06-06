<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract {
    protected $_name    = 'faq';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Faq_Item';

    public function init() { }
    
    public function getTop($top = 5){
        $select = $this->select()->order('Punteggio')->limit($top);
        return $this->fetchAll($select);
    }
}

