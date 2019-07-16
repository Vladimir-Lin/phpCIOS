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
  if ( is_a ( $this -> SQL , "mysqli" ) ) {
    return $this -> SQL -> close ( )      ;
  }                                       ;
  return false                            ;
}

public function ConnectionError ( )
{
  if ( is_a ( $this -> SQL , "mysqli" ) ) {
    return $this -> SQL -> connect_error  ;
  }                                       ;
  return ""                               ;
}

public function Query ( $CMD )
{
  if ( is_a ( $this -> SQL , "mysqli" ) ) {
    return $this -> SQL -> query ( $CMD ) ;
  }                                       ;
  return false                            ;
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
  if ( is_a ( $this -> SQL , "mysqli" ) )   {
    return $this -> SQL -> prepare ( $CMD ) ;
  }                                         ;
  return false                              ;
}

public function hasResult ( $qq )
{
  if ( ! $qq                  ) return false ;
  if (   $qq -> num_rows <= 0 ) return false ;
  return true                                ;
}

public function FetchOne ( $QQ )
{
  $qq = $this -> Query ( $QQ )                   ;
  if ( $this -> hasResult ( $qq ) )              {
    $rr    = $qq -> fetch_array  ( MYSQLI_BOTH ) ;
    return $rr [ 0 ]                             ;
  }                                              ;
  return ""                                      ;
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
  if ( strlen ( $CNT ) <= 0 )    {
    return "limit {$SID}"        ;
  }                              ;
  return   "limit {$SID} , $CNT" ;
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
      array_push ( $UU , $rr [ 0 ] )                   ;
    }                                                  ;
  }                                                    ;
  return $UU                                           ;
}

public function ObtainUuids($QQ)
{
  $UU  = array               (           ) ;
  $qq  = $this -> Query      ( $QQ       ) ;
  if ( $qq === false ) return $UU          ;
  return $this -> FetchUuids ( $qq , $UU ) ;
}

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
  $Q = "select count(*) from {$Table} ;"          ;
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

public function AddUuid ( $Table , $U , $T )
{
  $QQ = "insert into {$Table} (`uuid`,`type`,`used`) " .
        "values ( {$U} , {$T} , 1 ) ;"                 ;
  return $this -> Query ( $QQ )                        ;
}

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

public function UnusedUuid ( $Table , $Item = "`uuid`" )
{
  $QQ = "select {$Item} from {$Table}"          .
       " where `used` = 0 order by {$Item} asc" .
       " limit 0,1 ;"                           ;
  $qq = $this -> Query        ( $QQ         )   ;
  $NN = $qq   -> fetch_array  ( MYSQLI_BOTH )   ;
  return $NN [ 0 ]                              ;
}

public function UseUuid ( $Table , $U )
{
  return $this -> UuidUsage ( $Table , $U , 1 ) ;
}

public function UselessUuid ( $Table , $U )
{
  return $this -> UuidUsage ( $Table , $U , 0 ) ;
}

public function UuidUsage ( $Table , $U , $usage )
{
  $WH = $this -> WhereUuid ( $U , true )              ;
  $QQ = "update {$Table} set `used` = {$usage} {$WH}" ;
  return $this -> Query ( $QQ )                       ;
}

public function DeleteUuid ( $Table , $U )
{
  $WH = $this -> WhereUuid ( $U , true ) ;
  $QQ = "delete from {$Table} {$WH}"     ;
  return $this -> Query ( $QQ )          ;
}

public function ObtainsUuid($MainTable,$UuidTable)
{
  //////////////////////////////////////////////////////////////////////
  $this -> LockWrites ( [ $MainTable , $UuidTable ] )                  ;
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

public function LockWrites($TABLES)
{
  $TX    = array   (                    ) ;
  foreach          ( $TABLES as $t      ) {
    array_push     ( $TX , "{$t} write" ) ;
  }                                       ;
  $TT    = implode ( " , " , $TX        ) ;
  $QQ    = "lock tables {$TT} ;"          ;
  $this -> Query ( $QQ )                  ;
}

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

public function Naming ( $Table , $U , $Locality , $Usage = "Default" )
{
  $NI  = new Name     (                        ) ;
  $NI -> set          ( "Uuid"     , $U        ) ;
  $NI -> set          ( "Locality" , $Locality ) ;
  $NI -> setRelevance ( $Usage                 ) ;
  return $NI -> Fetch ( $this      , $Table    ) ;
}

public function GetTutor($Table,$U)
{
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return "" ;
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Stage"        ) ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Default"      ) ;
  }                                          ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1002             ,
                            "Default"      ) ;
  }                                          ;
  return $NN                                 ;
}

