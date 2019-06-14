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
                $modelli = array();
                foreach($modello as $m){ array_push($modelli, trim($m)); }
                $select = $select->where('Modello LIKE ?',$modelli);
            }
            if($marca){
                $marca = explode(',', $marca);
                $marche = array();
                foreach($marca as $m){ array_push($marche, trim($m)); }
                $select = $select->where('Marca IN (?)', $marche);
            }
            if($values['allestimento']){
                $select = $select->where('Allestimento LIKE ?', '%'.$values['allestimento'].'%');
            }
            if($prezzoMin != null){ $select = $select->where('Prezzo >= ?', $prezzoMin); }
            if($prezzoMax != null){ $select = $select->where('Prezzo <= ?', $prezzoMax); }
            if($posti != null){ $select = $select->where('Posti = ?', $posti); }
            
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
    
    public function updateC($car){
        $where = $this->getAdapter()->quoteInto('ID = ?', $car['ID']);
        return $this->update((array)$car, $where);
    }

    public function getById($id)
    {
        $select=$this->select()

                    ->where('ID IN(?)', $id); 
        
        $row = $this->fetchAll($select);
        if(count($row)>0){
            return $row[0];
        }
        else return null;

    }
}



