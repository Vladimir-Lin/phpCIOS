<?php

namespace CIOS ;

class Trade extends Columns
{

public $Id          ;
public $Uuid        ;
public $Payer       ;
public $PayerBank   ;
public $Payee       ;
public $PayeeBank   ;
public $Currency    ;
public $Amount      ;
public $States      ;
public $Item        ;
public $Description ;
public $Record      ;
public $Update      ;

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
  $this -> Id          = -1    ;
  $this -> Uuid        =  0    ;
  $this -> Payer       =  0    ;
  $this -> PayerBank   =  0    ;
  $this -> Payee       =  0    ;
  $this -> PayeeBank   =  0    ;
  $this -> Currency    = "TWD" ;
  $this -> Amount      =  0    ;
  $this -> States      =  0    ;
  $this -> Item        =  0    ;
  $this -> Description =  0    ;
  $this -> Record      =  0    ;
  $this -> Update      =  0    ;
}

//////////////////////////////////////////////////////////////////////////////

public function tableItems()
{
  $S = array (                    ) ;
  array_push ( $S , "id"          ) ;
  array_push ( $S , "uuid"        ) ;
  array_push ( $S , "payer"       ) ;
  array_push ( $S , "payerbank"   ) ;
  array_push ( $S , "payee"       ) ;
  array_push ( $S , "payeebank"   ) ;
  array_push ( $S , "currency"    ) ;
  array_push ( $S , "amount"      ) ;
  array_push ( $S , "states"      ) ;
  array_push ( $S , "item"        ) ;
  array_push ( $S , "description" ) ;
  array_push ( $S , "record"      ) ;
  array_push ( $S , "ltime"       ) ;
  return $S                         ;
}

//////////////////////////////////////////////////////////////////////////////

public function JoinItems($X,$S)
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

//////////////////////////////////////////////////////////////////////////////

public function Items( $S = "," )
{
  $X = $this -> tableItems (         ) ;
  $L = $this -> JoinItems  ( $X , $S ) ;
  unset                    ( $X      ) ;
  return $L                            ;
}

//////////////////////////////////////////////////////////////////////////////

public function valueItems()
{
  $S = array (                    ) ;
  array_push ( $S , "payer"       ) ;
  array_push ( $S , "payerbank"   ) ;
  array_push ( $S , "payee"       ) ;
  array_push ( $S , "payeebank"   ) ;
  array_push ( $S , "currency"    ) ;
  array_push ( $S , "amount"      ) ;
  array_push ( $S , "states"      ) ;
  array_push ( $S , "item"        ) ;
  array_push ( $S , "description" ) ;
  array_push ( $S , "record"      ) ;
  return $S                         ;
}

//////////////////////////////////////////////////////////////////////////////

public function set($item,$V)
{
  $a = strtolower ( $item )                             ;
  if ( "id"          == $a ) $this -> Id           = $V ;
  if ( "uuid"        == $a ) $this -> Uuid         = $V ;
  if ( "payer"       == $a ) $this -> Payer        = $V ;
  if ( "payerbank"   == $a ) $this -> PayerBank    = $V ;
  if ( "payee"       == $a ) $this -> Payee        = $V ;
  if ( "payeebank"   == $a ) $this -> PayeeBank    = $V ;
  if ( "currency"    == $a ) $this -> Currency     = $V ;
  if ( "amount"      == $a ) $this -> Amount       = $V ;
  if ( "states"      == $a ) $this -> States       = $V ;
  if ( "item"        == $a ) $this -> Item         = $V ;
  if ( "description" == $a ) $this -> Description  = $V ;
  if ( "record"      == $a ) $this -> Record       = $V ;
  if ( "ltime"       == $a ) $this -> Update       = $V ;
}

//////////////////////////////////////////////////////////////////////////////

public function get($item)
{
  $a = strtolower ( $item )                                        ;
  if ( "id"          == $a ) return (string) $this -> Id           ;
  if ( "uuid"        == $a ) return (string) $this -> Uuid         ;
  if ( "payer"       == $a ) return (string) $this -> Payer        ;
  if ( "payerbank"   == $a ) return (string) $this -> PayerBank    ;
  if ( "payee"       == $a ) return (string) $this -> Payee        ;
  if ( "payeebank"   == $a ) return (string) $this -> PayeeBank    ;
  if ( "currency"    == $a ) return (string) $this -> Currency     ;
  if ( "amount"      == $a ) return (string) $this -> Amount       ;
  if ( "states"      == $a ) return (string) $this -> States       ;
  if ( "item"        == $a ) return (string) $this -> Item         ;
  if ( "description" == $a ) return (string) $this -> Description  ;
  if ( "record"      == $a ) return (string) $this -> Record       ;
  if ( "ltime"       == $a ) return (string) $this -> Update       ;
  return ""                                                        ;
}

