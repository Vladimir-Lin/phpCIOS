<?php

namespace CIOS ;

class Events
{

public $LINES = [ ] ;

function __construct()
{
}

function __destruct()
{
}

public function Pair ( $KEY , $VALUE )
{
  return "\"{$KEY}\": {$VALUE}" ;
}

public function DqPair ( $KEY , $VALUE )
{
  $VALUE = str_replace ( "\\" , "\\\\" , $VALUE ) ;
  $VALUE = str_replace ( "\"" , "\\\"" , $VALUE ) ;
  $VALUE = str_replace ( "\n" , "\\n"  , $VALUE ) ;
  $VALUE = str_replace ( "\t" , "\\t"  , $VALUE ) ;
  return "\"{$KEY}\": \"{$VALUE}\""               ;
}

public function AddPair ( $KEY , $VALUE )
{
  array_push ( $this -> LINES , $this -> Pair ( $KEY , $VALUE ) ) ;
}

public function AddDqPair ( $KEY , $VALUE )
{
  array_push ( $this -> LINES , $this -> DqPair ( $KEY , $VALUE ) ) ;
}

public function Title ( $TITLE )
{
  if ( strlen ( $TITLE ) <= 0 ) return    ;
  $this -> AddDqPair ( "title" , $TITLE ) ;
}

public function Id ( $ID )
{
  if ( strlen ( $ID ) <= 0 ) return ;
  $this -> AddDqPair ( "id" , $ID ) ;
}

public function Group ( $ID )
{
  if ( strlen ( $ID ) <= 0 ) return      ;
  $this -> AddDqPair ( "groupId" , $ID ) ;
}

public function URL ( $U )
{
  if ( strlen ( $U ) <= 0 ) return  ;
  $this -> AddDqPair ( "url" , $U ) ;
}

public function Classes ( $NAMES )
{
  if ( count ( $NAMES ) <= 0 ) return     ;
  $NS = array ( )                         ;
  foreach ( $NAMES as $N )                {
    array_push ( $NS , "\"{$N}\"" )       ;
  }                                       ;
  $NV = implode ( " , " , $NS )           ;
  $NV = "[ {$NV} ]"                       ;
  $this -> AddPair ( "classNames" , $NV ) ;
}

public function AllDay ( $ALL )
{
  $ES = "false"                       ;
  if ( $ALL ) $ES = "true"            ;
  $this -> AddPair ( "allDay" , $ES ) ;
}

public function Editable ( $EDIT )
{
  $ES = "false"                         ;
  if ( $EDIT ) $ES = "true"             ;
  $this -> AddPair ( "editable" , $ES ) ;
}

public function TextColor ( $COLOR )
{
  if ( strlen ( $COLOR ) <= 0 ) return        ;
  $this -> AddDqPair ( "textColor" , $COLOR ) ;
}

public function BorderColor ( $COLOR )
{
  if ( strlen ( $COLOR ) <= 0 ) return          ;
  $this -> AddDqPair ( "borderColor" , $COLOR ) ;
}

public function Background ( $COLOR )
{
  if ( strlen ( $COLOR ) <= 0 ) return              ;
  $this -> AddDqPair ( "backgroundColor" , $COLOR ) ;
}

public function TimeField ( $TZ , $FIELD , $PERIOD )
{
  $TSTR  = $PERIOD -> toTimeString ( $TZ     , $FIELD ) ;
  $this -> AddDqPair               ( $FIELD  , $TSTR  ) ;
}

public function TimeFields ( $TZ , $PERIOD )
{
  $this -> TimeField ( $TZ , "start" , $PERIOD ) ;
  $this -> TimeField ( $TZ , "end"   , $PERIOD ) ;
}

public function Content ( )
{
  $ITEMS = implode ( " ,\n" , $this -> LINES ) ;
  return "{\n{$ITEMS}\n}"                      ;
}

public static function GetPublicEventsByType ( $DB , $TABLE , $PERIOD , $TYPE )
{
  ////////////////////////////////////////////////////////////////////////////
  $START = $PERIOD -> Start                                                  ;
  $ENDST = $PERIOD -> End                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `uuid` from {$TABLE}"                                     .
           " where ( `used` = 1 )"                                           .
             " and ( `type` = {$TYPE} )"                                     .
           " and ( `start` >= {$START} )"                                    .
             " and ( `end` <= {$ENDST} )"                                    .
           " order by `start` asc ;"                                         ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> ObtainUuids ( $QQ )                                          ;
}

public static function ObtainsPeriods ( $DB , $TABLE , $VACATIONS )
{
  $PERIODs = array         (                    ) ;
  foreach                  ( $VACATIONS as $vac ) {
    $PRX   = new Periode   (                    ) ;
    $PRX  -> set           ( "Uuid"   , $vac    ) ;
    $PRX  -> ObtainsByUuid ( $DB      , $TABLE  ) ;
    array_push             ( $PERIODs , $PRX    ) ;
  }                                               ;
  return $PERIODs                                 ;
}

public static function PublicEventItem ( $DB , $NAMTAB , $PEOPLE , $PERIOD , $COLOR , $CLASSES )
{
  ////////////////////////////////////////////////////////////////////////////
  $PUID  = $PERIOD -> Uuid                                                   ;
  $LANG  = $PEOPLE -> Language                                               ;
  $TZ    = $PEOPLE -> TZ                                                     ;
  $E     = new Events            (                                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  $TIDS  = $PERIOD -> TypeString (                                         ) ;
  $PNAM  = $DB     -> Naming     ( $NAMTAB , $PUID , $LANG , "Default"     ) ;
  $TIDS  = "{$TIDS}\n{$PNAM}"                                                ;
  ////////////////////////////////////////////////////////////////////////////
  $E    -> Title                 ( $TIDS                                   ) ;
  $E    -> Id                    ( $PUID                                   ) ;
  $E    -> TimeFields            ( $TZ , $PERIOD                           ) ;
  $E    -> TextColor             ( $COLOR                                  ) ;
  $E    -> Editable              ( false                                   ) ;
  $E    -> AllDay                ( false                                   ) ;
  $E    -> Classes               ( $CLASSES                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $E    -> AddPair               ( "type" , $PERIOD -> Type                ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $E -> Content           (                                         ) ;
}

public static function VacationEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD )
{
  return self::PublicEventItem ( $DB               ,
                                 $NAMTAB           ,
                                 $PEOPLE           ,
                                 $PERIOD           ,
                                 "#FA8072"         ,
                                 [ "Vacations" ] ) ;
}

public static function SpecialDayEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD )
{
  return self::PublicEventItem ( $DB                 ,
                                 $NAMTAB             ,
                                 $PEOPLE             ,
                                 $PERIOD             ,
                                 "#FFEFD5"           ,
                                 [ "SpecialDays" ] ) ;
}

public static function SolarTermEvent ( $DB , $NAMTAB , $PEOPLE , $PERIOD )
{
  return self::PublicEventItem ( $DB               ,
                                 $NAMTAB           ,
                                 $PEOPLE           ,
                                 $PERIOD           ,
                                 "#77FF77"         ,
                                 [ "SolarTerm" ] ) ;
}

public static function PublicEventsByType ( $DB , $PEOPLE , $PERIOD , $TYPE , $PRDTAB , $NAMTAB , $FUNC )
{
  $EVENTS = array                       (                                  ) ;
  $UU     = self::GetPublicEventsByType ( $DB , $PRDTAB , $PERIOD , $TYPE  ) ;
  if                                    ( count ( $UU ) > 0                ) {
    $PRDs = self::ObtainsPeriods        ( $DB , $PRDTAB , $UU              ) ;
    foreach                             ( $PRDs as $P                      ) {
      $E  = $FUNC                       ( $DB , $NAMTAB , $PEOPLE , $P     ) ;
      array_push                        ( $EVENTS , $E                     ) ;
    }                                                                        ;
  }                                                                          ;
  return $EVENTS                                                             ;
}

}

?>
