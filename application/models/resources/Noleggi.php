<?php

class Application_Resource_Noleggi extends Zend_Db_Table_Abstract {
    protected $_name    = 'noleggi';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Noleggi_Item';

    public function init() { }

    public function getAll(){
        $select = $this->select();
        return $this->fetchAll($select); //fetchAll ritorna un RowSet
    }

    public function checkDate($array){ //L'array deve contenere la data di inizio e fine affinché il sistema riesca a fare un controllo sulla
        //disponibilità, e l'ID della macchina che si vuole cercare
       
        $disp == true;
        $select=$this->select()
            ->where('macchina', $array.['macchina']);

            foreach($select as $sel){
                if ($sel.current().get($inizio)>$array.['inizio'] && $array.['fine'] < $sel.current().get($fine)){

                }
                else if ($sel.current().get($inizio)<$array.['inizio'] && $sel.current().get($fine) < $array.['fine']){
                    $disp == false;
                }

            }
        //INSERIRE IL RETURN
    }


    public function getNolById($id)
    {
        return $this->find($id)->current();
    }


    public function insertNoleggio($array)
    {
    	$this->insert($array);
    }

    public function deleteNoleggio($where)
    {
    	$this->delete($where);
    }

    } 
