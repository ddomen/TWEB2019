<?php
class Application_Form_Staff_Macchine_Modify extends Application_Form_Abstract
{
	protected $car;
	protected $marca;
	protected $modello;
        protected $targa;
	protected $prezzo;
	protected $posti;
	protected $foto;
	protected $allestimento;
	protected $button;

	public function __construct($car = null) {
        $this->car = $car;
        parent::__construct();
    }

	public function init()
	{
		
		$this->setMethod('post');
		$this->setName('modifymacchina');
		$this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        

        $this->marca = $this->createElement('text', 'marca', array('label' => 'Marca: ', 'autofocus' => true, 'decorators' => $this->elementDecorators));
        $this->marca
                        ->addFilter('StringTrim')
						->addValidator('stringLength', false, array(1, 10))
						->setAttrib('class', 'form-control validation required')
						->setRequired(true);
						
        $this->modello = $this->createElement('text', 'modello', array('label' => 'Modello: ', 'decorators' => $this->elementDecorators));
        $this->modello
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
						->setAttrib('class', 'form-control validation required')
                        ->setRequired(true);

        $this->targa = $this->createElement('text', 'targa', array('label' => 'Targa: ', 'decorators' => $this->elementDecorators));
        $this->targa
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
						->setAttrib('class', 'form-control validation required')
						->setRequired(true);

        $this->posti = $this->createElement('text', 'posti', array('label' => 'Posti: ', 'decorators' => $this->elementDecorators));
        $this->posti
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
                        ->addValidator('int', false, array('locale' => 'en_US'))
						->setAttrib('class', 'form-control validation required integer')
                        ->setRequired(true);
        
        $this->prezzo = $this->createElement('text', 'prezzo', array('label' => 'Prezzo: ', 'decorators' => $this->elementDecorators));
		$this->prezzo
						->addFilter('LocalizedToNormalized')
						->addValidator('Float', true, array('locale' => 'en_US'))
						->setAttrib('class', 'form-control validation required number')
						->setRequired(true);

		

		$this->foto = $this->createElement('file', 'foto', array('label' => 'Immagine: ', 'decorators' => $this->fileDecorators, 'destination' => APPLICATION_PATH . '/../public/images/vetture'));
		$this->foto
						->addValidator('Count', false, 1)
						->addValidator('Size', false, 102400)
						->setAttrib('class', 'form-control-file validation required')
						->addValidator('Extension', true, array('jpg', 'gif', 'png'));


		$this->allestimento = $this->createElement('textarea', 'allestimento', array('label' => 'Allestimento: ', 'class' => 'form-control', 'rows' => '8', 'decorators' => $this->elementDecorators));
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

        $this   ->addElement($this->marca)
                ->addElement($this->modello)		
                ->addElement($this->targa)
				->addElement($this->prezzo)
				->addElement($this->posti)
				->addElement($this->foto)
				->addElement($this->allestimento)
                ->addElement('submit', 'Modifica', array('label' => 'Modifica', 'class' => 'btn btn-success', 'decorators' => $this->buttonDecorators));
        
        $this->setDecorators(array(

			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));
    }
	}
