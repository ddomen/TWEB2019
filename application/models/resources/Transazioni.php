<?php

class Application_Resource_Transazioni extends Zend_Db_Table_Abstract {
    protected $_name    = 'transazioni';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Transazioni_Item';

    public function init() { }
}

