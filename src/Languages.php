<?php

namespace CIOS ;

class Languages
{

public $Codes ;
public $Uuids ;
public $Names ;

function __construct()
{
  $this -> Clear ( ) ;
}

function __destruct()
{
}

public function Clear()
{
  $this -> Codes = array ( ) ;
  $this -> Uuids = array ( ) ;
  $this -> Names = array ( ) ;
}

public function Obtains($DB,$LOCALITY)
{
  $QQ = "select `uuid`,`code` from {$LOCALITY} order by `code` asc ;"        ;
  $qq = $DB -> Query ( $QQ )                                                 ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                       {
      array_push ( $this -> Codes , $rr [ "code" ] )                         ;
      array_push ( $this -> Uuids , $rr [ "uuid" ] )                         ;
    }                                                                        ;
  }                                                                          ;
}

public function DynamicList($FIRST,$Localities)
{
  $LX = array (                   ) ;
  array_push  ( $LX , $FIRST      ) ;
  foreach     ( $Localities as $L ) {
    if ( ! in_array ( $L , $LX ) )  {
      array_push ( $LX , $L )       ;
    }                               ;
  }                                 ;
  return $LX                        ;
}

public function GetName($DB,$TABLE,$Locality,$Usage = "Default")
{
  $this -> Names = array ( )       ;
  foreach ( $this -> Uuids as $u ) {
    $NN = $DB -> GetName           (
                   $TABLE          ,
                   $u              ,
                   $Locality       ,
                   $Usage        ) ;
    $this -> Names [ $u ] = $NN    ;
  }                                ;
}

public function GetNames($DB,$TABLE,$Localities,$Usage = "Default")
{
  $this -> Names = array ( )         ;
  $pos           = 0                 ;
  foreach ( $this -> Uuids as $u )   {
    $NN = $DB -> GetNameByLocalities (
                   $TABLE            ,
                   $u                ,
                   $Localities       ,
                   $Usage          ) ;
    $this -> Names [ $u ] = $NN      ;
    $pos           = $pos + 1        ;
  }                                  ;
}

public function GetNative($DB,$TABLE,$Localities,$Usage = "Default")
{
  $this -> Names = array ( )                         ;
  $pos           = 0                                 ;
  foreach ( $this -> Uuids as $u )                   {
    $CI = $this -> Codes [ $pos ]                    ;
    $AA = $this -> DynamicList ( $CI , $Localities ) ;
    $NN = $DB   -> GetNameByLocalities               (
                     $TABLE                          ,
                     $u                              ,
                     $AA                             ,
                     $Usage                        ) ;
    $this -> Names [ $u ] = $NN                      ;
    $pos           = $pos + 1                        ;
    unset ( $AA )                                    ;
  }                                                  ;
}

public function EchoSelections($CURRENT)
{
  $HS  = new HtmlTag (          )            ;
  $HS -> setTag      ( "select" )            ;
  $HS -> setSplitter ( "\n"     )            ;
  ////////////////////////////////////////////
  $pos = 0                                   ;
  foreach ( $this -> Codes as $c )           {
    $U   = $this -> Uuids [ $pos ]           ;
    $HO  = $HS -> addOption ( )              ;
    $HO -> AddPair ( "value" , $c          ) ;
    if ( $CURRENT == $c )                    {
      $HO -> AddMember ( "selected" )        ;
    }                                        ;
    $HO -> AddText ( $this -> Names [ $U ] ) ;
    $pos = $pos + 1                          ;
  }                                          ;
  ////////////////////////////////////////////
  return $HS                                 ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