public function GetManager($Table,$U)
{
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return "" ;
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Stage"        ) ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Default"      ) ;
  }                                          ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1002             ,
                            "Default"      ) ;
  }                                          ;
  return $NN                                 ;
}

public function GetInsider($Table,$U)
{
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return "" ;
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1002             ,
                            "Default"      ) ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Default"      ) ;
  }                                          ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Stage"        ) ;
  }                                          ;
  return $NN                                 ;
}

public function GetStudent($Table,$U)
{
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return "" ;
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1002             ,
                            "Default"      ) ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Pen"          ) ;
  }                                          ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Default"      ) ;
  }                                          ;
  return $NN                                 ;
}

public function GetTrainee($Table,$U)
{
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return "" ;
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Pen"          ) ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1001             ,
                            "Default"      ) ;
  }                                          ;
  if ( strlen ( $NN ) <= 0 )                 {
    $NN = $this -> Naming ( $Table           ,
                            $U               ,
                            1002             ,
                            "Default"      ) ;
  }                                          ;
  return $NN                                 ;
}

public function GetNameByLocalities($Table,$U,$Localities,$Usage = "Default")
{
  $NN = ""                                              ;
  foreach ( $Localities as $L )                         {
    $NN = $this -> Naming ( $Table , $U , $L , $Usage ) ;
    if ( strlen ( $NN ) > 0 ) return $NN                ;
  }                                                     ;
  return $NN                                            ;
}

public function GetPassword($Table,$Uuid,$Name)
{
  $QQ  = "select `secret` from {$Table}"          .
         " where `uuid` = {$Uuid}"                .
           " and `name` = '{$Name}' ;"            ;
  $Pwd = ""                                       ;
  $qq  = $this -> Query ( $QQ )                   ;
  if ( ! $this -> hasResult ( $qq ) ) return $Pwd ;
  $N   = $qq -> fetch_array ( MYSQLI_BOTH )       ;
  $Pwd = $N [ "secret" ]                          ;
  return $Pwd                                     ;
}

public function AssurePassword($Table,$Uuid,$Name,$Pwd)
{
  $Id  = 0                                     ;
  $QQ  = "select `id` from {$Table}"           .
         " where `uuid` = {$Uuid}"             .
           " and `name` = '{$Name}' ;"         ;
  $q   = $this -> Query ( $QQ )                ;
  //////////////////////////////////////////////
  if ( $this -> hasResult ( $q ) )             {
    $N  = $q -> fetch_array  ( MYSQLI_BOTH )   ;
    $Id = $N [ "id" ]                          ;
  }                                            ;
  //////////////////////////////////////////////
  if ( $Id > 0 )                               {
    if ( strlen ( $Pwd ) <= 0 )                {
      $QQ = "delete from {$Table}"             .
            " where `id` = {$Id}"              .
            " and `uuid` = {$Uuid}"            .
            " ;"                               ;
    } else                                     {
      $QQ = "update {$Table}"                  .
            " set `secret` = '{$Pwd}'"         .
            " where `uuid` = {$Uuid}"          .
              " and `name` = '{$Name}' ;"      ;
    }                                          ;
  } else                                       {
    $QQ = "insert into {$Table}"               .
          " (`uuid`,`name`,`secret`)"          .
          " values"                            .
          " ({$Uuid},'{$Name}','{$Pwd}') ;"    ;
  }                                            ;
  //////////////////////////////////////////////
  return $this -> Query ( $QQ )                ;
}

}

?>
