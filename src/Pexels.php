<?php

namespace CIOS ;

class Pexels
{
/////////////////////////////////////////////////////////

public $Auth    ;
public $Path    ;
public $Start   ;
public $Page    ;
public $Item    ;
public $JSON    ;
public $Results ;

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
  $this -> Auth  = [ 'Authorization: 563492ad6f9170000100000183fbbfc298f044b584d13c45c6235107' ] ;
  $this -> Path  = "https://api.pexels.com/v1/search?"                       ;
  $this -> Start = 0                                                         ;
  $this -> Page  = 50                                                        ;
  $this -> Item  = "small"                                                   ;
//  $this -> Item  = "original"                                                ;
//  $this -> Item  = "large"                                                   ;
//  $this -> Item  = "large2x"                                                 ;
//  $this -> Item  = "medium"                                                  ;
//  $this -> Item  = "portrait"                                                ;
//  $this -> Item  = "landscape"                                               ;
//  $this -> Item  = "tiny"                                                    ;
}

public function Query ( $KEY )
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
  $this -> JSON    = json_decode ( $temp                            ) ;
  return $this -> JSON                                                ;
}

public function Total ( )
{
  return count ( $this -> JSON -> photos ) ;
}

public function get ( $i )
{
  $item = $this -> Item                                 ;
  return $this -> JSON -> photos [ $i ] -> src -> $item ;
}

public function obtain ( $i , $part )
{
  return $this -> JSON -> photos [ $i ] -> src -> $part ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
