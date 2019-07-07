<?php

namespace CIOS ;

class People extends Columns
{

/////////////////////////////////////////////////////////
public $Uuid      = 0                     ;
public $Role      = 0                     ;
public $Euid      = 0                     ;
public $Suid      = 0                     ;
public $TzId      = "2700000000000000270" ;
public $TZ        = "Asia/Taipei"         ;
public $TzName    = ""                    ;
public $Language  = 1002                  ;
public $Level     = 0                     ;
public $Seniority = 0                     ;
public $Item      = 1                     ;
public $Owners                            ;
public $Name                              ;
public $Parameter                         ;
public $DB                                ;
public $Roles                             ;
/////////////////////////////////////////////////////////

public function Prepare()
{
  $this -> Parameter     = new Parameters ( ) ;
  $this -> DB            = new ActionsDB  ( ) ;
  $this -> Roles         = array          ( ) ;
  $this -> ForumUsername = ""                 ;
  $this -> ForumPassword = ""                 ;
}

/////////////////////////////////////////////////////////

public function Connect($Host)
{
  return $this -> DB -> ConnectDB ( $Host ) ;
}

/////////////////////////////////////////////////////////

public function Disconnect()
{
  $this -> DB -> CloseDB ( ) ;
}

/////////////////////////////////////////////////////////

public function hasParameter($KEY)
{
  return $this -> Parameter -> hasParameter ( $KEY ) ;
}

/////////////////////////////////////////////////////////

public function RoleId()
{
  return $this -> ShortRole ( $this -> Role ) ;
}

/////////////////////////////////////////////////////////

public function ShortRole($X)
{
  $R = (string) $X                                              ;
  $R = (string) str_replace ( "1700000000" , "" , (string) $R ) ;
  return intval ( (string) $R , 10 )                            ;
}

/////////////////////////////////////////////////////////

public function ContainsRole($X)
{
  foreach ( $this -> Roles as $R ) {
    $V = $this -> ShortRole( $R )  ;
    if ( $V == $X ) return true    ;
  }                                ;
  return false                     ;
}

/////////////////////////////////////////////////////////

public function AddRole($R)
{
  array_push ( $this -> Roles , $R ) ;
}

public function toString()
{
  return $this -> Parameter -> PeopleString ( $this -> Uuid ) ;
}

/////////////////////////////////////////////////////////

public function hasActionsID()
{
  $this -> Uuid = 0                                         ;
  if ( $this -> Parameter -> hasParameter ( "actionsid" ) ) {
    $AID = $this -> Parameter -> Parameter ( "actionsid" )  ;
    if ( strlen ( $AID ) != 12 ) return false               ;
    $this -> Uuid = $this -> Parameter -> PeopleID ( $AID ) ;
  } else                                                    {
    return false                                            ;
  }                                                         ;
  return true                                               ;
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

public function Recovery()
{
  if ( ! $this -> Parameter -> hasSession ( "Authorized" ) ) return ;
  $A = $_SESSION [ "Authorized" ]                                   ;
  if ( ! $A ) return                                                ;
  ///////////////////////////////////////////////////////////////////
  $this -> Uuid      = (string) $_SESSION [ "ACTIONS_UUID"      ]   ;
  $this -> Role      = (string) $_SESSION [ "ACTIONS_ROLE"      ]   ;
  $this -> Name      = (string) $_SESSION [ "ACTIONS_NAME"      ]   ;
  $this -> TzId      = (string) $_SESSION [ "ACTIONS_TZID"      ]   ;
  $this -> TZ        = (string) $_SESSION [ "ACTIONS_TZ"        ]   ;
  $this -> TzName    = (string) $_SESSION [ "ACTIONS_TZNAME"    ]   ;
  $this -> Language  = (string) $_SESSION [ "ACTIONS_LANG"      ]   ;
  $this -> Level     = (string) $_SESSION [ "ACTIONS_LEVEL"     ]   ;
  $this -> Seniority = (string) $_SESSION [ "ACTIONS_SENIORITY" ]   ;
  $this -> Item      = (string) $_SESSION [ "ACTIONS_ITEM"      ]   ;
  ///////////////////////////////////////////////////////////////////
  $RS                = (string) $_SESSION [ "ACTIONS_ROLES"     ]   ;
  $this -> Roles     = explode ( "," , $RS )                        ;
}

/////////////////////////////////////////////////////////

public function SessionStart()
{
  $_SESSION [ "Authorized"        ] = true                                      ;
  $_SESSION [ "ACTIONS_UUID"      ] = (string) $this -> Uuid                    ;
  $_SESSION [ "ACTIONS_ROLE"      ] = (string) $this -> Role                    ;
  $_SESSION [ "ACTIONS_ROLES"     ] = (string) implode ( "," , $this -> Roles ) ;
  $_SESSION [ "ACTIONS_NAME"      ] = (string) $this -> Name                    ;
  $_SESSION [ "ACTIONS_TZID"      ] = (string) $this -> TzId                    ;
  $_SESSION [ "ACTIONS_TZ"        ] = (string) $this -> TZ                      ;
  $_SESSION [ "ACTIONS_TZNAME"    ] = (string) $this -> TzName                  ;
  $_SESSION [ "ACTIONS_LANG"      ] = (string) $this -> Language                ;
  $_SESSION [ "ACTIONS_LEVEL"     ] = (string) $this -> Level                   ;
  $_SESSION [ "ACTIONS_SENIORITY" ] = (string) $this -> Seniority               ;
  $_SESSION [ "ACTIONS_ITEM"      ] = (string) $this -> Item                    ;
  $_SESSION [ "ACTIONS_COURSE"    ] = (string) $this -> Item                    ;
}

/////////////////////////////////////////////////////////

public function PeopleFromEmails($Email,$M)
{
  $E = array ( )                                                        ;
  if ( ! $M -> setEMail ( $Email ) )                                    {
    unset ( $M )                                                        ;
    return $E                                                           ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  if ( ! $M -> ObtainsByEMail ( $this -> DB , "`erp`.`emails`" ) )      {
    unset ( $M )                                                        ;
    return $E                                                           ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  $this -> Euid = $M -> Uuid                                            ;
  $E = $M -> GetOwners ( $this -> DB , "`erp`.`relations`" , "People" ) ;
  unset ( $M )                                                          ;
  ///////////////////////////////////////////////////////////////////////
  return $E                                                             ;
}

public function ListPeopleFromEmails()
{
  $E = array ( )                                            ;
  if ( $this -> Parameter -> hasParameter ( "username"  ) ) {
    $Email = $this -> Parameter -> Parameter ( "username" ) ;
    if ( strlen ( $Email ) <= 0 ) return $E                 ;
    $M = new MailBox ( )                                    ;
    $E = $this -> PeopleFromEmails ( $Email , $M )          ;
    unset ( $M )                                            ;
  }                                                         ;
  return $E                                                 ;
}

/////////////////////////////////////////////////////////

public function PeopleFromSkype($Skype,$I)
{
  $S  = array ( )                                                            ;
  $I -> setAccount ( $Skype )                                                ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! $I -> ObtainsByAccount ( $this -> DB , "`erp`.`instantmessage`" ) ) {
    unset ( $I )                                                             ;
    return $S                                                                ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Suid = $I -> Uuid                                                 ;
  $S = $I -> GetOwners ( $this -> DB , "`erp`.`relations`" , "People" )      ;
  unset ( $I )                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  return $S                                                                  ;
}

public function ListPeopleFromSkype()
{
  $S = array ( )                                         ;
  if ( $this -> Parameter -> hasParameter ( "skype" ) )  {
    $Skype = $this -> Parameter -> Parameter ( "skype" ) ;
    if ( strlen ( $Skype ) <= 0 ) return $S              ;
    $I = new ImApp ( )                                   ;
    $S = $this -> PeopleFromSkype ( $Skype , $I )        ;
    unset ( $I )                                         ;
  }                                                      ;
  return $S                                              ;
}

public function ListRoles ( $Table = "`erp`.`relations`" )
{
  $RI  = new RelationItem     (                         ) ;
  /////////////////////////////////////////////////////////
  $RI -> set                  ( "first" , $this -> Uuid ) ;
  $RI -> setT1                ( "People"                ) ;
  $RI -> setT2                ( "Role"                  ) ;
  $RI -> setRelation          ( "Acting"                ) ;
  $RA  = $RI -> Subordination ( $this -> DB , $Table    ) ;
  /////////////////////////////////////////////////////////
  unset                       ( $RI                     ) ;
  /////////////////////////////////////////////////////////
  return $RA                                              ;
}

public function DecideRole ( )
{
  $TRS  = $this -> Roles                                                     ;
  foreach                      ( $TRS as $R )                                {
    $I    = $this -> ShortRole ( $R         )                                ;
    $X    = $this -> RoleId    (            )                                ;
    switch                     ( $I         )                                {
      case  2                                                                : // Tutor
        switch                 ( $X         )                                {
          case 7                                                             :
          break                                                              ;
          default                                                            :
            $this -> Role = $R                                               ;
          break                                                              ;
        }                                                                    ;
      break                                                                  ;
      case  4                                                                : // Partner
      case  5                                                                : // Supervisor
        $this -> Role = $R                                                   ;
      break                                                                  ;
      case  7                                                                : // Manager
        $this -> Role = $R                                                   ;
      break                                                                  ;
      case 13                                                                : // Chairperson
        $this -> Role = $R                                                   ;
      break                                                                  ;
      default                                                                :
        if ( 0 == $X ) $this -> Role = $R                                    ;
      break                                                                  ;
    }                                                                        ;
  }                                                                          ;
}

public function GetObjects($DB,$TABLE,$T2,$RELATION)
{
  $RI  = new RelationItem     (                         ) ;
  $RI -> set                  ( "first" , $this -> Uuid ) ;
  $RI -> setT1                ( "People"                ) ;
  $RI -> setT2                ( $T2                     ) ;
  $RI -> setRelation          ( $RELATION               ) ;
  $XX  = $RI -> Subordination ( $DB , $TABLE            ) ;
  unset                       ( $RI                     ) ;
  return $XX                                              ;
}

public function GetEMails($DB,$TABLE="`erp`.`relations`")
{
  return $this -> GetObjects ( $DB , $TABLE , "EMail" , "Subordination" ) ;
}

public function GetIMs($DB,$TABLE="`erp`.`relations`")
{
  return $this -> GetObjects ( $DB , $TABLE , "InstantMessage" , "Subordination" ) ;
}

public function GetPhones($DB,$TABLE="`erp`.`relations`")
{
  return $this -> GetObjects ( $DB , $TABLE , "Phone" , "Subordination" ) ;
}

public function GetLanguage ( $Table = "`erp`.`relations`" )
{
  $RA  = array                (                         ) ;
  $RI  = new RelationItem     (                         ) ;
  /////////////////////////////////////////////////////////
  $RI -> set                  ( "first" , $this -> Uuid ) ;
  $RI -> setT1                ( "People"                ) ;
  $RI -> setT2                ( "Language"              ) ;
  $RI -> setRelation          ( "Using"                 ) ;
  $RA  = $RI -> Subordination ( $this -> DB , $Table    ) ;
  if                          ( count ( $RA ) > 0       ) {
    $HH    = new Parameters   (                         ) ;
    $this -> Language = $HH -> toLocality ( $RA [ 0 ] )   ;
  }                                                       ;
  /////////////////////////////////////////////////////////
  unset                       ( $RI                     ) ;
  unset                       ( $RA                     ) ;
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

/////////////////////////////////////////////////////////
// function Login return values
// 0 - Failure to identify people
// 1 - $Uuid has an unique Actions ID and password matched
// 2 - $Uuid has an unique Actions ID, password matched, but no role assigned
// 3 - $Uuid has an unique Actions ID and password mismatched
// 4 - More than one people found , a list was stored in $Owners
// 5 - inconsistency account
// 6 - No password inputed

public function Login()
{
  global $EnglishId                                                   ;
  global $LanguageId                                                  ;
  $EU = array            ( )                                          ;
  $ES = array            ( )                                          ;
  $Verified     = false                                               ;
  $this -> Role = 0                                                   ;
  $this -> Uuid = 0                                                   ;
  /////////////////////////////////////////////////////////////////////
  // Try to obtain Actions ID
  $this -> hasActionsID ( )                                           ;
  /////////////////////////////////////////////////////////////////////
  // Try to obtain EMail Account
  if ( $this -> hasParameter ( "username" ) )                         {
    $EU = $this -> ListPeopleFromEmails ( )                           ;
  }                                                                   ;
  /////////////////////////////////////////////////////////////////////
  // Try to obtain Skype Account
  if ( $this -> hasParameter ( "skype" ) )                            {
    $ES = $this -> ListPeopleFromSkype ( )                            ;
  }                                                                   ;
  /////////////////////////////////////////////////////////////////////
  if     ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 )                     {
    // WWW User did not input Actions ID
    if   ( 0 >= count ( $EU ) )                                       {
      // No Email was inputed
      if ( 0 >= count ( $ES ) )                                       {
        // No skype was inputed
        return 0                                                      ;
      } else
      if ( 1 == count ( $ES ) )                                       {
        // Assign People $Uuid found by Skype
        $this -> Uuid = $ES [ 0 ]                                     ;
      } else                                                          {
        // More than one people own this Skype
        $this -> Owners = $ES                                         ;
        return 4                                                      ;
      }                                                               ;
    } else
    if   ( 1 == count ( $EU ) )                                       {
      // Assign People $Uuid found by Email
      $this -> Uuid = $EU [ 0 ]                                       ;
    } else                                                            {
      // More than one people own this Email
      $this -> Owners = $EU                                           ;
      return 4                                                        ;
    }                                                                 ;
  } else                                                              {
    // WWW User did input Actions ID
    if   ( 0 < count ( $EU ) )                                        {
      if ( ! $this -> Parameter -> Contains ( $EU , $this -> Uuid ) ) {
        return 5                                                      ;
      }                                                               ;
    }                                                                 ;
    if   ( 0 < count ( $ES ) )                                        {
      if ( ! $this -> Parameter -> Contains ( $ES , $this -> Uuid ) ) {
        return 5                                                      ;
      }                                                               ;
    }                                                                 ;
  }                                                                   ;
  /////////////////////////////////////////////////////////////////////
  // Verify Password
  if ( gmp_cmp ( $this -> Uuid , "0" ) > 0 )                          {
    if ( $this -> hasParameter ( "password" ) )                       {
      $PASSWD = $this -> Parameter -> Parameter ( "password" )        ;
      if ( 0 < strlen ( $PASSWD) )                                    {
        // Check password
        $Verified = false                                             ;
        $QQ = "select `secret` from `erp`.`secrets`"                  .
              " where `uuid` = {$this->Uuid}"                         .
                " and `name` = 'login' ;"                             ;
        $qq = $this -> DB -> Query ( $QQ )                            ;
        if ( $this -> DB -> hasResult ( $qq ) )                       {
          $rr = $qq -> fetch_array ( MYSQLI_BOTH )                    ;
          $PW = $rr [ 0 ]                                             ;
          if ( $PASSWD == $PW ) $Verified = true                      ;
        }                                                             ;
      } else                                                          {
        return 6                                                      ;
      }                                                               ;
      if ( ! $Verified ) return 3                                     ;
    } else                                                            {
      return 6                                                        ;
    }                                                                 ;
  }                                                                   ;
  /////////////////////////////////////////////////////////////////////
  if ( $Verified )                                                    {
    $this -> TzId  = $this -> ListTimeZone ( )                        ;
    $QX = "select `zonename` from `erp`.`timezones` where `uuid` = "  .
          (string) $this -> TzId . " ;"                               ;
    $qq = $this -> DB -> Query ( $QX )                                ;
    if ( $this -> DB -> hasResult ( $qq ) )                           {
      $NN         = $qq -> fetch_array ( MYSQLI_BOTH )                ;
      $this -> TZ = $NN [ 0 ]                                         ;
    }                                                                 ;
    ///////////////////////////////////////////////////////////////////
    $this -> GetLanguage ( )                                          ;
    ///////////////////////////////////////////////////////////////////
    $this -> Roles = $this -> ListRoles    ( )                        ;
    if ( 0 == count ( $this -> Roles ) )                              {
      // No role found
      return 2                                                        ;
    }                                                                 ;
    //////////////////////////////////////////////////////////////////////////
    $this -> DecideRole ( )                                                  ;
    //////////////////////////////////////////////////////////////////////////

/*

    foreach ( $this -> Roles as $R )                                  {
      $I = $this -> ShortRole ( $R )                                  ;
      $X = $this -> RoleId    (    )                                  ;
      switch ( $I )                                                   {
        case  2                                                       :
          // Tutor
          switch ( $X )                                               {
            case 7                                                    :
            break                                                     ;
            default                                                   :
              $this -> Role = $R                                      ;
            break                                                     ;
          }                                                           ;
        break                                                         ;
        case  4                                                       :
          // Partner
        case  5                                                       :
          // Supervisor
          $this -> Role = $R                                          ;
        break                                                         ;
        case  7                                                       :
          // Manager
          $this -> Role = $R                                          ;
        break                                                         ;
        case 13                                                       :
          // Chairperson
          $this -> Role = $R                                          ;
        break                                                         ;
        default                                                       :
          if ( 0 == $X ) $this -> Role = $R                           ;
        break                                                         ;
      }                                                               ;
    }                                                                 ;

*/

    ///////////////////////////////////////////////////////////////////
    if ( 0 == $this -> Role )                                         {
      return 2                                                        ;
    }                                                                 ;
    ///////////////////////////////////////////////////////////////////
    switch ( $this -> RoleId ( )  )                                   {
      case  2                                                         :
        // Tutor
        $this -> Name = $this -> DB -> GetTutor                       (
                          "`erp`.`names`"                             ,
                          $this -> Uuid                             ) ;
        ///////////////////////////////////////////////////////////////
        $PQX   = new ParameterQuery ( )                               ;
        $PQX  -> setTable   ( "`erp`.`parameters`" )                  ;
        $PQX  -> setType    ( 0                    )                  ;
        $PQX  -> setVariety ( 23                   )                  ;
        $PQX  -> setScope   ( "Status"             )                  ;
        $this -> Seniority = $PQX -> Value                            (
                               $this -> DB                            ,
                               $this -> Uuid                          ,
                               "Level"                              ) ;
        ///////////////////////////////////////////////////////////////
        unset ( $PQX )                                                ;
        ///////////////////////////////////////////////////////////////
        $PQ           = NewParameter ( 2 , 37 , "Teaching"          ) ;
        $PQ          -> setTable     ( "`erp`.`parameters`"         ) ;
        $this -> Item = $PQ -> Data  ( $this -> DB                    ,
                                       $this -> Uuid                  ,
                                       "Courses"                    ) ;
        ///////////////////////////////////////////////////////////////
      break                                                           ;
      case  7                                                         :
        ///////////////////////////////////////////////////////////////
        $PQX   = new ParameterQuery ( )                               ;
        $PQX  -> setTable   ( "`erp`.`parameters`" )                  ;
        $PQX  -> setType    ( 0                    )                  ;
        $PQX  -> setVariety ( 48                   )                  ;
        $PQX  -> setScope   ( "Personal"           )                  ;
        $this -> Level = $PQX -> Value                                (
                            $this -> DB                               ,
                            $this -> Uuid                             ,
                            "Level"                                 ) ;
        ///////////////////////////////////////////////////////////////
        $PQX   = new ParameterQuery ( )                               ;
        $PQX  -> setTable   ( "`erp`.`parameters`" )                  ;
        $PQX  -> setType    ( 0                    )                  ;
        $PQX  -> setVariety ( 23                   )                  ;
        $PQX  -> setScope   ( "Status"             )                  ;
        $this -> Seniority = $PQX -> Value                            (
                               $this -> DB                            ,
                               $this -> Uuid                          ,
                               "Level"                              ) ;
        ///////////////////////////////////////////////////////////////
        unset ( $PQX )                                                ;
        ///////////////////////////////////////////////////////////////
        if ( ( $this -> Level >= 400 ) and ( $this -> Level < 500 ) ) {
          $this -> Name = $this -> DB -> GetTutor                     (
            "`erp`.`names`"                                           ,
            $this -> Uuid                                           ) ;
        } else                                                        {
          $this -> Name = $this -> DB -> GetManager                   (
            "`erp`.`names`"                                           ,
            $this -> Uuid                                           ) ;
        }                                                             ;
        ///////////////////////////////////////////////////////////////
        $PQ           = NewParameter ( 2 , 37 , "Teaching"          ) ;
        $PQ          -> setTable     ( "`erp`.`parameters`"         ) ;
        $this -> Item = $PQ -> Data  ( $this -> DB                    ,
                                       $this -> Uuid                  ,
                                       "Courses"                    ) ;
        ///////////////////////////////////////////////////////////////
      break                                                           ;
      default                                                         :
        ///////////////////////////////////////////////////////////////
        $this -> Name = $this -> DB -> GetStudent                     (
          "`erp`.`names`"                                             ,
          $this -> Uuid                                             ) ;
        ///////////////////////////////////////////////////////////////
        $PQ           = NewParameter ( 0 , 23 , "Status"            ) ;
        $PQ          -> setTable     ( "`erp`.`parameters`"         ) ;
        $this -> Item = $PQ -> Value ( $this -> DB                    ,
                                       $this -> Uuid                  ,
                                       "Course"                     ) ;
        ///////////////////////////////////////////////////////////////
      break                                                           ;
    }                                                                 ;
    ///////////////////////////////////////////////////////////////////
    if ( ( strlen ( $this -> Item ) <= 0 )                           or
         ( $this -> Item <= 0 )                                     ) {
      $this -> Item = 1                                               ;
    }                                                                 ;
    ///////////////////////////////////////////////////////////////////
  } else                                                              {
    // No valid user found
    return 0                                                          ;
  }                                                                   ;
  /////////////////////////////////////////////////////////////////////
  return 1                                                            ;
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

/////////////////////////////////////////////////////////
// function Register return values
//  0 - Failure to register
//  1 - Register success
//  2 - Email exists
//  3 - Skype exists
//  4 - Can not obtain People Uuid
//  5 - Password incorrect , less than 6 characters or mismatch with confirm
//  6 - Phone number exists
//  7 - Phone number incorrect
//  8 - Email incorrect
//  9 - Skype incorrect
// 10 - No English Name

public function Register()
{
  global $NameUsages                                                    ;
  $SROLE        = "1700000000000000003"                                 ;
  $EU           = array ( )                                             ;
  $ES           = array ( )                                             ;
  $Verified     = false                                                 ;
  $Email        = ""                                                    ;
  $Skype        = ""                                                    ;
  $this -> Role = 0                                                     ;
  $this -> Uuid = 0                                                     ;
  ///////////////////////////////////////////////////////////////////////
  $PwdCorrect = $this -> CorrectPassword ( )                            ;
  if ( ! $PwdCorrect ) return 5                                         ;
  $Pwd = $this -> Parameter -> Parameter ( "password" )                 ;
  ///////////////////////////////////////////////////////////////////////
  // Try to obtain EMail Account
  $mbox = new MailBox ( )                                               ;
  if ( $this -> hasParameter ( "email" ) )                              {
    $Email = $this -> Parameter -> Parameter ( "email" )                ;
    $EU    = $this -> PeopleFromEmails ( $Email , $mbox )               ;
    if ( count ( $EU ) > 0 ) return 2                                   ;
  } else                                                                {
    return 8                                                            ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Try to obtain Skype Account
  $im = new ImApp ( )                                                   ;
  if ( $this -> hasParameter ( "skype" ) )                              {
    $Skype = $this -> Parameter -> Parameter ( "skype" )                ;
    $ES    = $this -> PeopleFromSkype ( $Skype , $im )                  ;
    if ( count ( $ES ) > 0 ) return 3                                   ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  $PNC  = new PhoneNumber (      )                                      ;
  $PNC -> setMobile       ( true )                                      ;
  if ( $this -> hasParameter ( "phoneNumber" ) )                        {
    $phoneNumber = $this -> Parameter -> Parameter ( "phoneNumber" )    ;
    if ( $this -> hasParameter ( "countryCode" ) )                      {
      $countryCode = $this -> Parameter -> Parameter ( "countryCode" )  ;
      $PNC -> setInternational ( $countryCode )                         ;
      $PNC -> setPhone         ( $phoneNumber )                         ;
      if ( $PNC -> ObtainsByNumber ( $this -> DB , "`erp`.`phones`" ) ) {
        return 6                                                        ;
      }                                                                 ;
    } else                                                              {
      return 7                                                          ;
    }                                                                   ;
  } else                                                                {
    return 7                                                            ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  $Correct = true                                                       ;
  ///////////////////////////////////////////////////////////////////////
  // Obtain English Name and Chinese Name
  $NE = $this -> GetNameByParameter ( "EnglishName" )                   ;
  if ( ! $NE -> hasName ( ) ) return 10                                 ;
  $NC = $this -> GetNameByParameter ( "ChineseName" )                   ;
  $NP = $this -> GetNameByParameter ( "PenName"     )                   ;
  ///////////////////////////////////////////////////////////////////////
  // Obtain People Uuid
  $this -> Uuid = $this -> DB -> ObtainsUuid                            (
                    "`erp`.`people`"                                    ,
                    "`erp`.`uuids`"                                   ) ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return 4                  ;
  ///////////////////////////////////////////////////////////////////////
  // Append English Name
  if ( $NE -> hasName ( ) )                                             {
    $NE -> set ( "uuid"      , $this -> Uuid             )              ;
    $NE -> set ( "locality"  , 1001                      )              ;
    $NE -> set ( "priority"  , 0                         )              ;
    $NE -> set ( "relevance" , $NameUsages [ "Default" ] )              ;
    $NE -> Append ( $this -> DB , "`erp`.`names`" )                     ;
    $this -> Name = $NE -> Name                                         ;
  } else                                                                {
//    $Correct = false                                                    ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append Chinese Name
  if ( $NC -> hasName ( ) )                                             {
    $NC -> set ( "uuid"      , $this -> Uuid             )              ;
    $NC -> set ( "locality"  , 1002                      )              ;
    $NC -> set ( "priority"  , 0                         )              ;
    $NC -> set ( "relevance" , $NameUsages [ "Default" ] )              ;
    $NC -> Append ( $this -> DB , "`erp`.`names`" )                     ;
    $this -> Name = $NC -> Name                                         ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append Pen Name
  if ( $NP -> hasName ( ) )                                             {
    $NP -> set ( "uuid"      , $this -> Uuid         )                  ;
    $NP -> set ( "locality"  , 1001                  )                  ;
    $NP -> set ( "priority"  , 0                     )                  ;
    $NP -> set ( "relevance" , $NameUsages [ "Pen" ] )                  ;
    $NP -> Append ( $this -> DB , "`erp`.`names`" )                     ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append Role into People
  $RI  = new RelationItem (                            )                ;
  $RI -> set              ( "first"    , $this -> Uuid )                ;
  $RI -> set              ( "second"   , $SROLE        )                ;
  $RI -> set              ( "position" , "0"           )                ;
  $RI -> setT1            ( "People"                   )                ;
  $RI -> setT2            ( "Role"                     )                ;
  $RI -> setRelation      ( "Acting"                   )                ;
  if ( $RI -> Append ( $this -> DB , "`erp`.`relations`" ) )            {
    $this -> Role = $SROLE                                              ;
    $this -> AddRole ( $SROLE )                                         ;
  } else                                                                {
    $Correct = false                                                    ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append TimeZone into People
  ///////////////////////////////////////////////////////////////////////
  $RI -> set              ( "second"   , "2700000000000000270" )        ;
  $RI -> setT2            ( "TimeZone"                         )        ;
  $RI -> setRelation      ( "Originate"                        )        ;
  if ( $RI -> Append ( $this -> DB , "`erp`.`relations`" ) )            {
  } else                                                                {
    $Correct = false                                                    ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  $RI -> set         ( "position" , "0" )                               ;
  $RI -> setRelation ( "Subordination"  )                               ;
  ///////////////////////////////////////////////////////////////////////
  // Append Email
  if ( $mbox -> Append ( $this -> DB                                    ,
                         "`erp`.`emails`"                               ,
                         "`erp`.`uuids`"                            ) ) {
    $RI -> set   ( "second" , $mbox -> Uuid )                           ;
    $RI -> setT2 ( "EMail"                  )                           ;
    if ( $RI -> Append ( $this -> DB , "`erp`.`relations`" ) )          {
    } else                                                              {
      $Correct = false                                                  ;
    }                                                                   ;
  } else                                                                {
    $Correct = false                                                    ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append Skype
  if ( $im -> Append ( $this -> DB                                      ,
                       "`erp`.`instantmessage`"                         ,
                       "`erp`.`uuids`"                              ) ) {
    $RI -> set   ( "second" , $im -> Uuid )                             ;
    $RI -> setT2 ( "InstantMessage"       )                             ;
    if ( $RI -> Append ( $this -> DB , "`erp`.`relations`" ) )          {
    } else                                                              {
      $Correct = false                                                  ;
    }                                                                   ;
  } else                                                                {
    $Correct = false                                                    ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append Phone
  if ( $PNC -> Append ( $this -> DB                                     ,
                       "`erp`.`phones`"                                 ,
                       "`erp`.`uuids`"                              ) ) {
    $RI -> set   ( "second" , $PNC -> Uuid )                            ;
    $RI -> setT2 ( "Phone"                 )                            ;
    if ( $RI -> Append ( $this -> DB , "`erp`.`relations`" ) )          {
    } else                                                              {
      $Correct = false                                                  ;
    }                                                                   ;
  } else                                                                {
    $Correct = false                                                    ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  // Append Password

  ///////////////////////////////////////////////////////////////////////
  // Append Registration Time

  ///////////////////////////////////////////////////////////////////////
  if ( $Correct ) return 1                                              ;
  ///////////////////////////////////////////////////////////////////////
  return 0                                                              ;
}

public function TutorHtml($DB)
{
  $NN = $DB -> GetName  ( "`erp`.`names`" , $this -> Uuid , 1001 , "Stage"   ) ;
  $NX = $DB -> GetName  ( "`erp`.`names`" , $this -> Uuid , 1001 , "Default" ) ;
  ////////////////////////////////////////////////////////////////////////////
  if ( strlen ( $NN ) <= 0 ) $NN = "&nbsp;"                                  ;
  if ( strlen ( $NX ) <= 0 ) $NX = "&nbsp;"                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $HTML  = new HtmlTag      (                                )               ;
  $HB    = $HTML -> asTable (                                )               ;
  $HTML -> AddPair          ( "width"       , "100%"         )               ;
  $HTML -> AddPair          ( "border"      , "1"            )               ;
  $HTML -> AddPair          ( "cellspacing" , "4"            )               ;
  $HTML -> AddPair          ( "cellpadding" , "4"            )               ;
  $HTML -> AddPair          ( "class"       , "TutorBlock"   )               ;
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $HB -> addTr     (                                )               ;
  $HD    = $HR -> addTd     (                                )               ;
  $HD   -> AddText          ( $NN                            )               ;
  ////////////////////////////////////////////////////////////////////////////
  $HI    = new HtmlTag      (                                )               ;
  $HI   -> setTag           ( "img"                          )               ;
  $HI   -> setType          ( 2                              )               ;
  $HI   -> AddPair          ( "src"    , "/images/tutor.jpg" )               ;
  $HI   -> AddPair          ( "width"  , "256"               )               ;
  $HI   -> AddPair          ( "height" , "256"               )               ;
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $HB -> addTr     (                             )                  ;
  $HD    = $HR -> addTd     (                             )                  ;
  $HD   -> AddTag           ( $HI                         )                  ;
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $HB -> addTr     (                             )                  ;
  $HD    = $HR -> addTd     (                             )                  ;
  $HD   -> AddText          ( $NX                         )                  ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTML                                                               ;
}

public function StudentBriefRow($DB,$HR)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $PeopleUsage                                                        ;
  global $PeopleStates                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $MB      = new MailBox     ( )                                             ;
  $SK      = new ImApp       ( )                                             ;
  $PN      = new PhoneNumber ( )                                             ;
  ////////////////////////////////////////////////////////////////////////////
  $MNAME   = $_SESSION [ "ACTIONS_NAME" ]                                    ;
  $SN      = $DB -> GetStudent ( "`erp`.`names`" , $this -> Uuid )           ;
  $EMN     = ""                                                              ;
  $IMN     = ""                                                              ;
  $PMN     = ""                                                              ;
  $CORRECT = 0                                                               ;
  $USED    = 1                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "select `state`,`used` from `erp`.`people` where `uuid` = {$this -> Uuid} ;" ;
  $qq      = $DB -> Query ( $QQ )                                            ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr      = $qq -> fetch_array ( MYSQLI_BOTH )                            ;
    $CORRECT = intval ( $rr [ 0 ] , 10 )                                     ;
    $USED    = intval ( $rr [ 1 ] , 10 )                                     ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ML      = $this -> GetEMails ( $DB , "`erp`.`relations`" )                ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $ML ) > 0 )                                                   {
    $MXC = array ( )                                                         ;
    foreach ( $ML as $mlx )                                                  {
      $MB -> Uuid = $mlx                                                     ;
      if ( $MB -> ObtainsByUuid ( $DB , "`erp`.`emails`" ) )                 {
        array_push ( $MXC , $MB -> Name ( ) )                                ;
      }                                                                      ;
    }                                                                        ;
    $EMN = implode ( "<br>\n" , $MXC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $IM  = $this -> GetIMs ( $DB , "`erp`.`relations`" )                       ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $IM ) > 0 )                                                   {
    $MIC = array ( )                                                         ;
    foreach ( $IM as $imx )                                                  {
      $SK -> Uuid = $imx                                                     ;
      if ( $SK -> ObtainsByUuid ( $DB , "`erp`.`instantmessage`" ) )         {
        $IMN = $SK -> AccountURL ( ) -> Content ( )                          ;
        array_push ( $MIC , $IMN )                                           ;
      }                                                                      ;
    }                                                                        ;
    $IMN = implode ( "<br>\n" , $MIC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PM  = $this -> GetPhones ( $DB , "`erp`.`relations`" )                    ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $PM ) > 0 )                                                   {
    $MPC = array ( )                                                         ;
    foreach ( $PM as $pmx )                                                  {
      $PN -> Uuid = $pmx                                                     ;
      if ( $PN -> ObtainsByUuid ( $DB , "`erp`.`phones`" ) )                 {
        if ( $PN -> isMobile ( ) )                                           {
          $PXN  = $PN -> Phone      ( )                                      ;
          $PCN  = $PN -> CallNumber ( )                                      ;
          $PCN  = str_replace ( "+" , "%2b" , $PCN )                         ;
          $PCN  = str_replace ( "-" , "%2d" , $PCN )                         ;
          $TSN  = $Translations [ "MMS::SendTo" ]                            ;
          $TSN  = str_replace     ( "$(PEOPLE)" , $SN , $TSN )               ;
          $URLX = "/managers/sms.php?Phone={$PCN}&Sender={$MNAME}&Subject={$TSN}" ;
          $URLX = htmlentities    ( $URLX          )                         ;
          $HAT  = new HtmlTag     (                )                         ;
          $HAT -> setTag          ( "a"            )                         ;
          $HAT -> AddPair         ( "href" , $URLX )                         ;
          $HAT -> AddText         ( $PXN           )                         ;
          $PMN  = $HAT -> Content (                )                         ;
          array_push ( $MPC , $PMN )                                         ;
        } else                                                               {
          $PMN = $PN -> Phone ( )                                            ;
          array_push ( $MPC , $PMN )                                         ;
        }                                                                    ;
      }                                                                      ;
    }                                                                        ;
    $PMN = implode ( "<br>\n" , $MPC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $SDBS = $Translations [ "Managers::StudentDetails" ]                       ;
  $CID  = $this -> Parameter -> PeopleString ( $this -> Uuid )               ;
  $JSC  = "StudentInfo('{$CID}') ;"                                          ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD  -> AddPair              ( "width" , "5%"                )             ;
  $HBN  = $HD     -> addButton ( $SDBS                         )             ;
  $HBN -> AddPair              ( "class"   , "SelectionButton" )             ;
  $HBN -> AddPair              ( "onclick" , $JSC              )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $CID                          )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $SN                           )             ;
  $HD   = $HR     -> addTd     ( $IMN                          )             ;
  $HD   = $HR     -> addTd     ( $EMN                          )             ;
  $HD   = $HR     -> addTd     ( $PMN                          )             ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD   = $HR     -> addTd     (                               )             ;
  ////////////////////////////////////////////////////////////////////////////
  $JSU  = "PeopleUsage(this.value,'{$CID}') ;"                               ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HS   = $HD     -> addSelection ( $PeopleUsage , $USED , "PeopleUsage" )   ;
  $HS  -> setSplitter          ( "\n"                          )             ;
  $HS  -> AddPair              ( "onchange" , $JSU             )             ;
  ////////////////////////////////////////////////////////////////////////////
  $PIX  = $CORRECT & 7                                                       ;
  $DSU  = "PeopleStates(this.value,{$CORRECT},'{$CID}') ;"                   ;
  $HD   = $HR     -> addTd     (                               )             ;
  ////////////////////////////////////////////////////////////////////////////
  $SRC  = ""                                                                 ;
  if ( $PIX > 0 ) $SRC = "/images/delete.png"                                ;
             else $SRC = "/images/yes.png"                                   ;
  $IMG  = new HtmlTag (                 )                                    ;
  $IMG -> setTag      ( "img"           )                                    ;
  $IMG -> AddPair     ( "width"  , "24" )                                    ;
  $IMG -> AddPair     ( "height" , "24" )                                    ;
  $IMG -> AddPair     ( "src"    , $SRC )                                    ;
  $HD  -> AddTag      ( $IMG            )                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HS   = $HD     -> addSelection ( $PeopleStates , $PIX , "PeopleStates" )  ;
  $HS  -> setSplitter          ( "\n"                          )             ;
  $HS  -> AddPair              ( "onchange" , $DSU             )             ;
  ////////////////////////////////////////////////////////////////////////////
}

public function TutorBriefRow($DB,$HR)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $PeopleUsage                                                        ;
  global $PeopleStates                                                       ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $TZ       = $_SESSION [ "ACTIONS_TZ" ]                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $YEARSTR  = $Translations [ "YearsString"    ]                             ;
  $OLDSTR   = $Translations [ "YearsOldString" ]                             ;
  $MONTHSTR = $Translations [ "MonthsString"   ]                             ;
  ////////////////////////////////////////////////////////////////////////////
  $MB      = new MailBox      ( )                                            ;
  $SK      = new ImApp        ( )                                            ;
  $PN      = new PhoneNumber  ( )                                            ;
  $RI      = new RelationItem ( )                                            ;
  ////////////////////////////////////////////////////////////////////////////
  $MNAME   = $_SESSION [ "ACTIONS_NAME" ]                                    ;
  $SN      = $DB -> GetTutor ( "`erp`.`names`" , $this -> Uuid )             ;
  $EMN     = ""                                                              ;
  $IMN     = ""                                                              ;
  $PMN     = ""                                                              ;
  $CORRECT = 0                                                               ;
  $USED    = 1                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "select `state`,`used` from `erp`.`people` where `uuid` = {$this -> Uuid} ;" ;
  $qq      = $DB -> Query ( $QQ )                                            ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr      = $qq -> fetch_array ( MYSQLI_BOTH )                            ;
    $CORRECT = intval ( $rr [ 0 ] , 10 )                                     ;
    $USED    = intval ( $rr [ 1 ] , 10 )                                     ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ML      = $this -> GetEMails ( $DB , "`erp`.`relations`" )                ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $ML ) > 0 )                                                   {
    $MXC = array ( )                                                         ;
    foreach ( $ML as $mlx )                                                  {
      $MB -> Uuid = $mlx                                                     ;
      if ( $MB -> ObtainsByUuid ( $DB , "`erp`.`emails`" ) )                 {
        array_push ( $MXC , $MB -> Name ( ) )                                ;
      }                                                                      ;
    }                                                                        ;
    $EMN = implode ( "<br>\n" , $MXC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $IM  = $this -> GetIMs ( $DB , "`erp`.`relations`" )                       ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $IM ) > 0 )                                                   {
    $MIC = array ( )                                                         ;
    foreach ( $IM as $imx )                                                  {
      $SK -> Uuid = $imx                                                     ;
      if ( $SK -> ObtainsByUuid ( $DB , "`erp`.`instantmessage`" ) )         {
        $IMN = $SK -> AccountURL ( ) -> Content ( )                          ;
        array_push ( $MIC , $IMN )                                           ;
      }                                                                      ;
    }                                                                        ;
    $IMN = implode ( "<br>\n" , $MIC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PM  = $this -> GetPhones ( $DB , "`erp`.`relations`" )                    ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $PM ) > 0 )                                                   {
    $MPC = array ( )                                                         ;
    foreach ( $PM as $pmx )                                                  {
      $PN -> Uuid = $pmx                                                     ;
      if ( $PN -> ObtainsByUuid ( $DB , "`erp`.`phones`" ) )                 {
        if ( $PN -> isMobile ( ) )                                           {
          $PXN  = $PN -> Phone      ( )                                      ;
          $PCN  = $PN -> CallNumber ( )                                      ;
          $PCN  = str_replace ( "+" , "%2b" , $PCN )                         ;
          $PCN  = str_replace ( "-" , "%2d" , $PCN )                         ;
          $TSN  = $Translations [ "MMS::SendTo" ]                            ;
          $TSN  = str_replace     ( "$(PEOPLE)" , $SN , $TSN )               ;
          $URLX = "/managers/sms.php?Phone={$PCN}&Sender={$MNAME}&Subject={$TSN}" ;
          $URLX = htmlentities    ( $URLX          )                         ;
          $HAT  = new HtmlTag     (                )                         ;
          $HAT -> setTag          ( "a"            )                         ;
          $HAT -> AddPair         ( "href" , $URLX )                         ;
          $HAT -> AddText         ( $PXN           )                         ;
          $PMN  = $HAT -> Content (                )                         ;
          array_push ( $MPC , $PMN )                                         ;
        } else                                                               {
          $PMN = $PN -> Phone ( )                                            ;
          array_push ( $MPC , $PMN )                                         ;
        }                                                                    ;
      }                                                                      ;
    }                                                                        ;
    $PMN = implode ( "<br>\n" , $MPC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $TEAM   = ""                                                               ;
  $RI    -> set         ( "second" , $this -> Uuid )                         ;
  $RI    -> setT1       ( "People"                 )                         ;
  $RI    -> setT2       ( "People"                 )                         ;
  $RI    -> setRelation ( "Subordination"          )                         ;
  $LEADER = $RI -> GetOwners ( $DB , "`erp`.`relations`" )                   ;
  if ( count ( $LEADER ) > 0 )                                               {
    $RL   = $LEADER [ 0 ]                                                    ;
    $TEAM = $DB -> GetTutor ( "`erp`.`names`" , $RL )                        ;
  } else                                                                     {
    $RI     -> set                  ( "first" , $this -> Uuid   )            ;
    $RI     -> setT1                ( "People"                  )            ;
    $RI     -> setT2                ( "People"                  )            ;
    $RI     -> setRelation          ( "Subordination"           )            ;
    $MEMBERS = $RI -> Subordination ( $DB , "`erp`.`relations`" )            ;
    if                              ( count ( $MEMBERS ) > 0    )            {
      $TEAM = $Translations [ "Tutors::Crew" ]                               ;
      $TEAM = str_replace ( "$(TOTAL)" , count ( $MEMBERS ) , $TEAM )        ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PQ     = NewParameter       ( 0 , 23 , "Status"                         ) ;
  $PQ    -> setTable           ( "`erp`.`parameters`"                      ) ;
  $LEVEL  = $PQ -> Value       ( $DB , $this -> Uuid , "Level"             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $PQ     = NewParameter       ( 1 , 14 , "Onboard"                        ) ;
  $PQ    -> setTable           ( "`erp`.`parameters`"                      ) ;
  $ONDT   = $PQ -> Data        ( $DB , $this -> Uuid , "Tutor"             ) ;
  if                           ( strlen ( $ONDT ) > 0                      ) {
    $UTS  = UntilToday         ( $ONDT , $TZ , $YEARSTR , $MONTHSTR        ) ;
    $ONDT = "{$ONDT} ({$UTS})"                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PQ     = NewParameter       ( 1 , 14 , "Birthday"                       ) ;
  $PQ    -> setTable           ( "`erp`.`parameters`"                      ) ;
  $BIRTH  = $PQ -> Data        ( $DB , $this -> Uuid , "Tutor"             ) ;
  if                           ( strlen ( $BIRTH ) > 0                     ) {
    $UTS  = UntilToday         ( $BIRTH , $TZ , $OLDSTR  , $MONTHSTR       ) ;
    $BIRTH = "{$BIRTH} ({$UTS})"                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $SDBS = $Translations [ "Managers::TutorDetails" ]                         ;
  $CID  = $this -> Parameter -> PeopleString ( $this -> Uuid )               ;
  $JSC  = "TutorInfo('{$CID}') ;"                                            ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     (                               )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  $HBN  = $HD     -> addButton ( $SDBS                         )             ;
  $HBN -> AddPair              ( "class"   , "TutorButton"     )             ;
  $HBN -> AddPair              ( "onclick" , $JSC              )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $CID                          )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $SN                           )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $TEAM                         )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $IMN                          )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $EMN                          )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $PMN                          )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $LEVEL                        )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  $HD  -> AddPair              ( "align"   , "center"          )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $ONDT                         )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $BIRTH                        )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  // 平均得分
  $HD   = $HR     -> addTd     (                               )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  // 授課種類
  $PQ     = NewParameter    ( 2 , 37 , "Teaching"            )               ;
  $PQ    -> setTable        ( "`erp`.`parameters`"           )               ;
  $COURSEX  = $PQ -> Data   ( $DB , $this -> Uuid , "Courses" )              ;
  if                           ( strlen ( $COURSEX ) > 0                   ) {
    $HD = $HR     -> addTd     ( $CourseListings [ $COURSEX ]              ) ;
  } else                                                                     {
    $HD = $HR     -> addTd     (                                           ) ;
  }                                                                          ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
  $JSU  = "PeopleUsage(this.value,'{$CID}') ;"                               ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  $HS   = $HD     -> addSelection ( $PeopleUsage , $USED , "PeopleUsage" )   ;
  $HS  -> setSplitter          ( "\n"                          )             ;
  $HS  -> AddPair              ( "onchange" , $JSU             )             ;
  ////////////////////////////////////////////////////////////////////////////
  $PIX  = $CORRECT & 7                                                       ;
  $DSU  = "PeopleStates(this.value,{$CORRECT},'{$CID}') ;"                   ;
  $HD   = $HR     -> addTd     (                               )             ;
  ////////////////////////////////////////////////////////////////////////////
  $SRC  = ""                                                                 ;
  if ( $PIX > 0 ) $SRC = "/images/delete.png"                                ;
             else $SRC = "/images/yes.png"                                   ;
  $IMG  = new HtmlTag (                 )                                    ;
  $IMG -> setTag      ( "img"           )                                    ;
  $IMG -> AddPair     ( "width"  , "24" )                                    ;
  $IMG -> AddPair     ( "height" , "24" )                                    ;
  $IMG -> AddPair     ( "src"    , $SRC )                                    ;
  $HD  -> AddTag      ( $IMG            )                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HS   = $HD     -> addSelection ( $PeopleStates , $PIX , "PeopleStates" )  ;
  $HS  -> setSplitter          ( "\n"                          )             ;
  $HS  -> AddPair              ( "onchange" , $DSU             )             ;
  $HD  -> NoWrap               (                               )             ;
  $HD  -> AddPair              ( "width"   , "1%"              )             ;
  if ( 1 != $USED ) $HD  -> AddPair ( "bgcolor" , "#dddddd"    )             ;
  ////////////////////////////////////////////////////////////////////////////
}

public function ReceptionistBriefRow($DB,$HR)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $PeopleUsage                                                        ;
  global $PeopleStates                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $MB      = new MailBox     ( )                                             ;
  $SK      = new ImApp       ( )                                             ;
  $PN      = new PhoneNumber ( )                                             ;
  ////////////////////////////////////////////////////////////////////////////
  $MNAME   = $_SESSION [ "ACTIONS_NAME" ]                                    ;
  $SN      = $DB -> GetStudent ( "`erp`.`names`" , $this -> Uuid )           ;
  $EMN     = ""                                                              ;
  $IMN     = ""                                                              ;
  $PMN     = ""                                                              ;
  $CORRECT = 0                                                               ;
  $USED    = 1                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "select `state`,`used` from `erp`.`people` where `uuid` = {$this -> Uuid} ;" ;
  $qq      = $DB -> Query ( $QQ )                                            ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr      = $qq -> fetch_array ( MYSQLI_BOTH )                            ;
    $CORRECT = intval ( $rr [ 0 ] , 10 )                                     ;
    $USED    = intval ( $rr [ 1 ] , 10 )                                     ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ML      = $this -> GetEMails ( $DB , "`erp`.`relations`" )                ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $ML ) > 0 )                                                   {
    $MXC = array ( )                                                         ;
    foreach ( $ML as $mlx )                                                  {
      $MB -> Uuid = $mlx                                                     ;
      if ( $MB -> ObtainsByUuid ( $DB , "`erp`.`emails`" ) )                 {
        array_push ( $MXC , $MB -> Name ( ) )                                ;
      }                                                                      ;
    }                                                                        ;
    $EMN = implode ( "<br>\n" , $MXC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $IM  = $this -> GetIMs ( $DB , "`erp`.`relations`" )                       ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $IM ) > 0 )                                                   {
    $MIC = array ( )                                                         ;
    foreach ( $IM as $imx )                                                  {
      $SK -> Uuid = $imx                                                     ;
      if ( $SK -> ObtainsByUuid ( $DB , "`erp`.`instantmessage`" ) )         {
        $IMN = $SK -> AccountURL ( ) -> Content ( )                          ;
        array_push ( $MIC , $IMN )                                           ;
      }                                                                      ;
    }                                                                        ;
    $IMN = implode ( "<br>\n" , $MIC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PM  = $this -> GetPhones ( $DB , "`erp`.`relations`" )                    ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $PM ) > 0 )                                                   {
    $MPC = array ( )                                                         ;
    foreach ( $PM as $pmx )                                                  {
      $PN -> Uuid = $pmx                                                     ;
      if ( $PN -> ObtainsByUuid ( $DB , "`erp`.`phones`" ) )                 {
        if ( $PN -> isMobile ( ) )                                           {
          $PXN  = $PN -> Phone      ( )                                      ;
          $PCN  = $PN -> CallNumber ( )                                      ;
          $PCN  = str_replace ( "+" , "%2b" , $PCN )                         ;
          $PCN  = str_replace ( "-" , "%2d" , $PCN )                         ;
          $TSN  = $Translations [ "MMS::SendTo" ]                            ;
          $TSN  = str_replace     ( "$(PEOPLE)" , $SN , $TSN )               ;
          $URLX = "/managers/sms.php?Phone={$PCN}&Sender={$MNAME}&Subject={$TSN}" ;
          $URLX = htmlentities    ( $URLX          )                         ;
          $HAT  = new HtmlTag     (                )                         ;
          $HAT -> setTag          ( "a"            )                         ;
          $HAT -> AddPair         ( "href" , $URLX )                         ;
          $HAT -> AddText         ( $PXN           )                         ;
          $PMN  = $HAT -> Content (                )                         ;
          array_push ( $MPC , $PMN )                                         ;
        } else                                                               {
          $PMN = $PN -> Phone ( )                                            ;
          array_push ( $MPC , $PMN )                                         ;
        }                                                                    ;
      }                                                                      ;
    }                                                                        ;
    $PMN = implode ( "<br>\n" , $MPC )                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $SDBS = $Translations [ "Managers::ReceptionistDetails" ]                  ;
  $CID  = $this -> Parameter -> PeopleString ( $this -> Uuid )               ;
  $JSC  = "ReceptionistInfo('{$CID}') ;"                                     ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD  -> AddPair              ( "width" , "5%"                )             ;
  $HBN  = $HD     -> addButton ( $SDBS                         )             ;
  $HBN -> AddPair              ( "class"   , "SelectionButton" )             ;
  $HBN -> AddPair              ( "onclick" , $JSC              )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $CID                          )             ;
  ////////////////////////////////////////////////////////////////////////////
  $HD   = $HR     -> addTd     ( $SN                           )             ;
  $HD   = $HR     -> addTd     ( $IMN                          )             ;
  $HD   = $HR     -> addTd     ( $EMN                          )             ;
  $HD   = $HR     -> addTd     ( $PMN                          )             ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HD   = $HR     -> addTd     (                               )             ;
  ////////////////////////////////////////////////////////////////////////////
  $JSU  = "PeopleUsage(this.value,'{$CID}') ;"                               ;
  $HD   = $HR     -> addTd     (                               )             ;
  $HS   = $HD     -> addSelection ( $PeopleUsage , $USED , "PeopleUsage" )   ;
  $HS  -> setSplitter          ( "\n"                          )             ;
  $HS  -> AddPair              ( "onchange" , $JSU             )             ;
  ////////////////////////////////////////////////////////////////////////////
  $PIX  = $CORRECT & 7                                                       ;
  $DSU  = "PeopleStates(this.value,{$CORRECT},'{$CID}') ;"                   ;
  $HD   = $HR     -> addTd     (                               )             ;
  ////////////////////////////////////////////////////////////////////////////
  $SRC  = ""                                                                 ;
  if ( $PIX > 0 ) $SRC = "/images/delete.png"                                ;
             else $SRC = "/images/yes.png"                                   ;
  $IMG  = new HtmlTag (                 )                                    ;
  $IMG -> setTag      ( "img"           )                                    ;
  $IMG -> AddPair     ( "width"  , "24" )                                    ;
  $IMG -> AddPair     ( "height" , "24" )                                    ;
  $IMG -> AddPair     ( "src"    , $SRC )                                    ;
  $HD  -> AddTag      ( $IMG            )                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HS   = $HD     -> addSelection ( $PeopleStates , $PIX , "PeopleStates" )  ;
  $HS  -> setSplitter          ( "\n"                          )             ;
  $HS  -> AddPair              ( "onchange" , $DSU             )             ;
  ////////////////////////////////////////////////////////////////////////////
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

public function JoinTeam($TBODY,$NAME,$MSG="People::Authorization")
{
  //////////////////////////////////////////////////////////////
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  $CS  = "AcceptSupervised('{$this->Uuid}',true) ;"            ;
  $CR  = "AcceptSupervised('{$this->Uuid}',false) ;"           ;
  //////////////////////////////////////////////////////////////
  $PID = $this -> Parameter -> PeopleString ( $this -> Uuid  ) ;
  $NS  = "{$NAME}({$PID})"                                     ;
  $NX  = $Translations [ $MSG ]                                ;
  $NS  = str_replace         ( "$(NAME)" , $NS , $NX         ) ;
  //////////////////////////////////////////////////////////////
  $HR  = $TBODY -> addTr     (                               ) ;
  //////////////////////////////////////////////////////////////
  $HD  = $HR    -> addTd     ( $NS                           ) ;
  //////////////////////////////////////////////////////////////
  $HD  = $HR    -> addTd     (                               ) ;
  $HD -> AddPair             ( "nowrap"  , "nowrap"          ) ;
  $HD -> AddPair             ( "width"   , "4%"              ) ;
  $HD -> AddPair             ( "align"   , "right"           ) ;
  $HU  = $HD    -> addButton ( $Translations [ "Accept"  ]   ) ;
  $HU -> AddPair             ( "class"   , "SelectionButton" ) ;
  $HU -> AddPair             ( "onclick" , $CS               ) ;
  //////////////////////////////////////////////////////////////
  $HD  = $HR    -> addTd     (                               ) ;
  $HD -> AddPair             ( "nowrap"  , "nowrap"          ) ;
  $HD -> AddPair             ( "width"   , "4%"              ) ;
  $HD -> AddPair             ( "align"   , "left"            ) ;
  $HU  = $HD    -> addButton ( $Translations [ "Decline" ]   ) ;
  $HU -> AddPair             ( "class"   , "SelectionButton" ) ;
  $HU -> AddPair             ( "onclick" , $CR               ) ;
  //////////////////////////////////////////////////////////////
}

public function PartnerInvitations()
{
  ///////////////////////////////////////////////////////////////////////
  global $Translations                                                  ;
  ///////////////////////////////////////////////////////////////////////
  $LX  = $this -> GetOwners     ( $this -> DB                           ,
                                  "`erp`.`relations`"                   ,
                                  "desc"                                ,
                                  "Action"                            ) ;
  ///////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag            (                                     ) ;
  if                            ( count ( $LX ) > 0                   ) {
    $HB = $HX -> ConfigureTable ( 1 , 0 , 0                           ) ;
    /////////////////////////////////////////////////////////////////////
    foreach                     ( $LX as $uu                          ) {
      $NN    = $this -> DB -> GetStudent ( "`erp`.`names`" , $uu      ) ;
      $this -> Uuid = $uu                                               ;
      $this -> JoinTeam         ( $HB , $NN , "People::Authorization" ) ;
    }                                                                   ;
    /////////////////////////////////////////////////////////////////////
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  return $HX                                                            ;
}

public function TutorInvitations()
{
  /////////////////////////////////////////////////////////////////////////
  global $Translations                                                    ;
  /////////////////////////////////////////////////////////////////////////
  $LX  = $this -> GetOwners            ( $this -> DB                      ,
                                         "`erp`.`relations`"              ,
                                         "desc"                           ,
                                         "Action"                       ) ;
  /////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag                   (                                ) ;
  if                                   ( count ( $LX ) > 0              ) {
    $HB = $HX -> ConfigureTable        ( 1 , 0 , 0                      ) ;
    ///////////////////////////////////////////////////////////////////////
    foreach                            ( $LX as $uu                     ) {
      $NN    = $this -> DB -> GetTutor ( "`erp`.`names`" , $uu          ) ;
      $this -> Uuid = $uu                                                 ;
      $this -> JoinTeam                ( $HB , $NN , "People::JoinTeam" ) ;
    }                                                                     ;
    ///////////////////////////////////////////////////////////////////////
  }                                                                       ;
  /////////////////////////////////////////////////////////////////////////
  return $HX                                                              ;
}

public function JoinMoment($DB,$RI,$TABLE)
{
  $RI -> set                ( "second"  , $this -> Uuid )              ;
  $QQ  = "select `ltime` from {$TABLE} " . $RI -> ExactItem ( ) . " ;" ;
  $qq  = $DB -> Query       ( $QQ                       )              ;
  $rr  = $qq -> fetch_array ( MYSQLI_BOTH               )              ;
  return $rr [ 0 ]                                                     ;
}

public function addCell($HR,$MSG)
{
  $HD  = $HR -> addTd ( $MSG                ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap" ) ;
  return $HD                                  ;
}

public function ActionsTd($HR)
{
  $PID = $this -> Parameter -> PeopleString ( $this -> Uuid ) ;
  return $this -> addCell                   ( $HR , $PID    ) ;
}

public function MemberButton($HR,$BTN,$JS,$BTNCLASS="SelectionButton")
{
  /////////////////////////////////////////////////////////////
  global $Translations                                        ;
  /////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd     (                                 ) ;
  $HD -> AddPair          ( "nowrap"  , "nowrap"            ) ;
  $HD -> AddPair          ( "align"   , "right"             ) ;
  $HU  = $HD -> addButton ( $Translations [ $BTN ]          ) ;
  $HU -> AddPair          ( "class"   , $BTNCLASS           ) ;
  $HU -> AddPair          ( "onclick" , $JS                 ) ;
  /////////////////////////////////////////////////////////////
}

public function ShortMemberLine($HR,$NAME,$DATETIME,$JS,$BTN,$BTNCLASS="SelectionButton")
{
  ////////////////////////////////////////////////////////
  $this -> ActionsTd    ( $HR                          ) ;
  $this -> addCell      ( $HR , $NAME                  ) ;
  $this -> addCell      ( $HR , $DATETIME              ) ;
  $this -> MemberButton ( $HR , $BTN , $JS , $BTNCLASS ) ;
  ////////////////////////////////////////////////////////
}

public function RequestMember($DB,$RI,$NAME,$RELATION,$HR)
{
  ///////////////////////////////////////////////////////////////////////
  $CS    = "CancelSupervised('{$this->Uuid}',7) ;"                      ;
  $DD    = $this -> JoinMoment ( $DB , $RI , $RELATION )                ;
  $NN    = $DB   -> GetStudent ( $NAME , $this -> Uuid )                ;
  ///////////////////////////////////////////////////////////////////////
  $this -> ShortMemberLine ($HR,$NN,$DD,$CS,"Cancel","SelectionButton") ;
}

public function SuperviseMember($DB,$RI,$NAME,$RELATION,$HR)
{
  ///////////////////////////////////////////////////////////////////////
  $CS    = "RemoveSupervised('{$this->Uuid}',1) ;"                      ;
  $DD    = $this -> JoinMoment ( $DB , $RI , $RELATION )                ;
  $NN    = $DB   -> GetStudent ( $NAME , $this -> Uuid )                ;
  ///////////////////////////////////////////////////////////////////////
  $this -> ShortMemberLine ($HR,$NN,$DD,$CS,"Remove","SelectionButton") ;
}

public function RequestTutor($DB,$RI,$NAME,$RELATION,$HR)
{
  ///////////////////////////////////////////////////////////////////////
  $CS    = "CancelSupervised('{$this->Uuid}',7) ;"                      ;
  $DD    = $this -> JoinMoment ( $DB , $RI , $RELATION )                ;
  $NN    = $DB   -> GetTutor   ( $NAME , $this -> Uuid )                ;
  ///////////////////////////////////////////////////////////////////////
  $this -> ShortMemberLine ($HR,$NN,$DD,$CS,"Cancel","SelectionButton") ;
}

public function SectionHeader($HR,$TITLE,$COLSPAN)
{
  //////////////////////////////////////////////////
  global $Translations                             ;
  //////////////////////////////////////////////////
  $HD  = $HR -> addTd (                          ) ;
  $HD -> AddPair      ( "width"   , "100%"       ) ;
  $HD -> SafePair     ( "colspan" , $COLSPAN     ) ;
  $HD -> AddPair      ( "align"   , "center"     ) ;
  $HD -> AddText      ( $Translations [ $TITLE ] ) ;
}

public function MemberHeader($HR,$MOMENT)
{
  ////////////////////////////////////////////////////////
  global $Translations                                   ;
  ////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $Translations [ "ActionsID"  ] ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap"            ) ;
  $HD -> AddPair      ( "width"  ,  "3%"               ) ;
  $HD -> AddPair      ( "align"  , "center"            ) ;
  ////////////////////////////////////////////////////////
  $HD  = $HR -> addTd (  $Translations [ "NameLabel" ] ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap"            ) ;
  $HD -> AddPair      ( "width"  , "20%"               ) ;
  $HD -> AddPair      ( "align"  , "center"            ) ;
  ////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $Translations [ $MOMENT      ] ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap"            ) ;
  $HD -> AddPair      ( "width"  , "20%"               ) ;
  $HD -> AddPair      ( "align"  , "center"            ) ;
  ////////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                                ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap"            ) ;
  $HD -> AddPair      ( "width"  , "1%"                ) ;
}

public function ListMembers($DB,$FUNC,$PUID,$LIST,$NAME,$RELATION,$TYPE,$HB,$HEADER,$MOMENT)
{
  ///////////////////////////////////////////////////////////////////
  $HR    = $HB  -> addTr    (                                     ) ;
  $this -> SectionHeader    ( $HR     , $HEADER , "4"             ) ;
  ///////////////////////////////////////////////////////////////////
  $HR    = $HB  -> addTr    (                                     ) ;
  $this -> MemberHeader     ( $HR     , $MOMENT                   ) ;
  ///////////////////////////////////////////////////////////////////
  $RI    = new RelationItem (                                     ) ;
  $RI   -> set              ( "first" , $PUID                     ) ;
  $RI   -> setT1            ( "People"                            ) ;
  $RI   -> setT2            ( "People"                            ) ;
  $RI   -> setRelation      ( $TYPE                               ) ;
  ///////////////////////////////////////////////////////////////////
  foreach                   ( $LIST as $uu                        ) {
    $HR    = $HB  -> addTr  (                                     ) ;
    $this -> Uuid  = $uu                                            ;
    $this -> $FUNC          ( $DB , $RI , $NAME , $RELATION , $HR ) ;
  }                                                                 ;
}

public function AddTeamMember()
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $HTX   = new HtmlTag            (                                        ) ;
  $HTB   = $HTX -> ConfigureTable (                                        ) ;
  $HR    = $HTB -> addTr          (                                        ) ;
  $HR   -> setSplitter            ( "\n"                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增成員按鈕
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "People::AddTeamMember" ]                         ;
  $HD    = $HR  -> addTd          (                                        ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HD   -> AddPair                ( "width"   , "1%"                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $BTN   = $HD  -> addButton      ( $MSG                                   ) ;
  $BTN  -> AddPair                ( "class"   , "SelectionButton"          ) ;
  $BTN  -> AddPair                ( "onclick" , "AddSupervised() ;"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  // Actions ID
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "ActionsID:" ]                                    ;
  $HD    = $HR  -> addTd          ( $MSG                                   ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HD   -> AddPair                ( "width"   , "1%"                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR  -> addTd          (                                        ) ;
  $HINP  = $HD  -> addInput       (                                        ) ;
  $HINP -> AddPair                ( "type"    , "text"                     ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HINP -> AddPair                ( "id"      , "ActionsID"                ) ;
  $HINP -> AddPair                ( "class"   , "NameInput"                ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 即時通帳號
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "Managers::InstantMessage" ]                      ;
  $HD    = $HR  -> addTd          ( $MSG                                   ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HD   -> AddPair                ( "width"   , "1%"                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR  -> addTd          (                                        ) ;
  $HINP  = $HD  -> addInput       (                                        ) ;
  $HINP -> AddPair                ( "type"    , "text"                     ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HINP -> AddPair                ( "id"      , "SuperviseIM"              ) ;
  $HINP -> AddPair                ( "class"   , "NameInput"                ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 電子郵件
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "Managers::EMail" ]                               ;
  $HD    = $HR  -> addTd          ( $MSG                                   ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HD   -> AddPair                ( "width"   , "1%"                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR  -> addTd          (                                        ) ;
  $HINP  = $HD  -> addInput       (                                        ) ;
  $HINP -> AddPair                ( "type"    , "text"                     ) ;
  $HD   -> AddPair                ( "nowrap"  , "nowrap"                   ) ;
  $HINP -> AddPair                ( "id"      , "SuperviseEmail"           ) ;
  $HINP -> AddPair                ( "class"   , "NameInput"                ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTX                                                                ;
}

// 內定語言列表
public function addLanguage()
{
  global $LanguageNames                                  ;
  ////////////////////////////////////////////////////////
  $LL  = array_keys          ( $LanguageNames          ) ;
  $HS  = new HtmlTag         (                         ) ;
  $HS -> setTag              ( "select"                ) ;
  $HS -> setSplitter         ( "\n"                    ) ;
  ////////////////////////////////////////////////////////
  foreach                    ( $LL as $L               ) {
    $HO   = $HS -> addOption (                         ) ;
    if                       ( $L == $this -> Language ) {
      $HO -> AddMember       ( "selected"              ) ;
    }                                                    ;
    $HO   -> AddPair         ( "value" , $L            ) ;
    $HO   -> AddText         ( $LanguageNames [ $L ]   ) ;
  }                                                      ;
  ////////////////////////////////////////////////////////
  return $HS                                             ;
}

// 語言選單
public function addDefaultLanguage($URL,$ID="SetLanguage",$CLASSID="SetLanguage")
{
  $SHJ  = "assignLanguageJS('{$this->Uuid}',this.value,'{$URL}')" ;
  /////////////////////////////////////////////////////////////////
  $SDL  = $this -> addLanguage (                       )          ;
  $SDL -> AddPair              ( "id"       , $ID      )          ;
  $SDL -> AddPair              ( "class"    , $CLASSID )          ;
  $SDL -> AddPair              ( "onchange" , $SHJ     )          ;
  /////////////////////////////////////////////////////////////////
  return $SDL                                                     ;
}

public function addTimeZone($DB,$TzMenu,$TzClass="",$RootURL="")
{
  ///////////////////////////////////////////////////////////////////////
  global $ActionsTimeZone                                               ;
  ///////////////////////////////////////////////////////////////////////
  if                         ( strlen ( $RootURL ) > 0                ) {
    $JSC = "TimeZoneChanged(this.value,'{$this->Uuid}','{$RootURL}') ;" ;
  } else                                                                {
    $JSC = "TimeZoneChanged(this.value,'{$this->Uuid}') ;"              ;
  }                                                                     ;
  ///////////////////////////////////////////////////////////////////////
  $TZ  = new TimeZones       (                                        ) ;
  $TZ -> Query               ( $DB , "`erp`.`timezones`"              ) ;
  $CT  = $TZ -> GetTimeZone  ( $DB                                      ,
                              "`erp`.`relations`"                       ,
                              $this -> Uuid                             ,
                              $ActionsTimeZone                        ) ;
  $HS  = $TZ -> addSelection ( $CT , $TzMenu , $TzClass               ) ;
  $HS -> AddPair             ( "onchange" , $JSC                      ) ;
  ///////////////////////////////////////////////////////////////////////
  unset                      ( $TZ                                    ) ;
  ///////////////////////////////////////////////////////////////////////
  return $HS                                                            ;
}

public function AssignSexuality($DB)
{
  ////////////////////////////////////////////////////////////////////
  global $SexualityNames                                             ;
  ////////////////////////////////////////////////////////////////////
  $ACT  = GetParameterPersonal ( $DB , $this -> Uuid , "Sexuality" ) ;
  $JSC  = "setSexuality(this.value,'{$this->Uuid}')"                 ;
  ////////////////////////////////////////////////////////////////////
  $HZX  = new HtmlTag          (                                   ) ;
  $HZX -> setTag               ( "select"                          ) ;
  $HZX -> AddPair              ( "onchange"      , $JSC            ) ;
  $HZX -> setSplitter          ( "\n"                              ) ;
  $HZX -> AddPair              ( "id" , "SexualitySelection"       ) ;
  $HZX -> addOptions           ( $SexualityNames , $ACT            ) ;
  ////////////////////////////////////////////////////////////////////
  return $HZX                                                        ;
}

public function IconID($DB)
{
  $DID = "3800000000000000041"                              ;
  ///////////////////////////////////////////////////////////
  $RI  = new RelationItem     (                           ) ;
  $RI -> set                  ( "first" , $this -> Uuid   ) ;
  $RI -> setT1                ( "People"                  ) ;
  $RI -> setT2                ( "Picture"                 ) ;
  $RI -> setRelation          ( "Using"                   ) ;
  $UX  = $RI -> Subordination ( $DB , "`erp`.`relations`" ) ;
  if ( count ( $UX ) > 0 ) $DID = $UX [ 0 ]                 ;
  ///////////////////////////////////////////////////////////
  return $DID                                               ;
}

public function IconPath($ICONPATH,$DID,$WIDTH=128,$HEIGHT=128)
{
  $SRC = "{$ICONPATH}?ID={$DID}"            ;
  $HI  = new HtmlTag (                    ) ;
  $HI -> setTag      ( "img"              ) ;
  $HI -> AddPair     ( "width"  , $WIDTH  ) ;
  $HI -> AddPair     ( "height" , $HEIGHT ) ;
  $HI -> AddPair     ( "src"    , $SRC    ) ;
  return $HI                                ;
}

public function IconTable($DB,$ICONPATH)
{
  ////////////////////////////////////////////////////////////////
  $DID = $this -> IconID      ( $DB                            ) ;
  $PIC = new Picture          (                                ) ;
  ////////////////////////////////////////////////////////////////
  $HT  = new HtmlTag          (                                ) ;
  $HT -> setTag               ( "div"                          ) ;
  $HT -> setSplitter          ( "\n"                           ) ;
  $HT -> AddPair              ( "id"     , "PersonalIcon"      ) ;
  ////////////////////////////////////////////////////////////////
  $HV  = $HT -> addHtml       ( "div"                          ) ;
  $HV -> AddPair              ( "id"     , "PersonalImage"     ) ;
  ////////////////////////////////////////////////////////////////
  $HI  = $this -> IconPath    ( $ICONPATH , $DID , 128 , 128   ) ;
  $HV -> AddTag               ( $HI                            ) ;
  ////////////////////////////////////////////////////////////////
  $HT -> AddText              ( "<br>"                         ) ;
  ////////////////////////////////////////////////////////////////
  $HX  = $HT -> addDiv        (                                ) ;
  $HX -> AddTag               ( $PIC -> UploadForm ( )         ) ;
  ////////////////////////////////////////////////////////////////
  return $HT                                                     ;
}

public function PeopleIcon($DB,$ICON,$VIEW,$WIDTH="144px")
{
  $UITX  = $this -> IconTable ( $DB      , $VIEW    ) ;
  $ICON -> AddPair            ( "id"     , "IconTD" ) ;
  $ICON -> AddPair            ( "align"  , "center" ) ;
  $ICON -> AddPair            ( "valign" , "top"    ) ;
  $ICON -> AddPair            ( "width"  , $WIDTH   ) ;
  $ICON -> AddTag             ( $UITX               ) ;
}

public function PictureDIV($PATH,$PUID)
{
 return $this -> IconPath   ( $PATH ,
                              $PUID ,
                              128   ,
                              128 ) ;
}

public function PictureBlock($DB,$TABLE,$PATH,$DIV)
{
  $PC     = $this -> GetObjects ( $DB                   ,
                                  $TABLE                ,
                                  "Picture"             ,
                                  "Subordination"     ) ;
  foreach                       ( $PC as $px          ) {
    $JSX  = "ViewFullPicture('{$px}') ;"                ;
    $IMG  = $this -> PictureDIV ( $PATH        , $px  ) ;
    $IMG -> AddPair             ( "ondblclick" , $JSX ) ;
    $DIV -> AddTag              ( $IMG                ) ;
  }                                                     ;
}

public function GalleryTable($DB,$PATH)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $HTAB   = new HtmlTag               (                                    ) ;
  $MBODY  = $HTAB   -> ConfigureTable ( 1 , 0 , 0                          ) ;
  $HR     = $MBODY  -> addTr          (                                    ) ;
  $HR    -> setSplitter               ( "\n"                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG    = $Translations [ "Picture::Galleries" ]                           ;
  $HD     = $HR     -> addTd          ( $MSG                               ) ;
  $HD    -> AddPair                   ( "align"   , "center"               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD     = $HR     -> addTd          (                                    ) ;
  $HD    -> AddPair                   ( "nowrap"  , "nowrap"               ) ;
  $HD    -> AddPair                   ( "align"   , "right"                ) ;
  $HD    -> AddPair                   ( "width"   , "2%"                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $FRM    = new HtmlTag               (                                    ) ;
  $FRM   -> setTag                    ( "form"                             ) ;
  $FRM   -> setSplitter               ( "\n"                               ) ;
  $FRM   -> AddPair                   ( "id"      , "galleryForm"          ) ;
  $FRM   -> AddPair                   ( "method"  , "POST"                 ) ;
  $FRM   -> AddPair                   ( "enctype" , "multipart/form-data"  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $LABEL  = $FRM    -> addHtml        (                                    ) ;
  $LABEL -> setTag                    ( "label"                            ) ;
  $LABEL -> setSplitter               ( "\n"                               ) ;
  $LABEL -> AddPair                   ( "id"      , "inputGallery"         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC     = "UploadGallery('galleryForm') ;"                                ;
  $INP     = $LABEL -> addInput       (                                    ) ;
  $INP    -> AddPair                  ( "type"     , "file"                ) ;
  $INP    -> AddPair                  ( "id"       , "uploadGallery"       ) ;
  $INP    -> AddPair                  ( "name"     , "uploadGallery"       ) ;
  $INP    -> AddPair                  ( "style"    , "display: none;"      ) ;
  $INP    -> AddPair                  ( "onchange" , $JSC                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ "Picture::Gallery" ]                            ;
  $IUI     = $LABEL -> addHtml        (                                    ) ;
  $IUI    -> setTag                   ( "i"                                ) ;
  $IUI    -> AddPair                  ( "class" , "fa fa-photo"            ) ;
  $IUI    -> AddText                  ( "&nbsp;"                           ) ;
  $IUI    -> AddText                  ( $MSG                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD     -> AddTag                   ( $FRM                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR      = $MBODY -> addTr          (                                    ) ;
  $HR     -> setSplitter              ( "\n"                               ) ;
  $HBAR    = $HR    -> addTd          (                                    ) ;
  $HBAR   -> AddPair                  ( "colspan" , "2"                    ) ;
  $HBAR   -> AddPair                  ( "id"      , "GalleryBar"           ) ;
  $HBAR   -> AddPair                  ( "width"   , "100%"                 ) ;
  $HXIV    = $HBAR  -> addDiv         ( ""        , "GalleryProgress"      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR      = $MBODY -> addTr          (                                    ) ;
  $HR     -> setSplitter              ( "\n"                               ) ;
  $HDIV    = $HR    -> addTd          (                                    ) ;
  $HDIV   -> AddPair                  ( "colspan" , "2"                    ) ;
  $HDIV   -> AddPair                  ( "id"      , "Gallery"              ) ;
  $HDIV   -> setSplitter              ( "\n"                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $this   -> PictureBlock             ( $DB                                  ,
                                        "`erp`.`relations`"                  ,
                                        $PATH                                ,
                                        $HDIV                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTAB                                                               ;
}

public function ShowGallery($DB,$PATH)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $HTAB   = new HtmlTag               (                                    ) ;
  $MBODY  = $HTAB   -> ConfigureTable ( 0 , 0 , 0                          ) ;
//  $HR     = $MBODY  -> addTr          (                                    ) ;
//  $HR    -> setSplitter               ( "\n"                               ) ;
  ////////////////////////////////////////////////////////////////////////////
//  $MSG    = $Translations [ "Picture::Galleries" ]                           ;
//  $HD     = $HR     -> addTd          ( $MSG                               ) ;
//  $HD    -> AddPair                   ( "align"   , "center"               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR      = $MBODY -> addTr          (                                    ) ;
  $HR     -> setSplitter              ( "\n"                               ) ;
  $HDIV    = $HR    -> addTd          (                                    ) ;
  $HDIV   -> AddPair                  ( "id"      , "Gallery"              ) ;
  $HDIV   -> setSplitter              ( "\n"                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $PC      = $this -> GetObjects      ( $DB                                  ,
                                        "`erp`.`relations`"                  ,
                                        "Picture"                            ,
                                        "Subordination"                    ) ;
  foreach                             ( $PC as $px                         ) {
    $JSX   = "ViewFullPicture('{$px}') ;"                                    ;
    $IMG   = $this -> PictureDIV      ( $PATH , $px                        ) ;
    $HDIV -> AddTag                   ( $IMG                               ) ;
    $IMG  -> AddPair                  ( "ondblclick" , $JSX                ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTAB                                                               ;
}

public function addChineseColumn($DB,$HR,$KEY="Registration::Chinese")
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $EnglishId                                                          ;
  global $LanguageId                                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $NI      = new NameItem         (                                        ) ;
  $NI     -> AddColumn            ( "uuid"                                 ) ;
  $NI     -> AddColumn            ( "locality"                             ) ;
  $NI     -> AddColumn            ( "priority"                             ) ;
  $NI     -> AddColumn            ( "relevance"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NI     -> set                  ( "uuid"     , $this -> Uuid             ) ;
  $NI     -> set                  ( "locality" , $LanguageId               ) ;
  $NI     -> set                  ( "priority" , "0"                       ) ;
  $NI     -> setRelevance         ( "Default"                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = $NI -> SelectColumns ( "`erp`.`names`"                        ) ;
  $qq      = $DB -> Query         ( $QQ                                    ) ;
  $NI -> Name = ""                                                           ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr  = $qq -> fetch_array ( MYSQLI_BOTH )                                ;
    $NI -> obtain ( $rr )                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ $KEY ]                                          ;
  $HD      = $HR -> addNameTd     ( $MSG , "3%"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD      = $HR      -> addTd    (                                        ) ;
  $HD     -> AddPair              ( "colspan"  , 4                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC     = "assignNameChanged(this.value,{$LanguageId},0,0,'ChinoId','{$this->Uuid}')" ;
  $INP     = $HD      -> addInput ( $NI -> Name                            ) ;
  $INP    -> AddPair              ( "id"       , "ChinoId"                 ) ;
  $INP    -> AddPair              ( "name"     , "ChinoName"               ) ;
  $INP    -> AddPair              ( "class"    , "NameInput"               ) ;
  $INP    -> AddPair              ( "onchange" , $JSC                      ) ;
  ////////////////////////////////////////////////////////////////////////////
}

public function addEnglishColumn($DB,$HR,$KEY="Registration::English")
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $EnglishId                                                          ;
  global $LanguageId                                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $NI      = new NameItem         (                                        ) ;
  $NI     -> AddColumn            ( "uuid"                                 ) ;
  $NI     -> AddColumn            ( "locality"                             ) ;
  $NI     -> AddColumn            ( "priority"                             ) ;
  $NI     -> AddColumn            ( "relevance"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NI     -> set                  ( "uuid"     , $this -> Uuid             ) ;
  $NI     -> set                  ( "locality" , $EnglishId                ) ;
  $NI     -> set                  ( "priority" , "0"                       ) ;
  $NI     -> setRelevance         ( "Default"                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = $NI -> SelectColumns ( "`erp`.`names`"                        ) ;
  $qq      = $DB -> Query         ( $QQ                                    ) ;
  $NI     -> Name = ""                                                       ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr  = $qq -> fetch_array ( MYSQLI_BOTH )                                ;
    $NI -> obtain ( $rr )                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ $KEY ]                                          ;
  $HD      = $HR -> addNameTd     ( $MSG , "3%"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD      = $HR      -> addTd    (                                        ) ;
  $HD     -> AddPair              ( "colspan"  , 4                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC     = "assignNameChanged(this.value,{$EnglishId},0,0,'EnglishId','{$this->Uuid}')" ;
  $INP     = $HD      -> addInput ( $NI -> Name                            ) ;
  $INP    -> AddPair              ( "id"       , "EnglishId"               ) ;
  $INP    -> AddPair              ( "name"     , "EnglishName"             ) ;
  $INP    -> AddPair              ( "class"    , "NameInput"               ) ;
  $INP    -> AddPair              ( "onchange" , $JSC                      ) ;
  ////////////////////////////////////////////////////////////////////////////
}

public function addPenColumn($DB,$HR)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $EnglishId                                                          ;
  global $LanguageId                                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $NI      = new NameItem         (                                        ) ;
  $NI     -> AddColumn            ( "uuid"                                 ) ;
  $NI     -> AddColumn            ( "locality"                             ) ;
  $NI     -> AddColumn            ( "priority"                             ) ;
  $NI     -> AddColumn            ( "relevance"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NI     -> set                  ( "uuid"     , $this -> Uuid             ) ;
  $NI     -> set                  ( "locality" , $EnglishId                ) ;
  $NI     -> set                  ( "priority" , "0"                       ) ;
  $NI     -> setRelevance         ( "Pen"                                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = $NI -> SelectColumns ( "`erp`.`names`"                        ) ;
  $qq      = $DB -> Query         ( $QQ                                    ) ;
  $NI     -> Name = ""                                                       ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr  = $qq -> fetch_array ( MYSQLI_BOTH )                                ;
    $NI -> obtain ( $rr )                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ "Registration::Pen" ]                           ;
  $HD      = $HR -> addNameTd     ( $MSG , "3%"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD      = $HR      -> addTd    (                                        ) ;
  $HD     -> AddPair              ( "colspan"  , 4                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC     = "assignNameChanged(this.value,{$EnglishId},0,2,'PenId','{$this->Uuid}')" ;
  $INP     = $HD      -> addInput ( $NI -> Name                            ) ;
  $INP    -> AddPair              ( "id"       , "PenId"                   ) ;
  $INP    -> AddPair              ( "name"     , "PenName"                 ) ;
  $INP    -> AddPair              ( "class"    , "NameInput"               ) ;
  $INP    -> AddPair              ( "onchange" , $JSC                      ) ;
  ////////////////////////////////////////////////////////////////////////////
}

public function addStageColumn($DB,$HR)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $EnglishId                                                          ;
  global $LanguageId                                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $NI      = new NameItem         (                                        ) ;
  $NI     -> AddColumn            ( "uuid"                                 ) ;
  $NI     -> AddColumn            ( "locality"                             ) ;
  $NI     -> AddColumn            ( "priority"                             ) ;
  $NI     -> AddColumn            ( "relevance"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NI     -> set                  ( "uuid"     , $this -> Uuid             ) ;
  $NI     -> set                  ( "locality" , $EnglishId                ) ;
  $NI     -> set                  ( "priority" , "0"                       ) ;
  $NI     -> setRelevance         ( "Stage"                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = $NI -> SelectColumns ( "`erp`.`names`"                        ) ;
  $qq      = $DB -> Query         ( $QQ                                    ) ;
  $NI     -> Name = ""                                                       ;
  if ( $DB -> hasResult ( $qq ) )                                            {
    $rr  = $qq -> fetch_array ( MYSQLI_BOTH )                                ;
    $NI -> obtain ( $rr )                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ "Registration::Alias" ]                         ;
  $HD      = $HR -> addNameTd     ( $MSG , "3%"                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD      = $HR      -> addTd    (                                        ) ;
  $HD     -> AddPair              ( "colspan"  , 4                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC     = "assignNameChanged(this.value,{$EnglishId},0,3,'StageId','{$this->Uuid}')" ;
  $INP     = $HD      -> addInput ( $NI -> Name                            ) ;
  $INP    -> AddPair              ( "id"       , "StageId"                 ) ;
  $INP    -> AddPair              ( "name"     , "StageName"               ) ;
  $INP    -> AddPair              ( "class"    , "NameInput"               ) ;
  $INP    -> AddPair              ( "onchange" , $JSC                      ) ;
  ////////////////////////////////////////////////////////////////////////////
}

public function addRegisterColumn($DB,$HR)
{
  //////////////////////////////////////////////////////////////////////
  global $Translations                                                 ;
  //////////////////////////////////////////////////////////////////////
  $MSG     = $Translations [ "Registration::RegisterDT" ]              ; // 註冊時間
  $HD      = $HR -> addNameTd ( $MSG , "3%"                          ) ;
  $HD      = $HR -> addTd     (                                      ) ;
  $HD     -> AddPair          ( "colspan" , 4                        ) ;
  $HDIV    = $HD -> addDiv    ( "" , "Register" , "PortfolioPad"     ) ;
  //////////////////////////////////////////////////////////////////////
  $DT      = GetParameterDateTime ( $DB , $this -> Uuid , "Register" ) ;
  if                          ( gmp_cmp ( $DT , "0" ) == 0           ) {
    $MSG   = $Translations [ "NoRecord" ]                              ;
    $HDIV -> AddText          ( $MSG                                 ) ;
  } else                                                               {
    $SS    = StarDateString   ( $DT , "Y/m/d H:i:s"                  ) ;
    $HDIV -> AddText          ( $SS                                  ) ;
  }                                                                    ;
  //////////////////////////////////////////////////////////////////////
}

public function GotoOldRecord($DB,$PEOPLE)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $GTAB  = new HtmlTag              (                                      ) ;
  $GBODY = $GTAB  -> ConfigureTable (                                      ) ;
  $HR    = $GBODY -> addTr          (                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC   = "PeopleOldRecord(this.value,'{$PEOPLE}') ; "                      ;
  $NI    = new NoteItem             (                                      ) ;
  $ORL   = $NI    -> ObtainByOwner  ( $DB                                    ,
                                      "`erp`.`notes`"                        ,
                                      $PEOPLE                                ,
                                      "Record"                               ,
                                      0                                    ) ;
  $HD    = $HR -> addTd             (                                      ) ;
  $HD   -> AddPair                  ( "colspan"  , 6                       ) ;
  $INP   = $HD -> addInput          (                                      ) ;
  $INP  -> AddPair                  ( "id"       , "OldRecord"             ) ;
  $INP  -> AddPair                  ( "class"    , "NameInput"             ) ;
  $INP  -> SafePair                 ( "value"    , $ORL                    ) ;
  $INP  -> AddPair                  ( "onchange" , $JSC                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "Tutors::GotoRecord" ]                            ;
  $JSC   = "GoToOldRecords() ; "                                             ;
  $HD    = $HR -> addTd             (                                      ) ;
  $HD   -> AddPair                  ( "nowrap"   , "nowrap"                ) ;
  $HD   -> SafePair                 ( "width"    , "1%"                    ) ;
  $BTN   = $HD -> addButton         ( $MSG                                 ) ;
  $BTN  -> AddPair                  ( "class"    , "SelectionButton"       ) ;
  $BTN  -> AddPair                  ( "onclick"  , $JSC                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $GTAB                                                               ;
}

public function GotoContacts($DB,$PEOPLE)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $GTAB  = new HtmlTag              (                                      ) ;
  $GBODY = $GTAB  -> ConfigureTable (                                      ) ;
  $HR    = $GBODY -> addTr          (                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC   = "PeopleContacts(this.value,'{$PEOPLE}') ; "                       ;
  $NI    = new NoteItem             (                                      ) ;
  $ORL   = $NI    -> ObtainByOwner  ( $DB                                    ,
                                      "`erp`.`notes`"                        ,
                                      $PEOPLE                                ,
                                      "Contacts"                             ,
                                      0                                    ) ;
  $HD    = $HR -> addTd             (                                      ) ;
  $HD   -> AddPair                  ( "colspan"  , 6                       ) ;
  $INP   = $HD -> addInput          (                                      ) ;
  $INP  -> AddPair                  ( "id"       , "Contacts"              ) ;
  $INP  -> AddPair                  ( "class"    , "NameInput"             ) ;
  $INP  -> SafePair                 ( "value"    , $ORL                    ) ;
  $INP  -> AddPair                  ( "onchange" , $JSC                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "Tutors::GotoRecord" ]                            ;
  $JSC   = "GoToContacts() ; "                                               ;
  $HD    = $HR -> addTd             (                                      ) ;
  $HD   -> AddPair                  ( "nowrap"   , "nowrap"                ) ;
  $HD   -> SafePair                 ( "width"    , "1%"                    ) ;
  $BTN   = $HD -> addButton         ( $MSG                                 ) ;
  $BTN  -> AddPair                  ( "class"    , "SelectionButton"       ) ;
  $BTN  -> AddPair                  ( "onclick"  , $JSC                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $GTAB                                                               ;
}

//////////////////////////////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////
?>
