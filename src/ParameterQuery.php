<?php

namespace CIOS ;

class ParameterQuery
{

public $Type    ;
public $Variety ;
public $Scope   ;
public $Table   ;

function __construct ( )
{
  $this -> clear ( )  ;
}

function __destruct()
{
}

public function clear ( )
{
  $TABLE = ""                                         ;
  if ( isset ( $GLOBALS [ "TableMapping" ] ) )        {
    $TableMapping  = $GLOBALS      [ "TableMapping" ] ;
    $TABLE         = $TableMapping [ "Parameters"   ] ;
  }                                                   ;
  /////////////////////////////////////////////////////
  $this -> Type    = 0                                ;
  $this -> Variety = 0                                ;
  $this -> Scope   = ""                               ;
  $this -> Table   = $TABLE                           ;
}

public function setType ( $T )
{
  $this -> Type    = $T ;
}

public function setVariety ( $V )
{
  $this -> Variety = $V ;
}

public function setScope ( $S )
{
  $this -> Scope   = $S ;
}

public function setTable ( $T )
{
  $this -> Table   = $T ;
}

public function Where ( $Uuid , $Name )
{
  return "where "                                      .
            "`uuid` = "  . (string) $Uuid   .  " and " .
            "`type` = "  . $this -> Type    .  " and " .
         "`variety` = "  . $this -> Variety .  " and " .
           "`scope` = '" . $this -> Scope   . "' and " .
            "`name` = '" . $Name            . "'"      ;
}

public function SelectItem ( $Item , $Uuid , $Name )
{
  return "select `" . $Item . "` from " . $this -> Table . " " .
         $this -> Where ( $Uuid , $Name ) . " ;"               ;
}

public function UpdateItem ( $Item , $Uuid , $Name )
{
  return "update " . $this -> Table . " set `" . $Item . "` = ? " .
         $this -> Where ( $Uuid , $Name ) . " ;"                  ;
}

public function UpdateId ( $Id , $Item , $Value )
{
  return "update " . $this -> Table . " set `" . $Item . "` = " . $Value .
         " where `id` = " . (string) $Id . " ;"                          ;
}

public function Fetch ( $DB , $Item , $Uuid , $Name )
{
  $QQ   = $this -> SelectItem ( $Item , $Uuid , $Name ) ;
  $qq   = $DB   -> Query      ( $QQ                   ) ;
  $VV   = ""                                            ;
  if ( ! $DB -> hasResult ( $qq ) ) return $VV          ;
  if ( $rr = $qq -> fetch_array  ( MYSQLI_BOTH ) )      {
    $VV = $rr [ 0 ]                                     ;
  }                                                     ;
  return $VV                                            ;
}

public function Value ( $DB , $Uuid , $Name )
{
  $A = $this -> Fetch ( $DB , "value" , $Uuid , $Name ) ;
  if ( strlen ( $A ) <= 0 ) return 0                    ;
  return $A                                             ;
}

public function Floating ( $DB , $Uuid , $Name )
{
  $A = $this -> Fetch ( $DB , "floating" , $Uuid , $Name ) ;
  if ( strlen ( $A ) <= 0 ) return 0                       ;
  return $A                                                ;
}

public function Data ( $DB , $Uuid , $Name )
{
  return $this -> Fetch ( $DB , "data" , $Uuid , $Name ) ;
}

public function ObtainsId ( $DB , $Uuid , $Name )
{
  return $this -> Fetch ( $DB , "id" , $Uuid , $Name ) ;
}

public function InsertIntoValue ( $DB , $Uuid , $Name , $Value )
{
  return "insert into " . $this -> Table                              .
         " (`uuid`,`type`,`variety`,`scope`,`name`,`value`) values (" .
         (string) $Uuid                                         . "," .
         (string) $this -> Type                                 . "," .
         (string) $this -> Variety                              . "," .
         "'" . (string) $this -> Scope                         . "'," .
         "'" . (string) $Name                                  . "'," .
         (string) $Value                                      . ") ;" ;
}

public function InsertIntoFloating ( $DB , $Uuid , $Name , $Floating )
{
  return "insert into " . $this -> Table                                 .
         " (`uuid`,`type`,`variety`,`scope`,`name`,`floating`) values (" .
         (string) $Uuid                                            . "," .
         (string) $this -> Type                                    . "," .
         (string) $this -> Variety                                 . "," .
         "'" . (string) $this -> Scope                            . "'," .
         "'" . (string) $Name                                     . "'," .
         (string) $Floating                                      . ") ;" ;
}

public function InsertIntoData ( $DB , $Uuid , $Name )
{
  return "insert into " . $this -> Table                             .
         " (`uuid`,`type`,`variety`,`scope`,`name`,`data`) values (" .
         (string) $Uuid                                        . "," .
         (string) $this -> Type                                . "," .
         (string) $this -> Variety                             . "," .
         "'" . (string) $this -> Scope                        . "'," .
         "'" . (string) $Name                             . "',?) ;" ;
}

public function assureValue ( $DB , $Uuid , $Name , $Value )
{
  $Id = $this -> ObtainsId ( $DB , $Uuid , $Name )                  ;
  $QQ = ""                                                          ;
  if ( $Id <= 0 )                                                   {
    $QQ = $this -> InsertIntoValue ( $DB , $Uuid , $Name , $Value ) ;
  } else                                                            {
    $QQ = $this -> UpdateId        ( $Id , "value"       , $Value ) ;
  }                                                                 ;
  return $DB -> Query ( $QQ )                                       ;
}

public function assureData ( $DB , $Uuid , $Name , $BLOB )
{
  $Id = $this -> ObtainsId        ( $DB , $Uuid , $Name ) ;
  $QQ = ""                                                ;
  if ( $Id <= 0 )                                         {
    $QQ = $this -> InsertIntoData ( $DB , $Uuid , $Name ) ;
  } else                                                  {
    $QQ = $this -> UpdateId       ( $Id , "data" , "?"  ) ;
  }                                                       ;
  /////////////////////////////////////////////////////////
  $qq  = $DB -> Prepare           ( $QQ                 ) ;
  $qq        -> bind_param        ( 's' , $BLOB         ) ;
  $rt  = $qq -> execute           (                     ) ;
  $qq        -> close             (                     ) ;
  /////////////////////////////////////////////////////////
  return $rt                                              ;
}

public static function NewParameter ( $T , $V , $S )
{
  $PQ  = new ParameterQuery (    ) ;
  $PQ -> setType            ( $T ) ;
  $PQ -> setVariety         ( $V ) ;
  $PQ -> setScope           ( $S ) ;
  return $PQ                       ;
}

public static function GetParameterData ( $DB , $PUID , $Item , $T , $V , $S )
{
  /////////////////////////////////////////////////////
  $TABLE = "`erp`.`parameters`"                       ;
  if ( isset ( $GLOBALS [ "TableMapping" ] ) )        {
    $TableMapping  = $GLOBALS      [ "TableMapping" ] ;
    $TABLE         = $TableMapping [ "Parameters"   ] ;
  }                                                   ;
  /////////////////////////////////////////////////////
  $PQ  = self::NewParameter ( $T  , $V    , $S      ) ;
  $PQ -> setTable           ( $TABLE                ) ;
  $DT  = $PQ -> Data        ( $DB , $PUID , $Item   ) ;
  unset                     ( $PQ                   ) ;
  /////////////////////////////////////////////////////
  return $DT                                          ;
}

public static function GetParameter ( $DB , $PUID , $Item , $T , $V , $S )
{
  /////////////////////////////////////////////////////
  $TABLE = "`erp`.`parameters`"                       ;
  if ( isset ( $GLOBALS [ "TableMapping" ] ) )        {
    $TableMapping  = $GLOBALS      [ "TableMapping" ] ;
    $TABLE         = $TableMapping [ "Parameters"   ] ;
  }                                                   ;
  /////////////////////////////////////////////////////
  $PQ  = self::NewParameter ( $T  , $V    , $S      ) ;
  $PQ -> setTable           ( $TABLE                ) ;
  $DT  = $PQ -> Value       ( $DB , $PUID , $Item   ) ;
  unset                     ( $PQ                   ) ;
  /////////////////////////////////////////////////////
  return $DT                                          ;
}

public static function GetParameterDateTime ( $DB , $PUID , $Item )
{
  return self::GetParameter ( $DB , $PUID , $Item , 3 , 12 , "DateTime" ) ;
}

public static function GetParameterStatus ( $DB , $PUID , $Item )
{
  return self::GetParameter ( $DB , $PUID , $Item , 0 , 23 , "Status" ) ;
}

public static function GetParameterPersonal ( $DB , $PUID , $Item )
{
  return self::GetParameter ( $DB , $PUID , $Item , 0 , 48 , "Personal" ) ;
}

}

?>
