<?php

namespace CIOS ;

class Relation extends Columns
{

public $Id          ;
public $First       ;
public $T1          ;
public $Second      ;
public $T2          ;
public $Relation    ;
public $Position    ;
public $Reverse     ;
public $Prefer      ;
public $Membership  ;
public $Description ;

public $Relations = array (
  "Ignore"        =>  0   ,
  "Subordination" =>  1   ,
  "Icon"          =>  2   ,
  "Sexuality"     =>  3   ,
  "Trigger"       =>  4   ,
  "StartTrigger"  =>  5   ,
  "FinalTrigger"  =>  6   ,
  "Action"        =>  7   ,
  "Condition"     =>  8   ,
  "Synonymous"    =>  9   ,
  "Equivalent"    => 10   ,
  "Contains"      => 11   ,
  "Using"         => 12   ,
  "Possible"      => 13   ,
  "Originate"     => 14   ,
  "Capable"       => 15   ,
  "Estimate"      => 16   ,
  "Alias"         => 17   ,
  "Counterpart"   => 18   ,
  "Explain"       => 19   ,
  "Fuzzy"         => 20   ,
  "Greater"       => 21   ,
  "Less"          => 22   ,
  "Before"        => 23   ,
  "After"         => 24   ,
  "Tendency"      => 25   ,
  "Different"     => 26   ,
  "Acting"        => 27   ,
  "Forgotten"     => 28   ,
  "Google"        => 29   ,
  "Facebook"      => 30   ,
  "End"           => 31   ,
)                         ;

public $Types         = array (
  "None"              =>   0  ,
  "Type"              =>   1  ,
  "Picture"           =>   9  ,
  "Video"             =>  11  ,
  "PlainText"         =>  12  ,
  "File"              =>  14  ,
  "Schedule"          =>  15  ,
  "Task"              =>  16  ,
  "Subgroup"          =>  17  ,
  "Account"           =>  18  ,
  "TopLevelDomain"    =>  23  ,
  "SecondLevelDomain" =>  24  ,
  "DomainName"        =>  26  ,
  "Username"          =>  27  ,
  "ITU"               =>  28  ,
  "Nation"            =>  43  ,
  "Currency"          =>  45  ,
  "Tag"               =>  75  ,
  "SqlConnection"     =>  81  ,
  "Division"          =>  91  ,
  "Period"            =>  92  ,
  "Variable"          =>  93  ,
  "CountryCode"       =>  97  ,
  "AreaCode"          =>  98  ,
  "Language"          => 101  ,
  "Place"             => 102  ,
  "People"            => 103  ,
  "Station"           => 104  ,
  "Organization"      => 105  ,
  "Role"              => 106  ,
  "Relevance"         => 107  ,
  "Locality"          => 108  ,
  "Group"             => 109  ,
  "Course"            => 110  ,
  "Lesson"            => 111  ,
  "IMApp"             => 112  ,
  "InstantMessage"    => 113  ,
  "Phone"             => 114  ,
  "Occupation"        => 115  ,
  "TimeZone"          => 116  ,
  "IPA"               => 117  ,
  "Address"           => 118  ,
  "EMail"             => 119  ,
  "Description"       => 120  ,
  "SqlServer"         => 121  ,
  "Lecture"           => 122  ,
  "Trade"             => 123  ,
  "Token"             => 124  ,
  "BankAccount"       => 125  ,
  "Class"             => 126  ,
  "Fragment"          => 127  ,
  "AgeGroup"          => 128  ,
  "Proficiency"       => 129  ,
)                             ;

function __construct()
{
  parent::__construct ( ) ;
  $this -> clear      ( ) ;
}

function __destruct()
{
  parent::__destruct ( ) ;
}

public function clear()
{
  $this -> Id          = 0 ;
  $this -> First       = 0 ;
  $this -> T1          = 0 ;
  $this -> Second      = 0 ;
  $this -> T2          = 0 ;
  $this -> Relation    = 0 ;
  $this -> Position    = 0 ;
  $this -> Reverse     = 0 ;
  $this -> Prefer      = 0 ;
  $this -> Membership  = 0 ;
  $this -> Description = 0 ;
}

public function assign($Item)
{
  $this -> Id          = $Item -> Id          ;
  $this -> First       = $Item -> First       ;
  $this -> T1          = $Item -> T1          ;
  $this -> Second      = $Item -> Second      ;
  $this -> T2          = $Item -> T2          ;
  $this -> Relation    = $Item -> Relation    ;
  $this -> Position    = $Item -> Position    ;
  $this -> Reverse     = $Item -> Reverse     ;
  $this -> Prefer      = $Item -> Prefer      ;
  $this -> Membership  = $Item -> Membership  ;
  $this -> Description = $Item -> Description ;
}

public function tableItems()
{
  $S = array (                    ) ;
  array_push ( $S , "id"          ) ;
  array_push ( $S , "first"       ) ;
  array_push ( $S , "t1"          ) ;
  array_push ( $S , "second"      ) ;
  array_push ( $S , "t2"          ) ;
  array_push ( $S , "relation"    ) ;
  array_push ( $S , "position"    ) ;
  array_push ( $S , "reverse"     ) ;
  array_push ( $S , "prefer"      ) ;
  array_push ( $S , "membership"  ) ;
  array_push ( $S , "description" ) ;
  return $S                         ;
}

public function FullList()
{
  $L = array (            ) ;
  array_push ( $L           ,
               "t1"         ,
               "t2"         ,
               "relation"   ,
               "first"      ,
               "second"     ,
               "position" ) ;
  return $L                 ;
}

public function ExactList()
{
  $L = array (          ) ;
  array_push ( $L         ,
               "t1"       ,
               "t2"       ,
               "relation" ,
               "first"    ,
               "second" ) ;
  return $L               ;
}

public function FirstList()
{
  $L = array (          ) ;
  array_push ( $L         ,
               "t1"       ,
               "t2"       ,
               "relation" ,
               "first"  ) ;
  return $L               ;
}

public function SecondList()
{
  $L = array (          ) ;
  array_push ( $L         ,
               "t1"       ,
               "t2"       ,
               "relation" ,
               "second" ) ;
  return $L               ;
}

public function isFirst($F)
{
  return ( 0 == gmp_cmp ( $F , $this -> First ) ) ;
}

public function isSecond($S)
{
  return ( 0 == gmp_cmp ( $S , $this -> Second ) ) ;
}

public function isType($t1,$t2)
{
  if ( $this -> T1 != $t1 ) return false ;
  if ( $this -> T2 != $t2 ) return false ;
  return true                            ;
}

public function isT1($t1)
{
  return ( $t1 == $this -> T1 ) ;
}

public function isT2($t2)
{
  return ( $t2 == $this -> T2 ) ;
}

public function isRelation($R)
{
  return ( $R == $this -> Relation ) ;
}

public function set($item,$V)
{
  $a = strtolower ( $item )                            ;
  if ( "id"          == $a ) $this -> Id          = $V ;
  if ( "first"       == $a ) $this -> First       = $V ;
  if ( "t1"          == $a ) $this -> T1          = $V ;
  if ( "second"      == $a ) $this -> Second      = $V ;
  if ( "t2"          == $a ) $this -> T2          = $V ;
  if ( "relation"    == $a ) $this -> Relation    = $V ;
  if ( "position"    == $a ) $this -> Position    = $V ;
  if ( "reverse"     == $a ) $this -> Reverse     = $V ;
  if ( "prefer"      == $a ) $this -> Prefer      = $V ;
  if ( "membership"  == $a ) $this -> Membership  = $V ;
  if ( "description" == $a ) $this -> Description = $V ;
}

public function setT1($N)
{
  $this -> T1 = $this -> Types [ $N ] ;
}

public function setT2($N)
{
  $this -> T2 = $this -> Types [ $N ] ;
}

public function setRelation($N)
{
  $this -> Relation = $this -> Relations [ $N ] ;
}

public function ItemPair($item)
{
  $a = strtolower ( $item )                                  ;
  if ( "id"          == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Id          ;
  }                                                          ;
  if ( "first"       == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> First       ;
  }                                                          ;
  if ( "t1"          == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> T1          ;
  }                                                          ;
  if ( "second"      == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Second      ;
  }                                                          ;
  if ( "t2"          == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> T2          ;
  }                                                          ;
  if ( "relation"    == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Relation    ;
  }                                                          ;
  if ( "position"    == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Position    ;
  }                                                          ;
  if ( "reverse"     == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Reverse     ;
  }                                                          ;
  if ( "prefer"      == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Prefer      ;
  }                                                          ;
  if ( "membership"  == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Membership  ;
  }                                                          ;
  if ( "description" == $a )                                 {
    return "`" . $a . "` = " . (string) $this -> Description ;
  }                                                          ;
  return ""                                                  ;
}

public function Value($item)
{
  $a = strtolower ( $item )                                       ;
  if ( "id"          == $a ) return (string) $this -> Id          ;
  if ( "first"       == $a ) return (string) $this -> First       ;
  if ( "t1"          == $a ) return (string) $this -> T1          ;
  if ( "second"      == $a ) return (string) $this -> Second      ;
  if ( "t2"          == $a ) return (string) $this -> T2          ;
  if ( "relation"    == $a ) return (string) $this -> Relation    ;
  if ( "position"    == $a ) return (string) $this -> Position    ;
  if ( "reverse"     == $a ) return (string) $this -> Reverse     ;
  if ( "prefer"      == $a ) return (string) $this -> Prefer      ;
  if ( "membership"  == $a ) return (string) $this -> Membership  ;
  if ( "description" == $a ) return (string) $this -> Description ;
  return ""                                                       ;
}

public function Values($items)
{
  $I = array ( )                              ;
  foreach ( $items as $i )                    {
    array_push ( $I , $this -> Value ( $i ) ) ;
  }                                           ;
  $L = implode ( "," , $I )                   ;
  unset        (       $I )                   ;
  return $L                                   ;
}

public function ExactItem ( $Options = "" , $Limits = "" )
{
  $L = $this -> ExactList  (                         ) ;
  $Q = $this -> QueryItems ( $L , $Options , $Limits ) ;
  unset                    ( $L                      ) ;
  return $Q                                            ;
}

public function FirstItem ( $Options = "" , $Limits = "" )
{
  $L = $this -> FirstList  (                         ) ;
  $Q = $this -> QueryItems ( $L , $Options , $Limits ) ;
  unset                    ( $L                      ) ;
  return $Q                                            ;
}

public function SecondItem ( $Options = "" , $Limits = "" )
{
  $L = $this -> SecondList (                         ) ;
  $Q = $this -> QueryItems ( $L , $Options , $Limits ) ;
  unset                    ( $L                      ) ;
  return $Q                                            ;
}

public function Last($Table)
{
  $WS = $this -> FirstItem ( "order by `position` desc" , "limit 0,1" ) ;
  return "select `position` from " . $Table . " " . $WS . " ;"          ;
}

public function ExactColumn ( $Table , $Item , $Options = "" , $Limits = "" )
{
  $WS = $this -> ExactItem ( $Options , $Limits )                 ;
  return "select " . $Item . " from " . $Table . " " . $WS . " ;" ;
}

public function InsertItems($Table,$items)
{
  return "insert into " . $Table . " ("      .
         $this -> JoinItems ( $items , "," ) .
         ") values ("                        .
         $this -> Values    ( $items       ) .
         ") ;"                               ;
}

public function Insert($Table)
{
  $L = $this -> FullList    (             ) ;
  $Q = $this -> InsertItems ( $Table , $L ) ;
  unset                     ( $L          ) ;
  return $Q                                 ;
}

public function DeleteItems($Table,$items)
{
  return "delete from {$Table} "               .
         $this -> QueryItems ( $items ) . " ;" ;
}

public function Delete($Table)
{
  $L = $this -> ExactList   (             ) ;
  $Q = $this -> DeleteItems ( $Table , $L ) ;
  unset                     ( $L          ) ;
  return $Q                                 ;
}

public function WipeOut($Table)
{
  $L = $this -> FirstList   (             ) ;
  $Q = $this -> DeleteItems ( $Table , $L ) ;
  unset                     ( $L          ) ;
  return $Q                                 ;
}

public function obtain($R)
{
  $this -> Id          = $R [ "id"          ] ;
  $this -> First       = $R [ "first"       ] ;
  $this -> T1          = $R [ "t1"          ] ;
  $this -> Second      = $R [ "second"      ] ;
  $this -> T2          = $R [ "t2"          ] ;
  $this -> Relation    = $R [ "relation"    ] ;
  $this -> Position    = $R [ "position"    ] ;
  $this -> Reverse     = $R [ "reverse"     ] ;
  $this -> Prefer      = $R [ "prefer"      ] ;
  $this -> Membership  = $R [ "membership"  ] ;
  $this -> Description = $R [ "description" ] ;
}

public function Subordination                 (
         $DB                                  ,
         $Table                               ,
         $Options = "order by `position` asc" ,
         $Limits  = ""                        )
{
  $W = $this -> FirstItem ( $Options , $Limits )          ;
  $Q = "select `second` from " . $Table . " " . $W . " ;" ;
  return $DB -> ObtainUuids ( $Q )                        ;
}

public function GetOwners               (
         $DB                            ,
         $Table                         ,
         $Options = "order by `id` asc" ,
         $Limits  = ""                  )
{
  $W = $this -> SecondItem ( $Options , $Limits )        ;
  $Q = "select `first` from " . $Table . " " . $W . " ;" ;
  return $DB -> ObtainUuids ( $Q )                       ;
}

public function CountFirst($DB,$TABLE)
{
  $WW = $this -> SecondItem ( )                 ;
  $QQ = "select count(*) from {$TABLE} {$WW} ;" ;
  $qq = $DB -> Query ( $QQ )                    ;
  if ( $DB -> hasResult ( $qq ) )               {
    $rr  = $qq -> fetch_row ( )                 ;
    return $rr [ 0 ]                            ;
  }                                             ;
  return 0                                      ;
}

public function CountSecond($DB,$TABLE)
{
  $WW = $this -> FirstItem ( )                  ;
  $QQ = "select count(*) from {$TABLE} {$WW} ;" ;
  $qq = $DB -> Query ( $QQ )                    ;
  if ( $DB -> hasResult ( $qq ) )               {
    $rr  = $qq -> fetch_row ( )                 ;
    return $rr [ 0 ]                            ;
  }                                             ;
  return 0                                      ;
}

public function Assure($DB,$Table)
{
  $QQ  = $this -> WipeOut ( $Table ) ;
  $DB -> Query            ( $QQ    ) ;
  $QQ  = $this -> Insert  ( $Table ) ;
  $DB -> Query            ( $QQ    ) ;
}

public function Append($DB,$Table)
{
  $QQ =  $this -> Insert ( $Table ) ;
  return $DB   -> Query  ( $QQ    ) ;
}

public function Join ( $DB , $Table )
{
  $QQ = $this -> ExactColumn ( $Table , "id" ) ;
  $q  = $DB   -> Query       ( $QQ           ) ;
  if ( $DB -> hasResult ( $q ) ) return false  ;
  //////////////////////////////////////////////
  $ID = -1                                     ;
  $QQ = $this -> Last  ( $Table )              ;
  $q  = $DB   -> Query ( $QQ    )              ;
  if ( $DB -> hasResult ( $q ) )               {
    $N  = $q -> fetch_array  ( MYSQLI_BOTH )   ;
    $ID = $N [ "position" ]                    ;
  }                                            ;
  $ID               = $ID + 1                  ;
  $this -> Position = $ID                      ;
  //////////////////////////////////////////////
  return $this -> Append ( $DB , $Table )      ;
}

public function Joins($DB,$Table,$LIST)
{
  foreach         ( $LIST as $L       ) {
    $this -> set  ( "second" , $L     ) ;
    $this -> Join ( $DB      , $Table ) ;
  }                                     ;
}

public function PrefectOrder($DB,$Table)
{
  $IX = array ( )                                           ;
  $WH = $this -> FirstItem ( "order by `position` asc" )    ;
  $QQ = "select `id` from " . $Table . " " . $WH . " ;"     ;
  $qq = $DB -> Query ( $QQ )                                ;
  while ( $rx = $qq -> fetch_array ( MYSQLI_BOTH ) )        {
    array_push ( $IX , $rx [ 0 ] )                          ;
  }                                                         ;
  $pos = 0                                                  ;
  foreach ( $IX as $ix )                                    {
    $QQ  = "update " . $Table . " set `position` = " . $pos .
           " where `id` = " . $ix . " ;"                    ;
    $DB -> Query ( $QQ )                                    ;
    $pos = $pos + 1                                         ;
  }                                                         ;
  unset ( $IX )                                             ;
}

public function ObtainOwners ( $DB , $TABLE , $MEMBERS , $TMP )
{
  foreach                            ( $TMP as $nsx    ) {
    $this   -> set                   ( "second" , $nsx ) ;
    $CC      = $this -> GetOwners    ( $DB , $TABLE    ) ;
    $MEMBERS = Parameters::JoinArray ( $MEMBERS , $CC  ) ;
  }                                                      ;
  return $MEMBERS                                        ;
}

public function Organize ( $DB , $TABLE )
{
  ////////////////////////////////////////////////////////////////////////////
  $WH     = $this -> FirstItem    ( "order by `position` asc"              ) ;
  $QQ     = "select `id` from {$TABLE} {$WH} ;"                              ;
  $IX     = $DB   -> ObtainUuids  ( $QQ                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                              ( count ( $IX ) <= 0                     ) {
    return                                                                   ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $pos    = 0                                                                ;
  $DB    -> LockWrite             ( $TABLE                                 ) ;
  foreach                         ( $IX as $iv                             ) {
    $QQ   = "update {$TABLE} set `position` = {$pos} where `id` = {$iv} ;"   ;
    $DB  -> Query                 ( $QQ                                    ) ;
    $pos  = $pos + 1                                                         ;
  }                                                                          ;
  $DB    -> UnlockTables          (                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
}

public function Ordering ( $DB , $TABLE , $UUIDs )
{
  ////////////////////////////////////////////////////////////////////////////
  $pos    = 0                                                                ;
  $DB    -> LockWrite             ( $TABLE                                 ) ;
  foreach                         ( $UUIDs as $xu                          ) {
    $this  -> set                 ( "second" , $xu                         ) ;
    $WH   = $this -> ExactItem    (                                        ) ;
    $QQ   = "update {$TABLE} set `position` = {$pos} {$WH} ;"                ;
    $DB  -> Query                 ( $QQ                                    ) ;
    $pos  = $pos + 1                                                         ;
  }                                                                          ;
  $DB    -> UnlockTables          (                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
}

}

?>
