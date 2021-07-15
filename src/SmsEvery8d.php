<?php
//////////////////////////////////////////////////////////////////////////////
// 互動資通簡訊發送平台
// 網址：http://www.every8d.com
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class SmsEvery8d extends SMS                                                 {
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
  $KEY   = "SmsEvery8dConf"                                                  ;
  $this -> ManagementURL  = ""                                               ;
  $this -> URL            = ""                                               ;
  $this -> Username       = ""                                               ;
  $this -> Password       = ""                                               ;
  $this -> CurrentCredits = 0                                                ;
  $this -> CurrentError   = ""                                               ;
  $this -> JSON           = array ( )                                        ;
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
  $CMD        = "{$CMD}/API21/HTTP/getCredit.ashx"                           ;
  ////////////////////////////////////////////////////////////////////////////
  $PARAMETERS = array ( "UID" => $this -> Username                           ,
                        "PWD" => $this -> Password                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $RR         = $this -> Request ( $CMD , $PARAMETERS                      ) ;
  $CREDITZ    = intval           ( $RR , 10                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                             ( $CREDITZ < 0                            ) {
    $this -> CurrentError = "Every8d did not answer current credits"         ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> CurrentCredits = $CREDITZ                                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> CurrentCredits                                             ;
}
//////////////////////////////////////////////////////////////////////////////
function send                 ( $Phone , $Content , $Title = ""            ) {
  ////////////////////////////////////////////////////////////////////////////
  $this   -> CurrentError = ""                                               ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( strlen ( $Phone ) <= 0                     ) {
    $this -> CurrentError = "SMS requires a valid phone number"              ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( strlen ( $Content ) <= 0                   ) {
    $this -> CurrentError = "SMS requires content"                           ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $CMD     = $this -> URL                                                    ;
  $CMD     = "{$CMD}/API21/HTTP/sendSMS.ashx"                                ;
  $PARAMETERS =  array                                                       (
    "UID"     => $this -> Username                                           ,
    "PWD"     => $this -> Password                                           ,
    "DEST"    => $Phone                                                      ,
    "MSG"     => $Content                                                    ,
  )                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $RR      = $this -> Request ( $CMD , $PARAMETERS                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( strlen ( $RR ) <= 0                        ) {
    $this -> CurrentError = "HTTP return text is empty"                      ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ANSZ    = explode          ( "," , $RR                                  ) ;
  if                          ( count ( $ANSZ ) < 5                        ) {
    $this -> CurrentError = "HTTP Response format did not match API document" ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $CREDITZ = intval           ( $ANSZ [ 0 ] , 10                           ) ;
  $this        -> JSON = array                                               (
    "CREDIT"   => $CREDITZ                                                   ,
    "SENDED"   => $ANSZ [ 1 ]                                                ,
    "COST"     => $ANSZ [ 2 ]                                                ,
    "UNSEND"   => $ANSZ [ 3 ]                                                ,
    "BATCH_ID" => $ANSZ [ 4 ] ,                                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( $CREDITZ < 0                               ) {
    $this -> CurrentError = "Unknown mistake : {$RR}"                        ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> CurrentCredits = $CREDITZ                                         ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
