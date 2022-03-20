<?php
//////////////////////////////////////////////////////////////////////////////
// 
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Phone                                                                  {
//////////////////////////////////////////////////////////////////////////////
public    $Uuid                                                              ;
public    $Used                                                              ;
public    $ISD           ; // international subscriber dialing , international direct dialing
public    $Area          ; // Area code
public    $Number        ; // Local Phone Number
protected $Splitters                                                         ;
protected $ForcelyMobile                                                     ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function clear ( )                                                    {
  $this -> Uuid          = "0"                                               ;
  $this -> Used          =  1                                                ;
  $this -> ISD           = ""                                                ;
  $this -> Area          = ""                                                ;
  $this -> Number        = ""                                                ;
  $this -> ForcelyMobile = false                                             ;
  $this -> Splitters     = array (                                         ) ;
  $this -> Properties    = array (                                         ) ;
  $this -> Owners        = array (                                         ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function Purge ( $n                                                 ) {
  $r = $n                                                                    ;
  $r = str_replace    ( " " , "" , $r                                      ) ;
  $r = str_replace    ( "-" , "" , $r                                      ) ;
  $r = str_replace    ( "+" , "" , $r                                      ) ;
  $r = str_replace    ( "(" , "" , $r                                      ) ;
  $r = str_replace    ( ")" , "" , $r                                      ) ;
  return  $r                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function isLoaded (                                                 ) {
  return                 ( gmp_cmp ( $this -> Uuid , "0" ) > 0             ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function isEqual ( $phone )                                           {
  if ( ! $this  -> isValid ( ) ) return false                                ;
  if ( ! $phone -> isValid ( ) ) return false                                ;
  return ( $this -> Phone ( ) == $phone -> Phone ( ) )                       ;
}
//////////////////////////////////////////////////////////////////////////////
public function isValid ( )                                                  {
  if ( strlen ( $this -> ISD    ) <= 0 ) return false                        ;
  if ( strlen ( $this -> Number ) <= 0 ) return false                        ;
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function isMobile ( )                                                 {
  if ( $this -> ForcelyMobile ) return true                                  ;
  return ( strlen ( $this -> Area ) <= 0 )                                   ;
}
//////////////////////////////////////////////////////////////////////////////
public function isAllow ( $n )                                               {
  $N = trim   ( $n         )                                                 ;
  $H = substr ( $N , 0 , 1 )                                                 ;
  if ( $H != "+" ) return false                                              ;
  return ( strpos ( $N , '-') !== false )                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function assign ( $phone )                                            {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Uuid          = $phone -> Uuid                                    ;
  $this -> ISD           = $phone -> ISD                                     ;
  $this -> Area          = $phone -> Area                                    ;
  $this -> Number        = $phone -> Number                                  ;
  $this -> ForcelyMobile = $phone -> ForcelyMobile                           ;
  $this -> Splitters     = $phone -> Splitters                               ;
  $this -> Properties    = $phone -> Properties                              ;
  $this -> Owners        = $phone -> Owners                                  ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function setSplitters ( $splitters )                                  {
  $this -> Splitters = $splitters                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function setMobile ( $mobile )                                        {
  $this -> ForcelyMobile = $mobile                                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function International ( )                                            {
  if ( ! is_numeric ( $this -> ISD ) ) return 0                              ;
  return $this -> ISD                                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function Phone ( )                                                    {
  $n = ""                                                                    ;
  if ( strlen ( $this -> ISD  ) > 0 )                                        {
    $n = $n . "+"                                                            ;
    $n = $n . $this -> ISD                                                   ;
    $n = $n . "-"                                                            ;
  }                                                                          ;
  if ( strlen ( $this -> Area ) > 0 )                                        {
    $n = $n . $this -> Area                                                  ;
    $n = $n . "-"                                                            ;
  }                                                                          ;
  $n = $n . $this -> dashNumbers ( )                                         ;
  return $n                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function CallNumber ( )                                               {
  $n = ""                                                                    ;
  if ( strlen ( $this -> ISD  ) > 0 )                                        {
    $n = $n . "+"                                                            ;
    $n = $n . $this -> ISD                                                   ;
    $n = $n . "-"                                                            ;
  }                                                                          ;
  if ( strlen ( $this -> Area ) > 0 )                                        {
    $n = $n . $this -> Area                                                  ;
    $n = $n . "-"                                                            ;
  }                                                                          ;
  $n = $n . $this -> Number                                                  ;
  return $n                                                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function dashNumbers ( )                                              {
  if ( count ( $this -> Splitters ) <= 0 )                                   {
    return $this -> Number                                                   ;
  }                                                                          ;
  $S = array ( )                                                             ;
  $s = $this -> Number                                                       ;
  foreach ( $this -> Splitters as $d )                                       {
    if ( intval ( $d , 10 ) < strlen ( $s ) )                                {
      array_push ( $S , substr ( $s , 0 , intval ( $d , 10 ) ) )             ;
      $s = substr ( $s , intval ( $d , 10 ) )                                ;
    }                                                                        ;
  }                                                                          ;
  if ( strlen ( $s ) > 0 ) array_push ( $S , $s )                            ;
  return implode ( "-" , $S )                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function setInternational   ( $isd )                                  {
  $this -> ISD    = $this -> Purge ( $isd )                                  ;
  $this -> installSplitters        (      )                                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function setArea            ( $area )                                 {
  $this -> Area   = $this -> Purge ( $area )                                 ;
  $this -> installSplitters        (       )                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function setPhone           ( $n )                                    {
  $this -> Number = $this -> Purge ( $n )                                    ;
  $this -> installSplitters        (    )                                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function setFull ( $n )                                               {
  $N = trim ( $n )                                                           ;
  $H = substr ( $N , 0 , 1 )                                                 ;
  if ( "+" == $H )                                                           {
    $N = substr ( $N , 1 )                                                   ;
  }                                                                          ;
  $S = explode ( "-" , $N )                                                  ;
  $C = count ( $S )                                                          ;
  if ( $C < 2 ) return false                                                 ;
  switch ( $C )                                                              {
    case 2                                                                   :
      $this -> ISD    = $S [ 0 ]                                             ;
      $this -> Area   = ""                                                   ;
      $this -> Number = $S [ 1 ]                                             ;
    break                                                                    ;
    case 3                                                                   :
      $this -> ISD = $S [ 0 ]                                                ;
      unset ( $S [ 0 ] )                                                     ;
      if ( $this -> ForcelyMobile )                                          {
        $this -> Area   = ""                                                 ;
        $this -> Number = implode ( "" , $S )                                ;
      } else                                                                 {
        $this -> Area   = $S [ 0 ]                                           ;
        $this -> Number = $S [ 1 ]                                           ;
      }                                                                      ;
    break                                                                    ;
    default                                                                  :
      $this -> ISD = $S [ 0 ]                                                ;
      unset ( $S [ 0 ] )                                                     ;
      if ( ForcelyMobile )                                                   {
        $this -> Area   = ""                                                 ;
      } else                                                                 {
        $this -> Area   = $S [ 0 ]                                           ;
        unset ( $S [ 0 ] )                                                   ;
      }                                                                      ;
      $this   -> Number = implode ( "" , $S )                                ;
    break                                                                    ;
  }                                                                          ;
  $this -> installSplitters ( )                                              ;
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function installSplitters ( )                                         {
  ////////////////////////////////////////////////////////////////////////////
  if ( ! is_numeric ( $this -> ISD  ) ) return                               ;
  ////////////////////////////////////////////////////////////////////////////
  $area  = ( strlen ( $this -> Area ) > 0 )                                  ;
  $isd   = intval ( $this -> ISD  , 10 )                                     ;
  if ( $area and is_numeric ( $this -> Area ) )                              {
    $acode = intval ( $this -> Area , 10 )                                   ;
  } else                                                                     {
    $acode = 0                                                               ;
    $area  = false                                                           ;
  }                                                                          ;
  if ( $this -> ForcelyMobile ) $area = false                                ;
  $this -> Splitters = array ( )                                             ;
  ////////////////////////////////////////////////////////////////////////////
  switch ( $isd )                                                            {
    case  63                                                                 :
      // Philippines
      if ( $area )                                                           {
        array_push ( $this -> Splitters , 4     )                            ;
      } else                                                                 {
        array_push ( $this -> Splitters , 3 , 4 )                            ;
      }                                                                      ;
    break                                                                    ;
    case 81                                                                  :
      // Japan
      if ( $area )                                                           {
        array_push ( $this -> Splitters , 3 , 3 )                            ;
      } else                                                                 {
        array_push ( $this -> Splitters , 3 , 4 )                            ;
      }                                                                      ;
    break                                                                    ;
    case 852                                                                 :
      // Hong Kong
      if ( $area )                                                           {
        array_push ( $this -> Splitters , 3     )                            ;
      } else                                                                 {
        array_push ( $this -> Splitters , 4     )                            ;
      }                                                                      ;
    break                                                                    ;
    case 853                                                                 :
      // Macau
      if ( $area )                                                           {
        array_push ( $this -> Splitters , 3     )                            ;
      } else                                                                 {
        array_push ( $this -> Splitters , 4     )                            ;
      }                                                                      ;
    break                                                                    ;
    case 86                                                                  :
      // China
      if ( $area )                                                           {
        array_push ( $this -> Splitters , 3 , 3 )                            ;
      } else                                                                 {
        array_push ( $this -> Splitters , 4 , 3 )                            ;
      }                                                                      ;
    break                                                                    ;
    case 886                                                                 :
      // Taiwan
      if ( $area )                                                           {
        switch ( $acode )                                                    {
          case 1                                                             :
            array_push ( $this -> Splitters , 4 )                            ;
          break                                                              ;
          default                                                            :
            array_push ( $this -> Splitters , 3 )                            ;
          break                                                              ;
        }                                                                    ;
      } else                                                                 {
        array_push ( $this -> Splitters , 3 , 3 )                            ;
      }                                                                      ;
    break                                                                    ;
  }
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function Obtains     ( $q        )                                    {
  $this -> ISD    = $q      [ "country" ]                                    ;
  $this -> Area   = $q      [ "area"    ]                                    ;
  $this -> Number = $q      [ "number"  ]                                    ;
  $this -> installSplitters (           )                                    ;
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function Update ( $DB , $Table )                                      {
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false                   ;
  $QQ = "update " . $Table . " set "                                         .
         "`country` = '" . (string) $this -> ISD    . "' , "                 .
            "`area` = '" . (string) $this -> Area   . "' , "                 .
          "`number` = '" . (string) $this -> Number . "' "                   .
        $DB -> WhereUuid ( $this -> Uuid , true )                            ;
  return $DB -> Query ( $QQ )                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByUuid ( $DB , $Table )                               {
  $Q = "select `country`,`area`,`number` from " . $Table                     .
       " where `uuid` = " . (string) $this -> Uuid . " ;"                    ;
  $q = $DB -> Query ( $Q )                                                   ;
  if ( ! $DB -> hasResult ( $q ) ) return false                              ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )                                     ;
  return $this -> Obtains ( $N )                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByNumber ( $DB , $Table )                             {
  $QQ = ""                                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $this -> isMobile ( ) )                                               {
    $QQ = "select `uuid` from " . $Table                                     .
          " where `country` = " . (string) $this -> ISD                      .
               " and `used` = 1"                                             .
             " and `number` = " . (string) $this -> Number . " ;"            ;
  } else                                                                     {
    $QQ = "select `uuid` from " . $Table                                     .
          " where `country` = " . (string) $this -> ISD                      .
               " and `used` = 1"                                             .
               " and `area` = " . (string) $this -> Area                     .
             " and `number` = " . (string) $this -> Number . " ;"            ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $q = $DB -> Query ( $QQ )                                                  ;
  if ( ! $DB -> hasResult ( $q ) ) return false                              ;
  $N = $q -> fetch_array ( MYSQLI_BOTH )                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Uuid = $N [ "uuid" ]                                              ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainPhone ( $DB , $Table )                                 {
  if ( gmp_cmp ( $this -> Uuid , "0" ) > 0 )                                 {
    if ( $this -> ObtainsByUuid   ( $DB , $Table ) ) return true             ;
  }                                                                          ;
  return $this -> ObtainsByNumber ( $DB , $Table )                           ;
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsITU ( $DB , $TABLE )                                  {
  $IU = array ( )                                                            ;
  $QQ = "select `itu` from {$TABLE} order by `id` asc ;"                     ;
  $qq = $DB -> Query ( $QQ )                                                 ;
  while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) )                         {
    array_push ( $IU , $rr [ 0 ] )                                           ;
  }                                                                          ;
  return $IU                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function Append ( $DB , $PhoneTable , $UuidTable )                    {
  $U = $DB -> ObtainsUuid ( $PhoneTable , $UuidTable )                       ;
  if ( gmp_cmp ( $U , "0" ) <= 0 ) return false                              ;
  $this -> Uuid = $U                                                         ;
  return $this -> Update ( $DB , $PhoneTable )                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function Assure ( $DB , $PhoneTable , $UuidTable )                    {
  if ( gmp_cmp ( $this -> Uuid , "0" ) == 0 )                                {
    if ( ! $this -> isValid ( )                         ) return false       ;
    if ( $this -> ObtainsByNumber ( $DB , $PhoneTable ) ) return true        ;
  } else                                                                     {
    if ( $this -> ObtainsByUuid   ( $DB , $PhoneTable ) ) return true        ;
  }                                                                          ;
  return $this -> Append ( $DB , $PhoneTable , $UuidTable )                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function Newbie ( $DB , $PhoneTable , $UuidTable )                    {
  if ( $this -> ObtainsByNumber ( $DB , $PhoneTable ) ) return false         ;
  return $this -> Append ( $DB , $PhoneTable , $UuidTable )                  ;
}
//////////////////////////////////////////////////////////////////////////////
public function Subordination ( $DB , $Table , $U , $Type = "People"       ) {
  $RI  = new Relation         (                                            ) ;
  $RI -> set                  ( "first" , $U                               ) ;
  $RI -> setT1                ( $Type                                      ) ;
  $RI -> setT2                ( "Phone"                                    ) ;
  $RI -> setRelation          ( "Subordination"                            ) ;
  $UU  = $RI -> Subordination ( $DB , $Table                               ) ;
  unset                       ( $RI                                        ) ;
  return $UU                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function GetOwners ( $DB , $Table , $Type = "People"                ) {
  $RI  = new Relation     (                                                ) ;
  $RI -> set              ( "second" , $this -> Uuid                       ) ;
  $RI -> setT1            ( $Type                                          ) ;
  $RI -> setT2            ( "Phone"                                        ) ;
  $RI -> setRelation      ( "Subordination"                                ) ;
  $UU  = $RI -> GetOwners ( $DB , $Table                                   ) ;
  unset                   ( $RI                                            ) ;
  return $UU                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function FindByName  ( $DB , $TABLE , $NAME                         ) {
  ////////////////////////////////////////////////////////////////////////////
  $TMP  = array ( )                                                          ;
  $SPT  = "%{$NAME}%"                                                        ;
  $QQ   = "select `uuid` from {$TABLE}"                                      .
          " where ( ( `number` like ? )"                                     .
              " or ( `country` like ? )"                                     .
                 " or ( `area` like ? ) )"                                   .
          " and ( `used` > 0 )"                                              .
          " order by `ltime` desc ;"                                         ;
  ////////////////////////////////////////////////////////////////////////////
  $qq   = $DB -> Prepare    ( $QQ                                          ) ;
  $qq  -> bind_param        ( 'sss' , $SPT , $SPT , $SPT                   ) ;
  $ANS = $qq -> execute     (                                              ) ;
  if                        ( ! $ANS                                       ) {
    return $TMP                                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $kk   = $qq -> get_result (                                              ) ;
  if                        ( $DB -> hasResult ( $kk )                     ) {
    while                   ( $rr = $kk -> fetch_array ( MYSQLI_BOTH )     ) {
      array_push            ( $TMP , $rr [ 0 ]                             ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $TMP                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function AppendProperties ( $DB                                       ,
                                   $TABLE                                    ,
                                   $CORRECT                                  ,
                                   $MOBILE                                   ,
                                   $SHARE                                    ,
                                   $CONFIRM                                  ,
                                   $REGION = "TW"                          ) {
  ////////////////////////////////////////////////////////////////////////////
  $UUID = $this -> Uuid                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "insert into {$TABLE}"                                             .
          " ( `uuid` , `correct` , `mobile` , `shareable` , `confirm` , `region` )" .
          " values"                                                          .
          " ( {$UUID} , {$CORRECT} , {$MOBILE} , {$SHARE} , {$CONFIRM} , '{$REGION}' ) ;" ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB  -> Query           ( $QQ                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateProperty ( $DB , $TABLE , $ITEM , $VALUE             ) {
  ////////////////////////////////////////////////////////////////////////////
  $UUID    = $this -> Uuid                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $ITEM == "region"                         ) {
    $VALUE = "'{$VALUE}'"                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "update {$TABLE}"                                               .
             " set `{$ITEM}` = {$VALUE}"                                     .
             " where ( `uuid` = {$UUID} ) ;"                                 ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB  -> Query         ( $QQ                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetProperties   ( $DB , $TABLE                             ) {
  ////////////////////////////////////////////////////////////////////////////
  $UUID    = $this -> Uuid                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "select `correct` , `mobile` , `shareable` , `confirm` , `region`" .
             " from {$TABLE}"                                                .
             " where ( `uuid` = {$UUID} ) ;"                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $qq      = $DB -> Query       ( $QQ                                      ) ;
  if                            ( ! $DB -> hasResult ( $qq )               ) {
    return array                ( "Correct"   => 0                           ,
                                  "Mobile"    => 0                           ,
                                  "Shareable" => 0                           ,
                                  "Confirm"   => 0                           ,
                                  "Region"    => ""                        ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $NN      = $qq -> fetch_array ( MYSQLI_BOTH                              ) ;
  $CORRECT = $NN                [ "correct"                                ] ;
  $MOBILE  = $NN                [ "mobile"                                 ] ;
  $SHARE   = $NN                [ "shareable"                              ] ;
  $CONFIRM = $NN                [ "confirm"                                ] ;
  $REGION  = $NN                [ "region"                                 ] ;
  ////////////////////////////////////////////////////////////////////////////
  $CORRECT = intval             ( $CORRECT , 10                            ) ;
  $MOBILE  = intval             ( $MOBILE  , 10                            ) ;
  $SHARE   = intval             ( $SHARE   , 10                            ) ;
  $CONFIRM = intval             ( $CONFIRM , 10                            ) ;
  $REGION  = "{$REGION}"                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  return array                  ( "Correct"   => $CORRECT                    ,
                                  "Mobile"    => $MOBILE                     ,
                                  "Shareable" => $SHARE                      ,
                                  "Confirm"   => $CONFIRM                    ,
                                  "Region"    => $REGION                   ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function getReceiveMessage ( $DB , $PUID , $DEFAULT = 1             ) {
  ////////////////////////////////////////////////////////////////////////////
  $RECEIVE   = $DEFAULT                                                      ;
  $EUID      = $this -> Uuid                                                 ;
  $PQ        = ParameterQuery::NewParameter                                  (
                                    71                                       ,
                                    47                                       ,
                                    "ReceiveMessage"                       ) ;
  $RMC       = $PQ -> Fetch       ( $DB , "value" , $EUID , $PUID          ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                              ( strlen ( $RMC ) > 0                    ) {
    $RECEIVE = intval             ( $RMC , 10                              ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $RECEIVE                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function setReceiveMessage ( $DB , $PUID , $RECEIVE                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $PAMTAB = $GLOBALS [ "TableMapping" ] [ "Parameters" ]                     ;
  $PQ     = ParameterQuery::NewParameter ( 71 , 47 , "ReceiveMessage"      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DB    -> LockWrites            ( [ $PAMTAB                            ] ) ;
  $PQ    -> assureValue           ( $DB , $this -> Uuid , $PUID , $RECEIVE ) ;
  $DB    -> UnlockTables          (                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetCONFs              ( $DB , $PROPTAB , $PUID , $RECEIVE  ) {
  ////////////////////////////////////////////////////////////////////////////
  $PRTS  = $this -> GetProperties     ( $DB , $PROPTAB                     ) ;
  $RECV  = $this -> getReceiveMessage ( $DB ,            $PUID , $RECEIVE  ) ;
  $this -> Properties [ "Correct"   ] = $PRTS [ "Correct"                  ] ;
  $this -> Properties [ "Mobile"    ] = $PRTS [ "Mobile"                   ] ;
  $this -> Properties [ "Shareable" ] = $PRTS [ "Shareable"                ] ;
  $this -> Properties [ "Confirm"   ] = $PRTS [ "Confirm"                  ] ;
  $this -> Properties [ "Region"    ] = $PRTS [ "Region"                   ] ;
  $this -> Properties [ "Receive"   ] = $RECV                                ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetProperty  ( $KEY , $DEFAULT = 0                         ) {
  ////////////////////////////////////////////////////////////////////////////
  if                         ( ! in_array ( $KEY , $this -> Properties )   ) {
    return $DEFAULT                                                          ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Properties [ $KEY                                        ] ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoOptions ( $HS , $ITU )                                   {
  if ( count ( $ITU ) <= 0 ) return                                          ;
  foreach ( $ITU as $itx )                                                   {
    $HE = new Html ( )                                                       ;
    $HE -> setTag ( "option" )                                               ;
    if ( $itx == $this -> ISD )                                              {
      $HE -> AddMember ( "selected" )                                        ;
    }                                                                        ;
    $HE -> AddPair ( "value" , $itx )                                        ;
    $HE -> AddText ( "+" . $itx     )                                        ;
    $HS -> AddTag  ( $HE            )                                        ;
  }
}
//////////////////////////////////////////////////////////////////////////////
public function EchoSelection ( $ClassName , $ItemName , $ITU              ) {
  $HS    = new Html           (                                            ) ;
  $HS   -> setSplitter        ( "\n"                                       ) ;
  $HS   -> setTag             ( "select"                                   ) ;
  $HS   -> SafePair           ( "class" , $ClassName                       ) ;
  $HS   -> SafePair           ( "id"    , $ItemName                        ) ;
  $HS   -> SafePair           ( "name"  , $ItemName                        ) ;
  $this -> EchoOptions        ( $HS     , $ITU                             ) ;
  return $HS                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoUuidInput ( $ItemName                                  ) {
  $HS  = new HtmlTag          (                                            ) ;
  $HS -> setHiddenInput       (                                            ) ;
  $HS -> SafePair             ( "id"    , $ItemName                        ) ;
  $HS -> SafePair             ( "name"  , $ItemName                        ) ;
  $HS -> SafePair             ( "value" , $this -> Uuid                    ) ;
  return $HS                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoPositionInput ( $ItemName , $ID     )                    {
  ////////////////////////////////////////////////////////////////////////////
  $HT  = new Html                 (                     )                    ;
  $HT -> setHiddenInput           (                     )                    ;
  $HT -> SafePair                 ( "id"    , $ItemName )                    ;
  $HT -> SafePair                 ( "name"  , $ItemName )                    ;
  $HT -> AddPair                  ( "value" , $ID       )                    ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoAreaInput ( $ClassName , $ItemName , $Width )            {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $HS  = new HtmlTag (                                  )                    ;
  $HS -> setInput    (                                  )                    ;
  $HS -> AddPair     ( "type"  , "text"                 )                    ;
  $HS -> AddPair     ( "size"  , $Width                 )                    ;
  $HS -> SafePair    ( "class" , $ClassName             )                    ;
  $HS -> SafePair    ( "id"    , $ItemName              )                    ;
  $HS -> SafePair    ( "name"  , $ItemName              )                    ;
  $HS -> SafePair    ( "value" , (string) $this -> Area )                    ;
  if                 ( strlen ( $this -> Area ) <= 0    )                    {
    $MSG = $Translations [ "Registration::AreaCode" ]                        ;
    $HS -> AddPair   ( "placeholder" , $MSG             )                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $HS                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoPhoneInput ( $ClassName,$ItemName,$Width,$Holder=""    ) {
  $HS  = new HtmlTag (                                                     ) ;
  $HS -> setInput    (                                                     ) ;
  $HS -> AddPair     ( "type"        , "text"                              ) ;
  $HS -> AddPair     ( "size"        , $Width                              ) ;
  $HS -> SafePair    ( "class"       , $ClassName                          ) ;
  $HS -> SafePair    ( "id"          , $ItemName                           ) ;
  $HS -> SafePair    ( "name"        , $ItemName                           ) ;
  $HS -> SafePair    ( "value"       , (string) $this -> dashNumbers ( )   ) ;
  $HS -> SafePair    ( "placeholder" , $Holder                             ) ;
  return $HS                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoDIV ( $ITU , $ID , $Width , $Holder = "" )               {
  ////////////////////////////////////////////////////////////////////////////
  $OC  = "portfolioPhoneChanged("     . $ID . ");"                           ;
//  $OE  = "portfolioPhoneEnter(event," . $ID . ");"        ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = new HtmlTag (                                  )                    ;
  $HD -> setSplitter ( "\n"                             )                    ;
  $HD -> setTag      ( "div"                            )                    ;
  $HD -> SafePair    ( "class" , "phone-div"            )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HT  = new HtmlTag (                                  )                    ;
  $HT -> setTag      ( "table"                          )                    ;
  $HT -> AddPair     ( "width"       , "100%"           )                    ;
  $HT -> AddPair     ( "border"      , "0"              )                    ;
  $HT -> AddPair     ( "cellspacing" , "0"              )                    ;
  $HT -> AddPair     ( "cellpadding" , "0"              )                    ;
  $HD -> AddTag      ( $HT                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag (                                  )                    ;
  $HB -> setTag      ( "tbody"                          )                    ;
  $HT -> AddTag      ( $HB                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = new HtmlTag (                                  )                    ;
  $HR -> setTag      ( "tr"                             )                    ;
  $HR -> setSplitter ( "\n"                             )                    ;
  $HB -> AddTag      ( $HR                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  )                    ;
  $HX -> setTag      ( "td"                             )                    ;
  $HX -> AddPair     ( "width" , "5%"                   )                    ;
  $HX -> setSplitter ( "\n"                             )                    ;
  $HR -> AddTag      ( $HX                              )                    ;
  $HX -> AddTag      ( $this -> EchoUuidInput                                (
                         "phone-uuid-" . $ID          ) )                    ;
  $HX -> AddTag      ( $this -> EchoPositionInput                            (
                       "phone-position-" . $ID                               ,
                       $ID                            ) )                    ;
  $HX -> AddTag      ( $this -> EchoSelection                                (
                         "phone-selection"                                   ,
                         "phone-isd-"  . $ID                                 ,
                         $ITU                         ) )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  )                    ;
  $HX -> setTag      ( "td"                             )                    ;
  $HX -> AddPair     ( "width" , "5%"                   )                    ;
  $HX -> setSplitter ( "\n"                             )                    ;
  $HR -> AddTag      ( $HX                              )                    ;
  $HA  = $this -> EchoAreaInput                                              (
                       "phone-areacode"                                      ,
                       "phone-area-" . $ID                                   ,
                       6                                )                    ;
  $HA -> AddPair     ( "onchange"   , $OC               )                    ;
//  $HA -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HA                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  )                    ;
  $HX -> setTag      ( "td"                             )                    ;
  $HX -> setSplitter ( "\n"                             )                    ;
  $HR -> AddTag      ( $HX                              )                    ;
  $HI  = $this -> EchoPhoneInput                                             (
                       "NameInput"                                           ,
                       "phone-"      . $ID                                   ,
                       $Width                                                ,
                       $Holder                          )                    ;
  $HI -> AddPair     ( "onchange"   , $OC               )                    ;
//  $HI -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HI                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  return $HD                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public function EchoPersonalPhone ( $PUID                                    ,
                                    $ITU                                     ,
                                    $ID                                      ,
                                    $Width                                   ,
                                    $Holder = ""                             ,
                                    $SMS    = false                        ) {
  ////////////////////////////////////////////////////////////////////////////
  $OC  = "personalPhoneChanged('{$PUID}',{$ID},{$SMS});"                     ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = new HtmlTag (                                  )                    ;
  $HD -> setSplitter ( "\n"                             )                    ;
  $HD -> setTag      ( "div"                            )                    ;
  $HD -> SafePair    ( "class" , "phone-div"            )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HT  = new HtmlTag (                                  )                    ;
  $HT -> setTag      ( "table"                          )                    ;
  $HT -> AddPair     ( "width"       , "100%"           )                    ;
  $HT -> AddPair     ( "border"      , "0"              )                    ;
  $HT -> AddPair     ( "cellspacing" , "0"              )                    ;
  $HT -> AddPair     ( "cellpadding" , "0"              )                    ;
  $HD -> AddTag      ( $HT                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag (                                  )                    ;
  $HB -> setTag      ( "tbody"                          )                    ;
  $HT -> AddTag      ( $HB                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = new HtmlTag (                                  )                    ;
  $HR -> setTag      ( "tr"                             )                    ;
  $HR -> setSplitter ( "\n"                             )                    ;
  $HB -> AddTag      ( $HR                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $ESI = $this -> EchoSelection                                              (
                       "phone-selection"                                     ,
                       "phone-isd-"  . $ID                                   ,
                       $ITU                             )                    ;
  $ESI -> AddPair    ( "onchange"   , $OC               )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  )                    ;
  $HX -> setTag      ( "td"                             )                    ;
  $HX -> AddPair     ( "width" , "5%"                   )                    ;
  $HX -> setSplitter ( "\n"                             )                    ;
  $HR -> AddTag      ( $HX                              )                    ;
  $HX -> AddTag      ( $this -> EchoUuidInput                                (
                         "phone-uuid-" . $ID          ) )                    ;
  $HX -> AddTag      ( $this -> EchoPositionInput                            (
                       "phone-position-" . $ID                               ,
                       $ID                            ) )                    ;
  $HX -> AddTag      ( $ESI                             )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  )                    ;
  $HX -> setTag      ( "td"                             )                    ;
  $HX -> AddPair     ( "width" , "5%"                   )                    ;
  $HX -> setSplitter ( "\n"                             )                    ;
  $HR -> AddTag      ( $HX                              )                    ;
  $HA  = $this -> EchoAreaInput                                              (
                       "phone-areacode"                                      ,
                       "phone-area-" . $ID                                   ,
                       6                                )                    ;
  $HA -> AddPair     ( "onchange"   , $OC               )                    ;
//  $HA -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HA                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HX  = new HtmlTag (                                  )                    ;
  $HX -> setTag      ( "td"                             )                    ;
  $HX -> setSplitter ( "\n"                             )                    ;
  $HR -> AddTag      ( $HX                              )                    ;
  $HI  = $this -> EchoPhoneInput                                             (
                       "NameInput"                                           ,
                       "phone-"      . $ID                                   ,
                       $Width                                                ,
                       $Holder                          )                    ;
  $HI -> AddPair     ( "onchange"   , $OC               )                    ;
//  $HI -> AddPair     ( "onkeypress" , $OE               ) ;
  $HX -> AddTag      ( $HI                              )                    ;
  ////////////////////////////////////////////////////////////////////////////
  return $HD                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
