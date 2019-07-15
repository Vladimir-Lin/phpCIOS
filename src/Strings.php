<?php

namespace CIOS ;

class Strings
{

public $String   ;
public $Listings ;

function __construct( $s = "" )
{
  $this -> clear ( )   ;
  $this -> String = $s ;
}

function __destruct()
{
  unset ( $this -> Listings ) ;
}

public function clear ( )
{
  $this -> String = "" ;
  unset ( $this -> Listings ) ;
}

public function toLower ( )
{
  $this -> String = strtolower ( $this -> String ) ;
  return $this -> String                           ;
}

public function toUpper ( )
{
  $this -> String = strtoupper ( $this -> String ) ;
  return $this -> String                           ;
}

public function count ( )
{
  return count ( $this -> Listings ) ;
}

public function split ( $key )
{
  $this -> Listings = explode ( $key , $this -> String ) ;
}

public function at ( $index )
{
  $cnt = $this -> count ( )           ;
  if ( $index >= $cnt ) return ""     ;
  return $this -> Listings [ $index ] ;
}

public static function ReplaceTranslations ( $SOURCE , $REPLACES )
{
  $Translations = $GLOBALS [ "Translations" ]   ;
  $SRCS = $SOURCE                               ;
  $KEYS = array_keys      ( $REPLACES         ) ;
  foreach                 ( $KEYS as $K       ) {
    $VAL  = $REPLACES     [ $K                ] ;
    $MSG  = $Translations [ $VAL              ] ;
    $SRCS = str_replace   ( $K , $MSG , $SRCS ) ;
  }                                             ;
  return $SRCS                                  ;
}

public static function ReplaceByKeys($SOURCE,$REPLACES)
{
  $SRCS = $SOURCE                             ;
  $KEYS = array_keys    ( $REPLACES         ) ;
  foreach               ( $KEYS as $K       ) {
    $VAL  = $REPLACES   [ $K                ] ;
    $SRCS = str_replace ( $K , $VAL , $SRCS ) ;
  }                                           ;
  return $SRCS                                ;
}

public static function ReplaceFileByKeys($FILENAME,$REPLACES)
{
  $CMHR = file_get_contents  ( $FILENAME         ) ;
  return self::ReplaceByKeys ( $CMHR , $REPLACES ) ;
}

public static function ReportJSON ( $JSON )
{
  $PAIRS = array      (                       ) ;
  $KEYs  = array_keys ( $JSON                 ) ;
  foreach             ( $KEYs as $K           ) {
    $V   = "\"{$K}\""                           ;
    $W   = $JSON [ $K ]                         ;
    $Z   = "\"{$W}\""                           ;
    array_push        ( $PAIRS , "{$V}: {$Z}" ) ;
  }                                             ;
  $TEXT  = implode    ( ",\n" , $PAIRS        ) ;
  return "{\n" . $TEXT . "\n}"                  ;
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

public static function JsonNaming ( $NAME )
{
  $NAME = str_replace ( "\r" , ""     , $NAME ) ;
  $NAME = str_replace ( "\n" , "\\n"  , $NAME ) ;
  $NAME = str_replace ( "\t" , " "    , $NAME ) ;
  $NAME = str_replace ( "\"" , "\\\"" , $NAME ) ;
  $NAME = str_replace ( "\\" , "\\\\" , $NAME ) ;
  return $NAME                                  ;
}

public static function Replacement ( $NAME )
{
  $NAME = str_replace ( "\r" , ""     , $NAME ) ;
  $NAME = str_replace ( "\n" , ""     , $NAME ) ;
  $NAME = str_replace ( "\t" , " "    , $NAME ) ;
  $NAME = str_replace ( "\"" , "\\\"" , $NAME ) ;
  return $NAME                                  ;
}

public static function LoginWords ( $NAME )
{
  $NAME = str_replace ( "\r" , "" , $NAME ) ;
  $NAME = str_replace ( "\n" , "" , $NAME ) ;
  $NAME = str_replace ( "\t" , "" , $NAME ) ;
  $NAME = str_replace ( "\"" , "" , $NAME ) ;
  $NAME = str_replace ( "\\" , "" , $NAME ) ;
  $NAME = str_replace ( "'"  , "" , $NAME ) ;
  $NAME = str_replace ( "`"  , "" , $NAME ) ;
  return trim         ( $NAME             ) ;
}

}

?>
