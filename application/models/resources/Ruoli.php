<?php

class Application_Resource_Ruoli extends Zend_Db_Table_Abstract {
    protected $_name    = 'ruoli';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Ruoli_Item';

    public function init() { }
}

