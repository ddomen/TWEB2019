<?php

class Application_Model_DBContext extends Application_Model_Abstract {
	protected $_topCats, $_subCats, $_prods;
        

	
	
	
	//METODI TABELLA FAQ
	public function getTopFaq($top = 5) { return $this->getResource('Faq')->getTop($top); }

	public function getFaqs(){ return $this->getResource('Faq')->getAllFaqs(); }

	public function getFaqById($id){ return $this->getResource('Faq')->getById($id); }
	
	public function updateFaq($faq){ return $this->getResource('Faq')->updateFaq($faq); }
	
	public function deleteFaq($id){ return $this->getResource('Faq')->delete('ID = ' . intval($id)); }

	public function saveFaq($info){ return $this->getResource('Faq')->insertFaq($info); }
    
        
        
        
	public function getCatalog($values = null, $paged = null, $itemsPerPage = 3){
        return $this->getResource('Macchine')->getCatalog($values, $paged, $itemsPerPage);
	}

	//METODI TABELLA RUOLI

	public function getRoles(){ return $this->getResource('Ruoli')->getAll(); }

	//METODI TABELLA OCCUPAZIONI
	public function getOccupazioni(){ return $this->getResource('Occupazioni')->getAll(); }


	//METODI TABELLA UTENTI
	public function getUserByUsername($username){ return $this->getResource('Utenti')->getByUsername($username); }

	public function getUserById($id){ return $this->getResource('Utenti')->getById($id); }

	public function getAllUsers(){ return $this->getResource('Utenti')->getAll();}

	public function updateUser($user){ return $this->getResource('Utenti')->updateUser($user); }

	public function insertUser($user){ return $this->getResource('Utenti')->insert($user); }
	
	public function deleteUser($id){ return $this->getResource('Utenti')->delete('ID = ' . intval($id)); }

	public function getProspettoMensile($anno = null){ return $this->getResource('Noleggi')->getProspettoMensile($anno); }
	
	public function getAdministrators(){ return $this->getResource('Utenti')->getAdministrators(); }


	//METODI TABELLA MACCHINE
	public function getCarById($id){ return $this->getResource('Macchine')->getById($id); }

	public function deleteCar($id){ return $this->getResource('Macchine')->delete('ID = ' . intval($id)); }

	public function updateCar($car){ return $this->getResource('Macchine')->updateC($car); }
	
	//METODI TABELLA NOLEGGI
	//Metodo per visualizzare le auto noleggiate in un mese specifico
	public function getMonth($m){ return $this->getResource('Noleggi')->getNolByMonth($m); }

	public function checkNoleggio($id, $inizio, $fine){ return $this->getResource('Noleggi')->check($id, $inizio, $fine); }

	public function insertNoleggio($noleggio){ return $this->getResource('Noleggi')->insert($noleggio); }

	public function getProspettoAnno(){ return $this->getResource('Noleggi')->getProspettoAnno(); }

	public function getNoleggiStoricoUtente($userId){ return $this->getResource('Noleggi')->getStoricoUtente($userId); }

	//METODI TABELLA MESSAGGI
	public function insertMessage($message){ return $this->getResource('Messaggi')->insert($message); }

	public function getMessagesByUser($userId){ return $this->getResource('Messaggi')->getByUser($userId); }

	//Usando Application_Model_DBContext::Instance si evita di instanziare molteplici dbcontext
	public static function Instance(){
        static $inst = null;
        if ($inst === null) { $inst = new Application_Model_DBContext(); }
        return $inst;
    }
}
