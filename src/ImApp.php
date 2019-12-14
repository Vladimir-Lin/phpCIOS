<?php

namespace CIOS ;

class ImApp
{

public $Uuid    = "0" ;
public $Type    =  1  ;
public $Account       ;

function __construct()
{
  $this -> clear ( ) ;
}

function __destruct()
{
}

public function clear ()
{
  $this -> Uuid    = "0" ;
  $this -> Type    = 1   ;
  $this -> Account = ""  ;
}

public function isLoaded()
{
  return ( gmp_cmp ( $this -> Uuid , "0" ) > 0 ) ;
}

public function isValid()
{
  /////////////////////////////////////////////////////
  if ( false === strpos ( $this -> Account , " " ) ) {
    // no space in the email account name
  } else return false                                 ;
  /////////////////////////////////////////////////////
  if ( false === strpos ( $this -> Account , "\\" ) ) {
  } else return false                                 ;
  /////////////////////////////////////////////////////
  if ( false === strpos ( $this -> Account , "'"  ) ) {
  } else return false                                 ;
  /////////////////////////////////////////////////////
  if ( false === strpos ( $this -> Account , "`"  ) ) {
  } else return false                                 ;
  /////////////////////////////////////////////////////
  if ( false === strpos ( $this -> Account , "\"" ) ) {
  } else return false                                 ;
  /////////////////////////////////////////////////////
  return ( strlen ( $this -> Account ) > 0 )          ;
}

public function setApp ( $app )
{
  $this -> Type = $app ;
}

public function setAccount($account)
{
  $this -> Account = trim ( $account ) ;
}

public function Update($DB,$Table)
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false ;
  $QQ = "update " . $Table                                 .
        " set `account` = '" . $this -> Account . "' ,"    .
        " `imapp` = " . $this -> Type                      .
        $DB -> WhereUuid ( $this -> Uuid , true          ) ;
  return $DB -> Query ( $QQ )                              ;
}

public function ObtainsByUuid($DB,$Table)
{
  $Q = "select `account`,`imapp` from {$Table}"  .
       $DB -> WhereUuid ( $this -> Uuid , true ) ;
  $q = $DB -> Query ( $Q )                       ;
  if ( ! $DB -> hasResult ( $q ) ) return false  ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )         ;
  if ( ! $N ) return false                       ;
  $this -> Type    = $N [ "imapp"   ]            ;
  $this -> Account = $N [ "account" ]            ;
  return true                                    ;
}

public function ObtainsByAccount ( $DB , $Table )
{
  $this -> Uuid = "0"                           ;
  $T  = $this -> Type                           ;
  $A  = $this -> Account                        ;
  $Q  = "select `uuid` from {$Table}"           .
        " where `account` = '{$A}'"             .
        " and `imapp` = {$T}"                   .
        " and `used` = 1 ;"                     ;
  $q  = $DB -> Query ( $Q )                     ;
  if ( ! $DB -> hasResult ( $q ) ) return false ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )        ;
  if ( ! $N ) return false                      ;
  $this -> Uuid = $N [ "uuid" ]                 ;
  return true                                   ;
}

public function Obtains ( $DB , $Table )
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) > 0 )                      {
    if ( $this -> ObtainsByUuid    ( $DB , $Table ) ) return true ;
  }                                                               ;
  if ( $this -> isValid ( ) )                                     {
    if ( $this -> ObtainsByAccount ( $DB , $Table ) ) return true ;
  }                                                               ;
  return false                                                    ;
}

public function Append ( $DB , $ImTable , $UuidTable )
{
  $U = $DB -> ObtainsUuid ( $ImTable , $UuidTable ) ;
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return false     ;
  $this -> Uuid = (string) $U                       ;
  return $this -> Update ( $DB , $ImTable )         ;
}

public function Assure ( $DB , $ImTable , $UuidTable )
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) == 0 )                       {
    if ( strlen ( $this -> Account ) <= 0 ) return false            ;
    if ( $this -> ObtainsByAccount ( $DB , $ImTable ) ) return true ;
  } else                                                            {
    if ( $this -> ObtainsByUuid    ( $DB , $ImTable ) ) return true ;
  }                                                                 ;
  return $this -> Append ( $DB , $ImTable , $UuidTable )            ;
}

public function Newbie ( $DB , $ImTable , $UuidTable )
{
  if ( $this -> ObtainsByAccount ( $DB , $ImTable ) ) return false ;
  return $this -> Append ( $DB , $ImTable , $UuidTable )           ;
}

public function Subordination ( $DB , $Table , $U , $Type = "People" )
{
  $RI  = new Relation         (                  ) ;
  $RI -> set                  ( "first" , $U     ) ;
  $RI -> setT1                ( $Type            ) ;
  $RI -> setT2                ( "InstantMessage" ) ;
  $RI -> setRelation          ( "Subordination"  ) ;
  $UU  = $RI -> Subordination ( $DB , $Table     ) ;
  unset                       ( $RI              ) ;
  return $UU                                       ;
}

public function GetOwners ( $DB , $Table , $Type = "People" )
{
  $RI  = new Relation     (                          ) ;
  $RI -> set              ( "second" , $this -> Uuid ) ;
  $RI -> setT1            ( $Type                    ) ;
  $RI -> setT2            ( "InstantMessage"         ) ;
  $RI -> setRelation      ( "Subordination"          ) ;
  $UU  = $RI -> GetOwners ( $DB , $Table             ) ;
  unset                   ( $RI                      ) ;
  return $UU                                           ;
}

public function FindByName ( $DB , $TABLE , $NAME )
{
  $TMP = array ( )                                     ;
  $SPT = "%{$NAME}%"                                   ;
  $QQ  = "select `uuid` from {$TABLE}"                 .
         " where `account` like ?"                     .
         " order by `ltime` desc ;"                    ;
  $qq  = $DB -> Prepare    ( $QQ        )              ;
  $qq -> bind_param        ( 's' , $SPT )              ;
  $qq -> execute           (            )              ;
  $kk  = $qq -> get_result (            )              ;
  if ( $DB -> hasResult ( $kk ) )                      {
    while ( $rr = $kk -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $TMP , $rr [ 0 ] )                  ;
    }                                                  ;
  }                                                    ;
  return $TMP                                          ;
}

}

?>
