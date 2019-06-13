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
        if($info['titolo']==0){$this->update($info['titolo'],'ID='.$valID);}
        if($info['testo']==0){$this->update($info['testo'],'ID='.$valID);}
        if($info['punteggio']==0){$this->update($info['punteggio'],'ID='.$valID);}
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

