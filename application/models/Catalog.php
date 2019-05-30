<?php

class Application_Model_Catalog extends App_Model_Abstract {


	    protected $_topCats, $_subCats, $_prods;

	    public function __construct()
	    {

					$this->_logger = Zend_Registry::get('log');
					//Inserire la visualizzazione di tutte le macchine

	    }

	    public function getbyMarca($marca)
	    {
				//FiltroMarca
	    }

	    public function getbyModello($modello)
	    {
				//FiltroModello
	    }

	    public function getbyTarga($targa)
	    {
				//FiltroTarga
			}

			public function getbyPrezzo($prezzo)
			{
				//FiltroPrezzo
			}

			public function getbyPosti($posti)
			{
				//FiltroTarga
			}

			//Allestimento?

}
