<?php

namespace CIOS\DB;

class DB
{

public $SQL ;

public function Connect($Host)
{
  $this -> SQL = new mysqli ( $Host [ "Hostname" ]   ,
                              $Host [ "Username" ]   ,
                              $Host [ "Password" ]   ,
                              $Host [ "Database" ] ) ;
  if ( mysqli_connect_errno ( ) ) return false       ;
  return true                                        ;
}

public function Close()
{
  return $this -> SQL -> close ( ) ;
}

public function Query($CMD)
{
  return $this -> SQL -> query ( $CMD ) ;
}

?>
