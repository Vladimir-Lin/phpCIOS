<?php

namespace CIOS ;

class Events
{

public $LINES = [ ] ;

function __construct()
{
}

function __destruct()
{
}

public function Pair ( $KEY , $VALUE )
{
  return "\"{$KEY}\": {$VALUE}" ;
}

public function DqPair ( $KEY , $VALUE )
{
  $VALUE = str_replace ( "\\" , "\\\\" , $VALUE ) ;
  $VALUE = str_replace ( "\"" , "\\\"" , $VALUE ) ;
  $VALUE = str_replace ( "\n" , "\\n"  , $VALUE ) ;
  $VALUE = str_replace ( "\t" , "\\t"  , $VALUE ) ;
  return "\"{$KEY}\": \"{$VALUE}\""               ;
}

public function AddPair ( $KEY , $VALUE )
{
  array_push ( $LINES , $this -> Pair ( $KEY , $VALUE ) ) ;
}

public function AddDqPair ( $KEY , $VALUE )
{
  array_push ( $LINES , $this -> DqPair ( $KEY , $VALUE ) ) ;
}

public function Content ( )
{
  $ITEMS = implode ( " ,\n" , $this -> LINES ) ;
  return "{\n{$ITEMS}\n}"                      ;
}

}

?>
