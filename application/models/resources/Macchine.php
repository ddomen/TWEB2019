<?php

class Application_Resource_Macchine extends Zend_Db_Table_Abstract {
    protected $_name    = 'macchine';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Macchine_Item';
    
    public function init() { }
    
    public function getCatalog($values = null, $ordinator = null, $paged = null, $itemsPerPage = 3){
        $select = $this->select();

        switch($ordinator){
            case 'DESC_P': $select = $select->order('prezzo DESC'); break;
            case 'DESC_S': $select = $select->order('posti DESC'); break;
            case 'ASC_S': $select = $select->order('posti ASC'); break;
            default: case 'ASC_P': $select = $select->order('prezzo ASC'); break;
        }

        if($values != null){
            $prezzoMin = $values['prezzoMin'] != '' ? floatval($values['prezzoMin']) : null;
            $prezzoMax = $values['prezzoMax'] != '' ? floatval($values['prezzoMax']) : null;
            $posti = $values['posti'] != '' ? intval($values['posti']) : null;
            $modello = strval($values['modello']);
            $marca = strval($values['marca']);
    
            if($modello){
                $modello = explode(',', $modello);
                $modello = array_map(function($m){ return trim($m); }, $modello);
                $select = $select->where('modello IN (?)', $modello);
            }
            if($marca){
                $marca = explode(',', $marca);
                $marca = array_map(function($m){ return trim($m); }, $marca);
                $select = $select->where('marca IN (?)', $marca);
            }
            if($prezzoMin != null){ $select = $select->where('prezzo >= ?', $prezzoMin); }
            if($prezzoMax != null){ $select = $select->where('prezzo <= ?', $prezzoMax); }
            if($posti != null){ $select = $select->where('posti = ?', $posti); }
        }


        if($paged != null){
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage)
		          	  ->setCurrentPageNumber(intval($paged));
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



