<?php
class Application_Form_Staff_Macchine_Modify extends Zend_Form
{
	protected $car;
	protected $marca;
	protected $targa;
	protected $modello;
	protected $prezzo;
	protected $posti;
	protected $foto;
	protected $allestimento;

	public function __construct($car = null) {
        $this->car = $car;
        parent::__construct();
    }

	public function init()
	{
		
		$this->setMethod('post');
		$this->setName('modify');
		$this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        

        $this->marca = $this->createElement('text', 'marca', array('label' => 'Marca: '));
        $this->marca
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
						->setRequired(true);
						
        $this->modello = $this->createElement('text', 'modello', array('label' => 'Modello: '));
        $this->modello
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
                        ->setRequired(true);

        $this->targa = $this->createElement('text', 'targa', array('label' => 'Targa: '));
        $this->targa
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
						->setRequired(true);

        $this->posti = $this->createElement('text', 'posti', array('label' => 'Posti: '));
        $this->posti
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
                        ->addValidator('int', false, array('locale' => 'en_US'))
                        ->setRequired(true);
        
        $this->prezzo = $this->createElement('text', 'prezzo', array('label' => 'Prezzo: '));
		$this->prezzo
						->addFilter('LocalizedToNormalized')
						->addValidator('Float', true, array('locale' => 'en_US'))
						->setRequired(true);

		

		$this->foto = $this->createElement('file', 'foto', array('label' => 'Immagine: ','destination' => APPLICATION_PATH . '/../public/images/vetture'));
		$this->foto
						->addValidator('Count', false, 1)
						->addValidator('Size', false, 102400)
						->addValidator('Extension', true, array('jpg', 'gif', 'png'));


		$this->allestimento = $this->createElement('textarea', 'allestimento', array('label' => 'Allestimento: '));
		$this->allestimento
						->addFilter('StringTrim')
						->addValidator('StringLength',true, array(1,2500))
						->setRequired(true);



			if($this->car != null){

            $this->targa->setValue($this->car->TARGA);
            $this->modello->setValue($this->car->Modello);
			$this->marca->setValue($this->car->Marca);
			$this->prezzo->setValue($this->car->Prezzo);
			$this->posti->setValue($this->car->Posti);
			$this->foto->setValue($this->car->Foto);
			$this->allestimento->setValue($this->car->Allestimento);
            
        }

        $this
                ->addElement($this->targa)
                ->addElement($this->modello)
				->addElement($this->marca)
				->addElement($this->prezzo)
				->addElement($this->posti)
				->addElement($this->foto)
				->addElement($this->allestimento)
                ->addElement('submit', 'Modifica', array('label' => 'Modifica'));
    }
	}