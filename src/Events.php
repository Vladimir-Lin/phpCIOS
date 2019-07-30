<?php

namespace CIOS ;

class Events
{

public $LINES = [ ] ;

function __construct()
{
}

function __destruct()
{
}

public function Pair ( $KEY , $VALUE )
{
  return "\"{$KEY}\": {$VALUE}" ;
}

public function DqPair ( $KEY , $VALUE )
{
  $VALUE = str_replace ( "\\" , "\\\\" , $VALUE ) ;
  $VALUE = str_replace ( "\"" , "\\\"" , $VALUE ) ;
  $VALUE = str_replace ( "\n" , "\\n"  , $VALUE ) ;
  $VALUE = str_replace ( "\t" , "\\t"  , $VALUE ) ;
  return "\"{$KEY}\": \"{$VALUE}\""               ;
}

public function AddPair ( $KEY , $VALUE )
{
  array_push ( $this -> LINES , $this -> Pair ( $KEY , $VALUE ) ) ;
}

public function AddDqPair ( $KEY , $VALUE )
{
  array_push ( $this -> LINES , $this -> DqPair ( $KEY , $VALUE ) ) ;
}

public function Title ( $TITLE )
{
  if ( strlen ( $TITLE ) <= 0 ) return    ;
  $this -> AddDqPair ( "title" , $TITLE ) ;
}

public function Id ( $ID )
{
  if ( strlen ( $ID ) <= 0 ) return ;
  $this -> AddDqPair ( "id" , $ID ) ;
}

public function Group ( $ID )
{
  if ( strlen ( $ID ) <= 0 ) return      ;
  $this -> AddDqPair ( "groupId" , $ID ) ;
}

public function URL ( $U )
{
  if ( strlen ( $U ) <= 0 ) return  ;
  $this -> AddDqPair ( "url" , $U ) ;
}

public function Classes ( $NAMES )
{
  if ( count ( $NAMES ) <= 0 ) return     ;
  $NS = array ( )                         ;
  foreach ( $NAMES as $N )                {
    array_push ( $NS , "\"{$N}\"" )       ;
  }                                       ;
  $NV = implode ( " , " , $NS )           ;
  $NV = "[ {$NV} ]"                       ;
  $this -> AddPair ( "classNames" , $NV ) ;
}

public function AllDay ( $ALL )
{
  $ES = "false"                       ;
  if ( $ALL ) $ES = "true"            ;
  $this -> AddPair ( "allDay" , $ES ) ;
}

public function Editable ( $EDIT )
{
  $ES = "false"                         ;
  if ( $EDIT ) $ES = "true"             ;
  $this -> AddPair ( "editable" , $ES ) ;
}

public function TextColor ( $COLOR )
{
  if ( strlen ( $COLOR ) <= 0 ) return        ;
  $this -> AddDqPair ( "textColor" , $COLOR ) ;
}

public function BorderColor ( $COLOR )
{
  if ( strlen ( $COLOR ) <= 0 ) return          ;
  $this -> AddDqPair ( "borderColor" , $COLOR ) ;
}

public function Background ( $COLOR )
{
  if ( strlen ( $COLOR ) <= 0 ) return              ;
  $this -> AddDqPair ( "backgroundColor" , $COLOR ) ;
}

public function TimeField ( $TZ , $FIELD , $PERIOD )
{
  $TSTR  = $PERIOD -> toTimeString ( $TZ     , $FIELD ) ;
  $this -> AddDqPair               ( $FIELD  , $TSTR  ) ;
}

public function TimeFields ( $TZ , $PERIOD )
{
  $this -> TimeField ( $TZ , "start" , $PERIOD ) ;
  $this -> TimeField ( $TZ , "end"   , $PERIOD ) ;
}

public function Content ( )
{
  $ITEMS = implode ( " ,\n" , $this -> LINES ) ;
  return "{\n{$ITEMS}\n}"                      ;
}

public static function GetTraineeClasses ( $DB , $TABLE , $PEOPLE , $PERIOD , $ITEM )
{
  $PUID  = $PEOPLE -> Uuid                                                   ;
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `trainee` = {$PUID} )"                                  .
             " and ( `item` = {$ITEM} )"                                     .
             " and ( `type` in ( 1 , 2 , 4 ) )"                              .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  return $DB -> ObtainUuids ( $QQ )                                          ;
}

public static function GetTraineeOff ( $DB , $TABLE , $PEOPLE , $PERIOD , $ITEM )
{
  $PUID  = $PEOPLE -> Uuid                                                   ;
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `trainee` = {$PUID} )"                                  .
             " and ( `item` = {$ITEM} )"                                     .
             " and ( `type` in ( 3 , 5 ) )"                                  .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  return $DB -> ObtainUuids ( $QQ )                                          ;
}

