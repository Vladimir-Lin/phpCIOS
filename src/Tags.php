<?php
//////////////////////////////////////////////////////////////////////////////
// 分類標籤元件
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Tags extends Columns                                                   {
//////////////////////////////////////////////////////////////////////////////
public $Id                                                                   ;
public $Uuid                                                                 ;
public $Used                                                                 ;
public $Type                                                                 ;
public $Table                                                                ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Id    = -1                                                        ;
  $this -> Uuid  =  0                                                        ;
  $this -> Used  =  1                                                        ;
  $this -> Type  =  0                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Table = $GLOBALS [ "TableMapping" ] [ "Tags" ]                    ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function assign ( $Item )                                             {
  $this -> Id   = $Item -> Id                                                ;
  $this -> Uuid = $Item -> Uuid                                              ;
  $this -> Used = $Item -> Used                                              ;
  $this -> Type = $Item -> Type                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function tableItems (             )                                   {
  $S = array               (             )                                   ;
  array_push               ( $S , "id"   )                                   ;
  array_push               ( $S , "uuid" )                                   ;
  array_push               ( $S , "used" )                                   ;
  array_push               ( $S , "type" )                                   ;
  return $S                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function valueItems (             )                                   {
  $S = array               (             )                                   ;
  array_push               ( $S , "used" )                                   ;
  array_push               ( $S , "type" )                                   ;
  return $S                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function ItemPair ( $item )                                           {
  $a = strtolower ( $item )                                                  ;
  if ( "id"   == $a )                                                        {
    return "`{$a}` = " . (string) $this -> Id                                ;
  }                                                                          ;
  if ( "uuid" == $a )                                                        {
    return "`{$a}` = " . (string) $this -> Uuid                              ;
  }                                                                          ;
  if ( "used" == $a )                                                        {
    return "`{$a}` = " . (string) $this -> Used                              ;
  }                                                                          ;
  if ( "type" == $a )                                                        {
    return "`{$a}` = " . (string) $this -> Type                              ;
  }                                                                          ;
  return ""                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function set ( $item , $V )                                           {
  $a = strtolower ( $item )                                                  ;
  if ( "id"   == $a ) $this -> Id   = $V                                     ;
  if ( "uuid" == $a ) $this -> Uuid = $V                                     ;
  if ( "used" == $a ) $this -> Used = $V                                     ;
  if ( "type" == $a ) $this -> Type = $V                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function get ( $item )                                                {
  $a = strtolower ( $item )                                                  ;
  if ( "id"   == $a ) return (string) $this -> Id                            ;
  if ( "uuid" == $a ) return (string) $this -> Uuid                          ;
  if ( "used" == $a ) return (string) $this -> Used                          ;
  if ( "type" == $a ) return (string) $this -> Type                          ;
  return ""                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function Pair ( $item )                                               {
  $V = $this -> get ( $item )                                                ;
  return "`{$item}` = {$V}"                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function Pairs ( $Items )                                             {
  $P = array ( )                                                             ;
  foreach ( $Items as $item )                                                {
    array_push ( $P , $this -> Pair ( $item ) )                              ;
  }                                                                          ;
  $Q = implode ( " , " , $P )                                                ;
  unset        ( $P         )                                                ;
  return $Q                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function setType ( $TYPE , $USED = 1                                ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Type = $TYPE                                                      ;
  $this -> Used = $USED                                                      ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function obtain ( $R )                                                {
  $this -> Id   = $R [ "id"   ]                                              ;
  $this -> Uuid = $R [ "uuid" ]                                              ;
  $this -> Used = $R [ "used" ]                                              ;
  $this -> Type = $R [ "type" ]                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetUuid ( $DB , $Table , $Main )                             {
  $BASE         = "2800000000000000000"                                      ;
  $RI           = new Relation ( )                                           ;
  $TYPE         = $RI -> Types [ "Tag" ]                                     ;
  $this -> Uuid = $DB -> GetLast ( $Table , "uuid" , $BASE )                 ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false                   ;
  $DB -> AddUuid ( $Main , $this -> Uuid , $TYPE )                           ;
  return $this -> Uuid                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateItems ( $DB , $TABLE , $ITEMS )                        {
  $PRX   = $this -> Pairs ( $ITEMS )                                         ;
  $QQ    = "update {$TABLE} set {$PRX} "                                     .
           $DB -> WhereUuid ( $this -> Uuid , true )                         ;
  return $DB -> Query ( $QQ )                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function Update ( $DB , $TABLE )                                      {
  $ITEMS = $this -> valueItems (        )                                    ;
  $PRX   = $this -> Pairs      ( $ITEMS )                                    ;
  $QQ    = "update {$TABLE} set {$PRX} "                                     .
           $DB -> WhereUuid ( $this -> Uuid , true )                         ;
  unset ( $ITEMS )                                                           ;
  return $DB -> Query ( $QQ )                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByQuery ( $DB , $QQ                                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $qq = $DB -> Query           ( $QQ                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $DB -> hasResult ( $qq )                  ) {
    $rr = $qq -> fetch_array   ( MYSQLI_BOTH                               ) ;
    $this     -> obtain        ( $rr                                       ) ;
    return true                                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByUuid    ( $DB , $TABLE = ""                       ) {
  ////////////////////////////////////////////////////////////////////////////
  if                             ( strlen ( $TABLE ) <= 0                  ) {
    $TABLE = $this -> Table                                                  ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ITS  = $this -> Items         (                                         ) ;
  $WUS  = $DB   -> WhereUuid     ( $this -> Uuid , true                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ = "select {$ITS} from {$TABLE} {$WUS}"                                 ;
  return $this -> ObtainsByQuery ( $DB , $QQ                               ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainListings ( $DB , $TABLE = ""                         ) {
  ////////////////////////////////////////////////////////////////////////////
  if                           ( strlen ( $TABLE ) <= 0                    ) {
    $TABLE = $this -> Table                                                  ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TYPE   = $this -> Type                                                    ;
  $USED   = $this -> Used                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ     = "select `uuid` from {$TABLE}"                                    .
            " where ( `type` = {$TYPE} )"                                    .
              " and ( `used` = {$USED} )"                                    .
            " order by `id` asc ;"                                           ;
  return $DB -> ObtainUuids    ( $QQ                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetListings      ( $DB , $TYPE , $TABLE = ""               ) {
  ////////////////////////////////////////////////////////////////////////////
  $this        -> setType        (       $TYPE                             ) ;
  return $this -> ObtainListings ( $DB ,         $TABLE                    ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function SortTags           ( $DB                                     ,
                                     $TABLE                                  ,
                                     $TAGS                                   ,
                                     $ITEM  = "id"                           ,
                                     $ORDER = "asc"                        ) {
  ////////////////////////////////////////////////////////////////////////////
  $CXLISTS    = implode            ( " , " , $TAGS                         ) ;
  $QQ         = "select `uuid` from {$TABLE}"                                .
                " where ( `used` = 1 )"                                      .
                " and ( `uuid` in ( $CXLISTS ) )"                            .
                " order by `{$ITEM}` {$ORDER} ;"                             ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids        ( $QQ                                   ) ;
}
//////////////////////////////////////////////////////////////////////////////
function FilterType                    ( $DB , $TAGS , $TYPE , $TABLE = "" ) {
  ////////////////////////////////////////////////////////////////////////////
  if                                   ( count ( $TAGS ) <= 0              ) {
    return $TAGS                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( strlen ( $TABLE ) <= 0                    ) {
    $TABLE = $this -> Table                                                  ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TLISTS = implode                    ( " , " , $TAGS                     ) ;
  $QQ     = "select `uuid` from {$TABLE}"                                    .
            " where ( `type` = {$TYPE} )"                                    .
              " and ( `used` = 1 )"                                          .
            " and ( `uuid` in ( {$TLISTS} ) )"                               .
            " order by `id` asc ;"                                           ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids            ( $QQ                               ) ;
}

//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
