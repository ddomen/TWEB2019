<?php

class Application_Resource_Macchine extends Zend_Db_Table_Abstract {
    protected $_name    = 'macchine';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Macchine_Item';
    
    public function init() { }
    
    public function getCatalog($values = null, $paged = null, $itemsPerPage = 3){
        $select = $this->select();
        $pag=0;

        if($values != null){
            $prezzoMin = $values['prezzoMin'] != '' ? floatval($values['prezzoMin']) : null;
            $prezzoMax = $values['prezzoMax'] != '' ? floatval($values['prezzoMax']) : null;
            $modello = strval($values['modello']);
            $marca = strval($values['marca']);
            $posti = strval($values['posti']);
            $from = isset($values['from']) ? strval($values['from']) : null;
            $to = isset($values['to']) ? strval($values['to']) : null;
            $ordinator=$values['OrderBy'];
    
            if($modello!=null){
                $modello = explode(',', $modello);
                $modelli = array();
                foreach($modello as $m){ array_push($modelli, trim($m)); }
                $select = $select->where('Modello LIKE ?',$modelli);
                $pag=1;
            }
            if($marca!=null){
                $marca = explode(',', $marca);
                $marche = array();
                foreach($marca as $m){ array_push($marche, trim($m)); }
                $select = $select->where('Marca IN (?)', $marche);
                $pag=1;
            }
            if($values['allestimento']!=null){
                $select = $select->where('Allestimento LIKE ?', '%'.$values['allestimento'].'%');
                $pag=1;
            }
            
            if($prezzoMin != null && $prezzoMax != null && $prezzoMin > $prezzoMax){
                $tmp = $prezzoMin;
                $prezzoMin = $prezzoMax;
                $prezzoMax = $tmp;
                unset($tmp);
            }
            if($prezzoMin != null ){$select = $select->where('Prezzo >= ?', $prezzoMin); $pag=1;}   
            if($prezzoMax != null ){ $select = $select->where('Prezzo <= ?', $prezzoMax); $pag=1;}  
            
            if($posti!=null){
                $posti = explode(',', $posti);
                $seats = array();
                foreach($posti as $p){ array_push($seats, trim($p)); }
                $select = $select->where('Posti IN (?)',$seats);
                $pag=1;
            }

            $nolSelect = null;
            if($from<=$to){
                if($from){
                    if(!$nolSelect){ $nolSelect = $this->select('Macchina')->distinct()->from('noleggi')->setIntegrityCheck(false); }
                    $from = date('Y-m-d', strtotime(str_replace('/', '-', $from)));
                    $nolSelect = $nolSelect->where('Inizio >= ?', $from);
                    $pag=1;
                }
                if($to){
                    if(!$nolSelect){ $nolSelect = $this->select('Macchina')->distinct()->from('noleggi')->setIntegrityCheck(false); }
                    $from = date('Y-m-d', strtotime(str_replace('/', '-', $to)));
                    $nolSelect = $nolSelect->where('Fine <= ?', $to);
                    $pag=1;
                }
            }
            else{$select = $select->where('ID = ?', -1);} //nel caso in cui la data di inizio è maggiore della data di fine non facciamo stampare nessun risultato

            if($nolSelect){
                $nols = $this->fetchAll($nolSelect)->toArray();
                $ids = array();
                foreach($nols as $n){ array_push($ids, $n['Macchina']); }
                $select = $select->where('ID NOT IN (?)', implode(", ", $ids));
            }
            
            switch($ordinator){
                case 'DESC_P': $select = $select->order('prezzo DESC');$pag=1; break;
                case 'DESC_S': $select = $select->order('posti DESC');$pag=1; break;
                case 'ASC_S': $select = $select->order('posti ASC');$pag=1; break;
                default: case 'ASC_P': $select = $select->order('prezzo ASC'); break;
            }
            
        }


        if($paged != null && $pag!=1){
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage)
		          	  ->setCurrentPageNumber(intval($paged));
			return $paginator;

		}
        
        return $this->fetchAll($select);       
    }
    
    public function updateCar($car){
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

    public function insertCar($values){ $this->insert($values);  }
    

    public function getCatalogApi($filters){
        $select = $this->select();

        if(isset($filters['modello'])){ $select = $select->where('Modello = ?', strval($filters['modello'])); }
        if(isset($filters['marca'])){ $select = $select->where('Marca = ?', strval($filters['marca'])); }
        if(isset($filters['prezzoMin'])){ $select = $select->where('Prezzo >= ?', $filters['prezzoMin']); }
        if(isset($filters['prezzoMax'])){ $select = $select->where('Prezzo <= ?', $filters['prezzoMax']); }
        if(isset($filters['posti'])){ $select = $select->where('Posti = ?', $filters['prezzoMax']); }

        //TODO Filtro per date

        if(isset($filters['limit']) && intval($filters['limit'])){ $select = $select->limit(intval($filters['limit'])); }
        else{ $select = $select->limit(5); }

        return $this->fetchAll($select);
    }
}



