<?php

class Application_Resource_Occupazioni extends Zend_Db_Table_Abstract {
    protected $_name    = 'occupazioni';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Occupazioni_Item';

    public function init() { }

    public function getAll(){ return $this->fetchAll($this->select()); }
}

