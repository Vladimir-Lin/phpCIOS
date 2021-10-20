<?php
//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
define ( "CiosLanguageKey" , "CIOS-Language" )                               ;
//////////////////////////////////////////////////////////////////////////////
class Browser                                                                {
//////////////////////////////////////////////////////////////////////////////
public static function Language ( )                                          {
  ////////////////////////////////////////////////////////////////////////////
  $Accepts = $_SERVER [ "HTTP_ACCEPT_LANGUAGE" ]                             ;
  preg_match ( '/^([a-z\-]+)/i' , $Accepts , $matches )                      ;
  $lang = $matches [ 1 ]                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  switch ( $lang )                                                           {
    case 'zh-tw'                                                             :
    case 'zh-TW'                                                             :
    return 1002                                                              ;
    case 'zh-hk'                                                             :
    case 'zh-HK'                                                             :
    case 'zh-mo'                                                             :
    case 'zh-MO'                                                             :
    return 1004                                                              ;
    case 'zh-cn'                                                             :
    case 'zh-CN'                                                             :
    case 'zh-sg'                                                             :
    case 'zh-SG'                                                             :
    return 1003                                                              ;
    case 'jp'                                                                :
    case 'ja-jp'                                                             :
    case 'ja-JP'                                                             :
    return 1006                                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return 1001                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SetLanguage ( $LANG )                                 {
  $_SESSION [ CiosLanguageKey ] = $LANG                                      ;
}
//////////////////////////////////////////////////////////////////////////////
public static function GetLanguage ( )                                       {
  ////////////////////////////////////////////////////////////////////////////
  if   ( isset ( $_SESSION [ CiosLanguageKey ] ) )                           {
    $LANG = $_SESSION [ CiosLanguageKey ]                                    ;
    if ( strlen ( $LANG ) > 0                    )                           {
      return $LANG                                                           ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TIDX = self::Language ( )                                                 ;
  if ( strlen ( $TIDX ) <= 0 ) return 1001                                   ;
  ////////////////////////////////////////////////////////////////////////////
  return $TIDX                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function LocaleNow ( $LANG )                                   {
  switch                         ( $LANG )                                   {
    case 1002: return "zh-TW"                                                ;
    case 1003: return "zh-CN"                                                ;
    case 1004: return "zh-HK"                                                ;
    case 1005: return "zh-TN"                                                ;
    case 1006: return "ja-JP"                                                ;
  }                                                                          ;
  return "en"                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function Locale ( )                                            {
  return self::LocaleNow ( self::GetLanguage ( ) )                           ;
}
//////////////////////////////////////////////////////////////////////////////
public static function CurrentRole ( )                                       {
  $ROLE = $_SESSION [ "ACTIONS_ROLE" ]                                       ;
  $ROLE = intval    ( $ROLE , 10     )                                       ;
  return $ROLE                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function isTutor ( )                                           {
  if ( self::CurrentRole ( ) == 2 ) return true                              ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function isStudent ( )                                         {
  if ( self::CurrentRole ( ) == 3 ) return true                              ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function GetPathInfos ( )                                      {
  ////////////////////////////////////////////////////////////////////////////
  if ( ! isset ( $_SERVER['PATH_INFO'] ) ) return array ( )                  ;
  ////////////////////////////////////////////////////////////////////////////
  $PIFS  = explode ( "/" , $_SERVER['PATH_INFO']                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $ID    = 0                                                                 ;
  $LISTs = array   (                                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  foreach          ( $PIFS as $p                                           ) {
    if             ( $ID == 0                                              ) {
      if           ( strlen ( $p ) > 0                                     ) {
        array_push ( $LISTs , $p                                           ) ;
      }                                                                      ;
    } else                                                                   {
      array_push   ( $LISTs , $p                                           ) ;
    }                                                                        ;
    $ID  = $ID + 1                                                           ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $LISTs                                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SitePath ( )                                          {
  $HTTPS     = "http"                                                        ;
  if   ( isset ( $_SERVER['HTTPS'] ) )                                       {
    $H       = $_SERVER['HTTPS']                                             ;
    if ( $H == "on"                  )                                       {
      $HTTPS = "https"                                                       ;
    }                                                                        ;
  }                                                                          ;
  $HOSX      = $_SERVER['HTTP_HOST']                                         ;
  return "{$HTTPS}://{$HOSX}"                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function GetSessionValue ( $KEY , $DEFAULT )                   {
  if ( isset ( $_SESSION [ $KEY ] ) )                                        {
    return $_SESSION [ $KEY ]                                                ;
  }                                                                          ;
  $_SESSION [ $KEY ] = $DEFAULT                                              ;
  return $DEFAULT                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public static function GetSessionLists ( $KEY )                              {
  ////////////////////////////////////////////////////////////////////////////
  if ( ! isset ( $_SESSION [ $KEY ] ) )                                      {
    return array ( )                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $GSL = $_SESSION [ $KEY ]                                                  ;
  if ( strlen ( $GSL ) <= 0 )                                                {
    return array ( )                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return explode ( " , " , $GSL )                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public static function GetSessionValues ( $KEY )                             {
  ////////////////////////////////////////////////////////////////////////////
  $GSV = self::GetSessionLists ( $KEY )                                      ;
  if ( count ( $GSV ) <= 0 )                                                 {
    return $GSV                                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $GSX = array  (            )                                               ;
  foreach       ( $GSV as $G )                                               {
    $V = intval ( $G   , 10  )                                               ;
    array_push  ( $GSX , $V  )                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $GSX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
