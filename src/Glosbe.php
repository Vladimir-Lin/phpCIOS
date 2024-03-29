<?php
//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Glosbe                                                                 {
//////////////////////////////////////////////////////////////////////////////
public $Path                                                                 ;
public $From                                                                 ;
public $Dest                                                                 ;
public $Format                                                               ;
public $Tm                                                                   ;
public $Pretty                                                               ;
public $Results                                                              ;
public $JSON                                                                 ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> Path   = "https://glosbe.com/gapi/translate?"                     ;
  $this -> From   = "eng"                                                    ;
  $this -> Dest   = "zho"                                                    ;
  $this -> Format = "json"                                                   ;
  $this -> Tm     = true                                                     ;
  $this -> Pretty = true                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////
public function Query ( $Phrase )                                            {
  $PAVH   = $this -> Path                                                    ;
  $FPAT   = "from={$this->From}"                                             ;
  $PAXH   = "{$PAVH}{$FPAT}"                                                 ;
  $DEST   = "dest={$this->Dest}"                                             ;
  $PAXH   = "{$PAVH}&{$DEST}"                                                ;
  $FMTX   = "format={$this->Format}"                                         ;
  $PAXH   = "{$PAVH}&{$FMTX}"                                                ;
  if ( $this -> Tm )                                                         {
    $TMVX = "tm=true"                                                        ;
  } else                                                                     {
    $TMVX = "tm=false"                                                       ;
  }                                                                          ;
  $PAXH   = "{$PAVH}&{$TMVX}"                                                ;
  if ( $this -> Pretty )                                                     {
    $PTVX = "pretty=true"                                                    ;
  } else                                                                     {
    $PTVX = "pretty=false"                                                   ;
  }                                                                          ;
  $PAXH   = "{$PAVH}&page=1&pageSize=30"                                     ;
  $PAXH   = "{$PAVH}&{$PTVX}"                                                ;
  $KS   = rawurlencode ( $Phrase )                                           ;
  $PAXH = "{$PAVH}&phrase={$KS}"                                             ;
  $ch   = curl_init  (                                                     ) ;
  curl_setopt        ( $ch , CURLOPT_URL            , $PAXH                ) ;
  curl_setopt        ( $ch , CURLOPT_RETURNTRANSFER , 1                    ) ;
  curl_setopt        ( $ch , CURLOPT_ENCODING       , ''                   ) ;
//  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYHOST , 0             )        ;
//  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYPEER , 0             )        ;
  $temp = curl_exec  ( $ch                                                 ) ;
          curl_close ( $ch                                                 ) ;
  $this -> Results = $temp                                                   ;
  $this -> JSON    = json_decode ( $temp                                   ) ;
  return $this -> Results                                                    ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
