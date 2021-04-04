<?php
//////////////////////////////////////////////////////////////////////////////
// 處理日曆課堂資訊事件
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Events                                                                 {
//////////////////////////////////////////////////////////////////////////////
public $LINES = [ ]                                                          ;
public $JSONs = array ( )                                                    ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function Clear    ( )                                                 {
  $this -> LINES = array ( )                                                 ;
  $this -> JSONs = array ( )                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function Pair ( $KEY , $VALUE )                                       {
  return "\"{$KEY}\":{$VALUE}"                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function DqPair ( $KEY , $VALUE                                     ) {
  ////////////////////////////////////////////////////////////////////////////
  $VALUE = str_replace ( "\\" , "\\\\" , $VALUE                            ) ;
  $VALUE = str_replace ( "\"" , "\\\"" , $VALUE                            ) ;
  $VALUE = str_replace ( "\n" , "\\n"  , $VALUE                            ) ;
  $VALUE = str_replace ( "\t" , "\\t"  , $VALUE                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  return "\"{$KEY}\":\"{$VALUE}\""                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function AddPair ( $KEY , $VALUE                                    ) {
  $this -> JSONs [ $KEY ] = $VALUE                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function AddDqPair ( $KEY , $VALUE                                  ) {
  $this -> JSONs [ $KEY ] = $VALUE                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function Title ( $TITLE                                             ) {
  if                  ( strlen ( $TITLE ) <= 0                             ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair  ( "title" , $TITLE                                   ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Id   ( $ID                                                 ) {
  if                 ( strlen ( $ID ) <= 0                                 ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair ( "id" , $ID                                          ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Group ( $ID                                                ) {
  if                  ( strlen ( $ID ) <= 0                                ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair  ( "groupId" , $ID                                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function URL  ( $U                                                  ) {
  if                 ( strlen ( $U ) <= 0                                  ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair ( "url" , $U                                          ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Classes ( $NAMES                                           ) {
  if                    ( count ( $NAMES ) <= 0                            ) {
    return                                                                   ;
  }                                                                          ;
  $this -> JSONs [ "classNames" ] = $NAMES                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function AllDay ( $ALL                                              ) {
  $ES   = false                                                              ;
  if                   ( $ALL                                              ) {
    $ES = true                                                               ;
  }                                                                          ;
  $this -> AddPair     ( "allDay" , $ES                                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Editable ( $EDIT                                           ) {
  $ES    = false                                                             ;
  if                     ( $EDIT                                           ) {
    $ES  = true                                                              ;
  }                                                                          ;
  $this -> AddPair       ( "editable" , $ES                                ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function TextColor ( $COLOR                                         ) {
  if                      ( strlen ( $COLOR ) <= 0                         ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair      ( "textColor" , $COLOR                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function BorderColor ( $COLOR                                       ) {
  if                        ( strlen ( $COLOR ) <= 0                       ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair        ( "borderColor" , $COLOR                       ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 新增背景顏色
//////////////////////////////////////////////////////////////////////////////
public function Background ( $COLOR                                        ) {
  if                       ( strlen ( $COLOR ) <= 0                        ) {
    return                                                                   ;
  }                                                                          ;
  $this -> AddDqPair       ( "backgroundColor" , $COLOR                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 新增單一時間欄位
//////////////////////////////////////////////////////////////////////////////
public function TimeField          ( $TZ     , $FIELD , $PERIOD            ) {
  $TSTR  = $PERIOD -> toTimeString ( $TZ     , $FIELD                      ) ;
  $this -> AddDqPair               (           $FIELD , $TSTR              ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 新增時間欄位
//////////////////////////////////////////////////////////////////////////////
public function TimeFields ( $TZ ,           $PERIOD )                       {
  $this -> TimeField       ( $TZ , "start" , $PERIOD )                       ;
  $this -> TimeField       ( $TZ , "end"   , $PERIOD )                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function Content (                                                  ) {
  return json_encode    ( $this -> JSONs                                   ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 事件是否存在
//////////////////////////////////////////////////////////////////////////////
public static function isEvent       ( $Filter , $Events , $Key , $Checked ) {
  ////////////////////////////////////////////////////////////////////////////
  if                                 ( $Filter                             ) {
    $Checked = in_array              ( $Key , $Events                      ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $Checked                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得支付方學員上課列表
//////////////////////////////////////////////////////////////////////////////
public static function GetPayerClasses ( $DB                                 ,
                                         $TABLE                              ,
                                         $LECTAB                             ,
                                         $PUID                               ,
                                         $PAYER                              ,
                                         $PERIOD                             ,
                                         $ITEM                             ) {
  ////////////////////////////////////////////////////////////////////////////
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $PP    = "select `uuid` from {$LECTAB} where ( `payer` = {$PAYER} )"       ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `trainee` = {$PUID} )"                                  .
             " and ( `item` = {$ITEM} )"                                     .
             " and ( `type` in ( 1 , 2 , 4 , 6 , 8 , 9 ) )"                  .
             " and ( `lecture` in ( {$PP} ) )"                               .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids              ( $QQ                             ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得學員上課列表
//////////////////////////////////////////////////////////////////////////////
public static function GetStudentClasses ( $DB                               ,
                                           $TABLE                            ,
                                           $PUID                             ,
                                           $PERIOD                           ,
                                           $ITEM                           ) {
  ////////////////////////////////////////////////////////////////////////////
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `trainee` = {$PUID} )"                                  .
             " and ( `item` = {$ITEM} )"                                     .
             " and ( `type` in ( 1 , 2 , 4 , 6 , 7 , 8 ) )"                  .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids              ( $QQ                             ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得學員上課列表
//////////////////////////////////////////////////////////////////////////////
public static function GetTraineeClasses ( $DB                               ,
                                           $TABLE                            ,
                                           $PEOPLE                           ,
                                           $PERIOD                           ,
                                           $ITEM                           ) {
  return self::GetStudentClasses         ( $DB                               ,
                                           $TABLE                            ,
                                           $PEOPLE -> Uuid                   ,
                                           $PERIOD                           ,
                                           $ITEM                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得支付方學員請假列表
//////////////////////////////////////////////////////////////////////////////
public static function GetPayerOff ( $DB                                     ,
                                     $TABLE                                  ,
                                     $LECTAB                                 ,
                                     $PUID                                   ,
                                     $PAYER                                  ,
                                     $PERIOD                                 ,
                                     $ITEM                                 ) {
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $PP    = "select `uuid` from {$LECTAB} where ( `payer` = {$PAYER} )"       ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `trainee` = {$PUID} )"                                  .
             " and ( `item` = {$ITEM} )"                                     .
             " and ( `type` in ( 3 , 5 ) )"                                  .
             " and ( `lecture` in ( {$PP} ) )"                               .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  return $DB -> ObtainUuids ( $QQ )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得學員請假列表
//////////////////////////////////////////////////////////////////////////////
public static function GetStudentOff ( $DB                                   ,
                                       $TABLE                                ,
                                       $PUID                                 ,
                                       $PERIOD                               ,
                                       $ITEM                               ) {
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `trainee` = {$PUID} )"                                  .
             " and ( `item` = {$ITEM} )"                                     .
             " and ( `type` in ( 3 , 9 ) )"                                  .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  return $DB -> ObtainUuids ( $QQ )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得學員請假列表
//////////////////////////////////////////////////////////////////////////////
public static function GetTraineeOff ( $DB                                   ,
                                       $TABLE                                ,
                                       $PEOPLE                               ,
                                       $PERIOD                               ,
                                       $ITEM                               ) {
  return self::GetStudentOff         ( $DB                                   ,
                                       $TABLE                                ,
                                       $PEOPLE -> Uuid                       ,
                                       $PERIOD                               ,
                                       $ITEM                               ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得教員上課列表
//////////////////////////////////////////////////////////////////////////////
public static function GetTutorClasses ( $DB , $TABLE , $PEOPLE , $PERIOD )  {
  $PUID  = $PEOPLE -> Uuid                                                   ;
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `tutor` = {$PUID} )"                                    .
             " and ( `type` in ( 1 , 2 , 3 , 4 , 6 , 8 , 9 ) )"              .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  return $DB -> ObtainUuids ( $QQ )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得諮詢顧問上課列表
//////////////////////////////////////////////////////////////////////////////
public static function GetAuditionClasses ( $DB                              ,
                                            $TABLE                           ,
                                            $PEOPLE                          ,
                                            $PERIOD                        ) {
  $PUID  = $PEOPLE -> Uuid                                                   ;
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `receptionist` = {$PUID} )"                             .
             " and ( `type` in ( 6 , 8 , 9 ) )"                              .
             " and ( `start` >= {$START} )"                                  .
               " and ( `end` <= {$ENDST} )"                                  .
             " order by `start` asc ;"                                       ;
  return $DB -> ObtainUuids ( $QQ )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得課堂資訊列表
//////////////////////////////////////////////////////////////////////////////
public static function ObtainsClasses ( $DB , $TABLE , $CLASSES )            {
  $CLA    = array         (                                                ) ;
  foreach                 ( $CLASSES as $UX                                ) {
    $CXS  = new ClassItem (                                                ) ;
    $CXS -> Uuid = $UX                                                       ;
    $CXS -> ObtainsByUuid ( $DB  , $TABLE                                  ) ;
    array_push            ( $CLA , $CXS                                    ) ;
  }                                                                          ;
  return $CLA                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示學生上課資訊
//////////////////////////////////////////////////////////////////////////////
public static function StudentClassEvent                                     (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $LANG                                               ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $LUID   = $CLASS -> Lecture                                                ;
  $LECID  = sprintf ( "lec2%08d" , gmp_mod ( $LUID , 100000000 )           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $LANG     ]                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSMSG = $Translations [ "ClassID"   ]                                    ;
  $CLSMSG = "{$CLSMSG}{$CLSID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $LECMSG = $Translations [ "LectureID" ]                                    ;
  $LECMSG = "{$LECMSG}{$LECID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Student" ]                             ;
  $SST    = $CLASS -> StudentString ( )                                      ;
  $SSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Tutor" ]                               ;
  $SST    = $CLASS -> TutorString   ( )                                      ;
  $TSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $EXTRA  = $SSMSG                                                         ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $EXTRA  = $TSMSG                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  switch ( $CLASS -> Type )                                                  {
    case 6                                                                   :
    case 8                                                                   :
      $TX   = $DB    -> GetTutor   ( $NAMTAB , $CLASS -> Tutor             ) ;
      $TB   = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Receptionist      ) ;
      $CLT  = $Translations [ "Classes::LecturingTutor"     ]                ;
      $CLZ  = $Translations [ "Classes::LecturingCounselor" ]                ;
      $TN   = "{$CLT}{$TX}\n{$CLZ}{$TB}"                                     ;
    break                                                                    ;
    default                                                                  :
      $TX   = $DB    -> GetTutor ( $NAMTAB , $CLASS -> Tutor               ) ;
      $CLT  = $Translations [ "Classes::LecturingTutor" ]                    ;
      $TN   = "{$CLT}{$TX}"                                                  ;
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat  ( "H:i:s" , "start" , $TZ                   ) ;
  $STV    = $PE -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s"        ) ;
  $ETV    = $PE -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOX    = new StarDate       (                                           ) ;
  $NOX   -> Stardate = $PE -> Start                                          ;
  $ETS    = $NOX -> Timestamp  (                                           ) ;
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
  $E     -> AddDqPair          ( "name"         , $TX                      ) ;
  $E     -> AddDqPair          ( "tutor"        , $CLASS -> Tutor          ) ;
  $E     -> AddDqPair          ( "receptionist" , $CLASS -> Receptionist   ) ;
  $E     -> AddDqPair          ( "skype"        , $SKYPE                   ) ;
  $E     -> AddDqPair          ( "classid"      , $CLSID                   ) ;
  $E     -> AddDqPair          ( "clock"        , $STX                     ) ;
  $E     -> AddDqPair          ( "lecture"      , $LTYPE                   ) ;
  $E     -> AddDqPair          ( "extra"        , $EXTRA                   ) ;
  $E     -> AddDqPair          ( "special"      , $CTMSG                   ) ;
  $E     -> AddDqPair          ( "classmsg"     , $CLSMSG                  ) ;
  $E     -> AddDqPair          ( "luid"         , $LUID                    ) ;
  $E     -> AddDqPair          ( "lecid"        , $LECID                   ) ;
  $E     -> AddDqPair          ( "lecmsg"       , $LECMSG                  ) ;
  $E     -> AddDqPair          ( "timestamp"    , $ETS                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddPair            ( "status"       , $CLASS -> Type           ) ;
  $E     -> AddPair            ( "type"         , 126                      ) ;
  $E     -> AddPair            ( "language"     , $LANG                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CXID   = $Translations      [ "ClassID"                                 ] ;
  $CXID   = "{$CXID}{$CLSID}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $STMSG  = $Translations      [ "StartTime"                               ] ;
  $STMSG  = "{$STMSG}{$STV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $ETMSG  = $Translations      [ "EndTime"                                 ] ;
  $ETMSG  = "{$ETMSG}{$ETV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $CRMSG  = $Translations      [ "Classes::Course:"                        ] ;
  $CRMSG  = "{$CRMSG}{$LTYPE}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CSMSG  = $Translations      [ "Classes::State"                          ] ;
  $CSMSG  = "{$CSMSG}{$CTMSG}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TOOLTIPS = "{$CXID}\n"                                                    .
              "{$TN}\n"                                                      .
              "{$CRMSG}\n"                                                   .
              "{$CSMSG}\n"                                                   .
              "{$SSMSG}\n"                                                   .
              "{$TSMSG}\n"                                                   .
              "{$STMSG}\n"                                                   .
              "{$ETMSG}"                                                     ;
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
          if                   ( $CLASS -> Type == 1                       ) {
            $CNUMSG   = $Translations [ "Classes::NotUpdated" ]              ;
            $TOOLTIPS = "{$TOOLTIPS}\n{$CNUMSG}"                             ;
          }                                                                  ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $TOOLTIPS                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示監督者上課資訊
//////////////////////////////////////////////////////////////////////////////
public static function PartnerClassEvent                                     (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $LANG                                               ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $LUID   = $CLASS -> Lecture                                                ;
  $LECID  = sprintf ( "lec2%08d" , gmp_mod ( $LUID , 100000000 )           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $CLASS -> Item ]                               ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSMSG = $Translations [ "ClassID"   ]                                    ;
  $CLSMSG = "{$CLSMSG}{$CLSID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $LECMSG = $Translations [ "LectureID" ]                                    ;
  $LECMSG = "{$LECMSG}{$LECID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Student" ]                             ;
  $SST    = $CLASS -> StudentString ( )                                      ;
  $SSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Tutor" ]                               ;
  $SST    = $CLASS -> TutorString   ( )                                      ;
  $TSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $EXTRA  = $SSMSG                                                         ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $EXTRA  = $TSMSG                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TX       = $DB    -> GetStudent ( $NAMTAB , $CLASS -> Trainee           ) ;
  $CLT      = $Translations [ "Classes::LecturingTrainee" ]                  ;
  $CLTXZ    = "{$CLT}{$TX}"                                                  ;
  $TN       = "{$CLTXZ}"                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $TB       = $DB    -> GetTutor   ( $NAMTAB , $CLASS -> Tutor             ) ;
  $CLZ      = $Translations [ "Classes::LecturingTutor"   ]                  ;
  $CLZXZ    = "{$CLZ}{$TB}"                                                  ;
  $TN       = "{$TN}\n{$CLZXZ}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $TC       = ""                                                             ;
  $CLV      = ""                                                             ;
  $CLVXZ    = ""                                                             ;
  if ( gmp_cmp ( $CLASS -> Receptionist , 0 ) > 0 )                          {
    $TC     = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Receptionist      ) ;
    $CLV    = $Translations [ "Classes::LecturingCounselor" ]                ;
    $CLVXZ  = "{$CLV}{$TC}"                                                  ;
    $TN     = "{$TN}\n{$CLVXZ}"                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat  ( "H:i:s" , "start" , $TZ                   ) ;
  $STV    = $PE -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s"        ) ;
  $ETV    = $PE -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOX    = new StarDate       (                                           ) ;
  $NOX   -> Stardate = $PE -> Start                                          ;
  $ETS    = $NOX -> Timestamp  (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Trainee         ) ;
  $SKYPE  = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $SKYPE = $IMA -> Account                                               ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Tutor           ) ;
  $TSKYPE = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $TSKYPE = $IMA -> Account                                              ;
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
  $E     -> AddDqPair          ( "name"         , $TX                      ) ;
  $E     -> AddDqPair          ( "trainee"      , $CLASS -> Trainee        ) ;
  $E     -> AddDqPair          ( "student"      , $CLTXZ                   ) ;
  $E     -> AddDqPair          ( "tutor"        , $CLASS -> Tutor          ) ;
  $E     -> AddDqPair          ( "teacher"      , $CLZXZ                   ) ;
  $E     -> AddDqPair          ( "receptionist" , $CLASS -> Receptionist   ) ;
  $E     -> AddDqPair          ( "cuservice"    , $CLVXZ                   ) ;
  $E     -> AddDqPair          ( "skype"        , $SKYPE                   ) ;
  $E     -> AddDqPair          ( "tskype"       , $TSKYPE                  ) ;
  $E     -> AddDqPair          ( "classid"      , $CLSID                   ) ;
  $E     -> AddDqPair          ( "clock"        , $STX                     ) ;
  $E     -> AddDqPair          ( "lecture"      , $LTYPE                   ) ;
  $E     -> AddDqPair          ( "extra"        , $EXTRA                   ) ;
  $E     -> AddDqPair          ( "special"      , $CTMSG                   ) ;
  $E     -> AddDqPair          ( "classmsg"     , $CLSMSG                  ) ;
  $E     -> AddDqPair          ( "luid"         , $LUID                    ) ;
  $E     -> AddDqPair          ( "lecid"        , $LECID                   ) ;
  $E     -> AddDqPair          ( "lecmsg"       , $LECMSG                  ) ;
  $E     -> AddDqPair          ( "timestamp"    , $ETS                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddPair            ( "status"       , $CLASS -> Type           ) ;
  $E     -> AddPair            ( "type"         , 126                      ) ;
  $E     -> AddPair            ( "language"     , $CLASS -> Item           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CXID   = $Translations      [ "ClassID"                                 ] ;
  $CXID   = "{$CXID}{$CLSID}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $STMSG  = $Translations      [ "StartTime"                               ] ;
  $STMSG  = "{$STMSG}{$STV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $ETMSG  = $Translations      [ "EndTime"                                 ] ;
  $ETMSG  = "{$ETMSG}{$ETV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $CRMSG  = $Translations      [ "Classes::Course:"                        ] ;
  $CRMSG  = "{$CRMSG}{$LTYPE}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CSMSG  = $Translations      [ "Classes::State"                          ] ;
  $CSMSG  = "{$CSMSG}{$CTMSG}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TOOLTIPS = "{$CXID}\n"                                                    .
              "{$TN}\n"                                                      .
              "{$CRMSG}\n"                                                   .
              "{$CSMSG}\n"                                                   .
              "{$SSMSG}\n"                                                   .
              "{$TSMSG}\n"                                                   .
              "{$STMSG}\n"                                                   .
              "{$ETMSG}"                                                     ;
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
          if                   ( $CLASS -> Type == 1                       ) {
            $CNUMSG   = $Translations [ "Classes::NotUpdated" ]              ;
            $TOOLTIPS = "{$TOOLTIPS}\n{$CNUMSG}"                             ;
          }                                                                  ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $TOOLTIPS                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示教員上課資訊
//////////////////////////////////////////////////////////////////////////////
public static function TutorClassEvent                                       (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $LUID   = $CLASS -> Lecture                                                ;
  $LECID  = sprintf ( "lec2%08d" , gmp_mod ( $LUID , 100000000 )           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $CLASS -> Item ]                               ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSMSG = $Translations [ "ClassID"   ]                                    ;
  $CLSMSG = "{$CLSMSG}{$CLSID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $LECMSG = $Translations [ "LectureID" ]                                    ;
  $LECMSG = "{$LECMSG}{$LECID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Student" ]                             ;
  $SST    = $CLASS -> StudentString ( )                                      ;
  $SSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Tutor" ]                               ;
  $SST    = $CLASS -> TutorString   ( )                                      ;
  $TSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $EXTRA  = $SSMSG                                                         ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $EXTRA  = $TSMSG                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  switch ( $CLASS -> Type )                                                  {
    case 6                                                                   :
    case 8                                                                   :
      $TX   = $DB    -> GetStudent ( $NAMTAB , $CLASS -> Trainee           ) ;
      $TB   = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Receptionist      ) ;
      $CLT  = $Translations [ "Classes::LecturingTrainee"   ]                ;
      $CLZ  = $Translations [ "Classes::LecturingCounselor" ]                ;
      $TN   = "{$CLT}{$TX}\n{$CLZ}{$TB}"                                     ;
    break                                                                    ;
    default                                                                  :
      $TX   = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Trainee           ) ;
      $CLT  = $Translations [ "Classes::LecturingTrainee" ]                  ;
      $TN   = "{$CLT}{$TX}"                                                  ;
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat   ( "H:i:s" , "start" , $TZ                  ) ;
  $STV    = $PE -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s"        ) ;
  $ETV    = $PE -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOX    = new StarDate       (                                           ) ;
  $NOX   -> Stardate = $PE -> Start                                          ;
  $ETS    = $NOX -> Timestamp  (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Trainee         ) ;
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
  $E     -> AddDqPair          ( "name"         , $TX                      ) ;
  $E     -> AddDqPair          ( "trainee"      , $CLASS -> Trainee        ) ;
  $E     -> AddDqPair          ( "receptionist" , $CLASS -> Receptionist   ) ;
  $E     -> AddDqPair          ( "skype"        , $SKYPE                   ) ;
  $E     -> AddDqPair          ( "classid"      , $CLSID                   ) ;
  $E     -> AddDqPair          ( "clock"        , $STX                     ) ;
  $E     -> AddDqPair          ( "lecture"      , $LTYPE                   ) ;
  $E     -> AddDqPair          ( "extra"        , $EXTRA                   ) ;
  $E     -> AddDqPair          ( "special"      , $CTMSG                   ) ;
  $E     -> AddDqPair          ( "classmsg"     , $CLSMSG                  ) ;
  $E     -> AddDqPair          ( "luid"         , $LUID                    ) ;
  $E     -> AddDqPair          ( "lecid"        , $LECID                   ) ;
  $E     -> AddDqPair          ( "lecmsg"       , $LECMSG                  ) ;
  $E     -> AddDqPair          ( "timestamp"    , $ETS                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddPair            ( "status"       , $CLASS -> Type           ) ;
  $E     -> AddPair            ( "type"         , 126                      ) ;
  $E     -> AddPair            ( "language"     , $CLASS -> Item           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CXID   = $Translations      [ "ClassID"                                 ] ;
  $CXID   = "{$CXID}{$CLSID}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $STMSG  = $Translations      [ "StartTime"                               ] ;
  $STMSG  = "{$STMSG}{$STV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $ETMSG  = $Translations      [ "EndTime"                                 ] ;
  $ETMSG  = "{$ETMSG}{$ETV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $CRMSG  = $Translations      [ "Classes::Course:"                        ] ;
  $CRMSG  = "{$CRMSG}{$LTYPE}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CSMSG  = $Translations      [ "Classes::State"                          ] ;
  $CSMSG  = "{$CSMSG}{$CTMSG}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TOOLTIPS = "{$CXID}\n"                                                    .
              "{$TN}\n"                                                      .
              "{$CRMSG}\n"                                                   .
              "{$CSMSG}\n"                                                   .
              "{$SSMSG}\n"                                                   .
              "{$TSMSG}\n"                                                   .
              "{$STMSG}\n"                                                   .
              "{$ETMSG}"                                                     ;
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
          if                   ( $CLASS -> Type == 1                       ) {
            $CNUMSG   = $Translations [ "Classes::NotUpdated" ]              ;
            $TOOLTIPS = "{$TOOLTIPS}\n{$CNUMSG}"                             ;
          }                                                                  ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $TOOLTIPS                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示諮詢顧問上課資訊
//////////////////////////////////////////////////////////////////////////////
public static function AuditionCounselorsClassEvent                          (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $LUID   = $CLASS -> Lecture                                                ;
  $LECID  = sprintf ( "lec2%08d" , gmp_mod ( $LUID , 100000000 )           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $CLASS -> Item ]                               ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSMSG = $Translations [ "ClassID"   ]                                    ;
  $CLSMSG = "{$CLSMSG}{$CLSID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $LECMSG = $Translations [ "LectureID" ]                                    ;
  $LECMSG = "{$LECMSG}{$LECID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Student" ]                             ;
  $SST    = $CLASS -> StudentString ( )                                      ;
  $SSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Tutor" ]                               ;
  $SST    = $CLASS -> TutorString   ( )                                      ;
  $TSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $EXTRA  = $SSMSG                                                         ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $EXTRA  = $TSMSG                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TX     = $DB    -> GetStudent ( $NAMTAB , $CLASS -> Trainee             ) ;
  $CLT    = $Translations [ "Classes::LecturingTrainee" ]                    ;
  $CLTXZ  = "{$CLT}{$TX}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TB     = $DB    -> GetTutor   ( $NAMTAB , $CLASS -> Tutor               ) ;
  $CLZ    = $Translations [ "Classes::LecturingTutor"   ]                    ;
  $CLZXZ  = "{$CLZ}{$TB}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TN     = $Translations [ "Students::Booking" ]                            ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat   ( "H:i:s" , "start" , $TZ                  ) ;
  $STV    = $PE -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s"        ) ;
  $ETV    = $PE -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOX    = new StarDate       (                                           ) ;
  $NOX   -> Stardate = $PE -> Start                                          ;
  $ETS    = $NOX -> Timestamp  (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Trainee         ) ;
  $SKYPE  = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $SKYPE = $IMA -> Account                                               ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Tutor           ) ;
  $TSKYPE = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $TSKYPE = $IMA -> Account                                              ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E      = new Events         (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> Id                 ( $CLASS -> Uuid                            ) ;
  $E     -> Title              ( $TN                                       ) ;
  $E     -> TimeFields         ( $TZ , $PE                                 ) ;
  $E     -> Editable           ( false                                     ) ;
  $E     -> AllDay             ( false                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "trainee"      , $CLASS -> Trainee        ) ;
  $E     -> AddDqPair          ( "student"      , $CLTXZ                   ) ;
  $E     -> AddDqPair          ( "tutor"        , $CLASS -> Tutor          ) ;
  $E     -> AddDqPair          ( "teacher"      , $CLZXZ                   ) ;
  $E     -> AddDqPair          ( "receptionist" , $CLASS -> Receptionist   ) ;
  $E     -> AddDqPair          ( "skype"        , $SKYPE                   ) ;
  $E     -> AddDqPair          ( "tskype"       , $TSKYPE                  ) ;
  $E     -> AddDqPair          ( "classid"      , $CLSID                   ) ;
  $E     -> AddDqPair          ( "clock"        , $STX                     ) ;
  $E     -> AddDqPair          ( "lecture"      , $LTYPE                   ) ;
  $E     -> AddDqPair          ( "extra"        , $EXTRA                   ) ;
  $E     -> AddDqPair          ( "special"      , $CTMSG                   ) ;
  $E     -> AddDqPair          ( "classmsg"     , $CLSMSG                  ) ;
  $E     -> AddDqPair          ( "luid"         , $LUID                    ) ;
  $E     -> AddDqPair          ( "lecid"        , $LECID                   ) ;
  $E     -> AddDqPair          ( "lecmsg"       , $LECMSG                  ) ;
  $E     -> AddDqPair          ( "timestamp"    , $ETS                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddPair            ( "status"       , $CLASS -> Type           ) ;
  $E     -> AddPair            ( "type"         , 126                      ) ;
  $E     -> AddPair            ( "language"     , $CLASS -> Item           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CXID   = $Translations      [ "ClassID"                                 ] ;
  $CXID   = "{$CXID}{$CLSID}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $STMSG  = $Translations      [ "StartTime"                               ] ;
  $STMSG  = "{$STMSG}{$STV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $ETMSG  = $Translations      [ "EndTime"                                 ] ;
  $ETMSG  = "{$ETMSG}{$ETV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $CRMSG  = $Translations      [ "Classes::Course:"                        ] ;
  $CRMSG  = "{$CRMSG}{$LTYPE}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CSMSG  = $Translations      [ "Classes::State"                          ] ;
  $CSMSG  = "{$CSMSG}{$CTMSG}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TOOLTIPS = "{$CXID}\n"                                                    .
              "{$TN}\n"                                                      .
              "{$CRMSG}\n"                                                   .
              "{$CSMSG}\n"                                                   .
              "{$SSMSG}\n"                                                   .
              "{$TSMSG}\n"                                                   .
              "{$STMSG}\n"                                                   .
              "{$ETMSG}"                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $CLASS -> Type == 9                       ) {
    $E -> Classes              ( [ "BookingClassCancel" ]                  ) ;
    $E -> TextColor            ( "#212165"                                 ) ;
  } else                                                                     {
    //////////////////////////////////////////////////////////////////////////
    $BTID   = $PE -> Between   ( $NOW -> Stardate                          ) ;
    switch                     ( $BTID                                     ) {
      case  1                                                                :
        $E -> Classes          ( [ "BookingClassArrange" ]                 ) ;
        $E -> TextColor        ( "#652121"                                 ) ;
      break                                                                  ;
      case  0                                                                :
        $E -> Classes          ( [ "BookingClassLecturing" ]               ) ;
        $E -> TextColor        ( "#333333"                                 ) ;
      break                                                                  ;
      case -1                                                                :
        $E -> Classes          ( [ "BookingClassComplete" ]                ) ;
        $E -> TextColor        ( "#00008B"                                 ) ;
        if                     ( $CLASS -> Type == 6                       ) {
          $CNUMSG   = $Translations [ "Classes::NotUpdated" ]                ;
          $TOOLTIPS = "{$TOOLTIPS}\n{$CNUMSG}"                               ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $TOOLTIPS                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示教員預約評估上課資訊
//////////////////////////////////////////////////////////////////////////////
public static function AuditionTutorsClassEvent                              (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $LUID   = $CLASS -> Lecture                                                ;
  $LECID  = sprintf ( "lec2%08d" , gmp_mod ( $LUID , 100000000 )           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $CLASS -> Item ]                               ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSMSG = $Translations [ "ClassID"   ]                                    ;
  $CLSMSG = "{$CLSMSG}{$CLSID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $LECMSG = $Translations [ "LectureID" ]                                    ;
  $LECMSG = "{$LECMSG}{$LECID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Student" ]                             ;
  $SST    = $CLASS -> StudentString ( )                                      ;
  $SSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Tutor" ]                               ;
  $SST    = $CLASS -> TutorString   ( )                                      ;
  $TSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $EXTRA  = $SSMSG                                                         ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $EXTRA  = $TSMSG                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TX     = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Trainee             ) ;
  $CLT    = $Translations [ "Classes::LecturingTrainee" ]                    ;
  $CLTXZ  = "{$CLT}{$TX}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TB     = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Receptionist        ) ;
  $CLZ    = $Translations [ "Classes::LecturingCounselor"   ]                ;
  $CLZXZ  = "{$CLZ}{$TB}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TN     = $Translations [ "Students::Booking" ]                            ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat   ( "H:i:s" , "start" , $TZ                  ) ;
  $STV    = $PE -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s"        ) ;
  $ETV    = $PE -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOX    = new StarDate       (                                           ) ;
  $NOX   -> Stardate = $PE -> Start                                          ;
  $ETS    = $NOX -> Timestamp  (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Trainee         ) ;
  $SKYPE  = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $SKYPE = $IMA -> Account                                               ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Receptionist    ) ;
  $CSKYPE = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $CSKYPE = $IMA -> Account                                              ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E      = new Events         (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> Id                 ( $CLASS -> Uuid                            ) ;
  $E     -> Title              ( $TN                                       ) ;
  $E     -> TimeFields         ( $TZ , $PE                                 ) ;
  $E     -> Editable           ( false                                     ) ;
  $E     -> AllDay             ( false                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "trainee"      , $CLASS -> Trainee        ) ;
  $E     -> AddDqPair          ( "student"      , $CLTXZ                   ) ;
  $E     -> AddDqPair          ( "tutor"        , $CLASS -> Tutor          ) ;
  $E     -> AddDqPair          ( "receptionist" , $CLASS -> Receptionist   ) ;
  $E     -> AddDqPair          ( "service"      , $CLZXZ                   ) ;
  $E     -> AddDqPair          ( "skype"        , $SKYPE                   ) ;
  $E     -> AddDqPair          ( "cskype"       , $CSKYPE                  ) ;
  $E     -> AddDqPair          ( "classid"      , $CLSID                   ) ;
  $E     -> AddDqPair          ( "clock"        , $STX                     ) ;
  $E     -> AddDqPair          ( "lecture"      , $LTYPE                   ) ;
  $E     -> AddDqPair          ( "extra"        , $EXTRA                   ) ;
  $E     -> AddDqPair          ( "special"      , $CTMSG                   ) ;
  $E     -> AddDqPair          ( "classmsg"     , $CLSMSG                  ) ;
  $E     -> AddDqPair          ( "luid"         , $LUID                    ) ;
  $E     -> AddDqPair          ( "lecid"        , $LECID                   ) ;
  $E     -> AddDqPair          ( "lecmsg"       , $LECMSG                  ) ;
  $E     -> AddDqPair          ( "timestamp"    , $ETS                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddPair            ( "status"       , $CLASS -> Type           ) ;
  $E     -> AddPair            ( "type"         , 126                      ) ;
  $E     -> AddPair            ( "language"     , $CLASS -> Item           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CXID   = $Translations      [ "ClassID"                                 ] ;
  $CXID   = "{$CXID}{$CLSID}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $STMSG  = $Translations      [ "StartTime"                               ] ;
  $STMSG  = "{$STMSG}{$STV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $ETMSG  = $Translations      [ "EndTime"                                 ] ;
  $ETMSG  = "{$ETMSG}{$ETV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $CRMSG  = $Translations      [ "Classes::Course:"                        ] ;
  $CRMSG  = "{$CRMSG}{$LTYPE}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CSMSG  = $Translations      [ "Classes::State"                          ] ;
  $CSMSG  = "{$CSMSG}{$CTMSG}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TOOLTIPS = "{$CXID}\n"                                                    .
              "{$TN}\n"                                                      .
              "{$CRMSG}\n"                                                   .
              "{$CSMSG}\n"                                                   .
              "{$SSMSG}\n"                                                   .
              "{$TSMSG}\n"                                                   .
              "{$STMSG}\n"                                                   .
              "{$ETMSG}"                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $CLASS -> Type == 9                       ) {
    $E -> Classes              ( [ "BookingClassCancel" ]                  ) ;
    $E -> TextColor            ( "#212165"                                 ) ;
  } else                                                                     {
    //////////////////////////////////////////////////////////////////////////
    $BTID   = $PE -> Between   ( $NOW -> Stardate                          ) ;
    switch                     ( $BTID                                     ) {
      case  1                                                                :
        $E -> Classes          ( [ "BookingClassArrange" ]                 ) ;
        $E -> TextColor        ( "#652121"                                 ) ;
      break                                                                  ;
      case  0                                                                :
        $E -> Classes          ( [ "BookingClassLecturing" ]               ) ;
        $E -> TextColor        ( "#333333"                                 ) ;
      break                                                                  ;
      case -1                                                                :
        $E -> Classes          ( [ "BookingClassComplete" ]                ) ;
        $E -> TextColor        ( "#00008B"                                 ) ;
        if                     ( $CLASS -> Type == 6                       ) {
          $CNUMSG   = $Translations [ "Classes::NotUpdated" ]                ;
          $TOOLTIPS = "{$TOOLTIPS}\n{$CNUMSG}"                               ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $TOOLTIPS                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示學員預約評估上課資訊
//////////////////////////////////////////////////////////////////////////////
public static function AuditionStudentsClassEvent                            (
                         $DB                                                 ,
                         $CLASS                                              ,
                         $NOW                                                ,
                         $TZ                                                 ,
                         $NAMTAB                                             ,
                         $PRDTAB                                             ,
                         $IMSTAB                                             ,
                         $RELTAB                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSID  = $CLASS -> toString (                                           ) ;
  $LUID   = $CLASS -> Lecture                                                ;
  $LECID  = sprintf ( "lec2%08d" , gmp_mod ( $LUID , 100000000 )           ) ;
  $CTMSG  = $CLASS -> ClassTypeString (                                    ) ;
  $LTYPE  = $CourseListings [ $CLASS -> Item ]                               ;
  ////////////////////////////////////////////////////////////////////////////
  $EXTRA  = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSMSG = $Translations [ "ClassID"   ]                                    ;
  $CLSMSG = "{$CLSMSG}{$CLSID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $LECMSG = $Translations [ "LectureID" ]                                    ;
  $LECMSG = "{$LECMSG}{$LECID}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Student" ]                             ;
  $SST    = $CLASS -> StudentString ( )                                      ;
  $SSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $XXV    = $Translations [ "Classes::Tutor" ]                               ;
  $SST    = $CLASS -> TutorString   ( )                                      ;
  $TSMSG  = "{$XXV}{$SST}"                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $CLASS -> isAbsent ( "trainee" ) )                                    {
    $EXTRA  = $SSMSG                                                         ;
  } else
  if ( $CLASS -> isAbsent ( "tutor"   ) )                                    {
    $EXTRA  = $TSMSG                                                         ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TX     = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Tutor               ) ;
  $CLT    = $Translations [ "Classes::LecturingTutor"     ]                  ;
  $CLTXZ  = "{$CLT}{$TX}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TB     = $DB    -> GetTrainee ( $NAMTAB , $CLASS -> Receptionist        ) ;
  $CLZ    = $Translations [ "Classes::LecturingCounselor" ]                  ;
  $CLZXZ  = "{$CLZ}{$TB}"                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TN     = $Translations [ "Students::Booking" ]                            ;
  ////////////////////////////////////////////////////////////////////////////
  $PE     = $CLASS -> toPeriod (                                           ) ;
  $PE    -> ObtainsByUuid      ( $DB , $PRDTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $STX    = $PE -> TimeFormat   ( "H:i:s" , "start" , $TZ                  ) ;
  $STV    = $PE -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s"        ) ;
  $ETV    = $PE -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOX    = new StarDate       (                                           ) ;
  $NOX   -> Stardate = $PE -> Start                                          ;
  $ETS    = $NOX -> Timestamp  (                                           ) ;
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
  $IMP    = $CLASS  -> SkypeID ( $DB , $RELTAB , $CLASS -> Receptionist    ) ;
  $CSKYPE = ""                                                               ;
  if                           ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp          (                                           ) ;
    $IMA -> Uuid = $IMP                                                      ;
    if                         ( $IMA -> ObtainsByUuid ( $DB , $IMSTAB )   ) {
      $CSKYPE = $IMA -> Account                                              ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E      = new Events         (                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> Id                 ( $CLASS -> Uuid                            ) ;
  $E     -> Title              ( $TN                                       ) ;
  $E     -> TimeFields         ( $TZ , $PE                                 ) ;
  $E     -> Editable           ( false                                     ) ;
  $E     -> AllDay             ( false                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "trainee"      , $CLASS -> Trainee        ) ;
  $E     -> AddDqPair          ( "tutor"        , $CLASS -> Tutor          ) ;
  $E     -> AddDqPair          ( "teacher"      , $CLTXZ                   ) ;
  $E     -> AddDqPair          ( "receptionist" , $CLASS -> Receptionist   ) ;
  $E     -> AddDqPair          ( "service"      , $CLZXZ                   ) ;
  $E     -> AddDqPair          ( "skype"        , $SKYPE                   ) ;
  $E     -> AddDqPair          ( "cskype"       , $CSKYPE                  ) ;
  $E     -> AddDqPair          ( "classid"      , $CLSID                   ) ;
  $E     -> AddDqPair          ( "clock"        , $STX                     ) ;
  $E     -> AddDqPair          ( "lecture"      , $LTYPE                   ) ;
  $E     -> AddDqPair          ( "extra"        , $EXTRA                   ) ;
  $E     -> AddDqPair          ( "special"      , $CTMSG                   ) ;
  $E     -> AddDqPair          ( "classmsg"     , $CLSMSG                  ) ;
  $E     -> AddDqPair          ( "luid"         , $LUID                    ) ;
  $E     -> AddDqPair          ( "lecid"        , $LECID                   ) ;
  $E     -> AddDqPair          ( "lecmsg"       , $LECMSG                  ) ;
  $E     -> AddDqPair          ( "timestamp"    , $ETS                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddPair            ( "status"       , $CLASS -> Type           ) ;
  $E     -> AddPair            ( "type"         , 126                      ) ;
  $E     -> AddPair            ( "language"     , $CLASS -> Item           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $CXID   = $Translations      [ "ClassID"                                 ] ;
  $CXID   = "{$CXID}{$CLSID}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $STMSG  = $Translations      [ "StartTime"                               ] ;
  $STMSG  = "{$STMSG}{$STV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $ETMSG  = $Translations      [ "EndTime"                                 ] ;
  $ETMSG  = "{$ETMSG}{$ETV}"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $CRMSG  = $Translations      [ "Classes::Course:"                        ] ;
  $CRMSG  = "{$CRMSG}{$LTYPE}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $CSMSG  = $Translations      [ "Classes::State"                          ] ;
  $CSMSG  = "{$CSMSG}{$CTMSG}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TOOLTIPS = "{$CXID}\n"                                                    .
              "{$TN}\n"                                                      .
              "{$CRMSG}\n"                                                   .
              "{$CSMSG}\n"                                                   .
              "{$SSMSG}\n"                                                   .
              "{$TSMSG}\n"                                                   .
              "{$STMSG}\n"                                                   .
              "{$ETMSG}"                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $CLASS -> Type == 9                       ) {
    $E -> Classes              ( [ "BookingClassCancel" ]                  ) ;
    $E -> TextColor            ( "#212165"                                 ) ;
  } else                                                                     {
    //////////////////////////////////////////////////////////////////////////
    $BTID   = $PE -> Between   ( $NOW -> Stardate                          ) ;
    switch                     ( $BTID                                     ) {
      case  1                                                                :
        $E -> Classes          ( [ "BookingClassArrange" ]                 ) ;
        $E -> TextColor        ( "#652121"                                 ) ;
      break                                                                  ;
      case  0                                                                :
        $E -> Classes          ( [ "BookingClassLecturing" ]               ) ;
        $E -> TextColor        ( "#333333"                                 ) ;
      break                                                                  ;
      case -1                                                                :
        $E -> Classes          ( [ "BookingClassComplete" ]                ) ;
        $E -> TextColor        ( "#00008B"                                 ) ;
        if                     ( $CLASS -> Type == 6                       ) {
          $CNUMSG   = $Translations [ "Classes::NotUpdated" ]                ;
          $TOOLTIPS = "{$TOOLTIPS}\n{$CNUMSG}"                               ;
        }                                                                    ;
      break                                                                  ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $E     -> AddDqPair          ( "tooltip"  , $TOOLTIPS                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 排課資訊
//////////////////////////////////////////////////////////////////////////////
public static function LectureEventItem ( $DB , $TZ , $LECTURE             ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseNames                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  $CLSTAB   = $GLOBALS [ "TableMapping" ] [ "Classes"     ]                  ;
  $NAMTAB   = $GLOBALS [ "TableMapping" ] [ "PeopleNames" ]                  ;
  $LUID     = $LECTURE -> Uuid                                               ;
  $QQ       = "select count(*) from {$CLSTAB} where `lecture` = {$LUID} ;"   ;
  $CLES     = $DB -> FetchOne           ( $QQ                              ) ;
  $LTSG     = $Translations [ "Lectures::Total" ]                            ;
  ////////////////////////////////////////////////////////////////////////////
  $CIDS     = $LECTURE -> toString      (                                  ) ;
  $CNIT     = $CourseNames  [ $LECTURE -> Item     ]                         ;
  $TIDS     = $Translations [ "Lectures::Register" ]                         ;
  $TIDS     = "{$CNIT} {$LTSG}{$CLES}\n{$TIDS}{$CIDS}"                       ;
  ////////////////////////////////////////////////////////////////////////////
  $STNAME   = $DB -> GetStudent         ( $NAMTAB , $LECTURE -> Trainee    ) ;
  $TRNAME   = $DB -> GetTrainee         ( $NAMTAB , $LECTURE -> Trainee    ) ;
  $TUNAME   = $DB -> GetTutor           ( $NAMTAB , $LECTURE -> Tutor      ) ;
  $PYNAME   = $DB -> GetStudent         ( $NAMTAB , $LECTURE -> Payer      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $PRX      = new Periode               (                                  ) ;
  $PRX     -> Start = $LECTURE -> Register                                   ;
  $PRX     -> setInterval               ( 1800                             ) ;
  $STX      = $PRX -> TimeFormat        ( "H:i:s" , "start" , $TZ          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $PRZ      = new Periode               (                                  ) ;
  $PRZ     -> Start = $LECTURE -> OpenDay                                    ;
  $PRZ     -> End   = $LECTURE -> CloseDay                                   ;
  $STV      = $PRZ -> toLongString      ( $TZ                                ,
                                          "start"                            ,
                                          "Y/m/d"                            ,
                                          "H:i:s"                          ) ;
  $ETV      = $PRZ -> toLongString      ( $TZ                                ,
                                          "end"                              ,
                                          "Y/m/d"                            ,
                                          "H:i:s"                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E        = new Events                (                                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E       -> Title                     ( $TIDS                            ) ;
  $E       -> Id                        ( $LECTURE -> Uuid                 ) ;
//  $E       -> TimeFields                ( $TZ , $PRX                       ) ;
  $E       -> TimeField                 ( $TZ , "start" , $PRX             ) ;
  $E       -> Editable                  ( false                            ) ;
  $E       -> AllDay                    ( false                            ) ;
  $E       -> Classes                   ( [ "StudentRegisterItem" ]        ) ;
  $E       -> TextColor                 ( "#4B0082"                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E       -> AddDqPair                 ( "lecture" , $CIDS                ) ;
  $E       -> AddDqPair                 ( "clock"   , $STX                 ) ;
  $E       -> AddPair                   ( "type"    , 122                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $TIDS     = "{$TIDS}\n{$STV}\n{$ETV}"                                      ;
  $E       -> AddDqPair                 ( "tooltip" , $TIDS                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E       -> AddDqPair                 ( "trainee" , $LECTURE -> Trainee  ) ;
  $E       -> AddDqPair                 ( "tutor"   , $LECTURE -> Tutor    ) ;
  $E       -> AddDqPair                 ( "manager" , $LECTURE -> Manager  ) ;
  $E       -> AddDqPair                 ( "payer"   , $LECTURE -> Payer    ) ;
  $E       -> AddDqPair                 ( "receptionist"                     ,
                                          $LECTURE -> Receptionist         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E       -> AddDqPair                 ( "studentname" , $STNAME          ) ;
  $E       -> AddDqPair                 ( "traineename" , $TRNAME          ) ;
  $E       -> AddDqPair                 ( "tutorname"   , $TUNAME          ) ;
  $E       -> AddDqPair                 ( "payername"   , $PYNAME          ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得排課資訊
//////////////////////////////////////////////////////////////////////////////
public static function ObtainsLectures ( $DB , $TABLE , $LECTURES )          {
  $CLA    = array         (                                                ) ;
  foreach                 ( $LECTURES as $UX                               ) {
    $CXS  = new Lecture   (                                                ) ;
    $CXS -> Uuid = $UX                                                       ;
    $CXS -> ObtainsByUuid ( $DB  , $TABLE                                  ) ;
    array_push            ( $CLA , $CXS                                    ) ;
  }                                                                          ;
  return $CLA                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示排課資訊
//////////////////////////////////////////////////////////////////////////////
public static function LectureRegisterEvents ( $DB                           ,
                                               $TABLE                        ,
                                               $TZ                           ,
                                               $PERIOD                       ,
                                               $PUID                       ) {
  $EVENTS = array                    (                                     ) ;
  $LIC    = new Lecture              (                                     ) ;
  $LIC   -> Trainee = $PUID                                                  ;
  $UU     = $LIC -> ObtainsLectures  ( $DB , $TABLE , "trainee"            ) ;
  if                                 ( count ( $UU ) > 0                   ) {
    $CLA  = self::ObtainsLectures    ( $DB , $TABLE , $UU                  ) ;
    foreach                          ( $CLA as $L                          ) {
      if ( $PERIOD -> Between ( $L -> Register ) == 0                      ) {
        $E  = self::LectureEventItem ( $DB , $TZ , $L                      ) ;
        array_push                   ( $EVENTS   , $E -> Content ( )       ) ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
// 支付方排課資訊
//////////////////////////////////////////////////////////////////////////////
public static function LecturePayerEvents ( $DB                              ,
                                            $TABLE                           ,
                                            $TZ                              ,
                                            $PERIOD                          ,
                                            $PUID                            ,
                                            $PAYER                         ) {
  $EVENTS = array                    (                                     ) ;
  $LIC    = new Lecture              (                                     ) ;
  $LIC   -> Trainee = $PUID                                                  ;
  $LIC   -> Payer   = $PAYER                                                 ;
  $UU     = $LIC -> ObtainsByPayer   ( $DB , $TABLE                        ) ;
  if                                 ( count ( $UU ) > 0                   ) {
    $CLA  = self::ObtainsLectures    ( $DB , $TABLE , $UU                  ) ;
    foreach                          ( $CLA as $L                          ) {
      if ( $PERIOD -> Between ( $L -> Register ) == 0                      ) {
        $E  = self::LectureEventItem ( $DB , $TZ , $L                      ) ;
        array_push                   ( $EVENTS   , $E -> Content ( )       ) ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
// 交易資訊
//////////////////////////////////////////////////////////////////////////////
public static function TradeEventItem ( $DB , $TZ , $TRADE                 ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $CourseNames                                                        ;
  global $ProductItems                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $TKNTAB = "`erp`.`tokens`"                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $TQMSG  = $Translations [ "Tokens::Quantity:" ]                            ;
  $TV     = ""                                                               ;
  if                                  ( $TRADE -> isToken ( )              ) {
    $TKNS   = new Token               (                                    ) ;
    $TKNS  -> Uuid = $TRADE -> Description                                   ;
    if ( $TKNS -> ObtainsByUuid ( $DB , $TKNTAB )                          ) {
      $TV = $TKNS -> TokenValue       (                                    ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $CIDS = $TRADE -> toString          (                                    ) ;
  $AMNT = $TRADE -> Amount                                                   ;
  $CURY = $TRADE -> Currency                                                 ;
  $PINM = $ProductItems [ $TRADE -> Item  ]                                  ;
  $TAMS = $Translations [ "Trade::Amount" ]                                  ;
  $TAIT = $Translations [ "Trade::Item"   ]                                  ;
  $TAID = $Translations [ "Trade::ID"     ]                                  ;
  $TIDS = "{$TAMS}{$AMNT} {$CURY}\n{$TAIT}{$PINM}"                           ;
  ////////////////////////////////////////////////////////////////////////////
  $PRX  = new Periode                  (                                   ) ;
  $PRX -> Start = $TRADE -> Record                                           ;
  $PRX -> setInterval                  ( 1800                              ) ;
  $STX  = $PRX -> TimeFormat           ( "H:i:s" , "start" , $TZ           ) ;
  $TLS  = $PRX -> toLongString         ( $TZ , "start" , "Y/m/d" , "H:i:s" ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E    = new Events                   (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> Title                        ( $TIDS                             ) ;
  $E   -> Id                           ( $TRADE -> Uuid                    ) ;
//  $E   -> TimeFields                   ( $TZ , $PRX                        ) ;
  $E   -> TimeField                    ( $TZ , "start" , $PRX              ) ;
  $E   -> Editable                     ( false                             ) ;
  $E   -> AllDay                       ( false                             ) ;
  $E   -> Classes                      ( [ "StudentTradeItem" ]            ) ;
  $E   -> TextColor                    ( "#7733AA"                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E   -> AddDqPair                    ( "trade"   , $CIDS                 ) ;
  $E   -> AddDqPair                    ( "clock"   , $STX                  ) ;
  $E   -> AddPair                      ( "type"    , 123                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $TIXS = "{$TLS}\n{$TAMS}{$AMNT} {$CURY}\n{$TAIT}{$PINM}\n{$TAID}{$CIDS}"   ;
  if                                   ( strlen ( $TV ) > 0                ) {
    $TIXS = "{$TIXS}\n{$TQMSG}{$TV}"                                         ;
  }                                                                          ;
  $E   -> AddDqPair                    ( "tooltip" , $TIXS                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得交易資訊列表
//////////////////////////////////////////////////////////////////////////////
public static function ObtainsTrades ( $DB , $TABLE , $TRADES )              {
  $CLA    = array         (                                                ) ;
  foreach                 ( $TRADES as $UX                                 ) {
    $CXS  = new Trade     (                                                ) ;
    $CXS -> Uuid = $UX                                                       ;
    $CXS -> ObtainsByUuid ( $DB  , $TABLE                                  ) ;
    array_push            ( $CLA , $CXS                                    ) ;
  }                                                                          ;
  return $CLA                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// 顯示交易資訊區塊
//////////////////////////////////////////////////////////////////////////////
public static function TradeBlockEvents ( $DB                                ,
                                          $TABLE                             ,
                                          $TZ                                ,
                                          $PERIOD                            ,
                                          $PUID                            ) {
  $EVENTS = array                       (                                  ) ;
  $TIC    = new Trade                   (                                  ) ;
  $TIC   -> Payer = $PUID                                                    ;
  $UU     = $TIC -> ObtainsTransactions ( $DB , $TABLE , "payer"           ) ;
  if                                    ( count ( $UU ) > 0                ) {
    $CLA  = self::ObtainsTrades         ( $DB , $TABLE , $UU               ) ;
    foreach                             ( $CLA as $T                       ) {
      if ( $PERIOD -> Between ( $T -> Record ) == 0                        ) {
        $E  = self::TradeEventItem      ( $DB , $TZ , $T                   ) ;
        array_push                      ( $EVENTS   , $E -> Content ( )    ) ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得公共行事曆事件列表
//////////////////////////////////////////////////////////////////////////////
public static function GetPublicEventsByType ( $DB                           ,
                                               $TABLE                        ,
                                               $PERIOD                       ,
                                               $TYPE                       ) {
  ////////////////////////////////////////////////////////////////////////////
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $C1    = "( ( `start` >= {$START} ) and ( `end` <= {$ENDST} ) )"           ;
  $C2    = "( ( `start` >= {$START} ) and ( `start` <= {$ENDST} ) )"         ;
  $C3    = "( ( `end` >= {$START} ) and ( `end` <= {$ENDST} ) )"             ;
  $C4    = "( ( `start` <= {$START} ) and ( `end` >= {$ENDST} ) )"           ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `type` = {$TYPE} )"                                     .
           " and ( {$C1} or {$C2} or {$C3} or {$C4} )"                       .
           " order by `start` asc ;"                                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids ( $QQ )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得個人行事曆事件列表
//////////////////////////////////////////////////////////////////////////////
public static function GetPrivateVacationEvents ( $DB                        ,
                                                  $TABLE                     ,
                                                  $RELATION                  ,
                                                  $PUID                      ,
                                                  $PERIOD                  ) {
  ////////////////////////////////////////////////////////////////////////////
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $C1    = "( ( `start` >= {$START} ) and ( `end` <= {$ENDST} ) )"           ;
  $C2    = "( ( `start` >= {$START} ) and ( `start` <= {$ENDST} ) )"         ;
  $C3    = "( ( `end` >= {$START} ) and ( `end` <= {$ENDST} ) )"             ;
  $C4    = "( ( `start` <= {$START} ) and ( `end` >= {$ENDST} ) )"           ;
  ////////////////////////////////////////////////////////////////////////////
  $WH    = "select `second` from {$RELATION}"                                .
           " where ( `first` = {$PUID} )"                                    .
                " and ( `t1` = 103 )"                                        .
                " and ( `t2` = 92 )"                                         .
          " and ( `relation` = 19 )"                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `type` = 9 )"                                           .
           " and ( {$C1} or {$C2} or {$C3} or {$C4} )"                       .
           " and ( `uuid` in ( {$WH} ) )"                                    .
           " order by `start` asc ;"                                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids ( $QQ )                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得個人行事曆事件列表
//////////////////////////////////////////////////////////////////////////////
public static function ObtainsPeriods ( $DB , $TABLE , $VACATIONS          ) {
  $PERIODs = array                    (                                    ) ;
  foreach                             ( $VACATIONS as $vac                 ) {
    $PRX   = new Periode              (                                    ) ;
    $PRX  -> set                      ( "Uuid"   , $vac                    ) ;
    $PRX  -> ObtainsByUuid            ( $DB      , $TABLE                  ) ;
    array_push                        ( $PERIODs , $PRX                    ) ;
  }                                                                          ;
  return $PERIODs                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PaymentTermItem ( $DB                                 ,
                                         $PEOPLE                             ,
                                         $TZ                                 ,
                                         $E                                  ,
                                         $PAYDAY                             ,
                                         $TERM                             ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $TRMX    = new Periode               (                                   ) ;
  $SDTX    = new StarDate              (                                   ) ;
  $TRMX   -> Start = $TERM -> Start                                          ;
  $TRMX   -> End   = gmp_sub           ( $TERM -> End , 1                  ) ;
  $PRID    = $TERM -> toString         (                                   ) ;
  $Correct = true                                                            ;
  ////////////////////////////////////////////////////////////////////////////
  $MSGID   = $Translations [ "Tutors::LectureTerm:" ]                        ;
  $PIDMSG  = "{$MSGID}{$PRID}"                                               ;
  ////////////////////////////////////////////////////////////////////////////
  if                                   ( isset ( $GLOBALS [ "WeekDays" ] ) ) {
    $WeekDays = $GLOBALS [ "WeekDays" ]                                      ;
  } else $Correct = false                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TLP     = $PAYDAY -> toDateString   ( $TZ , "start" , "Y/m/d"           ) ;
  if                                   ( $Correct                          ) {
    $SDTX -> Stardate = $PAYDAY -> Start                                     ;
    $SW    = $WeekDays [ $SDTX -> Weekday ( $TZ ) ]                          ;
    $TLP   = "{$TLP} {$SW}"                                                  ;
  }                                                                          ;
  $MSGID   = $Translations [ "Tutors::PayDay:" ]                             ;
  $TLP     = "{$MSGID}{$TLP}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $TLS  = $TRMX   -> toDateString      ( $TZ , "start" , "Y/m/d"           ) ;
  if                                   ( $Correct                          ) {
    $SDTX -> Stardate = $PAYDAY -> Start                                     ;
    $SW    = $WeekDays [ $SDTX -> Weekday ( $TZ ) ]                          ;
    $TLS   = "{$TLS} {$SW}"                                                  ;
  }                                                                          ;
  $MSGID   = $Translations [ "Periode::StartDate:" ]                         ;
  $TLS     = "{$MSGID}{$TLS}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $TLE  = $TRMX   -> toDateString      ( $TZ , "end"   , "Y/m/d"           ) ;
  if ( $Correct )                                                            {
    $SDTX -> Stardate = $TRMX -> End                                         ;
    $SW    = $WeekDays [ $SDTX -> Weekday ( $TZ ) ]                          ;
    $TLE   = "{$TLE} {$SW}"                                                  ;
  }                                                                          ;
  $MSGID   = $Translations [ "Periode::EndDate:" ]                           ;
  $TLE     = "{$MSGID}{$TLE}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $TIXS    = "{$PIDMSG}\n{$TLP}\n{$TLS}\n{$TLE}"                             ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ "Payment::TermID:" ]                            ;
  $E      -> AddDqPair                 ( "period"  , $PRID                 ) ;
  $E      -> AddDqPair                 ( "message" , "{$MSG}{$PRID}"       ) ;
  $E      -> AddDqPair                 ( "tooltip" , $TIXS                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PublicEventItem ( $DB                                 ,
                                         $NAMTAB                             ,
                                         $PEOPLE                             ,
                                         $PERIOD                             ,
                                         $COLOR                              ,
                                         $CLASSES                          ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $RELT  = $GLOBALS [ "TableMapping" ] [ "Relation" ]                        ;
  $PERT  = $GLOBALS [ "TableMapping" ] [ "Periods"  ]                        ;
  $PUID  = $PERIOD -> Uuid                                                   ;
  $LANG  = $PEOPLE -> Language                                               ;
  $TZ    = $PEOPLE -> TZ                                                     ;
  $E     = new Events            (                                         ) ;
  $RI    = new Relation          (                                         ) ;
  $PRX   = new Periode           (                                         ) ;
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
      ////////////////////////////////////////////////////////////////////////
      $RDMSG = $Translations [ "RestDay"   ]                                 ;
      $TTMSG = $Translations [ "LocalTime" ]                                 ;
      $STMSG = $PERIOD -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s" ) ;
      $ETMSG = $PERIOD -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s" ) ;
      $TT    = "{$PNAM}\n\n{$RDMSG}\n\n{$TTMSG}\n{$STMSG}\n{$ETMSG}"         ;
      $E    -> AddDqPair         ( "tooltip" , $TT                         ) ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
    case 13                                                                  :
      ////////////////////////////////////////////////////////////////////////
      $TTMSG = $Translations [ "LocalTime" ]                                 ;
      $STMSG = $PERIOD -> toLongString ( $TZ , "start" , "Y/m/d" , "H:i:s" ) ;
      $ETMSG = $PERIOD -> toLongString ( $TZ , "end"   , "Y/m/d" , "H:i:s" ) ;
      $TT    = "{$PNAM}\n\n{$TTMSG}\n{$STMSG}\n{$ETMSG}"                     ;
      $E    -> AddDqPair         ( "tooltip" , $TT                         ) ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
    case 14                                                                  :
    break                                                                    ;
    case 15                                                                  :
      ////////////////////////////////////////////////////////////////////////
      $RI   -> set                  ( "first" , $PERIOD -> Uuid            ) ;
      $RI   -> setT1                ( "Period"                             ) ;
      $RI   -> setT2                ( "Period"                             ) ;
      $RI   -> setRelation          ( "Equivalent"                         ) ;
      $UX    = $RI -> Subordination ( $DB     , $RELT                      ) ;
      if                            ( count ( $UX ) > 0                    ) {
        $PRX -> Uuid = $UX [ 0 ]                                             ;
        $PRX -> ObtainsByUuid       ( $DB     , $PERT                      ) ;
        $E  = self::PaymentTermItem ( $DB                                    ,
                                      $PEOPLE                                ,
                                      $TZ                                    ,
                                      $E                                     ,
                                      $PERIOD                                ,
                                      $PRX                                 ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
    case 16                                                                  :
    break                                                                    ;
    case 17                                                                  :
      ////////////////////////////////////////////////////////////////////////
      $RI   -> set                  ( "second" , $PERIOD -> Uuid           ) ;
      $RI   -> setT1                ( "Period"                             ) ;
      $RI   -> setT2                ( "Period"                             ) ;
      $RI   -> setRelation          ( "Equivalent"                         ) ;
      $UX    = $RI -> GetOwners     ( $DB     , $RELT                      ) ;
      if                            ( count ( $UX ) > 0                    ) {
        $PRX -> Uuid = $UX [ 0 ]                                             ;
        $PRX -> ObtainsByUuid       ( $DB     , $PERT                      ) ;
        $E  = self::PaymentTermItem ( $DB                                    ,
                                      $PEOPLE                                ,
                                      $TZ                                    ,
                                      $E                                     ,
                                      $PRX                                   ,
                                      $PERIOD                              ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $E -> Content           (                                         ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function UndecidedEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD  ) {
  return self::PublicEventItem        ( $DB                                  ,
                                        $NAMTAB                              ,
                                        $PEOPLE                              ,
                                        $PERIOD                              ,
                                        "#7280FA"                            ,
                                        [ "Undecided" ]                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PlanningEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD   ) {
  return self::PublicEventItem       ( $DB                                   ,
                                       $NAMTAB                               ,
                                       $PEOPLE                               ,
                                       $PERIOD                               ,
                                       "#72FA80"                             ,
                                       [ "Planning" ]                      ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SuspendedEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD  ) {
  return self::PublicEventItem        ( $DB                                  ,
                                        $NAMTAB                              ,
                                        $PEOPLE                              ,
                                        $PERIOD                              ,
                                        "#C0FA72"                            ,
                                        [ "Suspended" ]                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function VacationEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD   ) {
  return self::PublicEventItem       ( $DB                                   ,
                                       $NAMTAB                               ,
                                       $PEOPLE                               ,
                                       $PERIOD                               ,
                                       "#FA8072"                             ,
                                       [ "Vacations" ]                     ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PrivateVacationEvent ( $DB                            ,
                                              $NAMTAB                        ,
                                              $PEOPLE                        ,
                                              $PERIOD                      ) {
  return self::PublicEventItem ( $DB                                         ,
                                 $NAMTAB                                     ,
                                 $PEOPLE                                     ,
                                 $PERIOD                                     ,
                                 "#7280FA"                                   ,
                                 [ "PrivateVacations" ]                    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function ExceptionalVacationEvent ( $DB                        ,
                                                  $NAMTAB                    ,
                                                  $PEOPLE                    ,
                                                  $PERIOD                  ) {
  return self::PublicEventItem ( $DB                                         ,
                                 $NAMTAB                                     ,
                                 $PEOPLE                                     ,
                                 $PERIOD                                     ,
                                 "#8072FA"                                   ,
                                 [ "ExceptionalVacations" ]                ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PayDayEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD     ) {
  return self::PublicEventItem     ( $DB                                     ,
                                     $NAMTAB                                 ,
                                     $PEOPLE                                 ,
                                     $PERIOD                                 ,
                                     "#409936"                               ,
                                     [ "PayDays" ]                         ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function LectureTermEvent ( $DB                                ,
                                          $NAMTAB                            ,
                                          $PEOPLE                            ,
                                          $PERIOD                          ) {
  return self::PublicEventItem          ( $DB                                ,
                                          $NAMTAB                            ,
                                          $PEOPLE                            ,
                                          $PERIOD                            ,
                                          "#FADC72"                          ,
                                          [ "LectureTerms" ]               ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SpecialDayEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD ) {
  return self::PublicEventItem         ( $DB                                 ,
                                         $NAMTAB                             ,
                                         $PEOPLE                             ,
                                         $PERIOD                             ,
                                         "#FFEFD5"                           ,
                                         [ "SpecialDays" ]                 ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SolarTermEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD  ) {
  return self::PublicEventItem ( $DB                                         ,
                                 $NAMTAB                                     ,
                                 $PEOPLE                                     ,
                                 $PERIOD                                     ,
                                 "#225533"                                   ,
                                 [ "SolarTerm" ]                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PublicEventsByType ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PERIOD                          ,
                                            $TYPE                            ,
                                            $PRDTAB                          ,
                                            $NAMTAB                          ,
                                            $FUNC                          ) {
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
//////////////////////////////////////////////////////////////////////////////
public static function PrivateVacationEvents ( $DB                           ,
                                               $PEOPLE                       ,
                                               $PUID                         ,
                                               $PERIOD                       ,
                                               $PRDTAB                       ,
                                               $RELATION                     ,
                                               $NAMTAB                       ,
                                               $FUNC                       ) {
  $EVENTS = array                          (                               ) ;
  $UU     = self::GetPrivateVacationEvents ( $DB                             ,
                                             $PRDTAB                         ,
                                             $RELATION                       ,
                                             $PUID                           ,
                                             $PERIOD                       ) ;
  if                                       ( count ( $UU ) > 0             ) {
    $PRDs = self::ObtainsPeriods           ( $DB , $PRDTAB , $UU           ) ;
    foreach                                ( $PRDs as $P                   ) {
      $E  = $FUNC                          ( $DB , $NAMTAB , $PEOPLE , $P  ) ;
      array_push                           ( $EVENTS , $E                  ) ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public static function ShowPrivateVacationEvents ( $DB                       ,
                                                   $PEOPLE                   ,
                                                   $PUID                     ,
                                                   $PERIOD                   ,
                                                   $EVENTS                   ,
                                                   $ShowPrivateVacation    ) {
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $ShowPrivateVacation ) return $EVENTS                               ;
  ////////////////////////////////////////////////////////////////////////////
  $PRDTAB   = $GLOBALS [ "TableMapping" ] [ "Periods"  ]                     ;
  $RELATION = $GLOBALS [ "TableMapping" ] [ "Relation" ]                     ;
  $NAMTAB   = $GLOBALS [ "TableMapping" ] [ "Names"    ]                     ;
  ////////////////////////////////////////////////////////////////////////////
  $FUNC     = "CIOS\Events::PrivateVacationEvent"                            ;
  $E        = self::PrivateVacationEvents ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PUID                            ,
                                            $PERIOD                          ,
                                            $PRDTAB                          ,
                                            $RELATION                        ,
                                            $NAMTAB                          ,
                                            $FUNC                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  return Parameters::MergeArray           ( $EVENTS , $E                   ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function ShowPublicVacationEvents ( $DB                        ,
                                                  $PEOPLE                    ,
                                                  $PERIOD                    ,
                                                  $EVENTS                    ,
                                                  $ShowPublicEvents        ) {
  ////////////////////////////////////////////////////////////////////////////
  global $ShowSpecialDays                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $ShowPublicEvents ) return $EVENTS                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $PRDTAB = $GLOBALS [ "TableMapping" ] [ "Periods" ]                        ;
  $NAMTAB = $GLOBALS [ "TableMapping" ] [ "Names"   ]                        ;
  ////////////////////////////////////////////////////////////////////////////
  $EVF    = "CIOS\Events::ExceptionalVacationEvent"                          ;
  $E      = Events::PublicEventsByType  ( $DB                                ,
                                          $PEOPLE                            ,
                                          $PERIOD                            ,
                                          10                                 ,
                                          $PRDTAB                            ,
                                          $NAMTAB                            ,
                                          $EVF                             ) ;
  $EVENTS = Parameters::MergeArray      ( $EVENTS , $E                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $EVF    = "CIOS\Events::VacationEvent"                                     ;
  $E      = Events::PublicEventsByType  ( $DB                                ,
                                          $PEOPLE                            ,
                                          $PERIOD                            ,
                                          12                                 ,
                                          $PRDTAB                            ,
                                          $NAMTAB                            ,
                                          $EVF                             ) ;
  $EVENTS = Parameters::MergeArray      ( $EVENTS , $E                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                                    ( $ShowSpecialDays                 ) {
    $EVF  = "CIOS\Events::SpecialDayEvent"                                   ;
    $E    = Events::PublicEventsByType  ( $DB                                ,
                                          $PEOPLE                            ,
                                          $PERIOD                            ,
                                          13                                 ,
                                          $PRDTAB                            ,
                                          $NAMTAB                            ,
                                          $EVF                             ) ;
    $EVENTS = Parameters::MergeArray    ( $EVENTS , $E                     ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $EVENTS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public static function ShowSolarTermsEvents ( $DB                            ,
                                              $PEOPLE                        ,
                                              $PERIOD                        ,
                                              $EVENTS                        ,
                                              $ShowSolarTerms              ) {
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $ShowSolarTerms ) return $EVENTS                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $PRDTAB = $GLOBALS [ "TableMapping" ] [ "Periods" ]                        ;
  $NAMTAB = $GLOBALS [ "TableMapping" ] [ "Names"   ]                        ;
  ////////////////////////////////////////////////////////////////////////////
  $E      = self::PublicEventsByType  ( $DB                                  ,
                                        $PEOPLE                              ,
                                        $PERIOD                              ,
                                        14                                   ,
                                        $PRDTAB                              ,
                                        $NAMTAB                              ,
                                        "CIOS\Events::SolarTermEvent"      ) ;
  ////////////////////////////////////////////////////////////////////////////
  return Parameters::MergeArray       ( $EVENTS , $E                       ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function ShowPaymentsEvents ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PERIOD                          ,
                                            $EVENTS                          ,
                                            $PAYMENT                         ,
                                            $ShowPayments                  ) {
  ////////////////////////////////////////////////////////////////////////////
  global $ShowLectureTerms                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $ShowPayments ) return $EVENTS                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $PRDTAB = $GLOBALS [ "TableMapping" ] [ "Periods" ]                        ;
  $NAMTAB = $GLOBALS [ "TableMapping" ] [ "Names"   ]                        ;
  ////////////////////////////////////////////////////////////////////////////
  switch                                  ( $PAYMENT                       ) {
    case 2                                                                   :
      $K  = "CIOS\Events::PayDayEvent"                                       ;
      $E  = Events::PublicEventsByType    ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PERIOD                          ,
                                            16                               ,
                                            $PRDTAB                          ,
                                            $NAMTAB                          ,
                                            $K                             ) ;
      $EVENTS = Parameters::MergeArray    ( $EVENTS , $E                   ) ;
    break                                                                    ;
    default                                                                  :
      $K  = "CIOS\Events::PayDayEvent"                                       ;
      $E  = Events::PublicEventsByType    ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PERIOD                          ,
                                            15                               ,
                                            $PRDTAB                          ,
                                            $NAMTAB                          ,
                                            $K                             ) ;
      $EVENTS = Parameters::MergeArray    ( $EVENTS , $E                   ) ;
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $ShowLectureTerms ) return $EVENTS                                  ;
  ////////////////////////////////////////////////////////////////////////////
  switch                                  ( $PAYMENT                       ) {
    case 2                                                                   :
      $K  = "CIOS\Events::LectureTermEvent"                                  ;
      $E  = Events::PublicEventsByType    ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PERIOD                          ,
                                            17                               ,
                                            $PRDTAB                          ,
                                            $NAMTAB                          ,
                                            $K                             ) ;
      $EVENTS = Parameters::MergeArray    ( $EVENTS , $E                   ) ;
    break                                                                    ;
    default                                                                  :
      $K  = "CIOS\Events::LectureTermEvent"                                  ;
      $E  = Events::PublicEventsByType    ( $DB                              ,
                                            $PEOPLE                          ,
                                            $PERIOD                          ,
                                            17                               ,
                                            $PRDTAB                          ,
                                            $NAMTAB                          ,
                                            $K                             ) ;
      $EVENTS = Parameters::MergeArray    ( $EVENTS , $E                   ) ;
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $EVENTS                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
