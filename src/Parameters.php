<?php

namespace CIOS ;

class Parameters
{

public function hasParameter($KEY)
{
  if ( isset ( $_GET  [ $KEY ] ) ) return true ;
  if ( isset ( $_POST [ $KEY ] ) ) return true ;
  return false                                 ;
}

public function Parameter($KEY)
{
  if ( isset ( $_GET  [ $KEY ] ) ) {
    return $_GET  [ $KEY ]         ;
  }                                ;
  if ( isset ( $_POST [ $KEY ] ) ) {
    return $_POST [ $KEY ]         ;
  }                                ;
  return ""                        ;
}

public function Variables($KEY,$Split)
{
  if ( ! $this -> hasParameter ( $KEY ) )     {
    return array ( )                          ;
  }                                           ;
  $PP = $this -> Parameter ( $KEY )           ;
  if ( strlen ( $PP ) <= 0 ) return array ( ) ;
  return explode ( $Split , $PP )             ;
}

public function Listings($KEY,$Split)
{
  if ( ! isset ( $_SESSION [ $KEY ] ) )       {
    return array ( )                          ;
  }                                           ;
  $PP = $_SESSION [ $KEY ]                    ;
  if ( strlen ( $PP ) <= 0 ) return array ( ) ;
  return explode ( $Split , $PP )             ;
}

public function hasCookie($KEY)
{
  return isset ( $_COOKIE [ $KEY ] ) ;
}

public function Cookie($KEY)
{
  if ( ! $this -> hasCookie ( $KEY ) ) {
    return ""                          ;
  }                                    ;
  return $_COOKIE [ $KEY ]             ;
}

public function hasSession($KEY)
{
  return isset ( $_SESSION [ $KEY ] ) ;
}

public static function Contains($UU,$ID)
{
  return in_array ( $ID , $UU ) ;
}

public static function Remove($UU,$ID)
{
  $INDEX = array_search ( $ID , $UU        ) ;
  if                    ( $INDEX !== false ) {
    unset               ( $UU [ $INDEX ]   ) ;
  }                                          ;
  return $UU                                 ;
}

public static function JoinArray($AA,$BB)
{
  if ( count ( $BB ) <= 0 ) return $AA ;
  foreach ( $BB as $bb )               {
    if ( ! in_array ( $bb , $AA ) )    {
      array_push ( $AA , $bb )         ;
    }                                  ;
  }                                    ;
  return $AA                           ;
}

public static function Exclude($AA,$BB)
{
  if ( count ( $BB ) <= 0 ) return $AA ;
  $CC = array ( )                      ;
  foreach ( $AA as $aa )               {
    if ( ! in_array ( $aa , $BB ) )    {
      array_push ( $CC , $aa )         ;
    }                                  ;
  }                                    ;
  return $CC                           ;
}

public static function TakeUuid($UUIDs,$START,$TOTAL)
{
  $UU = array ( )                       ;
  $IX = $START                          ;
  $TT = count ( $UUIDs )                ;
  $TT = $TT - $START                    ;
  if ( $TT <= 0 ) return $UU            ;
  if ( $TOTAL < $TT ) $TT = $TOTAL      ;
  for ( $i = 0 ; $i < $TT ; $i++ )      {
    array_push ( $UU , $UUIDs [ $IX ] ) ;
    $IX = $IX + 1                       ;
  }                                     ;
  return $UU                            ;
}

public function toLocality($LL)
{
  return gmp_mod ( $LL , 100000 ) ;
}

public function asLanguage($L)
{
  $SL = "{$L}"                   ;
  $LL = ""                       ;
  if ( strlen ($SL) == 4 )       {
    $LL = "190000000000000{$SL}" ;
  } else                         {
    $LL = "1900000000000001001"  ;
  }                              ;
  return $LL                     ;
}

public static function isEnglish ( $S )
{
  $S = trim ( $S )                   ;
  if ( strlen ( $S ) <= 0 ) return 0 ;
  $M = mb_strlen ( $S , 'utf-8' )    ;
  $L = strlen    ( $S           )    ;
  if ( $L == $M ) return 1           ;
  return 2                           ;
}

public static function isChinese($NAME)
{
  return preg_match ( "/[\x{4e00}-\x{9fa5}]+/u" , $NAME ) ;
}

}

?>
