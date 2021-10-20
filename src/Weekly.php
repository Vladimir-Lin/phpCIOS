<?php
//////////////////////////////////////////////////////////////////////////////
// 每周時段規劃元件
// 與TimeSlot時段元件搭配使用
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class Weekly                                                                 {
//////////////////////////////////////////////////////////////////////////////
public $TimeSlots                                                            ;
public $Minutes                                                              ;
//////////////////////////////////////////////////////////////////////////////
function __construct ( )                                                     {
  $this -> Clear     ( )                                                     ;
}
//////////////////////////////////////////////////////////////////////////////
function __destruct ( )                                                      {
}
//////////////////////////////////////////////////////////////////////////////
// 原始設定
// 每周七天
// 每天1440分鐘
// 總計:7*1440= 10080分鐘
// 周基準分:10080
// 周基準秒:7*86400=604800
//////////////////////////////////////////////////////////////////////////////
public function Clear ( )                                                    {
  $this -> TimeSlots = array ( )                                             ;
  $this -> Minutes   = array ( )                                             ;
  for ( $i = 0 ; $i < 10080 ; $i++ )                                         {
    $this -> Minutes [ $i ] = 0                                              ;
  }                                                                          ;
}
//////////////////////////////////////////////////////////////////////////////
// 從小時列表文字來指定整周時段狀態
// 參數:
//   HOURS  : 文字 => "12,78,152"
//     每周小時總數7*24=168
//     範圍0~167
//   STATES : 時段狀態值
//////////////////////////////////////////////////////////////////////////////
public function FillHours    ( $HOURS , $STATES         )                    {
  ////////////////////////////////////////////////////////////////////////////
  $HX = explode              ( "," , $HOURS             )                    ;
  unset                      ( $this -> TimeSlots       )                    ;
  $this -> TimeSlots = array (                          )                    ;
  ////////////////////////////////////////////////////////////////////////////
  if                         ( strlen ( $HOURS ) <= 0   ) return             ;
  if                         ( count  ( $HX    ) <= 0   ) return             ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                    ( $HX as $v                )                    {
    //////////////////////////////////////////////////////////////////////////
    $MI  = intval            ( $v         , 10          )                    ;
    $MI  = intval            ( $MI * 3600 , 10          )                    ;
    $TS  = new TimeSlot      (                          )                    ;
    $TS -> States = $STATES                                                  ;
    $TS -> Start  = $MI                                                      ;
    $TS -> setInterval       ( 3599                     )                    ;
    array_push               ( $this -> TimeSlots , $TS )                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
// 指定日期時段數量總計
// 參數:
//   DAY : 0 ~ 6
//     0 : 星期一
//     1 : 星期二
//     2 : 星期三
//     3 : 星期四
//     4 : 星期五
//     5 : 星期六
//     6 : 星期日
// 返回值: 當日時段數量總計
//////////////////////////////////////////////////////////////////////////////
public function DayCounts ( $DAY                                           ) {
  ////////////////////////////////////////////////////////////////////////////
  $DC = 0                                                                    ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                 ( $this -> TimeSlots as $ts                      ) {
    if                    ( $DAY == $ts -> Day ( )                         ) {
      $DC = $DC + 1                                                          ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $DC                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
// 指定日期時段數量總計
// 參數:
//   DAY   : 0 ~ 6
//   SLOTS : 每周基準分鐘列表 [ 3520 , 14320 , ... ]
// 返回值: 當日時段數量總計
//////////////////////////////////////////////////////////////////////////////
public function SlotCounts ( $DAY , $SLOTS                                 ) {
  ////////////////////////////////////////////////////////////////////////////
  $DC     = 0                                                                ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                  ( $SLOTS as $ts                                 ) {
    $D    = intval         ( $ts / 1440 , 10                               ) ;
    if                     ( $DAY == $D                                    ) {
      $DC = $DC + 1                                                          ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $DC                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
// 將指定日期時段轉換成JSON
// 參數:
//   DAY : 0 ~ 6
// 返回值: 當日時段JSON
//////////////////////////////////////////////////////////////////////////////
public function toWeeklyJSON  ( $DAY                                       ) {
  ////////////////////////////////////////////////////////////////////////////
  $DL    = array              (                                            ) ;
  ////////////////////////////////////////////////////////////////////////////
  foreach                     ( $this -> TimeSlots as $ts                  ) {
    if                        ( $DAY == $ts -> Day ( )                     ) {
      $LINE = $ts -> toWeekly (                                            ) ;
      array_push              ( $DL   , $LINE                              ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $LINEX = implode            ( ",\n" , $DL                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $WJSL  = "{\n  \"day\":\"{$DAY}\",\n  \"periods\": [\n{$LINEX}\n  ]\n}"    ;
  ////////////////////////////////////////////////////////////////////////////
  return $WJSL                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
// 將所有時段依照日期次序轉換成JSON
// 返回值: 周時段JSON
//////////////////////////////////////////////////////////////////////////////
public function toWeekly            (                                      ) {
  ////////////////////////////////////////////////////////////////////////////
  $DL       = array                 (                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  for                               ( $i = 0 ; $i < 7 ; $i++               ) {
    $DC     = $this -> DayCounts    ( $i                                   ) ;
    if                              ( $DC > 0                              ) {
      $LINE = $this -> toWeeklyJSON ( $i                                   ) ;
      array_push                    ( $DL , $LINE                          ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $LINEX    = implode               ( ",\n" , $DL                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $LINEX                                                              ;
}
//////////////////////////////////////////////////////////////////////////////
// 讀取時段表
// 參數:
//   TABLE : 時段表資料庫表格
//   PUID  : 人物長編號
//   RUID  : 角色長編號
// 返回值:
//   true  : 成功讀取
//   false : 讀取失敗
//////////////////////////////////////////////////////////////////////////////
public function Obtains      ( $DB , $TABLE , $PUID , $RUID                ) {
  ////////////////////////////////////////////////////////////////////////////
  unset                      ( $this -> TimeSlots                          ) ;
  $this -> TimeSlots = array (                                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ    = "select `start`,`end`,`states` from {$TABLE}"                     .
           " where `uuid` = {$PUID} and `acting` = {$RUID}"                  .
           " order by `start` asc ;"                                         ;
  $qq    = $DB -> Query ( $QQ )                                              ;
  if                         ( ! $DB -> hasResult ( $qq )                  ) {
    return false                                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  while                      ( $rr = $qq -> fetch_array ( MYSQLI_BOTH )    ) {
    $TS  = new TimeSlot      (                                             ) ;
    $TS -> obtain            ( $rr                                         ) ;
    array_push               ( $this -> TimeSlots , $TS                    ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return true                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
// 更新時段表
// 參數:
//   TABLE : 時段表資料庫表格
//   PUID  : 人物長編號
//   RUID  : 角色長編號
//////////////////////////////////////////////////////////////////////////////
public function Update  ( $DB , $TABLE , $PUID , $RUID                     ) {
  ////////////////////////////////////////////////////////////////////////////
  $DB      -> LockWrite ( $TABLE                                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ       = "delete from {$TABLE}"                                         .
              " where `uuid` = {$PUID} and `acting` = {$RUID} ;"             ;
  $DB      -> Query     ( $QQ                                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  foreach               ( $this -> TimeSlots as $ts                        ) {
    $START  = $ts -> Start                                                   ;
    $END    = $ts -> End                                                     ;
    $STATES = $ts -> States                                                  ;
    $QQ     = "insert into {$TABLE}"                                         .
              " (`uuid`,`acting`,`start`,`end`,`states`)"                    .
              " values"                                                      .
              " ( {$PUID} , {$RUID} , {$START} , {$END} , {$STATES} ) ;"     ;
     $DB   -> Query     ( $QQ                                              ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $DB -> UnlockTables   ( $TABLE                                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
// 判斷時段是否存在
// 參數:
//   T     : 周基準秒
// 返回值:
//   true  : 存在時段
//   false : 時段不存在
//////////////////////////////////////////////////////////////////////////////
public function Occupied ( $T                                              ) {
  foreach                ( $this -> TimeSlots as $ts                       ) {
    if                   ( $ts -> Between ( $T ) == 0                      ) {
      return true                                                            ;
    }                                                                        ;
  }                                                                          ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
// 將時段從每秒基準轉換成每周基準分鐘列表
// 返回值: 每周基準分鐘列表
//   [ 3520 , 14320 , ... ]
//////////////////////////////////////////////////////////////////////////////
public function toMinuteIndexes (                                          ) {
  $MI = array                   (                                          ) ;
  foreach                       ( $this -> TimeSlots as $ts                ) {
    array_push                  ( $MI , $ts -> MinuteIndex ( )             ) ;
  }                                                                          ;
  return $MI                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
