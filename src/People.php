<?php

namespace CIOS ;

class People
{

public $Uuid      = 0                     ;
public $Role      = 0                     ;
public $TzId      = "2700000000000000270" ;
public $TZ        = "Asia/Taipei"         ;
public $Language  = 1002                  ;
public $Level     = 0                     ;
public $Seniority = 0                     ;
public $Item      = 1                     ;
public $Courses   = array ( 1 )           ;
public $Owners                            ;
public $Name                              ;
public $Roles                             ;
public $Attributes                        ;

function __construct( $OBJ = 0 )
{
  if ( is_a         ( $OBJ , "CIOS\People" ) ) {
    $this -> assign ( $OBJ                   ) ;
  } else
  if ( is_numeric   ( $OBJ                 ) ) {
    $this -> Uuid =   $OBJ                     ;
  }
}

function __destruct()
{
}

public function assign($item)
{
  $this -> Uuid        = $item -> Uuid      ;
  $this -> Role        = $item -> Role      ;
  $this -> TzId        = $item -> TzId      ;
  $this -> TZ          = $item -> TZ        ;
  $this -> Language    = $item -> Language  ;
  $this -> Level       = $item -> Level     ;
  $this -> Seniority   = $item -> Seniority ;
  $this -> Item        = $item -> Item      ;
  $this -> Courses     = $item -> Courses   ;
  $this -> Owners      = $item -> Owners    ;
  $this -> Name        = $item -> Name      ;
  $this -> Roles       = $item -> Roles     ;
  $this -> $Attributes = array ( )          ;
}

public function toString ( )
{
  $U = $this -> Uuid                                         ;
  return sprintf ( "act1%08d" , gmp_mod ( $U , 100000000 ) ) ;
}

public function fromString ( $S )
{
  if               ( 12 != strlen ( $S )     ) {
    $this -> Uuid = 0                          ;
    return 0                                   ;
  }                                            ;
  $X = strtolower  ( $S                      ) ;
  $C = substr      ( $X , 0 , 4              ) ;
  if               ( $C != "act1"            ) {
    $this -> Uuid = 0                          ;
    return 0                                   ;
  }                                            ;
  $C = substr      ( $S , 0 , 4              ) ;
  $U = str_replace ( $C , "14000000000" , $S ) ;
  $this -> Uuid = $U                           ;
  return $U                                    ;
}

public function GetObjects ( $DB , $TABLE , $T2 , $RELATION )
{
  $RI  = new Relation         (                         ) ;
  $RI -> set                  ( "first" , $this -> Uuid ) ;
  $RI -> setT1                ( "People"                ) ;
  $RI -> setT2                ( $T2                     ) ;
  $RI -> setRelation          ( $RELATION               ) ;
  $XX  = $RI -> Subordination ( $DB , $TABLE            ) ;
  unset                       ( $RI                     ) ;
  return $XX                                              ;
}

public function GetEMails ( $DB , $TABLE = "`erp`.`relations`" )
{
  return $this -> GetObjects ( $DB , $TABLE , "EMail" , "Subordination" ) ;
}

public function GetIMs ( $DB , $TABLE = "`erp`.`relations`" )
{
  return $this -> GetObjects ( $DB , $TABLE , "InstantMessage" , "Subordination" ) ;
}

public function GetPhones ( $DB , $TABLE = "`erp`.`relations`" )
{
  return $this -> GetObjects ( $DB , $TABLE , "Phone" , "Subordination" ) ;
}

public function GetLanguage ( $DB , $TABLE = "`erp`.`relations`" )
{
  $RA = $this -> GetObjects     ( $DB , $TABLE , "Language" , "Using" ) ;
  if                            ( count ( $RA ) > 0                   ) {
    $LL = $RA [ 0 ]                                                     ;
    $this -> Language = gmp_mod ( $LL , 100000                        ) ;
  }                                                                     ;
  unset                         ( $RA                                 ) ;
  if ( $this -> Language <= 1000 ) $this -> Language = 1001             ;
  if ( $this -> Language >= 2000 ) $this -> Language = 1001             ;
  return $this -> Language                                              ;
}

public function GetRoles ( $DB , $TABLE = "`erp`.`relations`" )
{
  $this -> Roles = $this -> GetObjects ( $DB , $TABLE , "Role" , "Acting" ) ;
  return $this -> Roles                                                     ;
}

public function GetTimeZone ( $DB , $TABLE = "`erp`.`relations`" )
{
  $this -> TzId   = "2700000000000000270"                               ;
  if ( $this -> ContainsRole ( 2 ) )                                    {
    $this -> TzId = "2700000000000000249"                               ;
  }                                                                     ;
  $RA = $this -> GetObjects ( $DB , $TABLE , "TimeZone" , "Originate" ) ;
  if ( count ( $RA ) > 0 ) $this -> TzId = $RA [ 0 ]                    ;
  return $this -> TzId                                                  ;
}

public function GetZoneName ( $DB , $TABLE )
{
  $TZS        = new TimeZones       (                              ) ;
  $this -> TZ = $TZS -> GetZoneName ( $DB , $TABLE , $this -> Uuid ) ;
  return $this -> TZ                                                 ;
}

public function GetSeniority ( $DB )
{
  $this -> Seniority = ParameterQuery::GetParameterStatus (
                         $DB                              ,
                         $this -> Uuid                    ,
                         "Level"                        ) ;
}

public function GetLevel ( $DB )
{
  $this -> Level = ParameterQuery::GetParameterPersonal (
                     $DB                                ,
                     $this -> Uuid                      ,
                     "Level"                          ) ;
}

public function GetCourse ( $DB )
{
  $this -> Item = ParameterQuery::GetParameterStatus                 (
                    $DB                                              ,
                    $this -> Uuid                                    ,
                    "Course"                                       ) ;
  if ( ( strlen ( $this -> Item ) <= 0 ) or ( $this -> Item <= 0 ) ) {
    $this -> Item = 1                                                ;
  }                                                                  ;
}

public function GetCourses ( $DB )
{
  $ITEMs           = ParameterQuery::GetParameterData (
                       $DB                            ,
                       $this -> Uuid                  ,
                       "Courses"                      ,
                       2                              ,
                       37                             ,
                       "Teaching"                   ) ;
  $this -> Courses = explode ( " , " , $ITEMs )       ;
}

public function isCounselor ( )
{
  if ( ! $this -> ContainsRole ( 7 ) ) return false             ;
  if ( ( $this -> Level >= 300 ) and ( $this -> Level < 400 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}

public function isTeamLeader ( )
{
  if ( ! $this -> ContainsRole ( 7 ) ) return false             ;
  if ( ( $this -> Level >= 400 ) and ( $this -> Level < 500 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}

public function isManager ( )
{
  if ( ( $this -> Level >= 500 ) and ( $this -> Level < 800 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}

public function isSubsidiary ( )
{
  if ( ( $this -> Level >= 800 ) and ( $this -> Level < 900 ) ) {
    return true                                                 ;
  }                                                             ;
  return false                                                  ;
}

public function TutorParameters ( $DB )
{
  $this -> GetSeniority ( $DB ) ;
  $this -> GetCourses   ( $DB ) ;
}

public function StudentParameters ( $DB )
{
  $this -> GetCourse ( $DB ) ;
}

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

public function EmployeeParameters ( $DB )
{
}

public function RoleId ( )
{
  return $this -> ShortRole ( $this -> Role ) ;
}

public function ShortRole ( $X )
{
  $R = (string) $X                                              ;
  $R = (string) str_replace ( "1700000000" , "" , (string) $R ) ;
  return intval ( (string) $R , 10 )                            ;
}

public function ContainsRole ( $X )
{
  foreach ( $this -> Roles as $R )  {
    $V = $this -> ShortRole ( $R )  ;
    if ( $V == $X ) return true     ;
  }                                 ;
  return false                      ;
}

public function AddRole ( $R )
{
  array_push ( $this -> Roles , $R ) ;
}

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

public function SessionStart ( )
{
  $COURSESTR                        = implode ( " , " , $this -> Courses ) ;
  $ROLESTR                          = implode ( " , " , $this -> Roles   ) ;
  //////////////////////////////////////////////////////////////////////////
  $_SESSION [ "Authorized"        ] = true                                 ;
  $_SESSION [ "ACTIONS_UUID"      ] = (string) $this -> Uuid               ;
  $_SESSION [ "ACTIONS_ROLE"      ] = (string) $this -> Role               ;
  $_SESSION [ "ACTIONS_ROLES"     ] = (string) $ROLESTR                    ;
  $_SESSION [ "ACTIONS_NAME"      ] = (string) $this -> Name               ;
  $_SESSION [ "ACTIONS_TZID"      ] = (string) $this -> TzId               ;
  $_SESSION [ "ACTIONS_TZ"        ] = (string) $this -> TZ                 ;
  $_SESSION [ "ACTIONS_LANG"      ] = (string) $this -> Language           ;
  $_SESSION [ "ACTIONS_LEVEL"     ] = (string) $this -> Level              ;
  $_SESSION [ "ACTIONS_SENIORITY" ] = (string) $this -> Seniority          ;
  $_SESSION [ "ACTIONS_ITEM"      ] = (string) $this -> Item               ;
  $_SESSION [ "ACTIONS_COURSE"    ] = (string) $this -> Item               ;
  $_SESSION [ "ACTIONS_COURSES"   ] = (string) $COURSESTR                  ;
  //////////////////////////////////////////////////////////////////////////
  $ROID                             = 1                                    ;
  while ( $ROID <= 17                                                    ) {
    if  ( $this -> ContainsRole ( $ROID )                                ) {
      switch ( $ROID )                                                     {
        case  7                                                            :
        case  8                                                            :
        case  9                                                            :
          if ( $this -> isManager ( ) )                                    {
            $_SESSION [ "ACTIONS_MANAGER" ] = $this -> toString ( )        ;
          }                                                                ;
        break                                                              ;
        case 13                                                            :
        case 16                                                            :
          $_SESSION   [ "ACTIONS_MANAGER" ] = $this -> toString ( )        ;
        break                                                              ;
      }                                                                    ;
    }                                                                      ;
    $ROID                           = $ROID + 1                            ;
  }                                                                        ;
  //////////////////////////////////////////////////////////////////////////
}

public function Recovery()
{
  if ( ! isset ( $_SESSION [ "Authorized" ] ) ) return            ;
  $A = $_SESSION [ "Authorized" ]                                 ;
  if ( ! $A ) return                                              ;
  /////////////////////////////////////////////////////////////////
  $this -> Uuid      = (string) $_SESSION [ "ACTIONS_UUID"      ] ;
  $this -> Role      = (string) $_SESSION [ "ACTIONS_ROLE"      ] ;
  $this -> Name      = (string) $_SESSION [ "ACTIONS_NAME"      ] ;
  $this -> TzId      = (string) $_SESSION [ "ACTIONS_TZID"      ] ;
  $this -> TZ        = (string) $_SESSION [ "ACTIONS_TZ"        ] ;
  $this -> Language  = (string) $_SESSION [ "ACTIONS_LANG"      ] ;
  $this -> Level     = (string) $_SESSION [ "ACTIONS_LEVEL"     ] ;
  $this -> Seniority = (string) $_SESSION [ "ACTIONS_SENIORITY" ] ;
  $this -> Item      = (string) $_SESSION [ "ACTIONS_ITEM"      ] ;
  /////////////////////////////////////////////////////////////////
  $RRS               = (string) $_SESSION [ "ACTIONS_ROLES"     ] ;
  $this -> Roles     = explode ( " , " , $RRS )                   ;
  /////////////////////////////////////////////////////////////////
  $CCS               = (string) $_SESSION [ "ACTIONS_COURSES"   ] ;
  $this -> Courses   = explode ( " , " , $CCS )                   ;
}

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
    case  8                                                                  : // 協理
    case  9                                                                  : // 部門主管
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
    case 10                                                                  : // 會計
    return "pecuniary"                                                       ;
    case 11                                                                  : // 財務長
    return "pecuniary"                                                       ;
    case 12                                                                  : // 人力資源
    return "employees"                                                       ;
    case 13                                                                  : // 董事長
    return "chairperson"                                                     ;
    case 14                                                                  : // 股東
    return "shareholders"                                                    ;
    case 15                                                                  : // 資管
    return "employees"                                                       ;
    case 16                                                                  : // 設計者
    return "employees"                                                       ;
    case 17                                                                  : // 勤務
    return "employees"                                                       ;
  }                                                                          ;
  return "visitors"                                                          ;
}

public function Home (  )
{
  return $this -> HomeDir ( $this -> RoleId ( ) ) ;
}

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

public function ObtainByRole($DB,$TABLE,$CANDIDATE,$ACTING)
{
  $UU = array                   (                    ) ;
  $RI = new RelationItem        (                    ) ;
  //////////////////////////////////////////////////////
  $RI -> setT1                  ( "People"           ) ;
  $RI -> setT2                  ( "Role"             ) ;
  $RI -> setRelation            ( "Acting"           ) ;
  //////////////////////////////////////////////////////
  foreach                       ( $CANDIDATE as $imx ) {
    $RI -> set                  ( "first" , $imx     ) ;
    $CC  = $RI -> Subordination ( $DB     , $TABLE   ) ;
    if ( in_array ( $ACTING , $CC ) )                  {
      array_push ( $UU , $imx )                        ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $UU                                           ;
}

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
  $QQ     = "select `amount` from `erp`.`skipquotas`"                        .
            " where `owner` = {$PUID}"                                       .
               " and `item` = {$ITEMX}"                                      .
             " and `action` = 3 ;"                                           ;
  $qq  = $DB -> Query ( $QQ )                                                ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                       {
      $PTS = $PTS + $rr [ 0 ]                                                ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ     = "select `amount` from `erp`.`skipquotas`"                        .
            " where `owner` = {$PUID}"                                       .
               " and `item` = {$ITEMX}"                                      .
             " and `action` = 5 ;"                                           ;
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

public function SearchByKey($DB,$CANDIDATEs,$KEY)
{
  $RI  = new RelationItem ( )                                                ;
  $NI  = new NameItem     ( )                                                ;
  $MB  = new MailBox      ( )                                                ;
  $IM  = new ImApp        ( )                                                ;
  $PN  = new PhoneNumber  ( )                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $NXs = array            ( )                                                ;
  $ELs = array            ( )                                                ;
  $IMs = array            ( )                                                ;
  $PNs = array            ( )                                                ;
  $TMP = array            ( )                                                ;
  ////////////////////////////////////////////////////////////////////////////
  // By People Name
  ////////////////////////////////////////////////////////////////////////////
  $TMP = $NI   -> FindByName ( $DB                                           ,
                               "`erp`.`names`"                               ,
                               $KEY                                        ) ;
  $NXs = $this -> MakeSure   ( $DB                                           ,
                               "`erp`.`people`"                              ,
                               $NXs                                          ,
                               $TMP                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $NXs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $NXs ; else              {
//      $CANDIDATEs = array_intersect ( $CANDIDATEs , $NXs )                   ;
      $CANDIDATEs = $DB -> JoinArray ( $CANDIDATEs , $NXs )                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // By E-mail
  ////////////////////////////////////////////////////////////////////////////
  $RI -> setT1       ( "People"                  )                           ;
  $RI -> setT2       ( "EMail"                   )                           ;
  $RI -> setRelation ( "Subordination"           )                           ;
  ////////////////////////////////////////////////////////////////////////////
  $TMP = $MB -> FindByName   ( $DB , "`erp`.`emails`" , $KEY )               ;
  $ELs = $RI -> ObtainOwners ( $DB                                           ,
                               "`erp`.`relations`"                           ,
                               $ELs                                          ,
                               $TMP                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $ELs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $ELs ; else              {
//      $CANDIDATEs = array_intersect ( $CANDIDATEs , $ELs )                   ;
      $CANDIDATEs = $DB -> JoinArray ( $CANDIDATEs , $ELs )                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // By Skype
  ////////////////////////////////////////////////////////////////////////////
  $RI -> setT1       ( "People"         )                                    ;
  $RI -> setT2       ( "InstantMessage" )                                    ;
  $RI -> setRelation ( "Subordination"  )                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $TMP = $IM -> FindByName   ( $DB , "`erp`.`instantmessage`" , $KEY       ) ;
  $IMs = $RI -> ObtainOwners ( $DB                                           ,
                               "`erp`.`relations`"                           ,
                               $IMs                                          ,
                               $TMP                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $IMs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $IMs ; else              {
//      $CANDIDATEs = array_intersect ( $CANDIDATEs , $IMs )                   ;
      $CANDIDATEs = $DB -> JoinArray ( $CANDIDATEs , $IMs )                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // By Phone
  ////////////////////////////////////////////////////////////////////////////
  $RI -> setT1       ( "People"        )                                     ;
  $RI -> setT2       ( "Phone"         )                                     ;
  $RI -> setRelation ( "Subordination" )                                     ;
  $TMP = $PN -> FindByName   ( $DB , "`erp`.`phones`" , $KEY )               ;
  $PNs = $RI -> ObtainOwners ( $DB                                           ,
                               "`erp`.`relations`"                           ,
                               $PNs                                          ,
                               $TMP                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $PNs ) > 0 )                                                  {
    if ( count ( $CANDIDATEs ) <= 0 ) $CANDIDATEs = $PNs ; else              {
//      $CANDIDATEs = array_intersect ( $CANDIDATEs , $PNs )                   ;
      $CANDIDATEs = $DB -> JoinArray ( $CANDIDATEs , $PNs )                  ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $CANDIDATEs                                                         ;
}

public function SearchByKeys($DB,$CANDIDATEs,$KEYs)
{
  foreach ( $KEYs as $key )                                           {
    if ( strlen ( $key ) > 0 )                                        {
      $CANDIDATEs = $this -> SearchByKey ( $DB , $CANDIDATEs , $key ) ;
    }                                                                 ;
  }                                                                   ;
  return $CANDIDATEs                                                  ;
}

public function SearchByLine($DB,$CANDIDATEs,$TXT,$SPLITTER=" ")
{
  $KEYs = explode ( $SPLITTER , $TXT )                              ;
  if ( count ( $KEYs ) <= 0 ) return $CANDIDATEs                    ;
  $CANDIDATEs = $this -> SearchByKeys ( $DB , $CANDIDATEs , $KEYs ) ;
  unset ( $KEYs )                                                   ;
  return $CANDIDATEs                                                ;
}

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

public function GetNameByParameter ( $KEY )
{
  $NI = new NameItem ( )                                 ;
  if ( ! $this -> hasParameter ( $KEY ) ) return $NI     ;
  $NI -> Name = $this -> Parameter -> Parameter ( $KEY ) ;
  $NI -> Name = trim ( $NI -> Name )                     ;
  return $NI                                             ;
}

public function GetMembers($DB,$TABLE,$ORDER="desc",$RELATION="Subordination")
{
  $RI  = new RelationItem     (                                ) ;
  $RI -> set                  ( "first" , $this -> Uuid        ) ;
  $RI -> setT1                ( "People"                       ) ;
  $RI -> setT2                ( "People"                       ) ;
  $RI -> setRelation          ( $RELATION                      ) ;
  $LX  = $RI -> Subordination ( $DB                              ,
                                $TABLE                           ,
                                "order by `position` {$ORDER}" ) ;
  unset                       ( $RI                            ) ;
  return $LX                                                     ;
}

public function GetOwners($DB,$TABLE,$ORDER="desc",$RELATION="Subordination")
{
  $RI  = new RelationItem (                             ) ;
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

public function JoinMoment($DB,$RI,$TABLE)
{
  $RI -> set                ( "second"  , $this -> Uuid )              ;
  $QQ  = "select `ltime` from {$TABLE} " . $RI -> ExactItem ( ) . " ;" ;
  $qq  = $DB -> Query       ( $QQ                       )              ;
  $rr  = $qq -> fetch_array ( MYSQLI_BOTH               )              ;
  return $rr [ 0 ]                                                     ;
}

}

?>
