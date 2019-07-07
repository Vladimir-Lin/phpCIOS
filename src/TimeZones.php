<?php

namespace CIOS ;

$CiosTimeZoneKey = "CIOS-TimeZone" ;
$CiosTzUuidKey   = "CIOS-TZ-Uuid"  ;

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

public function ZoneNames ( $DB , $Table , $LANGs )
{
  $this -> NAMEs = array        (                                ) ;
  $NI            = new Name     (                                ) ;
  $NI           -> set          ( "Priority"  , 0                ) ;
  $NI           -> setRelevance ( "Default"                      ) ;
  foreach                       ( $LANGs as $kk                  ) {
    $NI   -> set                ( "Locality"  , $kk              ) ;
    $NAMES = $NI -> FetchUuids  ( $DB  , $Table , $this -> Uuids ) ;
    $this -> NAMEs [ $kk ] = $NAMES                                ;
  }                                                                ;
}

public function GetTimeZone ( $DB , $Table , $U , $Default , $Type = "People" )
{
  $CT  = 0                                     ;
  $RI  = new Relation         (              ) ;
  $RI -> set                  ( "first" , $U ) ;
  $RI -> setT1                ( $Type        ) ;
  $RI -> setT2                ( "TimeZone"   ) ;
  $RI -> setRelation          ( "Originate"  ) ;
  $UU  = $RI -> Subordination ( $DB , $Table ) ;
  unset                       ( $RI          ) ;
  if ( count ( $UU ) > 0 )                     {
    $UX = $UU [ 0 ]                            ;
    $CT = "{$UX}"                              ;
  } else                                       {
    $CT = "{$Default}"                         ;
  }                                            ;
  return $CT                                   ;
}

public function addSelector($NameMaps,$CurrentTimeZone,$TzMenu,$TzClass="")
{
  $CT  = $CurrentTimeZone                     ;
  $HS  = new Html    (                      ) ;
  $HS -> setSplitter ( "\n"                 ) ;
  $HS -> setTag      ( "select"             ) ;
  $HS -> SafePair    ( "id"      , $TzMenu  ) ;
  $HS -> SafePair    ( "class"   , $TzClass ) ;
  $HS -> SafePair    ( "name"    , $TzMenu  ) ;
  $HS -> addOptions  ( $NameMaps , $CT      ) ;
  return $HS                                  ;
}

public function addSelection($CurrentTimeZone,$TzMenu,$TzClass="",$LANG=0)
{
  $LANGs   = $this -> TzIds                      ;
  if                          ( $LANG > 0      ) {
    $LANGs = $this -> NAMEs [ $LANG ]            ;
  }                                              ;
  return $this -> addSelector ( $LANGs           ,
                                $CurrentTimeZone ,
                                $TzMenu          ,
                                $TzClass       ) ;
}

public static function SetTZ ( $TZ )
{
  global $CiosTimeZoneKey              ;
  $_SESSION [ $CiosTimeZoneKey ] = $TZ ;
  return $TZ                           ;
}

public static function GetTZ ( )
{
  global $CiosTimeZoneKey                           ;
  ///////////////////////////////////////////////////
  if   ( isset ( $_SESSION [ $CiosTimeZoneKey ] ) ) {
    $TZ = $_SESSION [ $CiosTimeZoneKey ]            ;
    if ( strlen ( $TZ ) > 0                       ) {
      return $TZ                                    ;
    }                                               ;
  }                                                 ;
  ///////////////////////////////////////////////////
  return date_default_timezone_get ( )              ;
}

public static function SetTzUuid ( $TZ )
{
  global $CiosTzUuidKey              ;
  $_SESSION [ $CiosTzUuidKey ] = $TZ ;
  return $TZ                         ;
}

public static function GetTzUuid ( )
{
  global $CiosTzUuidKey                           ;
  if   ( isset ( $_SESSION [ $CiosTzUuidKey ] ) ) {
    $TZ = $_SESSION [ $CiosTzUuidKey ]            ;
    if ( strlen ( $TZ ) > 0                     ) {
      return $TZ                                  ;
    }                                             ;
  }                                               ;
  return ""                                       ;
}

}

?>
