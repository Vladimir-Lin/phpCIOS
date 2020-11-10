<?php
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class ClassItem extends Columns                                              {
//////////////////////////////////////////////////////////////////////////////
// +| Variables |+
//////////////////////////////////////////////////////////////////////////////
public $Id                                                                   ;
public $Uuid                                                                 ;
public $Type                                                                 ;
public $Used                                                                 ;
public $States                                                               ;
public $Trainee                                                              ;
public $Tutor                                                                ;
public $Manager                                                              ;
public $Receptionist                                                         ;
public $Item                                                                 ;
public $Lecture                                                              ;
public $Description                                                          ;
public $Period                                                               ;
public $Start                                                                ;
public $End                                                                  ;
public $Update                                                               ;
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
public function Clear ( )                                                    {
  $this -> Id           = -1 ;
  $this -> Uuid         =  0 ;
  $this -> Type         =  0 ;
  $this -> Used         =  1 ;
  $this -> States       =  0 ;
  $this -> Trainee      =  0 ;
  $this -> Tutor        =  0 ;
  $this -> Manager      =  0 ;
  $this -> Receptionist =  0 ;
  $this -> Item         =  0 ;
  $this -> Lecture      =  0 ;
  $this -> Description  =  0 ;
  $this -> Period       =  0 ;
  $this -> Start        =  0 ;
  $this -> End          =  0 ;
  $this -> Update       =  0 ;
}

public function assign($Item)
{
  $this -> Id           = $Item -> Id           ;
  $this -> Uuid         = $Item -> Uuid         ;
  $this -> Type         = $Item -> Type         ;
  $this -> Used         = $Item -> Used         ;
  $this -> States       = $Item -> States       ;
  $this -> Trainee      = $Item -> Trainee      ;
  $this -> Tutor        = $Item -> Tutor        ;
  $this -> Manager      = $Item -> Manager      ;
  $this -> Receptionist = $Item -> Receptionist ;
  $this -> Item         = $Item -> Item         ;
  $this -> Lecture      = $Item -> Lecture      ;
  $this -> Description  = $Item -> Description  ;
  $this -> Period       = $Item -> Period       ;
  $this -> Start        = $Item -> Start        ;
  $this -> End          = $Item -> End          ;
  $this -> Update       = $Item -> Update       ;
}

public function tableItems()
{
  $S = array (                     ) ;
  array_push ( $S , "id"           ) ;
  array_push ( $S , "uuid"         ) ;
  array_push ( $S , "type"         ) ;
  array_push ( $S , "used"         ) ;
  array_push ( $S , "states"       ) ;
  array_push ( $S , "trainee"      ) ;
  array_push ( $S , "tutor"        ) ;
  array_push ( $S , "manager"      ) ;
  array_push ( $S , "receptionist" ) ;
  array_push ( $S , "item"         ) ;
  array_push ( $S , "lecture"      ) ;
  array_push ( $S , "description"  ) ;
  array_push ( $S , "period"       ) ;
  array_push ( $S , "start"        ) ;
  array_push ( $S , "end"          ) ;
  array_push ( $S , "ltime"        ) ;
  return $S                          ;
}

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

public function Items( $S = "," )
{
  $X = $this -> tableItems (         ) ;
  $L = $this -> JoinItems  ( $X , $S ) ;
  unset                    ( $X      ) ;
  return $L                            ;
}

public function valueItems()
{
  $S = array (                     ) ;
  array_push ( $S , "type"         ) ;
  array_push ( $S , "used"         ) ;
  array_push ( $S , "states"       ) ;
  array_push ( $S , "trainee"      ) ;
  array_push ( $S , "tutor"        ) ;
  array_push ( $S , "manager"      ) ;
  array_push ( $S , "receptionist" ) ;
  array_push ( $S , "item"         ) ;
  array_push ( $S , "lecture"      ) ;
  array_push ( $S , "description"  ) ;
  array_push ( $S , "period"       ) ;
  array_push ( $S , "start"        ) ;
  array_push ( $S , "end"          ) ;
  return $S                          ;
}

public function set($item,$V)
{
  $a = strtolower ( $item )                              ;
  if ( "id"           == $a ) $this -> Id           = $V ;
  if ( "uuid"         == $a ) $this -> Uuid         = $V ;
  if ( "type"         == $a ) $this -> Type         = $V ;
  if ( "used"         == $a ) $this -> Used         = $V ;
  if ( "states"       == $a ) $this -> States       = $V ;
  if ( "trainee"      == $a ) $this -> Trainee      = $V ;
  if ( "tutor"        == $a ) $this -> Tutor        = $V ;
  if ( "manager"      == $a ) $this -> Manager      = $V ;
  if ( "receptionist" == $a ) $this -> Receptionist = $V ;
  if ( "item"         == $a ) $this -> Item         = $V ;
  if ( "lecture"      == $a ) $this -> Lecture      = $V ;
  if ( "description"  == $a ) $this -> Description  = $V ;
  if ( "period"       == $a ) $this -> Period       = $V ;
  if ( "start"        == $a ) $this -> Start        = $V ;
  if ( "end"          == $a ) $this -> End          = $V ;
  if ( "ltime"        == $a ) $this -> Update       = $V ;
}

public function get($item)
{
  $a = strtolower ( $item )                                         ;
  if ( "id"           == $a ) return (string) $this -> Id           ;
  if ( "uuid"         == $a ) return (string) $this -> Uuid         ;
  if ( "type"         == $a ) return (string) $this -> Type         ;
  if ( "used"         == $a ) return (string) $this -> Used         ;
  if ( "states"       == $a ) return (string) $this -> States       ;
  if ( "trainee"      == $a ) return (string) $this -> Trainee      ;
  if ( "tutor"        == $a ) return (string) $this -> Tutor        ;
  if ( "manager"      == $a ) return (string) $this -> Manager      ;
  if ( "receptionist" == $a ) return (string) $this -> Receptionist ;
  if ( "item"         == $a ) return (string) $this -> Item         ;
  if ( "lecture"      == $a ) return (string) $this -> Lecture      ;
  if ( "description"  == $a ) return (string) $this -> Description  ;
  if ( "period"       == $a ) return (string) $this -> Period       ;
  if ( "start"        == $a ) return (string) $this -> Start        ;
  if ( "end"          == $a ) return (string) $this -> End          ;
  if ( "ltime"        == $a ) return (string) $this -> Update       ;
  return ""                                                         ;
}


public function ItemPair($item)
{
  $a = strtolower ( $item )                             ;
  if ( "id"           == $a )                           {
    return "`{$a}` = " . (string) $this -> Id           ;
  }                                                     ;
  if ( "uuid"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Uuid         ;
  }                                                     ;
  if ( "type"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Type         ;
  }                                                     ;
  if ( "used"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Used         ;
  }                                                     ;
  if ( "states"       == $a )                           {
    return "`{$a}` = " . (string) $this -> States       ;
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
  if ( "receptionist" == $a )                           {
    return "`{$a}` = " . (string) $this -> Receptionist ;
  }                                                     ;
  if ( "item"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Item         ;
  }                                                     ;
  if ( "lecture"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Lecture      ;
  }                                                     ;
  if ( "description"  == $a )                           {
    return "`{$a}` = " . (string) $this -> Description  ;
  }                                                     ;
  if ( "period"       == $a )                           {
    return "`{$a}` = " . (string) $this -> Period       ;
  }                                                     ;
  if ( "start"        == $a )                           {
    return "`{$a}` = " . (string) $this -> Start        ;
  }                                                     ;
  if ( "end"          == $a )                           {
    return "`{$a}` = " . (string) $this -> End          ;
  }                                                     ;
  if ( "ltime"        == $a )                           {
    return "`{$a}` = " . (string) $this -> Update       ;
  }                                                     ;
  return ""                                             ;
}

public function fromLecture($Lecture)
{
  $this -> set ( "Trainee"      , $Lecture -> Trainee      ) ;
  $this -> set ( "Tutor"        , $Lecture -> Tutor        ) ;
  $this -> set ( "Manager"      , $Lecture -> Manager      ) ;
  $this -> set ( "Receptionist" , $Lecture -> Receptionist ) ;
  $this -> set ( "Item"         , $Lecture -> Item         ) ;
  $this -> set ( "Lecture"      , $Lecture -> Uuid         ) ;
}

public function Pair($item)
{
  return "`" . $item . "` = " . $this -> get ( $item ) ;
}

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

public function isCancelled()
{
  return ( $this -> Type == 3 ) ;
}

public function isAbsent($ROLE)
{
  $r = strtolower ( $ROLE )         ;
  if ( $r == "trainee" )            {
    $v = $this -> StudentStates ( ) ;
    switch ( $v )                   {
      case  0: // 不能上課
      case  3: // 發生異議
      case  8: // 授課中斷
      case  9: // 發生意外
      case 10: // 臨時缺課
      case 11: // 私事請假
      return true                   ;
    }                               ;
  } else
  if ( $r == "tutor"   )            {
    $v = $this -> TutorStates   ( ) ;
    switch ( $v )                   {
      case  0: // 不商量
      case 10: // 授課中斷
      case 11: // 發生意外
      case 12: // 臨時缺課
      case 13: // 私事請假
      return true                   ;
    }                               ;
  }                                 ;
  return false                      ;
}

public function ClassTypeString()
{
  global $ClassTypeIDs                   ;
  return $ClassTypeIDs [ $this -> Type ] ;
}

public function setStudent($ST)
{
  if ( $ST < 0 ) return                                  ;
  $TS    = $this -> TutorStates ( )                      ;
  $this -> States = intval ( ( $TS * 1000 ) + $ST , 10 ) ;
}

public function StudentStates()
{
  $ST = $this -> States             ;
  return intval ( $ST % 1000 , 10 ) ;
}

public function StudentString()
{
  global $StudentWeekly            ;
  $SS = $this -> StudentStates ( ) ;
  return $StudentWeekly [ $SS ]    ;
}

public function StudentListing()
{
  global $StudentWeekly                                      ;
  $JSC = "ClassStates(this.value,'student','$this->Uuid') ;" ;
  $SS  = $this -> StudentStates (                       )    ;
  $HS  = new HtmlTag            (                       )    ;
  $HS -> setTag                 ( "select"              )    ;
  $HS -> addOptions             ( $StudentWeekly , $SS  )    ;
  $HS -> AddPair                ( "onchange"     , $JSC )    ;
  return $HS                                                 ;
}

public function setTutor($ST)
{
  if ( $ST < 0 ) return                                  ;
  $SS    = $this -> StudentStates ( )                    ;
  $this -> States = intval ( ( $ST * 1000 ) + $SS , 10 ) ;
}

public function TutorStates()
{
  $ST = $this -> States             ;
  return intval ( $ST / 1000 , 10 ) ;
}

public function TutorString()
{
  global $TutorWeekly            ;
  $TS = $this -> TutorStates ( ) ;
  return $TutorWeekly [ $TS ]    ;
}

public function TutorListing()
{
  global $TutorWeekly                                      ;
  $JSC = "ClassStates(this.value,'tutor','$this->Uuid') ;" ;
  $SS  = $this -> TutorStates (                     )      ;
  $HS  = new HtmlTag          (                     )      ;
  $HS -> setTag               ( "select"            )      ;
  $HS -> addOptions           ( $TutorWeekly , $SS  )      ;
  $HS -> AddPair              ( "onchange"   , $JSC )      ;
  return $HS                                               ;
}

public function setPeriod($PERIODE)
{
  $this -> Period = $PERIODE -> Uuid  ;
  $this -> Start  = $PERIODE -> Start ;
  $this -> End    = $PERIODE -> End   ;
}

public function toPeriod()
{
  $PERIODE  = new Periode ( )         ;
  $PERIODE -> Uuid  = $this -> Period ;
  $PERIODE -> Start = $this -> Start  ;
  $PERIODE -> End   = $this -> End    ;
  return $PERIODE                     ;
}

public function toString()
{
  $U = $this -> Uuid                                         ;
  $H = substr    ( $U , 0 , 11                             ) ;
  if ( $H != "36000000000" ) return ""                       ;
  return sprintf ( "cls3%08d" , gmp_mod ( $U , 100000000 ) ) ;
}

public function fromString ( $CLASSID )
{
  ////////////////////////////////////////////////////
  if               ( 12 != strlen ( $CLASSID )     ) {
    $this -> Uuid = 0                                ;
    return 0                                         ;
  }                                                  ;
  ////////////////////////////////////////////////////
  $X = strtolower  ( $CLASSID                      ) ;
  $C = substr      ( $X , 0 , 4                    ) ;
  if               ( $C != "cls3"                  ) {
    $this -> Uuid = 0                                ;
    return 0                                         ;
  }                                                  ;
  ////////////////////////////////////////////////////
  $C = substr      ( $CLASSID , 0 , 4              ) ;
  $U = str_replace ( $C , "36000000000" , $CLASSID ) ;
  $this -> Uuid = $U                                 ;
  ////////////////////////////////////////////////////
  return $U                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// +| toJsonWithTimestamp |+
//////////////////////////////////////////////////////////////////////////////
public function toJsonWithTimestamp      (                                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $NOW      = new StarDate               (                                 ) ;
  $JSOX     = $this -> toJson            (                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NOW     -> Stardate = $this -> Start                                      ;
  $JSOX [ "StartTimestamp" ] = $NOW -> Timestamp ( )                         ;
  ////////////////////////////////////////////////////////////////////////////
  $NOW     -> Stardate = $this -> End                                        ;
  $JSOX [ "EndTimestamp"   ] = $NOW -> Timestamp ( )                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $JSOX                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
// -| toJsonWithTimestamp |-
//////////////////////////////////////////////////////////////////////////////
public function ClassTime($TZ)
{
  $SSD  = new StarDate ( )                 ;
  $ESD  = new StarDate ( )                 ;
  //////////////////////////////////////////
  $SSD -> Stardate = $this -> Start        ;
  $ESD -> Stardate = $this -> End          ;
  //////////////////////////////////////////
  $SDD  = $SSD -> toDateTime ( $TZ )       ;
  $EDD  = $ESD -> toDateTime ( $TZ )       ;
  //////////////////////////////////////////
  $SDS  = $SDD -> format ( "Y/m/d H:i:s" ) ;
  $EDS  = $EDD -> format ( "Y/m/d H:i:s" ) ;
  //////////////////////////////////////////
  unset ( $SSD )                           ;
  unset ( $ESD )                           ;
  //////////////////////////////////////////
  return $SDS . " - " . $EDS               ;
}

public function obtain($R)
{
  $this -> Id           = $R [ "id"           ] ;
  $this -> Uuid         = $R [ "uuid"         ] ;
  $this -> Type         = $R [ "type"         ] ;
  $this -> Used         = $R [ "used"         ] ;
  $this -> States       = $R [ "states"       ] ;
  $this -> Trainee      = $R [ "trainee"      ] ;
  $this -> Tutor        = $R [ "tutor"        ] ;
  $this -> Manager      = $R [ "manager"      ] ;
  $this -> Receptionist = $R [ "receptionist" ] ;
  $this -> Item         = $R [ "item"         ] ;
  $this -> Lecture      = $R [ "lecture"      ] ;
  $this -> Description  = $R [ "description"  ] ;
  $this -> Period       = $R [ "period"       ] ;
  $this -> Start        = $R [ "start"        ] ;
  $this -> End          = $R [ "end"          ] ;
  $this -> Update       = $R [ "ltime"        ] ;
}

public function GetUuid ( $DB , $Table , $Main )
{
  global $DataTypes                                          ;
  $BASE         = "3600000000000000000"                      ;
  $TYPE         = $DataTypes [ "Class" ]                     ;
  $this -> Uuid = $DB -> GetLast ( $Table , "uuid" , $BASE ) ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false   ;
  $DB -> AddUuid ( $Main , $this -> Uuid , $TYPE )           ;
  return $this -> Uuid                                       ;
}

public function UpdateItems($DB,$TABLE,$ITEMS)
{
  $QQ    = "update " . $TABLE . " set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )                ;
  return $DB -> Query ( $QQ )                                       ;
}

public function Update($DB,$TABLE)
{
  $ITEMS = $this -> valueItems ( )                                  ;
  $QQ    = "update " . $TABLE . " set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )                ;
  unset ( $ITEMS )                                                  ;
  return $DB -> Query ( $QQ )                                       ;
}

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

public function ObtainsByUuid($DB,$TABLE)
{
  $QQ = "select " . $this -> Items ( ) . " from " . $TABLE .
        $DB -> WhereUuid ( $this -> Uuid , true )          ;
  return $this -> ObtainsByQuery ( $DB , $QQ )             ;
}

public function ObtainsByLectures($DB,$TABLE,$LECTURES,$NOW,$ORDER="desc")
{
  $UU  = array ( )                              ;
  ///////////////////////////////////////////////
  if ( count ( $LECTURES ) <= 0 ) return $UU    ;
  ///////////////////////////////////////////////
  $LST = implode ( " , " , $LECTURES )          ;
  $QQ  = "select `uuid` from " . $TABLE         .
          " where ( `lecture` in ( {$LST} ) ) " .
             "and ( `end` < {$NOW} )"           .
          " order by `start` {$ORDER} ;"        ;
  $UU = $DB -> ObtainUuids ( $QQ )              ;
  ///////////////////////////////////////////////
  return $UU                                    ;
}

public function ObtainsClasses($DB,$CLASSES,$ITEM,$ORDER="asc")
{
  $VV = $this -> get ( $ITEM )          ;
  $QQ = "select `uuid` from {$CLASSES}" .
        " where `" . $ITEM ."` = {$VV}" .
        " order by `start` {$ORDER} ;"  ;
  return $DB -> ObtainUuids ( $QQ )     ;
}

public function ObtainItems($DB,$TABLE,$ITEM,$ORDER="desc",$LIMITS="")
{
  $DOCS = array ( )                                    ;
  $CUIX = $this -> Uuid                                ;
  $QQ   = "select `note` from {$TABLE}"                .
          " where `uuid` = {$CUIX}"                    .
          " and `name` = '{$ITEM}'"                    .
          " order by `prefer` {$ORDER} {$LIMITS};"     ;
  $qq   = $DB -> Query ( $QQ )                         ;
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      $NV = $rr [ 0 ]                                  ;
      array_push ( $DOCS , $NV )                       ;
    }                                                  ;
  }                                                    ;
  return $DOCS                                         ;
}

public function ObtainAge($DB,$TABLE,$TZ)
{
  $PQ     = NewParameter ( 1 , 17 , "Ages" )                             ;
  $PQ    -> setTable     ( $TABLE          )                             ;
  ////////////////////////////////////////////////////////////////////////
  $VDM             = 0                                                   ;
  $VDX             = 0                                                   ;
  $CDM             = new StarDate   (                 )                  ;
  $CDX             = new StarDate   (                 )                  ;
  $CDM -> Stardate = $PQ -> Value ( $DB , $this -> Trainee , "Minimum" ) ;
  $CDX -> Stardate = $PQ -> Value ( $DB , $this -> Trainee , "Maximum" ) ;
  if ( gmp_cmp ( $CDM -> Stardate , "0" ) > 0 )                          {
    $MAXV = $CDM -> YearsOld ( $TZ )                                     ;
  }                                                                      ;
  if ( gmp_cmp ( $CDX -> Stardate , "0" ) > 0 )                          {
    $MINV = $CDX -> YearsOld ( $TZ )                                     ;
  }                                                                      ;
  ////////////////////////////////////////////////////////////////////////
  $HST  = ""                                                             ;
  ////////////////////////////////////////////////////////////////////////
  if ( ( $MINV >  0 ) and ( $MAXV > 0 ) )                                {
    $HST = $MINV . " - " . $MAXV . " years old"                          ;
  } else
  if ( ( $MINV == 0 ) and ( $MAXV > 0 ) )                                {
    $HST = $MAXV . " years old"                                          ;
  }                                                                      ;
  ////////////////////////////////////////////////////////////////////////
  return $HST                                                            ;
}

public function ObtainCourses($DB,$RELATIONS)
{
  $RI      = new Relation         (                         ) ;
  $RI     -> set                  ( "first" , $this -> Uuid ) ;
  $RI     -> setT1                ( "Class"                 ) ;
  $RI     -> setT2                ( "Course"                ) ;
  $RI     -> setRelation          ( "Contains"              ) ;
  $COURSES = $RI -> Subordination ( $DB , $RELATIONS        ) ;
  unset                           ( $RI                     ) ;
  return $COURSES                                             ;
}

public function JoinCourses ( $DB , $RELATIONS , $COURSES ) {
  ///////////////////////////////////////////////////////////
  $RI  = new Relation       (                             ) ;
  ///////////////////////////////////////////////////////////
  $RI -> set                ( "first" , $this -> Uuid     ) ;
  $RI -> setT1              ( "Class"                     ) ;
  $RI -> setT2              ( "Course"                    ) ;
  $RI -> setRelation        ( "Contains"                  ) ;
  $RI -> Joins              ( $DB , $RELATIONS , $COURSES ) ;
  ///////////////////////////////////////////////////////////
  unset                     ( $RI                         ) ;
  ///////////////////////////////////////////////////////////
  return $COURSES                                           ;
}

public function RemoveCourse ( $DB , $RELATION , $COURSE                   ) {
  $RI   = new Relation       (                                             ) ;
  $RI  -> set                ( "first"  , $this -> Uuid                    ) ;
  $RI  -> set                ( "second" , $COURSE                          ) ;
  $RI  -> setT1              ( "Class"                                     ) ;
  $RI  -> setT2              ( "Course"                                    ) ;
  $RI  -> setRelation        ( "Contains"                                  ) ;
  $QQ   = $RI -> Delete      ( $RELATION                                   ) ;
  $DB  -> Query              ( $QQ                                         ) ;
}

public function ObtainLessons($DB,$RELATIONS)
{
  $RI      = new Relation         (                         ) ;
  $RI     -> set                  ( "first" , $this -> Uuid ) ;
  $RI     -> setT1                ( "Class"                 ) ;
  $RI     -> setT2                ( "Lesson"                ) ;
  $RI     -> setRelation          ( "Contains"              ) ;
  $LESSONS = $RI -> Subordination ( $DB , $RELATIONS        ) ;
  unset                           ( $RI                     ) ;
  return $LESSONS                                             ;
}

public function ObtainIcon($DB,$RELATION,$ITEM,$Relevance="Using")
{
  $DID = "3800000000000000041"                                     ;
  //////////////////////////////////////////////////////////////////
  $RI  = new RelationItem     (                                  ) ;
  $RI -> set                  ( "first" , $this -> get ( $ITEM ) ) ;
  $RI -> setT1                ( "People"                         ) ;
  $RI -> setT2                ( "Picture"                        ) ;
  $RI -> setRelation          ( $Relevance                       ) ;
  $UX  = $RI -> Subordination ( $DB , "`erp`.`relations`"        ) ;
  //////////////////////////////////////////////////////////////////
  if ( count ( $UX ) > 0 ) $DID = $UX [ 0 ]                        ;
  //////////////////////////////////////////////////////////////////
  return $DID                                                      ;
}

public function IconTag($PATH,$ID)
{
  $SRC = "{$PATH}?ID={$ID}"           ;
  $HT  = new HtmlTag (              ) ;
  $HT -> setTag      ( "img"        ) ;
  $HT -> AddPair     ( "src" , $SRC ) ;
  return $HT                          ;
}

public function ClassInItem($DB,$TABLE,$CLASSES,$ITEM,$ORDER="desc")
{
  if ( count ( $CLASSES ) <= 0 ) return array ( ) ;
  $INSIDE = implode ( " , " , $CLASSES )          ;
  $QQ = "select `uuid` from {$TABLE}"             .
        " where ( `item` = {$ITEM} )"             .
        " and ( `uuid` in ( {$INSIDE} ) )"        .
        " order by `start` {$ORDER} ;"            ;
  return $DB -> ObtainUuids ( $QQ )               ;
}

public function SearchClasses($DB,$TABLE,$PUID,$TYPE,$ITEM,$STARTTIME,$ENDTIME)
{
  $STARTTIME = gmp_add ( $STARTTIME , -1 )             ;
  $ENDTIME   = gmp_add ( $ENDTIME   ,  1 )             ;
  //////////////////////////////////////////////////////
  $AR        = array ( )                               ;
  $QQ        = "select `uuid` from {$TABLE}"           .
               " where `{$ITEM}` = {$PUID}"            .
                  " and ( `type` = {$TYPE} )"          .
                 " and ( ( `end` > {$STARTTIME} )"     .
                 " and ( `start` < ${ENDTIME} ) )"     .
               " order by `start` desc ;"              ;
  $qq        = $DB -> Query ( $QQ )                    ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $qq ) )                      {
    while ( $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ) {
      array_push ( $AR , $rr [ 0 ] )                   ;
    }                                                  ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return $AR                                           ;
}

public function CalendarRenderScript()
{
  $F1   = "$(element).on({\n"                                                .
        "dblclick: function() { CalendarClicked ( event,element ) ; }\n"     .
        "});"                                                                ;
  $F2   = "if ( event.chat ) {\n"                                            .
          "var a = element.find('div.fc-content');\n"                        .
          "var t = a . html ( ) ;\n"                                         .
          "var i = \"<a href='skype:\" + event.chat + \"?chat'><img src='/images/skype.png' width=12 height=12>\" + event.chat + \"</a>\"\n" .
          "var x = \"<table><tbody><tr><td nowrap='nowrap'>\" + i + \"</td></tr><tr><td>\" + t + \"</td></tr></tbody></table>\"\n ;" .
          "a.html( x ) ;\n"                                                  .
          "};"                                                               ;
  $F3   = "if ( event.icon ) {\n"                                            .
          "var a = element.find('div.fc-content');\n"                        .
          "var t = a . html ( ) ;\n"                                         .
          "var i = \"<img src='\" + event.icon + \"' width=32 height=32>\"\n" .
          "var x = \"<table><tbody><tr><td width=32px>\" + i + \"</td><td>\" + t + \"</td></tr></tbody></table>\"\n ;" .
          "a.html( x ) ;\n"                                                  .
          "};"                                                               ;
  $CDCF = "function ( event , element ) {\n{$F1}\n{$F2}\n{$F3} }"            ;
  return $CDCF                                                               ;
}

public function SkypeID($DB,$TABLE,$CUID)
{
  $IMP = "0"                                       ;
  $RI  = new Relation         (                  ) ;
  $RI -> set                  ( "first" , $CUID  ) ;
  $RI -> setT1                ( "People"         ) ;
  $RI -> setT2                ( "InstantMessage" ) ;
  $RI -> setRelation          ( "Subordination"  ) ;
  $UX  = $RI -> Subordination ( $DB , $TABLE     ) ;
  if ( count ( $UX ) > 0 ) $IMP = $UX [ 0 ]        ;
  return $IMP                                      ;
}

public function IconID($DB,$TABLE,$CUID)
{
  $DID = "3800000000000000041"                    ;
  /////////////////////////////////////////////////
  $RI  = new RelationItem     (                 ) ;
  $RI -> set                  ( "first" , $CUID ) ;
  $RI -> setT1                ( "People"        ) ;
  $RI -> setT2                ( "Picture"       ) ;
  $RI -> setRelation          ( "Using"         ) ;
  $UX  = $RI -> Subordination ( $DB , $TABLE    ) ;
  if ( count ( $UX ) > 0 ) $DID = $UX [ 0 ]       ;
  /////////////////////////////////////////////////
  return $DID                                     ;
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

public function StudentJson($DB,$TZ,$NAME,$CLASSID,$NOW)
{
  ///////////////////////////////////////////////////////////////////////////
  global $Translations                                                      ;
  ///////////////////////////////////////////////////////////////////////////
  $HH   = new Parameters      (                           )                 ;
  $RI   = new RelationItem    (                           )                 ;
  ///////////////////////////////////////////////////////////////////////////
  $DID  = $this -> IconID     ( $DB,"`erp`.`relations`",$this -> Tutor    ) ;
  $SRC = "/students/icon.php?ID={$DID}"                                     ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> ClassString ( $this -> Uuid            )                  ;
  $TNS  = $DB  -> GetTutor    ( $NAME , $this -> Tutor   )                  ;
  $XNS  = array ( )                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  // Skype帳號
  ///////////////////////////////////////////////////////////////////////////
  $IMP   = $this -> SkypeID ( $DB , "`erp`.`relations`" , $this -> Tutor )  ;
  ///////////////////////////////////////////////////////////////////////////
  $SKYPE = ""                                                               ;
  if                          ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp         (                                           ) ;
    $IMA -> Uuid = $IMP                                                     ;
    if ( $IMA -> ObtainsByUuid ( $DB , "`erp`.`instantmessage`" ) )         {
      $SKYPE = $IMA -> Account                                              ;
    }                                                                       ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  $LTN  = $Translations [ "Classes::LecturingTutor" ]                       ;
  $CIX  = $Translations [ "ClassID"                 ]                       ;
  if ( $this -> isCancelled ( ) )                                           {
    array_push ( $XNS , $this -> ClassTypeString ( ) )                      ;
  }                                                                         ;
  array_push ( $XNS , "{$LTN}{$TNS}"  )                                     ;
  array_push ( $XNS , "{$CIX}{$CIDS}" )                                     ;
  if ( $this -> isAbsent ( "trainee" ) )                                    {
    $XXV = $Translations [ "Classes::Student" ]                             ;
    $SST = $this -> StudentString   ( )                                     ;
    array_push ( $XNS , "{$XXV}{$SST}" )                                    ;
  } else
  if ( $this -> isAbsent ( "tutor"   ) )                                    {
    $XXV = $Translations [ "Classes::Tutor" ]                               ;
    $SST = $this -> TutorString     ( )                                     ;
    array_push ( $XNS , "{$XXV}{$SST}" )                                    ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  $TIDS = implode ( "\\n" , $XNS )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  $PRD  = $this -> toPeriod ( )                                             ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $CIDS                              ) ;
  $JSC -> JsonSqString ( "className" , $CLASSID                           ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  if                   ( strlen ( $SKYPE ) > 0                            ) {
    $JSC -> JsonSqString ( "chat"  , $SKYPE                               ) ;
  }                                                                         ;
  $JSC -> JsonSqString ( "icon"      , $SRC                               ) ;
  $JSC -> JsonValue    ( "allDay"    , "false"                            ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toTimeString ( $TZ , "start" ) ) ;
  $JSC -> JsonSqString ( "end"   , $PRD -> toTimeString ( $TZ , "end"   ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  switch ( $PRD -> Between ( $NOW ) )                                       {
    case -1                                                                 :
      if ( $this -> isCancelled ( ) )                                       {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#eeccff" )                      ;
        }                                                                   ;
      } else                                                                {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#ffcc99" )                      ;
        }                                                                   ;
      }                                                                     ;
    break                                                                   ;
    case  0                                                                 :
      if ( $this -> isCancelled ( ) )                                       {
        $JSC -> JsonSqString ( "color" , "#ff7755" )                        ;
      } else                                                                {
        $JSC -> JsonSqString ( "backgroundColor" , "#bbff99" )              ;
        $JSC -> JsonSqString ( "textColor"       , "#0000ff" )              ;
        $JSC -> JsonSqString ( "borderColor"     , "#ffcc99" )              ;
      }                                                                     ;
    break                                                                   ;
    case  1                                                                 :
      if ( $this -> isCancelled ( ) )                                       {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#7799cc" )                      ;
        }                                                                   ;
      } else                                                                {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#99ccFF" )                      ;
        }                                                                   ;
      }                                                                     ;
    break                                                                   ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}

public function StudentClasses($DB,$TZ,$JAVA,$CLASSES,$NAME,$CLASSID,$NOW)
{
  $UU = $this -> ObtainsClasses ( $DB , $CLASSES , "trainee" ) ;
  foreach ( $UU as $uu )                                       {
    $this -> Uuid = $uu                                        ;
    if ( $this -> ObtainsByUuid ( $DB , $CLASSES ) )           {
      if ( $this -> Type != 5 )                                {
        $JAVA    -> AddChild                                   (
          $this  -> StudentJson                                (
            $DB                                                ,
            $TZ                                                ,
            $NAME                                              ,
            $CLASSID                                           ,
            $NOW                                           ) ) ;
      }                                                        ;
    }                                                          ;
  }                                                            ;
}

public function TutorJson($DB,$TZ,$NAME,$CLASSID,$NOW)
{
  ///////////////////////////////////////////////////////////////////////////
  global $Translations                                                      ;
  ///////////////////////////////////////////////////////////////////////////
  $HH   = new Parameters      (                            )                ;
  $RI   = new RelationItem    (                            )                ;
  ///////////////////////////////////////////////////////////////////////////
  $DID  = $this -> IconID     ( $DB,"`erp`.`relations`",$this -> Trainee  ) ;
  $SRC = "/tutors/icon.php?ID={$DID}"                                       ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> ClassString ( $this -> Uuid            )                  ;
  $TNS  = $DB  -> GetTrainee  ( $NAME , $this -> Trainee )                  ;
  $XNS  = array ( )                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  // Skype帳號
  ///////////////////////////////////////////////////////////////////////////
  $IMP   = $this -> SkypeID ( $DB , "`erp`.`relations`" , $this -> Trainee ) ;
  ///////////////////////////////////////////////////////////////////////////
  $SKYPE = ""                                                               ;
  if                          ( gmp_cmp ( $IMP , "0" ) > 0                ) {
    $IMA  = new ImApp         (                                           ) ;
    $IMA -> Uuid = $IMP                                                     ;
    if ( $IMA -> ObtainsByUuid ( $DB , "`erp`.`instantmessage`" ) )         {
      $SKYPE = $IMA -> Account                                              ;
    }                                                                       ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  $LTN  = $Translations [ "Classes::LecturingTrainee" ]                     ;
  $CIX  = $Translations [ "ClassID"                   ]                     ;
  if ( $this -> isCancelled ( ) )                                           {
    array_push ( $XNS , $this -> ClassTypeString ( ) )                      ;
  }                                                                         ;
  array_push ( $XNS , "{$LTN}{$TNS}"  )                                     ;
  array_push ( $XNS , "{$CIX}{$CIDS}" )                                     ;
  if ( $this -> isAbsent ( "trainee" ) )                                    {
    $XXV = $Translations [ "Classes::Student" ]                             ;
    $SST = $this -> StudentString   ( )                                     ;
    array_push ( $XNS , "{$XXV}{$SST}" )                                    ;
  } else
  if ( $this -> isAbsent ( "tutor"   ) )                                    {
    $XXV = $Translations [ "Classes::Tutor" ]                               ;
    $SST = $this -> TutorString     ( )                                     ;
    array_push ( $XNS , "{$XXV}{$SST}" )                                    ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  $TIDS = implode ( "\\n" , $XNS )                                          ;
  $PRD  = $this -> toPeriod ( )                                             ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $CIDS                              ) ;
  $JSC -> JsonSqString ( "className" , $CLASSID                           ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  if                   ( strlen ( $SKYPE ) > 0                            ) {
    $JSC -> JsonSqString ( "chat"  , $SKYPE                               ) ;
  }                                                                         ;
  $JSC -> JsonSqString ( "icon"      , $SRC                               ) ;
  $JSC -> JsonValue    ( "allDay"    , "false"                            ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toTimeString ( $TZ , "start" ) ) ;
  $JSC -> JsonSqString ( "end"   , $PRD -> toTimeString ( $TZ , "end"   ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  switch ( $PRD -> Between ( $NOW ) )                                       {
    case -1                                                                 :
      if ( $this -> isCancelled ( ) )                                       {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#eeccff" )                      ;
        }                                                                   ;
      } else                                                                {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#ffcc99" )                      ;
        }                                                                   ;
      }                                                                     ;
    break                                                                   ;
    case  0                                                                 :
      if ( $this -> isCancelled ( ) )                                       {
        $JSC -> JsonSqString ( "color" , "#ff7755" )                        ;
      } else                                                                {
        $JSC -> JsonSqString ( "backgroundColor" , "#bbff99" )              ;
        $JSC -> JsonSqString ( "textColor"       , "#0000ff" )              ;
        $JSC -> JsonSqString ( "borderColor"     , "#ffcc99" )              ;
      }                                                                     ;
    break                                                                   ;
    case  1                                                                 :
      if ( $this -> isCancelled ( ) )                                       {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#7799cc" )                      ;
        }                                                                   ;
      } else                                                                {
        if ( $this -> isAbsent ( "trainee" ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff7755" )                      ;
        } else
        if ( $this -> isAbsent ( "tutor"   ) )                              {
          $JSC -> JsonSqString ( "color" , "#ff2277" )                      ;
        } else                                                              {
          $JSC -> JsonSqString ( "color" , "#99ccFF" )                      ;
        }                                                                   ;
      }                                                                     ;
    break                                                                   ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}

public function OfficerJson($DB,$TZ,$NAME,$CLASSID,$NOW)
{
  $HH   = new Parameters      (                        )                    ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> ClassString ( $this -> Uuid            )                  ;
  $SNS  = $DB  -> GetStudent  ( $NAME , $this -> Trainee )                  ;
  $TNS  = $DB  -> GetTutor    ( $NAME , $this -> Tutor   )                  ;
  $TIDS = "學員:" . $SNS . "\\n"                                             .
          "教員:" . $TNS . "\\n"                                             .
          "課號:" . $CIDS                                                    ;
  $PRD  = $this -> toPeriod ( )                                             ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $CIDS                              ) ;
  $JSC -> JsonSqString ( "className" , $CLASSID                           ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  $JSC -> JsonValue    ( "allDay"    , "false"                            ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toTimeString ( $TZ , "start" ) ) ;
  $JSC -> JsonSqString ( "end"   , $PRD -> toTimeString ( $TZ , "end"   ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  switch ( $PRD -> Between ( $NOW ) )                                       {
    case -1                                                                 :
      $JSC -> JsonSqString ( "color" , "#ffcc99" )                          ;
    break                                                                   ;
    case  0                                                                 :
      $JSC -> JsonSqString ( "backgroundColor" , "#bbff99" )                ;
      $JSC -> JsonSqString ( "textColor"       , "#0000ff" )                ;
      $JSC -> JsonSqString ( "borderColor"     , "#ffcc99" )                ;
    break                                                                   ;
    case  1                                                                 :
      $JSC -> JsonSqString ( "color" , "#99ccFF" )                          ;
    break                                                                   ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}

public function TutorClasses($DB,$TZ,$JAVA,$CLASSES,$NAME,$CLASSID,$NOW)
{
  $UU = $this -> ObtainsClasses ( $DB , $CLASSES , "tutor" ) ;
  foreach ( $UU as $uu )                                     {
    $this -> Uuid = $uu                                      ;
    if ( $this -> ObtainsByUuid ( $DB , $CLASSES ) )         {
      $JAVA    -> AddChild                                   (
        $this  -> TutorJson                                  (
          $DB                                                ,
          $TZ                                                ,
          $NAME                                              ,
          $CLASSID                                           ,
          $NOW                                           ) ) ;
    }                                                        ;
  }                                                          ;
}

public function OfficerClasses($DB,$TZ,$JAVA,$CLASSES,$NAME,$CLASSID,$NOW)
{
  $UU = $this -> ObtainsClasses ( $DB , $CLASSES , "manager" ) ;
  foreach ( $UU as $uu )                                       {
    $this -> Uuid = $uu                                        ;
    if ( $this -> ObtainsByUuid ( $DB , $CLASSES ) )           {
      $JAVA    -> AddChild                                     (
        $this  -> OfficerJson                                  (
          $DB                                                  ,
          $TZ                                                  ,
          $NAME                                                ,
          $CLASSID                                             ,
          $NOW                                             ) ) ;
    }                                                          ;
  }                                                            ;
}

public function PartnerJson($DB,$TZ,$NAME,$CLASSID,$NOW)
{
  $HH   = new Parameters      (                        )                    ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> ClassString ( $this -> Uuid          )                    ;
  $SNS  = $DB  -> GetStudent  ( $NAME , $this -> Trainee )                  ;
  $TNS  = $DB  -> GetTutor    ( $NAME , $this -> Tutor   )                  ;
  $TIDS = "學員:" . $SNS . "\\n"                                             .
          "教員:" . $TNS . "\\n"                                             .
          "課號:" . $CIDS                                                    ;
  $PRD  = $this -> toPeriod ( )                                             ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $CIDS                              ) ;
  $JSC -> JsonSqString ( "className" , $CLASSID                           ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  $JSC -> JsonValue    ( "allDay"    , "false"                            ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toTimeString ( $TZ , "start" ) ) ;
  $JSC -> JsonSqString ( "end"   , $PRD -> toTimeString ( $TZ , "end"   ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  switch ( $PRD -> Between ( $NOW ) )                                       {
    case -1                                                                 :
      $JSC -> JsonSqString ( "color" , "#ffcc99" )                          ;
    break                                                                   ;
    case  0                                                                 :
      $JSC -> JsonSqString ( "backgroundColor" , "#bbff99" )                ;
      $JSC -> JsonSqString ( "textColor"       , "#0000ff" )                ;
      $JSC -> JsonSqString ( "borderColor"     , "#ffcc99" )                ;
    break                                                                   ;
    case  1                                                                 :
      $JSC -> JsonSqString ( "color" , "#99ccFF" )                          ;
    break                                                                   ;
  }                                                                         ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}

public function PartnerClasses($DB,$TZ,$JAVA,$CLASSES,$NAME,$CLASSID,$NOW)
{
  $UU = $this -> ObtainsClasses ( $DB , $CLASSES , "trainee" ) ;
  foreach ( $UU as $uu )                                       {
    $this -> Uuid = $uu                                        ;
    if ( $this -> ObtainsByUuid ( $DB , $CLASSES ) )           {
      $JAVA    -> AddChild                                     (
        $this  -> PartnerJson                                  (
          $DB                                                  ,
          $TZ                                                  ,
          $NAME                                                ,
          $CLASSID                                             ,
          $NOW                                             ) ) ;
    }                                                          ;
  }                                                            ;
}

public function ReceptionistClasses($DB,$TZ,$JAVA,$CLASSES,$NAME,$CLASSID,$NOW)
{
  $UU = $this -> ObtainsClasses ( $DB , $CLASSES , "receptionist" ) ;
  foreach ( $UU as $uu )                                            {
    $this -> Uuid = $uu                                             ;
    if ( $this -> ObtainsByUuid ( $DB , $CLASSES ) )                {
      $JAVA    -> AddChild                                          (
        $this  -> TutorJson                                         (
          $DB                                                       ,
          $TZ                                                       ,
          $NAME                                                     ,
          $CLASSID                                                  ,
          $NOW                                                  ) ) ;
    }                                                               ;
  }                                                                 ;
}

public function addClassDetails($CLASSID="SelectionButton")
{
  /////////////////////////////////////////////////////////////
  global $Translations                                        ;
  /////////////////////////////////////////////////////////////
  $CID = $this -> toString ( )                                ;
  $CCJ = "ClassClicked('{$CID}')"                             ;
  $HB  = new HtmlTag (                                      ) ;
  $HB -> setTag      ( "button"                             ) ;
  $HB -> AddPair     ( "class"   , $CLASSID                 ) ;
  $HB -> AddPair     ( "onclick" , $CCJ                     ) ;
  $HB -> AddText     ( $Translations [ "Classes::Details" ] ) ;
  /////////////////////////////////////////////////////////////
  return $HB                                                  ;
}

public function addLectureDetails($CLASSID="SelectionButton")
{
  //////////////////////////////////////////////////////////////
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  $HH  = new Parameters       (                              ) ;
  $HL  = $HH -> LectureString ( $this -> Lecture             ) ;
  //////////////////////////////////////////////////////////////
  $LCJ = "LectureClicked('{$HL}')"                             ;
  //////////////////////////////////////////////////////////////
  $HB  = new HtmlTag (                                       ) ;
  $HB -> setTag      ( "button"                              ) ;
  $HB -> AddPair     ( "class"   , $CLASSID                  ) ;
  $HB -> AddPair     ( "onclick" , $LCJ                      ) ;
  $HB -> AddText     ( $Translations [ "Lectures::Details" ] ) ;
  //////////////////////////////////////////////////////////////
  unset              ( $HH                                   ) ;
  //////////////////////////////////////////////////////////////
  return $HB                                                   ;
}

public function addBriefIndex($HB,$COLS=4)
{
  $HR  = $HB -> addTr (                                ) ;
  $HD  = $HR -> addTd (                                ) ;
  $HD -> AddPair      ( "colspan" , $COLS              ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"           ) ;
  $HD -> AddPair      ( "align"   , "right"            ) ;
  $HD -> AddTag       ( $this -> addClassDetails   ( ) ) ;
  $HD -> AddTag       ( $this -> addLectureDetails ( ) ) ;
}

public function addDetails()
{
  global $Translations                                                  ;
  ///////////////////////////////////////////////////////////////////////
  $HH  = new Parameters       (                                       ) ;
  $HL  = $HH -> LectureString ( $this -> Lecture                      ) ;
  ///////////////////////////////////////////////////////////////////////
  $LCJ = "LectureClicked('{$HL}')"                                      ;
  ///////////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag          (                                       ) ;
  $HB -> setTag               ( "button"                              ) ;
  $HB -> AddPair              ( "class"   , "ClassButton"             ) ;
  $HB -> AddPair              ( "onclick" , $LCJ                      ) ;
  $HB -> AddText              ( $Translations [ "Lectures::Details" ] ) ;
  ///////////////////////////////////////////////////////////////////////
  unset                       ( $HH                                   ) ;
  ///////////////////////////////////////////////////////////////////////
  return $HB                                                            ;
}

public function addEdit($CLASSID="")
{
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  $HH   = new Parameters (                                   ) ;
  $CID  = $HH -> ClassString ( $this -> Uuid )                 ;
  $HBJ  = "ClassClicked('{$CID}')"                             ;
  $HBX  = new HtmlTag    (                                   ) ;
  //////////////////////////////////////////////////////////////
  $HBX -> setTag         ( "button"                          ) ;
  $HBX -> SafePair       ( "class"   , $CLASSID              ) ;
  $HBX -> AddPair        ( "onclick" , $HBJ                  ) ;
  $HBX -> AddText        ( $Translations [ "Classes::Edit" ] ) ;
  //////////////////////////////////////////////////////////////
  unset                  ( $HH                               ) ;
  //////////////////////////////////////////////////////////////
  return $HBX                                                  ;
}

public function addCallOff($TZ,$CLASSID="ClassButton")
{
  global $Translations                                               ;
  ////////////////////////////////////////////////////////////////////
  $HH  = new Parameters     (                                      ) ;
  $HL  = $HH -> ClassString ( $this -> Uuid                        ) ;
  ////////////////////////////////////////////////////////////////////
  $PRD = $this -> toPeriod     (                                   ) ;
  $ST  = $PRD  -> toTimeString ( $TZ , "start" )                     ;
  $ET  = $PRD  -> toTimeString ( $TZ , "end"   )                     ;
  $SCJ = "CallOffClass('{$HL}','{$ST}','{$ET}')"                     ;
  ////////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag        (                                      ) ;
  $HB -> setTag             ( "button"                             ) ;
  $HB -> SafePair           ( "class"   , $CLASSID                 ) ;
  $HB -> AddPair            ( "onclick" , $SCJ                     ) ;
  $HB -> AddText            ( $Translations [ "Classes::CallOff" ] ) ;
  ////////////////////////////////////////////////////////////////////
  unset                     ( $HH                                  ) ;
  ////////////////////////////////////////////////////////////////////
  return $HB                                                         ;
}

public function addStarting()
{
  global $Translations                                                ;
  /////////////////////////////////////////////////////////////////////
  $HH  = new Parameters     (                                       ) ;
  $HL  = $HH -> ClassString ( $this -> Uuid                         ) ;
  /////////////////////////////////////////////////////////////////////
  $SCJ = "StartingClass('{$HL}')"                                     ;
  /////////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag        (                                       ) ;
  $HB -> setTag             ( "button"                              ) ;
  $HB -> AddPair            ( "class"   , "ClassButton"             ) ;
  $HB -> AddPair            ( "onclick" , $SCJ                      ) ;
  $HB -> AddText            ( $Translations [ "Classes::Starting" ] ) ;
  /////////////////////////////////////////////////////////////////////
  unset                     ( $HH                                   ) ;
  /////////////////////////////////////////////////////////////////////
  return $HB                                                          ;
}

public function addEnding()
{
  global $Translations                                              ;
  ///////////////////////////////////////////////////////////////////
  $HH  = new Parameters     (                                     ) ;
  $HL  = $HH -> ClassString ( $this -> Uuid                       ) ;
  ///////////////////////////////////////////////////////////////////
  $SCJ = "EndingClass('{$HL}')"                                     ;
  ///////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag        (                                     ) ;
  $HB -> setTag             ( "button"                            ) ;
  $HB -> AddPair            ( "class"   , "ClassButton"           ) ;
  $HB -> AddPair            ( "onclick" , $SCJ                    ) ;
  $HB -> AddText            ( $Translations [ "Classes::Ending" ] ) ;
  ///////////////////////////////////////////////////////////////////
  unset                     ( $HH                                 ) ;
  ///////////////////////////////////////////////////////////////////
  return $HB                                                        ;
}

public function addEvaluation($URL)
{
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  $ETJ   = "window.location='{$URL}' ;"                        ;
  //////////////////////////////////////////////////////////////
  $HB  = new HtmlTag (                                       ) ;
  $HB -> setTag      ( "button"                              ) ;
  $HB -> AddPair     ( "class"   , "ClassButton"             ) ;
  $HB -> AddPair     ( "onclick" , $ETJ                      ) ;
  $HB -> AddText     ( $Translations [ "Classes::Evaluate" ] ) ;
  //////////////////////////////////////////////////////////////
  return $HB                                                   ;
}

public function addEnableEval()
{
  global $Translations                                                ;
  /////////////////////////////////////////////////////////////////////
  $HH  = new Parameters     (                                       ) ;
  $HL  = $HH -> ClassString ( $this -> Uuid                         ) ;
  /////////////////////////////////////////////////////////////////////
  $SCJ = "EnableEval('{$HL}',1) ;"                                    ;
  /////////////////////////////////////////////////////////////////////
  $HB   = new HtmlTag       (                                       ) ;
  $HB  -> setTag            ( "button"                              ) ;
  $HB  -> AddPair           ( "class"   , "ClassButton"             ) ;
  $HB  -> AddPair           ( "onclick" , $SCJ                      ) ;
  $HB  -> AddText           ( $Translations [ "Classes::OpenEval" ] ) ;
  /////////////////////////////////////////////////////////////////////
  unset                     ( $HH                                   ) ;
  /////////////////////////////////////////////////////////////////////
  $DIV  = new HtmlTag       (                                       ) ;
  $DIV -> setDiv            ( "" , "EnableEvaluation" , ""          ) ;
  $DIV -> AddTag            ( $HB                                   ) ;
  /////////////////////////////////////////////////////////////////////
  return $HB                                                          ;
}

public function addDisableEval()
{
  //////////////////////////////////////////////////////////////////////
  global $Translations                                                 ;
  //////////////////////////////////////////////////////////////////////
  $HH  = new Parameters     (                                        ) ;
  $HL  = $HH -> ClassString ( $this -> Uuid                          ) ;
  //////////////////////////////////////////////////////////////////////
  $SCJ = "EnableEval('{$HL}',0) ;"                                     ;
  //////////////////////////////////////////////////////////////////////
  $HB   = new HtmlTag       (                                        ) ;
  $HB  -> setTag            ( "button"                               ) ;
  $HB  -> AddPair           ( "class"   , "ClassButton"              ) ;
  $HB  -> AddPair           ( "onclick" , $SCJ                       ) ;
  $HB  -> AddText           ( $Translations [ "Classes::CloseEval" ] ) ;
  //////////////////////////////////////////////////////////////////////
  unset                     ( $HH                                    ) ;
  //////////////////////////////////////////////////////////////////////
  $DIV  = new HtmlTag       (                                        ) ;
  $DIV -> setDiv            ( "" , "EnableEvaluation" , ""           ) ;
  $DIV -> AddTag            ( $HB                                    ) ;
  //////////////////////////////////////////////////////////////////////
  return $HB                                                           ;
}

public function addCoursesRemove($CLASSID="SelectionButton")
{
  ///////////////////////////////////////////////////
  global $Translations                              ;
  ///////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::RemoveCourse" ] ;
  $JSC  = "RemoveClassCourse('{$this->Uuid}') ;"    ;
  $BTN  = new HtmlTag (                      )      ;
  $BTN -> setTag      ( "button"             )      ;
  $BTN -> SafePair    ( "class"   , $CLASSID )      ;
  $BTN -> SafePair    ( "onclick" , $JSC     )      ;
  $BTN -> AddText     ( $MSG                 )      ;
  ///////////////////////////////////////////////////
  return $BTN                                       ;
}

public function addLessonsButton($CLASSID="SelectionButton")
{
  ///////////////////////////////////////////////////
  global $Translations                              ;
  ///////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::AppendLesson" ] ;
  $JSC  = "AppendClassLesson('{$this->Uuid}') ;"    ;
  $BTN  = new HtmlTag (                      )      ;
  $BTN -> setTag      ( "button"             )      ;
  $BTN -> SafePair    ( "class"   , $CLASSID )      ;
  $BTN -> SafePair    ( "onclick" , $JSC     )      ;
  $BTN -> AddText     ( $MSG                 )      ;
  ///////////////////////////////////////////////////
  return $BTN                                       ;
}

public function addCoursesButton($CLASSID="SelectionButton")
{
  ////////////////////////////////////////////////
  global $Translations                           ;
  ////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::NewCourse" ] ;
  $JSC  = "AppendClassCourse('{$this->Uuid}') ;" ;
  $BTN  = new HtmlTag (                      )   ;
  $BTN -> setTag      ( "button"             )   ;
  $BTN -> SafePair    ( "class"   , $CLASSID )   ;
  $BTN -> SafePair    ( "onclick" , $JSC     )   ;
  $BTN -> AddText     ( $MSG                 )   ;
  ////////////////////////////////////////////////
  return $BTN                                    ;
}

public function addEnableSelectCourse($CLASSID="ClassButton")
{
  /////////////////////////////////////////////////
  global $Translations                            ;
  /////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::ShowCourse" ] ;
  $JSC  = "ShowCourses('{$this->Uuid}',1) ;"      ;
  $BTN  = new HtmlTag (                      )    ;
  $BTN -> setTag      ( "button"             )    ;
  $BTN -> SafePair    ( "class"   , $CLASSID )    ;
  $BTN -> SafePair    ( "onclick" , $JSC     )    ;
  $BTN -> AddText     ( $MSG                 )    ;
  /////////////////////////////////////////////////
  return $BTN                                     ;
}

public function addDisableSelectCourse($CLASSID="ClassButton")
{
  /////////////////////////////////////////////////
  global $Translations                            ;
  /////////////////////////////////////////////////
  $MSG  = $Translations [ "Classes::HideCourse" ] ;
  $JSC  = "ShowCourses('{$this->Uuid}',0) ;"      ;
  $BTN  = new HtmlTag (                      )    ;
  $BTN -> setTag      ( "button"             )    ;
  $BTN -> SafePair    ( "class"   , $CLASSID )    ;
  $BTN -> SafePair    ( "onclick" , $JSC     )    ;
  $BTN -> AddText     ( $MSG                 )    ;
  /////////////////////////////////////////////////
  return $BTN                                     ;
}

public function addCourseSelection($DIV,$COURSES,$BTNCLASS="SelectionButton",$CLASSID="")
{
  $BTN  = $this -> addCoursesRemove ( $BTNCLASS                      ) ;
  $DIV -> AddTag                    ( $BTN                           ) ;
  //////////////////////////////////////////////////////////////////////
  $CJS  = "ClassCourseChanged(this.value,'{$this->Uuid}') ;"           ;
  $HS   = $DIV  -> addSelection     ( $COURSES   , "" , $CLASSID     ) ;
  $HS  -> setSplitter               ( "\n"                           ) ;
  $HS  -> AddPair                   ( "id"       , "SelectedCourses" ) ;
  $HS  -> AddPair                   ( "onchange" , $CJS              ) ;
}

public function addAppendLesson($DIV,$LESSONS,$BTNCLASS="SelectionButton",$CLASSID="")
{
  $HS   = $DIV  -> addSelection     ( $LESSONS   , "" , $CLASSID ) ;
  $HS  -> setSplitter               ( "\n"                       ) ;
  $HS  -> AddPair                   ( "id" , "SelectedLessons"   ) ;
  //////////////////////////////////////////////////////////////////
  $BTN  = $this -> addLessonsButton ( $BTNCLASS                  ) ;
  $DIV -> AddTag                    ( $BTN                       ) ;
}

public function addAppendCourse($DIV,$ALL,$BTNCLASS="SelectionButton",$CLASSID="")
{
  $HS     = $DIV  -> addSelection     ( $ALL , "" , $CLASSID ) ;
  $HS    -> setSplitter               ( "\n"                 ) ;
  $HS    -> AddPair                   ( "id" , "AllCourses"  ) ;
  //////////////////////////////////////////////////////////////
  $BTN    = $this -> addCoursesButton ( $BTNCLASS            ) ;
  $DIV   -> AddTag                    ( $BTN                 ) ;
}

public function CoursesEditor($COURSES,$LESSONS,$ALL,$BTNCLASS="SelectionButton",$CLASSID="")
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
  $LLD   = $HLD   -> addDiv         ( "" , "LessonsSection" , "" ) ;
  $NLD   = $HND   -> addDiv         ( "" , "CoursesListing" , "" ) ;
  //////////////////////////////////////////////////////////////////
  $CLD  -> setSplitter              ( "\n"                       ) ;
  $LLD  -> setSplitter              ( "\n"                       ) ;
  $NLD  -> setSplitter              ( "\n"                       ) ;
  //////////////////////////////////////////////////////////////////
  $CLD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  $LLD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  $NLD  -> AddPair                  ( "nowrap" , "nowrap"        ) ;
  //////////////////////////////////////////////////////////////////
  if                                ( count ( $COURSES ) > 0     ) {
    $this -> addCourseSelection     ( $CLD                         ,
                                      $COURSES                     ,
                                      $BTNCLASS                    ,
                                      $CLASSID                   ) ;
  }                                                                ;
  //////////////////////////////////////////////////////////////////
  if                                ( count ( $LESSONS ) > 0     ) {
    $this -> addAppendLesson        ( $LLD                         ,
                                      $LESSONS                     ,
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

public function getCourseName          ( $DB , $LANG                       ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $RELATION   = $GLOBALS [ "TableMapping" ] [ "Relation" ]                   ;
  $NAMTAB     = $GLOBALS [ "TableMapping" ] [ "Names"    ]                   ;
  $LESTAB     = $GLOBALS [ "TableMapping" ] [ "Lessons"  ]                   ;
  ////////////////////////////////////////////////////////////////////////////
  $LNAME      = ""                                                           ;
  $CNAME      = ""                                                           ;
  $HNAME      = ""                                                           ;
  ////////////////////////////////////////////////////////////////////////////
  $LESSONS    = $this -> ObtainLessons ( $DB , $RELATION                   ) ;
  if                                   ( count ( $LESSONS ) > 0            ) {
    $LID      = $LESSONS [ 0 ]                                               ;
    $LNAME    = $DB -> Naming ( $NAMTAB , $LID , $LANG , "Default"         ) ;
    $PF       = 0                                                            ;
    $QQ       = "select `course`,`prefer` from {$LESTAB} where `uuid` = {$LID} ;" ;
    $qq       = $DB -> Query           ( $QQ                               ) ;
    if                                 ( $DB -> hasResult ( $qq )          ) {
      $rr     = $qq -> fetch_array     ( MYSQLI_BOTH                       ) ;
      $CID    = $rr [ 0 ]                                                    ;
      $PF     = $rr [ 1 ]                                                    ;
      $HNAME  = $Translations [ "Chapter::Number" ]                          ;
      $HNAME  = str_replace            ( "$(NUMBER)" , $PF , $HNAME        ) ;
      $CNAME  = $DB -> Naming ( $NAMTAB , $CID , $LANG , "Default"         ) ;
    }                                                                        ;
  } else                                                                     {
    $COURSES  = $this -> ObtainCourses ( $DB , $RELATION                   ) ;
    if                                 ( count ( $COURSES ) > 0            ) {
      $CID    = $COURSES [ 0 ]                                               ;
      $CNAME  = $DB -> Naming ( $NAMTAB , $CID , $LANG , "Default"         ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return "{$CNAME} {$HNAME} {$LNAME}"                                        ;
}

public function EditCourses($DB,$LANG)
{
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
  $LESSONS = $this -> ObtainLessons   ( $DB , "`erp`.`relations`"          ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                                  ( count ( $COURSES ) > 0             ) {
    $CX      -> Uuid = $COURSES [ 0 ]                                        ;
    $INCOURSE = $CX -> GetLessons     ( $DB , "`erp`.`lessons`"            ) ;
    $INCX     = $DB -> Exclude        ( $INCOURSE , $LESSONS               ) ;
    //////////////////////////////////////////////////////////////////////////
    $XNAMES  = array       (                                               ) ;
    foreach                ( $INCX as $cc                                  ) {
      $NN = $DB -> GetName ( "`erp`.`names`" , $cc , $LANG , "Default"     ) ;
      $PF = 0                                                                ;
      $QQ = "select `prefer` from `erp`.`lessons` where `uuid` = {$cc} ;"    ;
      $qq = $DB -> Query     ( $QQ                                         ) ;
      if ( $DB -> hasResult ( $qq ) )                                        {
        $rr = $qq -> fetch_array ( MYSQLI_BOTH )                             ;
        $PF = $rr [ 0 ]                                                      ;
      }                                                                      ;
      $NV             = $Translations [ "Chapter::Number" ]                  ;
      $NV             = str_replace ( "$(NUMBER)" , $PF , $NV )              ;
      $NN             = "{$NV} {$NN}"                                        ;
      $XNAMES [ $cc ] = $NN                                                  ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
  } else $XNAMES = array ( )                                                 ;
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
                                        $XNAMES                              ,
                                        $WNAMES                              ,
                                        "SelectionButton"                    ,
                                        "SelectCourse"                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $CET                                                                ;
}

public function LessonsTable($DB,$LANG,$showButton=true,$showURL=true,$showHref=true,$INPCLASS="DocumentInput")
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $DLB     = $Translations [ "Classes::DeleteLesson" ]                       ;
  ////////////////////////////////////////////////////////////////////////////
  $NI      = new NoteItem ( )                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $LESSONS = $this -> ObtainLessons ( $DB , "`erp`.`relations`" )            ;
  ////////////////////////////////////////////////////////////////////////////
  $LCMAPS  = array ( )                                                       ;
  $COURSES = array ( )                                                       ;
  $LNAMES  = array ( )                                                       ;
  $CNAMES  = array ( )                                                       ;
  $PFLIST  = array ( )                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  foreach ( $LESSONS as $lx )                                                {
    $QQ  = "select `course`,`prefer` from `erp`.`lessons` where `uuid` = {$lx} ;" ;
    $qq  = $DB -> Query ( $QQ )                                              ;
    if ( $DB -> hasResult ( $qq ) )                                          {
      $rr             = $qq -> fetch_array ( MYSQLI_BOTH )                   ;
      $CIDX           = $rr [ 0 ]                                            ;
      $PREFER         = $rr [ 1 ]                                            ;
      $LCMAPS [ $lx ] = $CIDX                                                ;
      $PFLIST [ $lx ] = $PREFER                                              ;
      if ( ! in_array ( $CIDX , $COURSES ) )                                 {
        array_push ( $COURSES , $CIDX )                                      ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $LESSONS ) > 0 )                                              {
    $LNAMES = $DB -> GetMapNames ( "`erp`.`names`" , $LESSONS , $LANG )      ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $COURSES ) > 0 )                                              {
    $CNAMES = $DB -> GetMapNames ( "`erp`.`names`" , $COURSES , $LANG )      ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $WIDTH = "40%"                                                             ;
  if ( $showURL ) $WIDTH = "20%"                                             ;
  $MHT   = new HtmlTag                   (                                 ) ;
  $THB   = $MHT -> ConfigureTable        ( 1 , 0 , 0                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                                ( $LESSONS as $lx )                 {
    //////////////////////////////////////////////////////////////////////////
    $HR         = $THB -> addTr          (                                 ) ;
    $HR        -> setSplitter            ( "\n"                            ) ;
    //////////////////////////////////////////////////////////////////////////
    $CIDX       = $LCMAPS [ $lx ]                                            ;
    if                                   ( $showButton                     ) {
      $LJS      = "RemoveClassLesson('{$lx}','{$this->Uuid}') ;"             ;
      $BTN      = new HtmlTag            (                                 ) ;
      $BTN     -> setTag                 ( "button"                        ) ;
      $BTN     -> AddPair                ( "class"   , "SelectionButton"   ) ;
      $BTN     -> AddPair                ( "onclick" , $LJS                ) ;
      $BTN     -> AddText                ( $DLB                            ) ;
      $this    -> addButton              ( $HR      , $BTN                 ) ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
    $UMSG       = $Translations [ "Classes::Unit" ]                          ;
    $HD         = $HR  -> addTd          ( $UMSG                            ) ;
    $HD        -> AddPair                ( "nowrap" , "nowrap"             ) ;
    $HD        -> AddPair                ( "valign" , "top"                ) ;
    $HD        -> AddPair                ( "width"  , "3%"                 ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD         = $HR  -> addTd          ( $CNAMES [ $CIDX ]               ) ;
    $HD        -> AddPair                ( "width"  , $WIDTH               ) ;
    $HD        -> AddPair                ( "valign" , "top"                ) ;
    //////////////////////////////////////////////////////////////////////////
//    $CMSG       = $Translations [ "Classes::Chapter" ]                       ;
    $CMSG       = $Translations [ "Chapter::Number" ]                        ;
    $CMSG       = str_replace ( "$(NUMBER)" , $PFLIST [ $lx ] , $CMSG )      ;
    $HD         = $HR  -> addTd          ( $CMSG                           ) ;
    $HD        -> AddPair                ( "nowrap" , "nowrap"             ) ;
    $HD        -> AddPair                ( "valign" , "top"                ) ;
    $HD        -> AddPair                ( "width"  , "3%"                 ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD         = $HR  -> addTd          ( $LNAMES [ $lx   ]               ) ;
    $HD        -> AddPair                ( "width"  , $WIDTH               ) ;
    $HD        -> AddPair                ( "valign" , "top"                ) ;
    //////////////////////////////////////////////////////////////////////////
    if                                   ( $showURL                        ) {
      $HD       = $HR  -> addTd          (                                 ) ;
      $HD      -> AddPair                ( "width"  , "50%"                ) ;
      ////////////////////////////////////////////////////////////////////////
      $NI      -> setOwner               ( $lx , "URL"                     ) ; // 取得基本章節教材網址
      $LURS     = $NI -> ObtainStrings   ( $DB , "`erp`.`notes`"           ) ;
      if                                 ( count ( $LURS ) > 0             ) {
        $HXT    = new HtmlTag            (                                 ) ;
        $HTB    = $HXT -> ConfigureTable ( 0 , 0 , 0                       ) ;
        $HD    -> AddTag                 ( $HXT                            ) ;
        foreach                          ( $LURS as $urx                   ) {
          $HXR  = $HTB -> addTr          (                                 ) ;
          $HXD  = $HXR -> addTd          (                                 ) ;
          $HIP  = new HtmlTag            (                                 ) ;
          $HIP -> setInput               (                                 ) ;
          $HIP -> AddPair                ( "type"    , "text"              ) ;
          $HIP -> AddPair                ( "class"   , $INPCLASS           ) ;
          $HIP -> AddPair                ( "value"   , $urx                ) ;
          $HXD -> AddTag                 ( $HIP                            ) ;
          if                             ( $showHref                       ) {
            $GMSG = $Translations [ "GotoURL" ]                              ;
            $GJS  = "window.open('{$urx}','_blank') ;"                       ;
            $HXD  = $HXR -> addTd        (                                 ) ;
            $HXD -> AddPair              ( "nowrap"  , "nowrap"            ) ;
            $HXD -> AddPair              ( "width"   , "3%"                ) ;
            $BTN  = $HXD -> addButton    ( $GMSG                           ) ;
            $BTN -> AddPair              ( "onclick" , $GJS                ) ;
            $BTN -> AddPair              ( "class"   , "SelectionButton"   ) ;
          }                                                                  ;
        }                                                                    ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $MHT                                                                ;
}

public function ClassTypeJS()
{
  return "ClassTypes(this.value,'{$this->Uuid}') ;" ;
}

public function addClassType($HR)
{
  global $Translations                                       ;
  global $ClassTypeIDs                                       ;
  ////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                                    ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap"                ) ;
  $HD -> AddPair      ( "width"  , "3%"                    ) ;
  $HD -> AddText      ( $Translations [ "Classes::State" ] ) ;
  ////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                                    ) ;
  $HD -> AddText      ( $ClassTypeIDs [ $this -> Type ]    ) ;
}

public function editClassType($HR)
{
  global $Translations                                               ;
  global $ClassTypeIDs                                               ;
  ////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd         (                                    ) ;
  $HD -> AddPair              ( "nowrap" , "nowrap"                ) ;
  $HD -> AddPair              ( "width"  , "3%"                    ) ;
  $HD -> AddText              ( $Translations [ "Classes::State" ] ) ;
  ////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd         (                                    ) ;
  $HS  = $HD -> addSelect     ( "ClassTypes"                       ) ;
  $HS -> setSplitter          ( "\n"                               ) ;
  ////////////////////////////////////////////////////////////////////
  $CTI = array_keys           ( $ClassTypeIDs                      ) ;
  foreach                     ( $CTI as $cti                       ) {
    $HO    = $HS -> addOption ( $ClassTypeIDs [ $cti ]             ) ;
    if                        ( $cti == $this -> Type              ) {
      $HO -> AddMember        ( "selected"                         ) ;
    }                                                                ;
    $HO   -> AddPair          ( "value" , $cti                     ) ;
  }                                                                  ;
  ////////////////////////////////////////////////////////////////////
  return $HS                                                         ;
}

public function getClassType($HR,$TYPE=0)
{
  switch ( $TYPE )                                {
    case 0: return $this -> addClassType  ( $HR ) ;
    case 1: return $this -> editClassType ( $HR ) ;
  }                                               ;
  return false                                    ;
}

public function CourseItemJS()
{
  return "ClassItem(this.value,'{$this->Uuid}') ;" ;
}

public function addCourse($HR,$LeftWidth="10%",$NameWidth="15%",$bgcolors="",$listing=false)
{
  ////////////////////////////////////////////////////////////////////////
  global $Translations                                                   ;
  global $CourseNames                                                    ;
  ////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd            ( $Translations [ "Classes::Course" ] ) ;
  $HD -> AddPair                 ( "width"      , $LeftWidth           ) ;
  $HD -> SafePair                ( "bgcolor"    , $bgcolors            ) ;
  ////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd            (                                     ) ;
  $HD -> AddPair                 ( "width"      , $NameWidth           ) ;
  $HD -> SafePair                ( "bgcolor"    , $bgcolors            ) ;
  if                             ( $listing                            ) {
    $JSC = $this -> CourseItemJS (                                     ) ;
    $HS  = $HD   -> addSelection ( $CourseNames , $this -> Item        ) ;
    $HS -> setSplitter           ( "\n"                                ) ;
    $HS -> AddPair               ( "onchange"   , $JSC                 ) ;
  } else                                                                 {
    $HD -> AddText               ( $CourseNames [ $this -> Item ]      ) ;
  }                                                                      ;
}

public function addStatus($HR,$LeftWidth="10%",$NameWidth="15%",$bgcolors="")
{
  ////////////////////////////////////////////////////////////
  global $Translations                                       ;
  global $ClassTypeIDs                                       ;
  ////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $Translations [ "Classes::State" ] ) ;
  $HD -> SafePair     ( "width"   , $LeftWidth             ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolors              ) ;
  ////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $ClassTypeIDs [ $this -> Type ]    ) ;
  $HD -> SafePair     ( "width"   , $NameWidth             ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolors              ) ;
}

public function addTutor($HR,$TUTOR,$LeftWidth="",$NameWidth="",$bgcolors="",$tutorId=0)
{
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  // 老師人名
  //////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd (                                    ) ;
  $HD   -> AddPair      ( "nowrap"  , "nowrap"               ) ;
  $HD   -> SafePair     ( "width"   , $LeftWidth             ) ;
  $HD   -> SafePair     ( "bgcolor" , $bgcolors              ) ;
  $HD   -> AddText      ( $Translations [ "Classes::Tutor" ] ) ;
  //////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd (                                    ) ;
  $HD   -> SafePair     ( "width"   , $NameWidth             ) ;
  $HD   -> SafePair     ( "bgcolor" , $bgcolors              ) ;
  $HD   -> AddText      ( $TUTOR                             ) ;
  //////////////////////////////////////////////////////////////
  if ( gmp_cmp ( $tutorId , "0" ) > 0 )                        {
    $HH  = new Parameters      (                             ) ;
    $SID = $HH -> PeopleString ( $tutorId                    ) ;
    $SJC = "TutorInfo('{$SID}') ;"                             ;
    $HD -> SafePair            ( "ondblclick" , $SJC         ) ;
    unset                      ( $HH                         ) ;
  }                                                            ;
}

// 學生人名
public function addStudent($HR,$STUDENT,$LeftWidth="",$NameWidth="",$bgcolors="",$trainee=0)
{
  global $Translations                                         ;
  //////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                                      ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"                 ) ;
  $HD -> SafePair     ( "width"   , $LeftWidth               ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolors                ) ;
  $HD -> AddText      ( $Translations [ "Classes::Student" ] ) ;
  //////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                                      ) ;
  $HD -> SafePair     ( "width"   , $NameWidth               ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolors                ) ;
  $HD -> AddText      ( $STUDENT                             ) ;
  //////////////////////////////////////////////////////////////
  if ( gmp_cmp ( $trainee , "0" ) > 0 )                        {
    $HH  = new Parameters      (                             ) ;
    $SID = $HH -> PeopleString ( $trainee                    ) ;
    $SJC = "StudentInfo('{$SID}') ;"                           ;
    $HD -> SafePair            ( "ondblclick" , $SJC         ) ;
    unset                      ( $HH                         ) ;
  }                                                            ;
}

public function addManager($HR,$MANAGER,$LeftWidth="",$NameWidth="",$bgcolors="",$managerId=0)
{
  global $Translations                                           ;
  ////////////////////////////////////////////////////////////////
  // 經理人名
  ////////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd (                                      ) ;
  $HD   -> AddPair      ( "nowrap"  , "nowrap"                 ) ;
  $HD   -> SafePair     ( "width"   , $LeftWidth               ) ;
  $HD   -> SafePair     ( "bgcolor" , $bgcolors                ) ;
  $HD   -> AddText      ( $Translations [ "Classes::Manager" ] ) ;
  ////////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd (                                      ) ;
  $HD   -> SafePair     ( "width"   , $NameWidth               ) ;
  $HD   -> SafePair     ( "bgcolor" , $bgcolors                ) ;
  $HD   -> AddText      ( $MANAGER                             ) ;
  ////////////////////////////////////////////////////////////////
  if ( gmp_cmp ( $managerId , "0" ) > 0 )                        {
    $HH  = new Parameters      (                               ) ;
    $SID = $HH -> PeopleString ( $managerId                    ) ;
    $SJC = "ManagerInfo('{$SID}') ;"                             ;
    $HD -> SafePair            ( "ondblclick" , $SJC           ) ;
    unset                      ( $HH                           ) ;
  }                                                              ;
}

public function addReceptionist($HR,$RECEPTIONIST,$LeftWidth="",$NameWidth="",$bgcolors="",$receptionistId=0)
{
  global $Translations                                                ;
  /////////////////////////////////////////////////////////////////////
  // 客戶服務人名
  /////////////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd (                                           ) ;
  $HD   -> AddPair      ( "nowrap"  , "nowrap"                      ) ;
  $HD   -> SafePair     ( "width"   , $LeftWidth                    ) ;
  $HD   -> SafePair     ( "bgcolor" , $bgcolors                     ) ;
  $HD   -> AddText      ( $Translations [ "Classes::Receptionist" ] ) ;
  /////////////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd (                                           ) ;
  $HD   -> SafePair     ( "width"   , $NameWidth                    ) ;
  $HD   -> SafePair     ( "bgcolor" , $bgcolors                     ) ;
  $HD   -> AddText      ( $RECEPTIONIST                             ) ;
  /////////////////////////////////////////////////////////////////////
  if ( gmp_cmp ( $receptionistId , "0" ) > 0 )                        {
    $HH  = new Parameters      (                                    ) ;
    $SID = $HH -> PeopleString ( $receptionistId                    ) ;
    $SJC = "ReceptionistInfo('{$SID}') ;"                             ;
    $HD -> SafePair            ( "ondblclick" , $SJC                ) ;
    unset                      ( $HH                                ) ;
  }                                                                   ;
}

public function addAge($HR,$AGE,$WIDTH="")
{
  /////////////////////////////////////////////////////
  // 學生年齡
  /////////////////////////////////////////////////////
  global $Translations                                ;
  if ( strlen ( $AGE ) <= 0 ) return false            ;
  /////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                             ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap"         ) ;
  $HD -> SafePair     ( "width"  , $WIDTH           ) ;
  $HD -> AddText      ( $Translations [ "AgeName" ] ) ;
  /////////////////////////////////////////////////////
  $HD  = $HR -> addTd (                             ) ;
  $HD -> AddText      ( $AGE                        ) ;
  /////////////////////////////////////////////////////
  return true                                         ;
}

public function addPrev($PREVID,$CLASSID="ClassButton")
{
  global $Translations                                              ;
  ///////////////////////////////////////////////////////////////////
  $HH  = new Parameters       (                                   ) ;
  $HL  = $HH -> ClassString   ( $this -> Uuid                     ) ;
  $HC  = $HH -> ClassString   ( $PREVID                           ) ;
  $HX  = $HH -> LectureString ( $this -> Lecture                  ) ;
  ///////////////////////////////////////////////////////////////////
  $SCJ = "PrevClass('{$HL}','{$HX}','{$HC}') ;"                     ;
  ///////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag          (                                   ) ;
  $HB -> setTag               ( "button"                          ) ;
  $HB -> AddPair              ( "class"   , $CLASSID              ) ;
  $HB -> AddPair              ( "onclick" , $SCJ                  ) ;
  $HB -> AddText              ( $Translations [ "Classes::Prev" ] ) ;
  ///////////////////////////////////////////////////////////////////
  unset                       ( $HH                               ) ;
  ///////////////////////////////////////////////////////////////////
  return $HB                                                        ;
}

public function addNext($NEXTID,$CLASSID="ClassButton")
{
  global $Translations                                              ;
  ///////////////////////////////////////////////////////////////////
  $HH  = new Parameters       (                                   ) ;
  $HL  = $HH -> ClassString   ( $this -> Uuid                     ) ;
  $HC  = $HH -> ClassString   ( $NEXTID                           ) ;
  $HX  = $HH -> LectureString ( $this -> Lecture                  ) ;
  ///////////////////////////////////////////////////////////////////
  $SCJ = "NextClass('{$HL}','{$HX}','{$HC}') ;"                     ;
  ///////////////////////////////////////////////////////////////////
  $HB  = new HtmlTag          (                                   ) ;
  $HB -> setTag               ( "button"                          ) ;
  $HB -> AddPair              ( "class"   , $CLASSID              ) ;
  $HB -> AddPair              ( "onclick" , $SCJ                  ) ;
  $HB -> AddText              ( $Translations [ "Classes::Next" ] ) ;
  ///////////////////////////////////////////////////////////////////
  unset                       ( $HH                               ) ;
  ///////////////////////////////////////////////////////////////////
  return $HB                                                        ;
}

public function addEval($HR,$NAMEID,$ID,$CLASSID="Rater")
{
  ////////////////////////////////////////////////////
  global $Translations                               ;
  ////////////////////////////////////////////////////
  $HD  = $HR -> addTd  ( $Translations [ $NAMEID ] ) ;
  $HD  = $HR -> addTd  (                           ) ;
  $HD -> setSplitter   ( "\n"                      ) ;
  ////////////////////////////////////////////////////
  $RA  = $HD -> addDiv (                           ) ;
  $RA -> SafePair      ( "id"    , $ID             ) ;
  $RA -> SafePair      ( "class" , $CLASSID        ) ;
  ////////////////////////////////////////////////////
  return $RA                                         ;
}

public function addComment($HR,$COMMENT,$COLS)
{
  ////////////////////////////////////////////////////////////////
  global $Translations                                           ;
  ////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd   ( $Translations [ "Classes::Comment" ] ) ;
  $HD  = $HR -> addTd   (                                      ) ;
  $HD -> AddPair        ( "colspan" , $COLS - 1                ) ;
  ////////////////////////////////////////////////////////////////
  $TJ  = "EvaluationChanged('{$this->Uuid}',this.value) ;"       ;
  $TA  = new HtmlTag    (                                      ) ;
  $TA -> setTag         ( "textarea"                           ) ;
  $TA -> AddPair        ( "class"    , "EvalClass"             ) ;
  $TA -> AddPair        ( "cols"     , "120"                   ) ;
  $TA -> AddPair        ( "rows"     , "3"                     ) ;
  $TA -> AddPair        ( "onchange" , $TJ                     ) ;
  $TA -> AddText        ( $COMMENT                             ) ;
  ////////////////////////////////////////////////////////////////
  $HD -> AddTag         ( $TA                                  ) ;
}

public function StudentEvaluation($COMMENT)
{
  $HT    = new HtmlTag           (                                ) ;
  $HB    = $HT -> ConfigureTable ( 1 , 0 , 0                      ) ;
  $HR    = $HB -> addTr          (                                ) ;
  $this -> addEval ( $HR , "Classes::Teaching"    , "Teaching"    ) ;
  $this -> addEval ( $HR , "Classes::Quality"     , "Connection"  ) ;
  $this -> addEval ( $HR , "Classes::Environment" , "Environment" ) ;
  $HR    = $HB -> addTr          (                                ) ;
  $this -> addComment            ( $HR , $COMMENT , 6             ) ;
  return $HT                                                        ;
}

// 打開文件
public function addOpenDocument($PREFER,$BTNID="",$BTNCLASS="")
{
  ////////////////////////////////////////////////////
  global $Translations                               ;
  ////////////////////////////////////////////////////
  $ODJ  = "documentURL({$PREFER},'{$this->Uuid}') ;" ;
  $TXT  = $Translations [ "Classes::OpenURL" ]       ;
  ////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                       )      ;
  $BTN -> setTag      ( "button"              )      ;
  $BTN -> SafePair    ( "id"      , $BTNID    )      ;
  $BTN -> SafePair    ( "class"   , $BTNCLASS )      ;
  $BTN -> AddPair     ( "onclick" , $ODJ      )      ;
  $BTN -> AddText     ( $TXT                  )      ;
  ////////////////////////////////////////////////////
  return $BTN                                        ;
}

// 打開文件在Frame裡面
public function addOpenFrame($PREFER,$BTNID="",$BTNCLASS="")
{
  ////////////////////////////////////////////////////////
  global $Translations                                   ;
  ////////////////////////////////////////////////////////
  $ODJ  = "documentFrame({$PREFER},'{$this->Uuid}',1) ;" ;
  $TXT  = $Translations [ "Classes::OpenFrame" ]         ;
  ////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                       )          ;
  $BTN -> setTag      ( "button"              )          ;
  $BTN -> SafePair    ( "id"      , $BTNID    )          ;
  $BTN -> SafePair    ( "class"   , $BTNCLASS )          ;
  $BTN -> AddPair     ( "onclick" , $ODJ      )          ;
  $BTN -> AddText     ( $TXT                  )          ;
  ////////////////////////////////////////////////////////
  return $BTN                                            ;
}

// 關閉Frame裡面的文件
public function addCloseFrame($PREFER,$BTNID="",$BTNCLASS="")
{
  ////////////////////////////////////////////////////////
  global $Translations                                   ;
  ////////////////////////////////////////////////////////
  $ODJ  = "documentFrame({$PREFER},'{$this->Uuid}',0) ;" ;
  $TXT  = $Translations [ "Classes::CloseFrame" ]        ;
  ////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                       )          ;
  $BTN -> setTag      ( "button"              )          ;
  $BTN -> SafePair    ( "id"      , $BTNID    )          ;
  $BTN -> SafePair    ( "class"   , $BTNCLASS )          ;
  $BTN -> AddPair     ( "onclick" , $ODJ      )          ;
  $BTN -> AddText     ( $TXT                  )          ;
  ////////////////////////////////////////////////////////
  return $BTN                                            ;
}

// 教材輸入欄
// Replace : ListDocuments
public function documentInput($PREFER=-1,$TEXT="",$PREFIX="ClassDocument",$INPUTCLASS="DocumentInput")
{
  global $Translations                                               ;
  ////////////////////////////////////////////////////////////////////
  $IDX  = ""                                                         ;
  if ( $PREFER < 0 ) $IDX = "{$PREFIX}-X"                            ;
                else $IDX = "{$PREFIX}-{$PREFER}"                    ;
  ////////////////////////////////////////////////////////////////////
  $OCF  = "documentsChanged(this.value,{$PREFER},'{$this->Uuid}') ;" ;
  ////////////////////////////////////////////////////////////////////
  $HZX  = new HtmlTag (                             )                ;
  $HZX -> setInput    (                             )                ;
  $HZX -> AddPair     ( "size"        , "120"       )                ;
  $HZX -> AddPair     ( "id"          , $IDX        )                ;
  $HZX -> AddPair     ( "class"       , $INPUTCLASS )                ;
  ////////////////////////////////////////////////////////////////////
  $HZX -> AddPair     ( "onchange"    , $OCF        )                ;
  ////////////////////////////////////////////////////////////////////
  if                  ( $PREFER >= 0                )                {
    $HZX -> AddPair   ( "value" , $TEXT             )                ;
  } else                                                             {
    $PHT  = $Translations [ "DocumentDetails" ]                      ;
    $HZX -> AddPair   ( "placeholder" , $PHT        )                ;
  }                                                                  ;
  return $HZX                                                        ;
}

// 教材區塊
public function DocumentsBlock                      (
                  $MAPs                             ,
                  $PREFIX       = "ClassDocument"   ,
                  $FRAMEID      = "DocumentFrame"   ,
                  $INPUTCLASS   = "DocumentInput"   ,
                  $BTNCLASS     = "SelectionButton" ,
                  $editable     = true              ,
                  $newline      = true              ,
                  $openDocument = true              ,
                  $openFrame    = true              ,
                  $closeFrame   = false             )
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $LINES  = 0                                                                ;
  $COLS   = 1                                                                ;
  $BORDER = 0                                                                ;
  if (   $openFrame    ) $closeFrame = false                                 ;
  if ( ! $editable     ) $BORDER     =         1                             ;
  if (   $openDocument ) $COLS       = $COLS + 1                             ;
  if (   $openFrame    ) $COLS       = $COLS + 1                             ;
  if (   $closeFrame   ) $COLS       = $COLS + 1                             ;
  ////////////////////////////////////////////////////////////////////////////
  // 編輯表格
  ////////////////////////////////////////////////////////////////////////////
  $TABLE  = new HtmlTag              (         )                             ;
  $TBODY  = $TABLE -> ConfigureTable ( $BORDER )                             ;
  $TBODY -> setSplitter              ( "\n"    )                             ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $MAPs ) > 0 )                                                 {
    $PREFERs = array_keys ( $MAPs )                                          ;
    foreach ( $PREFERs as $id )                                              {
      ////////////////////////////////////////////////////////////////////////
      $MSG   = $MAPs [ $id ]                                                 ;
      $LINES = $LINES + 1                                                    ;
      ////////////////////////////////////////////////////////////////////////
      $HR    = $TBODY -> addTr           (                                 ) ;
      $HR   -> setSplitter               ( "\n"                            ) ;
      ////////////////////////////////////////////////////////////////////////
      // 新增編輯欄
      ////////////////////////////////////////////////////////////////////////
      $HD    = $HR   -> addTd            (                                 ) ;
      $INPS  = $this -> documentInput    ( $id , $MSG                      ) ;
      $HD   -> AddTag                    ( $INPS                           ) ;
      if ( $editable )                                                       {
        $INPS -> AddPair                 ( "type"   , "text"               ) ;
      } else                                                                 {
        $INPS -> AddPair                 ( "type"   , "hidden"             ) ;
        $HAC  = new HtmlTag              (                                 ) ;
        $HAC -> setTag                   ( "a"                             ) ;
        $HAC -> AddPair                  ( "href"   , $MSG                 ) ;
        $HAC -> AddPair                  ( "target" , "_blank"             ) ;
        $HAC -> AddText                  (            $MSG                 ) ;
        $HD  -> AddTag                   ( $HAC                            ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      // 新增按鈕：打開教材
      ////////////////////////////////////////////////////////////////////////
      if ( $openDocument )                                                   {
        //////////////////////////////////////////////////////////////////////
        $HD   = $HR   -> addTd           (                                 ) ;
        $HD  -> AddPair                  ( "nowrap" , "nowrap"             ) ;
        $HD  -> AddPair                  ( "width"  , "3%"                 ) ;
        //////////////////////////////////////////////////////////////////////
        $ODB  = $this -> addOpenDocument ( $id , "" , $BTNCLASS            ) ;
        $HD  -> AddTag                   ( $ODB                            ) ;
        //////////////////////////////////////////////////////////////////////
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      // 新增按鈕：嵌入教材
      ////////////////////////////////////////////////////////////////////////
      if ( $openFrame )                                                      {
        //////////////////////////////////////////////////////////////////////
        $HD   = $HR    -> addTd          (                                 ) ;
        $HD  -> AddPair                  ( "nowrap" , "nowrap"             ) ;
        $HD  -> AddPair                  ( "width"  , "3%"                 ) ;
        //////////////////////////////////////////////////////////////////////
        $FID  = "{$FRAMEID}-{$id}"                                           ;
        $DIV  = $HD -> addDiv            ( "" , $FID                       ) ;
        //////////////////////////////////////////////////////////////////////
        $OFB  = $this -> addOpenFrame    ( $id , "" , $BTNCLASS            ) ;
        $DIV -> AddTag                   ( $OFB                            ) ;
        //////////////////////////////////////////////////////////////////////
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      // 新增按鈕：關閉教材
      ////////////////////////////////////////////////////////////////////////
      if ( $closeFrame )                                                     {
        //////////////////////////////////////////////////////////////////////
        $HD   = $HR    -> addTd          (                                 ) ;
        $HD  -> AddPair                  ( "nowrap" , "nowrap"             ) ;
        $HD  -> AddPair                  ( "width"  , "3%"                 ) ;
        //////////////////////////////////////////////////////////////////////
        $FID  = "{$FRAMEID}-{$id}"                                           ;
        $DIV  = $HD -> addDiv            ( "" , $FID                       ) ;
        //////////////////////////////////////////////////////////////////////
        $OFB  = $this -> addCloseFrame   ( $id , "" , $BTNCLASS            ) ;
        $DIV -> AddTag                   ( $OFB                            ) ;
        //////////////////////////////////////////////////////////////////////
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    }                                                                        ;
    unset ( $PREFERs )                                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增編輯欄
  ////////////////////////////////////////////////////////////////////////////
  if ( $newline )                                                            {
    //////////////////////////////////////////////////////////////////////////
    $HR = $TBODY -> addTr            (                                     ) ;
    $HD = $HR    -> addTd            (                                     ) ;
    if ( $COLS > 1 ) $HD -> AddPair  ( "colspan" , $COLS                   ) ;
    //////////////////////////////////////////////////////////////////////////
    if ( $editable  )                                                        {
      $INPS = $this -> documentInput ( -1 , "" , $PREFIX , $INPUTCLASS     ) ;
      $HD  -> AddTag                 ( $INPS                               ) ;
    } else                                                                   {
      if ( $LINES <= 0 )                                                     {
        $NDS  = $Translations [ "Classes::NoDocument" ]                      ;
        $HD  -> AddText              ( $NDS                                ) ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $TABLE                                                              ;
}

// 教材區塊
public function LoadDocumentsBlock                  (
                  $DB                               ,
                  $NOTETABLE                        ,
                  $PREFIX       = "ClassDocument"   ,
                  $FRAMEID      = "DocumentFrame"   ,
                  $INPUTCLASS   = "DocumentInput"   ,
                  $BTNCLASS     = "SelectionButton" ,
                  $editable     = true              ,
                  $newline      = true              ,
                  $openDocument = true              ,
                  $openFrame    = true              ,
                  $closeFrame   = false             )
{
  $NI   = new NoteItem        (                            ) ;
  $NI  -> setOwner            ( $this -> Uuid , "Document" ) ;
  $CIDs = $NI   -> ObtainMaps ( $DB           , $NOTETABLE ) ;
  $DBT  = $this -> DocumentsBlock                            (
                                $CIDs                        ,
                                $PREFIX                      ,
                                $FRAMEID                     ,
                                $INPUTCLASS                  ,
                                $BTNCLASS                    ,
                                $editable                    ,
                                $newline                     ,
                                $openDocument                ,
                                $openFrame                   ,
                                $closeFrame                ) ;
  unset                       ( $NI                        ) ;
  return $DBT                                                ;
}

public function DocumentFrameBlock($MAPs,$PREFIX="MaterialFrame",$EMBED=false)
{
  $HF     = new HtmlTag           (                    ) ;
  ////////////////////////////////////////////////////////
  $TBODY  = $HF -> ConfigureTable ( 0 , 0 , 0          ) ;
  $TBODY -> setSplitter           ( "\n"               ) ;
  ////////////////////////////////////////////////////////
  if ( count ( $MAPs ) > 0 )                             {
    $PREFERs = array_keys ( $MAPs )                      ;
    foreach ( $PREFERs as $id )                          {
      $IDN = "{$PREFIX}-{$id}"                           ;
      $HR  = $TBODY -> addTr      (                    ) ;
      $HR -> setSplitter          ( "\n"               ) ;
      $HD  = $HR    -> addTd      (                    ) ;
      $HD -> setSplitter          ( "\n"               ) ;
      $DIV = $HD    -> addDiv     ( "" , $IDN , ""     ) ;
      if ( $EMBED )                                      {
        $URL  = $MAPs [ $id ]                            ;
        $XFU  = $this -> FrameURL ( $id , $URL         ) ;
        $DIV -> AddTag            ( $XFU               ) ;
        $DIV -> AddPair           ( "width"  , "100%"  ) ;
        $DIV -> AddPair           ( "height" , "100vh" ) ;
      }                                                  ;
    }                                                    ;
  }                                                      ;
  ////////////////////////////////////////////////////////
  return $HF                                             ;
}

public function FrameURL($ID,$URL)
{
  //////////////////////////////////////////////////
  $FID   = "DocumentFrameId-{$ID}"                 ;
  //////////////////////////////////////////////////
  $HFRM  = new HtmlTag (                         ) ;
  //////////////////////////////////////////////////
  $HFRM -> setTag      ( "iframe"                ) ;
  $HFRM -> AddPair     ( "id"          , $FID    ) ;
  $HFRM -> AddPair     ( "width"       , "100%"  ) ;
  $HFRM -> AddPair     ( "height"      , "100%"  ) ;
  $HFRM -> AddPair     ( "frameborder" , "0"     ) ;
  $HFRM -> AddPair     ( "src"         , $URL    ) ;
  //////////////////////////////////////////////////
  return $HFRM                                     ;
}

public function FrameJS($CIDs)
{
  $HS      = new HtmlTag (          )               ;
  $HS     -> setTag      ( "script" )               ;
  $HS     -> setSplitter ( "\n"     )               ;
  ///////////////////////////////////////////////////
  $PREFERs = array_keys ( $CIDs )                   ;
  foreach ( $PREFERs as $id )                       {
    $DFI   = "DocFrameId-{$id}"                     ;
    $JCS   = "$('#{$DFI}').css('height','100vh') ;" ;
    $HS   -> AddText ( $JCS )                       ;
  }                                                 ;
  ///////////////////////////////////////////////////
  return $HS                                        ;
}

// 在另外一個視窗打開影片
public function addOpenVideo($PREFER,$BTNID="",$BTNCLASS="")
{
  /////////////////////////////////////////////////
  global $Translations                            ;
  /////////////////////////////////////////////////
  $ODJ  = "videoURL({$PREFER},'{$this->Uuid}') ;" ;
  $TXT  = $Translations [ "Classes::VideoURL" ]   ;
  /////////////////////////////////////////////////
  $BTN  = new HtmlTag (                       )   ;
  $BTN -> setTag      ( "button"              )   ;
  $BTN -> SafePair    ( "id"      , $BTNID    )   ;
  $BTN -> SafePair    ( "class"   , $BTNCLASS )   ;
  $BTN -> AddPair     ( "onclick" , $ODJ      )   ;
  $BTN -> AddText     ( $TXT                  )   ;
  /////////////////////////////////////////////////
  return $BTN                                     ;
}

// 打開文件在Frame裡面
public function addVideoFrame($PREFER,$BTNID="",$BTNCLASS="")
{
  /////////////////////////////////////////////////////
  global $Translations                                ;
  /////////////////////////////////////////////////////
  $ODJ  = "videoFrame({$PREFER},'{$this->Uuid}',1) ;" ;
  $TXT  = $Translations [ "Classes::OpenVideo" ]      ;
  /////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                       )       ;
  $BTN -> setTag      ( "button"              )       ;
  $BTN -> SafePair    ( "id"      , $BTNID    )       ;
  $BTN -> SafePair    ( "class"   , $BTNCLASS )       ;
  $BTN -> AddPair     ( "onclick" , $ODJ      )       ;
  $BTN -> AddText     ( $TXT                  )       ;
  /////////////////////////////////////////////////////
  return $BTN                                         ;
}

// 關閉Frame裡面的文件
public function addCloseVideo($PREFER,$BTNID="",$BTNCLASS="")
{
  /////////////////////////////////////////////////////
  global $Translations                                ;
  /////////////////////////////////////////////////////
  $ODJ  = "videoFrame({$PREFER},'{$this->Uuid}',0) ;" ;
  $TXT  = $Translations [ "Classes::CloseVideo" ]     ;
  /////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                       )       ;
  $BTN -> setTag      ( "button"              )       ;
  $BTN -> SafePair    ( "id"      , $BTNID    )       ;
  $BTN -> SafePair    ( "class"   , $BTNCLASS )       ;
  $BTN -> AddPair     ( "onclick" , $ODJ      )       ;
  $BTN -> AddText     ( $TXT                  )       ;
  /////////////////////////////////////////////////////
  return $BTN                                         ;
}

// 影片輸入欄
// Replace : ListFilms
public function filmInput($PREFER=-1,$TEXT="",$PREFIX="ClassFilm",$INPUTCLASS="FilmInput")
{
  global $Translations                                           ;
  ////////////////////////////////////////////////////////////////
  $IDX  = ""                                                     ;
  if ( $PREFER < 0 ) $IDX = "{$PREFIX}-X"                        ;
                else $IDX = "{$PREFIX}-{$PREFER}"                ;
  ////////////////////////////////////////////////////////////////
  $OCF  = "filmsChanged(this.value,{$PREFER},'{$this->Uuid}') ;" ;
  ////////////////////////////////////////////////////////////////
  $HZX  = new HtmlTag (                             )            ;
  $HZX -> setInput    (                             )            ;
  $HZX -> AddPair     ( "size"        , "120"       )            ;
  $HZX -> AddPair     ( "id"          , $IDX        )            ;
  $HZX -> AddPair     ( "class"       , $INPUTCLASS )            ;
  ////////////////////////////////////////////////////////////////
  $HZX -> AddPair     ( "onchange"    , $OCF        )            ;
  ////////////////////////////////////////////////////////////////
  if                  ( $PREFER >= 0                )            {
    $HZX -> AddPair   ( "value" , $TEXT             )            ;
  } else                                                         {
    $PHT  = $Translations [ "FilmDetails" ]                      ;
    $HZX -> AddPair   ( "placeholder" , $PHT        )            ;
  }                                                              ;
  return $HZX                                                    ;
}

// 影片輸入區塊
public function FilmsBlock                        (
                  $MAPs                           ,
                  $PREFIX     = "ClassFilm"       ,
                  $FRAMEID    = "FilmFrame"       ,
                  $INPUTCLASS = "FilmInput"       ,
                  $BTNCLASS   = "SelectionButton" ,
                  $editable   = true              ,
                  $newline    = true              ,
                  $openFilm   = true              ,
                  $openFrame  = true              ,
                  $closeFrame = false             )
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $LINES  = 0                                                                ;
  $COLS   = 1                                                                ;
  $BORDER = 0                                                                ;
  if (   $openFrame  ) $closeFrame = false                                   ;
  if ( ! $editable   ) $BORDER     =         1                               ;
  if (   $openFilm   ) $COLS       = $COLS + 1                               ;
  if (   $openFrame  ) $COLS       = $COLS + 1                               ;
  if (   $closeFrame ) $COLS       = $COLS + 1                               ;
  ////////////////////////////////////////////////////////////////////////////
  // 編輯表格
  ////////////////////////////////////////////////////////////////////////////
  $TABLE  = new HtmlTag              (         )                             ;
  $TBODY  = $TABLE -> ConfigureTable ( $BORDER )                             ;
  $TBODY -> setSplitter              ( "\n"    )                             ;
  ////////////////////////////////////////////////////////////////////////////
  if ( count ( $MAPs ) > 0 )                                                 {
    $PREFERs = array_keys ( $MAPs )                                          ;
    foreach ( $PREFERs as $id )                                              {
      ////////////////////////////////////////////////////////////////////////
      $MSG   = $MAPs [ $id ]                                                 ;
      $LINES = $LINES + 1                                                    ;
      ////////////////////////////////////////////////////////////////////////
      $HR    = $TBODY -> addTr           (                                 ) ;
      $HR   -> setSplitter               ( "\n"                            ) ;
      ////////////////////////////////////////////////////////////////////////
      // 新增編輯欄
      ////////////////////////////////////////////////////////////////////////
      $HD    = $HR   -> addTd            (                                 ) ;
      $INPS  = $this -> filmInput        ( $id , $MSG                      ) ;
      $HD   -> AddTag                    ( $INPS                           ) ;
      if ( $editable )                                                       {
        $INPS -> AddPair                 ( "type"   , "text"               ) ;
      } else                                                                 {
        $INPS -> AddPair                 ( "type"   , "hidden"             ) ;
        $HAC  = new HtmlTag              (                                 ) ;
        $HAC -> setTag                   ( "a"                             ) ;
        $HAC -> AddPair                  ( "href"   , $MSG                 ) ;
        $HAC -> AddPair                  ( "target" , "_blank"             ) ;
        $HAC -> AddText                  (            $MSG                 ) ;
        $HD  -> AddTag                   ( $HAC                            ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      // 新增按鈕：打開影片
      ////////////////////////////////////////////////////////////////////////
      if ( $openFilm )                                                       {
        //////////////////////////////////////////////////////////////////////
        $HD   = $HR   -> addTd           (                                 ) ;
        $HD  -> AddPair                  ( "nowrap" , "nowrap"             ) ;
        $HD  -> AddPair                  ( "width"  , "3%"                 ) ;
        //////////////////////////////////////////////////////////////////////
        $ODB  = $this -> addOpenVideo    ( $id , "" , $BTNCLASS            ) ;
        $HD  -> AddTag                   ( $ODB                            ) ;
        //////////////////////////////////////////////////////////////////////
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      // 新增按鈕：嵌入影片
      ////////////////////////////////////////////////////////////////////////
      if ( $openFrame )                                                      {
        //////////////////////////////////////////////////////////////////////
        $HD   = $HR    -> addTd          (                                 ) ;
        $HD  -> AddPair                  ( "nowrap" , "nowrap"             ) ;
        $HD  -> AddPair                  ( "width"  , "3%"                 ) ;
        //////////////////////////////////////////////////////////////////////
        $FID  = "{$FRAMEID}-{$id}"                                           ;
        $DIV  = $HD -> addDiv            ( "" , $FID                       ) ;
        //////////////////////////////////////////////////////////////////////
        $OFB  = $this -> addVideoFrame   ( $id , "" , $BTNCLASS            ) ;
        $DIV -> AddTag                   ( $OFB                            ) ;
        //////////////////////////////////////////////////////////////////////
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      // 新增按鈕：關閉影片
      ////////////////////////////////////////////////////////////////////////
      if ( $closeFrame )                                                     {
        //////////////////////////////////////////////////////////////////////
        $HD   = $HR    -> addTd          (                                 ) ;
        $HD  -> AddPair                  ( "nowrap" , "nowrap"             ) ;
        $HD  -> AddPair                  ( "width"  , "3%"                 ) ;
        //////////////////////////////////////////////////////////////////////
        $FID  = "{$FRAMEID}-{$id}"                                           ;
        $DIV  = $HD -> addDiv            ( "" , $FID                       ) ;
        //////////////////////////////////////////////////////////////////////
        $OFB  = $this -> addCloseVideo   ( $id , "" , $BTNCLASS            ) ;
        $DIV -> AddTag                   ( $OFB                            ) ;
        //////////////////////////////////////////////////////////////////////
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    }                                                                        ;
    unset ( $PREFERs )                                                       ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增編輯欄
  ////////////////////////////////////////////////////////////////////////////
  if ( $newline )                                                            {
    //////////////////////////////////////////////////////////////////////////
    $HR = $TBODY -> addTr            (                                     ) ;
    $HD = $HR    -> addTd            (                                     ) ;
    if ( $COLS > 1 ) $HD -> AddPair  ( "colspan" , $COLS                   ) ;
    //////////////////////////////////////////////////////////////////////////
    if ( $editable  )                                                        {
      $INPS = $this -> filmInput     ( -1 , "" , $PREFIX , $INPUTCLASS     ) ;
      $HD  -> AddTag                 ( $INPS                               ) ;
    } else                                                                   {
      if ( $LINES <= 0 )                                                     {
        $NDS  = $Translations [ "Classes::NoVideo" ]                         ;
        $HD  -> AddText              ( $NDS                                ) ;
      }                                                                      ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $TABLE                                                              ;
}

public function FilmFrameBlock($MAPs,$PREFIX="FilmFrame",$EMBED=false)
{
  $HF     = new HtmlTag           (                    ) ;
  ////////////////////////////////////////////////////////
  $TBODY  = $HF -> ConfigureTable ( 0 , 0 , 0          ) ;
  $TBODY -> setSplitter           ( "\n"               ) ;
  ////////////////////////////////////////////////////////
  if ( count ( $MAPs ) > 0 )                             {
    $PREFERs = array_keys ( $MAPs )                      ;
    foreach ( $PREFERs as $id )                          {
      $IDN = "{$PREFIX}-{$id}"                           ;
      $HR  = $TBODY -> addTr      (                    ) ;
      $HR -> setSplitter          ( "\n"               ) ;
      $HD  = $HR    -> addTd      (                    ) ;
      $HD -> setSplitter          ( "\n"               ) ;
      $DIV = $HD    -> addDiv     ( "" , $IDN , ""     ) ;
      if ( $EMBED )                                      {
        $URL  = $MAPs [ $id ]                            ;
        $XFU  = $this -> FilmURL  ( $id , $URL         ) ;
        $DIV -> AddTag            ( $XFU               ) ;
        $DIV -> AddPair           ( "width"  , "100%"  ) ;
        $DIV -> AddPair           ( "height" , "100vh" ) ;
      }                                                  ;
    }                                                    ;
  }                                                      ;
  ////////////////////////////////////////////////////////
  return $HF                                             ;
}

public function RawFilm($URL,$WIDTH="100%",$HEIGHT="100vh")
{
  /////////////////////////////////////////////////////////
  $PRID    = "https://www.youtube.com/watch?v="           ;
  $YOUTUBE = strpos ( $URL , $PRID )                      ;
  /////////////////////////////////////////////////////////
  $HFRM  = new HtmlTag (                                ) ;
  if                   ( $YOUTUBE !== false             ) {
    ///////////////////////////////////////////////////////
    $YID   = (string) str_replace ( $PRID , "" , $URL )   ;
    $IPAT  = "https://www.youtube.com/embed/{$YID}"       ;
    $ALLW  = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" ;
    ///////////////////////////////////////////////////////
    $HFRM -> setTag    ( "iframe"                       ) ;
    $HFRM -> AddPair   ( "class"       , "VideoContent" ) ;
    $HFRM -> AddPair   ( "width"       , $WIDTH         ) ;
    $HFRM -> AddPair   ( "height"      , $HEIGHT        ) ;
    $HFRM -> AddPair   ( "frameborder" , "0"            ) ;
    $HFRM -> AddPair   ( "src"         , $IPAT          ) ;
    $HFRM -> AddPair   ( "allow"       , $ALLW          ) ;
    $HFRM -> AddMember ( "allowfullscreen"              ) ;
    ///////////////////////////////////////////////////////
  } else                                                  {
    $HFRM -> setDiv    (                                ) ;
  }                                                       ;
  /////////////////////////////////////////////////////////
  return $HFRM                                            ;
}

public function FilmURL($ID,$URL,$WIDTH="100%",$HEIGHT="100vh")
{
  ///////////////////////////////////////////////////////
  $VID   = "VidFrameId-{$ID}"                           ;
  ///////////////////////////////////////////////////////
  $HFRM  = $this -> RawFilm ( $URL , $WIDTH , $HEIGHT ) ;
  $HFRM -> AddPair          ( "id" , $VID             ) ;
  ///////////////////////////////////////////////////////
  return $HFRM                                          ;
}

public function FilmJS($CIDs)
{
  $HS      = new HtmlTag (          )               ;
  $HS     -> setTag      ( "script" )               ;
  $HS     -> setSplitter ( "\n"     )               ;
  ///////////////////////////////////////////////////
  $PREFERs = array_keys ( $CIDs )                   ;
  foreach ( $PREFERs as $id )                       {
    $DFI   = "VidFrameId-{$id}"                     ;
    $JCS   = "$('#{$DFI}').css('height','100vh') ;" ;
    $HS   -> AddText ( $JCS )                       ;
  }                                                 ;
  ///////////////////////////////////////////////////
  return $HS                                        ;
}

public function scoreInput($SCORING="")
{
  $SJS  = "RatingChanged('{$this->Uuid}','Score',this.value) ;" ;
  $SIP  = new HtmlTag (                           )             ;
  ///////////////////////////////////////////////////////////////
  $SIP -> setInput    (                           )             ;
  $SIP -> AddPair     ( "type"     , "number"     )             ;
  $SIP -> AddPair     ( "size"     , "8"          )             ;
  $SIP -> AddPair     ( "class"    , "ScoreInput" )             ;
  $SIP -> AddPair     ( "min"      , "0"          )             ;
  $SIP -> AddPair     ( "max"      , "100"        )             ;
  $SIP -> AddPair     ( "step"     , "1"          )             ;
  $SIP -> AddPair     ( "onchange" , $SJS         )             ;
  $SIP -> SafePair    ( "value"    , $SCORING     )             ;
  ///////////////////////////////////////////////////////////////
  return $SIP                                                   ;
}

public function aidInput($PID,$ROLEID,$UUID)
{
  $HH   = new Parameters      (                            ) ;
  $ID   = $HH -> PeopleString ( $PID                       ) ;
  ////////////////////////////////////////////////////////////
  if ( gmp_cmp ( $PID , "0" ) == 0 ) $ID = ""                ;
  ////////////////////////////////////////////////////////////
  $JSC  = "changePeople(this.value,'{$ROLEID}','{$UUID}') ;" ;
  $INP  = new HtmlTag         (                            ) ;
  $INP -> setInput            (                            ) ;
  $INP -> AddPair             ( "type"     , "text"        ) ;
  $INP -> AddPair             ( "class"    , "NameInput"   ) ;
  $INP -> AddPair             ( "onchange" , $JSC          ) ;
  $INP -> AddPair             ( "value"    , $ID           ) ;
  ////////////////////////////////////////////////////////////
  return $INP                                                ;
}

public function JoinDIV($TAG,$IDTAG,$CLASSID)
{
  $DIV  = new HtmlTag (                        ) ;
  ////////////////////////////////////////////////
  $DIV -> setDiv      ( "" , $IDTAG , $CLASSID ) ;
  $DIV -> setSplitter ( "\n"                   ) ;
  $DIV -> AddTag      ( $TAG                   ) ;
  ////////////////////////////////////////////////
  return $DIV                                    ;
}

public function addButton($HR,$TAG)
{
  $HD    = $HR -> addTd (                           ) ;
  $HD   -> AddPair      ( "width"  , "2%"           ) ;
  $HD   -> AddPair      ( "nowrap" , "nowrap"       ) ;
  if                    ( is_a ( $TAG , "HtmlTag" ) ) {
    $HD -> AddTag       ( $TAG                      ) ;
  } else
  if                    ( strlen ( $TAG ) > 0       ) {
    $HD -> AddText      ( $TAG                      ) ;
  }                                                   ;
  return $HD                                          ;
}

public function addClassID($HR)
{
  $CID = $this -> toString ( )                      ;
  $JSC = "ClassClicked('{$CID}') ;"                 ;
  $HD  = $this -> addButton ( $HR          , $CID ) ;
  $HD -> AddPair            ( "ondblclick" , $JSC ) ;
}

public function CallOffItem($DB,$TZ,$CLASSID="")
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $ClassTypeIDs                                                       ;
  global $CourseNames                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  $CTnam = $ClassTypeIDs [ $this -> Type ]                                   ;
  $ITname =$CourseNames  [ $this -> Item ]                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $CPRD  = $this -> toPeriod        (                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $SName = $DB -> GetTrainee        ( "`erp`.`names`" , $this -> Trainee   ) ;
  $MName = $DB -> GetManager        ( "`erp`.`names`" , $this -> Manager   ) ;
  $TName = $DB -> GetTutor          ( "`erp`.`names`" , $this -> Tutor     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HT    = new HtmlTag              (                                      ) ;
  $HT   -> AddPair                  ( "class" , $CLASSID                   ) ;
  $TBODY = $HT    -> ConfigureTable ( 1 , 0 , 0                            ) ;
  $HR    = $TBODY -> addTr          (                                      ) ;
  $HR   -> setSplitter              ( "\n"                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR   -> addTd           ( $Translations [ "ClassID" ]          ) ;
  $HD   -> AddPair                  ( "nowrap" , "nowrap"                  ) ;
  $HD   -> AddPair                  ( "width"  , "2%"                      ) ;
  $this -> addClassID               ( $HR                                  ) ;
  $CPRD -> toHtml                   ( $TZ , $HR , "2%"                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $TBODY -> addTr          (                                      ) ;
  $HR   -> setSplitter              ( "\n"                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR   -> addTd           ( $Translations [ "Classes::Tutor"   ] ) ;
  $HD   -> AddPair                  ( "nowrap" , "nowrap"                  ) ;
  $HD   -> AddPair                  ( "width"  , "2%"                      ) ;
  $HR   -> addTd                    ( $TName                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR   -> addTd           ( $Translations [ "Classes::Course"  ] ) ;
  $HD   -> AddPair                  ( "nowrap" , "nowrap"                  ) ;
  $HD   -> AddPair                  ( "width"  , "2%"                      ) ;
  $HR   -> addTd                    ( $CourseNames  [ $this -> Item      ] ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD    = $HR   -> addTd           ( $Translations [ "Classes::State"   ] ) ;
  $HD   -> AddPair                  ( "nowrap" , "nowrap"                  ) ;
  $HD   -> AddPair                  ( "width"  , "2%"                      ) ;
  $HR   -> addTd                    ( $CTnam                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $TBODY -> addTr          (                                      ) ;
  $HR   -> setSplitter              ( "\n"                                 ) ;
  $HD    = $HR    -> addTd          (                                      ) ;
  $HD   -> AddPair                  ( "align"   , "right"                  ) ;
  $HD   -> AddPair                  ( "colspan" , "6"                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HS    = $HD    -> addHtml        ( "select"                             ) ;
  $HS   -> AddPair                  ( "id"    , $this -> Uuid              ) ;
  $HS   -> AddPair                  ( "class" , "CallOffSelection"         ) ;
  $HO    = $HS    -> addOption      ( $Translations [ "Classes::CallOff" ] ) ;
  $HO   -> AddPair                  ( "value" , "0"                        ) ;
  $HO    = $HS    -> addOption      ( $Translations [ "Classes::Attend"  ] ) ;
  $HO   -> AddPair                  ( "value" , "1"                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}

public function CallOffTable($DB,$TZ,$HDIV,$CLASSES,$CLASSID="")
{
  foreach ( $CLASSES as $cc )                                           {
    $this -> Uuid = $cc                                                 ;
    if ( $this -> ObtainsByUuid ( $DB , "`erp`.`classes`" ) )           {
      $HDIV -> AddTag ( $this -> CallOffItem ( $DB , $TZ , $CLASSID ) ) ;
    }                                                                   ;
  }                                                                     ;
}

public function StudentVideo($DB,$TZ,$IDX,$NOID)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG   = $Translations [ "ClassID" ]                                       ;
  $MSGID = $this -> toString         (                                     ) ;
  $MSG   = "{$MSG}{$MSGID}"                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $TNS   = $DB   -> GetTutor         ( "`erp`.`names`" , $this -> Tutor    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $PRD   = $this -> toPeriod         (                                     ) ;
  $PRD  -> ObtainsByUuid             ( $DB , "`erp`.`periods`"             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $FRM   = $this   -> FilmURL        ( $IDX , $NOID , "320" , "180"        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HT     = new HtmlTag              (                                     ) ;
  $TBODY  = $HT    -> ConfigureTable (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 影片畫面
  ////////////////////////////////////////////////////////////////////////////
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> AddPair                  ( "width"  , "320px"                  ) ;
  $HD    -> AddPair                  ( "height" , "180px"                  ) ;
  $HD    -> AddTag                   ( $FRM                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> AddPair                  ( "align"   , "left"                  ) ;
  $HD    -> AddPair                  ( "valign"  , "top"                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HTAB   = $HD    -> addHtml        (                                     ) ;
  $XBODY  = $HTAB  -> ConfigureTable (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $XBODY -> addTr          (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 切換畫面按鈕
  ////////////////////////////////////////////////////////////////////////////
  $PMSG   = $Translations [ "Classes::MajorPlayer" ]                         ;
  $JSC    = "ChooseVideo('{$NOID}','{$this->Uuid}') ;"                       ;
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> NoWrap                   (                                     ) ;
  $HD    -> AddPair                  ( "width"  , "1%"                     ) ;
  $BTN    = $HD    -> addButton      ( $PMSG                               ) ;
  $BTN   -> AddPair                  ( "class" , "SelectionButton"         ) ;
  $BTN   -> AddPair                  ( "onclick" , $JSC                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 課程編號
  ////////////////////////////////////////////////////////////////////////////
  $JSC    = "ClassClicked('{$MSGID}')"                                       ;
  $HD     = $HR    -> addTd          ( $MSG                                ) ;
  $HD    -> AddPair                  ( "ondblclick" , $JSC                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 教員人名
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $XBODY -> addTr          (                                     ) ;
  $this  -> addTutor                 ( $HR , $TNS                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 授課開始時間
  ////////////////////////////////////////////////////////////////////////////
  $SDT    = $PRD   -> toLongString   ( $TZ , "start" , "Y/m/d" , "H:i:s"   ) ;
  $HR     = $XBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          ( $Translations [ "StartTime" ]       ) ;
  $HD    -> NoWrap                   (                                     ) ;
  $HD     = $HR    -> addTd          ( $SDT                                ) ;
  $HD    -> NoWrap                   (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 授課結束時間
  ////////////////////////////////////////////////////////////////////////////
  $EDT    = $PRD   -> toLongString   ( $TZ , "end"   , "Y/m/d" , "H:i:s"   ) ;
  $HR     = $XBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          ( $Translations [ "EndTime" ]         ) ;
  $HD    -> NoWrap                   (                                     ) ;
  $HD     = $HR    -> addTd          ( $EDT                                ) ;
  $HD    -> NoWrap                   (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD     = $HR    -> addTd          (                                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 影片網址
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> AddPair                  ( "colspan" , "2"                     ) ;
  $HD    -> AddPair                  ( "align"   , "left"                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $VIDR   = $HD    -> addHtml        ( "a"                                 ) ;
  $VIDR  -> AddPair                  ( "href"   , $NOID                    ) ;
  $VIDR  -> AddPair                  ( "target" , "_blank"                 ) ;
  $VIDR  -> AddText                  ( $NOID                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
