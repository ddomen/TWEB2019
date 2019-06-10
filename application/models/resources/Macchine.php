<?php

class Application_Resource_Macchine extends Zend_Db_Table_Abstract {
    protected $_name    = 'macchine';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Macchine_Item';

    public function init() { }
    
    public function orderCatalog($filtro){
        if($filtro=="DESC_P"){
            $select = $this->select()->order('prezzo DESC')->order('ID DESC');
        return $this->fetchAll($select);
        }
        if($filtro=="ASC_P"){
            $select = $this->select()->order('prezzo ASC')->order('ID ASC');
        return $this->fetchAll($select);
        }
        if($filtro=="DESC_S"){
            $select = $this->select()->order('posti DESC')->order('ID DESC');
        return $this->fetchAll($select);
        }
        if($filtro=="ASC_S"){
            $select = $this->select()->order('posti ASC')->order('ID ASC');
        return $this->fetchAll($select);
        }
        
    }

    public function getCatalog(){
        $select = $this->select();
        return $this->fetchAll($select);
    }
}

