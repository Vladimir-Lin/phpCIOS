<?php
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class MMS                                                                    {
//////////////////////////////////////////////////////////////////////////////
// Every8D 帳號密碼
//////////////////////////////////////////////////////////////////////////////
protected $Management                                                        ;
protected $LoginURL                                                          ;
protected $SmsURL                                                            ;
protected $Username                                                          ;
protected $Password                                                          ;
protected $Cust                                                              ;
protected $XML                                                               ;
//////////////////////////////////////////////////////////////////////////////
public    $Phone                                                             ;
public    $Sender                                                            ;
public    $Title                                                             ;
public    $Message                                                           ;
public    $Credits                                                           ;
//////////////////////////////////////////////////////////////////////////////
function __construct( )                                                      {
  $this -> Clear ( )                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct( )                                                       {
}
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> Management = "https://tw.every8d.com/every8d30/sms/SendMessage.aspx" ;
  $this -> LoginURL   = "http://tw.every8d.com/API20/Security.asmx?wsdl"     ;
  $this -> SmsURL     = "http://tw.every8d.com/API20/Message.asmx?wsdl"      ;
  $this -> Username   = "0918220677"                                         ;
  $this -> Password   = "1349ac0517s"                                        ;
  // $this -> Password   = "007071"                                             ;
  $this -> Cust       = "av8d20"                                             ;
  $this -> Credits    = 0                                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function setSecret ( $USERNAME , $PASSWORD )                          {
  $this -> Username = $USERNAME                                              ;
  $this -> Password = $PASSWORD                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function ManagerURL ( )                                               {
  return $this -> Management                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function Login ( )                                                    {
  ////////////////////////////////////////////////////////////////////////////
  // 登入Every8d帳戶
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
      $this -> Credits = $this -> XML -> CREDIT                              ;
      return true                                                            ;
    }                                                                        ;
  } catch ( Exception $e )                                                   {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function Send ( $NUMBER                                               ,
                       $SUBJECT                                              ,
                       $CONTENT                                              ,
                       $NAME     = ""                                        ,
                       $EMAIL    = ""                                        ,
                       $DATETIME = ""                                        ,
                       $PARAMS   = ""                                        ,
                       $MR       = ""                                      ) {
//////////////////////////////////////////////////////////////////////////////
  $UserNo    = $this -> XML -> USER_NO                                       ; // 從登入結果取得UserNo
  $CompanyNo = $this -> XML -> COMPANY_NO                                    ; // 從登入結果取得Company_No
  $Credit    = $this -> XML -> CREDIT                                        ; // 從登入結果取得目前剩餘額度
  ////////////////////////////////////////////////////////////////////////////
  $SML  = '<REPS VER="2.0">'                                                 ;
  $SML .= '<IP></IP>'                                                        ;
  $SML .= '<CARD_NO/>'                                                       ;
  $SML .= '<USER '                                                           ;
  $SML .= 'NAME="'     . $NAME     . '" '                                    ; // 發送人名
  $SML .= 'MOBILE="'   . $NUMBER   . '" '                                    ; // 電話號碼
  $SML .= 'EMAIL="'    . $EMAIL    . '" '                                    ; // 順便發送的電子郵件
  $SML .= 'SENDTIME="' . $DATETIME . '" '                                    ; // 指定的發送時間
  $SML .= 'PARAM="'    . $PARAMS   . '" '                                    ; // 參數
  $SML .= 'MR="'       . $MR       . '"'                                     ; // 批次發送獨特碼
  $SML .= '/>'                                                               ;
  $SML .= '</REPS>'                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PARAMS = array                                                            (
    "custID"      => $this -> Cust                                           ,
    "CompanyNo"   => $CompanyNo                                              ,
    "userNo"      => $UserNo                                                 ,
    "sendtype"    => "110"                                                   ,
    "msgCategory" => "10"                                                    ,
    "subject"     => $SUBJECT                                                ,
    "content"     => $CONTENT                                                ,
    "image"       => ""                                                      ,
    "Audio"       => ""                                                      ,
    "xml"         => $SML                                                    ,
    "batchID"     => ""                                                      ,
    "certified"   => ""                                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 發送簡訊
  ////////////////////////////////////////////////////////////////////////////
  $SMS    = new \SoapClient    ( $this -> SmsURL )                           ;
  $RESULT = $SMS    -> QueueIn ( $PARAMS         )                           ;
  $STR    = $RESULT -> QueueInResult                                         ;
  if ( substr ( $STR , 0 , 1 ) == "-" ) return false                         ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function CompactTd ( $HD                                            ) {
  $HD -> AddPair          ( "nowrap" , "nowrap"                            ) ;
  $HD -> AddPair          ( "width"  , "3%"                                ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function appendInput ( $HD,$VALUE="",$ID="",$CLASSID="NameInput"    ) {
  $HI  = $HD -> addInput    ( $VALUE                                       ) ;
  $HI -> SafePair           ( "id"    , $ID                                ) ;
  $HI -> SafePair           ( "class" , $CLASSID                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function appendArea ( $HD,$VALUE="",$ID="",$CLASSID="MmsArea"       ) {
  $TA  = $HD -> addHtml    ( "textarea"                                    ) ;
  $TA -> SafePair          ( "id"    , $ID                                 ) ;
  $TA -> SafePair          ( "class" , $CLASSID                            ) ;
  $TA -> AddPair           ( "rows"  , "5"                                 ) ;
  $TA -> AddPair           ( "cols"  , "120"                               ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function appendPhone ( $HR,$ID="PhoneNumber",$CLASSID="NameInput"   ) {
  global $Translations                                                       ;
  $HD    = $HR    -> addTd  ( $Translations [ "MMS::Phone" ]               ) ;
  $HD    = $HR    -> addTd  (                                              ) ;
  $this -> appendInput      ( $HD , $this -> Phone , $ID , $CLASSID        ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function appendSender ( $HR,$ID="Name",$CLASSID="NameInput"         ) {
  global $Translations                                                       ;
  $HD    = $HR    -> addTd   ( $Translations [ "MMS::Sender" ]             ) ;
  $HD    = $HR    -> addTd   (                                             ) ;
  $this -> appendInput       ( $HD , $this -> Sender , $ID , $CLASSID      ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function appendTitle ( $HR,$ID="Subject",$CLASSID="NameInput"       ) {
  global $Translations                                                       ;
  $HD    = $HR    -> addTd  ( $Translations [ "MMS::Subject" ]             ) ;
  $HD    = $HR    -> addTd  (                                              ) ;
  $this -> appendInput      ( $HD , $this -> Title , $ID , $CLASSID        ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function appendContent ( $HR,$ID="Content",$CLASSID="MmsArea"       ) {
  global $Translations                                                       ;
  $HD    = $HR    -> addTd    ( $Translations [ "MMS::Content" ]           ) ;
  $HD    = $HR    -> addTd    (                                            ) ;
  $this -> appendArea         ( $HD , $this -> Message , $ID , $CLASSID    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ClearButton (                                              ) {
  global $Translations                                                       ;
  $BTN  = new HtmlTag       (                                              ) ;
  $BTN -> setTag            ( "button"                                     ) ;
  $BTN -> AddPair           ( "class"   , "SelectionButton"                ) ;
  $BTN -> AddPair           ( "onclick" , "ClearSMS() ;"                   ) ;
  $BTN -> AddText           ( $Translations [ "MMS::Clear" ]               ) ;
  return $BTN                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function SendButton (                                               ) {
  global $Translations                                                       ;
  $BTN  = new HtmlTag      (                                               ) ;
  $BTN -> setTag           ( "button"                                      ) ;
  $BTN -> AddPair          ( "class"   , "SelectionButton"                 ) ;
  $BTN -> AddPair          ( "onclick" , "SendSMS() ;"                     ) ;
  $BTN -> AddText          ( $Translations [ "MMS::Send" ]                 ) ;
  return $BTN                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function SmsTable               (                                   ) {
  ////////////////////////////////////////////////////////////////////////////
  $HT     = new HtmlTag                (                                   ) ;
  $TBODY  = $HT      -> ConfigureTable (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  $this  -> appendPhone                ( $HR , "PhoneNumber" , "NameInput" ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  $this  -> appendSender               ( $HR , "Name" , "NameInput"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  $this  -> appendTitle                ( $HR , "Subject" , "NameInput"     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  $HD     = $HR    -> addTd            ( "&nbsp;"                          ) ;
  $HD     = $HR    -> addTd            ( "&nbsp;"                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  $this  -> appendContent              ( $HR , "Content" , "MmsArea"       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  $HD     = $HR    -> addTd            ( "&nbsp;"                          ) ;
  $HD     = $HR    -> addTd            ( "&nbsp;"                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr            (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD     = $HR    -> addTd            (                                   ) ;
  $HD    -> AddPair                    ( "align" , "center"                ) ;
  $HD    -> AddTag                     ( $this -> ClearButton ( )          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD     = $HR    -> addTd            (                                   ) ;
  $HD    -> AddPair                    ( "align" , "center"                ) ;
  $HD    -> AddTag                     ( $this -> SendButton ( )           ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function InformationTable     (                                     ) {
  $TABLE  = new HtmlTag              (                                     ) ;
  $TBODY  = $TABLE -> ConfigureTable ( 1 , 0 , 0                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Management"                   ) ;
  $HD     = $TBODY -> addTd          (                                     ) ;
  $HDA    = $HD    -> addHtml        (                                     ) ;
  $HDA   -> setTag                   ( "a"                                 ) ;
  $HDA   -> AddPair                  ( "target" , "_blank"                 ) ;
  $HDA   -> AddPair                  ( "href"   , $this -> Management      ) ;
  $HDA   -> AddText                  (            $this -> Management      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Credit"                       ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> CREDIT              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Account"                      ) ;
  $HD     = $TBODY -> addTd          ( $this -> Username                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Password"                     ) ;
  $HD     = $TBODY -> addTd          ( $this -> Password                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Company"                      ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> COMPANY_NO          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::User"                         ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> USER_NO             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Username"                     ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> USER_NAME           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Mobile"                       ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> MOBILE              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Upload"                       ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> UPLOAD_FILE_URL     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $TBODY -> addTagTd       ( "MMS::Deposit"                      ) ;
  $HD     = $TBODY -> addTd          ( $this -> XML -> SPECIAL_ACCOUNT     ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $TABLE                                                              ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
