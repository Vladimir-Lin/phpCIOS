<?php
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
use Gnello\OpenFireRestAPI\Client as Client                                  ;
//////////////////////////////////////////////////////////////////////////////
class OpenFire                                                               {
//////////////////////////////////////////////////////////////////////////////
public $client                                                               ;
public $Database                                                             ;
public $Response                                                             ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear ( )                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> Database = "openfire"                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function Table ( $table )                                             {
  $DBT = $this -> Database                                                   ;
  return "`{$DBT}`.`{$table}`"                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function loginAdmin ( $account )                                      {
  $this -> client = new Client( [ 'client' => $account , 'guzzle' => [ ] ] ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Protocol ( )                                                 {
  $PROTOCOL   = "http"                                                       ;
  if ( isset($_SERVER['HTTPS']) && ( $_SERVER['HTTPS'] === 'on' ) )          {
    $PROTOCOL = "https"                                                      ;
  }                                                                          ;
  return $PROTOCOL                                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function Password ( $DB , $user )                                     {
  $TBL = $this -> Table  ( "ofuser" )                                        ;
  $QQ = "select `plainPassword` from {$TBL} where `username` = '{$user}' ;"  ;
  return $DB -> FetchOne ( $QQ      )                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function Create ( $username                                           ,
                         $password                                           ,
                         $name  = ""                                         ,
                         $email = ""                                         ,
                         $group = ""                                         )
{
  if ( strlen ( $username ) <= 0 ) return false                              ;
  if ( strlen ( $password ) <= 0 ) return false                              ;
  $CUA         = array ( )                                                   ;
  $CUA [ "username" ] = $username                                            ;
  $CUA [ "password" ] = $password                                            ;
  if ( strlen ( $name  ) > 0 ) $CUA [ "name"  ] = $name                      ;
  if ( strlen ( $email ) > 0 ) $CUA [ "email" ] = $email                     ;
  return $this -> CreateUser ( $CUA , $group )                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function CreateUser ( $user , $group = "" )
{
  $RESP = $this -> client -> getUserModel ( ) -> createUser ( $user )        ;
  $this -> Response = $RESP                                                  ;
  if ( $RESP -> getStatusCode ( ) != 201 )                                   {
    return false                                                             ;
  }                                                                          ;
  if ( strlen ( $group ) > 0 )                                               {
    return $this -> JoinGroup ( $user [ "username" ] , $group )              ;
  }                                                                          ;
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function JoinGroup ( $user , $group )                                 {
  if ( strlen ( $group ) <= 0 ) return false                                 ;
  $RESP = $this -> client -> getUserModel ( ) -> addUserToGroup ( $user , $group ) ;
  $this -> Response = $RESP                                                  ;
  if ( $RESP -> getStatusCode ( ) == 201 )                                   {
    return true                                                              ;
  }                                                                          ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
