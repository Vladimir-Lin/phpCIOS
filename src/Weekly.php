<?php

namespace CIOS ;

class Weekly
{

public $TimeSlots ;
public $Minutes   ;

function __construct()
{
  $this -> Clear ( )  ;
}

function __destruct()
{
}

public function Clear()
{
  $this -> TimeSlots = array ( )     ;
  $this -> Minutes   = array ( )     ;
  for ( $i = 0 ; $i < 10080 ; $i++ ) {
    $this -> Minutes [ $i ] = 0      ;
  }                                  ;
}

public function FillHours($HOURS,$STATES)
{
  ////////////////////////////////////////////////////////////////////////////
  $HX = explode              ( "," , $HOURS             )                    ;
  unset                      ( $this -> TimeSlots       )                    ;
  $this -> TimeSlots = array (                          )                    ;
  ////////////////////////////////////////////////////////////////////////////
  if                         ( strlen ( $HOURS ) <= 0   ) return             ;
  if                         ( count  ( $HX    ) <= 0   ) return             ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                    ( $HX as $v                )                    {
    //////////////////////////////////////////////////////////////////////////
    $MI  = intval            ( $v         , 10          )                    ;
    $MI  = intval            ( $MI * 3600 , 10          )                    ;
    $TS  = new TimeSlot      (                          )                    ;
    $TS -> States = $STATES                                                  ;
    $TS -> Start  = $MI                                                      ;
    $TS -> setInterval       ( 3599                     )                    ;
    array_push               ( $this -> TimeSlots , $TS )                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}

public function DayCounts ( $DAY )
{
  ////////////////////////////////////////////////////////////////////////////
  $DC = 0                                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  foreach ( $this -> TimeSlots as $ts )                                      {
    if    ( $DAY == $ts -> Day ( )    )                                      {
      $DC = $DC + 1                                                          ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $DC                                                                 ;
}

public function SlotCounts ( $DAY , $SLOTS )
{
  ////////////////////////////////////////////////////////////////////////////
  $DC = 0                                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  foreach       ( $SLOTS as $ts   )                                          {
    $D = intval ( $ts / 1440 , 10 )                                          ;
    if          ( $DAY == $D      )                                          {
      $DC = $DC + 1                                                          ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $DC                                                                 ;
}

public function toWeeklyJSON($DAY)
{
  ////////////////////////////////////////////////////////////////////////////
  $DL    = array              (                           )                  ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                     ( $this -> TimeSlots as $ts )                  {
    if                        ( $DAY == $ts -> Day ( )    )                  {
      $LINE = $ts -> toWeekly (                           )                  ;
      array_push              ( $DL , $LINE               )                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $LINEX = implode            ( ",\n" , $DL               )                  ;
  ////////////////////////////////////////////////////////////////////////////
  $WJSL  = "{\n  \"day\":\"{$DAY}\",\n  \"periods\": [\n{$LINEX}\n  ]\n}"    ;
  ////////////////////////////////////////////////////////////////////////////
  return $WJSL                                                               ;
}

public function toWeekly()
{
  ////////////////////////////////////////////////////////////////////////////
  $DL       = array                 (                        )               ;
  ////////////////////////////////////////////////////////////////////////////
  for                               ( $i = 0 ; $i < 7 ; $i++ )               {
    $DC     = $this -> DayCounts    ( $i                     )               ;
    if                              ( $DC > 0                )               {
      $LINE = $this -> toWeeklyJSON ( $i                     )               ;
      array_push                    ( $DL , $LINE            )               ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $LINEX    = implode               ( ",\n" , $DL            )               ;
  ////////////////////////////////////////////////////////////////////////////
  return $LINEX                                                              ;
}

public function Obtains($DB,$TABLE,$PUID,$RUID)
{
  ////////////////////////////////////////////////////////////////////////////
  unset                      ( $this -> TimeSlots       )                    ;
  $this -> TimeSlots = array (                          )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `start`,`end`,`states` from {$TABLE}"                     .
           " where `uuid` = {$PUID} and `acting` = {$RUID}"                  .
           " order by `start` asc ;"                                         ;
  $qq    = $DB -> Query ( $QQ )                                              ;
  if ( ! $DB -> hasResult ( $qq ) ) return false                             ;
  ////////////////////////////////////////////////////////////////////////////
  while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                         {
    $TS  = new TimeSlot      (                          )                    ;
    $TS -> obtain            ( $rr                      )                    ;
    array_push               ( $this -> TimeSlots , $TS )                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}

public function Update($DB,$TABLE,$PUID,$RUID)
{
  ////////////////////////////////////////////////////////////////////////////
  $DB   -> LockWrite    ( $TABLE                    )                        ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "delete from {$TABLE}"                                            .
           " where `uuid` = {$PUID} and `acting` = {$RUID} ;"                ;
  $DB   -> Query        ( $QQ                       )                        ;
  ////////////////////////////////////////////////////////////////////////////
  foreach               ( $this -> TimeSlots as $ts )                        {
    $START  = $ts -> Start                                                   ;
    $END    = $ts -> End                                                     ;
    $STATES = $ts -> States                                                  ;
    $QQ     = "insert into {$TABLE}"                                         .
              " (`uuid`,`acting`,`start`,`end`,`states`)"                    .
              " values"                                                      .
              " ( {$PUID} , {$RUID} , {$START} , {$END} , {$STATES} ) ;"     ;
     $DB   -> Query     ( $QQ                       )                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $DB -> UnlockTables   ( $TABLE                    )                        ;
}

public function Occupied ( $T )
{
  foreach ( $this -> TimeSlots as $ts ) {
    if ( $ts -> Between ( $T ) == 0 )   {
      return true                       ;
    }                                   ;
  }                                     ;
  return false                          ;
}

public function toMinuteIndexes ( )
{
  $MI = array  (                              ) ;
  foreach      ( $this -> TimeSlots as $ts    ) {
    array_push ( $MI , $ts -> MinuteIndex ( ) ) ;
  }                                             ;
  return $MI                                    ;
}

}

?>
