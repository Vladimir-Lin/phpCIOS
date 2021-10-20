<?php
//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////
namespace CIOS ;
//////////////////////////////////////////////////////////////////////////////
class Periode extends Columns
{
//////////////////////////////////////////////////////////////////////////////
public $Id        ;
public $Uuid      ;
public $Type      ;
public $Used      ;
public $Start     ;
public $End       ;
public $States    ;
public $Update    ;
public $TermCount ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )
{
  $this -> Clear ( ) ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )
{
}
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )
{
  $this -> Id     = -1 ;
  $this -> Uuid   =  0 ;
  $this -> Type   =  1 ;
  $this -> Used   =  1 ;
  $this -> Start  =  0 ;
  $this -> End    =  0 ;
  $this -> States =  1 ;
  $this -> Update =  0 ;
}
//////////////////////////////////////////////////////////////////////////////
public function assign($Item)
{
  $this -> Id        = $Item -> Id        ;
  $this -> Uuid      = $Item -> Uuid      ;
  $this -> Type      = $Item -> Type      ;
  $this -> Used      = $Item -> Used      ;
  $this -> Start     = $Item -> Start     ;
  $this -> End       = $Item -> End       ;
  $this -> States    = $Item -> States    ;
  $this -> Update    = $Item -> Update    ;
  $this -> TermCount = $Item -> TermCount ;
}
//////////////////////////////////////////////////////////////////////////////
public function tableItems()
{
  $S = array (               ) ;
  array_push ( $S , "id"     ) ;
  array_push ( $S , "uuid"   ) ;
  array_push ( $S , "type"   ) ;
  array_push ( $S , "used"   ) ;
  array_push ( $S , "start"  ) ;
  array_push ( $S , "end"    ) ;
  array_push ( $S , "states" ) ;
  array_push ( $S , "ltime"  ) ;
  return $S                    ;
}
//////////////////////////////////////////////////////////////////////////////
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
//////////////////////////////////////////////////////////////////////////////
public function Items( $S = "," )
{
  $X = $this -> tableItems (         ) ;
  $L = $this -> JoinItems  ( $X , $S ) ;
  unset                    ( $X      ) ;
  return $L                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function valueItems()
{
  $S = array (               ) ;
  array_push ( $S , "type"   ) ;
  array_push ( $S , "used"   ) ;
  array_push ( $S , "start"  ) ;
  array_push ( $S , "end"    ) ;
  array_push ( $S , "states" ) ;
  return $S                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function set($item,$V)
{
  $a = strtolower ( $item )                  ;
  if ( "id"     == $a ) $this -> Id     = $V ;
  if ( "uuid"   == $a ) $this -> Uuid   = $V ;
  if ( "type"   == $a ) $this -> Type   = $V ;
  if ( "used"   == $a ) $this -> Used   = $V ;
  if ( "start"  == $a ) $this -> Start  = $V ;
  if ( "end"    == $a ) $this -> End    = $V ;
  if ( "states" == $a ) $this -> States = $V ;
  if ( "ltime"  == $a ) $this -> Update = $V ;
}
//////////////////////////////////////////////////////////////////////////////
public function get($item)
{
  $a = strtolower ( $item )                             ;
  if ( "id"     == $a ) return (string) $this -> Id     ;
  if ( "uuid"   == $a ) return (string) $this -> Uuid   ;
  if ( "type"   == $a ) return (string) $this -> Type   ;
  if ( "used"   == $a ) return (string) $this -> Used   ;
  if ( "start"  == $a ) return (string) $this -> Start  ;
  if ( "end"    == $a ) return (string) $this -> End    ;
  if ( "states" == $a ) return (string) $this -> States ;
  if ( "ltime"  == $a ) return (string) $this -> Update ;
  return ""                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function Pair($item)
{
  return "`{$item}` = " . $this -> get ( $item ) ;
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
public function ItemPair($item)
{
  $a = strtolower ( $item )                          ;
  if ( "id"        == $a )                           {
    return "`{$a}` = " . (string) $this -> Id        ;
  }                                                  ;
  if ( "uuid"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Uuid      ;
  }                                                  ;
  if ( "type"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Type      ;
  }                                                  ;
  if ( "used"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Used      ;
  }                                                  ;
  if ( "start"     == $a )                           {
    return "`{$a}` = " . (string) $this -> Start     ;
  }                                                  ;
  if ( "end"       == $a )                           {
    return "`{$a}` = " . (string) $this -> End       ;
  }                                                  ;
  if ( "states"    == $a )                           {
    return "`{$a}` = " . (string) $this -> States    ;
  }                                                  ;
  if ( "ltime"     == $a )                           {
    return "`{$a}` = " . (string) $this -> Update    ;
  }                                                  ;
  return ""                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function isValid ( )
{
  return ( gmp_cmp ( $this -> Uuid , 0 ) > 0 ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function toString ( )
{
  return sprintf ( "prd9%08d" , gmp_mod ( $this -> Uuid , 100000000 ) ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function fromString ( $S                                            ) {
  ////////////////////////////////////////////////////////////////////////////
  if                       ( 12 != strlen ( $S )                           ) {
    $this -> Uuid = 0                                                        ;
    return $this -> Uuid                                                     ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $X       = strtolower    ( $S                                            ) ;
  $C       = substr        ( $X , 0 , 4                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                       ( $C != "prd9"                                  ) {
    $this -> Uuid = 0                                                        ;
    return $this -> Uuid                                                     ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $C       = substr        ( $S , 0 , 4                                    ) ;
  $U       = str_replace   ( $C , "35000000000" , $S                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $this   -> Uuid = $U                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Uuid                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function setType ( $TYPE )
{
  $this -> Type = $TYPE ;
}
//////////////////////////////////////////////////////////////////////////////
public function setStates($STATES)
{
  $this -> States = $STATES ;
}
//////////////////////////////////////////////////////////////////////////////
public function setInterval($SECONDS)
{
  $this -> End = gmp_add ( $this -> Start , $SECONDS ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function setNow($shrink=false)
{
  $SD    = new StarDate (           ) ;
  $SD   -> Now          (           ) ;
  if                    ( $shrink   ) {
    $SD -> ShrinkMinute (           ) ;
  }                                   ;
  $this -> Start = $SD -> Stardate    ;
  $this -> setInterval  ( 86400     ) ;
  unset                 ( $SD       ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function setStart($DATETIME,$TZ="")
{
  $SD    = new StarDate (                 ) ;
  $SD   -> fromInput    ( $DATETIME , $TZ ) ;
  $this -> Start = $SD -> Stardate          ;
  unset                 ( $SD             ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function setEnd($DATETIME,$TZ="")
{
  $SD    = new StarDate (                 ) ;
  $SD   -> fromInput    ( $DATETIME , $TZ ) ;
  $this -> End = $SD -> Stardate            ;
  unset                 ( $SD             ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function setPeriod($STARTTIME,$ENDTIME,$TZ="")
{
  $this -> setStart ( $STARTTIME , $TZ ) ;
  $this -> setEnd   ( $ENDTIME   , $TZ ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function isCorrect()
{
  return ( gmp_cmp ( $this -> End , $this -> Start ) > 0 ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function TypeString ( )
{
  //////////////////////////////////////////
  global $AllPeriodTypes                   ;
  //////////////////////////////////////////
  return $AllPeriodTypes [ $this -> Type ] ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeItem($item,$TZ)
{
  $ZZ = "0"                                      ;
  $a = strtolower ( $item )                      ;
  if ( "start" == $a ) $ZZ = $this -> Start      ;
  if ( "end"   == $a ) $ZZ = $this -> End        ;
  if ( strlen  ( $ZZ       ) <= 0 ) return false ;
  if ( gmp_cmp ( $ZZ , "0" ) <= 0 ) return false ;
  $SD             = new StarDate      (     )    ;
  $SD -> Stardate = $ZZ                          ;
  $DD             = $SD -> toDateTime ( $TZ )    ;
  unset                               ( $SD )    ;
  return $DD                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeFormat($fmt,$item,$TZ)
{
  $DD = $this -> TimeItem ( $item , $TZ ) ;
  if ( ! $DD ) return ""                  ;
  $FMT = $DD  -> format   ( $fmt        ) ;
  unset                   ( $DD         ) ;
  return $FMT                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function toTimeString            (
                  $TZ                   ,
                  $item                 ,
                  $JOIN       = "T"     ,
                  $DateFormat = "Y-m-d" ,
                  $TimeFormat = "H:i:s" )
{
  $ZZ = "0"                                                                  ;
  $a = strtolower ( $item )                                                  ;
  if ( "start" == $a ) $ZZ = $this -> Start                                  ;
  if ( "end"   == $a ) $ZZ = $this -> End                                    ;
  if ( strlen  ( $ZZ       ) <= 0 ) return false                             ;
  if ( gmp_cmp ( $ZZ , "0" ) <= 0 ) return false                             ;
  $SD  = new StarDate ( )                                                    ;
  $SD -> Stardate = $ZZ                                                      ;
  $SS  = $SD -> toDateTimeString ( $TZ , $JOIN , $DateFormat , $TimeFormat ) ;
  unset ( $SD )                                                              ;
  return $SS                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function toLongString            (
                  $TZ                   ,
                  $item                 ,
                  $DateFormat = "Y-m-d" ,
                  $TimeFormat = "H:i:s" )
{
  $ZZ = "0"                                                      ;
  $a = strtolower ( $item )                                      ;
  if ( "start" == $a ) $ZZ = $this -> Start                      ;
  if ( "end"   == $a ) $ZZ = $this -> End                        ;
  if ( strlen  ( $ZZ       ) <= 0 ) return false                 ;
  if ( gmp_cmp ( $ZZ , "0" ) <= 0 ) return false                 ;
  $SD  = new StarDate ( )                                        ;
  $SD -> Stardate = $ZZ                                          ;
  $SS  = $SD -> toLongString ( $TZ , $DateFormat , $TimeFormat ) ;
  unset ( $SD )                                                  ;
  return $SS                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function toDateString            (
                  $TZ                   ,
                  $item                 ,
                  $DateFormat = "Y-m-d" )
{
  $ZZ = "0"                                        ;
  $a = strtolower ( $item )                        ;
  if ( "start" == $a ) $ZZ = $this -> Start        ;
  if ( "end"   == $a ) $ZZ = $this -> End          ;
  if ( strlen  ( $ZZ       ) <= 0 ) return false   ;
  if ( gmp_cmp ( $ZZ , "0" ) <= 0 ) return false   ;
  $SD  = new StarDate ( )                          ;
  $SD -> Stardate = $ZZ                            ;
  $SS  = $SD -> toDateString ( $TZ , $DateFormat ) ;
  unset ( $SD )                                    ;
  return $SS                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function toDuration ( )                                               {
  $DT  = gmp_sub ( $this -> End , $this -> Start )                           ;
  if             ( gmp_cmp ( $DT , 0 ) < 0       )                           {
    return "00:00"                                                           ;
  }                                                                          ;
  $HH  = intval  ( $DT / 3600   , 10             )                           ;
  $DT  = gmp_sub ( $DT          , $HH * 3600     )                           ;
  $MM  = intval  ( $DT /   60   , 10             )                           ;
  $DT  = gmp_sub ( $DT          , $MM *   60     )                           ;
  $DT  = intval  ( $DT          , 10             )                           ;
  if ( $MM < 10 ) $MM = "0{$MM}"                                             ;
  if ( $DT < 10 ) $DT = "0{$DT}"                                             ;
  if             ( $HH > 0                       )                           {
    $DS = "{$HH}:{$MM}:{$DT}"                                                ;
  } else                                                                     {
    $DS = "{$MM}:{$DT}"                                                      ;
  }                                                                          ;
  return $DS                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function obtain($R)
{
  $this -> Id     = $R [ "id"     ] ;
  $this -> Uuid   = $R [ "uuid"   ] ;
  $this -> Type   = $R [ "type"   ] ;
  $this -> Used   = $R [ "used"   ] ;
  $this -> Start  = $R [ "start"  ] ;
  $this -> End    = $R [ "end"    ] ;
  $this -> States = $R [ "states" ] ;
  $this -> Update = $R [ "ltime"  ] ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetUuid ( $DB , $Table , $Main )
{
  global $DataTypes                                           ;
  $BASE         = "3500000000000000000"                       ;
  $TYPE         = $DataTypes [ "Period" ]                     ;
  $this -> Uuid = $DB -> LastUuid ( $Table , "uuid" , $BASE ) ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false    ;
  $DB -> AddUuid ( $Table , $this -> Uuid , $this -> Type )   ;
  $DB -> AddUuid ( $Main  , $this -> Uuid , $TYPE         )   ;
  return $this -> Uuid                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateItems ( $DB , $TABLE , $ITEMS )
{
  $QQ    = "update " . $TABLE . " set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )                ;
  return $DB -> Query ( $QQ )                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function Update ( $DB , $TABLE )
{
  $ITEMS = $this -> valueItems ( )                                  ;
  $QQ    = "update " . $TABLE . " set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )                ;
  unset ( $ITEMS )                                                  ;
  return $DB -> Query ( $QQ )                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByUuid ( $DB , $TABLE )
{
  $IT = $this -> Items   (                      ) ;
  $WH = $DB -> WhereUuid ( $this -> Uuid , true ) ;
  $QQ = "select {$IT} from {$TABLE} {$WH}"        ;
  $qq = $DB -> Query ( $QQ )                      ;
  if ( $DB -> hasResult ( $qq ) )                 {
    $rr = $qq -> fetch_array ( MYSQLI_BOTH )      ;
    $this     -> obtain      ( $rr         )      ;
    return true                                   ;
  }                                               ;
  return false                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsDuration ( $DB , $TABLE , $NOW , $TYPE )
{
  $QQ = "select `uuid` from {$TABLE}"     .
          " where ( `used` = 1 )"         .
          " and ( `states` = 1 )"         .
            " and ( `type` = {$TYPE} )"   .
        " and ( ( `start` <= {$NOW} )"    .
            " and ( `end` >= {$NOW} ) ) " .
        " order by `start` desc"          .
        " limit 0 , 1 ;"                  ;
  return $DB -> FetchOne ( $QQ )          ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsPublicEventsByStart($DB,$TABLE,$START,$MINV=11,$MAXV=18)
{
  //////////////////////////////////////////////////////
  $VACATIONS = array ( )                               ;
  //////////////////////////////////////////////////////
  $QQ   = "select `uuid` from {$TABLE}"                .
          " where ( `used` = 1 )"                      .
           " and ( `type` >= {$MINV} )"                .
           " and ( `type` <= {$MAXV} )"                .
          " and ( `start` >= {$START} )"               .
          " order by `start` asc ;"                    ;
  $qq = $DB -> Query ( $QQ )                           ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $VACATIONS , $rr [ 0 ] )            ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $VACATIONS                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsFirstPublicEvents($DB,$TABLE,$BASE,$ITEMV=15)
{
  //////////////////////////////////////////////////////
  $VACATIONS = array ( )                               ;
  //////////////////////////////////////////////////////
  $QQ   = "select `uuid` from {$TABLE}"                .
          " where ( `used` = 1 )"                      .
            " and ( `type` = {$ITEMV} )"               .
          " and ( `start` >= {$BASE} )"                .
          " order by `start` asc"                      .
          " limit 0,1 ;"                               ;
  $qq = $DB -> Query ( $QQ )                           ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                      {
    $rr = $qq -> fetch_array ( MYSQLI_BOTH )           ;
    return $rr [ 0 ]                                   ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return 0                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsPublicEventsByEnd($DB,$TABLE,$END,$MINV=11,$MAXV=18)
{
  //////////////////////////////////////////////////////
  $VACATIONS = array ( )                               ;
  //////////////////////////////////////////////////////
  $QQ   = "select `uuid` from {$TABLE}"                .
          " where ( `used` = 1 )"                      .
           " and ( `type` >= {$MINV} )"                .
           " and ( `type` <= {$MAXV} )"                .
            " and ( `end` <= {$END} )"                 .
          " order by `start` desc ;"                   ;
  $qq = $DB -> Query ( $QQ )                           ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $VACATIONS , $rr [ 0 ] )            ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $VACATIONS                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsPublicEventsByDuration($DB,$TABLE,$START,$END,$MINV=11,$MAXV=18)
{
  //////////////////////////////////////////////////////
  $VACATIONS = array ( )                               ;
  //////////////////////////////////////////////////////
  $QQ   = "select `uuid` from {$TABLE}"                .
          " where ( `used` = 1 )"                      .
           " and ( `type` >= {$MINV} )"                .
           " and ( `type` <= {$MAXV} )"                .
            " and ( `end` >= {$START} )"               .
            " and ( `end` <= {$END} )"                 .
          " order by `start` desc ;"                   ;
  $qq = $DB -> Query ( $QQ )                           ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $VACATIONS , $rr [ 0 ] )            ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $VACATIONS                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsPublicEvents($DB,$TABLE,$MINV=11,$MAXV=18)
{
  //////////////////////////////////////////////////////
  $VACATIONS = array ( )                               ;
  //////////////////////////////////////////////////////
  $QQ   = "select `uuid` from {$TABLE}"                .
           " where ( `used` = 1 )"                     .
          " and ( `type` >= {$MINV} )"                 .
          " and ( `type` <= {$MAXV} )"                 .
          " order by `start` asc ;"                    ;
  $qq = $DB -> Query ( $QQ )                           ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $VACATIONS , $rr [ 0 ] )            ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $VACATIONS                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsEventPeriods($DB,$TABLE,$VACATIONS)
{
  $PERIODs = array         (                    ) ;
  foreach                  ( $VACATIONS as $vac ) {
    $PRX   = new Periode   (                    ) ;
    $PRX  -> set           ( "Uuid"   , $vac    ) ;
    $PRX  -> ObtainsByUuid ( $DB      , $TABLE  ) ;
    array_push             ( $PERIODs , $PRX    ) ;
  }                                               ;
  return $PERIODs                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function Between($T)
{
  if ( gmp_cmp ( $this -> Start , $T ) > 0 ) return  1 ;
  if ( gmp_cmp ( $this -> End   , $T ) > 0 ) return  0 ;
  return -1                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function Within($T,$PERIODs)
{
  foreach ( $PERIODs as $p )                     {
    if ( $p -> Between ( $T ) == 0 ) return true ;
  }                                              ;
  return false                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function Meeting($T,$PERIODs)
{
  foreach ( $PERIODs as $PX )                     {
    if ( $PX -> Between ( $T ) == 0 ) return true ;
  }                                               ;
  return false                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function JsonTitle($PNAME)
{
  $PNAME = str_replace ( "\n" , "\\n"  , $PNAME ) ;
  $PNAME = str_replace ( "'"  , "\'"   , $PNAME ) ;
  $PNAME = str_replace ( "\"" , "\\\"" , $PNAME ) ;
  return $PNAME                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function toPeriodJson($TZ,$JSON)
{
  $JSON -> JsonSqString                                (
             "start"                                   ,
             $this -> toTimeString ( $TZ , "start" ) ) ;
  $JSON -> JsonSqString                                (
             "end"                                     ,
             $this -> toTimeString ( $TZ , "end"   ) ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function VacationJson($JSON,$editable="false",$allDay="false",$CLASSID="")
{
  $JSON   -> JsonSqString ( "id"        , $this -> Uuid ) ;
  $JSON   -> JsonValue    ( "allDay"    , $allDay       ) ;
  $JSON   -> JsonValue    ( "editable"  , $editable     ) ;
  if                      ( strlen ( $CLASSID ) > 0     ) {
    $JSON -> JsonSqString ( "className" , $CLASSID      ) ;
  }                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function VacationColors($JSON)
{
  ////////////////////////////////////////////////////
  $BGXCOLORS = array                                 (
    11 => "#99bbff"                                  ,
    12 => "#bbff99"                                  ,
    13 => "#ff55aa"                                  ,
    14 => "#eeaaff"                                  ,
    15 => "#3399ff"                                  ,
    16 => "#779933"                                  ,
    17 => "#fc9977"                                  ,
    18 => "#773399"                                  ,
  )                                                  ;
  ////////////////////////////////////////////////////
  $BTGCOLORS = array                                 (
     0 => "#fc9977"                                  ,
     1 => "#ffddee"                                  ,
     2 => "#cc99ff"                                  ,
  )                                                  ;
  ////////////////////////////////////////////////////
  $TXTCOLORS = array                                 (
    11 => "#00ff00"                                  ,
    12 => "#0000ff"                                  ,
    13 => "#ffff66"                                  ,
    14 => "#332255"                                  ,
    15 => "#ffddee"                                  ,
    16 => "#ffeeff"                                  ,
    17 => "#223366"                                  ,
    18 => "#334636"                                  ,
  )                                                  ;
  ////////////////////////////////////////////////////
  $BRDCOLORS = array                                 (
    11 => "#ff99cc"                                  ,
    12 => "#ffcc99"                                  ,
    13 => "#cc99ff"                                  ,
    14 => "#ccff99"                                  ,
    15 => "#999999"                                  ,
    16 => "#000099"                                  ,
    17 => "#009900"                                  ,
    18 => "#990000"                                  ,
  )                                                  ;
  ////////////////////////////////////////////////////
  $BGC = $BGXCOLORS [ $this -> Type ]                ;
  $TXC = $TXTCOLORS [ $this -> Type ]                ;
  $BRC = $BRDCOLORS [ $this -> Type ]                ;
  if ( $this -> Type == 17 )                         {
    $TC = $this -> TermCount                         ;
    $TC = intval ( $TC % 3 , 10 )                    ;
    $BGC = $BTGCOLORS [ $TC ]                        ;
  }                                                  ;
  ////////////////////////////////////////////////////
  $JSON -> JsonSqString ( "backgroundColor" , $BGC ) ;
  $JSON -> JsonSqString ( "textColor"       , $TXC ) ;
  $JSON -> JsonSqString ( "borderColor"     , $BRC ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function PublicEventsJson($DB,$NAMTAB,$LANG,$TZ)
{
  //////////////////////////////////////////////////////////////////
  $TIDS  = $this -> TypeString ( )                                 ;
  $PNAM  = $DB   -> GetName ( $NAMTAB                              ,
                              $this -> Uuid                        ,
                              $LANG                                ,
                              "Default"                          ) ;
  //////////////////////////////////////////////////////////////////
  $TIDS  = "{$TIDS}\n{$PNAM}"                                      ;
  $TIDS  = $this -> JsonTitle ( $TIDS )                            ;
  //////////////////////////////////////////////////////////////////
  $JSON  = new jsHandler  (                                      ) ;
  $JSON -> setType        ( 4                                    ) ;
  $JSON -> setSplitter    ( " ,\n"                               ) ;
  //////////////////////////////////////////////////////////////////
  $JSON -> JsonSqString   ( "title"     , $TIDS                  ) ;
  $this -> VacationJson   (       $JSON , "false" , "false" , "" ) ;
  $this -> toPeriodJson   ( $TZ , $JSON                          ) ;
  $this -> VacationColors (       $JSON                          ) ;
  //////////////////////////////////////////////////////////////////
  return $JSON                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function PublicEvents($DB,$PTAB,$NTAB,$LANG,$TZ,$VACATIONS,$JSON)
{
  $this   -> TermCount = 0                                           ;
  foreach                              ( $VACATIONS as $vac        ) {
    $this -> set                       ( "Uuid" , $vac             ) ;
    $this -> ObtainsByUuid             ( $DB , $PTAB               ) ;
    $JSC   = $this -> PublicEventsJson ( $DB , $NTAB , $LANG , $TZ ) ;
    $JSON -> AddChild                  ( $JSC                      ) ;
    if                                 ( $this -> Type == 17       ) {
      $this -> TermCount = $this -> TermCount + 1                    ;
    }                                                                ;
  }                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function toHtml($TZ,$HR,$LeftWidth="",$NameWidth="",$bgcolors="",$original=false,$editable=false)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $WeekDays                                                           ;
  global $AMPM                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $editable )                                                           {
    $ST = $this -> toTimeString ( $TZ , "start" , "T" , "Y-m-d" , "H:i:s"  ) ;
    $ET = $this -> toTimeString ( $TZ , "end"   , "T" , "Y-m-d" , "H:i:s"  ) ;
  } else                                                                     {
    $SD = new StarDate          (                                          ) ;
    $ED = new StarDate          (                                          ) ;
    $SD -> Stardate = $this -> Start                                         ;
    $ED -> Stardate = $this -> End                                           ;
    $SW  = $WeekDays            [ $SD -> Weekday ( $TZ )                   ] ;
    $EW  = $WeekDays            [ $ED -> Weekday ( $TZ )                   ] ;
    $SP  = $AMPM                [ $SD -> isPM    ( $TZ )                   ] ;
    $EP  = $AMPM                [ $ED -> isPM    ( $TZ )                   ] ;
    $SJ  = " {$SW} {$SP} "                                                   ;
    $EJ  = " {$EW} {$EP} "                                                   ;
    $ST = $this -> toTimeString ( $TZ , "start" , $SJ , "Y/m/d" , "H:i:s"  ) ;
    $ET = $this -> toTimeString ( $TZ , "end"   , $EJ , "Y/m/d" , "H:i:s"  ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // 開始時間
  ////////////////////////////////////////////////////////////////////////////
  $MSG    = $Translations [ "StartTime" ]                                    ;
  if ( $original ) $MSG = $Translations [ "OriginalStart" ]                  ;
  $HD     = $HR -> addTd    ( $MSG                          )                ;
  $HD    -> AddPair         ( "nowrap"   , "nowrap"         )                ;
  $HD    -> SafePair        ( "width"    , $LeftWidth       )                ;
  $HD    -> SafePair        ( "bgcolor"  , $bgcolors        )                ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $editable )                                                           {
    $HD   = $HR -> addTd    (                               )                ;
    $INP  = $HD -> addInput ( $ST                           )                ;
    $INP -> AddPair         ( "type"     , "datetime-local" )                ;
    $INP -> AddPair         ( "class"    , "DateTimeInput"  )                ;
    $INP -> AddPair         ( "step"     , "1"              )                ;
    if                      ( $original                     )                {
      $JSC = "PeriodChanged(this.value,'classes','start','{$this->Uuid}') ;" ;
    } else                                                                   {
      $JSC = "PeriodChanged(this.value,'periods','start','{$this->Uuid}') ;" ;
    }                                                                        ;
    $INP -> AddPair         ( "onchange" , $JSC             )                ;
  } else                                                                     {
    $HD   = $HR -> addTd    ( $ST                           )                ;
    $HD  -> AddPair         ( "nowrap"   , "nowrap"         )                ;
    $HD  -> SafePair        ( "width"    , $NameWidth       )                ;
    $HD  -> SafePair        ( "bgcolor"  , $bgcolors        )                ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // 結束時間
  ////////////////////////////////////////////////////////////////////////////
  $MSG    = $Translations [ "EndTime" ]                                      ;
  if ( $original ) $MSG = $Translations [ "OriginalEnd" ]                    ;
  $HD     = $HR -> addTd    ( $MSG                          )                ;
  $HD    -> AddPair         ( "nowrap"   , "nowrap"         )                ;
  $HD    -> SafePair        ( "width"    , $LeftWidth       )                ;
  $HD    -> SafePair        ( "bgcolor"  , $bgcolors        )                ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $editable )                                                           {
    $HD   = $HR -> addTd    (                               )                ;
    $INP  = $HD -> addInput ( $ET                           )                ;
    $INP -> AddPair         ( "type"     , "datetime-local" )                ;
    $INP -> AddPair         ( "class"    , "DateTimeInput"  )                ;
    $INP -> AddPair         ( "step"     , "1"              )                ;
    if                      ( $original                     )                {
      $JEC = "PeriodChanged(this.value,'classes','end','{$this->Uuid}') ;"   ;
    } else                                                                   {
      $JEC = "PeriodChanged(this.value,'periods','end','{$this->Uuid}') ;"   ;
    }                                                                        ;
    $INP -> AddPair         ( "onchange" , $JEC             )                ;
  } else                                                                     {
    $HD   = $HR -> addTd    ( $ET                           )                ;
    $HD  -> AddPair         ( "nowrap"   , "nowrap"         )                ;
    $HD  -> SafePair        ( "width"    , $NameWidth       )                ;
    $HD  -> SafePair        ( "bgcolor"  , $bgcolors        )                ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeColumn($TZ,$ID,$ITEM="")
{
  ////////////////////////////////////////////////////
  $MTV  = ""                                         ;
  ////////////////////////////////////////////////////
  if                  ( strlen ( $ITEM ) > 0       ) {
    $MTV = $this -> toTimeString ( $TZ , $ITEM )     ;
  }                                                  ;
  ////////////////////////////////////////////////////
  $XTN  = new HtmlTag (                            ) ;
  $XTN -> setInput    (                            ) ;
  $XTN -> AddPair     ( "type"  , "datetime-local" ) ;
  $XTN -> AddPair     ( "id"    , $ID              ) ;
  $XTN -> AddPair     ( "class" , "DateTimeInput"  ) ;
  $XTN -> AddPair     ( "step"  , "1"              ) ;
  $XTN -> SafePair    ( "value" , $MTV             ) ;
  ////////////////////////////////////////////////////
  return $XTN                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function RangeEditor($TZ,$HR)
{
  //////////////////////////////////////////////////////////////
  $HD    = $HR   -> addLabelTd ( "Periode::Start"            ) ;
  $HD   -> AddPair             ( "width" , "2%"              ) ;
  $HD    = $HR   -> addTd      (                             ) ;
  $HD   -> AddPair             ( "width" , "2%"              ) ;
  $HD   -> setSplitter         ( "\n"                        ) ;
  $HDIV  = $HD -> addDiv       ( "" , "StartSection" , ""    ) ;
  $BTN   = $this -> TimeColumn ( $TZ , "StartTime" , "start" ) ;
  $HDIV -> AddTag              ( $BTN                        ) ;
  //////////////////////////////////////////////////////////////
  $HD    = $HR   -> addLabelTd ( "Periode::End"              ) ;
  $HD   -> AddPair             ( "width" , "2%"              ) ;
  $HD    = $HR   -> addTd      (                             ) ;
  $HD   -> AddPair             ( "width" , "2%"              ) ;
  $HD   -> setSplitter         ( "\n"                        ) ;
  $HDIV  = $HD -> addDiv       ( "" , "EndSection" , ""      ) ;
  $BTN   = $this -> TimeColumn ( $TZ , "EndTime"   , "end"   ) ;
  $HDIV -> AddTag              ( $BTN                        ) ;
  //////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function CallOffButtons($HDIV,$FOUND=false,$PSC="PickClasses();",$COJ="CallOffClasses();")
{
  /////////////////////////////////////////////////////////////////
  global $Translations                                            ;
  /////////////////////////////////////////////////////////////////
  if                            ( $FOUND                        ) {
    $MSG  = $Translations [ "Classes::CallOff" ]                  ;
    $BTN  = $HDIV  -> addButton ( $MSG                          ) ;
    $BTN -> AddPair             ( "class"   , "SelectionButton" ) ;
    $BTN -> AddPair             ( "onclick" , $COJ              ) ;
  }                                                               ;
  /////////////////////////////////////////////////////////////////
  $MSG    = $Translations [ "Search::Classes" ]                   ;
  $BTN    = $HDIV  -> addButton ( $MSG                          ) ;
  $BTN   -> AddPair             ( "class"   , "SelectionButton" ) ;
  $BTN   -> AddPair             ( "onclick" , $PSC              ) ;
  /////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function CallOff($TZ,$FOUND=false,$PSC="PickClasses();",$COJ="CallOffClasses();")
{
  ///////////////////////////////////////////////////////////////////
  global $Translations                                              ;
  ///////////////////////////////////////////////////////////////////
  $HT     = new HtmlTag           (                               ) ;
  $TBODY  = $HT -> ConfigureTable ( 0 , 0 , 0                     ) ;
  $HR     = $TBODY -> addTr       (                               ) ;
  $HR    -> setSplitter           ( "\n"                          ) ;
  ///////////////////////////////////////////////////////////////////
  $HD     = $HR    -> addTd       (                               ) ;
  $HD    -> AddPair               ( "nowrap"   , "nowrap"         ) ;
  $HD    -> AddPair               ( "width"    , "2%"             ) ;
  $HD    -> setSplitter           ( "\n"                          ) ;
  $HDIV   = $HD    -> addDiv      ( "" , "CallOffButtons" , ""    ) ;
  $HDIV  -> setSplitter           ( "\n"                          ) ;
  $this  -> CallOffButtons        ( $HDIV , $FOUND , $PSC , $COJ  ) ;
  ///////////////////////////////////////////////////////////////////
  $this  -> RangeEditor           ( $TZ       , $HR               ) ;
  ///////////////////////////////////////////////////////////////////
  $HT    -> setObject             ( "tr"      , $HR               ) ;
  ///////////////////////////////////////////////////////////////////
  return $HT                                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function WorkingTable($PUID,$TZ,$WORKS)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $WorkPeriodTypes                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HTX     = new HtmlTag              (                                    ) ;
  $TBODY   = $HTX   -> ConfigureTable ( 1 , 0 , 0                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR      = $TBODY -> addTr          (                                    ) ;
  $HD      = $HR    -> addTd          (                                    ) ;
  $HD      = $HR    -> addLabelTd     ( "Periode::Start"                   ) ;
  $HD      = $HR    -> addLabelTd     ( "Periode::End"                     ) ;
  $HD      = $HR    -> addTd          (                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                            ( $WORKS as $ws                       ) {
    if ( ( $ws -> Type > 24 ) and ( $ws -> Type < 28 ) )                     {
      ////////////////////////////////////////////////////////////////////////
      $ST  = $ws -> toTimeString ( $TZ , "start" , " " , "Y/m/d" , "H:i:s" ) ;
      $ET  = $ws -> toTimeString ( $TZ , "end"   , " " , "Y/m/d" , "H:i:s" ) ;
      ////////////////////////////////////////////////////////////////////////
      $HR  = $TBODY -> addTr        (                                      ) ;
      ////////////////////////////////////////////////////////////////////////
      if ( $ws -> Type == 27 )                                               {
        $HD  = $HR -> addTd         ( "Expire"                             ) ;
      } else                                                                 {
        $JSC = "ChangeWorkType(this.value,'{$ws->Uuid}') ;"                  ;
        $HD  = $HR -> addTd         (                                      ) ;
        $HS  = $HD -> addSelect     (                                      ) ;
        $HS -> addOptions           ( $WorkPeriodTypes , $ws -> Type       ) ;
        $HS -> AddPair              ( "onclick" , $JSC                     ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      $HD -> AddPair                ( "nowrap" , "nowrap"                  ) ;
      $HD -> AddPair                ( "width"  , "3%"                      ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD  = $HR    -> addTd        ( $ST                                  ) ;
      $HD -> AddPair                ( "nowrap" , "nowrap"                  ) ;
      $HD -> AddPair                ( "width"  , "3%"                      ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD  = $HR    -> addTd        ( $ET                                  ) ;
      $HD -> AddPair                ( "nowrap" , "nowrap"                  ) ;
      $HD -> AddPair                ( "width"  , "3%"                      ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD  = $HR    -> addTd        (                                      ) ;
      ////////////////////////////////////////////////////////////////////////
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
