<?php

namespace CIOS ;

class Note extends Columns
{

public $Id     ;
public $Uuid   ;
public $Name   ;
public $Prefer ;
public $Note   ;
public $Update ;

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
  $this -> Id     = 0  ;
  $this -> Uuid   = 0  ;
  $this -> Name   = "" ;
  $this -> Prefer = 0  ;
  $this -> Note   = "" ;
  $this -> Update = 0  ;
}

public function assign($Item)
{
  $this -> Id     = $Item -> Id     ;
  $this -> Uuid   = $Item -> Uuid   ;
  $this -> Name   = $Item -> Name   ;
  $this -> Prefer = $Item -> Prefer ;
  $this -> Note   = $Item -> Note   ;
  $this -> Update = $Item -> Update ;
}

public function tableItems()
{
  $S = array (               ) ;
  array_push ( $S , "id"     ) ;
  array_push ( $S , "uuid"   ) ;
  array_push ( $S , "name"   ) ;
  array_push ( $S , "prefer" ) ;
  array_push ( $S , "note"   ) ;
  array_push ( $S , "ltime"  ) ;
  return $S                    ;
}

public function JoinItems ( $X , $S = "," )
{
  $U = array ( )               ;
  foreach ( $X as $V )         {
    $W = "`" . $V . "`"        ;
    array_push ( $U , $W )     ;
  }                            ;
  $L = implode ( $S , $U )     ;
  unset ( $U )                 ;
  return $L                    ;
}

public function Items( $S = "," )
{
  $X = $this -> tableItems (         ) ;
  $L = $this -> JoinItems  ( $X , $S ) ;
  unset                    ( $X      ) ;
  return $L                            ;
}

public function set($item,$V)
{
  $a = strtolower ( $item )                  ;
  if ( "id"     == $a ) $this -> Id     = $V ;
  if ( "uuid"   == $a ) $this -> Uuid   = $V ;
  if ( "name"   == $a ) $this -> Name   = $V ;
  if ( "prefer" == $a ) $this -> Prefer = $V ;
  if ( "note"   == $a ) $this -> Note   = $V ;
  if ( "ltime"  == $a ) $this -> Update = $V ;
}

public function get($item)
{
  $a = strtolower ( $item )                    ;
  if ( "id"     == $a ) return $this -> Id     ;
  if ( "uuid"   == $a ) return $this -> Uuid   ;
  if ( "name"   == $a ) return $this -> Name   ;
  if ( "prefer" == $a ) return $this -> Prefer ;
  if ( "note"   == $a ) return $this -> Note   ;
  if ( "ltime"  == $a ) return $this -> Update ;
  return ""                                    ;
}

//////////////////////////////////////////////////////////////////////////////

public function ItemPair($item)
{
  $a = strtolower ( $item )                            ;
  if ( "id"        == $a )                             {
    return "`{$a}` = " . (string) $this -> Id          ;
  }                                                    ;
  if ( "uuid"      == $a )                             {
    return "`{$a}` = " . (string) $this -> Uuid        ;
  }                                                    ;
  if ( "name"      == $a )                             {
    return "`{$a}` = '" . (string) $this -> Name . "'" ;
  }                                                    ;
  if ( "prefer"  == $a )                               {
    return "`{$a}` = " . (string) $this -> prefer      ;
  }                                                    ;
  if ( "note" == $a )                                  {
    return "`{$a}` = '" . (string) $this -> Note . "'" ;
  }                                                    ;
  if ( "ltime"     == $a )                             {
    return "`{$a}` = " . (string) $this -> Update      ;
  }                                                    ;
  return ""                                            ;
}

