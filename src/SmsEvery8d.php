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
function Initialize   (                                                    ) {
  ////////////////////////////////////////////////////////////////////////////
  $KEY   = "SmsEvery8dConf"                                                  ;
  $this -> ManagementURL  = ""                                               ;
  $this -> LoginURL       = ""                                               ;
  $this -> URL            = ""                                               ;
  $this -> Username       = ""                                               ;
  $this -> Password       = ""                                               ;
  $this -> Cust           = ""                                               ;
  $this -> CurrentCredits = 0                                                ;
  $this -> CurrentError   = ""                                               ;
  $this -> XML            = null                                             ;
  ////////////////////////////////////////////////////////////////////////////
  if                  ( ! array_key_exists ( $KEY , $GLOBALS )             ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $CONF  = $GLOBALS   [ $KEY                                               ] ;
  $this -> ManagementURL  = $CONF [ "Management" ]                           ;
  $this -> LoginURL       = $CONF [ "Login"      ]                           ;
  $this -> URL            = $CONF [ "Hostname"   ]                           ;
  $this -> Username       = $CONF [ "Username"   ]                           ;
  $this -> Password       = $CONF [ "Password"   ]                           ;
  $this -> Cust           = $CONF [ "Cust"       ]                           ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
function management   (                                                    ) {
  return $this -> ManagementURL                                              ;
}
//////////////////////////////////////////////////////////////////////////////
function login        (                                                    ) {
  ////////////////////////////////////////////////////////////////////////////
  // 登入Every8d帳戶
  ////////////////////////////////////////////////////////////////////////////
  $this -> CurrentError = ""                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $PARAMS = array                                                            (
    "custID"   => $this -> Cust                                              ,
    "userID"   => $this -> Username                                          ,
    "password" => $this -> Password                                          ,
    "APIType"  => ""                                                         ,
    "version"  => ""                                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  try                                                                        {
    $CLIENT      = new \SoapClient      ( $this -> LoginURL )                ;
    $RESULT      = $CLIENT -> Login     ( $PARAMS           )                ;
    $XMLSTR      = $RESULT -> LoginResult                                    ;
    //////////////////////////////////////////////////////////////////////////
    // 取得登入結果
    //////////////////////////////////////////////////////////////////////////
    $this -> XML = new \SimpleXMLElement ( $XMLSTR           )               ;
    if ( $this -> XML -> ERROR_CODE == "0000" )                              {
      $this -> CurrentCredits = $this -> XML -> CREDIT                       ;
      return true                                                            ;
    } else                                                                   {
      $this -> CurrentError = (string) $this -> XML -> DESC [ 0 ]            ;
    }                                                                        ;
  } catch ( Exception $e )                                                   {
    $this -> CurrentError = "Failure to create a SOAP client for Every8d"    ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
function error        (                                                    ) {
  return $this -> CurrentError                                               ;
}
//////////////////////////////////////////////////////////////////////////////
function credits      (                                                    ) {
  return $this -> CurrentCredits                                             ;
}
//////////////////////////////////////////////////////////////////////////////
function send         ( $Phone , $Content , $Title = ""                    ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> CurrentError = ""                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $UserNo    = $this -> XML -> USER_NO                                       ; // 從登入結果取得UserNo
  $CompanyNo = $this -> XML -> COMPANY_NO                                    ; // 從登入結果取得Company_No
  $Credit    = $this -> XML -> CREDIT                                        ; // 從登入結果取得目前剩餘額度
  ////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////
  $SML  = '<REPS VER="2.0"><IP></IP><CARD_NO/>'                              ;
  $SML .= '<USER NAME="" '                                                   ;
  $SML .= 'MOBILE="' . $Phone . '" '                                         ; // 電話號碼
  $SML .= 'EMAIL="" SENDTIME="" PARAM="" MR=""/>'                            ;
  $SML .= '</REPS>'                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PARAMS = array                                                            (
    "custID"      => $this -> Cust                                           ,
    "CompanyNo"   => $CompanyNo                                              ,
    "userNo"      => $UserNo                                                 ,
    "sendtype"    => "110"                                                   ,
    "msgCategory" => "10"                                                    ,
    "subject"     => ""                                                      ,
    "content"     => $Content                                                ,
    "image"       => ""                                                      ,
    "Audio"       => ""                                                      ,
    "xml"         => $SML                                                    ,
    "batchID"     => ""                                                      ,
    "certified"   => ""                                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 發送簡訊
  ////////////////////////////////////////////////////////////////////////////
  $XMS    = new \SoapClient    ( $this -> URL )                              ;
  $RESULT = $XMS    -> QueueIn ( $PARAMS      )                              ;
  $STR    = $RESULT -> QueueInResult                                         ;
  if ( substr ( $STR , 0 , 1 ) == "-" )                                      {
    $this -> CurrentError = "Failure to send message to phone {$Phone}"      ;
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
