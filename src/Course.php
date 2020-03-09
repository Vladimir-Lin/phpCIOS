<?php

namespace CIOS ;

class Course extends Columns
{

public $Id          ;
public $Uuid        ;
public $Used        ;
public $Identifier  ;
public $Prefer      ;
public $CourseItems ;
public $Complete    ;
public $Lessons     ;
public $Update      ;
public $Chinese     ;
public $English     ;
public $Native      ;

function __construct()
{
  $this -> Clear ( )  ;
}

function __destruct()
{
}

public function Clear()
{
  $this -> Id          = -1        ;
  $this -> Uuid        =  0        ;
  $this -> Used        =  0        ;
  $this -> Identifier  = ""        ;
  $this -> Prefer      =  0        ;
  $this -> Complete    =  0        ;
  $this -> Lessons     =  0        ;
  $this -> Update      = ""        ;
  $this -> CourseItems = array ( ) ;
}

public function assign($Item)
{
  $this -> Id          = $Item -> Id          ;
  $this -> Uuid        = $Item -> Uuid        ;
  $this -> Used        = $Item -> Used        ;
  $this -> Identifier  = $Item -> Identifier  ;
  $this -> Prefer      = $Item -> Prefer      ;
  $this -> CourseItems = $Item -> CourseItems ;
  $this -> Complete    = $Item -> Complete    ;
  $this -> Lessons     = $Item -> Lessons     ;
  $this -> Update      = $Item -> Update      ;
  $this -> Chinese     = $Item -> Chinese     ;
  $this -> English     = $Item -> English     ;
  $this -> Native      = $Item -> Native      ;
}

public function tableItems()
{
  $S = array (                   ) ;
  array_push ( $S , "id"         ) ;
  array_push ( $S , "uuid"       ) ;
  array_push ( $S , "used"       ) ;
  array_push ( $S , "identifier" ) ;
  array_push ( $S , "prefer"     ) ;
  array_push ( $S , "items"      ) ;
  array_push ( $S , "complete"   ) ;
  array_push ( $S , "ltime"      ) ;
  return $S                        ;
}

public function set($item,$V)
{
  $a = strtolower ( $item )                          ;
  if ( "id"         == $a ) $this -> Id         = $V ;
  if ( "uuid"       == $a ) $this -> Uuid       = $V ;
  if ( "used"       == $a ) $this -> Used       = $V ;
  if ( "identifier" == $a ) $this -> Identifier = $V ;
  if ( "prefer"     == $a ) $this -> Prefer     = $V ;
  if ( "complete"   == $a ) $this -> Complete   = $V ;
  if ( "lessons"    == $a ) $this -> Lessons    = $V ;
  if ( "ltime"      == $a ) $this -> Update     = $V ;
}

public function get($item)
{
  $a = strtolower ( $item )                            ;
  if ( "id"         == $a ) return $this -> Id         ;
  if ( "uuid"       == $a ) return $this -> Uuid       ;
  if ( "used"       == $a ) return $this -> Used       ;
  if ( "identifier" == $a ) return $this -> Identifier ;
  if ( "prefer"     == $a ) return $this -> Prefer     ;
  if ( "complete"   == $a ) return $this -> Complete   ;
  if ( "lessons"    == $a ) return $this -> Lessons    ;
  if ( "ltime"      == $a ) return $this -> Update     ;
  return false                                         ;
}

public function ItemPair($item)
{
  $a = strtolower ( $item )                           ;
  if ( "id"         == $a )                           {
    return "`{$a}` = " . (string) $this -> Id         ;
  }                                                   ;
  if ( "uuid"       == $a )                           {
    return "`{$a}` = " . (string) $this -> Uuid       ;
  }                                                   ;
  if ( "used"       == $a )                           {
    return "`{$a}` = " . (string) $this -> Used       ;
  }                                                   ;
  if ( "identifier" == $a )                           {
    return "`{$a}` = " . (string) $this -> Identifier ;
  }                                                   ;
  if ( "prefer"     == $a )                           {
    return "`{$a}` = " . (string) $this -> Prefer     ;
  }                                                   ;
  if ( "complete"   == $a )                           {
    return "`{$a}` = " . (string) $this -> Complete   ;
  }                                                   ;
  if ( "lessons"    == $a )                           {
    return "`{$a}` = " . (string) $this -> Lessons    ;
  }                                                   ;
  if ( "ltime"      == $a )                           {
    return "`{$a}` = " . (string) $this -> Update     ;
  }                                                   ;
  return ""                                           ;
}

public function obtain($R)
{
  ////////////////////////////////////////////////////
  $this -> Id          = $R [ "id"         ]         ;
  $this -> Uuid        = $R [ "uuid"       ]         ;
  $this -> Used        = $R [ "used"       ]         ;
  $this -> Identifier  = $R [ "identifier" ]         ;
  $this -> Prefer      = $R [ "prefer"     ]         ;
  $this -> Complete    = $R [ "complete"   ]         ;
  $this -> Update      = $R [ "ltime"      ]         ;
  ////////////////////////////////////////////////////
  $ITEM                = $R [ "items"      ]         ;
  if ( strlen ( $ITEM ) > 0 )                        {
    $this -> CourseItems = explode ( " , " , $ITEM ) ;
  } else                                             {
    $this -> CourseItems = array   (               ) ;
  }                                                  ;
  ////////////////////////////////////////////////////
}

public function addItem($ITEM)
{
  if ( in_array ( $ITEM , $this -> CourseItems ) ) return ;
  array_push ( $this -> CourseItems , $ITEM )             ;
  if ( count ( $this -> CourseItems ) > 1 )               {
    sort ( $this -> CourseItems )                         ;
  }                                                       ;
}

public function removeItem($ITEM)
{
  if ( ! in_array ( $ITEM , $this -> CourseItems ) ) return                ;
  if ( ( $key = array_search ( $ITEM , $this -> CourseItems ) ) !== false) {
    unset ( $this -> CourseItems [ $key ] )                                ;
    if ( count ( $this -> CourseItems ) > 1 )                              {
      sort ( $this -> CourseItems )                                        ;
    }                                                                      ;
  }                                                                        ;
}

public function GetChinese($DB,$TABLE)
{
  $this -> Chinese = $DB -> Naming ( $TABLE , $this -> Uuid , 1002 ) ;
}

public function GetEnglish($DB,$TABLE)
{
  $this -> English = $DB -> Naming ( $TABLE , $this -> Uuid , 1001 ) ;
}

public function GetNative($DB,$TABLE,$Language)
{
  $this -> Native = $DB -> Naming ( $TABLE , $this -> Uuid , $Language ) ;
}

public function ObtainsByUuid($DB,$TABLE)
{
  $ITX = $this -> Items          (                           ) ;
  $UIX = $this -> Uuid                                         ;
  $QQ  = "select {$ITX} from {$TABLE} where `uuid` = {$UIX} ;" ;
  $qq  = $DB   -> Query          ( $QQ                       ) ;
  if                             ( $DB -> hasResult ( $qq )  ) {
    $rr    = $qq -> fetch_array  ( MYSQLI_BOTH               ) ;
    $this -> obtain              ( $rr                       ) ;
    return true                                                ;
  }                                                            ;
  return false                                                 ;
}

public function GetCourses($DB,$TABLE,$ORDER="asc")
{
  $QQ = "select `uuid` from {$TABLE}"   .
        " where `used` > 0"             .
        " order by `prefer` {$ORDER} ;" ;
  return $DB -> ObtainUuids ( $QQ )     ;
}

public function GetReadyCourses ( $DB , $TABLE , $ORDER = "asc" )
{
  $QQ = "select `uuid` from {$TABLE}"   .
        " where `used` = 1"             .
        " order by `prefer` {$ORDER} ;" ;
  return $DB -> ObtainUuids ( $QQ )     ;
}

public function GetLessons($DB,$TABLE,$ORDER="asc")
{
  $QQ = "select `uuid` from {$TABLE}"   .
        " where `used` = 1"             .
        " and `course` = {$this->Uuid}" .
        " order by `prefer` {$ORDER} ;" ;
  return $DB -> ObtainUuids ( $QQ )     ;
}

public function ObtainLessons($DB,$TABLE)
{
  $QQ = "select count(*) from {$TABLE}"                 .
        " where `course` = {$this->Uuid}"               .
        " and `used` = 1 ;"                             ;
  $qq              = $DB -> query       ( $QQ         ) ;
  $rr              = $qq -> fetch_array ( MYSQLI_BOTH ) ;
  $this -> Lessons = $rr [ 0 ]                          ;
  return true                                           ;
}

public function Obtains($DB,$TABLE,$LESSONS,$NAMES)
{
  if ( ! $this -> ObtainsByUuid ( $DB , $TABLE ) ) return false ;
  $this -> ObtainLessons ( $DB , $LESSONS )                     ;
  $this -> GetChinese    ( $DB , $NAMES   )                     ;
  $this -> GetEnglish    ( $DB , $NAMES   )                     ;
  return true                                                   ;
}

// 更新課程優先次序號
public function UpdatePrefer($DB,$TABLE)
{
  $QQ  = "update {$TABLE}"                 .
         " set `prefer` = {$this->Prefer}" .
         " where `uuid` = {$this->Uuid} ;" ;
  $DB -> LockWrite    ( $TABLE )           ;
  $DB -> Query        ( $QQ    )           ;
  $DB -> UnlockTables (        )           ;
}

// 更新課程使用狀態
public function UpdateUsage($DB,$TABLE)
{
  $QQ  = "update {$TABLE}"                 .
         " set `used` = {$this->Used}"     .
         " where `uuid` = {$this->Uuid} ;" ;
  $DB -> LockWrite    ( $TABLE )           ;
  $DB -> Query        ( $QQ    )           ;
  $DB -> UnlockTables (        )           ;
}

// 更新課程完整度
public function UpdateComplete($DB,$TABLE)
{
  $QQ  = "update {$TABLE}"                     .
         " set `complete` = {$this->Complete}" .
         " where `uuid` = {$this->Uuid} ;"     ;
  $DB -> LockWrite    ( $TABLE )               ;
  $DB -> Query        ( $QQ    )               ;
  $DB -> UnlockTables (        )               ;
}

// 更新課程辨識字
public function UpdateIdentifier($DB,$TABLE)
{
  $QQ  = "update {$TABLE}"                           .
         " set `identifier` = '{$this->Identifier}'" .
         " where `uuid` = {$this->Uuid} ;"           ;
  $DB -> LockWrite    ( $TABLE )                     ;
  $DB -> Query        ( $QQ    )                     ;
  $DB -> UnlockTables (        )                     ;
}

// 更新教學種類列表
public function StoreItems($DB,$TABLE)
{
  //////////////////////////////////////////////////
  if ( count ( $this -> CourseItems ) > 0 )        {
    $SS = implode ( " , " , $this -> CourseItems ) ;
  } else                                           {
    $SS = ""                                       ;
  }                                                ;
  //////////////////////////////////////////////////
  $QQ  = "update {$TABLE}"                         .
         " set `items` = '{$SS}'"                  .
         " where `uuid` = {$this->Uuid} ;"         ;
  $DB -> LockWrite    ( $TABLE )                   ;
  $DB -> Query        ( $QQ    )                   ;
  $DB -> UnlockTables (        )                   ;
  //////////////////////////////////////////////////
}

// 新增一個課程編號
public function AppendCourse($DB,$TABLE,$MAIN)
{
  //////////////////////////////////////////////
  $UU  = $DB -> ObtainsUuid ( $TABLE , $MAIN ) ;
  //////////////////////////////////////////////
  $QQ  = "select `prefer` from {$TABLE}"       .
         " order by `prefer` desc limit 0,1 ;" ;
  $qq  = $DB -> Query ( $QQ )                  ;
  $PFR = 0                                     ;
  if ( $DB -> hasResult ( $qq ) )              {
    $rr  = $qq -> fetch_array ( MYSQLI_BOTH )  ;
    $PFR = $rr [ 0 ]                           ;
  }                                            ;
  $PFR = $PFR + 1                              ;
  //////////////////////////////////////////////
  $QQ  = "update {$TABLE}"                     .
         " set `prefer` = {$PFR} ,"            .
               " `used` = 2"                   .
         " where `uuid` = {$UU} ;"             ;
  $DB -> LockWrite    ( $TABLE )               ;
  $DB -> Query        ( $QQ    )               ;
  $DB -> UnlockTables (        )               ;
  //////////////////////////////////////////////
  return $UU                                   ;
}

// 新增一個章節編號
public function AppendLesson($DB,$TABLE,$MAIN)
{
  /////////////////////////////////////////////////
  $COURSE = $this -> Uuid                         ;
  /////////////////////////////////////////////////
  $LESSON = $DB -> ObtainsUuid ( $TABLE , $MAIN ) ;
  /////////////////////////////////////////////////
  $QQ     = "select `prefer` from {$TABLE}"       .
            " where `course` = {$COURSE}"         .
            " order by `prefer` desc limit 0,1 ;" ;
  $qq     = $DB -> Query ( $QQ )                  ;
  $PFR    = 0                                     ;
  if ( $DB -> hasResult ( $qq ) )                 {
    $rr  = $qq -> fetch_array ( MYSQLI_BOTH )     ;
    $PFR = $rr [ 0 ]                              ;
  }                                               ;
  $PFR = $PFR + 1                                 ;
  /////////////////////////////////////////////////
  $QQ  = "update {$TABLE}"                        .
         " set `prefer` = {$PFR} ,"               .
               " `used` = 2 ,"                    .
             " `course` = {$COURSE}"              .
         " where `uuid` = {$LESSON} ;"            ;
  $DB -> LockWrite    ( $TABLE )                  ;
  $DB -> Query        ( $QQ    )                  ;
  $DB -> UnlockTables (        )                  ;
  /////////////////////////////////////////////////
  return $LESSON                                  ;
}

public function ListSelections($UU,$MM)
{
  $PCS  = new HtmlTag         (                        ) ;
  $PCS -> setTag              ( "select"               ) ;
  $PCS -> setSplitter         ( "\n"                   ) ;
  foreach                     ( $UU as $uu             ) {
    $LCO  = $PCS -> addOption (                        ) ;
    $LCO -> AddPair           ( "value" , (string) $uu ) ;
    $LCO -> AddText           ( $MM [ $uu ]            ) ;
  }                                                      ;
  return $PCS                                            ;
}

public function TrLine($HTML,$TXT)
{
  $BJ  = "RemoveCourse('" . $this -> Uuid . "');"   ;
  $HR  = $HTML -> addTr     (                     ) ;
  $HR -> setSplitter        ( "\n"                ) ;
  $HD  = $HR   -> addTd     (                     ) ;
  $HD -> AddText            ( $this -> Identifier ) ;
  $HD  = $HR   -> addTd     (                     ) ;
  $HD -> AddText            ( $this -> Chinese    ) ;
  $HD  = $HR   -> addTd     (                     ) ;
  $HD -> AddText            ( $this -> English    ) ;
  $HD  = $HR   -> addTd     (                     ) ;
  $HD -> AddPair            ( "align"   , "right" ) ;
  $HD -> AddText            ( $this -> Lessons    ) ;
  $HD  = $HR   -> addTd     (                     ) ;
  $HD -> AddPair            ( "align"   , "right" ) ;
  $HB  = $HD   -> addButton (                     ) ;
  $HB -> AddPair            ( "onclick" , $BJ     ) ;
  $HB -> AddText            ( $TXT                ) ;
  return $HB                                        ;
}

public function BlockHtml($Append=1)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $HG = new HtmlTag ( )                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  switch ( $Append )                                                         {
    case 0                                                                   :
      $MSG = $Translations [ "Courses::Remove" ]                             ;
      $SS  = $this -> Chinese . " (" . $this -> Identifier . ")"             ;
      $OC  = "RemoveCourse('{$this->Uuid}') ;"                               ;
      $HG -> setTag  ( "button"                                            ) ;
      $HG -> AddPair ( "class"   , "SelectionButton"                       ) ;
      $HG -> AddPair ( "onclick" , $OC                                     ) ;
      $HG -> AddText ( $MSG                                                ) ;
    break                                                                    ;
    case 1                                                                   :
      $MSG = $Translations [ "Courses::Append" ]                             ;
      $SS  = $this -> Chinese . " (" . $this -> Identifier . ")"             ;
      $OC  = "AppendCourse('{$this->Uuid}','" . $SS . "');"                  ;
      $HG -> setTag  ( "button"                                            ) ;
      $HG -> AddPair ( "class"   , "SelectionButton"                       ) ;
      $HG -> AddPair ( "onclick" , $OC                                     ) ;
      $HG -> AddText ( $MSG                                                ) ;
    break                                                                    ;
    default                                                                  :
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HT  = new HtmlTag           (                                           ) ;
  $HB  = $HT -> ConfigureTable ( 1 , 0 , 0                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HT -> AddPair               ( "class"       , "CourseBlock"             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = $HB -> addTr          (                                           ) ;
  $HR -> setSplitter           ( "\n"                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "align"   , "center"                      ) ;
  $HD -> AddText               ( $this -> Identifier                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JCW = "ShowCourseDetails('$this->Uuid') ;"                                ;
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "align"   , "center"                      ) ;
  $BTX = $HD -> addButton      ( "課程細節" ) ;
  $BTX -> AddPair              ( "class"   , "SelectionButton"             ) ;
  $BTX -> AddPair              ( "onclick" , $JCW                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "align"   , "right"                       ) ;
  $HD -> AddTag                ( $HG                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = $HB -> addTr          (                                           ) ;
  $HR -> setSplitter           ( "\n"                                      ) ;
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "colspan" , "3"                           ) ;
  $HD -> AddPair               ( "align"   , "center"                      ) ;
  $HD -> AddText               ( $this -> English                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = $HB -> addTr          (                                           ) ;
  $HR -> setSplitter           ( "\n"                                      ) ;
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "colspan" , "3"                           ) ;
  $HD -> AddPair               ( "align"   , "center"                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JXC = "GoCourse('$this->Uuid')"                                           ;
  $HI  = new HtmlTag           (                                           ) ;
  $HI -> setTag                ( "img"                                     ) ;
  $HI -> setType               ( 2                                         ) ;
  $HI -> AddPair               ( "src"        , "/images/Book.png"         ) ;
  $HI -> AddPair               ( "ondblclick" , $JXC                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD -> AddTag                ( $HI                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = $HB -> addTr          (                                           ) ;
  $HR -> setSplitter           ( "\n"                                      ) ;
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "colspan" , "3"                           ) ;
  $HD -> AddPair               ( "align"   , "center"                      ) ;
  $HD -> AddText               ( $this -> Chinese                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG = $Translations [ "Chapter::Total" ]                                  ;
  $CS  = str_replace           ( "$(TOTAL)" , $this -> Lessons , $MSG      ) ;
  $HR  = $HB -> addTr          (                                           ) ;
  $HR -> setSplitter           ( "\n"                                      ) ;
  $HD  = $HR -> addTd          (                                           ) ;
  $HD -> AddPair               ( "colspan" , "3"                           ) ;
  $HD -> AddPair               ( "align"   , "center"                      ) ;
  $HD -> AddText               ( $CS                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}

public function FrontBlock($IMG)
{
  /////////////////////////////////////////////////////////
  global $Translations                                    ;
  /////////////////////////////////////////////////////////
  $HT  = new HtmlTag    (                               ) ;
  $HT -> AddPair        ( "class"       , "CourseBlock" ) ;
  $HB  = $HT -> ConfigureTable ( 1 , 0 , 0              ) ;
  /////////////////////////////////////////////////////////
  $HR  = $HB -> addTr   (                               ) ;
  $HD  = $HR -> addTd   (                               ) ;
  $HD -> AddPair        ( "align"   , "center"          ) ;
  $HD -> AddText        ( $this -> Identifier           ) ;
  /////////////////////////////////////////////////////////
  $MSG = $Translations [ "Lectures::Lessons" ]            ;
  $CS  = $this -> Lessons . $MSG                          ;
  $HD  = $HR -> addTd   (                               ) ;
  $HD -> AddPair        ( "align"   , "right"           ) ;
  $HD -> AddText        ( $CS                           ) ;
  /////////////////////////////////////////////////////////
  $HR  = $HB -> addTr   (                               ) ;
  $HD  = $HR -> addTd   (                               ) ;
  $HD -> AddPair        ( "colspan" , "2"               ) ;
  $HD -> AddPair        ( "align"   , "center"          ) ;
  $HD -> AddText        ( $this -> English              ) ;
  /////////////////////////////////////////////////////////
  $HR  = $HB -> addTr   (                               ) ;
  $HD  = $HR -> addTd   (                               ) ;
  $HD -> AddPair        ( "colspan" , "2"               ) ;
  $HD -> AddPair        ( "align"   , "center"          ) ;
  $HD -> AddTag         ( $IMG                          ) ;
  /////////////////////////////////////////////////////////
  $HR  = $HB -> addTr   (                               ) ;
  $HD  = $HR -> addTd   (                               ) ;
  $HD -> AddPair        ( "colspan" , "2"               ) ;
  $HD -> AddPair        ( "align"   , "center"          ) ;
  $HD -> AddText        ( $this -> Native               ) ;
  /////////////////////////////////////////////////////////
  return $HT                                              ;
}

public function addChinese($CLASSID="",$editable=false)
{
  $CJS  = "CourseChinese(this.value,'{$this->Uuid}') ;"  ;
  $HDIV = new HtmlTag  (                               ) ;
  if                   ( $editable                     ) {
    $HDIV  -> setInput (                               ) ;
    $HDIV  -> AddPair  ( "type"     , "text"           ) ;
    $HDIV  -> AddPair  ( "onchange" , $CJS             ) ;
    $HDIV  -> AddPair  ( "value"    , $this -> Chinese ) ;
  } else                                                 {
    $HDIV -> setDiv    ( $this -> Chinese              ) ;
  }                                                      ;
  if                   ( strlen ( $CLASSID ) > 0       ) {
    $HDIV  -> AddPair  ( "class" , $CLASSID            ) ;
  }                                                      ;
  return $HDIV                                           ;
}

public function addEnglish($CLASSID="",$editable=false)
{
  $CJS  = "CourseEnglish(this.value,'{$this->Uuid}') ;"  ;
  $HDIV = new HtmlTag  (                               ) ;
  if                   ( $editable                     ) {
    $HDIV  -> setInput (                               ) ;
    $HDIV  -> AddPair  ( "type"     , "text"           ) ;
    $HDIV  -> AddPair  ( "onchange" , $CJS             ) ;
    $HDIV  -> AddPair  ( "value"    , $this -> English ) ;
  } else                                                 {
    $HDIV -> setDiv    ( $this -> English              ) ;
  }                                                      ;
  if                   ( strlen ( $CLASSID ) > 0       ) {
    $HDIV  -> AddPair  ( "class" , $CLASSID            ) ;
  }                                                      ;
  return $HDIV                                           ;
}

public function addLanguage($LANG,$CLASSID="",$editable=false)
{
  $CJS  = "CourseLanguage(this.value,{$LANG},'{$this->Uuid}') ;" ;
  $HDIV = new HtmlTag  (                              )          ;
  if                   ( $editable                    )          {
    $HDIV  -> setInput (                              )          ;
    $HDIV  -> AddPair  ( "type"     , "text"          )          ;
    $HDIV  -> AddPair  ( "onchange" , $CJS            )          ;
    $HDIV  -> AddPair  ( "value"    , $this -> Native )          ;
  } else                                                         {
    $HDIV -> setDiv    ( $this -> Native              )          ;
  }                                                              ;
  if                   ( strlen ( $CLASSID ) > 0      )          {
    $HDIV  -> AddPair  ( "class" , $CLASSID           )          ;
  }                                                              ;
  return $HDIV                                                   ;
}

public function addIdentifier($CLASSID="",$editable=false)
{
  $CJS  = "CourseIdentifier(this.value,'{$this->Uuid}') ;"  ;
  $HDIV = new HtmlTag  (                                  ) ;
  if                   ( $editable                        ) {
    $HDIV  -> setInput (                                  ) ;
    $HDIV  -> AddPair  ( "type"     , "text"              ) ;
    $HDIV  -> AddPair  ( "onchange" , $CJS                ) ;
    $HDIV  -> AddPair  ( "value"    , $this -> Identifier ) ;
  } else                                                    {
    $HDIV  -> setDiv   ( $this -> Identifier              ) ;
  }                                                         ;
  $HDIV    -> SafePair ( "class" , $CLASSID               ) ;
  return $HDIV                                              ;
}

public function addPrefer($CLASSID="",$editable=false)
{
  $CJS  = "CoursePrefer(this.value,'{$this->Uuid}') ;"  ;
  $HDIV = new HtmlTag  (                              ) ;
  if                   ( $editable                    ) {
    $HDIV  -> setInput (                              ) ;
    $HDIV  -> AddPair  ( "type"     , "number"        ) ;
    $HDIV  -> AddPair  ( "min"      , "1"             ) ;
    $HDIV  -> AddPair  ( "max"      , "9999999999"    ) ;
    $HDIV  -> AddPair  ( "onchange" , $CJS            ) ;
    $HDIV  -> AddPair  ( "value"    , $this -> Prefer ) ;
  } else                                                {
    $HDIV -> setDiv    ( $this -> Prefer              ) ;
  }                                                     ;
  if                   ( strlen ( $CLASSID ) > 0      ) {
    $HDIV  -> AddPair  ( "class" , $CLASSID           ) ;
  }                                                     ;
  return $HDIV                                          ;
}

public function addCodeLabel($HR,$bgcolor)
{
  global $Translations                                          ;
  $HD  = $HR -> addTd ( $Translations [ "Curriculums::Code" ] ) ;
  $HD -> AddPair      ( "width"   , "5%"                      ) ;
  $HD -> AddPair      ( "align"   , "center"                  ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolor                  ) ;
  return $HD                                                    ;
}

public function addIdentifierLabel($HR,$bgcolor)
{
  global $Translations                                                ;
  $HD  = $HR -> addTd ( $Translations [ "Curriculums::Identifier" ] ) ;
  $HD -> AddPair      ( "width"   , "7%"                            ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"                        ) ;
  $HD -> AddPair      ( "align"   , "center"                        ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolor                        ) ;
  return $HD                                                          ;
}

public function addActivationLabel($HR,$bgcolor)
{
  global $Translations                                                ;
  $HD  = $HR -> addTd ( $Translations [ "Curriculums::Activation" ] ) ;
  $HD -> AddPair      ( "width"   , "3%"                            ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"                        ) ;
  $HD -> AddPair      ( "align"   , "center"                        ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolor                        ) ;
  return $HD                                                          ;
}

public function addLessonsLabel($HR,$bgcolor)
{
  global $Translations                                             ;
  $HD  = $HR -> addTd ( $Translations [ "Curriculums::Lessons" ] ) ;
  $HD -> AddPair      ( "width"   , "3%"                         ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"                     ) ;
  $HD -> AddPair      ( "align"   , "center"                     ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolor                     ) ;
  return $HD                                                       ;
}

public function addLanguageLabel($HR,$LANG,$WIDTH,$bgcolor)
{
  global $Translations                             ;
  global $LanguageNames                            ;
  $HD  = $HR -> addTd ( $LanguageNames [ $LANG ] ) ;
  $HD -> AddPair      ( "width"   , $WIDTH       ) ;
  $HD -> AddPair      ( "nowrap"  , "nowrap"     ) ;
  $HD -> AddPair      ( "align"   , "center"     ) ;
  $HD -> SafePair     ( "bgcolor" , $bgcolor     ) ;
  return $HD                                       ;
}

public function addAppendCourse($HR,$bgcolor)
{
  global $Translations                                                 ;
  //////////////////////////////////////////////////////////////////////
  $ACJ  = "AppendCurriculum() ;"                                       ;
  //////////////////////////////////////////////////////////////////////
  $HD   = $HR -> addTd     (                                         ) ;
  $HD  -> AddPair          ( "width"   , "2%"                        ) ;
  $HD  -> AddPair          ( "nowrap"  , "nowrap"                    ) ;
  $HD  -> AddPair          ( "align"   , "right"                     ) ;
  $HD  -> SafePair         ( "bgcolor" , $bgcolor                    ) ;
  //////////////////////////////////////////////////////////////////////
  $BTN  = $HD -> addButton ( $Translations [ "Curriculums::Append" ] ) ;
  $BTN -> AddPair          ( "class"   , "AddCourseButton"           ) ;
  $BTN -> AddPair          ( "onclick" , $ACJ                        ) ;
  //////////////////////////////////////////////////////////////////////
  return $HD                                                           ;
}

public function addEditCourse($HR)
{
  global $Translations                                                ;
  /////////////////////////////////////////////////////////////////////
  $CEJ   = "CurriculumClicked('{$this -> Uuid}')"                     ;
  /////////////////////////////////////////////////////////////////////
  $HD    = $HR -> addTd     (                                       ) ;
  $HD   -> AddPair          ( "align"   , "right"                   ) ;
  $HD   -> AddPair          ( "nowrap"  , "nowrap"                  ) ;
  $HD   -> AddPair          ( "width"   , "2%"                      ) ;
  /////////////////////////////////////////////////////////////////////
  $BTN   = $HD -> addButton ( $Translations [ "Curriculums::Edit" ] ) ;
  $BTN  -> AddPair          ( "class"   , "EditCourseButton"        ) ;
  $BTN  -> AddPair          ( "onclick" , $CEJ                      ) ;
  /////////////////////////////////////////////////////////////////////
  return $HD                                                          ;
}

// 「可教授課程表」按鈕
public function addInstructable($PEOPLE)
{
  global $Translations                                  ;
  ///////////////////////////////////////////////////////
  $MSG  = $Translations [ "Curriculums::Setting" ]      ;
  $JSC  = "lectureTable('{$PEOPLE}') ;"                 ;
  ///////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                               ) ;
  $BTN -> setTag      ( "button"                      ) ;
  $BTN -> AddPair     ( "class"   , "SelectionButton" ) ;
  $BTN -> AddPair     ( "onclick" , $JSC              ) ;
  $BTN -> AddText     ( $MSG                          ) ;
  ///////////////////////////////////////////////////////
  return $BTN                                           ;
}

public function addItemLabel($HR,$ITEM,$JSC="")
{
  $HD  = $HR -> addTd ( $this -> get ($ITEM)    ) ;
  $HD -> AddPair      ( "nowrap"     , "nowrap" ) ;
  $HD -> AddPair      ( "width"      , "1%"     ) ;
  $HD -> SafePair     ( "ondblclick" , $JSC     ) ;
  return $HD                                      ;
}

public function addHeaderLabel($HR,$ITEM="")
{
  $HD  = $HR -> addTd ( $ITEM               ) ;
  $HD -> AddPair      ( "nowrap" , "nowrap" ) ;
  $HD -> AddPair      ( "width"  , "1%"     ) ;
  $HD -> AddPair      ( "align"  , "center" ) ;
  return $HD                                  ;
}

public function usageIcon()
{
  global $CourseImagePath                                            ;
  $IMG  = new Html (                                               ) ;
  $IMG -> setTag   ( "img"                                         ) ;
  $IMG -> AddPair  ( "width"  , "24"                               ) ;
  $IMG -> AddPair  ( "height" , "24"                               ) ;
  $IMG -> AddPair  ( "src"    , $CourseImagePath [ $this -> Used ] ) ;
  return $IMG                                                        ;
}

public function CourseRow($DB,$HB)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ  = $this -> SelectItems ( "`erp`.`courses`" )                          ;
  $qq  = $DB   -> Query       ( $QQ               )                          ;
  if ( ! $DB -> hasResult ( $qq ) ) return                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $rr      = $qq -> fetch_array ( MYSQLI_BOTH             )                  ;
  $this   -> obtain             ( $rr                     )                  ;
  $this   -> GetChinese         ( $DB , "`erp`.`names`"   )                  ;
  $this   -> GetEnglish         ( $DB , "`erp`.`names`"   )                  ;
  $this   -> ObtainLessons      ( $DB , "`erp`.`lessons`" )                  ;
  $LESSONS = $this -> Lessons . $Translations [ "Lectures::Lessons" ]        ;
  ////////////////////////////////////////////////////////////////////////////
  $HR  = $HB -> addTr (                                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $this -> Identifier                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $this -> Chinese                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $this -> English                                   ) ;
  $HD -> AddPair      ( "colspan" , "3"                                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HD  = $HR -> addTd ( $LESSONS                                           ) ;
  $HD -> AddPair      ( "align"   , "right"                                ) ;
  ////////////////////////////////////////////////////////////////////////////
}

public function CourseRows($DB,$HB,$COURSES)
{
  foreach              ( $COURSES as $cc ) {
    $this -> Uuid = $cc                    ;
    $this -> CourseRow ( $DB , $HB       ) ;
  }                                        ;
}

public function IconID ( $DB )
{
  $DID = "3800000000000000005"                              ;
  ///////////////////////////////////////////////////////////
  $RI  = new Relation         (                           ) ;
  $RI -> set                  ( "first" , $this -> Uuid   ) ;
  $RI -> setT1                ( "Course"                  ) ;
  $RI -> setT2                ( "Picture"                 ) ;
  $RI -> setRelation          ( "Using"                   ) ;
  $UX  = $RI -> Subordination ( $DB , "`erp`.`relations`" ) ;
  if ( count ( $UX ) > 0 ) $DID = $UX [ 0 ]                 ;
  ///////////////////////////////////////////////////////////
  return $DID                                               ;
}

public function IconTable($DB,$ICONPATH)
{
  $DID = $this -> IconID   ( $DB                    ) ;
  $IMG = $this -> IconPath ( $ICONPATH , $DID       ) ;
  /////////////////////////////////////////////////////
  $PIC = new Picture       (                        ) ;
  $HT  = new HtmlTag       (                        ) ;
  $HT -> setTag            ( "div"                  ) ;
  $HT -> setSplitter       ( "\n"                   ) ;
  $HT -> AddPair           ( "id" , "CourseIcon"    ) ;
  /////////////////////////////////////////////////////
  $HV  = $HT -> addHtml    ( "div"                  ) ;
  $HV -> AddPair           ( "id" , "CourseImage"   ) ;
  /////////////////////////////////////////////////////
  $HV -> AddTag            ( $IMG                   ) ;
  /////////////////////////////////////////////////////
  $HT -> AddText           ( "<br>"                 ) ;
  /////////////////////////////////////////////////////
  $HX  = $HT -> addDiv     (                        ) ;
  $HX -> AddTag            ( $PIC -> UploadForm ( ) ) ;
  /////////////////////////////////////////////////////
  return $HT                                          ;
}

public function CourseIcon($DB,$ICON,$VIEW,$WIDTH="144px")
{
  $UITX  = $this -> IconTable ( $DB      , $VIEW    ) ;
  $ICON -> AddPair            ( "id"     , "IconTD" ) ;
  $ICON -> AddPair            ( "align"  , "center" ) ;
  $ICON -> AddPair            ( "valign" , "top"    ) ;
  $ICON -> AddPair            ( "width"  , $WIDTH   ) ;
  $ICON -> AddTag             ( $UITX               ) ;
}

public function ItemListing($index)
{
  ////////////////////////////////////////////////////////////////////////////
  global $CourseNames                                                        ;
  global $CourseListings                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  switch             ( $index                                              ) {
    case 0                                                                   :
      ////////////////////////////////////////////////////////////////////////
      $ITEMs = array (                                                     ) ;
      ////////////////////////////////////////////////////////////////////////
      foreach        ( $this -> CourseItems as $it                         ) {
        $ITEMs [ $it ] = $CourseListings [ $it ]                             ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
    case 1                                                                   :
      $ITEMs = $CourseNames                                                  ;
    break                                                                    ;
    case 2                                                                   :
      $ITEMs = $CourseListings                                               ;
    break                                                                    ;
    case 3                                                                   :
      ////////////////////////////////////////////////////////////////////////
      $ITEMs = array      (                                                ) ;
      $KEYs  = array_keys ( $CourseNames                                   ) ;
      ////////////////////////////////////////////////////////////////////////
      foreach             ( $KEYs as $it                                   ) {
        if                ( ! in_array ( $it , $this -> CourseItems )      ) {
          $ITEMs [ $it ] = $CourseNames [ $it ]                              ;
        }                                                                    ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
    case 4                                                                   :
      ////////////////////////////////////////////////////////////////////////
      $ITEMs = array      (                                                ) ;
      $KEYs  = array_keys ( $CourseListings                                ) ;
      ////////////////////////////////////////////////////////////////////////
      foreach             ( $KEYs as $it                                   ) {
        if                ( ! in_array ( $it , $this -> CourseItems )      ) {
          $ITEMs [ $it ] = $CourseListings [ $it ]                           ;
        }                                                                    ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    break                                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HT  = new HtmlTag (                                                     ) ;
  $HT -> setTag      ( "select"                                            ) ;
  $HT -> addOptions  ( $ITEMs                                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HT                                                                 ;
}

//////////////////////////////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////
?>
