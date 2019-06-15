<?php

class Application_Resource_Noleggi extends Zend_Db_Table_Abstract {
    protected $_name    = 'noleggi';
    protected $_primary  = 'ID';
    protected $_rowClass = 'Application_Resource_Noleggi_Item';

    public function init() { }

    public function getProspettoMensile($anno = null){
        if($anno == null){ $anno = date('Y'); }
        $select = $this->select()
                        ->from('noleggi', array())
                        ->columns(array('Conteggio' => 'COUNT(*)', 'Mese' => 'MONTH(Inizio)'))
                        ->where('YEAR(Inizio) = ?', intval($anno))
                        ->group(array('YEAR(Inizio)', 'MONTH(Inizio)'));
        return $this->fetchAll($select);
    }

    public function getProspettoAnno(){
        $select = $this->select()
                        ->from('noleggi', array())
                        ->columns(array('Conteggio' => 'COUNT(*)', 'Anno' => 'YEAR(Inizio)'))
                        ->group(array('YEAR(Inizio)'));
        return $this->fetchAll($select);
    }


    public function getAllNol(){


        $select = $this->select();
        return $this->fetchAll($select);
    }


    public function getNolByMonth($m){

        $months=array();
        $months["gennaio"]="01";
        $months["febbraio"]="02";
        $months["marzo"]="03";
        $months["aprile"]="04";
        $months["maggio"]="05";
        $months["giugno"]="06";
        $months["luglio"]="07";
        $months["agosto"]="08";
        $months["settembre"]="09";
        $months["ottobre"]="10";
        $months["novembre"]="11";
        $months["dicembre"]="12";

        $select = $this->select()
                    ->from (array('n'=>'noleggi', 'm' => 'macchine', 'u' => 'utenti'))
                    ->where("Inizio >= ? ", '2019-'.$months[strtolower($m)].'-01 00:00:00')
                    ->where("Inizio <= ? ", '2019-'.$months[strtolower($m)].'-30 ')
                    ->join(array('m' => 'macchine') , 'n.Macchina = m.ID')
                    ->join(array('u' => 'utenti') , 'n.Noleggiatore = u.ID')
                    ->setIntegrityCheck(false);

                    return $this->fetchAll($select);
        
    }

    public function check($id, $inizio, $fine){
        $select = $this->select()
                        ->where('Macchina = ?', $id)
                        ->where('Inizio >= ?', $inizio)
                        ->where('Fine <= ?', $fine);
        $result = $this->fetchAll($select);
        return count($result) == 0;
    }


    public function getNolById($id)
    {
        $select=$this->select()
                    ->where('ID IN(?)', $id); 
        
        return $this->fetchAll($select);

    }


    public function insertNoleggio($array)
    {
    	$this->insert($array);
    }

    public function deleteNoleggio($id)
    {
    	$this->delete($id);
    }


    public function getStoricoUtente($userId){
        return $this->fetchAll($this->select()
            ->from (array('n'=>'noleggi', 'm' => 'macchine', 'u' => 'utenti'))
            ->where("n.Noleggiatore = ? ", $userId)
            ->order('n.Inizio DESC')
            ->limit(50)
            ->join(array('m' => 'macchine') , 'n.Macchina = m.ID')
            ->join(array('u' => 'utenti') , 'n.Noleggiatore = u.ID')
            ->setIntegrityCheck(false)
        );
    }
}
