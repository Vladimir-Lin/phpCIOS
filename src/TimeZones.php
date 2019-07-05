<?php

namespace CIOS ;

class TimeZones
{

public $TZs   ;
public $IDs   ;
public $Uuids ;
public $TzIds ;
public $IdTzs ;
public $TzSds ;
public $SdTzs ;
public $SdUds ;
public $UdSds ;
public $NAMEs ;

function __construct()
{
  $this -> clear ( )  ;
}

function __destruct()
{
  unset ( $this -> TZs   ) ;
  unset ( $this -> IDs   ) ;
  unset ( $this -> Uuids ) ;
  unset ( $this -> TzIds ) ;
  unset ( $this -> IdTzs ) ;
  unset ( $this -> TzSds ) ;
  unset ( $this -> SdTzs ) ;
  unset ( $this -> SdUds ) ;
  unset ( $this -> UdSds ) ;
  unset ( $this -> NAMEs ) ;
}

public function clear()
{
  $this -> TZs   = array ( ) ;
  $this -> IDs   = array ( ) ;
  $this -> Uuids = array ( ) ;
  $this -> TzIds = array ( ) ;
  $this -> IdTzs = array ( ) ;
  $this -> TzSds = array ( ) ;
  $this -> SdTzs = array ( ) ;
  $this -> SdUds = array ( ) ;
  $this -> UdSds = array ( ) ;
}

public function UuidById ( $id )
{
  return $this -> SdUds [ $id ] ;
}

public function ZoneNameById ( $id )
{
  return $this -> TzSds [ $id ] ;
}

public function Query ( $DB , $Table )
{
  $this -> clear ( )                                                         ;
  $QQ = "select `id`,`uuid`,`zonename` from {$Table} order by `id` asc ;"    ;
  $qq = $DB -> Query ( $QQ )                                                 ;
  while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                         {
    $id = $rr [ "id"       ]                                                 ;
    $UU = $rr [ "uuid"     ]                                                 ;
    $ZZ = $rr [ "zonename" ]                                                 ;
    $this -> TzIds [ $UU ] = $ZZ                                             ;
    $this -> IdTzs [ $ZZ ] = $UU                                             ;
    $this -> TzSds [ $id ] = $ZZ                                             ;
    $this -> SdTzs [ $ZZ ] = $id                                             ;
    $this -> SdUds [ $id ] = $UU                                             ;
    $this -> UdSds [ $UU ] = $id                                             ;
    array_push ( $this -> TZs   , $ZZ )                                      ;
    array_push ( $this -> Uuids , $UU )                                      ;
    array_push ( $this -> IDs   , $id )                                      ;
  }                                                                          ;
}

}

?>
