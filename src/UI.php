<?php
//////////////////////////////////////////////////////////////////////////////
namespace CIOS                                                               ;
//////////////////////////////////////////////////////////////////////////////
class UI                                                                     {
//////////////////////////////////////////////////////////////////////////////
public static function AppendCheckMark ( $CID , $CHECKED , $JSC , $MSG )     {
  $LVL    = new Html          (                           )                  ;
  $LVL   -> setTag            ( "label"                   )                  ;
  $LVL   -> AddPair           ( "class"    , "CheckBlock" )                  ;
  $INP    = $LVL  -> addInput (                           )                  ;
  $INP   -> AddPair           ( "type"     , "checkbox"   )                  ;
  if                          ( $CHECKED                  )                  {
    $INP -> AddMember         ( "checked"                 )                  ;
  }                                                                          ;
  $INP   -> SafePair          ( "id"       , $CID         )                  ;
  $INP   -> SafePair          ( "onchange" , $JSC         )                  ;
  $SPN    = $LVL  -> addSpan  (                           )                  ;
  $SPN   -> AddPair           ( "class"    , "CheckMark"  )                  ;
  $LVL   -> AddText           ( $MSG                      )                  ;
  return $LVL                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsEditorDB ( $DBX , $CONFs                    ) {
  ////////////////////////////////////////////////////////////////////////////
  if                                    ( isset ( $CONFs  [ "SORT"     ] ) ) {
    $SORT     = $CONFs  [ "SORT"     ]                                       ;
  } else                                                                     {
    $SORT     = "id"                                                         ;
  }                                                                          ;
  $EDIT       = $CONFs  [ "Edit"     ]                                       ;
  $DELETE     = $CONFs  [ "Delete"   ]                                       ;
  $ADD        = $CONFs  [ "Add"      ]                                       ;
  $REMOVE     = $CONFs  [ "Remove"   ]                                       ;
  $CLASSID    = $CONFs  [ "Class"    ]                                       ;
  if                                    ( isset ( $CONFs  [ "DIV"      ] ) ) {
    $DIVID    = $CONFs  [ "DIV"      ]                                       ;
  } else                                                                     {
    $DIVID    = ""                                                           ;
  }                                                                          ;
  if                                    ( isset ( $CONFs  [ "Editor"   ] ) ) {
    $EDITOR   = $CONFs  [ "Editor"   ]                                       ;
  } else                                                                     {
    $EDITOR   = ""                                                           ;
  }                                                                          ;
  $ITEMCLASS  = $CONFs  [ "Item"     ]                                       ;
  $VALUECLASS = $CONFs  [ "Value"    ]                                       ;
  if                                    ( isset ( $CONFs  [ "Content"  ] ) ) {
    $CONTENT  = $CONFs  [ "Content"  ]                                       ;
  } else                                                                     {
    $CONTENT  = ""                                                           ;
  }                                                                          ;
  $TABLES     = $CONFs  [ "Tables"   ]                                       ;
  $SETAB      = $TABLES [ "Settings" ]                                       ;
  ////////////////////////////////////////////////////////////////////////////
  if ( strlen ( $SORT ) <= 0 ) $SORT = "id"                                  ;
  $CONTENT    = trim                    ( $CONTENT                         ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                                    ( strlen ( $DIVID ) > 0            ) {
    $DIV   = new Html                   (                                  ) ;
    $DIV  -> setDiv                     ( "" , $DIVID , $CLASSID           ) ;
    //////////////////////////////////////////////////////////////////////////
    if                                  ( strlen ( $CONTENT ) > 0          ) {
      $HD  = $DIV   -> AddText          ( $CONTENT                         ) ;
    }                                                                        ;
    $TABLE = $DIV   -> addHtml          (                                  ) ;
    $ROOT  = $DIV                                                            ;
  } else                                                                     {
    $TABLE = new Html                   (                                  ) ;
    $ROOT  = $TABLE                                                          ;
  }                                                                          ;
  $TBODY   = $TABLE -> ConfigureTable   ( 1 , 1 , 1                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR      = $TBODY -> addTr            (                                  ) ;
  if                                    ( $EDIT                            ) {
    $HD    = $HR    -> addTd            (                                  ) ;
    $HD   -> Compact                    (                                  ) ;
  }                                                                          ;
  $HD      = $HR    -> addTd            ( "Id"                             ) ;
  $HD     -> Compact                    (                                  ) ;
  $HD      = $HR    -> addTd            ( "Username"                       ) ;
  $HD     -> Compact                    (                                  ) ;
  $HD      = $HR    -> addTd            ( "Scope"                          ) ;
  $HD     -> Compact                    (                                  ) ;
  $HD      = $HR    -> addTd            ( "Keyword"                        ) ;
  $HD     -> Compact                    (                                  ) ;
  $HD      = $HR    -> addTd            ( "Value"                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                                    ( $EDIT                            ) {
    //////////////////////////////////////////////////////////////////////////
    $HR      = $TBODY -> addTr          (                                  ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD      = $HR    -> addTd          (                                  ) ;
    $JSC     = "AddSettingItem('{$EDITOR}')"                                 ;
    $BTN     = $HD    -> addButton      (                                  ) ;
    $BTN    -> AddPair                  ( "onclick" , $JSC                 ) ;
    $IMG     = $BTN   -> addHtml        ( "img"                            ) ;
    $IMG    -> AddPair                  ( "src" , $ADD                     ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD      = $HR    -> addTd          (                                  ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD      = $HR    -> addTd          (                                  ) ;
    $INP     = $HD    -> addInput       (                                  ) ;
    $INP    -> AddPair                  ( "id"    , "SettingsUsername"     ) ;
    $INP    -> SafePair                 ( "class" , $ITEMCLASS             ) ;
    $INP    -> AddPair                  ( "placeholder" , "username"       ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD      = $HR    -> addTd          (                                  ) ;
    $INP     = $HD    -> addInput       (                                  ) ;
    $INP    -> AddPair                  ( "id"    , "SettingsScope"        ) ;
    $INP    -> SafePair                 ( "class" , $ITEMCLASS             ) ;
    $INP    -> AddPair                  ( "placeholder" , "scope"          ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD      = $HR    -> addTd          (                                  ) ;
    $INP     = $HD    -> addInput       (                                  ) ;
    $INP    -> AddPair                  ( "id"    , "SettingsKeyword"      ) ;
    $INP    -> SafePair                 ( "class" , $ITEMCLASS             ) ;
    $INP    -> AddPair                  ( "placeholder" , "keyword"        ) ;
    //////////////////////////////////////////////////////////////////////////
    $HD      = $HR    -> addTd          (                                  ) ;
    $INP     = $HD    -> addInput       (                                  ) ;
    $INP    -> AddPair                  ( "id"    , "SettingsValue"        ) ;
    $INP    -> SafePair                 ( "class" , $VALUECLASS            ) ;
    $INP    -> AddPair                  ( "placeholder" , "value"          ) ;
    //////////////////////////////////////////////////////////////////////////
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $QQ = "select `id`,`username`,`scope`,`keyword`,`value` from {$SETAB}"     .
        " order by `{$SORT}` asc ;"                                          ;
  $qq = $DBX -> Query                   ( $QQ                              ) ;
  if                                    ( $DBX -> hasResult ( $qq )        ) {
    while ( $rr = $qq -> fetch_array  ( MYSQLI_BOTH ) )                      {
      ////////////////////////////////////////////////////////////////////////
      $IDXX    = $rr [ "id"       ]                                          ;
      $USER    = $rr [ "username" ]                                          ;
      $SCOPE   = $rr [ "scope"    ]                                          ;
      $KEYWORD = $rr [ "keyword"  ]                                          ;
      $VALUE   = $rr [ "value"    ]                                          ;
      ////////////////////////////////////////////////////////////////////////
      $HR      = $TBODY -> addTr        (                                  ) ;
      if                                ( $EDIT                            ) {
        $HD    = $HR    -> addTd        (                                  ) ;
      }                                                                      ;
      if                                ( $DELETE                          ) {
        $JSC   = "DeleteSettingItem('{$EDITOR}',{$IDXX})"                    ;
        $BTN   = $HD    -> addButton    (                                  ) ;
        $BTN  -> AddPair                ( "onclick" , $JSC                 ) ;
        $IMG   = $BTN   -> addHtml      ( "img"                            ) ;
        $IMG  -> AddPair                ( "src"     , $REMOVE              ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
      $HD      = $HR    -> addTd        ( $IDXX                            ) ;
      $HD     -> AddPair                ( "align" , "right"                ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD      = $HR    -> addTd        ( $USER                            ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD      = $HR    -> addTd        ( $SCOPE                           ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD      = $HR    -> addTd        ( $KEYWORD                         ) ;
      ////////////////////////////////////////////////////////////////////////
      $HD      = $HR    -> addTd        (                                  ) ;
      if                                ( $EDIT                            ) {
        $JSC   = "UpdateSettingItem({$IDXX},this.value)"                     ;
        $INP   = $HD    -> addInput     (                                  ) ;
        $INP  -> SafePair               ( "class"    , $VALUECLASS         ) ;
        $INP  -> AddPair                ( "onchange" , $JSC                ) ;
        $INP  -> AddPair                ( "value"    , $VALUE              ) ;
      } else                                                                 {
        $HD   -> AddText                ( $VALUE                           ) ;
      }                                                                      ;
      ////////////////////////////////////////////////////////////////////////
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $ROOT -> Content               (                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsEditor   ( $CONFs                           ) {
  ////////////////////////////////////////////////////////////////////////////
  $HOST    = $CONFs  [ "Host"     ]                                          ;
  $HTML    = ""                                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX     = new DB                    (                                   ) ;
  if                                   ( ! $DBX -> Connect ( $HOST )       ) {
    return $DBX -> ConnectionError     (                                   ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HTML    = self::SettingsEditorDB    ( $DBX , $CONFs                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX    -> Close                     (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTML                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsCheckBoxDB ( $DBX , $CONFs                  ) {
  ////////////////////////////////////////////////////////////////////////////
  $DIVID      = $CONFs  [ "Editor"   ]                                       ;
  if                                    ( isset ( $CONFs  [ "Content"  ] ) ) {
    $CONTENT  = $CONFs  [ "Content"  ]                                       ;
  } else                                                                     {
    $CONTENT  = ""                                                           ;
  }                                                                          ;
  $TABLES     = $CONFs  [ "Tables"   ]                                       ;
  $SETAB      = $TABLES [ "Settings" ]                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $SETS       = new Settings (                                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  $USERNAME   = $CONFs  [ "Username" ]                                       ;
  $SCOPE      = $CONFs  [ "Scope"    ]                                       ;
  $KEYWORD    = $CONFs  [ "Keyword"  ]                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $SETS      -> set          ( "Username" , $USERNAME                      ) ;
  $SETS      -> set          ( "Scope"    , $SCOPE                         ) ;
  $SETS      -> set          ( "Keyword"  , $KEYWORD                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $VALUE      = $SETS -> obtainValue ( $DBX , $SETAB                       ) ;
  $ENABLE     = ( ( $VALUE == 0 ) or ( $VALUE = "0" ) ) ? false : true       ;
  $JSC        = "SettingsTriggerEnable('{$USERNAME}','{$SCOPE}','{$KEYWORD}',this.checked)" ;
  $ROOT       = self::AppendCheckMark ( $DIVID , $ENABLE , $JSC , $CONTENT ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $ROOT -> Content               (                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsCheckBox ( $CONFs                           ) {
  ////////////////////////////////////////////////////////////////////////////
  $HOST    = $CONFs  [ "Host"     ]                                          ;
  $HTML    = ""                                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX     = new DB                    (                                   ) ;
  if                                   ( ! $DBX -> Connect ( $HOST )       ) {
    return $DBX -> ConnectionError     (                                   ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HTML    = self::SettingsCheckBoxDB  ( $DBX , $CONFs                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX    -> Close                     (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTML                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function isYouTube       ( $URL                              ) {
  $YOUTUBE = "https://www.youtube.com/watch?v="                              ;
  if ( strpos ( $URL , $YOUTUBE ) !== false ) return true                    ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function YouTubeID       ( $URL                              ) {
  $YOUTUBE = "https://www.youtube.com/watch?v="                              ;
  $UID     = str_replace               ( $YOUTUBE , "" , $URL              ) ;
  $LEN     = strlen                    ( $UID                              ) ;
  if ( $LEN != 11 ) return ""                                                ;
  return $UID                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function iFrameYouTube   ( $UID , $EXTRAS = ""               ) {
  $URL     = "https://www.youtube.com/embed/{$UID}{$EXTRAS}"                 ;
  $ALLOW   = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" ;
  $IFRAME  = new Html                  (                                   ) ;
  $IFRAME -> setTag                    ( "iframe"                          ) ;
  $IFRAME -> AddPair                   ( "src"         , $URL              ) ;
  $IFRAME -> AddPair                   ( "frameborder" , "0"               ) ;
  $IFRAME -> AddPair                   ( "allow"       , $ALLOW            ) ;
  $IFRAME -> AddMember                 ( "allowfullscreen"                 ) ;
  return $IFRAME                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
public static function isLoom          ( $URL                              ) {
  $LOOM    = "https://www.loom.com/share/"                                   ;
  if ( strpos ( $URL , $LOOM ) !== false ) return true                       ;
  return false                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function LoomID          ( $URL                              ) {
  $LOOM    = "https://www.loom.com/share/"                                   ;
  $UID     = str_replace               ( $LOOM , "" , $URL                 ) ;
  $LEN     = strlen                    ( $UID                              ) ;
  if ( $LEN != 32 ) return ""                                                ;
  return $UID                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function iFrameLoom      ( $LID , $EXTRAS = ""               ) {
  $URL     = "https://www.loom.com/embed/{$LID}{$EXTRAS}"                    ;
  $ALLOW   = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" ;
  $IFRAME  = new Html                  (                                   ) ;
  $IFRAME -> setTag                    ( "iframe"                          ) ;
  $IFRAME -> AddPair                   ( "src"         , $URL              ) ;
  $IFRAME -> AddPair                   ( "frameborder" , "0"               ) ;
  $IFRAME -> AddPair                   ( "allow"       , $ALLOW            ) ;
  $IFRAME -> AddMember                 ( "allowfullscreen"                 ) ;
  return $IFRAME                                                             ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
