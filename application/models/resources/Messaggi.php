<?php

class Application_Resource_Messaggi extends Zend_Db_Table_Abstract {
    protected $_name    = 'messaggi';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Messaggi_Item';

    public function init() { }
}

