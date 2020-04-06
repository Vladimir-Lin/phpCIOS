<?php

namespace CIOS ;

class MailBox extends Columns
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

public function isLoaded()
{
  return ( gmp_cmp ( $this -> Uuid , "0" ) > 0 ) ;
}

public function isValid()
{
  if ( 0 >= strlen ( $this -> Appellation ) ) {
    return false                              ;
  }                                           ;
  return $this -> Verify ( )                  ;
}

public function isValidHostname($hostname)
{
  if ( strlen ( $hostname ) <= 0 )    {
    return false                      ;
  }                                   ;
  $TLDs = explode ( "." , $hostname ) ;
  if ( 2 > count ( $TLDs ) )          {
    unset ( $TLDs )                   ;
    return false                      ;
  }                                   ;
  unset ( $TLDs )                     ;
  return true                         ;
}

public function Verify()
{
  if ( ! $this -> isValidHostname ( $this -> Hostname ) ) {
    return false                                          ;
  }                                                       ;
  if ( false === strpos ( " "  , $this -> Account     ) ) {
    // no space in the email account name
  } else return false                                     ;
  if ( false === strpos ( "\\" , $this -> Appellation ) ) {
  } else return false                                     ;
  if ( false === strpos ( "'"  , $this -> Appellation ) ) {
  } else return false                                     ;
  if ( false === strpos ( "`"  , $this -> Appellation ) ) {
  } else return false                                     ;
  if ( false === strpos ( "\"" , $this -> Appellation ) ) {
  } else return false                                     ;
  $n = strtolower ( $this -> Name ( )    )                ;
  $a = strtolower ( $this -> Appellation )                ;
  return ( $n == $a )                                     ;
}

public function Name()
{
  return $this -> Account . "@" . $this -> Hostname ;
}

public function isEqual($email)
{
  return ( $email == $this -> Name ( ) ) ;
}

public function assign ($email)
{
  $this -> Position    = $email -> Position    ;
  $this -> Uuid        = $email -> Uuid        ;
  $this -> HostId      = $email -> HostId      ;
  $this -> Account     = $email -> Account     ;
  $this -> Hostname    = $email -> Hostname    ;
  $this -> Appellation = $email -> Appellation ;
  $this -> Updated     = $email -> Updated     ;
}

public function tableItems()
{
  $S = array (                 ) ;
  array_push ( $S , "id"       ) ;
  array_push ( $S , "uuid"     ) ;
  array_push ( $S , "hostid"   ) ;
  array_push ( $S , "account"  ) ;
  array_push ( $S , "hostname" ) ;
  array_push ( $S , "email"    ) ;
  array_push ( $S , "ltime"    ) ;
  return $S                      ;
}

public function set($item,$V)
{
  $a = strtolower ( $item )                         ;
  if ( "id"       == $a ) $this -> Position    = $V ;
  if ( "uuid"     == $a ) $this -> Uuid        = $V ;
  if ( "hostid"   == $a ) $this -> HostId      = $V ;
  if ( "account"  == $a ) $this -> Account     = $V ;
  if ( "hostname" == $a ) $this -> Hostname    = $V ;
  if ( "email"    == $a ) $this -> Appellation = $V ;
  if ( "ltime"    == $a ) $this -> Updated     = $V ;
}

public function ItemPair($item)
{
  $a = strtolower ( $item )                            ;
  if ( "id"       == $a )                              {
    return "`{$a}` = " . (string) $this -> Position    ;
  }                                                    ;
  if ( "uuid"     == $a )                              {
    return "`{$a}` = " . (string) $this -> Uuid        ;
  }                                                    ;
  if ( "hostid"   == $a )                              {
    return "`{$a}` = " . (string) $this -> HostId      ;
  }                                                    ;
  if ( "account"  == $a )                              {
    return "`{$a}` = " . (string) $this -> Account     ;
  }                                                    ;
  if ( "hostname" == $a )                              {
    return "`{$a}` = " . (string) $this -> Hostname    ;
  }                                                    ;
  if ( "email"    == $a )                              {
    return "`{$a}` = " . (string) $this -> Appellation ;
  }                                                    ;
  if ( "ltime"    == $a )                              {
    return "`{$a}` = " . (string) $this -> Updated     ;
  }                                                    ;
  return ""                                            ;
}

public function setAccount ($account)
{
  if ( strlen ( $account ) <= 0 ) return false ;
  $this -> Account = trim ( $account )         ;
  $this -> Updated = true                      ;
  return true                                  ;
}

public function setHostname ($hostname)
{
  if ( ! $this -> isValidHostname ( $hostname ) )       {
    return false                                        ;
  }                                                     ;
  $this -> Hostname = strtolower ( trim ( $hostname ) ) ;
  $this -> Updated  = true                              ;
  return true                                           ;
}

public function setEMail ($email)
{
  if ( 0 >= strlen ( $email )              ) return false ;
  $S = trim    ( $email   )                               ;
  $E = explode ( "@" , $S )                               ;
  if ( 2 != count ( $E )                   ) return false ;
  if ( ! $this -> setAccount  ( $E [ 0 ] ) ) return false ;
  if ( ! $this -> setHostname ( $E [ 1 ] ) ) return false ;
  $this -> Appellation = $S                               ;
  $this -> Updated     = true                             ;
  return $this -> isValid ( )                             ;
}

