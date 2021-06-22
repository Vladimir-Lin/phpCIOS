<?php
//////////////////////////////////////////////////////////////////////////////
// 三竹簡訊發送平台
// 網址：https://www.mitake.com.tw
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class SmsMitake extends SMS                                                  {
//////////////////////////////////////////////////////////////////////////////
function __construct  (                                                    ) {
  parent::__construct (                                                    ) ;
  $this -> Initialize (                                                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct   (                                                    ) {
  parent::__destruct  (                                                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
function Request        ( $URL , $PARAMS                                   ) {
  ////////////////////////////////////////////////////////////////////////////
  $JXON   = http_build_query ( $PARAMS                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HEADER = [ "Content-type: application/x-www-form-urlencoded" ]            ;
  ////////////////////////////////////////////////////////////////////////////
  $ch   = curl_init   (                                                    ) ;
  curl_setopt         ( $ch , CURLOPT_URL            , $URL                ) ;
  curl_setopt         ( $ch , CURLOPT_HTTPHEADER     , $HEADER             ) ;
  curl_setopt         ( $ch , CURLOPT_CUSTOMREQUEST  , "POST"              ) ;
  curl_setopt         ( $ch , CURLOPT_POSTFIELDS     , $JXON               ) ;
  curl_setopt         ( $ch , CURLOPT_RETURNTRANSFER , true                ) ;
  curl_setopt         ( $ch , CURLOPT_HEADER         , false               ) ;
  $RR  = curl_exec    ( $ch                                                ) ;
         curl_close   ( $ch                                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $RR                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
function Initialize   (                                                    ) {
  ////////////////////////////////////////////////////////////////////////////
  $KEY   = "SmsMitakeConf"                                                   ;
  $this -> ManagementURL  = ""                                               ;
  $this -> URL            = ""                                               ;
  $this -> Username       = ""                                               ;
  $this -> Password       = ""                                               ;
  $this -> CurrentCredits = 0                                                ;
  $this -> CurrentError   = ""                                               ;
  ////////////////////////////////////////////////////////////////////////////
  if                  ( ! array_key_exists ( $KEY , $GLOBALS )             ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $CONF  = $GLOBALS   [ $KEY                                               ] ;
  $this -> ManagementURL  = $CONF [ "Management" ]                           ;
  $this -> URL            = $CONF [ "Hostname"   ]                           ;
  $this -> Username       = $CONF [ "Username"   ]                           ;
  $this -> Password       = $CONF [ "Password"   ]                           ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
function ParseHttpLine              ( $LINE , $JSON                        ) {
  ////////////////////////////////////////////////////////////////////////////
  $LINE   = str_replace             ( "\r" , "" , $LINE                    ) ;
  $LINE   = str_replace             ( "\n" , "" , $LINE                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $AT     = strpos                  ( $LINE , "="                          ) ;
  if                                ( $AT == false                         ) {
    return $JSON                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $KEY    = substr                  ( $LINE , 0 , $AT                      ) ;
  $VALUE  = substr                  ( $LINE , $AT + 1                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSON [ $KEY ] = "{$VALUE}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  return $JSON                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
function ParseHttpResponses         ( $Response                            ) {
  ////////////////////////////////////////////////////////////////////////////
  $JSON    = array                  (                                      ) ;
  $LINEs   = explode                ( "\n" , $Response                     ) ;
  foreach                           ( $LINEs as $L                         ) {
    $JSON  = $this -> ParseHttpLine ( $L   , $JSON                         ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $JSON                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
function management   (                                                    ) {
  return $this -> ManagementURL                                              ;
}
//////////////////////////////////////////////////////////////////////////////
function login        (                                                    ) {
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
function error        (                                                    ) {
  return $this -> CurrentError                                               ;
}
//////////////////////////////////////////////////////////////////////////////
function credits      (                                                    ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> CurrentCredits = 0                                                ;
  $this -> CurrentError   = ""                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CMD        = $this -> URL                                                 ;
  $CMD        = "{$CMD}/api/mtk/SmQuery"                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $PARAMETERS = array ( "username" => $this -> Username                      ,
                        "password" => $this -> Password                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $RR         = $this -> Request ( $CMD , $PARAMETERS                      ) ;
  $JSON       = $this -> ParseHttpResponses ( $RR                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                  ( ! array_key_exists ( "AccountPoint" , $JSON ) )      {
    $this -> CurrentError = "Mitake did not answer current credits"          ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> CurrentCredits = intval ( $JSON [ "AccountPoint" ] , 10         ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> CurrentCredits                                             ;
}
//////////////////////////////////////////////////////////////////////////////
function send         ( $Phone , $Content , $Title = ""                    ) {
  ////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
