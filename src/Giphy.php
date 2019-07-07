<?php

namespace CIOS ;

class Giphy
{
/////////////////////////////////////////////////////////

public $Auth     ;
public $Path     ;
public $Start    ;
public $Page     ;
public $Rating   ;
public $Language ;
public $Item     ;
public $JSON     ;
public $Results  ;

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
  $this -> Auth     = "zUyU4fzuPAFvBgkUV5y8LJQhx9jfbovV"                     ; // api_key=Auth
  $this -> Path     = "https://api.giphy.com/v1/gifs/search?"                ;
  $this -> Page     = 50                                                     ; // limit=Page
  $this -> Start    = 0                                                      ; // offset=Start
  $this -> Rating   = "G"                                                    ; // rating=Rating
  $this -> Language = "en"                                                   ; // lang=Language
  $this -> Item     = "fixed_height"                                         ;
//  fixed_height_still
//  original_still
//  fixed_width
//  fixed_height_small_still
//  fixed_height_downsampled
//  preview => not working, maybe different item
//  fixed_height_small
//  downsized_still
//  downsized
//  downsized_large
//  fixed_width_small_still
//  preview_webp
//  fixed_width_still
//  fixed_width_small
//  downsized_small => not working, maybe different item
//  fixed_width_downsampled
//  downsized_medium
//  original
//  fixed_height => nice choice
//  looping => not working, maybe different item
//  original_mp4 => not working, maybe different item
//  preview_gif
//  480w_still
// Query => q=something_html_encoded
}

public function Query ( $KEY )
{
  $PAVH = $this -> Path                                                      ;
  $AUTH = $this -> Auth                                                      ;
  $PSTA = $this -> Start                                                     ;
  $PSIZ = $this -> Page                                                      ;
  $RSZK = $this -> Rating                                                    ;
  $LANK = $this -> Language                                                  ;
  $KS   = rawurlencode ( $KEY )                                              ;
  $OPTS = "offset={$PSTA}&limit={$PSIZ}&rating={$RSZK}&lang={$LANK}"         ;
  $PAXH = "{$PAVH}api_key={$AUTH}&q='{$KS}'&{OPTS}"                          ;
  $ch   = curl_init  (                                                     ) ;
  curl_setopt        ( $ch , CURLOPT_URL            , $PAXH                ) ;
  curl_setopt        ( $ch , CURLOPT_RETURNTRANSFER , 1                    ) ;
  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYHOST , 0                    ) ;
  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYPEER , 0                    ) ;
  $temp = curl_exec  ( $ch                                                 ) ;
          curl_close ( $ch                                                 ) ;
  $this -> Results = $temp                                                   ;
  $this -> JSON    = json_decode ( $temp                                   ) ;
  return $this -> JSON                                                       ;
}

public function Total ( )
{
  return count ( $this -> JSON -> data ) ;
}

public function get ( $i )
{
  $item = $this -> Item                                         ;
  return $this -> JSON -> data [ $i ] -> images -> $item -> url ;
}

public function obtain ( $i , $part )
{
  $item = $this -> Item                                           ;
  return $this -> JSON -> data [ $i ] -> images -> $item -> $part ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
