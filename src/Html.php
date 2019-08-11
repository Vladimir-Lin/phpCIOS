<?php

namespace CIOS ;

class Html
{

public $Type       ;
public $Tag        ;
public $Attributes ;
public $Tags       ;
public $Splitter   ;
public $Tail       ;
public $Objects    ;

function __construct()
{
  $this -> clear ( ) ;
}

function __destruct()
{
  unset ( $this -> Attributes ) ;
  unset ( $this -> Tags       ) ;
  unset ( $this -> Objects    ) ;
}

public function clear()
{
  $this -> Type       = 0         ;
  $this -> Tag        = ""        ;
  $this -> Attributes = array ( ) ;
  $this -> Tags       = array ( ) ;
  $this -> Tail       = ""        ;
  $this -> Objects    = array ( ) ;
}

public function setType($T)
{
  $this -> Type = $T ;
}

public function setExport($T)
{
  $v = strtolower ( $T )   ;
  if ( $v == "dom"       ) {
    $this -> Type = 1      ;
  } else
  if ( $v == "tag"       ) {
    $this -> Type = 2      ;
  } else
  if ( $v == "context"   ) {
    $this -> Type = 3      ;
  } else
  if ( $v == "container" ) {
    $this -> Type = 4      ;
  }
}

public function setTag($T)
{
  $t = strtolower ( $T )    ;
  $this -> Tag = $T         ;
  ///////////////////////////
  if ( 0 == $this -> Type ) {
    $this -> Type = 1       ;
  }                         ;
  ///////////////////////////
  if ( "input" == $t )      {
    $this -> Type = 2       ;
  }                         ;
  ///////////////////////////
  if ( "img"   == $t )      {
    $this -> Type = 2       ;
  }                         ;
  ///////////////////////////
  if ( "i"     == $t )      {
    $this -> Type = 2       ;
  }                         ;
  ///////////////////////////
  if ( "br"    == $t )      {
    $this -> Type = 2       ;
  }                         ;
}

public function setObject($INDEX,$OBJECT)
{
  $this -> Objects [ $INDEX ] = $OBJECT ;
}

public function getObject($INDEX)
{
  return $this -> Objects [ $INDEX ] ;
}

public function setText($T)
{
  $this -> Tag  = $T ;
  $this -> Type = 3  ;
}

public function AddText($T)
{
  $H     = new Html (    ) ;
  $H    -> setText  ( $T ) ;
  $this -> AddTag   ( $H ) ;
  return $H                ;
}

public function LoadText($FILENAME)
{
  $TXT   = file_get_contents ( $FILENAME ) ;
  $this -> AddText           ( $TXT      ) ;
}

public function setSplitter( $S = "\n" )
{
  $this -> Splitter = $S ;
}

public function setTail( $T = "\n" )
{
  $this -> Tail = $T ;
}

public function NewChild()
{
  $NT = new Html  (     ) ;
  $this -> AddTag ( $NT ) ;
  return $NT              ;
}

public function AddTag($T)
{
  array_push ( $this -> Tags , $T ) ;
}

public function PrependTag($T)
{
  array_unshift ( $this -> Tags , $T ) ;
}

public function AddMember($M)
{
  array_push ( $this -> Attributes , $M ) ;
}

public function KeyPair ( $N , $V )
{
  return $N . "=" . $this -> DoubleQuote ( $V ) ;
}

public function AddPair ( $N , $V )
{
  return $this -> AddMember ( $this -> KeyPair ( $N , $V ) ) ;
}

public function SafePair ( $N , $V )
{
  if ( strlen ( $V ) <= 0 ) return    ;
  return $this -> AddPair ( $N , $V ) ;
}

public function EndTag ( )
{
  if ( strlen ( $this -> Tag ) <= 0 ) return "" ;
  return "</" . $this -> Tag . ">"              ;
}

public function DoubleQuote($T)
{
  return "\"{$T}\"" ;
}

public function SingleQuote($T)
{
  return "'{$T}'" ;
}

public function DQ ( $T )
{
  return DoubleQuote ( $T ) ;
}

public function SQ ( $T )
{
  return SingleQuote ( $T ) ;
}

public function NewLine ( )
{
  return "\n" ;
}

public function Html ( )
{
  $H = "<" . $this -> Tag                                 ;
  if ( count ( $this -> Attributes ) > 0 )                {
    $H = $H . " " . implode ( " " , $this -> Attributes ) ;
  }                                                       ;
  $H = $H . ">"                                           ;
  return $H                                               ;
}

public function Inside($Content)
{
  return $this -> Html   ( ) . $this -> Splitter .
         $Content            . $this -> Splitter .
         $this -> EndTag ( ) . $this -> Tail     ;
}

public function TagsContent()
{
  if           ( count ( $this -> Tags ) <= 0 ) {
    return ""                                   ;
  }                                             ;
  $A = array   (                              ) ;
  foreach      ( $this -> Tags as $T          ) {
    array_push ( $A , $T -> Content ( )       ) ;
  }                                             ;
  $L = implode ( $this -> Splitter , $A       ) ;
  return $L                                     ;
}

public function setDiv($Msg="",$IDNAME="",$CLASSNAME="")
{
  $this -> Tag  = "div"                       ;
  $this -> Type = 1                           ;
  $this -> SafePair  ( "id"    , $IDNAME    ) ;
  $this -> SafePair  ( "class" , $CLASSNAME ) ;
  if                 ( strlen ( $Msg ) > 0  ) {
    $this -> AddText ( $Msg                 ) ;
  }                                           ;
}

public function setSpan($Msg="",$IDNAME="",$CLASSNAME="")
{
  $this -> Tag  = "span"                      ;
  $this -> Type = 1                           ;
  $this -> SafePair  ( "id"    , $IDNAME    ) ;
  $this -> SafePair  ( "class" , $CLASSNAME ) ;
  if                 ( strlen ( $Msg ) > 0  ) {
    $this -> AddText ( $Msg                 ) ;
  }                                           ;
}

public function setInput()
{
  $this -> Tag  = "input" ;
  $this -> Type = 2       ;
}

public function setHiddenInput()
{
  $this -> setInput (                   ) ;
  $this -> AddPair  ( "type" , "hidden" ) ;
}

public function setScript($SRC)
{
  $this -> Tag  = "script"           ;
  $this -> Type = 1                  ;
  $this -> SafePair ( "src" , $SRC ) ;
}

public function LoadScript($FILENAME)
{
  $this -> Tag  = "script"        ;
  $this -> Type = 1               ;
  $this -> LoadText ( $FILENAME ) ;
}

public function setMain($CLASSID)
{
  $this -> setTag      ( "main"             ) ;
  $this -> SafePair    ( "class" , $CLASSID ) ;
  $this -> setSplitter ( "\n"               ) ;
}

public function ConfigureTable($BORDER=0,$SPACING=0,$PADDING=0)
{
  $this -> setTag      ( "table"                  ) ;
  $this -> AddPair     ( "width"       , "100%"   ) ;
  $this -> AddPair     ( "border"      , $BORDER  ) ;
  $this -> AddPair     ( "cellspacing" , $SPACING ) ;
  $this -> AddPair     ( "cellpadding" , $PADDING ) ;
  ///////////////////////////////////////////////////
  $HB    = new Html    (                          ) ;
  $HB   -> setTag      ( "tbody"                  ) ;
  $HB   -> setSplitter ( "\n"                     ) ;
  $this -> AddTag      ( $HB                      ) ;
  ///////////////////////////////////////////////////
  return $HB                                        ;
}

public function addDiv($Msg = "",$IDNAME="",$CLASSNAME="")
{
  $HD    = new Html (                             ) ;
  $HD   -> setDiv   ( $Msg , $IDNAME , $CLASSNAME ) ;
  $this -> AddTag   ( $HD                         ) ;
  return $HD                                        ;
}

public function addSpan($Msg = "",$IDNAME="",$CLASSNAME="")
{
  $HD    = new Html (                             ) ;
  $HD   -> setSpan  ( $Msg , $IDNAME , $CLASSNAME ) ;
  $this -> AddTag   ( $HD                         ) ;
  return $HD                                        ;
}

public function addTr()
{
  $HR    = new Html (      ) ;
  $HR   -> setTag   ( "tr" ) ;
  $this -> AddTag   ( $HR  ) ;
  return $HR                 ;
}

public function addTd ( $MSG = "" )
{
  $HD    = new Html (                             ) ;
  $HD   -> setTag   ( "td"                        ) ;
  $this -> AddTag   ( $HD                         ) ;
  if                ( is_a ( $MSG , "CIOS\Html" ) ) {
    $HD -> AddTag   ( $MSG                        ) ;
  } else
  if                ( strlen ( $MSG ) > 0         ) {
    $HD -> AddText  ( $MSG                        ) ;
  }                                                 ;
  return $HD                                        ;
}

public function addTDs($MSGs)
{
  $HDs  = array          (               ) ;
  foreach                ( $MSGs as $msg ) {
    $HD = $this -> addTd ( $msg          ) ;
    array_push           ( $HDs , $HD    ) ;
  }                                        ;
  return $HDs                              ;
}

public function addTrLine($MSGs)
{
  $HR  = $this -> addTr  (       ) ;
  $HR          -> addTDs ( $MSGs ) ;
  return $HR                       ;
}

public function appendTrLine($Inner)
{
  $HR  = $this -> addTr (        ) ;
  $HD  = $HR   -> addTd (        ) ;
  $HD -> AddTag         ( $Inner ) ;
  return $HR                       ;
}

public function addSelect($CLASSID="")
{
  $HS    = new Html (                    ) ;
  $HS   -> setTag   ( "select"           ) ;
  $HS   -> SafePair ( "class" , $CLASSID ) ;
  $this -> AddTag   ( $HS                ) ;
  return $HS                               ;
}

public function addOption ( $MSG = "" )
{
  $HD    = new Html (                     ) ;
  $HD   -> setTag   ( "option"            ) ;
  $this -> AddTag   ( $HD                 ) ;
  if                ( strlen ( $MSG ) > 0 ) {
    $HD -> AddText  ( $MSG                ) ;
  }                                         ;
  return $HD                                ;
}

public function addOptions($MAPs,$ID="")
{
  $KS    = array_keys         ( $MAPs              ) ;
  foreach                     ( $KS as $ks         ) {
    $HO  = $this -> addOption ( $MAPs [ $ks ]      ) ;
    $HO -> AddPair            ( "value" , $ks      ) ;
    if                        ( strlen ( $ID ) > 0 ) {
      if                      ( $ID == $ks         ) {
        $HO -> AddMember      ( "selected" )         ;
      }                                              ;
    }                                                ;
  }                                                  ;
}

public function addSelection($MAPs,$ID="",$CLASSID="")
{
  $HS  = $this -> addSelect ( $CLASSID    ) ;
  $HS -> addOptions         ( $MAPs , $ID ) ;
  return $HS                                ;
}

public function addButton ( $MSG = "" )
{
  $HD    = new Html (                     ) ;
  $HD   -> setTag   ( "button"            ) ;
  $this -> AddTag   ( $HD                 ) ;
  if                ( strlen ( $MSG ) > 0 ) {
    $HD -> AddText  ( $MSG                ) ;
  }                                         ;
  return $HD                                ;
}

public function addInput($MSG="")
{
  $HI    = new Html (                ) ;
  $HI   -> setInput (                ) ;
  $HI   -> SafePair ( "value" , $MSG ) ;
  $this -> AddTag   ( $HI            ) ;
  return $HI                           ;
}

public function addNameTd($NAME,$WIDTH="20%",$CLASSID="NameLabel")
{
  $HD   = $this -> addTd (                          ) ;
  $HD  -> setSplitter    ( "\n"                     ) ;
  $HD  -> SafePair       ( "width"  , $WIDTH        ) ;
  $HD  -> AddPair        ( "nowrap" , "nowrap"      ) ;
  $DIV  = $HD  -> addDiv ( $NAME    , "" , $CLASSID ) ;
  return $HD                                          ;
}

public function addHtml($TAG="")
{
  $HI    = new Html (                     ) ;
  if                ( strlen ( $TAG ) > 0 ) {
    $HI -> setTag   ( $TAG                ) ;
  }                                         ;
  $this -> AddTag   ( $HI                 ) ;
  return $HI                                ;
}

public function NoWrap()
{
  $this -> AddPair ( "nowrap" , "nowrap" ) ;
}

public function Compact($WIDTH="1%")
{
  $this -> AddPair ( "nowrap" , "nowrap" ) ;
  $this -> AddPair ( "width"  , $WIDTH   ) ;
}

public function addEmptyLine($MSG="&nbsp;",$COLSPAN=1,$KEYID="Empty")
{
  $HR  = $this -> addTr (                      ) ;
  $HD  = $HR   -> addTd ( $MSG                 ) ;
  $HD -> AddPair        ( "colspan" , $COLSPAN ) ;
  $HR -> setObject      ( $KEYID    , $HD      ) ;
  return $HR                                     ;
}

public function Content ( )
{
  switch                   ( $this -> Type            ) {
    case 1                                              :
    return $this -> Inside ( $this -> TagsContent ( ) ) ;
    case 2                                              :
    return $this -> Html        ( ) . $this -> Tail     ;
    case 3                                              :
    return $this -> Tag             . $this -> Tail     ;
    case 4                                              :
    return $this -> TagsContent ( ) . $this -> Tail     ;
  }                                                     ;
  return ""                                             ;
}

public function TextAreaLines ( $TEXT , $LEN = 80 )
{
  $LC   = 0                          ;
  $TS   = explode ( "\n" , $TEXT   ) ;
  foreach         ( $TS as $t      ) {
    $L  = strlen  ( $t             ) ;
    $L  = $L + $LEN - 1              ;
    $L  = intval  ( $L / $LEN , 10 ) ;
    $LC = $LC + $L                   ;
  }                                  ;
  return $LC                         ;
}

public function Report()
{
  echo $this -> Content ( ) ;
  echo "\n"                 ;
}

}

?>
