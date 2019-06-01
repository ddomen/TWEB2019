<?php

class Application_Model_DBContext extends App_Model_Abstract {
	protected $_topCats, $_subCats, $_prods;

	public function getTopFaq($top = 5) {
		return $this->getResource('Faq')->getTop($top);
	}

	public function getCatalog(){
		return $this->getResource('Macchine')->getCatalog();
	}

	public function getbyMarca($marca) {
		//FiltroMarca
	}

	public function getbyModello($modello) {
		//FiltroModello
	}

	public function getbyTarga($targa) {
		//FiltroTarga
	}

	public function getbyPrezzo($prezzo) {
		//FiltroPrezzo
	}

	public function getbyPosti($posti) {
		//FiltroTarga
	}

	//Allestimento?

}
