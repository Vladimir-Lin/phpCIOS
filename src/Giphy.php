<?php
//////////////////////////////////////////////////////////////////////////////
// GIPHY檢索元件
// 檢索網址: https://api.giphy.com/v1/gifs/search
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Giphy                                                                  {
//////////////////////////////////////////////////////////////////////////////
public $Auth                                                                 ;
public $Path                                                                 ;
public $Start                                                                ;
public $Page                                                                 ;
public $Rating                                                               ;
public $Language                                                             ;
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
// 原始設定值
// English (en)
// Spanish (es)
// Portuguese (pt)
// Indonesian (id)
// French (fr)
// Arabic (ar)
// Turkish (tr)
// Thai (th)
// Vietnamese (vi)
// German (de)
// Italian (it)
// Japanese (ja)
// Chinese Simplified (zh-CN)
// Chinese Traditional (zh-TW)
// Russian (ru)
// Korean (ko)
// Polish (pl)
// Dutch (nl)
// Romanian (ro)
// Hungarian (hu)
// Swedish (sv)
// Czech (cs)
// Hindi (hi)
// Bengali (bn)
// Danish (da)
// Farsi (fa)
// Filipino (tl)
// Finnish (fi)
// Hebrew (he)
// Malay (ms)
// Norwegian (no)
// Ukrainian (uk)
//////////////////////////////////////////////////////////////////////////////
public function Clear (                                                    ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Auth     = "zUyU4fzuPAFvBgkUV5y8LJQhx9jfbovV"                     ; // api_key=Auth
  $this -> Path     = "https://api.giphy.com/v1/gifs/search?"                ; // GIPHY檢索網址
  $this -> Page     = 50                                                     ; // limit=Page
  $this -> Start    = 0                                                      ; // offset=Start
  $this -> Rating   = "G"                                                    ; // rating=Rating
  $this -> Language = "en"                                                   ; // lang=Language
  $this -> Item     = "fixed_height"                                         ;
  ////////////////////////////////////////////////////////////////////////////
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
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
// 檢索GIPHY的關鍵字
// 參數:
//   $KEY : 關鍵字
// 返回值: 從GIPHY網站上取得的回應JSON
//////////////////////////////////////////////////////////////////////////////
public function Query ( $KEY )                                               {
  ////////////////////////////////////////////////////////////////////////////
  $PAVH = $this -> Path                                                      ;
  $AUTH = $this -> Auth                                                      ;
  $PSTA = $this -> Start                                                     ;
  $PSIZ = $this -> Page                                                      ;
  $RSZK = $this -> Rating                                                    ;
  $LANK = $this -> Language                                                  ;
  $KS   = rawurlencode ( $KEY )                                              ;
  $OPTS = "offset={$PSTA}&limit={$PSIZ}&rating={$RSZK}&lang={$LANK}"         ;
  $PAXH = "{$PAVH}api_key={$AUTH}&q='{$KS}'&{OPTS}"                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ch   = curl_init  (                                                     ) ;
  curl_setopt        ( $ch , CURLOPT_URL            , $PAXH                ) ;
  curl_setopt        ( $ch , CURLOPT_RETURNTRANSFER , 1                    ) ;
  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYHOST , 0                    ) ;
  curl_setopt        ( $ch , CURLOPT_SSL_VERIFYPEER , 0                    ) ;
  $temp = curl_exec  ( $ch                                                 ) ;
          curl_close ( $ch                                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Results = $temp                                                   ;
  $this -> JSON    = json_decode ( $temp                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> JSON                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
// 回應GIPHY數據的總數
//////////////////////////////////////////////////////////////////////////////
public function Total (                                                    ) {
  return count        ( $this -> JSON -> data                              ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得第i個GIPHY數據的網址
// 參數:
//   i : 數據位置
// 返回值: 網址
//////////////////////////////////////////////////////////////////////////////
public function get ( $i )                                                   {
  ////////////////////////////////////////////////////////////////////////////
  $item = $this -> Item                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> JSON -> data [ $i ] -> images -> $item -> url              ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得第i個GIPHY數據的參數
// 參數:
//   i    : 數據位置
//   part : GIPHY回應的參數名稱
// 返回值: 數據
//////////////////////////////////////////////////////////////////////////////
public function obtain ( $i , $part )                                        {
  ////////////////////////////////////////////////////////////////////////////
  $item = $this -> Item                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> JSON -> data [ $i ] -> images -> $item -> $part            ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