//////////////////////////////////////////////////////////////////////////////

public function Pair($item)
{
  if ( $item == "currency" )                              {
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

//////////////////////////////////////////////////////////////////////////////

public function isToken()
{
  $des = $this -> Description                          ;
  if ( gmp_cmp ( $des , "0"      ) == 0 ) return false ;
  $duidmin = "3400000000000000000"                     ;
  $duidmax = "3400000001000000000"                     ;
  if ( gmp_cmp ( $des , $duidmin )  < 0 ) return false ;
  if ( gmp_cmp ( $des , $duidmax )  > 0 ) return false ;
  return true                                          ;
}

public function isClass()
{
  $des = $this -> Description                          ;
  if ( gmp_cmp ( $des , "0"      ) == 0 ) return false ;
  $duidmin = "3600000000000000000"                     ;
  $duidmax = "3600000001000000000"                     ;
  if ( gmp_cmp ( $des , $duidmin )  < 0 ) return false ;
  if ( gmp_cmp ( $des , $duidmax )  > 0 ) return false ;
  return true                                          ;
}

//////////////////////////////////////////////////////////////////////////////

public function IdString()
{
  $HH = new Parameters     (               ) ;
  $ID = $HH -> TradeString ( $this -> Uuid ) ;
  unset                    ( $HH           ) ;
  return $ID                                 ;
}

public function setId($ID)
{
  $HH           = new Parameters (     ) ;
  $this -> Uuid = $HH -> TradeID ( $ID ) ;
  unset ( $HH )                          ;
  return $this -> Uuid                   ;
}

//////////////////////////////////////////////////////////////////////////////

public function Money()
{
  return number_format ( $this -> Amount , 0 , "" , "," ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function setMoney($amount)
{
  $A = (string) str_replace ( "," , "" , $amount ) ;
  $this -> Amount = intval ( $A , 10 )             ;
  return $this -> Amount                           ;
}

public function GetMoney ( $SPLITTER = " " )
{
  return $this -> Money ( ) . $SPLITTER . $this -> Currency ;
}

public function Payment($PUID)
{
  global $Translations                           ;
  $WAY = ""                                      ;
  if ( gmp_cmp ( $this -> Payer , $PUID ) == 0 ) {
    $WAY = $Translations [ "Trade::Pay"    ]     ;
  } else
  if ( gmp_cmp ( $this -> Payee , $PUID ) == 0 ) {
    $WAY = $Translations [ "Trade::Refund" ]     ;
  }                                              ;
  return $WAY                                    ;
}

public function isPaid($PUID)
{
  return ( gmp_cmp ( $this -> Payer , $PUID ) == 0 ) ;
}

public function isRefund($PUID)
{
  return ( gmp_cmp ( $this -> Payee , $PUID ) == 0 ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function TradeRecord($TZ,$JOIN=" ",$DateFormat="Y/m/d",$TimeFormat="H:i:s")
{
  $SD  = new StarDate ( )                                                    ;
  $SD -> setSD ( $this -> Record )                                           ;
  $TT  = $SD -> toDateTimeString ( $TZ , $JOIN , $DateFormat , $TimeFormat ) ;
  unset ( $SD )                                                              ;
  return $TT                                                                 ;
}

public function TradeTime($TZ,$JOIN=" ",$DateFormat="Y/m/d",$TimeFormat="H:i:s")
{
  $SD  = new StarDate ( )                                        ;
  $SD -> setSD ( $this -> Record )                               ;
  $TT  = $SD -> toLongString ( $TZ , $DateFormat , $TimeFormat ) ;
  unset ( $SD )                                                  ;
  return $TT                                                     ;
}

//////////////////////////////////////////////////////////////////////////////

public function obtain($R)
{
  $this -> Id          = $R [ "id"          ]            ;
  $this -> Uuid        = $R [ "uuid"        ]            ;
  $this -> Payer       = $R [ "payer"       ]            ;
  $this -> PayerBank   = $R [ "payerbank"   ]            ;
  $this -> Payee       = $R [ "payee"       ]            ;
  $this -> PayeeBank   = $R [ "payeebank"   ]            ;
  $this -> Currency    = $R [ "currency"    ]            ;
  $this -> Amount      = $R [ "amount"      ]            ;
  $this -> States      = $R [ "states"      ]            ;
  $this -> Item        = $R [ "item"        ]            ;
  $this -> Description = $R [ "description" ]            ;
  $this -> Record      = $R [ "record"      ]            ;
  $this -> Update      = $R [ "ltime"       ]            ;
  ////////////////////////////////////////////////////////
  $this -> Item        = intval ( $this -> Item   , 10 ) ;
  $this -> States      = intval ( $this -> States , 10 ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function InsertInto($Table)
{
  return "insert into " . $Table . " "                         .
         "(`uuid`,`payer`,`payerbank`,`payee`,`payeebank`,"    .
          "`currency`,`amount`,`states`,`item`,`description`," .
          "`record`) values ("                                 .
          (string) $this -> Uuid        . ","                  .
          (string) $this -> Payer       . ","                  .
          (string) $this -> PayerBank   . ","                  .
          (string) $this -> Payee       . ","                  .
          (string) $this -> PayeeBank   . ","                  .
          "'" .    $this -> Currency    . "',"                 .
          (string) $this -> Amount      . ","                  .
          (string) $this -> States      . ","                  .
          (string) $this -> Item        . ","                  .
          (string) $this -> Description . ","                  .
          (string) $this -> Record      . ") ;"                ;
}

//////////////////////////////////////////////////////////////////////////////

public function UpdateProduct($Table)
{
  return "update " . $Table . " set "                       .
         "`item` = " . $this -> Item . " , "                .
         "`description` = " . (string) $this -> Description .
         " where `uuid` = " . (string) $this -> Uuid . " ;" ;
}

//////////////////////////////////////////////////////////////////////////////

public function GetUuid ( $DB , $Table , $Main )
{
  global $DataTypes                                          ;
  $BASE         = "3200000000000000000"                      ;
  $TYPE         = $DataTypes [ "Trade" ]                     ;
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

public function Update($DB,$TABLE)
{
  $ITEMS = $this -> valueItems ( )                            ;
  $QQ    = "update {$TABLE} set " . $this -> Pairs ( $ITEMS ) .
           $DB -> WhereUuid ( $this -> Uuid , true )          ;
  unset ( $ITEMS )                                            ;
  return $DB -> Query ( $QQ )                                 ;
}

//////////////////////////////////////////////////////////////////////////////

public function ObtainsByUuid($DB,$TABLE)
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

public function ObtainsTrades($DB,$TRADES,$ITEM)
{
  $QQ = "select `uuid` from " . $TRADES                 .
        " where ( `payer` = " . (string) $this -> Payer .
             " or `payee` = " . (string) $this -> Payee .
        " ) and `item` = " . $ITEM                      .
        " order by `record` desc ;"                     ;
  return $DB -> ObtainUuids ( $QQ )                     ;
}

//////////////////////////////////////////////////////////////////////////////

public function ObtainsTransactions($DB,$TRADES,$ITEM,$ORDER="asc")
{
  $QQ = "select `uuid` from " . $TRADES                              .
        " where `" . $ITEM ."` = " . (string) $this -> get ( $ITEM ) .
        " order by `record` asc ;"                                   ;
  return $DB -> ObtainUuids ( $QQ )                                  ;
}

//////////////////////////////////////////////////////////////////////////////

public function ObtainsByDescription($DB,$TABLE,$DESCRIPTION)
{
  $QQ = "select `uuid` from {$TABLE}"           .
        " where `description` = {$DESCRIPTION}" .
        " order by `record` desc ;"             ;
  return $DB -> ObtainUuids ( $QQ )             ;
}

//////////////////////////////////////////////////////////////////////////////

public function ObtainRelated($DB,$RELATIONS,$CLASSID)
{
  $RI     = new RelationItem     (                    ) ;
  $RI    -> set                  ( "first" , $CLASSID ) ;
  $RI    -> setT1                ( "Class"            ) ;
  $RI    -> setT2                ( "Trade"            ) ;
  $RI    -> setRelation          ( "Subordination"    ) ;
  $TRADES = $RI -> Subordination ( $DB , $RELATIONS   ) ;
  unset                          ( $RI                ) ;
  return $TRADES                                        ;
}

public function ObtainsByClass($DB,$TABLE,$RELATIONS,$CLASSID)
{
  $TRADES = $this -> ObtainsByDescription ( $DB , $TABLE     , $CLASSID ) ;
  $TRDS   = $this -> ObtainRelated        ( $DB , $RELATIONS , $CLASSID ) ;
  $TRADES = $DB   -> JoinArray            ( $TRADES , $TRDS             ) ;
  return $TRADES                                                          ;
}

//////////////////////////////////////////////////////////////////////////////

public function JoinClass($DB,$TABLE,$CLASSID)
{
  $RI    = new RelationItem (                          ) ;
  $RI   -> set              ( "first"  , $CLASSID      ) ;
  $RI   -> set              ( "second" , $this -> Uuid ) ;
  $RI   -> setT1            ( "Class"                  ) ;
  $RI   -> setT2            ( "Trade"                  ) ;
  $RI   -> setRelation      ( "Subordination"          ) ;
  $RI   -> Join             ( $DB , $TABLE             ) ;
  unset                     ( $RI                      ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function JoinPeople($DB,$TABLE,$PEOPLEID)
{
  $RI    = new RelationItem (                          ) ;
  $RI   -> set              ( "first"  , $PEOPLEID     ) ;
  $RI   -> set              ( "second" , $this -> Uuid ) ;
  $RI   -> setT1            ( "People"                 ) ;
  $RI   -> setT2            ( "Trade"                  ) ;
  $RI   -> setRelation      ( "Subordination"          ) ;
  $RI   -> Join             ( $DB , $TABLE             ) ;
  unset                     ( $RI                      ) ;
}

//////////////////////////////////////////////////////////////////////////////

public function RemoveWithClass($DB,$TABLE,$CLASSID)
{
  //////////////////////////////////////////////////////
  $RI  = new RelationItem (                          ) ;
  //////////////////////////////////////////////////////
  $RI -> set              ( "first"  , $CLASSID      ) ;
  $RI -> set              ( "second" , $this -> Uuid ) ;
  $RI -> setT1            ( "Class"                  ) ;
  $RI -> setT2            ( "Trade"                  ) ;
  $RI -> setRelation      ( "Subordination"          ) ;
  //////////////////////////////////////////////////////
  $QQ  = $RI -> Delete    ( $TABLE                   ) ;
  $DB -> Query            ( $QQ                      ) ;
  //////////////////////////////////////////////////////
  unset                   ( $RI                      ) ;
  //////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////

public function RemoveWithPeople($DB,$TABLE,$PEOPLEID)
{
  //////////////////////////////////////////////////////
  $RI  = new RelationItem (                          ) ;
  //////////////////////////////////////////////////////
  $RI -> set              ( "first"  , $PEOPLEID     ) ;
  $RI -> set              ( "second" , $this -> Uuid ) ;
  $RI -> setT1            ( "People"                 ) ;
  $RI -> setT2            ( "Trade"                  ) ;
  $RI -> setRelation      ( "Subordination"          ) ;
  //////////////////////////////////////////////////////
  $QQ  = $RI -> Delete    ( $TABLE                   ) ;
  $DB -> Query            ( $QQ                      ) ;
  //////////////////////////////////////////////////////
  unset                   ( $RI                      ) ;
  //////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////

public function StudentJson($DB,$TZ,$NAME,$TRADEID)
{
  global $ProductItems                                                      ;
  $HH   = new Parameters        (                        )                  ;
  ///////////////////////////////////////////////////////////////////////////
  $CIDS = $HH  -> TradeString   ( $this -> Uuid          )                  ;
  $TIDS = "付款金額：" . $this -> Amount . " " . $this -> Currency . "\\n"    .
          "品項：" . $ProductItems [ $this -> Item ]              . "\\n"    .
          "編號：" . $CIDS                                                   ;
  $PRD  = new Periode ( )                                                   ;
  $PRD -> Start = $this -> Record                                           ;
  $PRD -> setInterval ( 5400 )                                              ;
  ///////////////////////////////////////////////////////////////////////////
  $JSC  = new jsHandler (        )                                          ;
  $JSC -> setType       ( 4      )                                          ;
  $JSC -> setSplitter   ( " ,\n" )                                          ;
  ///////////////////////////////////////////////////////////////////////////
  // class information
  $JSC -> JsonSqString ( "id"        , $CIDS                              ) ;
  $JSC -> JsonSqString ( "className" , $TRADEID                           ) ;
  $JSC -> JsonSqString ( "title"     , $TIDS                              ) ;
  $JSC -> JsonValue    ( "allDay"    , "false"                            ) ;
  $JSC -> JsonValue    ( "editable"  , "false"                            ) ;
  ///////////////////////////////////////////////////////////////////////////
  // time duration
  $JSC -> JsonSqString ( "start" , $PRD -> toTimeString ( $TZ , "start" ) ) ;
  ///////////////////////////////////////////////////////////////////////////
  // set color style
  $JSC -> JsonSqString ( "backgroundColor" , "#00cc99" )                    ;
  $JSC -> JsonSqString ( "textColor"       , "#000000" )                    ;
  $JSC -> JsonSqString ( "borderColor"     , "#5522ff" )                    ;
  ///////////////////////////////////////////////////////////////////////////
  unset ( $PRD )                                                            ;
  unset ( $HH  )                                                            ;
  ///////////////////////////////////////////////////////////////////////////
  return $JSC                                                               ;
}

//////////////////////////////////////////////////////////////////////////////

public function StudentTrades($DB,$TZ,$JAVA,$TRADES,$NAME,$TRADEID)
{
  $UU = $this -> ObtainsTransactions ( $DB , $TRADES , "payer" ) ;
  foreach ( $UU as $uu )                                         {
    $this -> Uuid = $uu                                          ;
    if ( $this -> ObtainsByUuid ( $DB , $TRADES ) )              {
      $JAVA    -> AddChild                                       (
        $this  -> StudentJson                                    (
          $DB                                                    ,
          $TZ                                                    ,
          $NAME                                                  ,
          $TRADEID                                           ) ) ;
    }                                                            ;
  }                                                              ;
}

//////////////////////////////////////////////////////////////////////////////

public function ItemTd($ITEM,$COLSPAN=1)
{
  global $Translations                             ;
  //////////////////////////////////////////////////
  $HD    = new HtmlTag (                         ) ;
  $HD   -> setTag      ( "td"                    ) ;
  $HD   -> AddPair     ( "nowrap" , "nowrap"     ) ;
  $HD   -> AddPair     ( "width"  , "3%"         ) ;
  $HD   -> AddText     ( $Translations [ $ITEM ] ) ;
  //////////////////////////////////////////////////
  if                   ( $COLSPAN > 1            ) {
    $HD -> AddPair     ( "colspan" , $COLSPAN    ) ;
  }                                                ;
  //////////////////////////////////////////////////
  return $HD                                       ;
}

//////////////////////////////////////////////////////////////////////////////

public function DetailButton ( $CLASSID = "SelectionButton" )
{
  global $Translations                            ;
  /////////////////////////////////////////////////
  $TJC = "TradeDetails('{$this -> Uuid}');"       ;
  $MSG = $Translations [ "Trade::Details" ]       ;
  /////////////////////////////////////////////////
  $HB  = new HtmlTag (                      )     ;
  $HB -> setTag      ( "button"             )     ;
  $HB -> AddText     ( $MSG                 )     ;
  $HB -> AddPair     ( "class"   , $CLASSID )     ;
  $HB -> AddPair     ( "onclick" , $TJC     )     ;
  /////////////////////////////////////////////////
  return $HB                                      ;
}

//////////////////////////////////////////////////////////////////////////////
// 交易簡報表格
//////////////////////////////////////////////////////////////////////////////
public function TradeDivBlock($TZ,$PAY,$TKN,$SKIPS=0)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  global $ProductItems                                                       ;
  global $TradeStateNames                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  $HDXV  = new HtmlTag             (                                       ) ;
  $HDXV -> setDiv                  ( "" , "" , "TradeBlock"                ) ;
  $HDXV -> setSplitter             ( "\n"                                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HTIV  = $HDXV -> addHtml        (                                       ) ;
  $TBODY = $HTIV -> ConfigureTable ( 1 , 0 , 0                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $TBODY -> addTr  (                                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 交易編號
  ////////////////////////////////////////////////////////////////////////////
  $TJC   = "TradeDetails('{$this -> Uuid}');"                                ;
  $HR   -> AddTag           ( $this -> ItemTd ( "Trade::ID" , 10 )         ) ;
  $HD    = $HR    -> addTd  ( $this -> IdString ( )                        ) ;
  $HD   -> AddPair          ( "colspan"    , "25"                          ) ;
  $HD   -> AddPair          ( "ondblclick" , $TJC                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 交易時間
  ////////////////////////////////////////////////////////////////////////////
  $HR   -> AddTag           ( $this -> ItemTd ( "Trade::DateTime" , 10 )   ) ;
  $HD    = $HR    -> addTd  ( $this -> TradeTime ( $TZ )                   ) ;
  $HD   -> AddPair          ( "colspan" , "25"                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 交易金額
  ////////////////////////////////////////////////////////////////////////////
  $MONEY = $this -> GetMoney ( )                                             ;
  $MSG   = "{$PAY} {$MONEY}"                                                 ;
  $HR   -> AddTag           ( $this -> ItemTd ( "Trade::Amount" , 10 )     ) ;
  $HD    = $HR    -> addTd  ( $MSG                                         ) ;
  $HD   -> AddPair          ( "colspan" , "25"                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 交易項目
  ////////////////////////////////////////////////////////////////////////////
  $PROD  = $ProductItems [ $this -> Item ]                                   ;
  $MSG   = "{$TKN} {$PROD}"                                                  ;
  $HR   -> AddTag           ( $this -> ItemTd ( "Trade::Item" , 10 )       ) ;
  $HD    = $HR    -> addTd  ( $MSG                                         ) ;
  $HD   -> AddPair          ( "colspan" , "25"                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 可請假配額
  ////////////////////////////////////////////////////////////////////////////
  $HR   -> AddTag           ( $this -> ItemTd ( "Trade::Quota:" , 10 )     ) ;
  $HD    = $HR    -> addTd  ( $SKIPS                                       ) ;
  $HD   -> AddPair          ( "colspan" , "25"                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 交易狀態
  ////////////////////////////////////////////////////////////////////////////
  $HR   -> AddTag           ( $this -> ItemTd ( "Trade::State" , 10 )      ) ;
  $HD    = $HR    -> addTd  ( $TradeStateNames [ $this -> States ]         ) ;
  $HD   -> AddPair          ( "colspan" , "25"                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 按鈕行
  ////////////////////////////////////////////////////////////////////////////
  $HR    = $TBODY -> addTr  (                                              ) ;
  $HD    = $HR    -> addTd  (                                              ) ;
  $HD   -> AddPair          ( "colspan" , "210"                            ) ;
  $HD   -> AddPair          ( "align"   , "right"                          ) ;
  $HD   -> AddTag           ( $this -> DetailButton ( "SelectionButton" )  ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HDXV                                                               ;
}

public function addAppendPayee($CLASSID,$BTNCLASS="SelectionButton")
{
  /////////////////////////////////////////////////////////////////
  global $Translations                                            ;
  /////////////////////////////////////////////////////////////////
  $JSC  = "AppendClassTrade('payee','$CLASSID') ;"                ;
  /////////////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                                         ) ;
  $BTN -> setTag      ( "button"                                ) ;
  $BTN -> AddPair     ( "class"   , $BTNCLASS                   ) ;
  $BTN -> AddPair     ( "onclick" , $JSC                        ) ;
  $BTN -> AddText     ( $Translations [ "Trades::AppendPayee" ] ) ;
  /////////////////////////////////////////////////////////////////
  return $BTN                                                     ;
}

public function addAppendPayer($CLASSID,$BTNCLASS="SelectionButton")
{
  /////////////////////////////////////////////////////////////////
  global $Translations                                            ;
  /////////////////////////////////////////////////////////////////
  $JSC  = "AppendClassTrade('payer','$CLASSID') ;"                ;
  /////////////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                                         ) ;
  $BTN -> setTag      ( "button"                                ) ;
  $BTN -> AddPair     ( "class"   , $BTNCLASS                   ) ;
  $BTN -> AddPair     ( "onclick" , $JSC                        ) ;
  $BTN -> AddText     ( $Translations [ "Trades::AppendPayer" ] ) ;
  /////////////////////////////////////////////////////////////////
  return $BTN                                                     ;
}

public function payerInput($CLASSID,$IDV,$INPCLASS="NameInput")
{
  $JSC  = "changePayer(this.value,'{$this->Uuid}','{$CLASSID}') ;" ;
  //////////////////////////////////////////////////////////////////
  $INP  = new HtmlTag (                        )                   ;
  $INP -> setInput    (                        )                   ;
  $INP -> AddPair     ( "type"     , "text"    )                   ;
  $INP -> AddPair     ( "class"    , $INPCLASS )                   ;
  $INP -> AddPair     ( "onchange" , $JSC      )                   ;
  $INP -> SafePair    ( "value"    , $IDV      )                   ;
  //////////////////////////////////////////////////////////////////
  return $INP                                                      ;
}

public function addPayer($HD,$CLASSID,$INPCLASS="NameInput",$editable=false)
{
  $HH    = new Parameters      (                             ) ;
  if                  ( gmp_cmp ( $this -> Payer , "0" ) > 0 ) {
    $IDV = $HH -> PeopleString ( $this -> Payer              ) ;
  } else $IDV = ""                                             ;
  if                           ( $editable                   ) {
    $DTV = $this -> payerInput ( $CLASSID , $IDV , $INPCLASS ) ;
    $HD -> AddTag              ( $DTV                        ) ;
  } else                                                       {
    $HD -> AddText             ( $IDV                        ) ;
  }                                                            ;
  unset                        ( $HH                         ) ;
}

public function payeeInput($CLASSID,$IDV,$INPCLASS="NameInput")
{
  $JSC  = "changePayee(this.value,'{$this->Uuid}','{$CLASSID}') ;" ;
  //////////////////////////////////////////////////////////////////
  $INP  = new HtmlTag (                        )                   ;
  $INP -> setInput    (                        )                   ;
  $INP -> AddPair     ( "type"     , "text"    )                   ;
  $INP -> AddPair     ( "class"    , $INPCLASS )                   ;
  $INP -> AddPair     ( "onchange" , $JSC      )                   ;
  $INP -> SafePair    ( "value"    , $IDV      )                   ;
  //////////////////////////////////////////////////////////////////
  return $INP                                                      ;
}

public function addPayee($HD,$CLASSID,$INPCLASS="NameInput",$editable=false)
{
  $HH    = new Parameters      (                             ) ;
  if                  ( gmp_cmp ( $this -> Payee , "0" ) > 0 ) {
    $IDV = $HH -> PeopleString ( $this -> Payee              ) ;
  } else $IDV = ""                                             ;
  if                           ( $editable                   ) {
    $DTV = $this -> payeeInput ( $CLASSID , $IDV , $INPCLASS ) ;
    $HD -> AddTag              ( $DTV                        ) ;
  } else                                                       {
    $HD -> AddText             ( $IDV                        ) ;
  }                                                            ;
  unset                        ( $HH                         ) ;
}

public function currencyListing()
{
  //////////////////////////////////////////////////////////////
  global $DefaultCurrency                                      ;
  //////////////////////////////////////////////////////////////
  $JTS = "TradeChanged(this.value,'currency','$this->Uuid') ;" ;
  $SS  = $this -> Currency                                     ;
  //////////////////////////////////////////////////////////////
  $HS  = new HtmlTag (                     )                   ;
  $HS -> setTag      ( "select"            )                   ;
  $HS -> setSplitter ( "\n"                )                   ;
  //////////////////////////////////////////////////////////////
  foreach ( $DefaultCurrency as $dc )                          {
    $HO  = $HS -> addOption ( $dc )                            ;
    $HO -> AddPair ( "value" , $dc )                           ;
    if ( $SS == $dc ) $HO -> AddMember ( "selected" )          ;
  }                                                            ;
  //////////////////////////////////////////////////////////////
  $HS -> AddPair     ( "onchange"   , $JTS )                   ;
  //////////////////////////////////////////////////////////////
  return $HS                                                   ;
}

public function addCurrency($HD,$SELCLASS="",$editable=false)
{
  if                                 ( $editable           ) {
    $DTV  = $this -> currencyListing (                     ) ;
    $DTV -> AddPair                  ( "class" , $SELCLASS ) ;
    $HD  -> AddTag                   ( $DTV                ) ;
  } else                                                     {
    $DTV = $this -> Currency                                 ;
    $HD -> AddText                   ( $DTV                ) ;
  }                                                          ;
}

public function amountInput($AMTCLASS="AmountInput")
{
  $TJS  = "TradeChanged(this.value,'amount','$this->Uuid') ;" ;
  $TIP  = new HtmlTag (                              )        ;
  /////////////////////////////////////////////////////////////
  $TIP -> setInput    (                              )        ;
  $TIP -> AddPair     ( "type"     , "number"        )        ;
  $TIP -> AddPair     ( "size"     , "8"             )        ;
  $TIP -> SafePair    ( "class"    , $AMTCLASS       )        ;
  $TIP -> AddPair     ( "min"      , "0"             )        ;
  $TIP -> AddPair     ( "max"      ,  "100000000"    )        ;
  $TIP -> AddPair     ( "step"     , "1"             )        ;
  $TIP -> AddPair     ( "onchange" , $TJS            )        ;
  $TIP -> AddPair     ( "value"    , $this -> Amount )        ;
  /////////////////////////////////////////////////////////////
  return $TIP                                                 ;
}

public function addAmount($HD,$AMTCLASS="AmountInput",$editable=false)
{
  if                            ( $editable ) {
    $DTV = $this -> amountInput ( $AMTCLASS ) ;
    $HD -> AddTag               ( $DTV      ) ;
  } else                                      {
    $DTV = $this -> Amount                    ;
    $HD -> AddText              ( $DTV      ) ;
  }                                           ;
}

public function statesListing()
{
  ////////////////////////////////////////////////////////////
  global $TradeStateNames                                    ;
  ////////////////////////////////////////////////////////////
  $JTS = "TradeChanged(this.value,'states','$this->Uuid') ;" ;
  $SS  = $this -> States                                     ;
  ////////////////////////////////////////////////////////////
  $HS  = new HtmlTag (                         )             ;
  $HS -> setTag      ( "select"                )             ;
  $HS -> setSplitter ( "\n"                    )             ;
  $HS -> addOptions  ( $TradeStateNames , $SS  )             ;
  $HS -> AddPair     ( "onchange"       , $JTS )             ;
  ////////////////////////////////////////////////////////////
  return $HS                                                 ;
}

public function addStates($HD,$editable=false)
{
  ///////////////////////////////////////////////
  global $TradeStateNames                       ;
  ///////////////////////////////////////////////
  if                              ( $editable ) {
    $DTV = $this -> statesListing (           ) ;
    $HD -> AddTag                 ( $DTV      ) ;
  } else                                        {
    $DTV = $TradeStateNames [ $this -> States ] ;
    $HD -> AddText                ( $DTV      ) ;
  }                                             ;
}

public function itemsListing()
{
  //////////////////////////////////////////////////////////
  global $ProductItems                                     ;
  //////////////////////////////////////////////////////////
  $JTS = "TradeChanged(this.value,'item','$this->Uuid') ;" ;
  $SS  = $this -> Item                                     ;
  //////////////////////////////////////////////////////////
  $HS  = new HtmlTag (                      )              ;
  $HS -> setTag      ( "select"             )              ;
  $HS -> setSplitter ( "\n"                 )              ;
  $HS -> addOptions  ( $ProductItems , $SS  )              ;
  $HS -> AddPair     ( "onchange"    , $JTS )              ;
  //////////////////////////////////////////////////////////
  return $HS                                               ;
}

public function addItems($HD,$editable=false)
{
  //////////////////////////////////////////////
  global $ProductItems                         ;
  //////////////////////////////////////////////
  if                             ( $editable ) {
    $DTV = $this -> itemsListing (           ) ;
    $HD -> AddTag                ( $DTV      ) ;
  } else                                       {
    $DTV = $ProductItems [ $this -> Item ]     ;
    $HD -> AddText               ( $DTV      ) ;
  }                                            ;
}

public function addRecordInput($TZ)
{
  $TDT  = $this -> TradeRecord ( $TZ , "T" , "Y-m-d" , "H:i:s" ) ;
  $JSC  = "TradeChanged(this.value,'record','$this->Uuid') ;"    ;
  $INP  = new HtmlTag (                               )          ;
  $INP -> setInput    (                               )          ;
  $INP -> AddPair     ( "type"     , "datetime-local" )          ;
  $INP -> AddPair     ( "step"     , "1"              )          ;
  $INP -> AddPair     ( "class"    , "DateTimeInput"  )          ;
  $INP -> AddPair     ( "value"    , $TDT             )          ;
  $INP -> AddPair     ( "onchange" , $JSC             )          ;
  return $INP                                                    ;
}

public function addRecordTime($HD,$TZ,$editable=false)
{
  if ( $editable )                          {
    $DTI = $this -> addRecordInput ( $TZ  ) ;
    $HD -> AddTag                  ( $DTI ) ;
  } else                                    {
    $DTI = $this -> TradeTime               (
                             $TZ            ,
                             " "            ,
                             "Y/m/d D A"    ,
                             "H:i:s"      ) ;
    $HD -> AddText ( $DTI )                 ;
  }                                         ;
}

public function addRemoveTrade($CLASSID,$BTNCLASS="SelectionButton")
{
  ////////////////////////////////////////////////////////////
  global $Translations                                       ;
  ////////////////////////////////////////////////////////////
  $JSC  = "RemoveTrade('{$this->Uuid}','$CLASSID') ;"        ;
  ////////////////////////////////////////////////////////////
  $BTN  = new HtmlTag (                                    ) ;
  $BTN -> setTag      ( "button"                           ) ;
  $BTN -> AddPair     ( "class"   , $BTNCLASS              ) ;
  $BTN -> AddPair     ( "onclick" , $JSC                   ) ;
  $BTN -> AddText     ( $Translations [ "Trades::Remove" ] ) ;
  ////////////////////////////////////////////////////////////
  return $BTN                                                ;
}

//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
