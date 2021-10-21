<?php
//////////////////////////////////////////////////////////////////////////////
// PEXELS檢索元件
// 檢索網址: https://www.pexels.com/api/documentation
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Pexels                                                                 {
//////////////////////////////////////////////////////////////////////////////
public $Auth                                                                 ;
public $Path                                                                 ;
public $Locale                                                               ;
public $Start                                                                ;
public $Page                                                                 ;
public $Item                                                                 ;
public $JSON                                                                 ;
public $Results                                                              ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
// The locale of the search you are performing. The current supported locales are:
// 'en-US'
// 'pt-BR'
// 'es-ES'
// 'ca-ES'
// 'de-DE'
// 'it-IT'
// 'fr-FR'
// 'sv-SE'
// 'id-ID'
// 'pl-PL'
// 'ja-JP'
// 'zh-TW'
// 'zh-CN'
// 'ko-KR'
// 'th-TH'
// 'nl-NL'
// 'hu-HU'
// 'vi-VN'
// 'cs-CZ'
// 'da-DK'
// 'fi-FI'
// 'uk-UA'
// 'el-GR'
// 'ro-RO'
// 'nb-NO'
// 'sk-SK'
// 'tr-TR'
// 'ru-RU'
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> Auth   = [ 'Authorization: 563492ad6f9170000100000183fbbfc298f044b584d13c45c6235107' ] ;
  $this -> Path   = "https://api.pexels.com/v1/search?"                      ;
  $this -> Locale = "en-US"                                                  ;
  $this -> Start  = 0                                                        ;
  $this -> Page   = 50                                                       ;
  $this -> Item   = "small"                                                  ;
//  $this -> Item   = "original"                                               ;
//  $this -> Item   = "large"                                                  ;
//  $this -> Item   = "large2x"                                                ;
//  $this -> Item   = "medium"                                                 ;
//  $this -> Item   = "portrait"                                               ;
//  $this -> Item   = "landscape"                                              ;
//  $this -> Item   = "tiny"                                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function Query   ( $KEY                                             ) {
  ////////////////////////////////////////////////////////////////////////////
  $PAVH  = $this -> Path                                                     ;
  $PSIZ  = $this -> Page                                                     ;
  $LC    = $this -> Locale                                                   ;
  $KS    = rawurlencode ( $KEY                                             ) ;
  $PAXH  = "{$PAVH}per_page={$PSIZ}&locale={$LC}&query='{$KS}'"              ;
  ////////////////////////////////////////////////////////////////////////////
  $ch    = curl_init    (                                                  ) ;
  curl_setopt           ( $ch , CURLOPT_URL            , $PAXH             ) ;
  curl_setopt           ( $ch , CURLOPT_HTTPHEADER     , $this -> Auth     ) ;
  curl_setopt           ( $ch , CURLOPT_RETURNTRANSFER , 1                 ) ;
  curl_setopt           ( $ch , CURLOPT_SSL_VERIFYHOST , 0                 ) ;
  curl_setopt           ( $ch , CURLOPT_SSL_VERIFYPEER , 0                 ) ;
  $temp  = curl_exec    ( $ch                                              ) ;
           curl_close   ( $ch                                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Results = $temp                                                   ;
  $this -> JSON    = json_decode ( $temp                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> JSON                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function Total (                         )                            {
  return count        ( $this -> JSON -> photos )                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function get ( $i )                                                   {
  $item = $this -> Item                                                      ;
  return $this -> JSON -> photos [ $i ] -> src -> $item                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function obtain ( $i , $part )                                        {
  return $this -> JSON -> photos [ $i ] -> src -> $part                      ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
