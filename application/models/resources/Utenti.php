<?php

class Application_Resource_Utenti extends Zend_Db_Table_Abstract {
    protected $_name    = 'utenti';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Utenti_Item';

    public function init() { }

    public function getByUsername($username){
        $where = $this->getAdapter()->quoteInto('Username = ?', $username);
        $select = $this->select()->where($where);
        $result = $this->fetchAll($select);
        return count($result) > 0 ? $result[0] : null;
    }

    public function getById($id){
        $select = $this->select()->where('ID = ?', $id);
        $result = $this->fetchAll($select);
        return count($result) > 0 ? $result[0] : null;
    }

    public function updateUser($user){
        $where = $this->getAdapter()->quoteInto('ID = ?', $user['ID']);
        return $this->update((array)$user, $where);
    }

    public function getAll(){ return $this->fetchAll($this->select()); }
}

