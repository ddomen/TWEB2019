<?php

class Application_Resource_Messaggi extends Zend_Db_Table_Abstract {
    protected $_name    = 'messaggi';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Messaggi_Item';

    public function init() { }

    public function getByUser($userId, $date = null){
        if($date == null){ $date = date('Y-m-d', time() - 2592000); }
        $select = $this->select()
                        ->where('Mittente = ? OR Destinatario = ?', intval($userId))
                        ->where('Data >= ?', $date);
        $result = $this->fetchAll($select);
        return $result;
    }
}

