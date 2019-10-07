<?php

namespace CIOS ;

class Payroster extends Columns
{
/////////////////////////////////////////////////////////

public $Id          ;
public $Period      ;
public $Beneficiary ;
public $Item        ;
public $Seniority   ;
public $Duration    ;
public $Hours       ;
public $Tokens      ;
public $Bonus       ;
public $Cumulation  ;
public $Rate        ;
public $Wage        ;
public $Commission  ;
public $Penalty     ;
public $Salary      ;
public $Currency    ;
public $Update      ;

function __construct()
{
  $this -> Clear ( ) ;
}

function __destruct()
{
}

public function Clear ( )
{
  $this -> Id          = -1 ;
  $this -> Period      =  0 ;
  $this -> Beneficiary =  0 ;
  $this -> Item        =  0 ;
  $this -> Seniority   =  0 ;
  $this -> Duration    =  0 ;
  $this -> Hours       =  0 ;
  $this -> Tokens      =  0 ;
  $this -> Bonus       =  0 ;
  $this -> Cumulation  =  0 ;
  $this -> Rate        =  0 ;
  $this -> Wage        =  0 ;
  $this -> Commission  =  0 ;
  $this -> Penalty     =  0 ;
  $this -> Salary      =  0 ;
  $this -> Currency    = "" ;
  $this -> Update      =  0 ;
}

public function assign ( $Item )
{
  $this -> Id          = $Item -> Id          ;
  $this -> Period      = $Item -> Period      ;
  $this -> Beneficiary = $Item -> Beneficiary ;
  $this -> Item        = $Item -> Item        ;
  $this -> Seniority   = $Item -> Seniority   ;
  $this -> Duration    = $Item -> Duration    ;
  $this -> Hours       = $Item -> Hours       ;
  $this -> Tokens      = $Item -> Tokens      ;
  $this -> Bonus       = $Item -> Bonus       ;
  $this -> Cumulation  = $Item -> Cumulation  ;
  $this -> Rate        = $Item -> Rate        ;
  $this -> Wage        = $Item -> Wage        ;
  $this -> Commission  = $Item -> Commission  ;
  $this -> Penalty     = $Item -> Penalty     ;
  $this -> Salary      = $Item -> Salary      ;
  $this -> Currency    = $Item -> Currency    ;
  $this -> Update      = $Item -> Update      ;
}

public function tableItems ( )
{
  $S = array (                    ) ;
  array_push ( $S , "id"          ) ;
  array_push ( $S , "period"      ) ;
  array_push ( $S , "beneficiary" ) ;
  array_push ( $S , "item"        ) ;
  array_push ( $S , "seniority"   ) ;
  array_push ( $S , "duration"    ) ;
  array_push ( $S , "hours"       ) ;
  array_push ( $S , "tokens"      ) ;
  array_push ( $S , "bonus"       ) ;
  array_push ( $S , "cumulation"  ) ;
  array_push ( $S , "rate"        ) ;
  array_push ( $S , "wage"        ) ;
  array_push ( $S , "commission"  ) ;
  array_push ( $S , "penalty"     ) ;
  array_push ( $S , "salary"      ) ;
  array_push ( $S , "currency"    ) ;
  array_push ( $S , "ltime"       ) ;
  return $S                         ;
}

public function valueItems ( )
{
  $S = array (                   ) ;
  array_push ( $S , "seniority"  ) ;
  array_push ( $S , "duration"   ) ;
  array_push ( $S , "hours"      ) ;
  array_push ( $S , "tokens"     ) ;
  array_push ( $S , "bonus"      ) ;
  array_push ( $S , "cumulation" ) ;
  array_push ( $S , "rate"       ) ;
  array_push ( $S , "wage"       ) ;
  array_push ( $S , "commission" ) ;
  array_push ( $S , "penalty"    ) ;
  array_push ( $S , "salary"     ) ;
  array_push ( $S , "currency"   ) ;
  return $S                        ;
}

public function set ( $item , $V )
{
  $a = strtolower ( $item )                            ;
  if ( "id"          == $a ) $this -> Id          = $V ;
  if ( "period"      == $a ) $this -> Period      = $V ;
  if ( "beneficiary" == $a ) $this -> Beneficiary = $V ;
  if ( "item"        == $a ) $this -> Item        = $V ;
  if ( "seniority"   == $a ) $this -> Seniority   = $V ;
  if ( "duration"    == $a ) $this -> Duration    = $V ;
  if ( "hours"       == $a ) $this -> Hours       = $V ;
  if ( "tokens"      == $a ) $this -> Tokens      = $V ;
  if ( "bonus"       == $a ) $this -> Bonus       = $V ;
  if ( "cumulation"  == $a ) $this -> Cumulation  = $V ;
  if ( "rate"        == $a ) $this -> Rate        = $V ;
  if ( "wage"        == $a ) $this -> Wage        = $V ;
  if ( "commission"  == $a ) $this -> Commission  = $V ;
  if ( "penalty"     == $a ) $this -> Penalty     = $V ;
  if ( "salary"      == $a ) $this -> Salary      = $V ;
  if ( "currency"    == $a ) $this -> Currency    = $V ;
  if ( "ltime"       == $a ) $this -> Update      = $V ;
}

public function get ( $item )
{
  $a = strtolower ( $item )                                       ;
  if ( "id"          == $a ) return (string) $this -> Id          ;
  if ( "Period"      == $a ) return (string) $this -> Period      ;
  if ( "Beneficiary" == $a ) return (string) $this -> Beneficiary ;
  if ( "Item"        == $a ) return (string) $this -> Item        ;
  if ( "Seniority"   == $a ) return (string) $this -> Seniority   ;
  if ( "Duration"    == $a ) return (string) $this -> Duration    ;
  if ( "Hours"       == $a ) return (string) $this -> Hours       ;
  if ( "Tokens"      == $a ) return (string) $this -> Tokens      ;
  if ( "Bonus"       == $a ) return (string) $this -> Bonus       ;
  if ( "Cumulation"  == $a ) return (string) $this -> Cumulation  ;
  if ( "Rate"        == $a ) return (string) $this -> Rate        ;
  if ( "Wage"        == $a ) return (string) $this -> Wage        ;
  if ( "Commission"  == $a ) return (string) $this -> Commission  ;
  if ( "Penalty"     == $a ) return (string) $this -> Penalty     ;
  if ( "Salary"      == $a ) return (string) $this -> Salary      ;
  if ( "Currency"    == $a ) return (string) $this -> Currency    ;
  if ( "ltime"       == $a ) return (string) $this -> Update      ;
  return ""                                                       ;
}

public function Pair ( $item )
{
  return "`{$item}` = " . $this -> get ( $item ) ;
}

public function Pairs ( $Items )
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
  return $this -> Pair ( $item ) ;
}

public function obtain ( $R )
{
  $this -> Id          = $R [ "id"          ] ;
  $this -> Period      = $R [ "Period"      ] ;
  $this -> Beneficiary = $R [ "Beneficiary" ] ;
  $this -> Item        = $R [ "Item"        ] ;
  $this -> Seniority   = $R [ "Seniority"   ] ;
  $this -> Duration    = $R [ "Duration"    ] ;
  $this -> Hours       = $R [ "Hours"       ] ;
  $this -> Tokens      = $R [ "Tokens"      ] ;
  $this -> Bonus       = $R [ "Bonus"       ] ;
  $this -> Cumulation  = $R [ "Cumulation"  ] ;
  $this -> Rate        = $R [ "Rate"        ] ;
  $this -> Wage        = $R [ "Wage"        ] ;
  $this -> Commission  = $R [ "Commission"  ] ;
  $this -> Penalty     = $R [ "Penalty"     ] ;
  $this -> Salary      = $R [ "Salary"      ] ;
  $this -> Currency    = $R [ "Currency"    ] ;
  $this -> Update      = $R [ "ltime"       ] ;
}

/*

public function Obtains($DB,$TABLE)
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

*/

}
//////////////////////////////////////////////////////////////////////////////
?>
