<?php

namespace CIOS ;

class TimeSlot
{

public $Start  ;
public $End    ;
public $States ;

function __construct()
{
  $this -> clear ( )  ;
}

function __destruct()
{
}

public function clear()
{
  $this -> Start  = 0 ;
  $this -> End    = 0 ;
  $this -> States = 0 ;
}

public function setInterval($TOTAL)
{
  $this -> End = $this -> Start + $TOTAL ;
}

public function Between($T)
{
  if ( $this -> Start > $T ) return  1 ;
  if ( $this -> End   > $T ) return  0 ;
  return -1                            ;
}

public function Day()
{
  return intval ( $this -> Start / 86400 , 10 ) ;
}

public function Hour()
{
  $H   = intval ( $this -> Start % 86400 , 10 ) ;
  return intval ( $H             /  3600 , 10 ) ;
}

public function Minute()
{
  $M   = intval ( $this -> Start % 3600 , 10 ) ;
  return intval ( $M             /   60 , 10 ) ;
}

public function Second()
{
  return intval ( $this -> Start % 60 , 10 ) ;
}

public function Interval()
{
  return ( $this -> End - $this -> Start ) ;
}

public function MinuteIndex()
{
  return intval ( $this -> Start / 60 , 10 ) ;
}

public function EndIndex()
{
  return intval ( $this -> End / 60 , 10 ) ;
}

public function obtain($rr)
{
  $this -> Start  = $rr [ "start"  ] ;
  $this -> End    = $rr [ "end"    ] ;
  $this -> States = $rr [ "states" ] ;
}

public function toWeekly()
{
  $HS = $this -> Hour ( )                                       ;
  $HE = $HS + 1                                                 ;
  if ( $HS < 10 ) $VS = "0{$HS}" ; else $VS = "{$HS}"           ;
  if ( $HE < 10 ) $VK = "0{$HE}" ; else $VK = "{$HE}"           ;
  $LINE = "{ \"start\": \"{$VS}:00\" , \"end\": \"{$VK}:00\" , \"editable\": true }" ;
  return $LINE                                                  ;
}

}

?>
