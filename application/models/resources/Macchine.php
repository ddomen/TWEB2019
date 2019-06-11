<?php

class Application_Resource_Macchine extends Zend_Db_Table_Abstract {
    protected $_name    = 'macchine';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Macchine_Item';

    public function init() { }
    
    
    
    
    
    public function getCatalog($ordinator,$paged=null){
        if($ordinator=="DESC_P"){
            $select = $this->select()->order('prezzo DESC')->order('ID DESC');
        }
        if($ordinator=="ASC_P"){
            $select = $this->select()->order('prezzo ASC')->order('ID ASC');
        }
        if($ordinator=="DESC_S"){
            $select = $this->select()->order('posti DESC')->order('ID DESC');
        }
        if($ordinator=="ASC_S"){
            $select = $this->select()->order('posti ASC')->order('ID ASC');
        }
        if($ordinator==null){
            $select = $this->select();
        }
        
        
        
        if ($paged !== null) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(3)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        
        return $this->fetchAll($select);       
    }
    
    
    public function getCatalogFiltered($values){
             
        $prezzoMin=$values[prezzoMin];
        $prezzoMax=$values[prezzoMax];
        $select = $this->select()->where('modello IN (?)',$values)
                                 ->where('marca IN (?)', $values)
                                 ->where('prezzo > ?', $prezzoMin)
                                 ->where('prezzo < ?', $prezzoMax)
                                 ->where('posti IN (?)', $values);
        
        
        
        
        return $this->fetchAll($select);
    } 
    
    
    
}


    