public static function ObtainsClasses ( $DB , $TABLE , $CLASSES )
{
  $CLA    = array         (                                                ) ;
  foreach                 ( $CLASSES as $UX                                ) {
    $CXS  = new ClassItem (                                                ) ;
    $CXS -> Uuid = $UX                                                       ;
    $CXS -> ObtainsByUuid ( $DB  , $TABLE                                  ) ;
    array_push            ( $CLA , $CXS                                    ) ;
  }                                                                          ;
  return $CLA                                                                ;
}

public static function StudentClassEvent                                     (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $LANG                                               ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                             )
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $LANG ]                                        ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $XXV = $Translations [ "Classes::Student" ]                              ;
    $SST = $CLASS -> StudentString ( )                                       ;
    $EXTRA  = "{$XXV}{$SST}"                                                 ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $XXV = $Translations [ "Classes::Tutor" ]                                ;
    $SST = $CLASS -> TutorString   ( )                                       ;
    $EXTRA  = "{$XXV}{$SST}"                                                 ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TX     = $DB    -> GetTutor ( $NAMTAB , $CLASS -> Tutor                 ) ;
  $CLT    = $Translations [ "Classes::LecturingTutor" ]                      ;
  $TN     = "{$CLT}{$TX}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat  ( "H:i:s" , "start" , $TZ                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Tutor           ) ;
  $SKYPE  = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $SKYPE = $IMA -> Account                                               ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E      = new Events         (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> Title              ( $TN                                       ) ;
  $E     -> Id                 ( $CLASS -> Uuid                            ) ;
  $E     -> TimeFields         ( $TZ , $PE                                 ) ;
  $E     -> Editable           ( false                                     ) ;
  $E     -> AllDay             ( false                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "name"     , $TX                          ) ;
  $E     -> AddDqPair          ( "tutor"    , $CLASS -> Tutor              ) ;
  $E     -> AddDqPair          ( "skype"    , $SKYPE                       ) ;
  $E     -> AddDqPair          ( "classid"  , $CLSID                       ) ;
  $E     -> AddDqPair          ( "clock"    , $STX                         ) ;
  $E     -> AddDqPair          ( "lecture"  , $LTYPE                       ) ;
  $E     -> AddDqPair          ( "extra"    , $EXTRA                       ) ;
  $E     -> AddDqPair          ( "special"  , $CTMSG                       ) ;
  $E     -> AddPair            ( "status"   , $CLASS -> Type               ) ;
  $E     -> AddPair            ( "type"     , 126                          ) ;
  $E     -> AddPair            ( "language" , $LANG                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $CTMSG                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $CLASS -> Type == 5                       ) {
    $E     -> Classes          ( [ "StudentClassStop"    ]                 ) ;
    $E     -> TextColor        ( "#216521"                                 ) ;
  } else                                                                     {
    $BTID   = $PE -> Between   ( $NOW -> Stardate                          ) ;
    switch                     ( $BTID                                     ) {
      case  1                                                                :
        if                     ( $CLASS -> isCancelled ( )                 ) {
          $E -> Classes        ( [ "StudentClassRemove" ]                  ) ;
          $E -> TextColor      ( "#212165"                                 ) ;
        } else                                                               {
          $E -> Classes        ( [ "StudentClassArrange" ]                 ) ;
          $E -> TextColor      ( "#652121"                                 ) ;
        }                                                                    ;
      break                                                                  ;
      case  0                                                                :
        if                     ( $CLASS -> isCancelled ( )                 ) {
          $E -> Classes        ( [ "StudentClassCancel" ]                  ) ;
          $E -> TextColor      ( "#008B00"                                 ) ;
        } else                                                               {
          $E -> Classes        ( [ "StudentClassLecture" ]                 ) ;
          $E -> TextColor      ( "#333333"                                 ) ;
        }                                                                    ;
      break                                                                  ;
      case -1                                                                :
        if                     ( $CLASS -> isCancelled ( )                 ) {
          $E -> Classes        ( [ "StudentClassCancel" ]                  ) ;
          $E -> TextColor      ( "#8B0000"                                 ) ;
        } else                                                               {
          $E -> Classes        ( [ "StudentClassComplete" ]                ) ;
          $E -> TextColor      ( "#00008B"                                 ) ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////


  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}

public static function LectureEventItem ( $DB , $TZ , $LECTURE )
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $CIDS = $LECTURE -> toString            (                                ) ;
  $TIDS = $Translations [ "Lectures::Register" ]                             ;
  $TIDS = "{$TIDS}{$CIDS}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $PRX  = new Periode                     (                                ) ;
  $PRX -> Start = $LECTURE -> Register                                       ;
  $PRX -> setInterval                     ( 1800                           ) ;
  $STX  = $PRX -> TimeFormat              ( "H:i:s" , "start" , $TZ        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E    = new Events                      (                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> Title                           ( $TIDS                          ) ;
  $E   -> Id                              ( $LECTURE -> Uuid               ) ;
//  $E   -> TimeFields                      ( $TZ , $PRX                     ) ;
  $E   -> TimeField                       ( $TZ , "start" , $PRX           ) ;
  $E   -> Editable                        ( false                          ) ;
  $E   -> AllDay                          ( false                          ) ;
  $E   -> Classes                         ( [ "StudentRegisterItem" ]      ) ;
  $E   -> TextColor                       ( "#4B0082"                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> AddDqPair                       ( "lecture" , $CIDS              ) ;
  $E   -> AddDqPair                       ( "clock"   , $STX               ) ;
  $E   -> AddPair                         ( "type"    , 122                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> AddDqPair                       ( "tooltip" , $TIDS              ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}

public static function ObtainsLectures ( $DB , $TABLE , $LECTURES )
{
  $CLA    = array         (                                                ) ;
  foreach                 ( $LECTURES as $UX                               ) {
    $CXS  = new Lecture   (                                                ) ;
    $CXS -> Uuid = $UX                                                       ;
    $CXS -> ObtainsByUuid ( $DB  , $TABLE                                  ) ;
    array_push            ( $CLA , $CXS                                    ) ;
  }                                                                          ;
  return $CLA                                                                ;
}

public static function LectureRegisterEvents ( $DB , $TABLE , $TZ , $PUID )
{
  $EVENTS = array                   (                                      ) ;
  $LIC    = new Lecture             (                                      ) ;
  $LIC   -> Trainee = $PUID                                                  ;
  $UU     = $LIC -> ObtainsLectures ( $DB , $TABLE , "trainee"             ) ;
  if                                ( count ( $UU ) > 0                    ) {
    $CLA  = self::ObtainsLectures   ( $DB , $TABLE , $UU                   ) ;
    foreach                         ( $CLA as $L                           ) {
      $E  = self::LectureEventItem  ( $DB , $TZ , $L                       ) ;
      array_push                    ( $EVENTS   , $E -> Content ( )        ) ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}

public static function TradeEventItem ( $DB , $TZ , $TRADE )
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseNames                                                        ;
  global $ProductItems                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $CIDS = $TRADE -> toString              (                                ) ;
  $AMNT = $TRADE -> Amount                                                   ;
  $CURY = $TRADE -> Currency                                                 ;
  $PINM = $ProductItems [ $TRADE -> Item  ]                                  ;
  $TAMS = $Translations [ "Trade::Amount" ]                                  ;
  $TAIT = $Translations [ "Trade::Item"   ]                                  ;
  $TAID = $Translations [ "Trade::ID"     ]                                  ;
  $TIDS = "{$TAMS}{$AMNT} {$CURY}\n{$TAIT}{$PINM}\n{$TAID}{$CIDS}"           ;
  ////////////////////////////////////////////////////////////////////////////
  $PRX  = new Periode                     (                                ) ;
  $PRX -> Start = $TRADE -> Record                                           ;
  $PRX -> setInterval                     ( 1800                           ) ;
  $STX  = $PRX -> TimeFormat              ( "H:i:s" , "start" , $TZ        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E    = new Events                      (                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> Title                           ( $TIDS                          ) ;
  $E   -> Id                              ( $TRADE -> Uuid                 ) ;
//  $E   -> TimeFields                      ( $TZ , $PRX                     ) ;
  $E   -> TimeField                       ( $TZ , "start" , $PRX           ) ;
  $E   -> Editable                        ( false                          ) ;
  $E   -> AllDay                          ( false                          ) ;
  $E   -> Classes                         ( [ "StudentTradeItem" ]         ) ;
  $E   -> TextColor                       ( "#7733AA"                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> AddDqPair                       ( "trade"   , $CIDS              ) ;
  $E   -> AddDqPair                       ( "clock"   , $STX               ) ;
  $E   -> AddPair                         ( "type"    , 123                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> AddDqPair                       ( "tooltip" , $TIDS              ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}

public static function ObtainsTrades ( $DB , $TABLE , $TRADES )
{
  $CLA    = array         (                                                ) ;
  foreach                 ( $TRADES as $UX                                 ) {
    $CXS  = new Trade     (                                                ) ;
    $CXS -> Uuid = $UX                                                       ;
    $CXS -> ObtainsByUuid ( $DB  , $TABLE                                  ) ;
    array_push            ( $CLA , $CXS                                    ) ;
  }                                                                          ;
  return $CLA                                                                ;
}

public static function TradeBlockEvents ( $DB , $TABLE , $TZ , $PUID )
{
  $EVENTS = array                       (                                  ) ;
  $TIC    = new Trade                   (                                  ) ;
  $TIC   -> Payer = $PUID                                                    ;
  $UU     = $TIC -> ObtainsTransactions ( $DB , $TABLE , "payer"           ) ;
  if                                    ( count ( $UU ) > 0                ) {
    $CLA  = self::ObtainsTrades         ( $DB , $TABLE , $UU               ) ;
    foreach                             ( $CLA as $T                       ) {
      $E  = self::TradeEventItem        ( $DB , $TZ , $T                   ) ;
      array_push                        ( $EVENTS   , $E -> Content ( )    ) ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}

public static function GetPublicEventsByType ( $DB , $TABLE , $PERIOD , $TYPE )
{
  ////////////////////////////////////////////////////////////////////////////
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `type` = {$TYPE} )"                                     .
           " and ( `start` >= {$START} )"                                    .
             " and ( `end` <= {$ENDST} )"                                    .
           " order by `start` asc ;"                                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids ( $QQ )                                          ;
}

public static function ObtainsPeriods ( $DB , $TABLE , $VACATIONS )
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

public static function PublicEventItem ( $DB , $NAMTAB , $PEOPLE , $PERIOD , $COLOR , $CLASSES )
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $PUID  = $PERIOD -> Uuid                                                   ;
  $LANG  = $PEOPLE -> Language                                               ;
  $TZ    = $PEOPLE -> TZ                                                     ;
  $E     = new Events            (                                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $TIDS  = $PERIOD -> TypeString (                                         ) ;
  $PNAM  = $DB     -> Naming     ( $NAMTAB , $PUID , $LANG , "Default"     ) ;
  $TIDS  = "{$TIDS}\n{$PNAM}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $E    -> Title                 ( $TIDS                                   ) ;
  $E    -> Id                    ( $PUID                                   ) ;
  $E    -> TimeFields            ( $TZ , $PERIOD                           ) ;
  $E    -> Editable              ( false                                   ) ;
  $E    -> AllDay                ( false                                   ) ;
  $E    -> TextColor             ( $COLOR                                  ) ;
  $E    -> Classes               ( $CLASSES                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E    -> AddPair               ( "type" , $PERIOD -> Type                ) ;
  ////////////////////////////////////////////////////////////////////////////
  switch                         ( $PERIOD -> Type                         ) {
    case 12                                                                  :
      $RDMSG = $Translations [ "RestDay"   ]                                 ;
      $TTMSG = $Translations [ "LocalTime" ]                                 ;
      $STMSG = $PERIOD -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s" ) ;
      $ETMSG = $PERIOD -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s" ) ;
      $TT    = "{$PNAM}\n\n{$RDMSG}\n\n{$TTMSG}\n{$STMSG}\n{$ETMSG}"         ;
      $E    -> AddDqPair         ( "tooltip" , $TT                         ) ;
    break                                                                    ;
    case 13                                                                  :
      $TTMSG = $Translations [ "LocalTime" ]                                 ;
      $STMSG = $PERIOD -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s" ) ;
      $ETMSG = $PERIOD -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s" ) ;
      $TT    = "{$PNAM}\n\n{$TTMSG}\n{$STMSG}\n{$ETMSG}"                     ;
      $E    -> AddDqPair         ( "tooltip" , $TT                         ) ;
    break                                                                    ;
    case 14                                                                  :
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $E -> Content           (                                         ) ;
}

public static function VacationEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD )
{
  return self::PublicEventItem ( $DB               ,
                                 $NAMTAB           ,
                                 $PEOPLE           ,
                                 $PERIOD           ,
                                 "#FA8072"         ,
                                 [ "Vacations" ] ) ;
}

public static function SpecialDayEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD )
{
  return self::PublicEventItem ( $DB                 ,
                                 $NAMTAB             ,
                                 $PEOPLE             ,
                                 $PERIOD             ,
                                 "#FFEFD5"           ,
                                 [ "SpecialDays" ] ) ;
}

public static function SolarTermEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD )
{
  return self::PublicEventItem ( $DB               ,
                                 $NAMTAB           ,
                                 $PEOPLE           ,
                                 $PERIOD           ,
                                 "#77FF77"         ,
                                 [ "SolarTerm" ] ) ;
}

public static function PublicEventsByType ( $DB , $PEOPLE , $PERIOD , $TYPE , $PRDTAB , $NAMTAB , $FUNC )
{
  $EVENTS = array                       (                                  ) ;
  $UU     = self::GetPublicEventsByType ( $DB , $PRDTAB , $PERIOD , $TYPE  ) ;
  if                                    ( count ( $UU ) > 0                ) {
    $PRDs = self::ObtainsPeriods        ( $DB , $PRDTAB , $UU              ) ;
    foreach                             ( $PRDs as $P                      ) {
      $E  = $FUNC                       ( $DB , $NAMTAB , $PEOPLE , $P     ) ;
      array_push                        ( $EVENTS , $E                     ) ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}

}

?>
