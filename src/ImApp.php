<?php
//////////////////////////////////////////////////////////////////////////////
// 即時通帳號管理元件
// 即時通類型列表(Type)
// 1 : Skype
// 2 : LINE
// 3 : WeChat
// 4 : WhatsApp
// 5 : ICQ
// 6 : Telegram
// 7 : QQ
// 8 : Google Meet
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class ImApp                                                                  {
//////////////////////////////////////////////////////////////////////////////
public $Uuid    = "0"                                                        ;
public $Type    =  1                                                         ;
public $Account = ""                                                         ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
public function clear ( )                                                    {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Uuid       = "0"                                                  ;
  $this -> Type       = 1                                                    ;
  $this -> Account    = ""                                                   ;
  $this -> Explain    = ""                                                   ;
  $this -> Properties = array (                                            ) ;
  $this -> Owners     = array (                                            ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function assign ( $ims )                                              {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Uuid       = $ims -> Uuid                                         ;
  $this -> Type       = $ims -> Type                                         ;
  $this -> Account    = $ims -> Account                                      ;
  $this -> Explain    = $ims -> Explain                                      ;
  $this -> Properties = $ims -> Properties                                   ;
  $this -> Owners     = $ims -> Owners                                       ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
// 即時通資訊是否已經載入
// 返回值:
//   true  -> 已經載入
//   false -> 沒有載入
//////////////////////////////////////////////////////////////////////////////
public function isLoaded (                                                 ) {
  return                 ( gmp_cmp ( $this -> Uuid , "0" ) > 0             ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 即時通帳號格式是否有效
// 返回值:
//   true  -> 有效
//   false -> 無效
//////////////////////////////////////////////////////////////////////////////
public function isValid (                                                  ) {
  ////////////////////////////////////////////////////////////////////////////
  if                    ( false === strpos ( $this -> Account , " "  )     ) {
    // no space in the email account name
  } else return false                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  if                    ( false === strpos ( $this -> Account , "\\" )     ) {
  } else return false                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  if                    ( false === strpos ( $this -> Account , "'"  )     ) {
  } else return false                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  if                    ( false === strpos ( $this -> Account , "`"  )     ) {
  } else return false                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  if                    ( false === strpos ( $this -> Account , "\"" )     ) {
  } else return false                                                        ;
  ////////////////////////////////////////////////////////////////////////////
  return                ( strlen ( $this -> Account ) > 0                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 指定即時通帳號種類
// 參數:
//   app : 1 ~ 8 , 請參考即時通帳號種類編號
//////////////////////////////////////////////////////////////////////////////
public function setApp ( $app )                                              {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Type = $app                                                       ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
// 指定即時通帳號
// 參數:
//   account : 即時通帳號
//////////////////////////////////////////////////////////////////////////////
public function setAccount ( $account                                      ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Account = trim  ( $account                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
// 更新即時通帳號資訊
// 參數:
//   table : 即時通資料庫表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function Update        ( $DB , $Table                               ) {
  ////////////////////////////////////////////////////////////////////////////
  if                          ( gmp_cmp ( $this -> Uuid , "0" ) <= 0       ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $ACCOUNT = $this -> Account                                                ;
  $TYPE    = $this -> Type                                                   ;
  $WHUUID  = $DB -> WhereUuid ( $this -> Uuid , true                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "update {$Table}"                                               .
             " set `account` = '{$ACCOUNT}' , `imapp` = {$TYPE} {$WHUUID}"   ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB -> Query         ( $QQ                                        ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 依據即時通長編號取得即時通帳號所有資訊
// 參數:
//   table : 即時通資料庫表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByUuid ( $DB , $Table                               ) {
  ////////////////////////////////////////////////////////////////////////////
  $WH = $DB -> WhereUuid      ( $this -> Uuid , true                       ) ;
  $QQ = "select `account`,`imapp` from {$Table} {$WH} ;"                     ;
  $qq = $DB -> Query          ( $QQ                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( ! $DB -> hasResult ( $qq )                 ) {
    return false                                                             ;
  }                                                                          ;
  $N  = $qq -> fetch_array    ( MYSQLI_BOTH                                ) ;
  if                          ( ! $N                                       ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Type    = $N       [ "imapp"                                    ] ;
  $this -> Account = $N       [ "account"                                  ] ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// 依據即時通帳號取得即時通帳號所有資訊
// 參數:
//   table : 即時通資料庫表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function ObtainsByAccount ( $DB , $Table                            ) {
  ////////////////////////////////////////////////////////////////////////////
  $this -> Uuid = "0"                                                        ;
  $T     = $this -> Type                                                     ;
  $A     = $this -> Account                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `uuid` from {$Table}"                                     .
           " where `account` = '{$A}'"                                       .
               " and `imapp` = {$T}"                                         .
                " and `used` = 1 ;"                                          ;
  $qq    = $DB -> Query ( $QQ )                                              ;
  if                             ( ! $DB -> hasResult ( $qq )              ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $N     = $qq -> fetch_array    ( MYSQLI_BOTH                             ) ;
  if                             ( ! $N                                    ) {
    return false                                                             ;
  }                                                                          ;
  $this -> Uuid = $N             [ "uuid"                                  ] ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// 依據即時通常編號或帳號取得即時通帳號所有資訊
// 參數:
//   table : 即時通資料庫表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function Obtains ( $DB , $Table                                     ) {
  ////////////////////////////////////////////////////////////////////////////
  if                    ( gmp_cmp ( $this -> Uuid , "0" ) > 0              ) {
    if                  ( $this -> ObtainsByUuid    ( $DB , $Table )       ) {
      return true                                                            ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if                   ( $this -> isValid ( )                              ) {
    if                 ( $this -> ObtainsByAccount ( $DB , $Table )        ) {
      return true                                                            ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
// 新增帳號
// 參數:
//   ImTable   : 即時通資料庫表格
//   UuidTable : 物件主表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function Append    ( $DB , $ImTable , $UuidTable                    ) {
  ////////////////////////////////////////////////////////////////////////////
  $U = $DB -> ObtainsUuid ( $ImTable , $UuidTable                          ) ;
  if                      ( gmp_cmp ( $U , "0" ) <= 0                      ) {
    return false                                                             ;
  }                                                                          ;
  $this -> Uuid = "{$U}"                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Update ( $DB , $ImTable                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 確保即時通帳號存在於系統:使用所有資訊檢索現有資訊,如果不存在則會自動新增
// 參數:
//   ImTable   : 即時通資料庫表格
//   UuidTable : 物件主表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function Assure   ( $DB , $ImTable , $UuidTable                     ) {
  ////////////////////////////////////////////////////////////////////////////
  if                     ( gmp_cmp ( $this -> Uuid , "0" ) == 0            ) {
    //////////////////////////////////////////////////////////////////////////
    if                   ( strlen  ( $this -> Account    ) <= 0            ) {
      return false                                                           ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
    if                   ( $this -> ObtainsByAccount ( $DB , $ImTable )    ) {
      return true                                                            ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
  } else                                                                     {
    //////////////////////////////////////////////////////////////////////////
    if                   ( $this -> ObtainsByUuid    ( $DB , $ImTable )    ) {
      return true                                                            ;
    }                                                                        ;
    //////////////////////////////////////////////////////////////////////////
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Append ( $DB , $ImTable , $UuidTable                     ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 新手帳號:會依據帳號搜尋現有資訊,如果不存在則會自動新增
// 參數:
//   ImTable   : 即時通資料庫表格
//   UuidTable : 物件主表格
// 返回值:
//   true  -> 成功
//   false -> 失敗
//////////////////////////////////////////////////////////////////////////////
public function Newbie   ( $DB , $ImTable , $UuidTable                     ) {
  ////////////////////////////////////////////////////////////////////////////
  if                     ( $this -> ObtainsByAccount ( $DB , $ImTable )    ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Append ( $DB , $ImTable , $UuidTable                     ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 擁有者的帳號列表
// 參數:
//   Table : 物件關係資料庫表格,relations
//   U     : 帳號長編號
//   Type  : 擁有者種類
// 返回值:
//   帳號列表 : [ UUID , ... ]
//////////////////////////////////////////////////////////////////////////////
public function Subordination ( $DB , $Table , $U , $Type = "People"       ) {
  ////////////////////////////////////////////////////////////////////////////
  $RI  = new Relation         (                                            ) ;
  $RI -> set                  ( "first" , $U                               ) ;
  $RI -> setT1                ( $Type                                      ) ;
  $RI -> setT2                ( "InstantMessage"                           ) ;
  $RI -> setRelation          ( "Subordination"                            ) ;
  $UU  = $RI -> Subordination ( $DB , $Table                               ) ;
  ////////////////////////////////////////////////////////////////////////////
  unset                       ( $RI                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $UU                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
// 取得帳號擁有者列表
// 參數:
//   Table : 物件關係資料庫表格,relations
//   Type  : 擁有者種類
// 返回值:
//   擁有者列表 : [ UUID , ... ]
//////////////////////////////////////////////////////////////////////////////
public function GetOwners ( $DB , $Table , $Type = "People"                ) {
  ////////////////////////////////////////////////////////////////////////////
  if                      ( gmp_cmp ( $this -> Uuid , "0" ) == 0           ) {
    return                [                                                ] ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $RI  = new Relation     (                                                ) ;
  $RI -> set              ( "second" , $this -> Uuid                       ) ;
  $RI -> setT1            ( $Type                                          ) ;
  $RI -> setT2            ( "InstantMessage"                               ) ;
  $RI -> setRelation      ( "Subordination"                                ) ;
  $UU  = $RI -> GetOwners ( $DB , $Table                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  unset                   ( $RI                                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $UU                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
// 透過名稱檢索即時通
// 參數:
//   TABLE : 即時通資料庫表格
//   NAME  : 即時通帳號部分名稱
// 返回值:
//   即時通帳號列表 : [ UUID , ... ]
//////////////////////////////////////////////////////////////////////////////
public function FindByName ( $DB , $TABLE , $NAME                          ) {
  ////////////////////////////////////////////////////////////////////////////
  $TMP = array             (                                               ) ;
  $SPT = "%{$NAME}%"                                                         ;
  $QQ  = "select `uuid` from {$TABLE}"                                       .
         " where `account` like ?"                                           .
         " order by `ltime` desc ;"                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $qq  = $DB -> Prepare    ( $QQ                                           ) ;
  $qq -> bind_param        ( 's' , $SPT                                    ) ;
  $ANS = $qq -> execute    (                                               ) ;
  if                       ( ! $ANS                                        ) {
    return $TMP                                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $kk  = $qq -> get_result (                                               ) ;
  if                       ( $DB -> hasResult ( $kk )                      ) {
    while                  ( $rr = $kk -> fetch_array ( MYSQLI_BOTH )      ) {
      array_push           ( $TMP , $rr [ 0 ]                              ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $TMP                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public function AssureExplain  ( $DB , $TABLE                              ) {
  ////////////////////////////////////////////////////////////////////////////
  $UUID    = $this -> Uuid                                                   ;
  $TYPE    = $this -> Type                                                   ;
  $EXPLAIN = $this -> Explain                                                ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $TYPE != 2                                ) {
    return                                                                   ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "replace into {$TABLE}"                                         .
             " ( `uuid` , `type` , `name` )"                                 .
             " values"                                                       .
             " ( {$UUID} , 113 , '{$EXPLAIN}' ) ;"                           ;
  $DB     -> Query             ( $QQ                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function ObtainsExplain ( $DB , $TABLE                              ) {
  ////////////////////////////////////////////////////////////////////////////
  $this   -> Explain = ""                                                    ;
  $UUID    = $this -> Uuid                                                   ;
  $TYPE    = $this -> Type                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  if                           ( $TYPE != 2                                ) {
    return                                                                   ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "select `name` from {$TABLE}"                                   .
             " where ( `uuid` = {$UUID} )"                                   .
               " and ( `type` = 113 ) ;"                                     ;
  $RR      = $DB -> FetchOne   ( $QQ                                       ) ;
  if                           ( strlen ( $RR ) > 0                        ) {
    $this -> Explain = $RR                                                   ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function UpdateProperty ( $DB , $TABLE , $ITEM , $VALUE             ) {
  ////////////////////////////////////////////////////////////////////////////
  $UUID = $this -> Uuid                                                      ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ   = "update {$TABLE}"                                                  .
          " set `{$ITEM}` = {$VALUE}"                                        .
          " where ( `uuid` = {$UUID} ) ;"                                    ;
  ////////////////////////////////////////////////////////////////////////////
  return $DB  -> Query         ( $QQ                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetProperties   ( $DB , $TABLE                             ) {
  ////////////////////////////////////////////////////////////////////////////
  $UUID    = $this -> Uuid                                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ      = "select `shareable` , `confirm` from {$TABLE}"                  .
             " where ( `uuid` = {$UUID} ) ;"                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $qq      = $DB -> Query       ( $QQ                                      ) ;
  if                            ( ! $DB -> hasResult ( $qq )               ) {
    return array                ( "Shareable" => 0                           ,
                                  "Confirm"   => 0                         ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $NN      = $qq -> fetch_array ( MYSQLI_BOTH                              ) ;
  $SHARE   = $NN                [ "shareable"                              ] ;
  $CONFIRM = $NN                [ "confirm"                                ] ;
  ////////////////////////////////////////////////////////////////////////////
  $SHARE   = intval             ( $SHARE   , 10                            ) ;
  $CONFIRM = intval             ( $CONFIRM , 10                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  return array                  ( "Shareable" => $SHARE                      ,
                                  "Confirm"   => $CONFIRM                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public function getReceiveMessage ( $DB , $PUID , $DEFAULT = 1             ) {
  ////////////////////////////////////////////////////////////////////////////
  $RECEIVE   = $DEFAULT                                                      ;
  $EUID      = $this -> Uuid                                                 ;
  $PQ        = ParameterQuery::NewParameter                                  (
                                    71                                       ,
                                    47                                       ,
                                    "ReceiveMessage"                       ) ;
  $RMC       = $PQ -> Fetch       ( $DB , "value" , $EUID , $PUID          ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                              ( strlen ( $RMC ) > 0                    ) {
    $RECEIVE = intval             ( $RMC , 10                              ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $RECEIVE                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function setReceiveMessage ( $DB , $PUID , $RECEIVE                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $PAMTAB = $GLOBALS [ "TableMapping" ] [ "Parameters" ]                     ;
  $PQ     = ParameterQuery::NewParameter ( 71 , 47 , "ReceiveMessage"      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DB    -> LockWrites            ( [ $PAMTAB                            ] ) ;
  $PQ    -> assureValue           ( $DB , $this -> Uuid , $PUID , $RECEIVE ) ;
  $DB    -> UnlockTables          (                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function getAllowOnClasses ( $DB , $PUID , $DEFAULT = 1             ) {
  ////////////////////////////////////////////////////////////////////////////
  $RECEIVE   = $DEFAULT                                                      ;
  $EUID      = $this -> Uuid                                                 ;
  $PQ        = ParameterQuery::NewParameter                                  (
                                    71                                       ,
                                    53                                       ,
                                    "AllowOnClasses"                       ) ;
  $RMC       = $PQ -> Fetch       ( $DB , "value" , $EUID , $PUID          ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                              ( strlen ( $RMC ) > 0                    ) {
    $RECEIVE = intval             ( $RMC , 10                              ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $RECEIVE                                                            ;
}
//////////////////////////////////////////////////////////////////////////////
public function setAllowOnClasses ( $DB , $PUID , $ALLOW                   ) {
  ////////////////////////////////////////////////////////////////////////////
  $PAMTAB = $GLOBALS [ "TableMapping" ] [ "Parameters" ]                     ;
  $PQ     = ParameterQuery::NewParameter ( 71 , 53 , "AllowOnClasses"      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DB    -> LockWrites            ( [ $PAMTAB                            ] ) ;
  $PQ    -> assureValue           ( $DB , $this -> Uuid , $PUID , $ALLOW   ) ;
  $DB    -> UnlockTables          (                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetCONFs              ( $DB                                  ,
                                        $PROPTAB                             ,
                                        $PUID                                ,
                                        $RECEIVE                             ,
                                        $ALLOW = 1                         ) {
  ////////////////////////////////////////////////////////////////////////////
  $PRTS  = $this -> GetProperties     ( $DB , $PROPTAB                     ) ;
  $RECV  = $this -> getReceiveMessage ( $DB ,            $PUID , $RECEIVE  ) ;
  $ALLOW = $this -> getAllowOnClasses ( $DB ,            $PUID , $ALLOW    ) ;
  $this -> Properties [ "Shareable" ] = $PRTS [ "Shareable"                ] ;
  $this -> Properties [ "Confirm"   ] = $PRTS [ "Confirm"                  ] ;
  $this -> Properties [ "Receive"   ] = $RECV                                ;
  $this -> Properties [ "OnClasses" ] = $ALLOW                               ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public function GetProperty  ( $KEY , $DEFAULT = 0                         ) {
  ////////////////////////////////////////////////////////////////////////////
  if                         ( ! in_array ( $KEY , $this -> Properties )   ) {
    return $DEFAULT                                                          ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $this -> Properties [ $KEY                                        ] ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
