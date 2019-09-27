<?php

namespace CIOS ;

class Firebase {

public $ServerKey ;
public $FCM       ;

function __construct()
{
  $this -> ServerKey = "AAAA6LpY9YE:APA91bHYmy0DN0qYCvLEz_V8DRt5oNFuKRiqFS8Yky4GNumrxjSIfwQ8mhDFTfsEdhNkJjGcmt5nZztFeoFpBBBRGVAZR6i13Po-ssgkNBuBDEbPEgO8UIDoWPBbqkkn2x9YcLZkuxtR" ;
  $this -> FCM       = "https://fcm.googleapis.com/fcm/send" ;
}

function __destruct()
{
}

public function AuthorizationHeader ( )
{
  $SK = $this -> ServerKey          ;
  return "Authorization: key={$SK}" ;
}

public function UpdateToken ( $DB , $HH , $AA )
{
  ////////////////////////////////////////////////////////////////////////////
  $TABLE = "`history`.`firebase`"                                            ;
  $UUID  = $HH -> Parameter ( "Uuid"  )                                      ;
  $TOKEN = $HH -> Parameter ( "Token" )                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "insert into {$TABLE} ( `uuid` , `token` ) values"                .
           " ( {$UUID} , '{$TOKEN}' ) ;"                                     ;
  $DB   -> Query            ( $QQ     )                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $AA [ "Answer" ] = "Yes"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  return $AA                                                                 ;
}

public function SendSingleUser ( $DB , $HH , $AA )
{
  ////////////////////////////////////////////////////////////////////////////
  $Title       = $HH -> Parameter ( "Title" ) ;
  $Body        = $HH -> Parameter ( "Body"  ) ;
  $Icon        = $HH -> Parameter ( "Icon"  ) ;
  $URL         = $HH -> Parameter ( "URL"   ) ;
  $User        = $HH -> Parameter ( "User"  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $Content     = array            ( ) ;
  $Fields      = array            ( ) ;
  $Headers     = array            ( ) ;
  ////////////////////////////////////////////////////////////////////////////
  $PNAH        = $this -> AuthorizationHeader ( ) ;
  $CTAJ        = "Content-Type: application/json" ;
  array_push                      ( $Headers , $PNAH ) ;
  array_push                      ( $Headers , $CTAJ ) ;
  ////////////////////////////////////////////////////////////////////////////
  $Content [ "title" ] = $Title ;
  $Content [ "body"  ] = $Body  ;
  if ( strlen ( $Icon ) > 0 ) $Content [ "icon"         ] = $Icon            ;
  if ( strlen ( $URL  ) > 0 ) $Content [ "click_action" ] = $URL             ;
  ////////////////////////////////////////////////////////////////////////////
  $Fields  [ "to"    ] = $User  ;
  $Fields  [ "notification" ] = $Content  ;
  ////////////////////////////////////////////////////////////////////////////
  $FILEDS = json_encode ( $Fields ) ;
  ////////////////////////////////////////////////////////////////////////////
  $ch     = curl_init (                                                    ) ;
  curl_setopt         ( $ch , CURLOPT_URL            , $this -> FCM );
  curl_setopt         ( $ch , CURLOPT_POST           , true );
  curl_setopt         ( $ch , CURLOPT_HTTPHEADER     , $Headers );
  curl_setopt         ( $ch , CURLOPT_RETURNTRANSFER , true );
  curl_setopt         ( $ch , CURLOPT_SSL_VERIFYPEER , false );
  curl_setopt         ( $ch , CURLOPT_POSTFIELDS     , $FILEDS );
  $result = curl_exec ( $ch ) ;
  curl_close          ( $ch ) ;
  ////////////////////////////////////////////////////////////////////////////
  $AA [ "Message" ] = $result ;
  $AA [ "Answer"  ] = "Yes" ;
  ////////////////////////////////////////////////////////////////////////////
  return $AA                                                                 ;
}


}
?>
