<?php

class Application_Resource_Transazioni extends Zend_Db_Table_Abstract {
    protected $_name    = 'transazioni';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Transazioni_Item';

    public function init() { }

    public function getAll(){
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function getTransazById($id)
    {
        return $this->find($id)->current();
    }

    public function insertTransaz($data)
    {
    	$this->insert($data);
    }

    public function deleteTransaz($where)
    {
    	$this->delete($where);
    }
    
    
}

