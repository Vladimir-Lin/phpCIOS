<?php

namespace CIOS ;

class Domain extends Columns
{

public $Position    ;
public $Uuid        ;
public $HostId      ;
public $Account     ;
public $Hostname    ;
public $Appellation ;
public $Updated     ;
public $Owners      ;

function __construct()
{
  parent::__construct ( ) ;
  $this -> clear      ( ) ;
}

function __destruct()
{
  parent::__destruct ( ) ;
}

public function clear()
{
  $this -> Position    = -1        ;
  $this -> Uuid        = "0"       ;
  $this -> HostId      = "0"       ;
  $this -> Account     = ""        ;
  $this -> Hostname    = ""        ;
  $this -> Appellation = ""        ;
  $this -> Updated     = false     ;
  $this -> Owners      = array ( ) ;
}

}

?>
