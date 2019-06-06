<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract {
    protected $_name    = 'utenti';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Utenti_Item';

    public function init() { }

    public function getByUsername($username){
        $select = $this->select()->where("Username = '" . $username . "'");
        $result = $this->fetchAll($select);
        return count($result) > 0 ? $result[0] : null;
    }
}

