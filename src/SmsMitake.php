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
function toPhone                    ( $Phone                               ) {
  ////////////////////////////////////////////////////////////////////////////
  if                                ( strlen ( $Phone ) <= 0               ) {
    return ""                                                                ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if                                ( strpos ( $Phone , "+886-" ) != false ) {
    $Phone = str_replace            ( "+886-" , "0" , $Phone               ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $Phone   = str_replace            ( "-" , "" , $Phone                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                                ( strlen ( $Phone ) == 10              ) {
    $HEAD  = substr                 ( $Phone , 0 , 2                       ) ;
    if                              ( $HEAD == "09"                        ) {
      if                            ( strpos ( $Phone , "-" ) == false     ) {
        if                          ( strpos ( $Phone , "+" ) == false     ) {
          return $Phone                                                      ;
        }                                                                    ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return ""                                                                  ;
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
function send                 ( $Phone , $Content , $Title = ""            ) {
  ////////////////////////////////////////////////////////////////////////////
  $PN      = $this -> toPhone ( $Phone                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( strlen ( $PN ) <= 0                        ) {
    $this -> CurrentError = "SMS requires a valid phone number"              ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( strlen ( $Content ) <= 0                   ) {
    $this -> CurrentError = "SMS requires content"                           ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this   -> CurrentError = ""                                               ;
  $BODY    = $Content                                                        ;
  $BODY    = str_replace      ( "\n" , "\x06" , $BODY                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CMD     = $this -> URL                                                    ;
  $CMD     = "{$CMD}/api/mtk/SmSend"                                         ;
  $PARAMETERS    =  array                                                    (
    "CharsetURL" => "UTF-8"                                                  ,
    "username"   => $this -> Username                                        ,
    "password"   => $this -> Password                                        ,
    "dstaddr"    => $PN                                                      ,
    "smbody"     => $BODY                                                    ,
  )                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $RR      = $this -> Request ( $CMD , $PARAMETERS                         ) ;
  $JSON    = $this -> ParseHttpResponses ( $RR                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                  ( ! array_key_exists ( "statuscode" , $JSON ) )        {
    $this -> CurrentError = "Mitake did not answer current status code"      ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $Status     = $JSON [ "statuscode"                                       ] ;
  if ( ! in_array ( $Status , [ "0" , "1" , "2" , "4" ] ) )                  {
    $this -> CurrentError = $Status                                          ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
