<?php

class Application_Resource_Macchine extends Zend_Db_Table_Abstract {
    protected $_name    = 'macchine';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Macchine_Item';

    public function init() { }
    
    public function orderDescCatalog(){
        $select = $this->select()->order('prezzo DESC')->order('ID DESC');
        return $this->fetchAll($select);
        
    }
    
    public function orderAscCatalog(){
        $select = $this->select()->order('prezzo ASC')->order('ID ASC');
        return $this->fetchAll($select);
    }

    public function getCatalog(){
        $select = $this->select();
        return $this->fetchAll($select);
    }
}

