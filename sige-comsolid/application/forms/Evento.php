<?php

class Application_Form_Evento extends Zend_Form {
   
   private $modoEdicao = false;
   
   /**
    * @deprecated
    * @param type $options 
    */
   public function __construct($options = null) {
      parent::__construct($options);
      if (!is_null($options)) {
         if (isset($options['modo_edicao'])) {
            $this->modoEdicao = $options['modo_edicao'];
         }
      }
   }

   public function init() {
      
      $this->setName('Evento');

      $this->addElements(array(
          $this->_nome_evento(),
          $this->_id_tipo_evento(),
          $this->_id_dificuldade_evento(),
          $this->_perfil_minimo(),
          //$this->_curriculum(), // usar bio da pessoa
          $this->_resumo(),
          $this->_id_encontro(),
          $this->_preferencia_horario(),
      ));
      
      $botao = $this->createElement('submit', 'confimar')->removeDecorator('DtDdWrapper');
      $this->addElement($botao);
      $botao = $this->createElement('submit', 'cancelar')->removeDecorator('DtDdWrapper');
      $botao->setAttrib('class', 'submitCancelar');
      $this->addElement($botao);
	}
   
   protected function _nome_evento() {
      $e = new Zend_Form_Element_Text('nome_evento');
      $e->setLabel('Título:')
              ->setRequired(true)
              ->addValidator('StringLength', false, array(1, 100))
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->setAttrib('class', 'large');

      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
   
   protected function _id_tipo_evento() {
      $e = new Zend_Form_Element_Select('id_tipo_evento');
      $e->setRequired(true)
              ->setLabel('Tipo Atividade:');
      $model = new Application_Model_TipoEvento();
      $rs = $model->fetchAll();
      foreach ($rs as $item) {
         $e->addMultiOption($item->id_tipo_evento, $item->nome_tipo_evento);
      }
      
      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
   
   protected function _id_dificuldade_evento() {
      $e = new Zend_Form_Element_Select('id_dificuldade_evento');
      $e->setRequired(true)
              ->setLabel('Nível:');
      $model = new Application_Model_DificuldadeEvento();
      $rs = $model->fetchAll();
      foreach ($rs as $item) {
         $e->addMultiOption($item->id_dificuldade_evento, $item->descricao_dificuldade_evento);
      }
      
      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
   
   protected function _perfil_minimo() {
      $e = new Zend_Form_Element_Textarea('perfil_minimo');
      $e->setLabel('Perfil Mínimo:')
              ->setRequired(true)
              ->setAttrib('rows', 6)
              ->addFilter('StripTags')
              ->addFilter('StringTrim');

      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
   
   protected function _curriculum() {
      $e = new Zend_Form_Element_Textarea('curriculum');
      $e->setLabel('Curriculum:')
              ->setRequired(true)
              ->setAttrib('rows', 10)
              ->addFilter('StripTags')
              ->addFilter('StringTrim');

      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
   
   protected function _id_encontro() {
      $e = new Zend_Form_Element_Hidden('id_encontro');
      return $e;
   }
   
   protected function _resumo() {
      $e = new Zend_Form_Element_Textarea('resumo');
      $e->setLabel('Resumo:')
              ->setRequired(true)
              ->setAttrib('rows', 10)
              ->addFilter('StringTrim')
              ->setAttrib('class', 'ckeditor')
              ->addValidator('stringLength', false, array(10))
              ->addFilter(new Sige_Filter_HTMLPurifier)
          	  ->addErrorMessage("Resumo com numero insuficiente de caracteres (min. 10).");

      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
   
   protected function _preferencia_horario() {
      $e = new Zend_Form_Element_Textarea('preferencia_horario');
      $e->setLabel('Preferência de horário:')
              ->setAttrib('rows', 5)
              ->setAttrib('placeholder', 'Data e horário mais conveniente...')
              ->addFilter('StripTags')
              ->addFilter('StringTrim');

      $e->setDecorators(array(
          'ViewHelper',
          'Description',
          'Errors',
          array('HtmlTag', ''),
          array('Label', ''),
      ));
      return $e;
   }
}
