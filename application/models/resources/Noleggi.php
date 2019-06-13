<?php

class Application_Resource_Noleggi extends Zend_Db_Table_Abstract {
    protected $_name    = 'noleggi';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Noleggi_Item';

    public function init() { }

    public function getProspettoMensile($anno = null){
        if($anno == null){ $anno = date('Y'); }
        $select = $this->select()
                        ->from('noleggi', array())
                        ->columns(array('Conteggio' => 'COUNT(*)', 'Mese' => 'MONTH(inizio)'))
                        ->where('YEAR(inizio) = ?', intval($anno))
                        ->group(array('YEAR(inizio)', 'MONTH(inizio)'));
        return $this->fetchAll($select);
    }

    public function getProspettoAnno(){
        $select = $this->select()
                        ->from('noleggi', array())
                        ->columns(array('Conteggio' => 'COUNT(*)', 'Anno' => 'YEAR(inizio)'))
                        ->group(array('YEAR(inizio)'));
        return $this->fetchAll($select);
    }
}

