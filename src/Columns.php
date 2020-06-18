<?php

namespace CIOS ;

abstract class Columns
{

public $Columns ;

abstract public function assign     ( $Item      ) ;
abstract public function set        ( $item , $V ) ;
abstract public function tableItems (            ) ;
abstract public function ItemPair   ( $item      ) ;

function __construct()
{
  $this -> clear ( )  ;
}

function __destruct()
{
  unset ( $this -> Columns ) ;
}

public function clear()
{
  $this -> Columns   = array ( ) ;
}

public function ClearColumns()
{
  unset ( $this -> Columns )   ;
  $this -> Columns = array ( ) ;
}

public function AddColumn ( $C )
{
  array_push ( $this -> Columns , $C ) ;
}

public function JoinItems ( $X , $S = "," )
{
  $U = array   (          ) ;
  foreach      ( $X as $V ) {
    $W = "`{$V}`"           ;
    array_push ( $U , $W  ) ;
  }                         ;
  $L = implode ( $S , $U  ) ;
  unset        ( $U       ) ;
  return $L                 ;
}

public function Items( $S = "," )
{
  $X = $this -> tableItems (         ) ;
  $L = $this -> JoinItems  ( $X , $S ) ;
  unset                    ( $X      ) ;
  return $L                            ;
}

public function toJson ( )
{
  $X = $this -> tableItems   (          ) ;
  $J = array                 (          ) ;
  foreach                    ( $X as $V ) {
    $J [ $V ] = $this -> get ( $V       ) ;
  }                                       ;
  return $J                               ;
}

public function fromJson ( $JSON )
{
  $X = $this -> tableItems   (                   ) ;
  foreach                    ( $X as $V          ) {
    $J [ $V ] = $this -> set ( $V , $JSON [ $V ] ) ;
  }                                                ;
}

public function OptionsTail($Options,$Limits)
{
  $Q = ""                        ;
  if ( strlen ( $Options ) > 0 ) {
    $Q .= " "                    ;
    $Q .= $Options               ;
  }                              ;
  if ( strlen ( $Limits  ) > 0 ) {
    $Q .= " "                    ;
    $Q .= $Limits                ;
  }                              ;
  return $Q                      ;
}

public function ItemPairs ( $items )
{
  $I = array ( )                                 ;
  foreach ( $items as $i )                       {
    array_push ( $I , $this -> ItemPair ( $i ) ) ;
  }                                              ;
  $L = implode ( " and " , $I )                  ;
  unset        (           $I )                  ;
  return $L                                      ;
}

public function QueryItems($items,$Options = "",$Limits = "")
{
  $ITEMS = $this -> ItemPairs   ( $items             ) ;
  $TAILS = $this -> OptionsTail ( $Options , $Limits ) ;
  $QQ    = " where {$ITEMS} {$TAILS}"                  ;
  return $QQ                                           ;
}

public function SelectItems($Table,$items,$Options = "",$Limits = "")
{
  $ITEMS = $this -> Items      (                             ) ;
  $QUERY = $this -> QueryItems ( $items , $Options , $Limits ) ;
  $QQ    = "select {$ITEMS} from {$Table} {$QUERY} ;"          ;
  return $QQ                                                   ;
}

public function SelectColumns($Table,$Options = "order by `priority` asc",$Limits = "")
{
  return $this -> SelectItems ( $Table           ,
                                $this -> Columns ,
                                $Options         ,
                                $Limits        ) ;
}

}

?>
