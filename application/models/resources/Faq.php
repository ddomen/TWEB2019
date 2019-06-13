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
    
    
    public function modifyFaq($info,$valID){
        if($info['Titolo']==0){$this->update($info['Titolo'],'ID='.$valID);}
        if($info['Testo']==0){$this->update($info['Testo'],'ID='.$valID);}
        if($info['Punteggio']==0){$this->update($info['Punteggio'],'ID='.$valID);}
    }
    
    public function getIDFaq($valID){
        $select=$this->select()->where('ID =?',$valID);
        $this -> fetchAll ($select) ;
    }
    
    
    
    
    
    public function deleteFaq($info)
    {
        $select=$this->select()->where('ID =?',$info[ID]);
        $this -> delete ($select) ;
    }
    
    
    
}

