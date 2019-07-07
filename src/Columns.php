<?php

namespace CIOS ;

class Columns
{

public $Columns ;

function __construct()
{
  $this -> clear ( )  ;
}

function __destruct()
{
  unset ( $this -> Columns ) ;
}

public function clear()
{
  $this -> Columns   = array ( ) ;
}

public function ClearColumns()
{
  unset ( $this -> Columns )   ;
  $this -> Columns = array ( ) ;
}

public function AddColumn ( $C )
{
  array_push ( $this -> Columns , $C ) ;
}

}

?>
