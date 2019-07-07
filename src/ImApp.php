<?php

namespace CIOS ;

class ImApp extends Columns
{
//////////////////////////////////////////////////////////////////////////////
  public $Uuid    = "0" ;
  public $Type    =  1  ;
  public $Account       ;
//////////////////////////////////////////////////////////////////////////////

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
  $Q = "select `account`,`imapp` from " . $Table .
       $DB -> WhereUuid ( $this -> Uuid , true ) ;
  $q = $DB -> Query ( $Q )                       ;
  if ( ! $DB -> hasResult ( $q ) ) return false  ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )         ;
  if ( ! $N ) return false                       ;
  $this -> Type    = $N [ "imapp"   ]            ;
  $this -> Account = $N [ "account" ]            ;
  return true                                    ;
}

public function ObtainsByAccount($DB,$Table)
{
  $this -> Uuid = "0"                                        ;
  $Q  = "select `uuid` from " . $Table                       .
        " where `account` = '" . $this -> Account . "' and " .
        "`imapp` = " . $this -> Type . " and `used` = 1 ;"   ;
  $q  = $DB -> Query ( $Q )                                  ;
  if ( ! $DB -> hasResult ( $q ) ) return false              ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )                     ;
  if ( ! $N ) return false                                   ;
  $this -> Uuid = $N [ "uuid" ]                              ;
  return true                                                ;
}

public function Obtains($DB,$Table)
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
  $RI  = new RelationItem     (                  ) ;
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
  $RI  = new RelationItem (                          ) ;
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

public function EchoOptions($HS)
{
  global $ImAppNames                      ;
  $K = array_keys ( $ImAppNames )         ;
  if ( count ( $K ) <= 0 ) return         ;
  foreach ( $K as $k )                    {
    $HE = new HtmlTag ( )                 ;
    $HE -> setTag ( "option" )            ;
    if ( $k == $this -> Type )            {
      $HE -> AddMember ( "selected" )     ;
    }                                     ;
    $HE -> AddPair ( "value" , $k       ) ;
    $HE -> AddText ( $ImAppNames [ $k ] ) ;
    $HS -> AddTag  ( $HE                ) ;
  }
}

public function EchoSelection($ClassName,$ItemName)
{
  $HS    = new HtmlTag (                      ) ;
  $HS   -> setSplitter ( "\n"                 ) ;
  $HS   -> setTag      ( "select"             ) ;
  $HS   -> SafePair    ( "class" , $ClassName ) ;
  $HS   -> SafePair    ( "id"    , $ItemName  ) ;
  $HS   -> SafePair    ( "name"  , $ItemName  ) ;
  $this -> EchoOptions ( $HS                  ) ;
  return $HS                                    ;
}

public function EchoUuidInput($ItemName)
{
  $HS  = new HtmlTag    (                         ) ;
  $HS -> setHiddenInput (                         ) ;
  $HS -> SafePair       ( "id"    , $ItemName     ) ;
  $HS -> SafePair       ( "name"  , $ItemName     ) ;
  $HS -> SafePair       ( "value" , $this -> Uuid ) ;
  return $HS                                        ;
}

public function EchoPositionInput($ItemName,$ID)
{
  $HT  = new HtmlTag    (                     ) ;
  $HT -> setHiddenInput (                     ) ;
  $HT -> SafePair       ( "id"    , $ItemName ) ;
  $HT -> SafePair       ( "name"  , $ItemName ) ;
  $HT -> AddPair        ( "value" , $ID       ) ;
  ///////////////////////////////////////////////
  return $HT                                    ;
}

public function EchoAccountInput($ClassName,$ItemName,$Width,$Holder="")
{
  $HS  = new HtmlTag (                                  ) ;
  $HS -> setInput    (                                  ) ;
  $HS -> AddPair     ( "type"        , "text"           ) ;
  $HS -> AddPair     ( "size"        , $Width           ) ;
  $HS -> SafePair    ( "class"       , $ClassName       ) ;
  $HS -> SafePair    ( "id"          , $ItemName        ) ;
  $HS -> SafePair    ( "name"        , $ItemName        ) ;
  $HS -> SafePair    ( "value"       , $this -> Account ) ;
  $HS -> SafePair    ( "placeholder" , $Holder          ) ;
  return $HS                                              ;
}

