<?php
//////////////////////////////////////////////////////////////////////////////
// 代幣管理元件
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Token extends Columns                                                  {
//////////////////////////////////////////////////////////////////////////////
public $Id                                                                   ;
public $Uuid                                                                 ;
public $Owner                                                                ;
public $Tokens                                                               ;
public $Action                                                               ;
public $Reason                                                               ;
public $rType                                                                ;
public $Item                                                                 ;
public $Description                                                          ;
public $States                                                               ;
public $Creation                                                             ;
public $Modify                                                               ;
public $Updated                                                              ;
public $SkipQuotas                                                           ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> Id          = -1                                                  ;
  $this -> Uuid        =  0                                                  ;
  $this -> Owner       =  0                                                  ;
  $this -> Tokens      =  0                                                  ;
  $this -> Action      =  0                                                  ;
  $this -> Reason      =  0                                                  ;
  $this -> rType       =  0                                                  ;
  $this -> Item        =  0                                                  ;
  $this -> Description =  0                                                  ;
  $this -> States      =  0                                                  ;
  $this -> Creation    =  0                                                  ;
  $this -> Modify      =  0                                                  ;
  $this -> Updated     =  0                                                  ;
  $this -> SkipQuotas  =  0                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function assign ( $Item )                                             {
  $this -> Id          = $Item -> Id                                         ;
  $this -> Uuid        = $Item -> Uuid                                       ;
  $this -> Owner       = $Item -> Owner                                      ;
  $this -> Tokens      = $Item -> Tokens                                     ;
  $this -> Action      = $Item -> Action                                     ;
  $this -> Reason      = $Item -> Reason                                     ;
  $this -> rType       = $Item -> rType                                      ;
  $this -> Name        = $Item -> Name                                       ;
  $this -> Item        = $Item -> Item                                       ;
  $this -> Description = $Item -> Description                                ;
  $this -> States      = $Item -> States                                     ;
  $this -> Creation    = $Item -> Creation                                   ;
  $this -> Modify      = $Item -> Modify                                     ;
  $this -> Updated     = $Item -> Updated                                    ;
  $this -> SkipQuotas  = $Item -> SkipQuotas                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function tableItems ( )                                               {
  return [ "id"                                                              ,
           "uuid"                                                            ,
           "owner"                                                           ,
           "tokens"                                                          ,
           "action"                                                          ,
           "reason"                                                          ,
           "rtype"                                                           ,
           "item"                                                            ,
           "description"                                                     ,
           "states"                                                          ,
           "creation"                                                        ,
           "modify"                                                          ,
           "ltime"                                                         ] ;
}
//////////////////////////////////////////////////////////////////////////////
public function ItemPair ( $item )                                           {
  $a = strtolower ( $item )                                                  ;
  if ( "id"        == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Id                                ;
  }                                                                          ;
  if ( "uuid"      == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Uuid                              ;
  }                                                                          ;
  if ( "owner"     == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Owner                             ;
  }                                                                          ;
  if ( "tokens"    == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Tokens                            ;
  }                                                                          ;
  if ( "action"    == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Action                            ;
  }                                                                          ;
  if ( "reason"    == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Reason                            ;
  }                                                                          ;
  if ( "rtype"     == $a )                                                   {
    return "`{$a}` = " . (string) $this -> rType                             ;
  }                                                                          ;
  if ( "item"      == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Item                              ;
  }                                                                          ;
  if ( "description" == $a )                                                 {
    return "`{$a}` = " . (string) $this -> Description                       ;
  }                                                                          ;
  if ( "states"    == $a )                                                   {
    return "`{$a}` = " . (string) $this -> States                            ;
  }                                                                          ;
  if ( "creation"  == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Creation                          ;
  }                                                                          ;
  if ( "modify"    == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Modify                            ;
  }                                                                          ;
  if ( "ltime"     == $a )                                                   {
    return "`{$a}` = " . (string) $this -> Updated                           ;
  }                                                                          ;
  if ( "skipquotas" == $a )                                                  {
    return "`{$a}` = " . (string) $this -> SkipQuotas                        ;
  }                                                                          ;
  return ""                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function valueItems ( )                                               {
  return [ "owner"                                                           ,
           "tokens"                                                          ,
           "action"                                                          ,
           "reason"                                                          ,
           "rtype"                                                           ,
           "item"                                                            ,
           "description"                                                     ,
           "states"                                                          ,
           "creation"                                                        ,
           "modify"                                                        ] ;
}
//////////////////////////////////////////////////////////////////////////////
public function set ( $item , $V )                                           {
  $a = strtolower ( $item )                                                  ;
  if ( "id"          == $a ) $this -> Id          = $V                       ;
  if ( "uuid"        == $a ) $this -> Uuid        = $V                       ;
  if ( "owner"       == $a ) $this -> Owner       = $V                       ;
  if ( "tokens"      == $a ) $this -> Tokens      = $V                       ;
  if ( "action"      == $a ) $this -> Action      = $V                       ;
  if ( "reason"      == $a ) $this -> Reason      = $V                       ;
  if ( "rtype"       == $a ) $this -> rType       = $V                       ;
  if ( "item"        == $a ) $this -> Item        = $V                       ;
  if ( "description" == $a ) $this -> Description = $V                       ;
  if ( "states"      == $a ) $this -> States      = $V                       ;
  if ( "creation"    == $a ) $this -> Creation    = $V                       ;
  if ( "modify"      == $a ) $this -> Modify      = $V                       ;
  if ( "ltime"       == $a ) $this -> Updated     = $V                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function get ( $item )                                                {
  $a = strtolower ( $item )                                                  ;
  if ( "id"          == $a ) return (string) $this -> Id                     ;
  if ( "uuid"        == $a ) return (string) $this -> Uuid                   ;
  if ( "owner"       == $a ) return (string) $this -> Owner                  ;
  if ( "tokens"      == $a ) return (string) $this -> Tokens                 ;
  if ( "action"      == $a ) return (string) $this -> Action                 ;
  if ( "reason"      == $a ) return (string) $this -> Reason                 ;
  if ( "rtype"       == $a ) return (string) $this -> rType                  ;
  if ( "item"        == $a ) return (string) $this -> Item                   ;
  if ( "description" == $a ) return (string) $this -> Description            ;
  if ( "states"      == $a ) return (string) $this -> States                 ;
  if ( "creation"    == $a ) return (string) $this -> Creation               ;
  if ( "modify"      == $a ) return (string) $this -> Modify                 ;
  if ( "ltime"       == $a ) return (string) $this -> Updated                ;
  return ""                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function Pair ( $item )                                               {
  $V  = $this -> get ( $item )                                               ;
  return "`{$item}` = {$V}"                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function Pairs ( $Items                                             ) {
  $P = array          (                                                    ) ;
  foreach             ( $Items as $item                                    ) {
    array_push        ( $P , $this -> Pair ( $item )                       ) ;
  }                                                                          ;
  $Q = implode        ( " , " , $P                                         ) ;
  unset               ( $P                                                 ) ;
  return $Q                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function toString ( )                                                 {
  return sprintf ( "tkn6%08d" , gmp_mod ( $this -> Uuid , 100000000 ) )      ;
}
//////////////////////////////////////////////////////////////////////////////
public function fromString ( $S                                            ) {
  if                       ( 12 != strlen ( $S )                           ) {
    $this -> Uuid = 0                                                        ;
    return 0                                                                 ;
  }                                                                          ;
  $X = strtolower          ( $S                                            ) ;
  $C = substr              ( $X , 0 , 4                                    ) ;
  if                       ( $C != "tkn6"                                  ) {
    $this -> Uuid = 0                                                        ;
    return 0                                                                 ;
  }                                                                          ;
  $C = substr              ( $S , 0 , 4                                    ) ;
  $U = str_replace         ( $C , "34000000000" , $S                       ) ;
  $this -> Uuid = $U                                                         ;
  return $U                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function ValueString ( $X                                           ) {
  if                        ( $X < 0                                       ) {
    $X = - $X                                                                ;
  }                                                                          ;
  $T   = intval             ( $X      , 10                                 ) ;
  $M   = intval             ( $T % 10 , 10                                 ) ;
  $R   = intval             ( $T / 10 , 10                                 ) ;
  $D   = number_format      ( $R , 0 , "" , ","                            ) ;
  return "{$D}.{$M}"                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
public function TokenValue ( )                                               {
  return $this -> ValueString ( $this -> Tokens )                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function obtain ( $R )                                                {
  $this -> Id          = $R [ "id"          ]                                ;
  $this -> Uuid        = $R [ "uuid"        ]                                ;
  $this -> Owner       = $R [ "owner"       ]                                ;
  $this -> Tokens      = $R [ "tokens"      ]                                ;
  $this -> Action      = $R [ "action"      ]                                ;
  $this -> Reason      = $R [ "reason"      ]                                ;
  $this -> rType       = $R [ "rtype"       ]                                ;
  $this -> Item        = $R [ "item"        ]                                ;
  $this -> Description = $R [ "description" ]                                ;
  $this -> States      = $R [ "states"      ]                                ;
  $this -> Creation    = $R [ "creation"    ]                                ;
  $this -> Modify      = $R [ "modify"      ]                                ;
  $this -> Updated     = $R [ "ltime"       ]                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function toDateTimeString ( $ITEM                                     ,
                                   $TZ                                       ,
                                   $JOIN="T"                                 ,
                                   $DateFormat="Y-m-d"                       ,
                                   $TimeFormat="H:i:s"                     ) {
  $SD             = new StarDate (                                         ) ;
  $SD -> Stardate = $this -> get ( $ITEM                                   ) ;
  return $SD -> toDateTimeString ( $TZ , $JOIN , $DateFormat , $TimeFormat ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function InsertInto ( $Table )                                        {
  return "insert into {$Table} "                                             .
         "(`uuid`,`owner`,`tokens`,`action`,"                                .
          "`reason`,`rtype`,`item`,`description`,"                           .
          "`states`,`creation`,`modify`)"                                    .
          " values ("                                                        .
          (string) $this -> Uuid        . ","                                .
          (string) $this -> Owner       . ","                                .
          (string) $this -> Tokens      . ","                                .
          (string) $this -> Action      . ","                                .
          (string) $this -> Reason      . ","                                .
          (string) $this -> rType       . ","                                .
          (string) $this -> Item        . ","                                .
          (string) $this -> Description . ","                                .
          (string) $this -> States      . ","                                .
          (string) $this -> Creation    . ","                                .
          (string) $this -> Modify      . ") ;"                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetUuid          ( $DB , $Table , $Main                    ) {
  $BASE         = "3400000000000000000"                                      ;
  $RI           = new Relation   (                                         ) ;
  $TYPE         = $RI -> Types [ "Token" ]                                   ;
  $this -> Uuid = $DB -> GetLast ( $Table , "uuid" , $BASE                 ) ;
  if                             ( gmp_cmp ( $this -> Uuid , "0" ) <= 0    ) {
    return false                                                             ;
  }                                                                          ;
  $DB   -> AddUuid               ( $Main , $this -> Uuid , $TYPE           ) ;
  return $this -> Uuid                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateItems ( $DB , $TABLE , $ITEMS                        ) {
  $PRX   = $this -> Pairs   ( $ITEMS                                       ) ;
  $WHZ   = $DB -> WhereUuid ( $this -> Uuid , true                         ) ;
  $QQ    = "update {$TABLE} set {$PRX} {$WHZ}"                               ;
  return $DB -> Query       ( $QQ                                          ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Update         ( $DB , $TABLE                              ) {
  $ITEMS = $this -> valueItems (                                           ) ;
  $PRX   = $this -> Pairs      ( $ITEMS                                    ) ;
  $WHZ   = $DB   -> WhereUuid  ( $this -> Uuid , true                      ) ;
  $QQ    = "update {$TABLE} set {$PRX} {$WHZ}"                               ;
  unset                        ( $ITEMS                                    ) ;
  return $DB -> Query          ( $QQ                                       ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByQuery ( $DB , $QQ                                 ) {
  $qq   = $DB -> Query         ( $QQ                                       ) ;
  if                           ( $DB -> hasResult ( $qq )                  ) {
    $rr = $qq -> fetch_array   ( MYSQLI_BOTH                               ) ;
    $this     -> obtain        ( $rr                                       ) ;
    return true                                                              ;
  }                                                                          ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByUuid    ( $DB , $TABLE                            ) {
  $ITEMS = $this -> Items        (                                         ) ;
  $WHZ   = $DB -> WhereUuid      ( $this -> Uuid , true                    ) ;
  $QQ    = "select {$ITEMS} from {$TABLE} {$WHZ}"                            ;
  return $this -> ObtainsByQuery ( $DB , $QQ                               ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByReason ( $DB , $TABLE , $REASON )                   {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where `reason` = {$REASON}"                                        .
        " order by `creation` desc ;"                                        ;
  return $DB -> ObtainUuids     ( $QQ )                                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainRelated    ( $DB , $RELATIONS , $CLASSID             ) {
  $RI     = new Relation         (                                         ) ;
  $RI    -> set                  ( "first" , $CLASSID                      ) ;
  $RI    -> setT1                ( "Class"                                 ) ;
  $RI    -> setT2                ( "Token"                                 ) ;
  $RI    -> setRelation          ( "Subordination"                         ) ;
  $TOKENS = $RI -> Subordination ( $DB , $RELATIONS                        ) ;
  unset                          ( $RI                                     ) ;
  return $TOKENS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByClass       ( $DB , $TABLE , $RELATION , $CLASSID ) {
  $TOKENS = $this -> ObtainsByReason ( $DB , $TABLE    , $CLASSID          ) ;
  $TKNS   = $this -> ObtainRelated   ( $DB , $RELATION , $CLASSID          ) ;
  $TOKENS = $DB   -> JoinArray       ( $TOKENS , $TKNS                     ) ;
  return $TOKENS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsTrades ( $DB , $TOKENS                              ) {
  $QQ = "select `uuid` from {$TOKENS}"                                       .
        " where `owner` = " . (string) $this -> Owner                        .
         " and `action` = " . (string) $this -> Action                       .
         " and `states` = " . (string) $this -> States                       .
          " and `rtype` = " . (string) $this -> rType                        .
           " and `item` = " . (string) $this -> Item                         .
          " ;"                                                               ;
  return $DB -> ObtainUuids   ( $QQ                                        ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsConsumed ( $DB , $TOKENS , $NOW                     ) {
  $QQ = "select `uuid` from {$TOKENS}"                                       .
        " where `owner` = " . (string) $this -> Owner                        .
         " and `action` = " . (string) $this -> Action                       .
         " and `states` = " . (string) $this -> States                       .
          " and `rtype` = " . (string) $this -> rType                        .
           " and `item` = " . (string) $this -> Item                         .
        " and ( `creation` < {$NOW} )" .  " ;"                               ;
  return $DB -> ObtainUuids     ( $QQ                                      ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsSkipQuotas ( $DB , $TABLE                           ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> SkipQuotas = 0                                                    ;
  $OWID  = $this -> Owner                                                    ;
  $TKID  = $this -> Uuid                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `amount` from {$TABLE}"                                   .
           " where `owner` = {$OWID}"                                        .
            " and `reason` = {$TKID}"                                        .
            " and `action` = 3 ;"                                            ;
  $qq    = $DB -> Query           ( $QQ                                    ) ;
  if                              ( $DB -> hasResult ( $qq )               ) {
    $rr = $qq -> fetch_array      ( MYSQLI_BOTH                            ) ;
    $this -> SkipQuotas = $rr     [ 0                                      ] ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function JoinClass ( $DB , $TABLE , $CLASSID                        ) {
  $RI    = new Relation   (                                                ) ;
  $RI   -> set            ( "first"  , $CLASSID                            ) ;
  $RI   -> set            ( "second" , $this -> Uuid                       ) ;
  $RI   -> setT1          ( "Class"                                        ) ;
  $RI   -> setT2          ( "Token"                                        ) ;
  $RI   -> setRelation    ( "Subordination"                                ) ;
  $RI   -> Join           ( $DB , $TABLE                                   ) ;
  unset                   ( $RI                                            ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function RemoveWithClass ( $DB , $TABLE , $CLASSID                  ) {
  ////////////////////////////////////////////////////////////////////////////
  $RI  = new Relation           (                                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $RI -> set                    ( "first"  , $CLASSID                      ) ;
  $RI -> set                    ( "second" , $this -> Uuid                 ) ;
  $RI -> setT1                  ( "Class"                                  ) ;
  $RI -> setT2                  ( "Token"                                  ) ;
  $RI -> setRelation            ( "Subordination"                          ) ;
  $DB -> Query                  ( $RI -> Delete ( $TABLE )                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  unset                         ( $RI                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function CalculateTokens ( $DB , $TOKENS , $UU                      ) {
  ////////////////////////////////////////////////////////////////////////////
  if                            ( count ( $UU ) <= 0                       ) {
    return 0                                                                 ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $UUIDs = implode              ( " , " , $UU                              ) ;
  $QQ    = "select sum(`tokens`) from {$TOKENS}"                             .
           " where ( `uuid` in ( {$UUIDs} ) ) ;"                             ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> FetchOne        ( $QQ                                      ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetEarnedListings   ( $DB , $TABLE , $PUID , $ITEM         ) {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where ( `owner` = {$PUID} )"                                       .
        " and ( `action` in ( 1 , 3 ) )"                                     .
        " and ( `states` in ( 1 ) )"                                         .
        " and ( `item` = {$ITEM} ) ;"                                        ;
  return $DB -> ObtainUuids         ( $QQ                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetArrangedListings ( $DB , $TABLE , $PUID , $ITEM         ) {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where ( `owner` = {$PUID} )"                                       .
        " and ( `action` in ( 2 ) )"                                         .
        " and ( `states` in ( 1 , 2 , 3 ) )"                                 .
        " and ( `item` = {$ITEM} ) ;"                                        ;
  return $DB -> ObtainUuids         ( $QQ                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetConsumedListings ( $DB , $TABLE , $PUID , $ITEM         ) {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where ( `owner` = {$PUID} )"                                       .
        " and ( `action` in ( 2 ) )"                                         .
        " and ( `states` in ( 1 ) )"                                         .
        " and ( `item` = {$ITEM} ) ;"                                        ;
  return $DB -> ObtainUuids         ( $QQ                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetAllocatedListings ( $DB , $TABLE , $PUID , $ITEM , $SDT ) {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where ( `owner` = {$PUID} )"                                       .
        " and ( `action` in ( 2 ) )"                                         .
        " and ( `states` in ( 2 , 3 ) )"                                     .
        " and ( `item` = {$ITEM} )"                                          .
        " and ( `creation` >= {$SDT} ) ;"                                    ;
  return $DB -> ObtainUuids         ( $QQ                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetSpentListings    ( $DB , $TABLE , $PUID , $ITEM         ) {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where ( `owner` = {$PUID} )"                                       .
        " and ( `action` in ( 2 ) )"                                         .
        " and ( `states` in ( 1 , 3 ) )"                                     .
        " and ( `item` = {$ITEM} ) ;"                                        ;
  return $DB -> ObtainUuids         ( $QQ                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetTransferListings ( $DB , $TABLE , $PUID                 ) {
  $QQ = "select `uuid` from {$TABLE}"                                        .
        " where ( `owner` = {$PUID} )"                                       .
        " and ( `action` = 3 )"                                              .
        " and ( `states` = 3 )"                                              .
        " and ( `tokens` > 0 )"                                              .
        " order by `ltime` asc ;"                                            ;
  return $DB -> ObtainUuids         ( $QQ                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetTokensByFunction    ( $DB                                 ,
                                         $TABLE                              ,
                                         $PUID                               ,
                                         $ITEM                               ,
                                         $FUNC                             ) {
  ////////////////////////////////////////////////////////////////////////////
  $EMPTY    = true                                                           ;
  $TOTAL    = 0                                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $ITEMS    = $this -> $FUNC           ( $DB , $TABLE , $PUID , $ITEM      ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                                   ( count ( $ITEMS ) > 0              ) {
    //////////////////////////////////////////////////////////////////////////
    $EMPTY  = false                                                          ;
    $TOTAL  = $this -> CalculateTokens ( $DB , $TABLE , $ITEMS             ) ;
    //////////////////////////////////////////////////////////////////////////
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return array                                                               (
    "Empty" => $EMPTY                                                        ,
    "Total" => $TOTAL                                                        ,
  )                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetEarnedTokens          ( $DB , $TABLE , $PUID , $ITEM    ) {
  return $this -> GetTokensByFunction    ( $DB                               ,
                                           $TABLE                            ,
                                           $PUID                             ,
                                           $ITEM                             ,
                                           "GetEarnedListings"             ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetArrangedTokens        ( $DB , $TABLE , $PUID , $ITEM    ) {
  return $this -> GetTokensByFunction    ( $DB                               ,
                                           $TABLE                            ,
                                           $PUID                             ,
                                           $ITEM                             ,
                                           "GetArrangedListings"           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetConsumedTokens        ( $DB , $TABLE , $PUID , $ITEM    ) {
  return $this -> GetTokensByFunction    ( $DB                               ,
                                           $TABLE                            ,
                                           $PUID                             ,
                                           $ITEM                             ,
                                           "GetConsumedListings"           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetLastestTransferToken ( $DB , $TABLE                     ) {
  ////////////////////////////////////////////////////////////////////////////
  $OWNER = $this -> Owner                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `owner` = {$OWNER} )"                                   .
           " and ( `action` = 3 )"                                           .
           " and ( `states` = 3 )"                                           .
           " order by `ltime` asc"                                           .
           " limit 0 , 1 ;"                                                  ;
  return $DB -> FetchOne                ( $QQ                              ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateTransferTokens    ( $DB , $TABLE , $STATE , $NOW     ) {
  ////////////////////////////////////////////////////////////////////////////
  $TUID = $this -> Uuid                                                      ;
  $OUID = $this -> Description                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "update {$TABLE}"                                                  .
          " set `states` = {$STATE} , `modify` = {$NOW}"                     .
          " where ( `uuid` in ( {$TUID} , {$OUID} ) )"                       .
          " and ( `states` = 3 ) ;"                                          ;
  $DB  -> Query                         ( $QQ                              ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function AcceptTransferSkips     ( $DB , $TABLE                     ) {
  ////////////////////////////////////////////////////////////////////////////
  $TUID = $this -> Uuid                                                      ;
  $OUID = $this -> Description                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "update {$TABLE} set `action` = 3 , `states` = 7"                  .
          " where ( `reason` in ( {$TUID} , {$OUID} ) )"                     .
          " and ( `action` = 9 )"                                            .
          " and ( `states` = 8 ) ;"                                          ;
  $DB  -> Query                         ( $QQ                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "update {$TABLE} set `action` = 5 , `states` = 7"                  .
          " where ( `reason` in ( {$TUID} , {$OUID} ) )"                     .
          " and ( `action` = 7 )"                                            .
          " and ( `states` = 8 ) ;"                                          ;
  $DB  -> Query                         ( $QQ                              ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function CancelTransferSkips     ( $DB , $TABLE                     ) {
  ////////////////////////////////////////////////////////////////////////////
  $TUID = $this -> Uuid                                                      ;
  $OUID = $this -> Description                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "update {$TABLE} set `action` = 0"                                 .
          " where ( `reason` in ( {$TUID} , {$OUID} ) ) ;"                   ;
  $DB  -> Query                         ( $QQ                              ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateTransferSkips     ( $DB , $TABLE , $STATE , $NOW     ) {
  ////////////////////////////////////////////////////////////////////////////
  switch                                ( $STATE                           ) {
    case 1                                                                   :
      $this -> AcceptTransferSkips      ( $DB , $TABLE                     ) ;
    break                                                                    ;
    case 4                                                                   :
      $this -> CancelTransferSkips      ( $DB , $TABLE                     ) ;
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetOwnerTokenListings ( $DB , $TABLE , $ENDTIME            ) {
  ////////////////////////////////////////////////////////////////////////////
  $PUID = $this -> Owner                                                     ;
  $ITEM = $this -> Item                                                      ;
  $QQ   = "select `uuid` from {$TABLE}"                                      .
          " where ( `creation` < {$ENDTIME} )"                               .
          " and ( `owner` = {$PUID} )"                                       .
          " and ( `item` = {$ITEM} )"                                        .
          " and ( `states` in ( 1 , 3 , 4 ) )"                               .
          " and ( `action` in ( 1 , 2 , 3 , 4 ) )"                           .
          " order by `creation` asc ;"                                       ;
  return $DB -> ObtainUuids           ( $QQ                                ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ClassPoints ( $POINTS                                      ) {
  $PT   = intval            ( $POINTS , 10                                 ) ;
  $SG   =                   ( $PT < 0                                      ) ;
  if                        ( $SG                                          ) {
    $PT = - $PT                                                              ;
  }                                                                          ;
  $PD   = intval            ( $PT / 10 , 10                                ) ;
  $PR   = intval            ( $PT % 10 , 10                                ) ;
  $PP   = "{$PD}.{$PR}"                                                      ;
  if                        ( $SG                                          ) {
    $PP = "-{$PP}"                                                           ;
  }                                                                          ;
  return $PP                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
// 此處需要修改
//////////////////////////////////////////////////////////////////////////////
public function StudentSummary ( $DB , $PUID                               ) {
  ////////////////////////////////////////////////////////////////////////////
  $TKNTAB  = $GLOBALS [ "TableMapping" ] [ "Tokens" ]                        ;
  ////////////////////////////////////////////////////////////////////////////
  $HH      = new Parameters    (                                           ) ;
  $RI      = new Relation      (                                           ) ;
  $NOW     = new StarDate      (                                           ) ;
  $SUMMARY = array             (                                           ) ;
  $PTS     = 0                                                               ;
  $UTS     = 0                                                               ;
  $RTS     = 0                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $NOW    -> Now               (                                           ) ;
  $SDT     = $NOW -> Stardate                                                ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增/交易完成
  ////////////////////////////////////////////////////////////////////////////
  $this   -> Owner  = $PUID                                                  ;
  $this   -> Action = 1                                                      ;
  $this   -> States = 1                                                      ;
  $this   -> rType  = $RI -> Types [ "Trade" ]                               ;
  ////////////////////////////////////////////////////////////////////////////
  $UU      = $this -> ObtainsTrades   ( $DB , $TKNTAB                      ) ;
  $TOTAL   = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 賺取/交易完成 人物 => 其他人轉堂數給自己
  ////////////////////////////////////////////////////////////////////////////
  $this -> Owner  = $PUID                                                    ;
  $this -> Action = 3                                                        ;
  $this -> States = 1                                                        ;
  $this -> rType  = $RI -> Types [ "People" ]                                ;
  ////////////////////////////////////////////////////////////////////////////
  $UU    = $this -> ObtainsTrades   ( $DB , $TKNTAB                        ) ;
  $PIT   = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                  ) ;
  $TOTAL = $TOTAL + $PIT                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  // 消費/商議中 人物 => 轉堂數給其他人
  ////////////////////////////////////////////////////////////////////////////
  $this -> Owner  = $PUID                                                    ;
  $this -> Action = 2                                                        ;
  $this -> States = 3                                                        ;
  $this -> rType  = $RI -> Types [ "People" ]                                ;
  ////////////////////////////////////////////////////////////////////////////
  $UU    = $this -> ObtainsTrades   ( $DB , $TKNTAB                        ) ;
  $PIZ   = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                  ) ;
  $TOTAL = $TOTAL + $PIZ                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  // 賺取/交易完成 組織 => 從公司取得堂數
  ////////////////////////////////////////////////////////////////////////////
  $this -> Owner  = $PUID                                                    ;
  $this -> Action = 3                                                        ;
  $this -> States = 1                                                        ;
  $this -> rType  = $RI -> Types [ "Organization" ]                          ;
  ////////////////////////////////////////////////////////////////////////////
  $UU    = $this -> ObtainsTrades   ( $DB , $TKNTAB                        ) ;
  $OIT   = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                  ) ;
  $TOTAL = $TOTAL + $OIT                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $PTS   = $this -> ClassPoints     ( $TOTAL                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Owner  = $PUID                                                    ;
  $this -> Action = 2                                                        ;
  $this -> States = 1                                                        ;
  $this -> rType  = $RI -> Types [ "Class" ]                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $UU    = $this -> ObtainsConsumed ( $DB , $TKNTAB , $SDT                 ) ;
  $USED  = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 消費/交易完成 人物 => 轉堂數給其他人成功
  ////////////////////////////////////////////////////////////////////////////
  $this -> Owner  = $PUID                                                    ;
  $this -> Action = 2                                                        ;
  $this -> States = 1                                                        ;
  $this -> rType  = $RI -> Types [ "People" ]                                ;
  ////////////////////////////////////////////////////////////////////////////
  $UU    = $this -> ObtainsConsumed ( $DB , $TKNTAB , $SDT                 ) ;
  $OUD   = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                  ) ;
  $USED  = $USED + $OUD                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Owner  = $PUID                                                    ;
  $this -> Action = 2                                                        ;
  $this -> States = 1                                                        ;
  $this -> rType  = $RI -> Types [ "Organization" ]                          ;
  ////////////////////////////////////////////////////////////////////////////
  $UU    = $this -> ObtainsConsumed ( $DB , $TKNTAB , $SDT                 ) ;
  $OUD   = $this -> CalculateTokens ( $DB , $TKNTAB , $UU                  ) ;
  $USED  = $USED + $OUD                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $UTS   = $this -> ClassPoints     ( $USED                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $REMAIN = $TOTAL + $USED                                                   ;
  $RTS    = $this -> ClassPoints    ( $REMAIN                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $SUMMARY [ "All"     ] = $TOTAL                                            ;
  $SUMMARY [ "Used"    ] = $USED                                             ;
  $SUMMARY [ "Pocket"  ] = $REMAIN                                           ;
  ////////////////////////////////////////////////////////////////////////////
  $SUMMARY [ "Total"   ] = $PTS                                              ;
  $SUMMARY [ "Consume" ] = $UTS                                              ;
  $SUMMARY [ "Remain"  ] = $RTS                                              ;
  ////////////////////////////////////////////////////////////////////////////
  return $SUMMARY                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function ActionString ( )                                             {
  global $TokenActions                                                       ;
  return $TokenActions [ $this -> Action ]                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function ActionListing ( $JAVAFUNC = "TokenActions"                 ) {
  ////////////////////////////////////////////////////////////////////////////
  global $TokenActions                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $TUID   = $this -> Uuid                                                    ;
  $JSC    = "{$JAVAFUNC}(this.value,'{$TUID}');"                             ;
  ////////////////////////////////////////////////////////////////////////////
  $HT     = new Html          (                                            ) ;
  $HT    -> setTag            ( "select"                                   ) ;
  $HT    -> setSplitter       ( "\n"                                       ) ;
  $HT    -> addOptions        ( $TokenActions , $this -> Action            ) ;
  $HT    -> AddPair           ( "onchange"    , $JSC                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function ActionTD ( $HD                                               ,
                           $editable = false                                 ,
                           $JAVAFUNC = "TokenActions"                      ) {
  if                     ( $editable                                       ) {
    $HD -> AddTag        ( $this -> ActionListing ( $JAVAFUNC            ) ) ;
  } else                                                                     {
    $HD -> AddText       ( $this -> ActionString  (                      ) ) ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function StatesString ( )                                             {
  global $TokenStates                                                        ;
  return $TokenStates [ $this -> States ]                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function StatesListing ( $JAVAFUNC = "TokenStates"                  ) {
  ////////////////////////////////////////////////////////////////////////////
  global $TokenStates                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  $TUID = $this -> Uuid                                                      ;
  $JTS  = "{$JAVAFUNC}(this.value,'{$TUID}');"                               ;
  ////////////////////////////////////////////////////////////////////////////
  $HT   = new Html            (                                            ) ;
  $HT  -> setTag              ( "select"                                   ) ;
  $HT  -> setSplitter         ( "\n"                                       ) ;
  $HT  -> addOptions          ( $TokenStates , $this -> States             ) ;
  $HT  -> AddPair             ( "onchange"   , $JTS                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function StatesTD ( $HD                                               ,
                           $editable = false                                 ,
                           $JAVAFUNC = "TokenStates"                       ) {
  if                     ( $editable                                       ) {
    $HD -> AddTag        ( $this -> StatesListing ( $JAVAFUNC            ) ) ;
  } else                                                                     {
    $HD -> AddText       ( $this -> StatesString  (                      ) ) ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function addDateTimeInput      ( $ITEM                                ,
                                        $TZ                                  ,
                                        $JAVAFUNC = "TokenTimeChanged"       ,
                                        $CLASSID  = "DateTimeInput" ) {
  $TUID   = $this -> Uuid                                                    ;
  $TDT    = $this -> toDateTimeString ( $ITEM                                ,
                                        $TZ                                  ,
                                        "T"                                  ,
                                        "Y-m-d"                              ,
                                        "H:i:s"                            ) ;
  $JSC    = "TokenTimeChanged(this.value,'{$ITEM}','{$TUID}') ;"             ;
  $INP    = new Html                  (                                    ) ;
  $INP   -> setInput                  (                                    ) ;
  $INP   -> AddPair                   ( "type"     , "datetime-local"      ) ;
  $INP   -> SafePair                  ( "class"    , $CLASSID              ) ;
  $INP   -> AddPair                   ( "step"     , "1"                   ) ;
  $INP   -> AddPair                   ( "value"    , $TDT                  ) ;
  $INP   -> AddPair                   ( "onchange" , $JSC                  ) ;
  return $INP                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addDateTime($HD,$ITEM,$TZ,$editable=false)
{
  ////////////////////////////////////////////////////
  global $Translations                               ;
  global $WeekDays                                   ;
  global $AMPM                                       ;
  ////////////////////////////////////////////////////
  if ( $editable )                                   {
    $DTI = $this -> addDateTimeInput ( $ITEM , $TZ ) ;
    $HD -> AddTag                    ( $DTI        ) ;
  } else                                             {
    $SD  = new StarDate (                          ) ;
    $SD -> Stardate = $this -> Creation              ;
    $SW  = $WeekDays   [ $SD -> Weekday ( $TZ )    ] ;
    $SP  = $AMPM       [ $SD -> isPM    ( $TZ )    ] ;
    $SJ  = " {$SW} {$SP} "                           ;
    $DTI = $this -> toDateTimeString                 (
                             $ITEM                   ,
                             $TZ                     ,
                             $SJ                     ,
                             "Y/m/d"                 ,
                             "H:i:s"               ) ;
    $HD -> AddPair ( "nowrap" , "nowrap"           ) ;
    $HD -> AddText ( $DTI                          ) ;
  }                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function tokenInput($TKNCLASS="NameInput")
{
  $TJS  = "TokensChanged(this.value,'{$this->Uuid}') ;" ;
  $TIP  = new HtmlTag (                              )  ;
  ///////////////////////////////////////////////////////
  $TIP -> setInput    (                              )  ;
  $TIP -> AddPair     ( "type"     , "number"        )  ;
  $TIP -> AddPair     ( "size"     , "8"             )  ;
  $TIP -> SafePair    ( "class"    , $TKNCLASS       )  ;
  $TIP -> AddPair     ( "min"      , "-100000"       )  ;
  $TIP -> AddPair     ( "max"      ,  "100000"       )  ;
  $TIP -> AddPair     ( "step"     , "1"             )  ;
  $TIP -> AddPair     ( "onchange" , $TJS            )  ;
  $TIP -> AddPair     ( "value"    , $this -> Tokens )  ;
  ///////////////////////////////////////////////////////
  return $TIP                                           ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addTokens($HD,$TKNCLASS="NameInput",$editable=false)
{
  if                           ( $editable ) {
    $DTV = $this -> tokenInput ( $TKNCLASS ) ;
    $HD -> AddTag              ( $DTV      ) ;
  } else                                     {
    $DTV = $this -> TokenValue (           ) ;
    $HD -> AddText             ( $DTV      ) ;
  }                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function skipsInput($TKNCLASS="NameInput")
{
  $TJS  = "SkipsChanged(this.value,'{$this->Owner}','{$this->Uuid}') ;" ;
  $TIP  = new HtmlTag (                                  )              ;
  ///////////////////////////////////////////////////////////////////////
  $TIP -> setInput    (                                  )              ;
  $TIP -> AddPair     ( "type"     , "number"            )              ;
  $TIP -> AddPair     ( "size"     , "8"                 )              ;
  $TIP -> SafePair    ( "class"    , $TKNCLASS           )              ;
  $TIP -> AddPair     ( "min"      , "0"                 )              ;
  $TIP -> AddPair     ( "max"      ,  "100000"           )              ;
  $TIP -> AddPair     ( "step"     , "1"                 )              ;
  $TIP -> AddPair     ( "onchange" , $TJS                )              ;
  $TIP -> AddPair     ( "value"    , $this -> SkipQuotas )              ;
  ///////////////////////////////////////////////////////////////////////
  return $TIP                                                           ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addSkips($HD,$TKNCLASS="NameInput",$editable=false)
{
  if                           ( $editable ) {
    $DTV = $this -> skipsInput ( $TKNCLASS ) ;
    $HD -> AddTag              ( $DTV      ) ;
  } else                                     {
    $DTV = $this -> SkipQuotas               ;
    $HD -> AddText             ( $DTV      ) ;
  }                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function ownerInput($IDV,$INPCLASS="NameInput")
{
  $JSC  = "changeOwner(this.value,'{$this->Uuid}') ;" ;
  /////////////////////////////////////////////////////
  $INP  = new HtmlTag (                        )      ;
  $INP -> setInput    (                        )      ;
  $INP -> AddPair     ( "type"     , "text"    )      ;
  $INP -> AddPair     ( "class"    , $INPCLASS )      ;
  $INP -> AddPair     ( "onchange" , $JSC      )      ;
  $INP -> SafePair    ( "value"    , $IDV      )      ;
  /////////////////////////////////////////////////////
  return $INP                                         ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addOwner($HD,$INPCLASS="NameInput",$editable=false)
{
  $HH    = new Parameters      (                  ) ;
  if ( gmp_cmp ( $this -> Owner , "0" ) > 0 )       {
    $IDV = $HH -> PeopleString ( $this -> Owner   ) ;
  } else $IDV = ""                                  ;
  if                           ( $editable        ) {
    $DTV = $this -> ownerInput ( $IDV , $INPCLASS ) ;
    $HD -> AddTag              ( $DTV             ) ;
  } else                                            {
    $HD -> AddText             ( $IDV             ) ;
  }                                                 ;
  unset                        ( $HH              ) ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addRemoveToken ( $CLASSID , $BTNCLASS = "SelectionButton" )  {
  ////////////////////////////////////////////////////////////
  global $Translations                                       ;
  ////////////////////////////////////////////////////////////
  $JSC  = "RemoveToken('{$this->Uuid}','$CLASSID') ;"        ;
  ////////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                                    ) ;
  $BTN -> setTag      ( "button"                           ) ;
  $BTN -> AddPair     ( "class"   , $BTNCLASS              ) ;
  $BTN -> AddPair     ( "onclick" , $JSC                   ) ;
  $BTN -> AddText     ( $Translations [ "Tokens::Remove" ] ) ;
  ////////////////////////////////////////////////////////////
  return $BTN                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addAppendButton ( $CLASSID , $BTNCLASS = "SelectionButton" ) {
  ////////////////////////////////////////////////////////////
  global $Translations                                       ;
  ////////////////////////////////////////////////////////////
  $JSC  = "AppendToken('$CLASSID') ;"                        ;
  ////////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                                    ) ;
  $BTN -> setTag      ( "button"                           ) ;
  $BTN -> AddPair     ( "class"   , $BTNCLASS              ) ;
  $BTN -> AddPair     ( "onclick" , $JSC                   ) ;
  $BTN -> AddText     ( $Translations [ "Tokens::Append" ] ) ;
  ////////////////////////////////////////////////////////////
  return $BTN                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// to be obsoleted
//////////////////////////////////////////////////////////////////////////////
public function addSettlement ( $CLASSID , $BTNCLASS = "SelectionButton" )   {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC    = "ClassSettlement('$CLASSID') ;"                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $BTN    = new Html          (                                            ) ;
  $BTN   -> setTag            ( "button"                                   ) ;
  $BTN   -> AddPair           ( "class"   , $BTNCLASS                      ) ;
  $BTN   -> AddPair           ( "onclick" , $JSC                           ) ;
  $BTN   -> AddText           ( $Translations [ "Tokens::Settlement" ]     ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $BTN                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
