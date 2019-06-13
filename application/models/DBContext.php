<?php

class Application_Model_DBContext extends App_Model_Abstract {
	protected $_topCats, $_subCats, $_prods;
        

	public function getTopFaq($top = 5) {
		return $this->getResource('Faq')->getTop($top);
	}

	public function getFaqs(){
		return $this->getResource('Faq')->getAllFaqs();
	}
        
	public function getCatalog($values = null, $ordinator = null, $paged = null, $itemsPerPage = 3){
        return $this->getResource('Macchine')->getCatalog($values, $ordinator, $paged, $itemsPerPage);
	}
        
	public function getRoles(){ return $this->getResource('Ruoli')->getAll(); }

	public function getOccupazioni(){ return $this->getResource('Occupazioni')->getAll(); }


	//METODI TABELLA UTENTI
	public function getUserByUsername($username){ return $this->getResource('Utenti')->getByUsername($username); }

	public function getUserById($id){ return $this->getResource('Utenti')->getById($id); }

	public function getAllUsers(){ return $this->getResource('Utenti')->getAll();}

	public function updateUser($user){ return $this->getResource('Utenti')->updateUser($user); }

	public function insertUser($user){ return $this->getResource('Utenti')->insert($user); }
	
	public function deleteUser($id){ return $this->getResource('Utenti')->delete('ID = ' . intval($id)); }

	public function getProspettoMensile($anno = null){ return $this->getResource('Noleggi')->getProspettoMensile($anno); }
	
	public function getProspettoAnno(){ return $this->getResource('Noleggi')->getProspettoAnno(); }

	//Usando Application_Model_DBContext::Instance si evita di instanziare molteplici dbcontext
	public static function Instance(){
        static $inst = null;
        if ($inst === null) { $inst = new Application_Model_DBContext(); }
        return $inst;
    }
}