public function Pair($item)
{
  return "`" . $item . "` = " . $this -> get ( $item ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function Pairs($Items)
{
  $P = array ( )                                ;
  foreach ( $Items as $item )                   {
    array_push ( $P , $this -> Pair ( $item ) ) ;
  }                                             ;
  $Q = implode ( " , " , $P )                   ;
  unset        ( $P         )                   ;
  return $Q                                     ;
}

//////////////////////////////////////////////////////////////////////////////

public function setOwner($UUID,$NAME)
{
  $this -> Uuid = $UUID ;
  $this -> Name = $NAME ;
}

//////////////////////////////////////////////////////////////////////////////

public function WhereClause($PREFER="")
{
  $W = ""                                            ;
  if ( strlen ( $PREFER ) > 0 )                      {
    $W =  " where `uuid` = "  . $this -> Uuid        .
            " and `name` = '" . $this -> Name . "'"  .
          " and `prefer` = "  . $PREFER       . " ;" ;
  } else                                             {
    $W =  " where `uuid` = "  . $this -> Uuid        .
            " and `name` = '" . $this -> Name . "'"  .
           " order by `prefer` desc limit 0,1 ;"     ;
  }                                                  ;
  return $W                                          ;
}

public function Select($TABLE,$PREFER="")
{
  return "select `note` from " . $TABLE   .
         $this -> WhereClause ( $PREFER ) ;
}

public function Delete($TABLE)
{
  return "delete from " . $TABLE                  .
         $this -> WhereClause ( $this -> Prefer ) ;
}

public function Insert($DB,$TABLE)
{
  $QQ  = "insert into " . $TABLE . " "              .
         "(`uuid`,`name`,`prefer`,`note` ) values " .
          "(" . (string) $this -> Uuid              .
         ",'" . $this -> Name . "',"                .
         $this -> Prefer . ",?) ;"                  ;
  $qq  = $DB -> Prepare ( $QQ                 )     ;
  $qq -> bind_param     ( 's' , $this -> Note )     ;
  $rt  = $qq -> execute (                     )     ;
  $qq -> close          (                     )     ;
  return $rt                                        ;
}

public function UpdateNote($DB,$TABLE)
{
  $QQ  = "update " . $TABLE . " set `note` = ? "              .
         "where `uuid` = "  . (string) $this -> Uuid          .
          " and `name` = '" . $this -> Name . "'"             .
        " and `prefer` = "  . (string) $this -> Prefer . " ;" ;
  $qq  = $DB -> Prepare ( $QQ         )                       ;
  $qq -> bind_param     ( 's' , $note )                       ;
  $rt  = $qq -> execute (             )                       ;
  $qq -> close          (             )                       ;
  return $rt                                                  ;
}

public function Obtains($DB,$TABLE,$PREFER="")
{
  $this -> Note = ""                                   ;
  $QQ           = $this -> Select ( $TABLE , $PREFER ) ;
  $qq           = $DB   -> Query  ( $QQ              ) ;
  if ( $DB -> hasResult ( $qq ) )                      {
    $rr           = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this -> Note = $rr [ 0 ]                          ;
  }                                                    ;
  return $this -> Note                                 ;
}

public function ObtainByOwner($DB,$TABLE,$UUID,$NAME,$PREFER="")
{
  $this -> setOwner       ( $UUID , $NAME          ) ;
  return $this -> Obtains ( $DB , $TABLE , $PREFER ) ;
}

public function ObtainIDs($DB,$TABLE,$ITEM="id",$ORDER="asc")
{
  $IDs = array ( )                                     ;
  $QQ  = "select `{$ITEM}` from {$TABLE}"              .
         " where `uuid` = {$this->Uuid}"               .
         " and `name` = '{$this->Name}'"               .
         " order by `prefer` {$ORDER} ;"               ;
  $qq  = $DB -> Query ( $QQ )                          ;
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $IDs , $rr [ 0 ] )                  ;
    }                                                  ;
  }                                                    ;
  return $IDs                                          ;
}

public function ObtainStrings($DB,$TABLE,$ORDER="asc")
{
  $IDs = array ( )                                     ;
  $QQ  = "select `note` from {$TABLE}"                 .
         " where `uuid` = {$this->Uuid}"               .
          " and `name` = '{$this->Name}'"              .
         " order by `prefer` {$ORDER} ;"               ;
  $qq  = $DB -> Query ( $QQ )                          ;
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $IDs , $rr [ 0 ] )                  ;
    }                                                  ;
  }                                                    ;
  return $IDs                                          ;
}

public function ObtainMaps($DB,$TABLE,$ORDER="asc")
{
  $IDs = array ( )                                     ;
  $QQ  = "select `note`,`prefer` from {$TABLE}"        .
         " where `uuid` = {$this->Uuid}"               .
           " and `name` = '{$this->Name}'"             .
         " order by `prefer` {$ORDER} ;"               ;
  $qq  = $DB -> Query ( $QQ )                          ;
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      $NOTE        = $rr [ 0 ]                         ;
      $ID          = $rr [ 1 ]                         ;
      $IDs [ $ID ] = $NOTE                             ;
    }                                                  ;
  }                                                    ;
  return $IDs                                          ;
}

public function assureNote ( $DB , $TABLE )
{
  $this -> Prefer = 0                       ;
  $DS    = $this -> Delete ( $TABLE       ) ;
  $DB   -> Query           ( $DS          ) ;
  $this -> Insert          ( $DB , $TABLE ) ;
}

public function appendNote($DB,$TABLE)
{
  $this -> Prefer = -1                                   ;
  $QQ  = "select `prefer` from " . $TABLE                .
         " where `uuid` = " . (string) $this -> Uuid     .
          " and `name` = '" . $this -> Name . "'"        .
         " order by `prefer` desc limit 0,1 ;"           ;
  $qq  = $DB -> Query ( $QQ )                            ;
  if ( $DB -> hasResult ( $qq ) )                        {
    $rr             = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this -> Prefer = $rr [ 0 ]                          ;
  }                                                      ;
  $this -> Prefer = $this -> Prefer + 1                  ;
  $this -> Insert ( $DB , $TABLE )                       ;
}

public function Editing($DB,$TABLE)
{
  if ( $this -> Prefer < 0 )                      {
    if ( strlen ( $this -> Note ) > 0 )           {
      $this -> appendNote ( $DB , $TABLE )        ;
    }                                             ;
  } else                                          {
    if ( strlen ( $this -> Note ) > 0 )           {
      $this -> UpdateNote ( $DB , $TABLE )        ;
    } else                                        {
      $DB -> Query ( $this -> Delete ( $TABLE ) ) ;
    }                                             ;
  }                                               ;
}

public function Ordering($DB,$TABLE,$IDs)
{
  if ( count ( $IDs ) <= 0 ) return false           ;
  $CC  = 0                                          ;
  foreach ( $IDs as $id )                           {
    $QQ  = "update " . $TABLE                       .
           " set `prefer` = " . (string) $CC        .
             " where `id` = " . (string) $id . " ;" ;
    $DB -> Query ( $QQ )                            ;
    $CC  = $CC + 1                                  ;
  }                                                 ;
}

public function Organize($DB,$TABLE)
{
  $IDs = $this -> ObtainIDs ( $DB , $TABLE        ) ;
  $this        -> Ordering  ( $DB , $TABLE , $IDs ) ;
  unset                     (                $IDs ) ;
}

//////////////////////////////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////
?>
