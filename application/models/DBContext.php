<?php

class Application_Model_DBContext extends App_Model_Abstract {
	protected $_topCats, $_subCats, $_prods;

	public function getTopFaq($top = 5) {
		return $this->getResource('Faq')->getTop($top);
	}

	public function getCatalog(){
		return $this->getResource('Macchine')->getCatalog();
	}

	public function getRoles(){ return $this->getResource('Ruoli')->getAll(); }

	public function getOccupazioni(){ return $this->getResource('Occupazioni')->getAll(); }


	//METODI TABELLA UTENTI
	public function getUserByUsername($username){ return $this->getResource('Utenti')->getByUsername($username); }

	public function updateUser($user){ return $this->getResource('Utenti')->updateUser($user); }

	public function insertUser($user){ return $this->getResource('Utenti')->insert($user); }

	//Usando Application_Model_DBContext::Instance si evita di instanziare molteplici dbcontext
	public static function Instance(){
        static $inst = null;
        if ($inst === null) { $inst = new Application_Model_DBContext(); }
        return $inst;
    }
}
