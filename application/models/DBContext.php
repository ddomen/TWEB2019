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


	public function getNoleggi(){
		return $this->getResource('Noleggi')->getAll();
	}

	public function getTransazioni(){
		return $this->getResource('Transazioni')->getAll();
	}

	//Usando Application_Model_DBContext::Instance si evita di instanziare molteplici dbcontext
	public static function Instance(){
        static $inst = null;
        if ($inst === null) { $inst = new Application_Model_DBContext(); }
        return $inst;
    }
}
