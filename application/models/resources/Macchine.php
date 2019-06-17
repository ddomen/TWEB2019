<?php

class Application_Resource_Macchine extends Zend_Db_Table_Abstract {
    protected $_name    = 'macchine';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Macchine_Item';
    
    public function init() { }
    
    public function getCatalog($values = null, $paged = null, $itemsPerPage = 3){
        $select = $this->select();

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
            }
            if($marca!=null){
                $marca = explode(',', $marca);
                $marche = array();
                foreach($marca as $m){ array_push($marche, trim($m)); }
                $select = $select->where('Marca IN (?)', $marche);
            }
            if($values['allestimento']!=null){
                $select = $select->where('Allestimento LIKE ?', '%'.$values['allestimento'].'%');
            }
            
            if($prezzoMin != null && $prezzoMax != null && $prezzoMin > $prezzoMax){
                $tmp = $prezzoMin;
                $prezzoMin = $prezzoMax;
                $prezzoMax = $tmp;
                unset($tmp);
            }
            if($prezzoMin != null ){$select = $select->where('Prezzo >= ?', $prezzoMin);}   
            if($prezzoMax != null ){ $select = $select->where('Prezzo <= ?', $prezzoMax);}  
            
            if($posti!=null){
                $posti = explode(',', $posti);
                $seats = array();
                foreach($posti as $p){ array_push($seats, trim($p)); }
                $select = $select->where('Posti IN (?)',$seats);
            }

            $nolSelect = null;
            if($from != null && $to != null && $from > $to){
                $tmp = $from;
                $from = $to;
                $to = $tmp;
                unset($tmp);
            }
            if($from){
                if(!$nolSelect){ $nolSelect = $this->select('Macchina')->distinct()->from('noleggi')->setIntegrityCheck(false); }
                $from = date('Y-m-d', strtotime(str_replace('/', '-', $from)));
                $nolSelect = $nolSelect->where('Inizio >= ?', $from);
            }
            if($to){
                if(!$nolSelect){ $nolSelect = $this->select('Macchina')->distinct()->from('noleggi')->setIntegrityCheck(false); }
                $from = date('Y-m-d', strtotime(str_replace('/', '-', $to)));
                $nolSelect = $nolSelect->where('Fine <= ?', $to);
            }

            if($nolSelect){
                $nols = $this->fetchAll($nolSelect)->toArray();
                $ids = array();
                foreach($nols as $n){ array_push($ids, $n['Macchina']); }
                $select = $select->where('ID NOT IN (?)', implode(", ", $ids));
            }
            
            switch($ordinator){
                case 'DESC_P': $select = $select->order('prezzo DESC'); break;
                case 'DESC_S': $select = $select->order('posti DESC'); break;
                case 'ASC_S': $select = $select->order('posti ASC'); break;
                default: case 'ASC_P': $select = $select->order('prezzo ASC'); break;
            }
            
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
        $count = $this->select()->from($this, 'COUNT(*) as Totale');

        if(isset($filters['modello'])){
            $select = $select->where('Modello = ?', strval($filters['modello']));
            $count = $count->where('Modello = ?', strval($filters['modello']));
        }
        if(isset($filters['marca'])){
            $select = $select->where('Marca = ?', strval($filters['marca']));
            $count = $count->where('Marca = ?', strval($filters['marca']));
        }
        if(isset($filters['prezzoMin'])){
            $select = $select->where('Prezzo >= ?', $filters['prezzoMin']);
            $count = $count->where('Prezzo >= ?', $filters['prezzoMin']);
        }
        if(isset($filters['prezzoMax'])){
            $select = $select->where('Prezzo <= ?', $filters['prezzoMax']);
            $count = $count->where('Prezzo <= ?', $filters['prezzoMax']);
        }
        if(isset($filters['posti'])){
            $select = $select->where('Posti = ?', $filters['prezzoMax']);
            $count = $count->where('Posti = ?', $filters['prezzoMax']);
        }
        if(isset($filters['allestimento'])){
            $select = $select->where('Allestimento LIKE ?', '%' . $filters['allestimento'] . '%');
            $count = $select->where('Allestimento LIKE ?', '%' . $filters['allestimento'] . '%');
        }
        
        if(isset($filters['order'])){
            switch($filters['order']){
                case 'DESC_P':
                    $select = $select->order('prezzo DESC');
                    $count = $count->order('prezzo DESC'); break;
                case 'DESC_S':
                    $select = $select->order('posti DESC');
                    $count = $count->order('posti DESC'); break;
                case 'ASC_S':
                    $select = $select->order('posti ASC');
                    $count = $count->order('posti ASC'); break;
                default: case 'ASC_P':
                    $select = $select->order('prezzo ASC');
                    $count = $count->order('prezzo ASC'); break;
            }
        }

        $nolSelect = null;
        if(isset($filters['from']) && isset($filters['to']) && $filters['from'] > $filters['to']){
            $tmp = $filters['from'];
            $filters['from'] = $filters['to'];
            $filters['to'] = $tmp;
            unset($tmp);
        }
        if(isset($filters['from'])){
            if(!$nolSelect){ $nolSelect = $this->select('Macchina')->distinct()->from('noleggi')->setIntegrityCheck(false); }
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $filters['from'])));
            $nolSelect = $nolSelect->where('Inizio >= ?', $from);
        }

        if(isset($filters['to'])){
            if(!$nolSelect){ $nolSelect = $this->select('Macchina')->distinct()->from('noleggi')->setIntegrityCheck(false); }
            $to = date('Y-m-d', strtotime(str_replace('/', '-', $filters['to'])));
            $nolSelect = $nolSelect->where('Fine <= ?', $to);
        }
        
        if($nolSelect){
            $nols = $this->fetchAll($nolSelect)->toArray();
            $ids = array();
            foreach($nols as $n){ array_push($ids, $n['Macchina']); }
            $select = $select->where('ID NOT IN (?)', implode(", ", $ids));
            $count = $count->where('ID NOT IN (?)', implode(", ", $ids));
        }


        $page = isset($filters['page']) ? intval($filters['page']) : 1;
        $page = $page > 0 ? $page : 1;
        $limit = isset($filters['items']) ? intval($filters['items']) : 5;
        $limit = $limit > 0 ? $limit : 5;
        $select = $select->limit($limit, ($page - 1) * $limit);

        $cResult = $this->fetchAll($count);
        $total = $cResult[0]->Totale;

        return array(
            'totale' => $total,
            'data' => $this->fetchAll($select)->toArray()
        );
    }
}



