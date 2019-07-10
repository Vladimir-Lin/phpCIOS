<?php

namespace CIOS ;

define ( "CiosLanguageKey" , "CIOS-Language" ) ;

class Browser
{

public static function Language ( )
{
  $Accepts = $_SERVER [ "HTTP_ACCEPT_LANGUAGE" ]        ;
  preg_match ( '/^([a-z\-]+)/i' , $Accepts , $matches ) ;
  $lang = $matches [ 1 ]                                ;
  switch ( $lang )                                      {
    case 'zh-tw'                                        :
    case 'zh-TW'                                        :
    return 1002                                         ;
    case 'zh-hk'                                        :
    case 'zh-HK'                                        :
    case 'zh-mo'                                        :
    case 'zh-MO'                                        :
    return 1004                                         ;
    case 'zh-cn'                                        :
    case 'zh-CN'                                        :
    case 'zh-sg'                                        :
    case 'zh-SG'                                        :
    return 1003                                         ;
    case 'jp'                                           :
    case 'ja-jp'                                        :
    case 'ja-JP'                                        :
    return 1006                                         ;
  }                                                     ;
  return 1001                                           ;
}

public static function SetLanguage ( $LANG )
{
  $_SESSION [ CiosLanguageKey ] = $LANG ;
}

public static function GetLanguage ( )
{
  ///////////////////////////////////////////////////
  if   ( isset ( $_SESSION [ CiosLanguageKey ] ) )  {
    $LANG = $_SESSION [ CiosLanguageKey ]           ;
    if ( strlen ( $LANG ) > 0                     ) {
      return $LANG                                  ;
    }                                               ;
  }                                                 ;
  ///////////////////////////////////////////////////
  $TIDX = self::Language ( )                        ;
  if ( strlen ( $TIDX ) <= 0 ) return 1001          ;
  ///////////////////////////////////////////////////
  return $TIDX                                      ;
}

public static function LocaleNow ( $LANG )
{
  switch ( $LANG )            {
    case 1002: return "zh-TW" ;
    case 1003: return "zh-CN" ;
    case 1004: return "zh-HK" ;
    case 1005: return "zh-TN" ;
    case 1006: return "ja-JP" ;
  }                           ;
  return "en"                 ;
}

public static function Locale ( )
{
  return self::LocaleNow ( self::GetLanguage ( ) ) ;
}

}

?>
