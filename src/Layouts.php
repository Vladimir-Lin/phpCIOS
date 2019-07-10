<?php

namespace CIOS ;

class Layouts
{

public $MAIN    ;
public $TABLE   ;
public $TBODY   ;
public $TRs     ;
public $PROFILE ;
public $Objects ;

public function __construct()
{
  $this -> Clear ( ) ;
}

public function __destruct()
{
  unset ( $this -> MAIN    ) ;
  unset ( $this -> TABLE   ) ;
  unset ( $this -> TBODY   ) ;
  unset ( $this -> TRs     ) ;
  unset ( $this -> PROFILE ) ;
  unset ( $this -> Objects ) ;
}

public function Clear()
{
  $this -> TRs     = array ( ) ;
  $this -> Objects = array ( ) ;
}

public function setObject($INDEX,$OBJECT)
{
  $this -> Objects [ $INDEX ] = $OBJECT ;
}

public function getObject($INDEX)
{
  return $this -> Objects [ $INDEX ] ;
}

public function Create ( $PART = "onepiece" )
{
  $this -> MAIN   = new Html                (                ) ;
  $this -> TABLE  = new Html                (                ) ;
  $this -> MAIN  -> AddTag                  ( $this -> TABLE ) ;
  $this -> MAIN  -> setMain                 ( $PART          ) ;
  $TT    = $this -> TABLE -> ConfigureTable (                ) ;
  $this -> TBODY  = $TT                                        ;
}

public function Report()
{
  $this -> MAIN -> Report ( ) ;
}

public function Join($TAG)
{
  $this -> MAIN -> AddTag ( $TAG ) ;
}

public function addTr()
{
  $HR = $this -> TBODY -> addTr ( ) ;
  array_push ( $this -> TRs , $HR ) ;
  return $HR                        ;
}

public function lastTr()
{
  return end ( $this -> TRs ) ;
}

public function appendLine($MSG="")
{
  $HR = $this -> addTr (      ) ;
  $HD = $HR   -> addTd ( $MSG ) ;
  return $HD                    ;
}

public function addLine ( $TAG )
{
  $HD  = $this -> appendLine (      ) ;
  $HD          -> AddTag     ( $TAG ) ;
  return $HD                          ;
}

public function appendTable($BORDER=0,$SPACING=0,$PADDING=0,$TNAME="")
{
  $HD    = $this  -> appendLine     (                               ) ;
  $TABLE = $HD    -> addHtml        (                               ) ;
  $TBODY = $TABLE -> ConfigureTable ( $BORDER , $SPACING , $PADDING ) ;
  if                                ( strlen ( $TNAME ) > 0         ) {
    $this -> Objects [ $TNAME ] = $TABLE                              ;
  }                                                                   ;
  return $TBODY                                                       ;
}

public function LoadScript($FILENAME)
{
  return file_get_contents ( $FILENAME ) ;
}

public function AppendScript($FILENAME)
{
  $SRC  = $this -> LoadScript      ( $FILENAME ) ;
  $JSV  = $this -> MAIN -> addHtml (           ) ;
  $JSV -> setTag                   ( "script"  ) ;
  $JSV -> AddText                  ( $SRC      ) ;
}

}

?>
