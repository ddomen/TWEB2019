<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract {
    protected $_name    = 'faq';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Faq_Item';

    public function init() { }
    
    public function getAllFaqs(){
        $select = $this->select()->order('Punteggio DESC');
        return $this->fetchAll($select);
    }
    
    public function getTop($top = 5){
        $select = $this->select()->order('Punteggio')->limit($top);
        return $this->fetchAll($select);
    }
    
    
    public function insertFaq($info)
    {
    	$this->insert($info);
    }

      
    public function getById($id){
        $select = $this->select()->where('ID = ?', $id);
        $result = $this->fetchAll($select);
        return count($result) > 0 ? $result[0] : null;

    }
    
    public function updateFaq($faq){
        $where = $this->getAdapter()->quoteInto('ID = ?', $faq['ID']);
        return $this->update((array)$faq, $where);
    }
    
}

