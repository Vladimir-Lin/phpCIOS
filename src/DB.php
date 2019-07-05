<?php

namespace CIOS ;

class DB
{

public $SQL ;

public function Connect ( $Host )
{
  $Port        = $Host [ "Port" ]                   ;
  if ( strlen ( $Port ) <= 0 )                      {
    $Port      = "3306"                             ;
  }                                                 ;
  $this -> SQL = new \mysqli ( $Host [ "Hostname" ] ,
                               $Host [ "Username" ] ,
                               $Host [ "Password" ] ,
                               $Host [ "Database" ] ,
                               $Port              ) ;
  if ( $this -> SQL -> connect_errno > 0          ) {
    return false                                    ;
  }                                                 ;
  return true                                       ;
}

public function Close ( )
{
  return $this -> SQL -> close ( ) ;
}

public function ConnectionError ( )
{
  $DB -> SQL -> connect_error ;
}

public function Query ( $CMD )
{
  return $this -> SQL -> query ( $CMD ) ;
}

public function Queries($CMDs)
{
  $rr   = ""                      ;
  foreach ( $CMDs as $CMD )       {
    $rr = $this -> Query ( $CMD ) ;
  }                               ;
  return $rr                      ;
}

public function Prepare($CMD)
{
  return $this -> SQL -> prepare ( $CMD ) ;
}

public function hasResult ( $q )
{
  if ( ! $q                  ) return false ;
  if (   $q -> num_rows <= 0 ) return false ;
  return true                               ;
}

public function OrderBy($Item,$Sort)
{
  if ( strlen ( $Sort ) <= 0 )        {
    return "order by {$Item}"         ;
  }                                   ;
  return   "order by {$Item} {$Sort}" ;
}

public function OrderByAsc($Item)
{
  return $this -> OrderBy ( $Item , "asc" ) ;
}

public function OrderByDesc($Item)
{
  return $this -> OrderBy ( $Item , "desc" ) ;
}

public function Limit($SID,$CNT)
{
  if ( strlen ( $CNT ) <= 0 )  {
    return "limit {$SID}"      ;
  }                            ;
  return   "limit {$SID},$CNT" ;
}

public function LimitFirst()
{
  return $this -> Limit ( 0 , 1 ) ;
}

public function Pair($Item,$Value)
{
  return "`{$Item}` = {$Value}" ;
}

public function WhereUuid($U,$Tail = false)
{
  $QQ = " where `uuid` = {$U}"  ;
  if ( $Tail ) $QQ = $QQ . " ;" ;
  return $QQ                    ;
}

public function FetchUuids($qq,$UU)
{
  if ( $this -> hasResult ( $qq ) )                    {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      $UV = $rr [ 0 ]                                  ;
      array_push ( $UU , $UV )                         ;
    }                                                  ;
  }                                                    ;
  return $UU                                           ;
}

public function ObtainUuids($QQ)
{
  $UU  = array               (           ) ;
  $qq  = $this -> Query      ( $QQ       ) ;
  return $this -> FetchUuids ( $qq , $UU ) ;
}

/////////////////////////////////////////////////////////

public function LastUuid ( $Table , $Item , $Heading )
{
  /////////////////////////////////////////////////
  $U = 0                                          ;
  $Q = "select {$Item} from {$Table}"             .
       " order by {$Item} desc limit 0,1 ;"       ;
  $q = $this -> Query ( $Q )                      ;
  if ( $q -> num_rows > 0 )                       {
    $N = $q -> fetch_array  ( MYSQLI_BOTH )       ;
    $U = $N [ 0 ]                                 ;
    $U = gmp_add ( $U ,  "1" )                    ;
    if ( $U <= 1 ) $U = gmp_add ( $U , $Heading ) ;
    return $U                                     ;
  }                                               ;
  /////////////////////////////////////////////////
  $Q = "select count(*) from " . $Table . " ;"    ;
  $q = $this -> Query ( $Q )                      ;
  if ( $q -> num_rows > 0 )                       {
    $N = $q -> fetch_array  ( MYSQLI_BOTH )       ;
    $U = $N [ 0 ]                                 ;
    if ( $U <= 0 )                                {
      $U = gmp_add ( $Heading , "1" )             ;
      return $U                                   ;
    }                                             ;
  }                                               ;
  /////////////////////////////////////////////////
  return $U                                       ;
}

/////////////////////////////////////////////////////////

public function AddUuid ( $Table , $U , $T )
{
  $Q = "insert into " . $Table . " (`uuid`,`type`,`used`) " .
       "values (" . (string) $U . "," . $T . ",1) ;"        ;
  return $this -> Query ( $Q )                              ;
}

/////////////////////////////////////////////////////////

public function AppendUuid ( $Table , $U )
{
  $Q = "insert into {$Table} (`uuid`) values ( {$U} ) ;" ;
  return $this -> Query ( $Q )                           ;
}

