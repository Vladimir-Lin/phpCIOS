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
public $Credit      ;
public $Credits     ;
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
  $this -> Credit      =  0 ;
  $this -> Credits     =  0 ;
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
  $this -> Credit      = $Item -> Credit      ;
  $this -> Credits     = $Item -> Credits     ;
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
  array_push ( $S , "credit"      ) ;
  array_push ( $S , "credits"     ) ;
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
  array_push ( $S , "credit"     ) ;
  array_push ( $S , "credits"    ) ;
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
  if ( "credit"      == $a ) $this -> Credit      = $V ;
  if ( "credits"     == $a ) $this -> Credits     = $V ;
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
  if ( "period"      == $a ) return (string) $this -> Period      ;
  if ( "beneficiary" == $a ) return (string) $this -> Beneficiary ;
  if ( "item"        == $a ) return (string) $this -> Item        ;
  if ( "seniority"   == $a ) return (string) $this -> Seniority   ;
  if ( "duration"    == $a ) return (string) $this -> Duration    ;
  if ( "credit"      == $a ) return (string) $this -> Credit      ;
  if ( "credits"     == $a ) return (string) $this -> Credits     ;
  if ( "hours"       == $a ) return (string) $this -> Hours       ;
  if ( "tokens"      == $a ) return (string) $this -> Tokens      ;
  if ( "bonus"       == $a ) return (string) $this -> Bonus       ;
  if ( "cumulation"  == $a ) return (string) $this -> Cumulation  ;
  if ( "rate"        == $a ) return (string) $this -> Rate        ;
  if ( "wage"        == $a ) return (string) $this -> Wage        ;
  if ( "commission"  == $a ) return (string) $this -> Commission  ;
  if ( "penalty"     == $a ) return (string) $this -> Penalty     ;
  if ( "salary"      == $a ) return (string) $this -> Salary      ;
  if ( "currency"    == $a ) return (string) $this -> Currency    ;
  if ( "ltime"       == $a ) return (string) $this -> Update      ;
  return ""                                                       ;
}

public function Pair ( $item )
{
  $GV = $this -> get ( $item ) ;
  return "`{$item}` = {$GV}"   ;
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
  $this -> Period      = $R [ "period"      ] ;
  $this -> Beneficiary = $R [ "beneficiary" ] ;
  $this -> Item        = $R [ "item"        ] ;
  $this -> Seniority   = $R [ "seniority"   ] ;
  $this -> Duration    = $R [ "duration"    ] ;
  $this -> Credit      = $R [ "credit"      ] ;
  $this -> Credits     = $R [ "credits"     ] ;
  $this -> Hours       = $R [ "hours"       ] ;
  $this -> Tokens      = $R [ "tokens"      ] ;
  $this -> Bonus       = $R [ "bonus"       ] ;
  $this -> Cumulation  = $R [ "cumulation"  ] ;
  $this -> Rate        = $R [ "rate"        ] ;
  $this -> Wage        = $R [ "wage"        ] ;
  $this -> Commission  = $R [ "commission"  ] ;
  $this -> Penalty     = $R [ "penalty"     ] ;
  $this -> Salary      = $R [ "salary"      ] ;
  $this -> Currency    = $R [ "currency"    ] ;
  $this -> Update      = $R [ "ltime"       ] ;
}

public function Obtains ( $DB , $TABLE )
{
  $IT = $this -> Items ( )                   ;
  $PP = $this -> Period                      ;
  $BB = $this -> Beneficiary                 ;
  $II = $this -> Item                        ;
  $WH = "where ( `period` = {$PP} )"         .
         " and ( `beneficiary` = {$BB} )"    .
         " and ( `item` = {$II} )"           ;
  $QQ = "select {$IT} from {$TABLE} {$WH} ;" ;
  $qq = $DB -> Query ( $QQ )                 ;
  if ( $DB -> hasResult ( $qq ) )            {
    $rr = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this     -> obtain      ( $rr         ) ;
    return true                              ;
  }                                          ;
  return false                               ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
