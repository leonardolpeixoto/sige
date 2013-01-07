<?php

class Application_Form_Evento extends Zend_Form {
	public function init() {
		
   	$nome_evento = $this->createElement('text', 'nome_evento',array('label' => 'Titulo: '));
   	$nome_evento->addValidator('stringLength', false, array(1,100))
					// FIXME: pra que isso? ->addValidator('regex', false, array('/^[0-9a-zA-Záéíóúàìòùãẽĩõũâêîôûäëïöüç]*$/'))
   				->setAllowEmpty(false)
          		->setRequired(true);
          		//->addErrorMessage("Campo contém caracteres invalidos e/ou é muito pequeno.");

		$perfil_minimo = $this->createElement('textarea', 'perfil_minimo',array('label' => 'Perfil Minimo: '));
   	$perfil_minimo->setAttrib('cols', '40')
    			  ->setAttrib('rows', '4')
   				  ->setAllowEmpty(false)
          		  ->setRequired(true)
          		  ->addValidator('stringLength', false, array(10))
          		  ->addErrorMessage("Perfil com numero insuficiente de caracteres.");
          		  
		$curriculum = $this->createElement('textarea', 'curriculum',array('label' => 'Curriculum: '));
   	$curriculum->setAttrib('cols', '40')
    		->setAttrib('rows', '4')
   			->setAllowEmpty(false)
          	->setRequired(true)
  			->addValidator('stringLength', false, array(10))
          	->addErrorMessage("Curriculum com numero insuficiente de caracteres.");
          		  
		$resumo = $this->createElement('textarea', 'resumo',array('label' => 'Resumo: '));
   	$resumo->setAttrib('cols', '40')
    		->setAttrib('rows', '4')
   			->setAllowEmpty(false)
          	->setRequired(true)
          	->addValidator('stringLength', false, array(10))
          	->addErrorMessage("Resumo com numero insuficiente de caracteres.");
          	
          	
		$tipo_evento = new Application_Model_TipoEvento();
   	$tipo_evento = $tipo_evento->fetchAll();
   	$nome_tipo_evento = $this->createElement('select', 'id_tipo_evento',array('label' => 'Tipo Atividade: '));
   	
   	foreach($tipo_evento as $item) {
   		$nome_tipo_evento->addMultiOptions(array($item->id_tipo_evento => $item->nome_tipo_evento));	
   	}
   	
   	$dificuldade_evento = new Application_Model_DificuldadeEvento();
   	$listaDificuldade  = $dificuldade_evento->fetchAll();
   	$descricao_dificuldade_evento = $this->createElement('select', 'id_dificuldade_evento',array('label' => 'Nivel: '));
   	foreach($listaDificuldade as $item) {
   		$descricao_dificuldade_evento->addMultiOptions(array($item->id_dificuldade_evento => $item->descricao_dificuldade_evento));	
   	}
   
		$encontro = $this->createElement('hidden', 'id_encontro');
    
		$this->addElement($nome_evento)
			->addElement($nome_tipo_evento)
			->addElement($descricao_dificuldade_evento)
			->addElement($perfil_minimo)
			->addElement($curriculum)
    	   ->addElement($encontro)
			->addElement($resumo);
    	$botao = $this->createElement('submit', 'confimar')->removeDecorator('DtDdWrapper');
		$this->addElement($botao);
		$botao = $this->createElement('submit', 'cancelar')->removeDecorator('DtDdWrapper');
		$botao->setAttrib('class','submitCancelar');
		$this->addElement($botao);
	}
}
