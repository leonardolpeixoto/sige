<?php

class Application_Model_EventoRealizacao extends Zend_Db_Table_Abstract {

   protected $_name = 'evento_realizacao';
   protected $_primary = 'evento';
   protected $_referenceMap = array(
       array('refTableClass' => 'Application_Model_EventoDemanda',
           'refColumns' => 'evento',
           'columns' => 'evento',
           'onDelete' => self::CASCADE,
           'onUpdate' => self::RESTRICT));

   /**
    *
    * @param array $data com as colunas id_encontro, id_sala, data, hora_inicio e hora_fim
    */
   public function existeHorario($data) {
      $sql = "SELECT er.evento
         FROM evento_realizacao er
         INNER JOIN evento e ON er.id_evento = e.id_evento
         WHERE id_encontro = ?
         AND id_sala = ?
         AND \"data\" = ?
         AND hora_inicio = ?
         AND hora_fim = ?";
      $rs = $this->getAdapter()->fetchAll($sql, $data);
      if (count($rs) > 0) {
         return $rs[0]['evento'];
      }
      return false;
   }

}