public function Obtain($ResultArray)
{
  $this -> Account     = $ResultArray [ "account"  ] ;
  $this -> Hostname    = $ResultArray [ "hostname" ] ;
  $this -> Appellation = $ResultArray [ "email"    ] ;
  $this -> Updated     = false                       ;
}

public function Update($DB,$Table)
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false        ;
  $QQ = "update " . $Table . " set"                               .
          " `hostid` = "  . (string) $this -> HostId      . " ,"  .
         " `account` = '" . (string) $this -> Account     . "' ," .
        " `hostname` = '" . (string) $this -> Hostname    . "' ," .
           " `email` = '" . (string) $this -> Appellation . "' "  .
        $DB -> WhereUuid ( $this -> Uuid , true )                 ;
  return $DB -> Query ( $QQ )                                     ;
}

public function Insert($DB,$Table)
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false       ;
  $QQ = "insert into " . $Table                                  .
        " (`uuid`,`hostid`,`account`,`hostname`,`email`) values" .
        " (" . (string) $this -> Uuid                            .
        ",0"                                                     .
        ",'" . (string) $this -> Account  . "'"                  .
        ",'" . (string) $this -> Hostname . "'"                  .
        ",'" . (string) $this -> Appellation . "') ;"            ;
  return $DB -> Query ( $QQ )                                    ;
}

public function ObtainsByEMail ( $DB , $Table )
{
  $U = 0                                 ;
  $Q = "select `uuid` from " . $Table    .
       " where `email` = '"              .
       $this -> Appellation . "' ;"      ;
  $q = $DB -> Query   ( $Q )             ;
  if ( ! $DB -> hasResult ( $q ) )       {
    return false                         ;
  }                                      ;
  $N = $q -> fetch_array ( MYSQLI_BOTH ) ;
  $this -> Uuid = $N [ "uuid" ]          ;
  return true                            ;
}

public function ObtainsByUuid($DB,$Table)
{
  $Q = "select `account`,`hostname`,`email` from " . $Table .
       " where `uuid` = " . (string) $this -> Uuid . " ;"   ;
  $q = $DB -> Query ( $Q )                                  ;
  if ( ! $DB -> hasResult ( $q ) ) return false             ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )                    ;
  $this -> Obtain ( $N )                                    ;
  return true                                               ;
}

public function Obtains($DB,$Table)
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) > 0 )                    {
    if ( $this -> ObtainsByUuid  ( $DB , $Table ) ) return true ;
  }                                                             ;
  if ( $this -> isValid ( ) )                                   {
    if ( $this -> ObtainsByEMail ( $DB , $Table ) ) return true ;
  }                                                             ;
  return false                                                  ;
}

public function Append ( $DB , $EmailTable , $UuidTable )
{
  $U = $DB -> LastUuid ( $EmailTable , "`uuid`" , "3000000000000000000" ) ;
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return false                           ;
  $this -> Uuid = (string) $U                                             ;
  $RI           = new Relation ( )                                        ;
  $ET           = $RI -> Types [ "EMail" ]                                ;
  if ( ! $DB -> AddUuid ( $UuidTable , $U , $ET ) ) return false          ;
  return $this -> Insert ( $DB , $EmailTable )                            ;
}

public function Assure ( $DB , $EmailTable , $UuidTable )
{
  if ( gmp_cmp ( $this -> Uuid , "0" ) == 0 )                        {
    if ( ! $this -> isValid ( ) ) return false                       ;
    if ( $this -> ObtainsByEMail ( $DB , $EmailTable ) ) return true ;
  } else                                                             {
    if ( $this -> ObtainsByUuid  ( $DB , $EmailTable ) ) return true ;
  }                                                                  ;
  return $this -> Append ( $DB , $EmailTable , $UuidTable )          ;
}

public function Newbie ( $DB , $EmailTable , $UuidTable )
{
  if ( $this -> ObtainsByEMail ( $DB , $EmailTable ) ) return false ;
  return $this -> Append ( $DB , $EmailTable , $UuidTable )         ;
}

public function GetRelation ( $First               ,
                              $Second              ,
                              $T = "People"        ,
                              $R = "Subordination" )
{
  $RI  = new Relation       (                    ) ;
  $RI -> set                ( "first"  , $First  ) ;
  $RI -> set                ( "second" , $Second ) ;
  $RI -> setT1              ( $T                 ) ;
  $RI -> setT2              ( "EMail"            ) ;
  $RI -> setRelation        ( $R                 ) ;
  return $RI                                       ;
}

public function Subordination ( $DB , $Table , $U , $Type = "People" )
{
  $RI = $this -> GetRelation   ( $U  , 0 , $Type ) ;
  return $RI  -> Subordination ( $DB , $Table    ) ;
}

public function GetOwners ( $DB , $Table , $Type = "People" )
{
  $U  = $this -> Uuid                             ;
  $RI = $this -> GetRelation ( 0   , $U , $Type ) ;
  return $RI  -> GetOwners   ( $DB , $Table     ) ;
}

public function FindByName ( $DB , $TABLE , $NAME )
{
  $TMP = array ( )                                     ;
  $SPT = "%{$NAME}%"                                   ;
  $QQ  = "select `uuid` from {$TABLE}"                 .
         " where `email` like ?"                       .
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
