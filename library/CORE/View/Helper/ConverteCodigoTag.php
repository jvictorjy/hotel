<?php

class CORE_View_Helper_ConverteCodigoTag
{
  public function converteCodigoTag( $texto, $escape = true )
  {
  	$model = new Model_ForumTopico;

  	return $model->converteCodigo( $texto, $escape );
  }
}