public function GetLast ( $Table , $Item , $Heading )
{
  $L = $this -> LastUuid ( $Table , $Item , $Heading ) ;
  if ( $this -> AppendUuid ( $Table , $L ) ) return $L ;
  return "0"                                           ;
}

/////////////////////////////////////////////////////////

public function UnusedUuid ( $Table , $Item = "`uuid`" )
{
  $Q = "select " . $Item . " from " . $Table           .
       " where `used` = 0 order by " . $Item . " asc " .
       "limit 0,1 ;"                                   ;
  $q = $this -> Query        ( $Q          )           ;
  $N = $q    -> fetch_array  ( MYSQLI_BOTH )           ;
  return $N [ 0 ]                                      ;
}

/////////////////////////////////////////////////////////

public function UseUuid ( $Table , $U )
{
  return $this -> UuidUsage ( $Table , $U , 1 ) ;
}

/////////////////////////////////////////////////////////

public function UselessUuid ( $Table , $U )
{
  return $this -> UuidUsage ( $Table , $U , 0 ) ;
}

/////////////////////////////////////////////////////////

public function UuidUsage ( $Table , $U , $usage )
{
  $Q = "update {$Table}"                .
       " set `used` = {$usage}"         .
       $this -> WhereUuid ( $U , true ) ;
  return $this -> Query ( $Q )          ;
}

/////////////////////////////////////////////////////////

public function DeleteUuid ( $Table , $U )
{
  $Q = "delete from {$Table} "          .
       $this -> WhereUuid ( $U , true ) ;
  return $this -> Query ( $Q )          ;
}

/////////////////////////////////////////////////////////

public function ObtainsUuid($MainTable,$UuidTable)
{
  //////////////////////////////////////////////////////////////////////
  $QQ    = "lock tables {$MainTable} write, {$UuidTable} write ;"      ;
  $this -> Query ( $QQ )                                               ;
  //////////////////////////////////////////////////////////////////////
  $C = true                                                            ;
  $U = $this -> UnusedUuid ( $MainTable )                              ;
  //////////////////////////////////////////////////////////////////////
  if   ( gmp_cmp ( $U , "0" ) > 0 )                                    {
    if (       ( ! $this -> UseUuid ( $MainTable , $U ) ) ) $C = false ;
    if ( $C && ( ! $this -> UseUuid ( $UuidTable , $U ) ) ) $C = false ;
  }                                                                    ;
  //////////////////////////////////////////////////////////////////////
  if ( ! $C ) $U = "0"                                                 ;
  //////////////////////////////////////////////////////////////////////
  $this -> UnlockTables ( )                                            ;
  //////////////////////////////////////////////////////////////////////
  return $U                                                            ;
}

/////////////////////////////////////////////////////////

public function Forget($T1,$T2,$U)
{
  $Correct = true                                             ;
  if ( ! $this -> UselessUuid ( $T1 , $U ) ) $Correct = false ;
  if ( ! $this -> UselessUuid ( $T2 , $U ) ) $Correct = false ;
  return $Correct                                             ;
}

/////////////////////////////////////////////////////////

public function LockWrite($TABLE)
{
  $QQ    = "lock tables {$TABLE} write ;" ;
  $this -> Query ( $QQ )                  ;
}

public function UnlockTables()
{
  $QQ    = "unlock tables ;" ;
  $this -> Query ( $QQ )     ;
}

public function GetName($Table,$U,$Locality,$Usage = "Default")
{
  global $NameUsages                                 ;
  $Q = "select `name` from " . $Table . " "          .
       "where `uuid` = " . ( (string) $U ) . " and " .
       "`locality` = " . $Locality . " and "         .
       "`relevance` = " . $NameUsages [ $Usage ]     .
       " order by `priority` asc"                    .
       " limit 0,1 ;"                                ;
  $q = $this -> Query ( $Q )                         ;
  if ( $this -> hasResult ( $q ) )                   {
    $N = $q -> fetch_array  ( MYSQLI_BOTH )          ;
    return $N [ "name" ]                             ;
  }                                                  ;
  return ""                                          ;
}

public function GetNameByLocalities($Table,$U,$Localities,$Usage = "Default")
{
  $NN = ""                                               ;
  foreach ( $Localities as $L )                          {
    $NN = $this -> GetName ( $Table , $U , $L , $Usage ) ;
    if ( strlen ( $NN ) > 0 ) return $NN                 ;
  }                                                      ;
  return $NN                                             ;
}

public function GetMapNames($TABLE,$UU,$LANG,$Usage = "Default")
{
  $CNAMES  = array         (                               ) ;
  foreach                  ( $UU as $cc                    ) {
    $NN = $this -> GetName ( $TABLE , $cc , $LANG , $Usage ) ;
    $CNAMES [ $cc ] = $NN                                    ;
  }                                                          ;
  return $CNAMES                                             ;
}

}

?>
