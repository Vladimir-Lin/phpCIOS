<?php

namespace CIOS ;

class Remit extends Columns
{

public $Id           ;
public $Uuid         ;
public $Used         ;
public $Type         ;
public $States       ;
public $Trade        ;
public $Payer        ;
public $Intermediary ;
public $Inspector    ;
public $Currency     ;
public $Amount       ;
public $Paid         ;
public $Charge       ;
public $Moment       ;
public $Number       ;
public $Confirm      ;
public $Verification ;
public $Remark       ;
public $Reasons      ;
public $Others       ;
public $Update       ;

function __construct()
{
  $this -> Clear ( ) ;
}

function __destruct()
{
}

public function Clear()
{
  $this -> Id           = -1    ;
  $this -> Uuid         =  0    ;
  $this -> Used         =  1    ;
  $this -> Type         =  1    ;
  $this -> States       =  0    ;
  $this -> Trade        =  0    ;
  $this -> Payer        =  0    ;
  $this -> Intermediary =  0    ;
  $this -> Inspector    =  0    ;
  $this -> Currency     =  ""   ;
  $this -> Amount       =  ""   ;
  $this -> Paid         =  0    ;
  $this -> Charge       =  0    ;
  $this -> Moment       =  0    ;
  $this -> Number       =  ""   ;
  $this -> Confirm      =  0    ;
  $this -> Verification =  0    ;
  $this -> Remark       =  ""   ;
  $this -> Reasons      =  ""   ;
  $this -> Others       =  ""   ;
  $this -> Update       =  0    ;
}

public function assign($Item)
{
  $this -> Id           = $Item -> Id           ;
  $this -> Uuid         = $Item -> Uuid         ;
  $this -> Used         = $Item -> Used         ;
  $this -> Type         = $Item -> Type         ;
  $this -> States       = $Item -> States       ;
  $this -> Trade        = $Item -> Trade        ;
  $this -> Payer        = $Item -> Payer        ;
  $this -> Intermediary = $Item -> Intermediary ;
  $this -> Inspector    = $Item -> Inspector    ;
  $this -> Currency     = $Item -> Currency     ;
  $this -> Amount       = $Item -> Amount       ;
  $this -> Paid         = $Item -> Paid         ;
  $this -> Charge       = $Item -> Charge       ;
  $this -> Moment       = $Item -> Moment       ;
  $this -> Number       = $Item -> Number       ;
  $this -> Confirm      = $Item -> Confirm      ;
  $this -> Verification = $Item -> Verification ;
  $this -> Remark       = $Item -> Remark       ;
  $this -> Reasons      = $Item -> Reasons      ;
  $this -> Others       = $Item -> Others       ;
  $this -> Update       = $Item -> Update       ;
}

public function tableItems()
{
  $S = array (                     ) ;
  array_push ( $S , "id"           ) ;
  array_push ( $S , "uuid"         ) ;
  array_push ( $S , "used"         ) ;
  array_push ( $S , "type"         ) ;
  array_push ( $S , "states"       ) ;
  array_push ( $S , "trade"        ) ;
  array_push ( $S , "payer"        ) ;
  array_push ( $S , "intermediary" ) ;
  array_push ( $S , "inspector"    ) ;
  array_push ( $S , "currency"     ) ;
  array_push ( $S , "amount"       ) ;
  array_push ( $S , "paid"         ) ;
  array_push ( $S , "charge"       ) ;
  array_push ( $S , "moment"       ) ;
  array_push ( $S , "number"       ) ;
  array_push ( $S , "confirm"      ) ;
  array_push ( $S , "verification" ) ;
  array_push ( $S , "remark"       ) ;
  array_push ( $S , "reasons"      ) ;
  array_push ( $S , "others"       ) ;
  array_push ( $S , "ltime"        ) ;
  return $S                          ;
}

public function valueItems()
{
  $S = array (                     ) ;
  array_push ( $S , "used"         ) ;
  array_push ( $S , "type"         ) ;
  array_push ( $S , "states"       ) ;
  array_push ( $S , "trade"        ) ;
  array_push ( $S , "payer"        ) ;
  array_push ( $S , "intermediary" ) ;
  array_push ( $S , "inspector"    ) ;
  array_push ( $S , "currency"     ) ;
  array_push ( $S , "amount"       ) ;
  array_push ( $S , "paid"         ) ;
  array_push ( $S , "charge"       ) ;
  array_push ( $S , "moment"       ) ;
  array_push ( $S , "number"       ) ;
  array_push ( $S , "confirm"      ) ;
  array_push ( $S , "verification" ) ;
  array_push ( $S , "remark"       ) ;
  array_push ( $S , "reasons"      ) ;
  array_push ( $S , "others"       ) ;
  return $S                          ;
}

public function set($item,$V)
{
  $a = strtolower ( $item )                              ;
  if ( "id"           == $a ) $this -> Id           = $V ;
  if ( "uuid"         == $a ) $this -> Uuid         = $V ;
  if ( "used"         == $a ) $this -> Used         = $V ;
  if ( "type"         == $a ) $this -> Type         = $V ;
  if ( "states"       == $a ) $this -> States       = $V ;
  if ( "trade"        == $a ) $this -> Trade        = $V ;
  if ( "payer"        == $a ) $this -> Payer        = $V ;
  if ( "intermediary" == $a ) $this -> Intermediary = $V ;
  if ( "inspector"    == $a ) $this -> Inspector    = $V ;
  if ( "currency"     == $a ) $this -> Currency     = $V ;
  if ( "amount"       == $a ) $this -> Amount       = $V ;
  if ( "paid"         == $a ) $this -> Paid         = $V ;
  if ( "charge"       == $a ) $this -> Charge       = $V ;
  if ( "moment"       == $a ) $this -> Moment       = $V ;
  if ( "number"       == $a ) $this -> Number       = $V ;
  if ( "confirm"      == $a ) $this -> Confirm      = $V ;
  if ( "verification" == $a ) $this -> Verification = $V ;
  if ( "remark"       == $a ) $this -> Remark       = $V ;
  if ( "reasons"      == $a ) $this -> Reasons      = $V ;
  if ( "others"       == $a ) $this -> Others       = $V ;
  if ( "ltime"        == $a ) $this -> Update       = $V ;
}

//////////////////////////////////////////////////////////////////////////////

public function get($item)
{
  $a = strtolower ( $item )                                         ;
  if ( "id"           == $a ) return (string) $this -> Id           ;
  if ( "uuid"         == $a ) return (string) $this -> Uuid         ;
  if ( "used"         == $a ) return (string) $this -> Used         ;
  if ( "type"         == $a ) return (string) $this -> Type         ;
  if ( "states"       == $a ) return (string) $this -> States       ;
  if ( "trade"        == $a ) return (string) $this -> Trade        ;
  if ( "payer"        == $a ) return (string) $this -> Payer        ;
  if ( "intermediary" == $a ) return (string) $this -> Intermediary ;
  if ( "inspector"    == $a ) return (string) $this -> Inspector    ;
  if ( "currency"     == $a ) return (string) $this -> Currency     ;
  if ( "amount"       == $a ) return (string) $this -> Amount       ;
  if ( "paid"         == $a ) return (string) $this -> Paid         ;
  if ( "charge"       == $a ) return (string) $this -> Charge       ;
  if ( "moment"       == $a ) return (string) $this -> Moment       ;
  if ( "number"       == $a ) return (string) $this -> Number       ;
  if ( "confirm"      == $a ) return (string) $this -> Confirm      ;
  if ( "verification" == $a ) return (string) $this -> Verification ;
  if ( "remark"       == $a ) return (string) $this -> Remark       ;
  if ( "reasons"      == $a ) return (string) $this -> Reasons      ;
  if ( "others"       == $a ) return (string) $this -> Others       ;
  if ( "ltime"        == $a ) return (string) $this -> Update       ;
  return ""                                                         ;
}

//////////////////////////////////////////////////////////////////////////////

public function Pair($item)
{
  if ( $item == "currency" )                              {
    return "`{$item}` = '" . $this -> get ( $item ) . "'" ;
  }                                                       ;
  if ( $item == "amount" )                                {
    return "`{$item}` = '" . $this -> get ( $item ) . "'" ;
  }                                                       ;
  if ( $item == "number" )                                {
    return "`{$item}` = '" . $this -> get ( $item ) . "'" ;
  }                                                       ;
  return "`{$item}` = " . $this -> get ( $item )          ;
}

//////////////////////////////////////////////////////////////////////////////

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

public function ItemPair($item)
{
  $a = strtolower ( $item )                                 ;
  if ( "id"           == $a )                               {
    return "`{$a}` = " . (string) $this -> Id               ;
  }                                                         ;
  if ( "uuid"         == $a )                               {
    return "`{$a}` = " . (string) $this -> Uuid             ;
  }                                                         ;
  if ( "used"         == $a )                               {
    return "`{$a}` = " . (string) $this -> Used             ;
  }                                                         ;
  if ( "type"         == $a )                               {
    return "`{$a}` = " . (string) $this -> Type             ;
  }                                                         ;
  if ( "states"       == $a )                               {
    return "`{$a}` = " . (string) $this -> States           ;
  }                                                         ;
  if ( "trade"        == $a )                               {
    return "`{$a}` = " . (string) $this -> Trade            ;
  }                                                         ;
  if ( "payer"        == $a )                               {
    return "`{$a}` = " . (string) $this -> Payer            ;
  }                                                         ;
  if ( "intermediary"    == $a )                            {
    return "`{$a}` = " . (string) $this -> Intermediary     ;
  }                                                         ;
  if ( "inspector"    == $a )                               {
    return "`{$a}` = " . (string) $this -> Inspector        ;
  }                                                         ;
  if ( "currency"     == $a )                               {
    return "`{$a}` = '" . (string) $this -> Currency . "'"  ;
  }                                                         ;
  if ( "amount"       == $a )                               {
    return "`{$a}` = '" . (string) $this -> Amount   . "'"  ;
  }                                                         ;
  if ( "paid"         == $a )                               {
    return "`{$a}` = " . (string) $this -> Paid             ;
  }                                                         ;
  if ( "charge"       == $a )                               {
    return "`{$a}` = " . (string) $this -> Charge           ;
  }                                                         ;
  if ( "moment" == $a )                                     {
    return "`{$a}` = " . (string) $this -> Moment           ;
  }                                                         ;
  if ( "number"       == $a )                               {
    return "`{$a}` = '" . (string) $this -> Number  . "'"   ;
  }                                                         ;
  if ( "confirm"      == $a )                               {
    return "`{$a}` = " . (string) $this -> Confirm          ;
  }                                                         ;
  if ( "verification" == $a )                               {
    return "`{$a}` = " . (string) $this -> Verification     ;
  }                                                         ;
  if ( "remark"       == $a )                               {
    return "`{$a}` = '" . (string) $this -> Remark . "'"    ;
  }                                                         ;
  if ( "reasons"      == $a )                               {
    return "`{$a}` = '" . (string) $this -> Reasons . "'"   ;
  }                                                         ;
  if ( "others"       == $a )                               {
    return "`{$a}` = '" . (string) $this -> Others . "'"    ;
  }                                                         ;
  if ( "ltime"        == $a )                               {
    return "`{$a}` = " . (string) $this -> Update           ;
  }                                                         ;
  return ""                                                 ;
}

//////////////////////////////////////////////////////////////////////////////

public function toString()
{
  return sprintf ( "rmts%08d" , gmp_mod ( $this -> Uuid , 100000000 ) ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function fromString ( $ID )
{
  $this -> Uuid = str_replace ( "rmts" , "79000000000" , $ID ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function toLongString ( $TZ , $ITEM , $DATE = "Y/m/d" , $TIME = "H:i:s" )
{
  ////////////////////////////////////////////////////////////////////////////
  $SDT         = new StarDate            (                                 ) ;
  $SDT        -> Stardate = $this -> get ( $ITEM                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $SDT -> toLongString            ( $TZ , $DATE , $TIME             ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function obtain($R)
{
  $this -> Id           = $R [ "id"           ] ;
  $this -> Uuid         = $R [ "uuid"         ] ;
  $this -> Used         = $R [ "used"         ] ;
  $this -> Type         = $R [ "type"         ] ;
  $this -> States       = $R [ "states"       ] ;
  $this -> Trade        = $R [ "trade"        ] ;
  $this -> Payer        = $R [ "payer"        ] ;
  $this -> Intermediary = $R [ "intermediary" ] ;
  $this -> Inspector    = $R [ "inspector"    ] ;
  $this -> Currency     = $R [ "currency"     ] ;
  $this -> Amount       = $R [ "amount"       ] ;
  $this -> Paid         = $R [ "paid"         ] ;
  $this -> Charge       = $R [ "charge"       ] ;
  $this -> Moment       = $R [ "moment"       ] ;
  $this -> Number       = $R [ "number"       ] ;
  $this -> Confirm      = $R [ "confirm"      ] ;
  $this -> Verification = $R [ "verification" ] ;
  $this -> Remark       = $R [ "remark"       ] ;
  $this -> Reasons      = $R [ "reasons"      ] ;
  $this -> Others       = $R [ "others"       ] ;
  $this -> Update       = $R [ "ltime"        ] ;
}

//////////////////////////////////////////////////////////////////////////////

public function GetUuid ( $DB , $Table , $Main )
{
  global $DataTypes                                          ;
  $BASE         = "7900000000000000000"                      ;
  $RI           = new Relation ( )                           ;
  $TYPE         = $RI -> Types [ "Remittance" ]              ;
  $this -> Uuid = $DB -> GetLast ( $Table , "uuid" , $BASE ) ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) <= 0 ) return false   ;
  $DB -> AddUuid ( $Main , $this -> Uuid , $TYPE )           ;
  return $this -> Uuid                                       ;
}

//////////////////////////////////////////////////////////////////////////////

public function UpdateItems($DB,$TABLE,$ITEMS)
{
  $QQ    = "update " . $TABLE . " set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )                ;
  return $DB -> Query ( $QQ )                                       ;
}

//////////////////////////////////////////////////////////////////////////////

public function UpdateFresh   ( $DB , $TABLE      )
{
  $S = array                  (                     ) ;
  array_push                  ( $S , "used"         ) ;
  array_push                  ( $S , "type"         ) ;
  array_push                  ( $S , "states"       ) ;
  array_push                  ( $S , "trade"        ) ;
  array_push                  ( $S , "payer"        ) ;
  array_push                  ( $S , "inspector"    ) ;
  array_push                  ( $S , "intermediary" ) ;
  array_push                  ( $S , "currency"     ) ;
  array_push                  ( $S , "amount"       ) ;
  array_push                  ( $S , "paid"         ) ;
  array_push                  ( $S , "moment"       ) ;
  array_push                  ( $S , "number"       ) ;
  array_push                  ( $S , "confirm"      ) ;
  array_push                  ( $S , "verification" ) ;
  return $this -> UpdateItems ( $DB , $TABLE , $S   ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function UpdateString ( $DB , $TABLE , $ITEM )
{
  ////////////////////////////////////////////////////////////////////////////
  $VALUE = $this -> get     ( $ITEM                                        ) ;
  $QQ    = "update {$TABLE} set `{$ITEM}` = ?"                               .
           $DB -> WhereUuid ( $this -> Uuid , true )                         ;
  $qq    = $DB   -> Prepare ( $QQ                                          ) ;
  $qq   -> bind_param       ( 's' , $VALUE                                 ) ;
  $qq   -> execute          (                                              ) ;
  ////////////////////////////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////

public function Update ( $DB , $TABLE )
{
  $ITEMS = $this -> valueItems ( )                            ;
  $QQ    = "update {$TABLE} set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )          ;
  unset ( $ITEMS )                                            ;
  return $DB -> Query ( $QQ )                                 ;
}

//////////////////////////////////////////////////////////////////////////////

public function ObtainsByUuid ( $DB , $TABLE )
{
  $QQ = "select " . $this -> Items ( ) . " from " . $TABLE .
        $DB -> WhereUuid ( $this -> Uuid , true )          ;
  $qq = $DB -> Query ( $QQ )                               ;
  if ( $DB -> hasResult ( $qq ) )                          {
    $rr = $qq -> fetch_array ( MYSQLI_BOTH )               ;
    $this     -> obtain      ( $rr         )               ;
    return true                                            ;
  }                                                        ;
  return false                                             ;
}

//////////////////////////////////////////////////////////////////////////////

public function JoinTrade ( $DB , $RELATION , $TradeUuid )
{
  $RI  = new Relation (                          ) ;
  $RI -> set          ( "first"  , $TradeUuid    ) ;
  $RI -> set          ( "second" , $this -> Uuid ) ;
  $RI -> setT1        ( "Trade"                  ) ;
  $RI -> setT2        ( "Remittance"             ) ;
  $RI -> setRelation  ( "Subordination"          ) ;
  $RI -> Join         ( $DB      , $RELATION     ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function TradeMembers ( $DB , $RELATION , $TradeUuid )
{
  $RI  = new Relation         (                       ) ;
  $RI -> set                  ( "first"  , $TradeUuid ) ;
  $RI -> setT1                ( "Trade"               ) ;
  $RI -> setT2                ( "Remittance"          ) ;
  $RI -> setRelation          ( "Subordination"       ) ;
  return $RI -> Subordination ( $DB , $RELATION       ) ;
}
//////////////////////////////////////////////////////////////////////////////

public function RemitPictures ( $DB , $RELATION )
{
  $RI  = new Relation         (                          ) ;
  $RI -> set                  ( "first"  , $this -> Uuid ) ;
  $RI -> setT1                ( "Remittance"             ) ;
  $RI -> setT2                ( "Picture"                ) ;
  $RI -> setRelation          ( "Subordination"          ) ;
  return $RI -> Subordination ( $DB , $RELATION          ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function JoinPicture ( $DB , $RELATION , $PictureUuid )
{
  $RI  = new Relation (                          ) ;
  $RI -> set          ( "first"  , $this -> Uuid ) ;
  $RI -> set          ( "second" , $PictureUuid  ) ;
  $RI -> setT1        ( "Remittance"             ) ;
  $RI -> setT2        ( "Picture"                ) ;
  $RI -> setRelation  ( "Subordination"          ) ;
  $RI -> Join         ( $DB      , $RELATION     ) ;
}

//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
