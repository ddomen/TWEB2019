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
        $select = $this->select();
        
        if($values[modello]!=null){
            $select->where('modello LIKE ?','%'. $values[modello] .'%');
        }
        
        if($values[marca]!=null){
            $select->where('marca LIKE ?','%'. $values[marca] .'%');
        }
        
        if($values[prezzoMin]!=null){
            $prezzoMin=$values[prezzoMin];
            $select->where('prezzo > ?', $prezzoMin);
        }
        
        if($values[prezzoMax]!=null){
            $prezzoMax=$values[prezzoMax];
            $select->where('prezzo < ?', $prezzoMax);
        }
        
        if($values[posti]!=null){
            $select->where('posti =?', $values[posti]);
        }
        
        if($values[allestimento]!=null){
            $select->where('allestimento LIKE ?','%'. $values[allestimento] .'%');
        }
        
        return $this->fetchAll($select);
        
        
    } 
}



