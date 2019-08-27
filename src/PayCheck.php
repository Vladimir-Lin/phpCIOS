<?php

namespace CIOS ;

class PayCheck
{

public $Item       ;
public $Pay        ;
public $Commission ;
public $Hours      ;

function __construct()
{
  $this -> Clear ( ) ;
}

function __destruct()
{
}

function Clear()
{
  $this -> Item       = 1         ;
  $this -> Pay        = array ( ) ;
  $this -> Commission = array ( ) ;
  $this -> Hours      = array ( ) ;
}

public function Obtains($DB,$TABLE)
{
  ///////////////////////////////////////////////////////////////////
  $ITEM = $this -> Item                                             ;
  $QQ   = "select `level`,`pay`,`commission`,`hours` from {$TABLE}" .
          " where `item` = {$ITEM}"                                 .
          " order by `level` asc ;"                                 ;
  $qq   = $DB -> Query ( $QQ )                                      ;
  ///////////////////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                                   {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )              {
      $level                         = $rr [ "level"      ]         ;
      $this -> Pay        [ $level ] = $rr [ "pay"        ]         ;
      $this -> Commission [ $level ] = $rr [ "commission" ]         ;
      $this -> Hours      [ $level ] = $rr [ "hours"      ]         ;
      ///////////////////////////////////////////////////////////////
    }                                                               ;
  }                                                                 ;
  ///////////////////////////////////////////////////////////////////
}

public function Keys()
{
  return array_keys ( $this -> Pay ) ;
}

}

?>
