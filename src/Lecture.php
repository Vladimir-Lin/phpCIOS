<?php
//////////////////////////////////////////////////////////////////////////////
// 排課資訊
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Lecture extends Columns                                                {
//////////////////////////////////////////////////////////////////////////////
// +| Variables |+
//////////////////////////////////////////////////////////////////////////////
public $Id                                                                   ;
public $Uuid                                                                 ;
public $Trainee                                                              ;
public $Tutor                                                                ;
public $Manager                                                              ;
public $Payer                                                                ;
public $Receptionist                                                         ;
public $Item                                                                 ;
public $States                                                               ;
public $Register                                                             ; // 課堂註冊時間
public $OpenDay                                                              ; // 課堂開始時間
public $CloseDay                                                             ; // 課堂結束時間
public $Log                                                                  ; // 登錄紀錄時間
public $Update                                                               ;
public $Sections                                                             ;
//////////////////////////////////////////////////////////////////////////////
// -| Variables |-
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear ( )                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
// +| Clear |+
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> Id           = -1                                                 ;
  $this -> Uuid         = "0"                                                ;
  $this -> Trainee      = "0"                                                ;
  $this -> Tutor        = "0"                                                ;
  $this -> Manager      = "0"                                                ;
  $this -> Payer        = "0"                                                ;
  $this -> Receptionist = "0"                                                ;
  $this -> Item         = "0"                                                ;
  $this -> States       =  0                                                 ;
  $this -> Register     = "0"                                                ;
  $this -> OpenDay      = "0"                                                ;
  $this -> CloseDay     = "0"                                                ;
  $this -> Log          = "0"                                                ;
  $this -> Update       = ""                                                 ;
  $this -> Sections     = array ( )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// -| Clear |-
//////////////////////////////////////////////////////////////////////////////
// +| assign |+
//////////////////////////////////////////////////////////////////////////////
public function assign ( $Item )                                             {
  $this -> Id           = $Item -> Id                                        ;
  $this -> Uuid         = $Item -> Uuid                                      ;
  $this -> Trainee      = $Item -> Trainee                                   ;
  $this -> Tutor        = $Item -> Tutor                                     ;
  $this -> Manager      = $Item -> Manager                                   ;
  $this -> Payer        = $Item -> Payer                                     ;
  $this -> Receptionist = $Item -> Receptionist                              ;
  $this -> Item         = $Item -> Item                                      ;
  $this -> States       = $Item -> States                                    ;
  $this -> Register     = $Item -> Register                                  ;
  $this -> OpenDay      = $Item -> OpenDay                                   ;
  $this -> CloseDay     = $Item -> CloseDay                                  ;
  $this -> Log          = $Item -> Log                                       ;
  $this -> Update       = $Item -> Update                                    ;
  $this -> Sections     = $Item -> Sections                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// -| assign |-
//////////////////////////////////////////////////////////////////////////////
// +| tableItems |+
//////////////////////////////////////////////////////////////////////////////
public function tableItems ( )                                               {
  return [ "id"                                                              ,
           "uuid"                                                            ,
           "trainee"                                                         ,
           "tutor"                                                           ,
           "manager"                                                         ,
           "payer"                                                           ,
           "receptionist"                                                    ,
           "item"                                                            ,
           "states"                                                          ,
           "register"                                                        ,
           "openday"                                                         ,
           "closeday"                                                        ,
           "log"                                                             ,
           "ltime"                                                         ] ;
}
//////////////////////////////////////////////////////////////////////////////
// -| tableItems |-
//////////////////////////////////////////////////////////////////////////////
// +| valueItems |+
//////////////////////////////////////////////////////////////////////////////
public function valueItems ( )                                               {
  return [ "trainee"                                                         ,
           "tutor"                                                           ,
           "manager"                                                         ,
           "payer"                                                           ,
           "receptionist"                                                    ,
           "item"                                                            ,
           "states"                                                          ,
           "register"                                                        ,
           "openday"                                                         ,
           "closeday"                                                        ,
           "log"                                                           ] ;
}
//////////////////////////////////////////////////////////////////////////////
// -| valueItems |-
//////////////////////////////////////////////////////////////////////////////
// +| set |+
//////////////////////////////////////////////////////////////////////////////
public function set($item,$V)
{
  $a = strtolower ( $item )                              ;
  if ( "id"           == $a ) $this -> Id           = $V ;
  if ( "uuid"         == $a ) $this -> Uuid         = $V ;
  if ( "trainee"      == $a ) $this -> Trainee      = $V ;
  if ( "tutor"        == $a ) $this -> Tutor        = $V ;
  if ( "manager"      == $a ) $this -> Manager      = $V ;
  if ( "payer"        == $a ) $this -> Payer        = $V ;
  if ( "receptionist" == $a ) $this -> Receptionist = $V ;
  if ( "item"         == $a ) $this -> Item         = $V ;
  if ( "states"       == $a ) $this -> States       = $V ;
  if ( "register"     == $a ) $this -> Register     = $V ;
  if ( "openday"      == $a ) $this -> OpenDay      = $V ;
  if ( "closeday"     == $a ) $this -> CloseDay     = $V ;
  if ( "log"          == $a ) $this -> Log          = $V ;
  if ( "ltime"        == $a ) $this -> Update       = $V ;
}
//////////////////////////////////////////////////////////////////////////////
// -| set |-
//////////////////////////////////////////////////////////////////////////////
// +| get |+
//////////////////////////////////////////////////////////////////////////////
public function get($item)
{
  $a = strtolower ( $item )                                         ;
  if ( "id"           == $a ) return (string) $this -> Id           ;
  if ( "uuid"         == $a ) return (string) $this -> Uuid         ;
  if ( "trainee"      == $a ) return (string) $this -> Trainee      ;
  if ( "tutor"        == $a ) return (string) $this -> Tutor        ;
  if ( "manager"      == $a ) return (string) $this -> Manager      ;
  if ( "payer"        == $a ) return (string) $this -> Payer        ;
  if ( "receptionist" == $a ) return (string) $this -> Receptionist ;
  if ( "item"         == $a ) return (string) $this -> Item         ;
  if ( "states"       == $a ) return (string) $this -> States       ;
  if ( "register"     == $a ) return (string) $this -> Register     ;
  if ( "openday"      == $a ) return (string) $this -> OpenDay      ;
  if ( "closeday"     == $a ) return (string) $this -> CloseDay     ;
  if ( "log"          == $a ) return (string) $this -> Log          ;
  if ( "ltime"        == $a ) return (string) $this -> Update       ;
  return ""                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
// -| get |-
//////////////////////////////////////////////////////////////////////////////
// +| Pair |+
//////////////////////////////////////////////////////////////////////////////
public function Pair($item)
{
  return "`{$item}` = " . $this -> get ( $item ) ;
}
//////////////////////////////////////////////////////////////////////////////
// -| Pair |-
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
  $a = strtolower ( $item )                             ;
  if ( "id"           == $a )                           {
    return "`{$a}` = " . (string) $this -> Id           ;
  }                                                     ;
  if ( "uuid"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Uuid         ;
  }                                                     ;
  if ( "trainee"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Trainee      ;
  }                                                     ;
  if ( "tutor"        == $a )                           {
    return "`{$a}` = " . (string) $this -> Tutor        ;
  }                                                     ;
  if ( "manager"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Manager      ;
  }                                                     ;
  if ( "payer"        == $a )                           {
    return "`{$a}` = " . (string) $this -> Payer        ;
  }                                                     ;
  if ( "receptionist" == $a )                           {
    return "`{$a}` = " . (string) $this -> Receptionist ;
  }                                                     ;
  if ( "item"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Item         ;
  }                                                     ;
  if ( "states"       == $a )                           {
    return "`{$a}` = " . (string) $this -> States       ;
  }                                                     ;
  if ( "register"     == $a )                           {
    return "`{$a}` = " . (string) $this -> Register     ;
  }                                                     ;
  if ( "openday"      == $a )                           {
    return "`{$a}` = " . (string) $this -> OpenDay      ;
  }                                                     ;
  if ( "closeday"     == $a )                           {
    return "`{$a}` = " . (string) $this -> CloseDay     ;
  }                                                     ;
  if ( "log"          == $a )                           {
    return "`{$a}` = " . (string) $this -> Log          ;
  }                                                     ;
  if ( "ltime"        == $a )                           {
    return "`{$a}` = " . (string) $this -> Update       ;
  }                                                     ;
  if ( "sections"     == $a )                           {
    return "`{$a}` = " . (string) $this -> Sections     ;
  }                                                     ;
  return ""                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function toString()
{
  return sprintf ( "lec2%08d" , gmp_mod ( $this -> Uuid , 100000000 ) ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function fromString ( $LXID )
{
  /////////////////////////////////////////////////
  if               ( 12 != strlen ( $LXID )     ) {
    $this -> Uuid = 0                             ;
    return 0                                      ;
  }                                               ;
  /////////////////////////////////////////////////
  $X = strtolower  ( $LXID                      ) ;
  $C = substr      ( $X , 0 , 4                 ) ;
  if               ( $C != "lec2"               ) {
    $this -> Uuid = 0                             ;
    return 0                                      ;
  }                                               ;
  /////////////////////////////////////////////////
  $C = substr      ( $LXID , 0 , 4              ) ;
  $U = str_replace ( $C , "29000000000" , $LXID ) ;
  $this -> Uuid = $U                              ;
  /////////////////////////////////////////////////
  return $U                                       ;
}
//////////////////////////////////////////////////////////////////////////////
// +| toJsonWithTimestamp |+
//////////////////////////////////////////////////////////////////////////////
public function toJsonWithTimestamp      (                                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $NOW      = new StarDate               (                                 ) ;
  $JSOX     = $this -> toJson            (                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOW     -> Stardate = $this -> OpenDay                                    ;
  $JSOX [ "StartTimestamp" ] = $NOW -> Timestamp ( )                         ;
  ////////////////////////////////////////////////////////////////////////////
  $NOW     -> Stardate = $this -> CloseDay                                   ;
  $JSOX [ "EndTimestamp"   ] = $NOW -> Timestamp ( )                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $JSOX                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
// -| toJsonWithTimestamp |-
//////////////////////////////////////////////////////////////////////////////
public function TimeItem($item,$TZ)
{
  $ZZ = "0"                                       ;
  $a = strtolower ( $item )                       ;
  if ( "register" == $a ) $ZZ = $this -> Register ;
  if ( "openday"  == $a ) $ZZ = $this -> OpenDay  ;
  if ( "closeday" == $a ) $ZZ = $this -> CloseDay ;
  if ( "log"      == $a ) $ZZ = $this -> Log      ;
  if ( strlen  ( $ZZ       ) <= 0 ) return false  ;
  if ( gmp_cmp ( $ZZ , "0" ) <= 0 ) return false  ;
  $SD             = new StarDate      (     )     ;
  $SD -> Stardate = $ZZ                           ;
  $DD             = $SD -> toDateTime ( $TZ )     ;
  unset                               ( $SD )     ;
  return $DD                                      ;
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
public function toPeriod()
{
  $PERIODE  = new Periode ( )           ;
  $PERIODE -> Uuid  = $this -> Uuid     ;
  $PERIODE -> Start = $this -> OpenDay  ;
  $PERIODE -> End   = $this -> CloseDay ;
  return $PERIODE                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function obtain($R)
{
  $this -> Id           = $R [ "id"           ] ;
  $this -> Uuid         = $R [ "uuid"         ] ;
  $this -> Trainee      = $R [ "trainee"      ] ;
  $this -> Tutor        = $R [ "tutor"        ] ;
  $this -> Manager      = $R [ "manager"      ] ;
  $this -> Payer        = $R [ "payer"        ] ;
  $this -> Receptionist = $R [ "receptionist" ] ;
  $this -> Item         = $R [ "item"         ] ;
  $this -> States       = $R [ "states"       ] ;
  $this -> Register     = $R [ "register"     ] ;
  $this -> OpenDay      = $R [ "openday"      ] ;
  $this -> CloseDay     = $R [ "closeday"     ] ;
  $this -> Log          = $R [ "log"          ] ;
  $this -> Update       = $R [ "ltime"        ] ;
}
//////////////////////////////////////////////////////////////////////////////
public function RegisterTime($TZ,$JOIN=" ",$DateFormat="Y/m/d D A",$TimeFormat="H:i:s")
{
  $REG    = new StarDate (             ) ;
  $REG   -> Stardate = $this -> Register ;
  $REGSTR = $REG -> toDateTimeString     (
                      $TZ                ,
                      $JOIN              ,
                      $DateFormat        ,
                      $TimeFormat      ) ;
  unset                  ( $REG        ) ;
  return $REGSTR                         ;
}
//////////////////////////////////////////////////////////////////////////////
public function LogTime($TZ,$JOIN=" ",$DateFormat="Y/m/d D A",$TimeFormat="H:i:s")
{
  $LOG    = new StarDate (         ) ;
  $LOG   -> Stardate = $this -> Log  ;
  $LOGSTR = $LOG -> toDateTimeString (
                      $TZ            ,
                      $JOIN          ,
                      $DateFormat    ,
                      $TimeFormat  ) ;
  unset                  ( $LOG    ) ;
  return $LOGSTR                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function CallOffJS($TZ)
{
  $NOW  = new StarDate             (               ) ;
  $END  = new StarDate             (               ) ;
  $NOW -> Now                      (               ) ;
  $END -> Stardate = $this -> CloseDay               ;
  $HH   = new Parameters           (               ) ;
  $LS   = $HH  -> LectureString    ( $this -> Uuid ) ;
  $ST   = $NOW -> toDateTimeString ( $TZ           ) ;
  $ET   = $END -> toDateTimeString ( $TZ           ) ;
  return "CallOffClass('{$LS}','{$ST}','{$ET}')"     ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetUuid($DB,$Table,$Main)
{
  global $DataTypes                                          ;
  $BASE         = "2900000000000000000"                      ;
  $RI           = new Relation ( )                           ;
  $TYPE         = $RI -> Types [ "Lecture" ]                 ;
  $this -> Uuid = $DB -> GetLast ( $Table , "uuid" , $BASE ) ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false   ;
  $DB -> AddUuid ( $Main , $this -> Uuid , $TYPE )           ;
  return $this -> Uuid                                       ;
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
  ////////////////////////////////////////////////////////////////////////////
  $ITEMS  = $this -> valueItems (                      )                     ;
  $VALUES = $this -> Pairs      ( $ITEMS               )                     ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ     = "update {$TABLE} set {$VALUES} "                                 .
            $DB   -> WhereUuid  ( $this -> Uuid , true )                     ;
  unset                         ( $ITEMS               )                     ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> Query           ( $QQ                  )                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByQuery($DB,$QQ)
{
  $qq = $DB -> Query ( $QQ )                 ;
  if ( $DB -> hasResult ( $qq ) )            {
    $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this     -> obtain      ( $rr         ) ;
    return true                              ;
  }                                          ;
  return false                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByUuid ( $DB , $TABLE )
{
  $IT = $this -> Items ( )                        ;
  $QQ = "select {$IT} from {$TABLE}"              .
        $DB -> WhereUuid ( $this -> Uuid , true ) ;
  return $this -> ObtainsByQuery ( $DB , $QQ )    ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsLectures ( $DB , $LECTURES , $ITEM , $ORDER = "asc" )
{
  $VV = $this -> get ( $ITEM )           ;
  $QQ = "select `uuid` from {$LECTURES}" .
        " where `{$ITEM}` = {$VV}"       .
        " order by `openday` {$ORDER} ;" ;
  return $DB -> ObtainUuids ( $QQ )      ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByPayer          ( $DB , $LECTURES , $ORDER = "asc" ) {
  ////////////////////////////////////////////////////////////////////////////
  $VV   = $this -> Trainee                                                   ;
  $PP   = $this -> Payer                                                     ;
  $QQ   = "select `uuid` from {$LECTURES}"                                   .
          " where ( `trainee` = {$VV} ) and ( `payer` = {$PP} )"             .
          " order by `openday` {$ORDER} ;"                                   ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids             ( $QQ                              ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainMembers ( $DB , $LECTURES , $FROM , $MEMBER , $PUID , $ORDER = "desc" )
{
  $UUX = array ( )                                     ;
  $QQ  = "select `{$MEMBER}` from {$LECTURES}"         .
         " where `{$FROM}` = {$PUID}"                  .
         " order by `openday` {$ORDER} ;"              ;
  $qq  = $DB -> Query ( $QQ )                          ;
  if      ( $DB -> hasResult ( $qq )                 ) {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      $XUU = $rr [ 0 ]                                 ;
      if  ( ! in_array ( $XUU , $UUX )               ) {
        array_push     ( $UUX , $XUU )                 ;
      }                                                ;
    }                                                  ;
  }                                                    ;
  return $UUX                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainTutors ( $DB , $TABLE , $PUID , $ORDER = "desc" )
{
  ////////////////////////////////////////////////////////////////////////////
  $QQ         = "select `tutor` from {$TABLE}"                               .
                " where ( `trainee` = {$PUID} )"                             .
                " group by `tutor` order by `closeday` {$ORDER} ;"           ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids  ( $QQ                  )                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainCourses     ( $DB , $RELATIONS        )
{
  $RI      = new Relation         (                         ) ;
  $RI     -> set                  ( "first" , $this -> Uuid ) ;
  $RI     -> setT1                ( "Lecture"               ) ;
  $RI     -> setT2                ( "Course"                ) ;
  $RI     -> setRelation          ( "Contains"              ) ;
  $COURSES = $RI -> Subordination ( $DB , $RELATIONS        ) ;
  unset                           ( $RI                     ) ;
  return $COURSES                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function JoinCourses ( $DB , $RELATIONS , $COURSES ) {
  ///////////////////////////////////////////////////////////
  $RI  = new Relation       (                             ) ;
  ///////////////////////////////////////////////////////////
  $RI -> set                ( "first" , $this -> Uuid     ) ;
  $RI -> setT1              ( "Lecture"                   ) ;
  $RI -> setT2              ( "Course"                    ) ;
  $RI -> setRelation        ( "Contains"                  ) ;
  $RI -> Joins              ( $DB , $RELATIONS , $COURSES ) ;
  ///////////////////////////////////////////////////////////
  unset                     ( $RI                         ) ;
  ///////////////////////////////////////////////////////////
  return $COURSES                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainLessons($DB,$RELATIONS)
{
  $RI      = new Relation         (                         ) ;
  $RI     -> set                  ( "first" , $this -> Uuid ) ;
  $RI     -> setT1                ( "Lecture"               ) ;
  $RI     -> setT2                ( "Lesson"                ) ;
  $RI     -> setRelation          ( "Contains"              ) ;
  $LESSONS = $RI -> Subordination ( $DB , $RELATIONS        ) ;
  unset                           ( $RI                     ) ;
  return $LESSONS                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainSections ( $DB , $TABLE )
{
  $PQ    = ParameterQuery::NewParameter ( 2 , 67 , "Periods"               ) ;
  $PQ   -> setTable                     ( $TABLE                           ) ;
  $SECTs = $PQ -> Data                  ( $DB , $this -> Uuid , "Sections" ) ;
  if                                    ( strlen ( $SECTs ) > 0            ) {
    $this -> Sections = explode         ( " , " , $SECTs                   ) ;
  } else                                                                     {
    $this -> Sections = array           (                                  ) ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function addSection($SECTION)
{
  if ( in_array ( $SECTION          , $this -> Sections ) ) return ;
  array_push    ( $this -> Sections , $SECTION          )          ;
  asort         ( $this -> Sections                     )          ;
}
//////////////////////////////////////////////////////////////////////////////
public function removeSection($SECTION)
{
  if ( ! in_array ( $SECTION , $this -> Sections ) ) return ;
  $SX = array     (                              )          ;
  foreach         ( $this -> Sections as $ss     )          {
    if            ( $ss != $SECTION              )          {
      array_push  ( $SX , $ss                    )          ;
    }                                                       ;
  }                                                         ;
  $this -> Sections = $SX                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function assureSections ( $DB , $TABLE )
{
  if                   ( count ( $this -> Sections ) > 0        ) {
    $SS = implode      ( " , "  , $this -> Sections             ) ;
  } else                                                          {
    $SS = ""                                                      ;
  }                                                               ;
  $PQ   = ParameterQuery::NewParameter ( 2 , 67 , "Periods"     ) ;
  $PQ  -> setTable     ( $TABLE                                 ) ;
  $PQ  -> assureData   ( $DB , $this -> Uuid , "Sections" , $SS ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeAt($STD,$ID,$TZ)
{
  $WD  = $STD -> Weekday      ( $TZ )        ;
  ////////////////////////////////////////////
  $SOD = $STD -> SecondsOfDay ( $TZ )        ;
  $SOE = $SOD + 3000                         ;
  $SOD = $SOD + 5                            ;
  $SOE = $SOE - 5                            ;
  ////////////////////////////////////////////
  $IW  = intval ( $ID      , 10     )        ;
  $IT  = intval ( $IW % 48 , 10     )        ;
  $IW  = intval ( $IW / 48 , 10     )        ;
  $IW  = $IW +  1                            ;
  ////////////////////////////////////////////
  if ( $IW != $WD ) return false             ;
  ////////////////////////////////////////////
  $IT  = $IT * 1800                          ;
  $ET  = $IT + 3600                          ;
  ////////////////////////////////////////////
  if   ( ( $IT < $SOD ) and ( $ET > $SOD ) ) {
    if ( ( $IT < $SOE ) and ( $ET > $SOE ) ) {
      return true                            ;
    }                                        ;
  }                                          ;
  ////////////////////////////////////////////
  return false                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeInside($STD,$TZ)
{
  foreach ( $this -> Sections as $ID )                      {
    if ( $this -> TimeAt ( $STD , $ID , $TZ ) ) return true ;
  }                                                         ;
  return false                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function NextClassTime($START,$TZ)
{
  if ( count ( $this -> Sections ) <= 0 ) return $Start ;
  ///////////////////////////////////////////////////////
  $SD  = new StarDate ( )                               ;
  $SD -> Stardate = $START                              ;
  ///////////////////////////////////////////////////////
  while ( ! $this -> TimeInside ( $SD , $TZ ) )         {
    $SD -> Add ( 3600 )                                 ;
  }                                                     ;
  ///////////////////////////////////////////////////////
  return $SD -> Stardate                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function StudentJson($DB,$TZ,$NAME,$LECTUREID,$NOW)
{
  $HH   = new Parameters        (                        )                  ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> LectureString ( $this -> Uuid          )                  ;
  $TNS  = $DB  -> GetTutor      ( $NAME , $this -> Tutor )                  ;
  $TIDS = "授課老師：" . $TNS  . "\\n" . "排課編號：" . $CIDS                   ;
  $PRD  = $this -> toPeriod ( )                                             ;
  $PRD -> End = gmp_add ( $PRD -> End , 86400 )                             ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $CIDS                              ) ;
  $JSC -> JsonSqString ( "className" , $LECTUREID                         ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  $JSC -> JsonValue    ( "allDay"    , "true"                             ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toDateString ( $TZ , "start" ) ) ;
  $JSC -> JsonSqString ( "end"   , $PRD -> toDateString ( $TZ , "end"   ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  switch ( $PRD -> Between ( $NOW ) )                                       {
    case -1                                                                 :
      $JSC -> JsonSqString ( "color" , "#99ccff" )                          ;
    break                                                                   ;
    case  0                                                                 :
      $JSC -> JsonSqString ( "backgroundColor" , "#55ffcc" )                ;
      $JSC -> JsonSqString ( "textColor"       , "#bb0099" )                ;
      $JSC -> JsonSqString ( "borderColor"     , "#0000ff" )                ;
    break                                                                   ;
    case  1                                                                 :
      $JSC -> JsonSqString ( "color" , "#33ff99" )                          ;
    break                                                                   ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function RegisterJson($DB,$TZ,$NAME,$LECTUREID)
{
  $HH   = new Parameters        (                        )                  ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> LectureString ( $this -> Uuid          )                  ;
  $TIDS = "註冊課程：" . $CIDS                                                ;
  $PRD  = new Periode   (      )                                            ;
  $PRD -> Start = $this -> Register                                         ;
  $PRD -> setInterval   ( 1800 )                                            ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $this -> Uuid                      ) ;
  $JSC -> JsonSqString ( "className" , $LECTUREID                         ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  $JSC -> JsonValue    ( "allDay"    , "false"                            ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toTimeString ( $TZ , "start" ) ) ;
//  $JSC -> JsonSqString ( "end"   , $PRD -> toTimeString ( $TZ , "end"   ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  $JSC -> JsonSqString ( "backgroundColor" , "#99ffcc" )                    ;
  $JSC -> JsonSqString ( "textColor"       , "#9900bb" )                    ;
  $JSC -> JsonSqString ( "borderColor"     , "#ff0000" )                    ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function StudentLectures($DB,$TZ,$JAVA,$LECTURES,$NAME,$LECTUREID,$NOW)
{
  $UU = $this -> ObtainsLectures ( $DB , $LECTURES , "trainee" ) ;
  foreach ( $UU as $uu )                                         {
    $this -> Uuid = $uu                                          ;
    if ( $this -> ObtainsByUuid ( $DB , $LECTURES ) )            {
      $JAVA    -> AddChild                                       (
        $this  -> StudentJson                                    (
          $DB                                                    ,
          $TZ                                                    ,
          $NAME                                                  ,
          $LECTUREID                                             ,
          $NOW                                               ) ) ;
      $JAVA    -> AddChild                                       (
        $this  -> RegisterJson                                   (
          $DB                                                    ,
          $TZ                                                    ,
          $NAME                                                  ,
          $LECTUREID                                         ) ) ;
    }                                                            ;
  }                                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function StudentRegister($DB,$TZ,$JAVA,$LECTURES,$NAME,$LECTUREID)
{
  $UU = $this -> ObtainsLectures ( $DB , $LECTURES , "trainee" ) ;
  foreach ( $UU as $uu )                                         {
    $this -> Uuid = $uu                                          ;
    if ( $this -> ObtainsByUuid ( $DB , $LECTURES ) )            {
      $JAVA    -> AddChild                                       (
        $this  -> RegisterJson                                   (
          $DB                                                    ,
          $TZ                                                    ,
          $NAME                                                  ,
          $LECTUREID                                         ) ) ;
    }                                                            ;
  }                                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function OfficerLectures($DB,$TZ,$JAVA,$LECTURES,$NAME,$LECTUREID)
{
  $UU = $this -> ObtainsLectures ( $DB , $LECTURES , "manager" ) ;
  foreach ( $UU as $uu )                                         {
    $this -> Uuid = $uu                                          ;
    if ( $this -> ObtainsByUuid ( $DB , $LECTURES ) )            {
      $JAVA    -> AddChild                                       (
        $this  -> RegisterJson                                   (
          $DB                                                    ,
          $TZ                                                    ,
          $NAME                                                  ,
          $LECTUREID                                         ) ) ;
    }                                                            ;
  }                                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function ReceptionistLectures($DB,$TZ,$JAVA,$LECTURES,$NAME,$LECTUREID)
{
  $UU = $this -> ObtainsLectures ( $DB , $LECTURES , "receptionist" ) ;
  foreach ( $UU as $uu )                                              {
    $this -> Uuid = $uu                                               ;
    if ( $this -> ObtainsByUuid ( $DB , $LECTURES ) )                 {
      $JAVA    -> AddChild                                            (
        $this  -> RegisterJson                                        (
          $DB                                                         ,
          $TZ                                                         ,
          $NAME                                                       ,
          $LECTUREID                                              ) ) ;
    }                                                                 ;
  }                                                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function addTd($HR,$MSG="",$WIDTH="3%",$bgcolors="")
{
  $HD  = $HR -> addTd ( $MSG                  ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"  ) ;
  $HD -> SafePair     ( "width"   , $WIDTH    ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolors ) ;
  return $HD                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function addNameItem($HR,$NAME,$KEY,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  /////////////////////////////////////////////////////////
  global $Translations                                    ;
  /////////////////////////////////////////////////////////
  $LST   = $Translations [ $KEY ]                         ;
  $this -> addTd ( $HR , $LST  , $LeftWidth , $bgcolors ) ;
  $this -> addTd ( $HR , $NAME , $NameWidth , $bgcolors ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addBriefIndex($HB,$COLS=6)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $LID  = $this -> toString ( )                                              ;
  $LCJ = "LectureClicked('{$LID}')"                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = $HB -> addTr     (                                                ) ;
  $HD  = $HR -> addTd     (                                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD -> AddPair          ( "colspan" , $COLS                              ) ;
  $HD -> AddPair          ( "nowrap"  , "nowrap"                           ) ;
  $HD -> AddPair          ( "align"   , "right"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = $HD -> addButton ( $Translations [ "Lectures::Details" ]          ) ;
  $HX -> AddPair          ( "class"   , "SelectionButton"                  ) ;
  $HX -> AddPair          ( "onclick" , $LCJ                               ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function addStudent($HR,$NAME,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  $this -> addNameItem ( $HR                 ,
                         $NAME               ,
                         "Lectures::Student" ,
                         $LeftWidth          ,
                         $NameWidth          ,
                         $bgcolors         ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addTutor($HR,$NAME,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  $this -> addNameItem ( $HR               ,
                         $NAME             ,
                         "Lectures::Tutor" ,
                         $LeftWidth        ,
                         $NameWidth        ,
                         $bgcolors       ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addManager($HR,$NAME,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  $this -> addNameItem ( $HR                 ,
                         $NAME               ,
                         "Lectures::Manager" ,
                         $LeftWidth          ,
                         $NameWidth          ,
                         $bgcolors         ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addReceptionist($HR,$NAME,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  $this -> addNameItem ( $HR                      ,
                         $NAME                    ,
                         "Lectures::Receptionist" ,
                         $LeftWidth               ,
                         $NameWidth               ,
                         $bgcolors              ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addPayer($HR,$NAME,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  $this -> addNameItem ( $HR               ,
                         $NAME             ,
                         "Lectures::Payer" ,
                         $LeftWidth        ,
                         $NameWidth        ,
                         $bgcolors       ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function DateTimeInput($TIMESTRING,$ITEM)
{
  $JSC  = "LectureTimeChanged(this.value,'{$ITEM}','{$this->Uuid}') ;" ;
  //////////////////////////////////////////////////////////////////////
  $INP  = new HtmlTag (                               )                ;
  $INP -> setInput    (                               )                ;
  $INP -> AddPair     ( "type"     , "datetime-local" )                ;
  $INP -> AddPair     ( "class"    , "DateTimeInput"  )                ;
  $INP -> AddPair     ( "step"     , "1"              )                ;
  $INP -> SafePair    ( "value"    , $TIMESTRING      )                ;
  $INP -> AddPair     ( "onchange" , $JSC             )                ;
  //////////////////////////////////////////////////////////////////////
  return $INP                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function addRegistration($HR,$TZ,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  ////////////////////////////////////////////////////////////
  global $Translations                                       ;
  ////////////////////////////////////////////////////////////
  $REGTIME = $this -> RegisterTime ( $TZ )                   ;
  $REGKEY  = $Translations [ "Lectures::Registration" ]      ;
  ////////////////////////////////////////////////////////////
  $this -> addTd ( $HR , $REGKEY  , $NameWidth , $bgcolors ) ;
  $this -> addTd ( $HR , $REGTIME , $TimeWidth , $bgcolors ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function editRegistration($HR,$TZ,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  //////////////////////////////////////////////////////////////
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  $REGTIME = $this -> RegisterTime ( $TZ,"T","Y-m-d","H:i:s" ) ;
  $REGKEY  = $Translations [ "Lectures::Registration" ]        ;
  //////////////////////////////////////////////////////////////
  $this   -> addTd ( $HR , $REGKEY  , $NameWidth , $bgcolors ) ;
  //////////////////////////////////////////////////////////////
  $INP     = $this -> DateTimeInput ( $REGTIME , "register"  ) ;
  $HD      = $HR -> addTd    (                               ) ;
  $HD     -> AddTag          ( $INP                          ) ;
  //////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function RegistrationEditing($HR,$TZ,$editable=false,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  if ( $editable )                          {
    $this -> editRegistration ( $HR         ,
                                $TZ         ,
                                $NameWidth  ,
                                $TimeWidth  ,
                                $bgcolors ) ;
  } else                                    {
    $this -> addRegistration  ( $HR         ,
                                $TZ         ,
                                $NameWidth  ,
                                $TimeWidth  ,
                                $bgcolors ) ;
  }                                         ;
}
//////////////////////////////////////////////////////////////////////////////
public function addLog($HR,$TZ,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  ////////////////////////////////////////////////////////////
  global $Translations                                       ;
  ////////////////////////////////////////////////////////////
  $LOGTIME = $this -> LogTime ( $TZ )                        ;
  $LOGKEY  = $Translations [ "Lectures::Log" ]               ;
  ////////////////////////////////////////////////////////////
  $this -> addTd ( $HR , $LOGKEY  , $NameWidth , $bgcolors ) ;
  $this -> addTd ( $HR , $LOGTIME , $TimeWidth , $bgcolors ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function editLog($HR,$TZ,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  /////////////////////////////////////////////////////////////
  global $Translations                                        ;
  /////////////////////////////////////////////////////////////
  $LOGTIME = $this -> LogTime ( $TZ,"T","Y-m-d","H:i:s" )     ;
  $LOGKEY  = $Translations [ "Lectures::Log" ]                ;
  /////////////////////////////////////////////////////////////
  $this   -> addTd ( $HR , $LOGKEY , $NameWidth , $bgcolors ) ;
  /////////////////////////////////////////////////////////////
  $INP     = $this -> DateTimeInput ( $LOGTIME , "log"      ) ;
  $HD      = $HR -> addTd    (                              ) ;
  $HD     -> AddTag          ( $INP                         ) ;
  /////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function LogEditing($HR,$TZ,$editable=false,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  if ( $editable )                 {
    $this -> editLog ( $HR         ,
                       $TZ         ,
                       $NameWidth  ,
                       $TimeWidth  ,
                       $bgcolors ) ;
  } else                           {
    $this -> addLog  ( $HR         ,
                       $TZ         ,
                       $NameWidth  ,
                       $TimeWidth  ,
                       $bgcolors ) ;
  }                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function addPeriod($HR,$TZ,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  ///////////////////////////////////////////////////////////////////////
  global $Translations                                                  ;
  ///////////////////////////////////////////////////////////////////////
  $PRD   = $this -> toPeriod    (                                     ) ;
  ///////////////////////////////////////////////////////////////////////
  $STIME = $PRD -> toTimeString ( $TZ,"start"," ","Y/m/d D A","H:i:s" ) ;
  $ETIME = $PRD -> toTimeString ( $TZ,"end"  ," ","Y/m/d D A","H:i:s" ) ;
  ///////////////////////////////////////////////////////////////////////
  $LOS   = $Translations [ "Lectures::OpenDay"  ]                       ;
  $LCS   = $Translations [ "Lectures::CloseDay" ]                       ;
  ///////////////////////////////////////////////////////////////////////
  $this -> addTd ( $HR , $LOS   , $LeftWidth , $bgcolors )              ;
  $this -> addTd ( $HR , $STIME , $NameWidth , $bgcolors )              ;
  $this -> addTd ( $HR , $LCS   , $LeftWidth , $bgcolors )              ;
  $this -> addTd ( $HR , $ETIME , $NameWidth , $bgcolors )              ;
}
//////////////////////////////////////////////////////////////////////////////
public function editPeriod($HR,$TZ,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  ///////////////////////////////////////////////////////////////////
  global $Translations                                              ;
  ///////////////////////////////////////////////////////////////////
  $PRD   = $this -> toPeriod    (                                 ) ;
  ///////////////////////////////////////////////////////////////////
  $STIME = $PRD -> toTimeString ( $TZ,"start","T","Y-m-d","H:i:s" ) ;
  $ETIME = $PRD -> toTimeString ( $TZ,"end"  ,"T","Y-m-d","H:i:s" ) ;
  ///////////////////////////////////////////////////////////////////
  $LOS   = $Translations [ "Lectures::OpenDay"  ]                   ;
  $LCS   = $Translations [ "Lectures::CloseDay" ]                   ;
  ///////////////////////////////////////////////////////////////////
  $INX     = $this -> DateTimeInput ( $STIME , "openday"          ) ;
  $INP     = $this -> DateTimeInput ( $ETIME , "closeday"         ) ;
  ///////////////////////////////////////////////////////////////////
  $this   -> addTd        ( $HR , $LOS   , $LeftWidth , $bgcolors ) ;
  $HD      = $HR -> addTd (                                       ) ;
  $HD     -> AddTag       ( $INX                                  ) ;
  ///////////////////////////////////////////////////////////////////
  $this   -> addTd        ( $HR , $LCS   , $LeftWidth , $bgcolors ) ;
  $HD      = $HR -> addTd (                                       ) ;
  $HD     -> AddTag       ( $INP                                  ) ;
  ///////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function PeriodEditing($HR,$TZ,$editable=false,$NameWidth="3%",$TimeWidth="15%",$bgcolors="")
{
  if ( $editable )                    {
    $this -> editPeriod ( $HR         ,
                          $TZ         ,
                          $NameWidth  ,
                          $TimeWidth  ,
                          $bgcolors ) ;
  } else                              {
    $this -> addPeriod  ( $HR         ,
                          $TZ         ,
                          $NameWidth  ,
                          $TimeWidth  ,
                          $bgcolors ) ;
  }                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function addPeople($ITEM)
{
  $HH    = new Parameters        (                                     ) ;
  $AID   = $this -> get          ( $ITEM                               ) ;
  if                             ( gmp_cmp ( $AID , "0" ) > 0          ) {
    $ACT = $HH   -> PeopleString ( $AID                                ) ;
  } else                                                                 {
    $ACT = ""                                                            ;
  }                                                                      ;
  ////////////////////////////////////////////////////////////////////////
  $JSC  = "LecturePeopleChanged(this.value,'{$ITEM}','{$this->Uuid}') ;" ;
  ////////////////////////////////////////////////////////////////////////
  $INP  = new HtmlTag           (                                      ) ;
  $INP -> setInput              (                                      ) ;
  $INP -> AddPair               ( "type"     , "text"                  ) ;
  $INP -> AddPair               ( "class"    , "NameInput"             ) ;
  $INP -> SafePair              ( "value"    , $ACT                    ) ;
  $INP -> AddPair               ( "onchange" , $JSC                    ) ;
  ////////////////////////////////////////////////////////////////////////
  return $INP                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function CourseListing()
{
  global $CourseNames                                         ;
  $JSC = "LectureCourseChanged(this.value,'{$this->Uuid}') ;" ;
  $HT  = new HtmlTag (                              )         ;
  $HT -> setTag      ( "select"                     )         ;
  $HT -> setSplitter ( "\n"                         )         ;
  $HT -> addOptions  ( $CourseNames , $this -> Item )         ;
  $HT -> AddPair     ( "onchange"   , $JSC          )         ;
  return $HT                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function addCourse($HR,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  ////////////////////////////////////////////////////////
  global $Translations                                   ;
  global $CourseNames                                    ;
  ////////////////////////////////////////////////////////
  $LSS   = $Translations [ "Lectures::Course" ]          ;
  $LST   = $CourseNames  [ $this -> Item      ]          ;
  ////////////////////////////////////////////////////////
  $this -> addTd ( $HR , $LSS , $LeftWidth , $bgcolors ) ;
  $this -> addTd ( $HR , $LST , $NameWidth , $bgcolors ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function CourseEditing($HR,$editable=false,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  ///////////////////////////////////////////////////////////////////////
  global $Translations                                                  ;
  ///////////////////////////////////////////////////////////////////////
  if ( $editable )                                                      {
    $LSS   = $Translations [ "Lectures::Course" ]                       ;
    $this -> addTd        ( $HR , $LSS , $LeftWidth , $bgcolors       ) ;
    $HD    = $HR -> addTd (                                           ) ;
    $HD   -> AddTag       ( $this -> CourseListing ( )                ) ;
  } else                                                                {
    $this -> addCourse    ( $HR , $LeftWidth , $NameWidth , $bgcolors ) ;
  }                                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function StatusListing()
{
  global $LectureStates                                      ;
  $JSC = "LectureStateChanged(this.value,'{$this->Uuid}') ;" ;
  $HT  = new HtmlTag (                                  )    ;
  $HT -> setTag      ( "select"                         )    ;
  $HT -> setSplitter ( "\n"                             )    ;
  $HT -> addOptions  ( $LectureStates , $this -> States )    ;
  $HT -> AddPair     ( "onchange"     , $JSC            )    ;
  return $HT                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function addStatus($HR,$LeftWidth="10%",$NameWidth="15%",$bgcolors="")
{
  ////////////////////////////////////////////////////////
  global $Translations                                   ;
  global $LectureStates                                  ;
  ////////////////////////////////////////////////////////
  $LSS   = $Translations  [ "Lectures::State" ]          ;
  $LST   = $LectureStates [ $this -> States   ]          ;
  ////////////////////////////////////////////////////////
  $this -> addTd ( $HR , $LSS , $LeftWidth , $bgcolors ) ;
  $this -> addTd ( $HR , $LST , $NameWidth , $bgcolors ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function StatusEditing($HR,$editable=false,$LeftWidth="3%",$NameWidth="15%",$bgcolors="")
{
  ///////////////////////////////////////////////////////////////////////
  global $Translations                                                  ;
  ///////////////////////////////////////////////////////////////////////
  if ( $editable )                                                      {
    $LSS   = $Translations [ "Lectures::State" ]                        ;
    $this -> addTd        ( $HR , $LSS , $LeftWidth , $bgcolors       ) ;
    $HD    = $HR -> addTd (                                           ) ;
    $HD   -> AddTag       ( $this -> StatusListing ( )                ) ;
  } else                                                                {
    $this -> addStatus    ( $HR , $LeftWidth , $NameWidth , $bgcolors ) ;
  }                                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function addLectureID($HR,$LeftWidth="3%",$NameWidth="5%",$bgcolors="")
{
  ////////////////////////////////////////////////////////
  global $Translations                                   ;
  ////////////////////////////////////////////////////////
  $LST   = $Translations [ "LectureID" ]                 ;
  $HH    = new Parameters       (               )        ;
  $LID   = $HH -> LectureString ( $this -> Uuid )        ;
  ////////////////////////////////////////////////////////
  $this -> addTd ( $HR , $LST , $LeftWidth , $bgcolors ) ;
  $this -> addTd ( $HR , $LID , $NameWidth , $bgcolors ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addCallOff($TZ,$CLASSID="")
{
  /////////////////////////////////////////////////////////////////
  global $Translations                                            ;
  /////////////////////////////////////////////////////////////////
  $HBX   = new HtmlTag (                                        ) ;
  $HBX  -> setTag      ( "button"                               ) ;
  $HBX  -> AddText     ( $Translations [ "Classes::CallOff" ]   ) ;
  $HBX  -> SafePair    ( "class"   , $CLASSID                   ) ;
  $HBX  -> AddPair     ( "onclick" , $this -> CallOffJS ( $TZ ) ) ;
  /////////////////////////////////////////////////////////////////
  return $HBX                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
public function addCoursesRemove($CLASSID="SelectionButton")
{
  ///////////////////////////////////////////////////
  global $Translations                              ;
  ///////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::RemoveCourse" ] ;
  $JSC  = "RemoveLectureCourse('{$this->Uuid}') ;"  ;
  $BTN  = new HtmlTag (                      )      ;
  $BTN -> setTag      ( "button"             )      ;
  $BTN -> SafePair    ( "class"   , $CLASSID )      ;
  $BTN -> SafePair    ( "onclick" , $JSC     )      ;
  $BTN -> AddText     ( $MSG                 )      ;
  ///////////////////////////////////////////////////
  return $BTN                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function addCoursesButton($CLASSID="SelectionButton")
{
  //////////////////////////////////////////////////
  global $Translations                             ;
  //////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::NewCourse" ]   ;
  $JSC  = "AppendLectureCourse('{$this->Uuid}') ;" ;
  $BTN  = new HtmlTag (                      )     ;
  $BTN -> setTag      ( "button"             )     ;
  $BTN -> SafePair    ( "class"   , $CLASSID )     ;
  $BTN -> SafePair    ( "onclick" , $JSC     )     ;
  $BTN -> AddText     ( $MSG                 )     ;
  //////////////////////////////////////////////////
  return $BTN                                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function addCourseSelection($DIV,$COURSES,$BTNCLASS="SelectionButton",$CLASSID="")
{
  $BTN  = $this -> addCoursesRemove ( $BTNCLASS                      ) ;
  $DIV -> AddTag                    ( $BTN                           ) ;
  //////////////////////////////////////////////////////////////////////
  $HS   = $DIV  -> addSelection     ( $COURSES   , "" , $CLASSID     ) ;
  $HS  -> setSplitter               ( "\n"                           ) ;
  $HS  -> AddPair                   ( "id"       , "SelectedCourses" ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function addAppendCourse($DIV,$ALL,$BTNCLASS="SelectionButton",$CLASSID="")
{
  $HS     = $DIV  -> addSelection     ( $ALL , "" , $CLASSID ) ;
  $HS    -> setSplitter               ( "\n"                 ) ;
  $HS    -> AddPair                   ( "id" , "AllCourses"  ) ;
  //////////////////////////////////////////////////////////////
  $BTN    = $this -> addCoursesButton ( $BTNCLASS            ) ;
  $DIV   -> AddTag                    ( $BTN                 ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function CoursesEditor($COURSES,$ALL,$BTNCLASS="SelectionButton",$CLASSID="")
{
  //////////////////////////////////////////////////////////////////
  $MHT   = new HtmlTag              (                            ) ;
  $THB   = $MHT   -> ConfigureTable ( 0 , 0 , 0                  ) ;
  $HR    = $THB   -> addTr          (                            ) ;
  //////////////////////////////////////////////////////////////////
  $HCD   = $HR    -> addTd          (                            ) ;
  $HLD   = $HR    -> addTd          (                            ) ;
  $HND   = $HR    -> addTd          (                            ) ;
  //////////////////////////////////////////////////////////////////
  $HCD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  $HLD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  $HND  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  $HND  -> AddPair                  ( "align"  , "right"         ) ;
  //////////////////////////////////////////////////////////////////
  $HCD  -> AddPair                  ( "width"  , "3%"            ) ;
  $HLD  -> AddPair                  ( "width"  , "3%"            ) ;
  $HND  -> AddPair                  ( "width"  , "80%"           ) ;
  //////////////////////////////////////////////////////////////////
  $CLD   = $HCD   -> addDiv         ( "" , "CoursesSection" , "" ) ;
  $NLD   = $HND   -> addDiv         ( "" , "CoursesListing" , "" ) ;
  //////////////////////////////////////////////////////////////////
  $CLD  -> setSplitter              ( "\n"                       ) ;
  $NLD  -> setSplitter              ( "\n"                       ) ;
  //////////////////////////////////////////////////////////////////
  $CLD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  $NLD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  //////////////////////////////////////////////////////////////////
  if                                ( count ( $COURSES ) > 0     ) {
    $this -> addCourseSelection     ( $CLD                         ,
                                      $COURSES                     ,
                                      $BTNCLASS                    ,
                                      $CLASSID                   ) ;
  }                                                                ;
  //////////////////////////////////////////////////////////////////
  if                                ( count ( $ALL ) > 0         ) {
    $this -> addAppendCourse        ( $NLD                         ,
                                      $ALL                         ,
                                      $BTNCLASS                    ,
                                      $CLASSID                   ) ;
  }                                                                ;
  //////////////////////////////////////////////////////////////////
  return $MHT                                                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function EditCourses           ( $DB , $LANG                        ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $CX      = new CourseItem           (                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $COURSES = $this -> ObtainCourses   ( $DB , "`erp`.`relations`"          ) ;
  $CNAMES  = $DB   -> GetMapNames     ( "`erp`.`names`" , $COURSES , $LANG ) ;
  $ZNAMES  = array                    (                                    ) ;
  foreach                             ( $COURSES as $cu                    ) {
    $CX -> Uuid = $cu                                                        ;
    if ( $CX -> ObtainsByUuid ( $DB , "`erp`.`courses`" ) )                  {
      $NV             = $CNAMES [ $cu ]                                      ;
      $NZ             = $CX -> Identifier                                    ;
      $VB             = "$NZ $NV"                                            ;
      $ZNAMES [ $cu ] = $VB                                                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ALLCC   = $CX   -> GetReadyCourses ( $DB , "`erp`.`courses`"            ) ;
  $ALLCX   = $DB   -> Exclude         ( $ALLCC , $COURSES                  ) ;
  $ALLCS   = $DB   -> GetMapNames     ( "`erp`.`names`" , $ALLCX , $LANG   ) ;
  $WNAMES  = array                    (                                    ) ;
  foreach                             ( $ALLCX as $cu                      ) {
    $CX -> Uuid = $cu                                                        ;
    if ( $CX -> ObtainsByUuid ( $DB , "`erp`.`courses`" ) )                  {
      $NV             = $ALLCS [ $cu ]                                       ;
      $NZ             = $CX -> Identifier                                    ;
      $VB             = "$NZ $NV"                                            ;
      $WNAMES [ $cu ] = $VB                                                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $CET     = $this -> CoursesEditor   ( $ZNAMES                              ,
                                        $WNAMES                              ,
                                        "SelectionButton"                    ,
                                        "SelectCourse"                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $CET                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function addTimeSections ( $HD )                                      {
  ////////////////////////////////////////////////////////////////
  global $WeekDays                                               ;
  global $DayPeriods                                             ;
  global $Translations                                           ;
  ////////////////////////////////////////////////////////////////
  $WAS  = $Translations [ "Weekly::Append" ]                     ;
  ////////////////////////////////////////////////////////////////
  $WD   = date                 ( "N"                           ) ;
  $WS   = WeekSelections       ( $WeekDays   , $WD             ) ;
  $DPS  = DayPeriodsSelections ( $DayPeriods , 38 , 2          ) ;
  ////////////////////////////////////////////////////////////////
  $WS  -> setSplitter          ( "\n"                          ) ;
  $WS  -> AddPair              ( "id" , "WeekSelections"       ) ;
  $DPS -> setSplitter          ( "\n"                          ) ;
  $DPS -> AddPair              ( "id" , "DayPeriods"           ) ;
  ////////////////////////////////////////////////////////////////
  $HD  -> AddTag               ( $WS                           ) ;
  $HD  -> AddTag               ( $DPS                          ) ;
  ////////////////////////////////////////////////////////////////
  $JSC  = "AppendSection('{$this->Uuid}') ;"                     ;
  $BTN  = $HD -> addButton     ( $WAS                          ) ;
  $BTN -> AddPair              ( "class"   , "SelectionButton" ) ;
  $BTN -> AddPair              ( "onclick" , $JSC              ) ;
  ////////////////////////////////////////////////////////////////
  $HD  -> AddPair              ( "nowrap"  , "nowrap"          ) ;
  $HD  -> AddPair              ( "align"   , "right"           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function MinutesString ( $MINUTES )                                   {
  $HS = intval ( $MINUTES / 60 , 10 )                 ;
  $MS = intval ( $MINUTES % 60 , 10 )                 ;
  if ( $HS < 10 ) $VS = "0{$HS}" ; else $VS = "{$HS}" ;
  if ( $MS < 10 ) $VK = "0{$MS}" ; else $VK = "{$MS}" ;
  return "{$VS}:{$VK}:00"                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function SectionString ( $MINUTES )                                   {
  global $WeekDays                           ;
  global $HourNames                          ;
  ////////////////////////////////////////////
  $DP  =   $MINUTES % 1440                   ;
  $EP  = $DP + 50                            ;
  $HN  = intval ( $DP / 30 , 10 )            ;
  ////////////////////////////////////////////
  $WK  = intval ( $MINUTES / 1440 , 10 ) + 1 ;
  ////////////////////////////////////////////
  $DPS = $this -> MinutesString ( $DP )      ;
  $DPE = $this -> MinutesString ( $EP )      ;
  ////////////////////////////////////////////
  $WDT = $WeekDays  [ $WK ]                  ;
  $WDN = $HourNames [ $HN ]                  ;
  $WDV = "{$DPS}-{$DPE} {$WDT} {$WDN}"       ;
  ////////////////////////////////////////////
  return $WDV                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeSectionsSelector($SECTIONCLASS="")                       {
  ///////////////////////////////////////////////////////////////
  global $Translations                                          ;
  global $WeekDays                                              ;
  global $DayPeriods                                            ;
  ///////////////////////////////////////////////////////////////
  $HS  = new HtmlTag               (                          ) ;
  $HS -> setTag                    ( "select"                 ) ;
  $HS -> setSplitter               ( "\n"                     ) ;
  $HS -> SafePair                  ( "class" , $SECTIONCLASS  ) ;
  ///////////////////////////////////////////////////////////////
  foreach                          ( $this -> Sections as $ss ) {
    $WK   = intval                 ( $ss , 10                 ) ;
    $WDV  = $this -> SectionString ( $WK                      ) ;
    $HPO  = $HS   -> addOption     (                          ) ;
    $HPO -> AddPair                ( "value" , (string) $ss   ) ;
    $HPO -> AddText                ( $WDV                     ) ;
  }                                                             ;
  ///////////////////////////////////////////////////////////////
  return $HS                                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function addSectionsEditor($HD,$SECTIONCLASS="")                      {
  //////////////////////////////////////////////////////////////
  global $WeekDays                                             ;
  global $DayPeriods                                           ;
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  if ( count ( $this -> Sections ) <= 0 ) return               ;
  //////////////////////////////////////////////////////////////
  $HD    -> AddPair          ( "nowrap" , "nowrap"           ) ;
  $HD    -> AddPair          ( "width"  , "3%"               ) ;
  //////////////////////////////////////////////////////////////
  $HS     = $HD -> addSelect ( $SECTIONCLASS                 ) ;
  $HS    -> setSplitter      ( "\n"                          ) ;
  $HS    -> AddPair          ( "id" , "CoursePeriods"        ) ;
  //////////////////////////////////////////////////////////////
  foreach                    ( $this -> Sections as $ss      ) {
    $WK   = intval                 ( $ss , 10                 ) ;
    $WDV  = $this -> SectionString ( $WK                      ) ;
    $HPO  = $HS   -> addOption     (                          ) ;
    $HPO -> AddPair                ( "value" , (string) $ss   ) ;
    $HPO -> AddText                ( $WDV                     ) ;
  }                                                            ;
  //////////////////////////////////////////////////////////////
  $MSG    = $Translations [ "Remove" ]                         ;
  $JSC    = "RemoveSection('{$this->Uuid}') ;"                 ;
  $BTN    = $HD -> addButton ( $MSG                          ) ;
  $BTN   -> AddPair          ( "class"   , "SelectionButton" ) ;
  $BTN   -> AddPair          ( "onclick" , $JSC              ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function TimeSectionEditor($SECTID="",$SECTIONCLASS="")               {
  /////////////////////////////////////////////////////////
  $HT    = new HtmlTag           (                      ) ;
  $HB    = $HT -> ConfigureTable (                      ) ;
  /////////////////////////////////////////////////////////
  $HR    = $HB -> addTr          (                      ) ;
  /////////////////////////////////////////////////////////
  $HD    = $HR -> addTd          (                      ) ;
  $HD   -> setSplitter           ( "\n"                 ) ;
  $HD   -> AddPair               ( "nowrap" , "nowrap"  ) ;
  $HD   -> AddPair               ( "align"  , "left"    ) ;
  $HD   -> AddPair               ( "width"  , "3%"      ) ;
  $DIV   = $HD -> addDiv         ( "" , $SECTID , ""    ) ;
  $this -> addSectionsEditor     ( $DIV , $SECTIONCLASS ) ;
  /////////////////////////////////////////////////////////
  $HD    = $HR -> addTd          (                      ) ;
  $this -> addTimeSections       ( $HD                  ) ;
  /////////////////////////////////////////////////////////
  return $HT                                              ;
}
//////////////////////////////////////////////////////////////////////////////
function AppendSections($DIV,$editable,$SELECTIONS="Selections")             {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  if                                     ( count ( $this -> Sections ) > 0 ) {
    $MXT  = $this -> TimeSectionsSelector ( $SELECTIONS                    ) ;
    $MXT -> AddPair                       ( "id" , "LectureSections"       ) ;
    $DIV -> AddTag                        ( $MXT                           ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $editable ) return                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  if                                     ( count ( $this -> Sections ) > 0 ) {
    $MSG = $Translations [ "Lectures::RemoveSection" ]                       ;
    $JSC = "RemoveSection('{$this->Uuid}','normal') ;"                       ;
    $HD  = $DIV -> addButton             ( $MSG                            ) ;
    $HD -> AddPair                       ( "class"   , "SelectionButton"   ) ;
    $HD -> AddPair                       ( "onclick" , $JSC                ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "Lectures::AppendSection" ]                       ;
  $JSC   = "OpenSections('{$this->Uuid}','open') ;"                          ;
  $HBX   = $DIV -> addButton             ( $MSG                            ) ;
  $HBX  -> AddPair                       ( "class" , "SelectionButton"     ) ;
  $HBX  -> AddPair                       ( "onclick" , $JSC                ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
function CloseSections($DIV,$editable,$SELECTIONS="Selections")              {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  if                                     ( count ( $this -> Sections ) > 0 ) {
    $MXT  = $this -> TimeSectionsSelector ( $SELECTIONS                    ) ;
    $MXT -> AddPair                       ( "id" , "LectureSections"       ) ;
    $DIV -> AddTag                        ( $MXT                           ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $editable ) return                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  if                                     ( count ( $this -> Sections ) > 0 ) {
    $MSG = $Translations [ "Lectures::RemoveSection" ]                       ;
    $JSC = "RemoveSection('{$this->Uuid}','append') ;"                       ;
    $HD  = $DIV -> addButton             ( $MSG                            ) ;
    $HD -> AddPair                       ( "class"   , "SelectionButton"   ) ;
    $HD -> AddPair                       ( "onclick" , $JSC                ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "Lectures::StopSection" ]                         ;
  $JSC   = "OpenSections('{$this->Uuid}','close') ;"                         ;
  $HBX   = $DIV -> addButton             ( $MSG                            ) ;
  $HBX  -> AddPair                       ( "class" , "SelectionButton"     ) ;
  $HBX  -> AddPair                       ( "onclick" , $JSC                ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
