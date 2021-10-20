<?php
//////////////////////////////////////////////////////////////////////////////
namespace CIOS ;
//////////////////////////////////////////////////////////////////////////////
class JsHandler
{
//////////////////////////////////////////////////////////////////////////////
public $Type     ;
public $Tag      ;
public $Before   ;
public $After    ;
public $Splitter ;
public $Content  ;
public $Children ;
//////////////////////////////////////////////////////////////////////////////
function __construct()
{
  $this -> Clear ( ) ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct()
{
}
//////////////////////////////////////////////////////////////////////////////
public function Clear()
{
  $this -> Type     = 0         ;
  $this -> Tag      = ""        ;
  $this -> Splitter = "\n"      ;
  $this -> Content  = ""        ;
  $this -> Children = array ( ) ;
}

//  0 - Nothingness
//  1 - Content
//  2 - Children
//  3 - round  bracket , ( ... ) , with Children, no Content
//  4 - curly  bracket , { ... } , with Children, no Content
//  5 - square bracket , [ ... ] , with Children, no Content
//  6 - Tag, (var,let,const) , var name = value
//  7 - call function FuncName ( ... ) , FuncName => Tag , Content => ( ... )
//  8 -
//  9 -
// 10 -
public function setType($TYPE)
{
  $this -> Type = $TYPE                     ;
  switch ( $this -> Type )                  {
    case 2                                  :
      $this -> Splitter = "\n"              ;
    break                                   ;
    case 3                                  :
      $this -> Splitter = " "               ;
      $this -> setBracket ( "( "  , " )"  ) ;
    break                                   ;
    case 4                                  :
      $this -> Splitter = "\n"              ;
      $this -> setBracket ( "{\n" , "\n}" ) ;
    break                                   ;
    case 5                                  :
      $this -> Splitter = ",\n"             ;
      $this -> setBracket ( "["   , "]"   ) ;
    break                                   ;
  }
}
//////////////////////////////////////////////////////////////////////////////
public function setBracket($BEFORE,$AFTER)
{
  $this -> Before = $BEFORE ;
  $this -> After  = $AFTER  ;
}
//////////////////////////////////////////////////////////////////////////////
public function setSplitter($SPLITTER="\n")
{
  $this -> Splitter = $SPLITTER ;
}
//////////////////////////////////////////////////////////////////////////////
public function setTag($PREFIX,$NAME,$VALUE="")
{
  $this -> Type = 6                   ;
  $this -> Tag  = $PREFIX             ;
  $this -> setPair ( $NAME , $VALUE ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function setPair($NAME,$VALUE)
{
  $SSS = $NAME                          ;
  if ( strlen ( $VALUE ) > 0 )          {
    $SSS = $SSS . " = " . $VALUE . " ;" ;
  }                                     ;
  $this -> setContent ( $SSS )          ;
}
//////////////////////////////////////////////////////////////////////////////
public function setMap($NAME,$VALUE)
{
  $SSS = $NAME                  ;
  if ( strlen ( $VALUE ) > 0 )  {
    $SSS = $SSS . ": " . $VALUE ;
  }                             ;
  $this -> setContent ( $SSS )  ;
}
//////////////////////////////////////////////////////////////////////////////
public function setContent($Content)
{
  $this -> Content = $Content ;
}
//////////////////////////////////////////////////////////////////////////////
public function CallFunction($TAG,$PARAMENTS)
{
  $this -> Type = 7                          ;
  ////////////////////////////////////////////
  $JHC   = new jsHandler (            )      ;
  $JHC  -> setType       ( 1          )      ;
  $JHC  -> setContent    ( $PARAMENTS )      ;
  ////////////////////////////////////////////
  $JHR   = new jsHandler (            )      ;
  $JHR  -> setType       ( 3          )      ;
  $JHR  -> AddChild      ( $JHC       )      ;
  ////////////////////////////////////////////
  $this -> Content = $JHR  -> JavaScript ( ) ;
  $this -> Tag     = $TAG                    ;
}
//////////////////////////////////////////////////////////////////////////////
public function AddChild($T)
{
  array_push ( $this -> Children , $T ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function DoubleQuote($T)
{
  return "\"" . $T . "\"" ;
}
//////////////////////////////////////////////////////////////////////////////
public function SingleQuote($T)
{
  return "'" . $T . "'" ;
}
//////////////////////////////////////////////////////////////////////////////
public function DQ($T)
{
  return DoubleQuote ( $T ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function SQ($T)
{
  return SingleQuote ( $T ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function NewLine()
{
  return "\n" ;
}
//////////////////////////////////////////////////////////////////////////////
public function JsonValue($NAME,$VALUE)
{
  $JAV   = new jsHandler (                ) ;
  $JAV  -> setType       ( 1              ) ;
  $JAV  -> setMap        ( $NAME , $VALUE ) ;
  $this -> AddChild      ( $JAV           ) ;
  return $JAV                               ;
}
//////////////////////////////////////////////////////////////////////////////
public function JsonSqString($NAME,$VALUE)
{
  $JAV   = new jsHandler (                                         ) ;
  $JAV  -> setType       ( 1                                       ) ;
  $JAV  -> setMap        ( $NAME , $this -> SingleQuote ( $VALUE ) ) ;
  $this -> AddChild      ( $JAV                                    ) ;
  return $JAV                                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function JsonDqString($NAME,$VALUE)
{
  $JAV   = new jsHandler (                                         ) ;
  $JAV  -> setType       ( 1                                       ) ;
  $JAV  -> setMap        ( $NAME , $this -> DoubleQuote ( $VALUE ) ) ;
  $this -> AddChild      ( $JAV                                    ) ;
  return $JAV                                                        ;
}
//////////////////////////////////////////////////////////////////////////////
public function Inners()
{
  if ( count ( $this -> Children ) <= 0 ) return "" ;
  $A = array   (                           )        ;
  foreach      ( $this -> Children as $T   )        {
    array_push ( $A , $T -> JavaScript ( ) )        ;
  }                                                 ;
  $L = implode ( $this -> Splitter , $A    )        ;
  return $L                                         ;
}
//////////////////////////////////////////////////////////////////////////////
public function Bracket()
{
  return $this -> Before . $this -> Inners ( ) . $this -> After ;
}
//////////////////////////////////////////////////////////////////////////////
public function TagStructure()
{
  return $this -> Tag . " " . $this -> Content ;
}
//////////////////////////////////////////////////////////////////////////////
public function FunctionCall()
{
  return $this -> TagStructure ( ) . " ;" ;
}
//////////////////////////////////////////////////////////////////////////////
public function JavaScript()
{
  switch ( $this -> Type )           {
    case 1                           :
    return $this -> Content          ;
    case 2                           :
    return $this -> Inners       ( ) ;
    case 3                           :
    case 4                           :
    case 5                           :
    return $this -> Bracket      ( ) ;
    case 6                           :
    return $this -> TagStructure ( ) ;
    case 7                           :
    return $this -> FunctionCall ( ) ;
  }                                  ;
  return ""                          ;
}
//////////////////////////////////////////////////////////////////////////////
public function Report ()
{
  echo $this -> JavaScript ( ) ;
  echo "\n"                    ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
