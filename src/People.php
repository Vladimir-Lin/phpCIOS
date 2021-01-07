<?php
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class People                                                                 {
//////////////////////////////////////////////////////////////////////////////
public $Uuid      = 0                                                        ;
public $Role      = 0                                                        ;
public $TzId      = "2700000000000000270"                                    ;
public $TZ        = "Asia/Taipei"                                            ;
public $Language  = 1002                                                     ;
public $Level     = 0                                                        ;
public $Seniority = 0                                                        ;
public $Item      = 1                                                        ;
public $Courses   = [ 1 ]                                                    ;
public $Owners                                                               ;
public $Name                                                                 ;
public $Roles     = [ ]                                                      ;
public $Attributes                                                           ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( $OBJ = 0                                            ) {
  ////////////////////////////////////////////////////////////////////////////
  if                 ( is_a       ( $OBJ , "CIOS\People" )                 ) {
    $this -> assign  ( $OBJ                                                ) ;
  } else
  if                 ( is_numeric ( $OBJ                 )                 ) {
    $this -> Uuid = $OBJ                                                     ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function assign ( $item )                                             {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Uuid        = $item -> Uuid                                       ;
  $this -> Role        = $item -> Role                                       ;
  $this -> TzId        = $item -> TzId                                       ;
  $this -> TZ          = $item -> TZ                                         ;
  $this -> Language    = $item -> Language                                   ;
  $this -> Level       = $item -> Level                                      ;
  $this -> Seniority   = $item -> Seniority                                  ;
  $this -> Item        = $item -> Item                                       ;
  $this -> Courses     = $item -> Courses                                    ;
  $this -> Owners      = $item -> Owners                                     ;
  $this -> Name        = $item -> Name                                       ;
  $this -> Roles       = $item -> Roles                                      ;
  $this -> $Attributes = array ( )                                           ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function toString (                                                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $U = $this -> Uuid                                                         ;
  $H = substr            ( $U , 0 , 11                                     ) ;
  if                     ( $H != "14000000000"                             ) {
    return ""                                                                ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return sprintf         ( "act1%08d" , gmp_mod ( $U , 100000000 )         ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function fromString ( $S                                            ) {
  ////////////////////////////////////////////////////////////////////////////
  if                       ( 12 != strlen ( $S )                           ) {
    $this -> Uuid = 0                                                        ;
    return 0                                                                 ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $X       = strtolower    ( $S                                            ) ;
  $C       = substr        ( $X , 0 , 4                                    ) ;
  if                       ( $C != "act1"                                  ) {
    $this -> Uuid = 0                                                        ;
    return 0                                                                 ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $C       = substr        ( $S , 0 , 4                                    ) ;
  $U       = str_replace   ( $C , "14000000000" , $S                       ) ;
  $this   -> Uuid = $U                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  return $U                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetObjects    ( $DB , $TABLE , $T2 , $RELATION             ) {
  ////////////////////////////////////////////////////////////////////////////
  $RI  = new Relation         (                                            ) ;
  $RI -> set                  ( "first" , $this -> Uuid                    ) ;
  $RI -> setT1                ( "People"                                   ) ;
  $RI -> setT2                ( $T2                                        ) ;
  $RI -> setRelation          ( $RELATION                                  ) ;
  $XX  = $RI -> Subordination ( $DB , $TABLE                               ) ;
  unset                       ( $RI                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $XX                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetEMails    ( $DB , $TABLE = "`erp`.`relations`"          ) {
  return $this -> GetObjects ( $DB , $TABLE , "EMail" , "Subordination"    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetIMs       ( $DB , $TABLE = "`erp`.`relations`"          ) {
  return $this -> GetObjects ( $DB                                           ,
                               $TABLE                                        ,
                               "InstantMessage"                              ,
                               "Subordination"                             ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetPhones    ( $DB , $TABLE = "`erp`.`relations`"          ) {
  return $this -> GetObjects ( $DB , $TABLE , "Phone" , "Subordination"    ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetLanguage     ( $DB , $TABLE = "`erp`.`relations`"       ) {
  $RA   = $this -> GetObjects   ( $DB , $TABLE , "Language" , "Using"      ) ;
  if                            ( count ( $RA ) > 0                        ) {
    $LL = $RA                   [ 0                                        ] ;
    $this -> Language = $LL % 100000                                         ;
  }                                                                          ;
  unset                         ( $RA                                      ) ;
  if ( $this -> Language <= 1000 ) $this -> Language = 1001                  ;
  if ( $this -> Language >= 2000 ) $this -> Language = 1001                  ;
  return $this -> Language                                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetRoles ( $DB , $TABLE = "`erp`.`relations`"              ) {
  $this -> Roles = $this -> GetObjects ( $DB , $TABLE , "Role" , "Acting"  ) ;
  return $this -> Roles                                                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetTimeZone ( $DB , $TABLE = "`erp`.`relations`"           ) {
  $this -> TzId   = "2700000000000000270"                                    ;
  if ( $this -> ContainsRole ( 2 ) )                                         {
    $this -> TzId = "2700000000000000249"                                    ;
  }                                                                          ;
  $RA = $this -> GetObjects ( $DB , $TABLE , "TimeZone" , "Originate" )      ;
  if ( count ( $RA ) > 0 ) $this -> TzId = $RA [ 0 ]                         ;
  return $this -> TzId                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetZoneName         ( $DB , $TABLE                         ) {
  $TZS        = new TimeZones       (                                      ) ;
  $this -> TZ = $TZS -> GetZoneName ( $DB , $TABLE , $this -> TzId         ) ;
  return $this -> TZ                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetSeniority ( $DB )                                         {
  $this -> Seniority = ParameterQuery::GetParameterStatus                    (
                         $DB                                                 ,
                         $this -> Uuid                                       ,
                         "Level"                                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetLevel ( $DB )                                             {
  $this -> Level = ParameterQuery::GetParameterPersonal                      (
                     $DB                                                     ,
                     $this -> Uuid                                           ,
                     "Level"                                               ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetCourse ( $DB )                                            {
  $this -> Item = ParameterQuery::GetParameterStatus                         (
                    $DB                                                      ,
                    $this -> Uuid                                            ,
                    "Course"                                               ) ;
  if ( ( strlen ( $this -> Item ) <= 0 ) or ( $this -> Item <= 0 ) )         {
    $this -> Item = 1                                                        ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetCourses ( $DB )                                           {
  $ITEMs           = ParameterQuery::GetParameterData                        (
                       $DB                                                   ,
                       $this -> Uuid                                         ,
                       "Courses"                                             ,
                       2                                                     ,
                       37                                                    ,
                       "Teaching"                                          ) ;
  $this -> Courses = explode ( " , " , $ITEMs )                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function isCounselor ( )                                              {
  if ( ! $this -> ContainsRole ( 7 ) ) return false             ;
  if ( ( $this -> Level >= 300 ) and ( $this -> Level < 400 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function isTeamLeader ( )
{
  if ( ! $this -> ContainsRole ( 7 ) ) return false             ;
  if ( ( $this -> Level >= 400 ) and ( $this -> Level < 500 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function isManager ( )
{
  if ( ( $this -> Level >= 500 ) and ( $this -> Level < 800 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function isSubsidiary ( )
{
  if ( ( $this -> Level >= 800 ) and ( $this -> Level < 900 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function TutorParameters ( $DB )
{
  $this -> GetSeniority ( $DB ) ;
  $this -> GetCourses   ( $DB ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function StudentParameters ( $DB )
{
  $this -> GetCourse ( $DB ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ManagerParameters ( $DB )
{
  $this -> GetSeniority ( $DB )    ;
  $this -> GetLevel     ( $DB )    ;
  if ( $this -> isCounselor  ( ) ) {
    $this -> GetCourses   ( $DB )  ;
  } else
  if ( $this -> isTeamLeader ( ) ) {
    $this -> GetCourses   ( $DB )  ;
  } else
  if ( $this -> isSubsidiary ( ) ) {
  } else
  if ( $this -> isManager    ( ) ) {
  }
}
//////////////////////////////////////////////////////////////////////////////
public function EmployeeParameters ( $DB )
{
}
//////////////////////////////////////////////////////////////////////////////
public function RoleId ( )
{
  return $this -> ShortRole ( $this -> Role ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function ShortRole ( $X )
{
  $R = (string) $X                                              ;
  $R = (string) str_replace ( "1700000000" , "" , (string) $R ) ;
  return intval ( (string) $R , 10 )                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function ContainsRole ( $X )
{
  foreach ( $this -> Roles as $R )  {
    $V = $this -> ShortRole ( $R )  ;
    if ( $V == $X ) return true     ;
  }                                 ;
  return false                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function AddRole ( $R )
{
  array_push ( $this -> Roles , $R ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function toRoleString ( )
{
  if ( count ( $this -> Roles ) <= 0 ) return ""     ;
  $RL = array               (                      ) ;
  foreach                   ( $this -> Roles as $R ) {
    $S = $this -> ShortRole (                   $R ) ;
    array_push              ( $RL   , $S           ) ;
  }                                                  ;
  return implode            ( " , " , $RL          ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function DecideRole ( )
{
  ////////////////////////////////////////////////////////////////////////////
  $RolePriority = array                                                      (
    13                                                                       , // 董事長
    16                                                                       , // 設計者
    12                                                                       , // 人力資源
    11                                                                       , // 財務長
     9                                                                       , // 部門主管
     8                                                                       , // 協理
    10                                                                       , // 會計
     7                                                                       , // 經理
     6                                                                       , // 教練
    14                                                                       , // 股東
    15                                                                       , // 資管
    17                                                                       , // 勤務
     2                                                                       , // 教員
     4                                                                       , // 夥伴
     5                                                                       , // 監護者
     3                                                                       , // 學員
     1                                                                       , // 訪客
  )                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Role = 0                                                          ;
  foreach ( $RolePriority as $RP          )                                  {
    if    ( $this -> ContainsRole ( $RP ) )                                  {
      $this -> Role = $RP                                                    ;
      return $this -> Role                                                   ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Role                                                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetParameters ( $DB )
{
  ////////////////////////////////////////////////////////////////////////////
  $RolePriority = array                                                      (
     1                                                                       , // 訪客
     3                                                                       , // 學員
     5                                                                       , // 監護者
     4                                                                       , // 夥伴
     2                                                                       , // 教員
    17                                                                       , // 勤務
    15                                                                       , // 資管
    14                                                                       , // 股東
     6                                                                       , // 教練
     7                                                                       , // 經理
    10                                                                       , // 會計
     8                                                                       , // 協理
     9                                                                       , // 部門主管
    11                                                                       , // 財務長
    12                                                                       , // 人力資源
    16                                                                       , // 設計者
    13                                                                       , // 董事長
  )                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  foreach ( $RolePriority as $RP          )                                  {
    if    ( $this -> ContainsRole ( $RP ) )                                  {
      switch ( $RP )                                                         {
        case  2                                                              :
        case  6                                                              :
          $this -> TutorParameters    ( $DB )                                ;
        break                                                                ;
        case  3                                                              :
        case  4                                                              :
        case  5                                                              :
          $this -> StudentParameters  ( $DB )                                ;
        break                                                                ;
        case  7                                                              :
        case  8                                                              :
        case  9                                                              :
          $this -> ManagerParameters  ( $DB )                                ;
        break                                                                ;
        case  1                                                              :
        case 10                                                              :
        case 11                                                              :
        case 12                                                              :
        case 13                                                              :
        case 14                                                              :
        case 15                                                              :
        case 16                                                              :
        case 17                                                              :
          $this -> EmployeeParameters ( $DB )                                ;
        break                                                                ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function SessionStart ( )                                             {
  $COURSESTR                        = implode ( " , " , $this -> Courses ) ;
  $ROLESTR                          = implode ( " , " , $this -> Roles   ) ;
  //////////////////////////////////////////////////////////////////////////
  $_SESSION [ "Authorized"        ] = true                                 ;
  $_SESSION [ "ACTIONS_UUID"      ] = (string) $this -> Uuid               ;
  $_SESSION [ "ACTIONS_ROLE"      ] = (string) $this -> Role               ;
  $_SESSION [ "ACTIONS_ROLES"     ] = (string) $ROLESTR                    ;
  $_SESSION [ "ACTIONS_NAME"      ] = (string) $this -> Name               ;
  $_SESSION [ "ACTIONS_LEVEL"     ] = (string) $this -> Level              ;
  $_SESSION [ "ACTIONS_SENIORITY" ] = (string) $this -> Seniority          ;
  $_SESSION [ "ACTIONS_ITEM"      ] = (string) $this -> Item               ;
  $_SESSION [ "ACTIONS_COURSE"    ] = (string) $this -> Item               ;
  $_SESSION [ "ACTIONS_COURSES"   ] = (string) $COURSESTR                  ;
  //////////////////////////////////////////////////////////////////////////
  Browser::SetLanguage ( $this -> Language )                               ;
  TimeZones::SetTZ     ( $this -> TZ       )                               ;
  TimeZones::SetTzUuid ( $this -> TzId     )                               ;
  //////////////////////////////////////////////////////////////////////////
  $ROID                             = 1                                    ;
  while ( $ROID <= 17                                                    ) {
    if  ( $this -> ContainsRole ( $ROID )                                ) {
      switch ( $ROID )                                                     {
        case  7                                                            :
        case  8                                                            :
        case  9                                                            :
//          if ( $this -> isManager ( ) )                                    {
//            $_SESSION [ "ACTIONS_MANAGER" ] = $this -> toString ( )        ;
//          }                                                                ;
        break                                                              ;
        case 13                                                            :
        case 16                                                            :
//          $_SESSION   [ "ACTIONS_MANAGER" ] = $this -> toString ( )        ;
        break                                                              ;
      }                                                                    ;
    }                                                                      ;
    $ROID                           = $ROID + 1                            ;
  }                                                                        ;
  //////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function Recovery()
{
  if ( ! isset ( $_SESSION [ "Authorized" ] ) ) return            ;
  $A = $_SESSION [ "Authorized" ]                                 ;
  if ( ! $A ) return                                              ;
  /////////////////////////////////////////////////////////////////
  $this -> Uuid      = (string) $_SESSION [ "ACTIONS_UUID"      ] ;
  $this -> Role      = (string) $_SESSION [ "ACTIONS_ROLE"      ] ;
  $this -> Name      = (string) $_SESSION [ "ACTIONS_NAME"      ] ;
  $this -> Level     = (string) $_SESSION [ "ACTIONS_LEVEL"     ] ;
  $this -> Seniority = (string) $_SESSION [ "ACTIONS_SENIORITY" ] ;
  $this -> Item      = (string) $_SESSION [ "ACTIONS_ITEM"      ] ;
  /////////////////////////////////////////////////////////////////
  $this -> Language  = Browser::GetLanguage (  )                  ;
  $this -> TzId      = TimeZones::GetTzUuid (  )                  ;
  $this -> TZ        = TimeZones::GetTZ     (  )                  ;
  /////////////////////////////////////////////////////////////////
  $RRS               = (string) $_SESSION [ "ACTIONS_ROLES"     ] ;
  $this -> Roles     = explode ( " , " , $RRS )                   ;
  /////////////////////////////////////////////////////////////////
  $CCS               = (string) $_SESSION [ "ACTIONS_COURSES"   ] ;
  $this -> Courses   = explode ( " , " , $CCS )                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function HomeDir ( $ROLE )
{
  switch ( $ROLE )                                                           {
    case  1                                                                  : // 訪客
    return "visitors"                                                        ;
    case  2                                                                  : // 教員
    return "tutors"                                                          ;
    case  3                                                                  : // 學員
    return "students"                                                        ;
    case  4                                                                  : // 夥伴
    return "partners"                                                        ;
    case  5                                                                  : // 監護者
    return "partners"                                                        ;
    case  6                                                                  : // 教練
    return "coach"                                                           ;
    case  7                                                                  : // 經理
      if ( $this -> isCounselor  ( ) )                                       {
        return "counselors"                                                  ;
      } else
      if ( $this -> isTeamLeader ( ) )                                       {
        return "team"                                                        ;
      } else
      if ( $this -> isSubsidiary ( ) )                                       {
        return "subsidiaries"                                                ;
      }                                                                      ;
    return "managers"                                                        ;
    case  8                                                                  : // 協理
    return "associates"                                                      ;
    case  9                                                                  : // 部門主管
    return "departments"                                                     ;
    case 10                                                                  : // 會計
    return "pecuniary"                                                       ;
    case 11                                                                  : // 財務長
    return "cfo"                                                             ;
    case 12                                                                  : // 人力資源
    return "hr"                                                              ;
    case 13                                                                  : // 董事長
    return "chairperson"                                                     ;
    case 14                                                                  : // 股東
    return "shareholders"                                                    ;
    case 15                                                                  : // 資管
    return "mis"                                                             ;
    case 16                                                                  : // 設計者
    return "designer"                                                        ;
    case 17                                                                  : // 勤務
    return "employees"                                                       ;
  }                                                                          ;
  return "visitors"                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function Home (  )
{
  return $this -> HomeDir ( $this -> RoleId ( ) ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Obtains ( $DB )
{
  $this -> ObtainTimeZone             ( $DB )    ;
  $this -> GetLanguage                (     )    ;
  $this -> Roles = $this -> ListRoles (     )    ;
  $this -> DecideRole                 (     )    ;
  if ( $this -> RoleId ( ) == 7 )                {
    //////////////////////////////////////////////
    $PQX   = new ParameterQuery ( )              ;
    $PQX  -> setTable   ( "`erp`.`parameters`" ) ;
    $PQX  -> setType    ( 0                    ) ;
    $PQX  -> setVariety ( 48                   ) ;
    $PQX  -> setScope   ( "Personal"           ) ;
    $this -> Level = $PQX -> Value               (
                        $this -> DB              ,
                        $this -> Uuid            ,
                        "Level"                ) ;
    //////////////////////////////////////////////
    $PQX   = new ParameterQuery ( )              ;
    $PQX  -> setTable   ( "`erp`.`parameters`" ) ;
    $PQX  -> setType    ( 0                    ) ;
    $PQX  -> setVariety ( 23                   ) ;
    $PQX  -> setScope   ( "Status"             ) ;
    $this -> Seniority = $PQX -> Value           (
                           $this -> DB           ,
                           $this -> Uuid         ,
                           "Level"             ) ;
    //////////////////////////////////////////////
  }                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainTimeZone ( $DB )
{
  $PUID          = $this -> Uuid                                             ;
  $TZID          = $this -> ListTimeZone ( )                                 ;
  $this -> TzId  = $TZID                                                     ;
  $QX            = "select `zonename` from `erp`.`timezones`"                .
                   " where `uuid` = ${$TZID} ;"                              ;
  $qq            = $DB -> Query ( $QX )                                      ;
  if ( $this -> DB -> hasResult ( $qq ) )                                    {
    $NN         = $qq -> fetch_array ( MYSQLI_BOTH )                         ;
    $this -> TZ = $NN [ 0 ]                                                  ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function ListTimeZone ( $Table = "`erp`.`relations`" )
{
  $RA  = array                (                         ) ;
  $RI  = new RelationItem     (                         ) ;
  /////////////////////////////////////////////////////////
  $RI -> set                  ( "first" , $this -> Uuid ) ;
  $RI -> setT1                ( "People"                ) ;
  $RI -> setT2                ( "TimeZone"              ) ;
  $RI -> setRelation          ( "Originate"             ) ;
  $RA  = $RI -> Subordination ( $this -> DB , $Table    ) ;
  /////////////////////////////////////////////////////////
  unset                       ( $RI                     ) ;
  /////////////////////////////////////////////////////////
  if ( count($RA) > 0 ) return $RA [ 0 ]                  ;
  /////////////////////////////////////////////////////////
  return "2700000000000000270"                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function MakeSure ( $DB , $TABLE , $CANDIDATES , $TMP )
{
  foreach ( $TMP as $nsx )                       {
    $QQ = "select `used` from {$TABLE}"          .
          " where `uuid` = {$nsx} ;"             ;
    $qq = $DB -> Query ( $QQ )                   ;
    if ( $DB -> hasResult ( $qq ) )              {
      $rr = $qq -> fetch_array ( MYSQLI_BOTH )   ;
      if ( $rr [ 0 ] > 0 )                       {
        if ( ! in_array ( $nsx , $CANDIDATES ) ) {
          array_push ( $CANDIDATES , $nsx )      ;
        }                                        ;
      }                                          ;
    }                                            ;
  }                                              ;
  return $CANDIDATES                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainByRole ( $DB , $TABLE , $CANDIDATE , $ACTING )
{
  //////////////////////////////////////////////////////////////
  $UU    = array                (                            ) ;
  $RI    = new Relation         (                            ) ;
  //////////////////////////////////////////////////////////////
  $RI   -> setT1                ( "People"                   ) ;
  $RI   -> setT2                ( "Role"                     ) ;
  $RI   -> setRelation          ( "Acting"                   ) ;
  //////////////////////////////////////////////////////////////
  foreach                       ( $CANDIDATE as $imx         ) {
    $RI -> set                  ( "first" , $imx             ) ;
    $CC  = $RI -> Subordination ( $DB     , $TABLE           ) ;
    if                          ( in_array ( $ACTING , $CC ) ) {
      if                        ( ! in_array ( $imx , $UU )  ) {
        array_push              ( $UU , $imx                 ) ;
      }                                                        ;
    }                                                          ;
  }                                                            ;
  //////////////////////////////////////////////////////////////
  return $UU                                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function JoinMeByRelation ( $DB , $PUID , $TUID , $ACTION           ) {
  ////////////////////////////////////////////////////////////////////////////
  $PRLTAB = $GLOBALS [ "TableMapping" ] [ "PeopleRelation" ]                 ;
  ////////////////////////////////////////////////////////////////////////////
  $RI     = new Relation         (                                         ) ;
  $RI    -> set                  ( "first"  , $PUID                        ) ;
  $RI    -> set                  ( "second" , $TUID                        ) ;
  $RI    -> setT1                ( "People"                                ) ;
  $RI    -> setT2                ( "People"                                ) ;
  $RI    -> setRelation          ( $ACTION                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DB    -> LockWrite            ( $PRLTAB                                 ) ;
  $RI    -> Join                 ( $DB , $PRLTAB                           ) ;
  $DB    -> UnlockTables         (                                         ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function JoinMeAs    ( $DB , $TUID , $ACTION                        ) {
  $this -> JoinMeByRelation ( $DB , $this -> Uuid , $TUID , $ACTION        ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetTeamMembers ( $DB , $PUID , $RELATION = "Subordination" ) {
  ////////////////////////////////////////////////////////////////////////////
  $RELTAB     = $GLOBALS [ "TableMapping" ] [ "PeopleRelation" ]             ;
  ////////////////////////////////////////////////////////////////////////////
  $RI         = new Relation   (                                           ) ;
  $RI        -> set            ( "first" , $PUID                           ) ;
  $RI        -> setT1          ( "People"                                  ) ;
  $RI        -> setT2          ( "People"                                  ) ;
  $RI        -> setRelation    ( $RELATION                                 ) ;
  return $RI -> Subordination  ( $DB , $RELTAB                             ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function SkipClasses($DB,$TABLE)
{
  //////////////////////////////////////////////////////
  $CLASSES = array ( )                                 ;
  //////////////////////////////////////////////////////
  $QQ      = "select `reason` from {$TABLE}"           .
             " where `owner` = {$this->Uuid}"          .
//                " and `item` = {$ITEMX} ;"             .
              " and `action` = 5 ;"                    ;
  $qq      = $DB -> Query ( $QQ )                      ;
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $CLASSES , $rr [ 0 ] )              ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $CLASSES                                      ;
}
//////////////////////////////////////////////////////////////////////////////
public function SkipQuotas($DB,$ITEMX)
{
  $HH    = new Parameters ( )                                                ;
  $NOW   = new StarDate   ( )                                                ;
  $SUMS  = array          ( )                                                ;
  $PUID  = $this -> Uuid                                                     ;
  $PTS   = 0                                                                 ;
  $UTS   = 0                                                                 ;
  $RTS   = 0                                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增
  ////////////////////////////////////////////////////////////////////////////
  $QQ     = "select `amount` from `erp`.`skipquotas`"                        .
            " where ( `owner` = {$PUID} )"                                   .
               " and ( `item` = {$ITEMX} )"                                  .
             " and ( `states` = 7 )"                                         .
             " and ( `action` = 3 ) ;"                                       ;
  $qq  = $DB -> Query ( $QQ )                                                ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                       {
      $PTS = $PTS + $rr [ 0 ]                                                ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // 消費
  ////////////////////////////////////////////////////////////////////////////
  $QQ     = "select `amount` from `erp`.`skipquotas`"                        .
            " where ( `owner` = {$PUID} )"                                   .
               " and ( `item` = {$ITEMX} )"                                  .
             " and ( `states` = 7 )"                                         .
             " and ( `action` = 5 ) ;"                                       ;
  $qq  = $DB -> Query ( $QQ )                                                ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                       {
      $UTS = $UTS + $rr [ 0 ]                                                ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $RTS                = $PTS - $UTS                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $SUMS [ "Total"   ] = $PTS                                                 ;
  $SUMS [ "Consume" ] = $UTS                                                 ;
  $SUMS [ "Remain"  ] = $RTS                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  return $SUMS                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function SearchByKey ( $DB , $CANDIDATEs , $KEY )
{
  $RI  = new Relation     ( )                                                ;
  $NI  = new Name         ( )                                                ;
  $MB  = new MailBox      ( )                                                ;
  $IM  = new ImApp        ( )                                                ;
  $PN  = new Phone        ( )                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $NXs = array            ( )                                                ;
  $ELs = array            ( )                                                ;
  $IMs = array            ( )                                                ;
  $PNs = array            ( )                                                ;
  $TMP = array            ( )                                                ;
  ////////////////////////////////////////////////////////////////////////////
  // By People Name
  ////////////////////////////////////////////////////////////////////////////
  $SPT  = "%{$KEY}%"                                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "select `uuid` from `erp`.`people`"                                .
          " where ( `used` > 0 )"                                            .
          " and ( `uuid` in"                                                 .
          " ( select `uuid` from `erp`.`names` where `name` like ? ) ) ;"    ;
  $qq   = $DB -> Prepare    ( $QQ        )                                   ;
  $qq  -> bind_param        ( 's' , $SPT )                                   ;
  $qq  -> execute           (            )                                   ;
  $kk   = $qq -> get_result (            )                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $NXs  = $DB -> FetchUuids ( $kk , $NXs )                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $NXs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $NXs ; else              {
      $CANDIDATEs = Parameters::JoinArray ( $CANDIDATEs , $NXs )             ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // By E-mail
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "select `first` from `erp`.`relations`"                            .
          " where ( `t1` = 103 )"                                            .
            " and ( `t2` = 119 )"                                            .
            " and ( `relation` = 1 )"                                        .
            " and ( `second` in ("                                           .
            " select `uuid` from `erp`.`emails` where `email` like ? ) ) ;"  ;
  $qq   = $DB -> Prepare    ( $QQ        )                                   ;
  $qq  -> bind_param        ( 's' , $SPT )                                   ;
  $qq  -> execute           (            )                                   ;
  $kk   = $qq -> get_result (            )                                   ;
  $ELs  = $DB -> FetchUuids ( $kk , $ELs )                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $ELs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $ELs ; else              {
      $CANDIDATEs = Parameters::JoinArray ( $CANDIDATEs , $ELs )             ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // By Skype
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "select `first` from `erp`.`relations`"                            .
          " where ( `t1` = 103 )"                                            .
            " and ( `t2` = 113 )"                                            .
            " and ( `relation` = 1 )"                                        .
            " and ( `second` in ("                                           .
            " select `uuid` from `erp`.`instantmessage`"                     .
            " where ( `used` > 0 ) and ( `account` like ? ) ) ) ;"           ;
  $qq   = $DB -> Prepare    ( $QQ        )                                   ;
  $qq  -> bind_param        ( 's' , $SPT )                                   ;
  $qq  -> execute           (            )                                   ;
  $kk   = $qq -> get_result (            )                                   ;
  $IMs  = $DB -> FetchUuids ( $kk , $IMs )                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $IMs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $IMs ; else              {
      $CANDIDATEs = Parameters::JoinArray ( $CANDIDATEs , $IMs )             ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // By Phone
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "select `first` from `erp`.`relations`"                            .
          " where ( `t1` = 103 )"                                            .
            " and ( `t2` = 114 )"                                            .
            " and ( `relation` = 1 )"                                        .
            " and ( `second` in ("                                           .
            " select `uuid` from `erp`.`phones`"                             .
            " where ( `used` > 0 )"                                          .
            " and ( ( `number` like ? )"                                     .
            " or ( `country` like ? )"                                       .
            " or ( `area` like ? ) )  ) ) ;"                                 ;
  $qq   = $DB -> Prepare    ( $QQ                        )                   ;
  $qq  -> bind_param        ( 'sss' , $SPT , $SPT , $SPT )                   ;
  $qq  -> execute           (                            )                   ;
  $kk   = $qq -> get_result (                            )                   ;
  $PNs  = $DB -> FetchUuids ( $kk , $PNs                 )                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $PNs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $PNs ; else              {
      $CANDIDATEs = Parameters::JoinArray ( $CANDIDATEs , $PNs )             ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if             ( count ( $CANDIDATEs ) > 0                               ) {
    $CDS = array (                                                         ) ;
    foreach      ( $CANDIDATEs as $C                                       ) {
      if         ( ! in_array ( $C , $CDS )                                ) {
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $CANDIDATEs                                                         ;
}
//////////////////////////////////////////////////////////////////////////////
public function SearchByKeys($DB,$CANDIDATEs,$KEYs)
{
  foreach ( $KEYs as $key )                                           {
    if ( strlen ( $key ) > 0 )                                        {
      $CANDIDATEs = $this -> SearchByKey ( $DB , $CANDIDATEs , $key ) ;
    }                                                                 ;
  }                                                                   ;
  return $CANDIDATEs                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function SearchByLine($DB,$CANDIDATEs,$TXT,$SPLITTER=" ")
{
  $KEYs = explode ( $SPLITTER , $TXT )                              ;
  if ( count ( $KEYs ) <= 0 ) return $CANDIDATEs                    ;
  $CANDIDATEs = $this -> SearchByKeys ( $DB , $CANDIDATEs , $KEYs ) ;
  unset ( $KEYs )                                                   ;
  return $CANDIDATEs                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function CorrectPassword()
{
  $PwdCorrect = false                                          ;
  $Pwd        = ""                                             ;
  $Confirm    = ""                                             ;
  if ( $this -> hasParameter ( "password" ) )                  {
    $Pwd = $this -> Parameter -> Parameter ( "password" )      ;
    if ( $this -> hasParameter ( "confirm" ) )                 {
      $Confirm = $this -> Parameter -> Parameter ( "confirm" ) ;
      $PwdCorrect = ( $Pwd == $Confirm )                       ;
      if ( $PwdCorrect )                                       {
        if ( strlen ( $Pwd ) < 6 ) return false                ;
      }                                                        ;
    }                                                          ;
  }                                                            ;
  if ( ! $PwdCorrect ) return false                            ;
  return true                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetNameByParameter ( $KEY )
{
  $NI = new NameItem ( )                                 ;
  if ( ! $this -> hasParameter ( $KEY ) ) return $NI     ;
  $NI -> Name = $this -> Parameter -> Parameter ( $KEY ) ;
  $NI -> Name = trim ( $NI -> Name )                     ;
  return $NI                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetMembers    ( $DB                                          ,
                                $TABLE                                       ,
                                $ORDER    = "desc"                           ,
                                $RELATION = "Subordination"                ) {
  $RI  = new Relation         (                                            ) ;
  $RI -> set                  ( "first" , $this -> Uuid                    ) ;
  $RI -> setT1                ( "People"                                   ) ;
  $RI -> setT2                ( "People"                                   ) ;
  $RI -> setRelation          ( $RELATION                                  ) ;
  $LX  = $RI -> Subordination ( $DB                                          ,
                                $TABLE                                       ,
                                "order by `position` {$ORDER}"             ) ;
  unset                       ( $RI                                        ) ;
  return $LX                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetOwners($DB,$TABLE,$ORDER="desc",$RELATION="Subordination")
{
  $RI  = new Relation     (                             ) ;
  $RI -> set              ( "second" , $this -> Uuid    ) ;
  $RI -> setT1            ( "People"                    ) ;
  $RI -> setT2            ( "People"                    ) ;
  $RI -> setRelation      ( $RELATION                   ) ;
  $LX  = $RI -> GetOwners ( $DB                           ,
                            $TABLE                        ,
                            "order by `ltime` {$ORDER}" ) ;
  unset                   ( $RI                         ) ;
  return $LX                                              ;
}
//////////////////////////////////////////////////////////////////////////////
public function JoinMoment  ( $DB , $RI , $TABLE                           ) {
  $RI -> set                ( "second"  , $this -> Uuid                    ) ;
  $EIT = $RI -> ExactItem   (                                              ) ;
  $QQ  = "select `ltime` from {$TABLE} {$EIT} ;"                             ;
  $qq  = $DB -> Query       ( $QQ                                          ) ;
  $rr  = $qq -> fetch_array ( MYSQLI_BOTH                                  ) ;
  return $rr [ 0 ]                                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetPartners      ( $DB                                     ) {
  ////////////////////////////////////////////////////////////////////////////
  $PRLTAB   = $GLOBALS [ "TableMapping" ] [ "PeopleRelation" ]               ;
  $PQATAB   = $GLOBALS [ "TableMapping" ] [ "PartnerQuotas"  ]               ;
  ////////////////////////////////////////////////////////////////////////////
  $PUID     = $this -> Uuid                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $RI       = new Relation       (                                         ) ;
  $RI      -> set                ( "second" , $PUID                        ) ;
  $RI      -> setT1              ( "People"                                ) ;
  $RI      -> setT2              ( "People"                                ) ;
  $RI      -> setRelation        ( "Subordination"                         ) ;
  $PARTNERs = $RI -> GetOwners   ( $DB , $PRLTAB                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ       = "select `partner` from {$PQATAB}"                              .
               " where ( `people` = {$PUID} ) "                              .
               " group by `partner` ;"                                       ;
  $HISTORY  = $DB -> ObtainUuids ( $QQ                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                        ( $HISTORY as $H                          ) {
    if                           ( ! in_array ( $H , $PARTNERs )           ) {
      array_push                 ( $PARTNERs , $H                          ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $PARTNERs                                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetTeamLeaders ( $DB                                       ) {
  ////////////////////////////////////////////////////////////////////////////
  $PRLTAB = $GLOBALS [ "TableMapping" ] [ "PeopleRelation" ]                 ;
  ////////////////////////////////////////////////////////////////////////////
  $PUID   = $this -> Uuid                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $RI     = new Relation       (                                           ) ;
  $RI    -> set                ( "second" , $PUID                          ) ;
  $RI    -> setT1              ( "People"                                  ) ;
  $RI    -> setT2              ( "People"                                  ) ;
  $RI    -> setRelation        ( "Subordination"                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $RI -> GetOwners      ( $DB , $PRLTAB                             ) ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
