<?php

namespace CIOS ;

class Glosbe
{
/////////////////////////////////////////////////////////

public $Path    ;
public $From    ;
public $Dest    ;
public $Format  ;
public $Tm      ;
public $Pretty  ;

/////////////////////////////////////////////////////////

function __construct()
{
  $this -> Clear ( ) ;
}

function __destruct()
{
}

public function Clear ( )
{
  $this -> Path   = "https://glosbe.com/gapi/translate?"                     ;
  $this -> From   = "eng"                                                    ;
  $this -> Dest   = "zho"                                                    ;
  $this -> Format = "json"                                                   ;
  $this -> Tm     = true                                                     ;
  $this -> Pretty = true                                                     ;
}

public function Query ( $Phrase )
{
  $PAVH = $this -> Path                                               ;
  $PSIZ = $this -> Page                                               ;
  $KS   = rawurlencode ( $KEY )                                       ;
  $PAXH = "{$PAVH}per_page={$PSIZ}&query='{$KS}'"                     ;
  $ch   = curl_init  (                                              ) ;
  curl_setopt        ( $ch , CURLOPT_URL            , $PAXH         ) ;
  curl_setopt        ( $ch , CURLOPT_HTTPHEADER     , $this -> Auth ) ;
  curl_setopt        ( $ch , CURLOPT_RETURNTRANSFER , 1             ) ;
  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYHOST , 0             ) ;
  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYPEER , 0             ) ;
  $temp = curl_exec  ( $ch                                          ) ;
          curl_close ( $ch                                          ) ;
  $this -> Results = $temp                                            ;
//  $this -> JSON    = json_decode ( $temp                            ) ;
  return $this -> Results                                             ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