public function EchoDIV($ID,$Width,$Holder="")
{
  $OC  = "portfolioImAppChanged("     . $ID . ");"        ;
//  $OE  = "portfolioImAppEnter(event," . $ID . ");"        ;
  /////////////////////////////////////////////////////////
  $HD  = new HtmlTag (                                  ) ;
  $HD -> setSplitter ( "\n"                             ) ;
  $HD -> setTag      ( "div"                            ) ;
  $HD -> SafePair    ( "class" , "imapp-div"            ) ;
  /////////////////////////////////////////////////////////
  $HT  = new HtmlTag (                                  ) ;
  $HT -> setTag      ( "table"                          ) ;
  $HT -> AddPair     ( "width"       , "100%"           ) ;
  $HT -> AddPair     ( "border"      , "0"              ) ;
  $HT -> AddPair     ( "cellspacing" , "0"              ) ;
  $HT -> AddPair     ( "cellpadding" , "0"              ) ;
  $HD -> AddTag      ( $HT                              ) ;
  /////////////////////////////////////////////////////////
  $HB  = new HtmlTag (                                  ) ;
  $HB -> setTag      ( "tbody"                          ) ;
  $HT -> AddTag      ( $HB                              ) ;
  /////////////////////////////////////////////////////////
  $HR  = new HtmlTag (                                  ) ;
  $HR -> setTag      ( "tr"                             ) ;
  $HR -> setSplitter ( "\n"                             ) ;
  $HB -> AddTag      ( $HR                              ) ;
  /////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  ) ;
  $HX -> setTag      ( "td"                             ) ;
  $HX -> setSplitter ( "\n"                             ) ;
  $HX -> AddPair     ( "width" , "5%"                   ) ;
  $HR -> AddTag      ( $HX                              ) ;
  $HX -> AddTag      ( $this -> EchoUuidInput             (
                         "imapp-uuid-" . $ID          ) ) ;
  $HX -> AddTag      ( $this -> EchoPositionInput         (
                         "imapp-position-" . $ID          ,
                         $ID                          ) ) ;
  /////////////////////////////////////////////////////////
  $HS  = $this -> EchoSelection                           (
                       "imapp-selection"                  ,
                       "imapp-id-"     . $ID            ) ;
  $HS -> AddPair     ( "onchange"   , $OC               ) ;
//  $HS -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HS                              ) ;
  /////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  ) ;
  $HX -> setTag      ( "td"                             ) ;
  $HX -> setSplitter ( "\n"                             ) ;
  $HR -> AddTag      ( $HX                              ) ;
  $HA  = $this -> EchoAccountInput                        (
                       "NameInput"                        ,
                       "imapp-"          . $ID            ,
                       $Width                             ,
                       $Holder                          ) ;
  $HA -> AddPair     ( "onchange"   , $OC               ) ;
//  $HA -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HA                              ) ;
  /////////////////////////////////////////////////////////
  return $HD                                              ;
}

public function EchoPersonalImApp($PUID,$ID,$Width,$Holder="")
{
  $OC  = "personalImAppChanged('{$PUID}',{$ID});"         ;
  /////////////////////////////////////////////////////////
  $HD  = new HtmlTag (                                  ) ;
  $HD -> setSplitter ( "\n"                             ) ;
  $HD -> setTag      ( "div"                            ) ;
  $HD -> SafePair    ( "class" , "imapp-div"            ) ;
  /////////////////////////////////////////////////////////
  $HT  = new HtmlTag (                                  ) ;
  $HT -> setTag      ( "table"                          ) ;
  $HT -> AddPair     ( "width"       , "100%"           ) ;
  $HT -> AddPair     ( "border"      , "0"              ) ;
  $HT -> AddPair     ( "cellspacing" , "0"              ) ;
  $HT -> AddPair     ( "cellpadding" , "0"              ) ;
  $HD -> AddTag      ( $HT                              ) ;
  /////////////////////////////////////////////////////////
  $HB  = new HtmlTag (                                  ) ;
  $HB -> setTag      ( "tbody"                          ) ;
  $HT -> AddTag      ( $HB                              ) ;
  /////////////////////////////////////////////////////////
  $HR  = new HtmlTag (                                  ) ;
  $HR -> setTag      ( "tr"                             ) ;
  $HR -> setSplitter ( "\n"                             ) ;
  $HB -> AddTag      ( $HR                              ) ;
  /////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  ) ;
  $HX -> setTag      ( "td"                             ) ;
  $HX -> setSplitter ( "\n"                             ) ;
  $HX -> AddPair     ( "width" , "5%"                   ) ;
  $HR -> AddTag      ( $HX                              ) ;
  $HX -> AddTag      ( $this -> EchoUuidInput             (
                         "imapp-uuid-" . $ID          ) ) ;
  $HX -> AddTag      ( $this -> EchoPositionInput         (
                         "imapp-position-" . $ID          ,
                         $ID                          ) ) ;
  /////////////////////////////////////////////////////////
  $HS  = $this -> EchoSelection                           (
                       "imapp-selection"                  ,
                       "imapp-id-"     . $ID            ) ;
  $HS -> AddPair     ( "onchange"   , $OC               ) ;
//  $HS -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HS                              ) ;
  /////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  ) ;
  $HX -> setTag      ( "td"                             ) ;
  $HX -> setSplitter ( "\n"                             ) ;
  $HR -> AddTag      ( $HX                              ) ;
  $HA  = $this -> EchoAccountInput                        (
                       "NameInput"                        ,
                       "imapp-"          . $ID            ,
                       $Width                             ,
                       $Holder                          ) ;
  $HA -> AddPair     ( "onchange"   , $OC               ) ;
//  $HA -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HA                              ) ;
  /////////////////////////////////////////////////////////
  return $HD                                              ;
}

public function AccountURL()
{
  ////////////////////////////////////////////////////////
  $SA    = $this -> Account                              ;
  $SKYPE = "skype:{$SA}?chat"                            ;
  ////////////////////////////////////////////////////////
  $URL  = new HtmlTag (                                ) ;
  $URL -> setTag      ( "a"                            ) ;
  ////////////////////////////////////////////////////////
  $IMG  = new HtmlTag (                                ) ;
  $IMG -> setTag      ( "img"                          ) ;
  $IMG -> AddPair     ( "src"    , "/images/skype.png" ) ;
  $IMG -> AddPair     ( "width"  , "24"                ) ;
  $IMG -> AddPair     ( "height" , "24"                ) ;
  ////////////////////////////////////////////////////////
  $URL -> setSplitter ( "\n"                           ) ;
  $URL -> AddPair     ( "href"   , $SKYPE              ) ;
  $URL -> AddTag      ( $IMG                           ) ;
  $URL -> AddText     ( $SA                            ) ;
  ////////////////////////////////////////////////////////
  return $URL                                            ;
}

//////////////////////////////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////
?>
