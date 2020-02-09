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
public static function AppendInputLine ( $TYPE , $VALUE , $JSC , $MSG )      {
  $DIV    = new Html          (                     )                        ;
  $DIV   -> setDiv            ( $MSG , "" , ""      )                        ;
  $INP    = $DIV  -> addInput (                     )                        ;
  $INP   -> AddPair           ( "type"     , $TYPE  )                        ;
  $INP   -> AddPair           ( "value"    , $VALUE )                        ;
  $INP   -> SafePair          ( "onchange" , $JSC   )                        ;
  return $DIV                                                                ;
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
public static function SettingsInputValueDB ( $DBX , $CONFs                ) {
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
  $JSC        = "SettingsInputValue('{$USERNAME}','{$SCOPE}','{$KEYWORD}',this.value)" ;
  $ROOT       = self::AppendInputLine ( "number" , $VALUE , $JSC , $CONTENT ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $ROOT -> Content               (                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsInputValue ( $CONFs                         ) {
  ////////////////////////////////////////////////////////////////////////////
  $HOST    = $CONFs  [ "Host"     ]                                          ;
  $HTML    = ""                                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX     = new DB                       (                                ) ;
  if                                      ( ! $DBX -> Connect ( $HOST )    ) {
    return $DBX -> ConnectionError        (                                ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HTML    = self::SettingsInputValueDB  ( $DBX , $CONFs                     ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX    -> Close                     (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTML                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsInputTextDB ( $DBX , $CONFs                 ) {
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
  $JSC        = "SettingsInputValue('{$USERNAME}','{$SCOPE}','{$KEYWORD}',this.value)" ;
  $ROOT       = self::AppendInputLine ( "text" , $VALUE , $JSC , $CONTENT  ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $ROOT -> Content               (                                  ) ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingsInputText ( $CONFs                          ) {
  ////////////////////////////////////////////////////////////////////////////
  $HOST    = $CONFs  [ "Host"     ]                                          ;
  $HTML    = ""                                                              ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX     = new DB                      (                                 ) ;
  if                                     ( ! $DBX -> Connect ( $HOST )     ) {
    return $DBX -> ConnectionError       (                                 ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HTML    = self::SettingsInputTextDB   ( $DBX , $CONFs                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $DBX    -> Close                       (                                 ) ;
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
public static function IconPath    ( $ICONPATH,$DID,$WIDTH=128,$HEIGHT=128 ) {
  $SRC = "{$ICONPATH}?ID={$DID}&Width={$WIDTH}&Height={$HEIGHT}"             ;
  $HI  = new Html (                    )                                     ;
  $HI -> setTag   ( "img"              )                                     ;
  $HI -> AddPair  ( "width"  , $WIDTH  )                                     ;
  $HI -> AddPair  ( "height" , $HEIGHT )                                     ;
  $HI -> AddPair  ( "src"    , $SRC    )                                     ;
  return $HI                                                                 ;
}
//////////////////////////////////////////////////////////////////////////////
public static function SettingValue ( $DB , $KEY )                           {
  $SETAB  = $GLOBALS [ "TableMapping" ] [ "Settings" ]                       ;
  $SS     = new Settings          (                                        ) ;
  $SS    -> setIndex              ( "Debugger" , "Students" , $KEY         ) ;
  $Beta   = $SS    -> obtainValue ( $DB , $SETAB                           ) ;
  if                              ( strlen ( $Beta ) > 0                   ) {
    $Beta = intval                ( $Beta , 10                             ) ;
  }                                                                          ;
  return $Beta                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function CreateClickMenu ( $JSC )                              {
  ////////////////////////////////////////////////////////////////////////////
  $IMG  = new Html (                                                       ) ;
  $IMG -> setTag   ( "img"                                                 ) ;
  $IMG -> AddPair  ( "src"           , "/images/24x24/Menu.png"            ) ;
  $IMG -> AddPair  ( "onclick"       , $JSC                                ) ;
  $IMG -> AddPair  ( "oncontextmenu" , $JSC                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $IMG                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function CreateJsonMenu ( $JSC )                               {
  ////////////////////////////////////////////////////////////////////////////
  $IMG = self::CreateClickMenu ( $JSC                                      ) ;
  $HBX = $IMG -> Content       (                                           ) ;
  $HBX = str_replace           ( "\n" , ""       , $HBX                    ) ;
  $HBX = str_replace           ( "\"" , "\\\""   , $HBX                    ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HBX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function ListNote ( $PREFER                                    ,
                                  $TEXT                                      ,
                                  $PRIME                                     ,
                                  $PHT                                       ,
                                  $INPCLASS = "NameInput"                  ) {
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $IDX = ""                                                                  ;
  if ( $PREFER < 0 )                                                         {
    $IDX = "{$PRIME}-X"                                                      ;
  } else                                                                     {
    $IDX = "{$PRIME}-{$PREFER}"                                              ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $HZX  = new Html  (                                                      ) ;
  $HZX -> setInput  (                                                      ) ;
  $HZX -> AddPair   ( "size"  , "120"                                      ) ;
  $HZX -> AddPair   ( "id"    , $IDX                                       ) ;
  $HZX -> SafePair  ( "class" , $INPCLASS                                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                ( strlen ( $TEXT ) > 0                                 ) {
    $HZX -> AddPair ( "value"       , $TEXT                                ) ;
  } else                                                                     {
    $HZX -> AddPair ( "placeholder" , $PHT                                 ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $HZX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function NotesEditor ( $DB                                     ,
                                     $PFX                                    ,
                                     $UUID                                   ,
                                     $JAVA                                   ,
                                     $TABLE                                  ,
                                     $NAME                                   ,
                                     $PRIME                                  ,
                                     $PHT                                    ,
                                     $INPCLASS = "NameInput"               ) {
  ////////////////////////////////////////////////////////////////////////////
  $PPP = "{$PRIME}-{$UUID}"                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  $NI  = new Note             (                                            ) ;
  $NI -> setOwner             ( $UUID , $NAME                              ) ;
  $IDs = $NI -> ObtainMaps    ( $DB   , $TABLE                             ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                          ( count ( $IDs ) > 0                         ) {
    $PREFERs = array_keys     (         $IDs                               ) ;
    foreach                   ( $PREFERs as $id                            ) {
      $OCF   = str_replace    ( "$(PREFER)" , $id , $JAVA                  ) ;
      $MLN   = self::ListNote ( $id                                          ,
                                $IDs [ $id ]                                 ,
                                $PPP                                         ,
                                $PHT                                         ,
                                $INPCLASS                                  ) ;
      $MLN  -> AddPair        ( "onchange"    , $OCF                       ) ;
      $PFX  -> AddTag         ( $MLN                                       ) ;
    }                                                                        ;
    unset                     ( $PREFERs                                   ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $OCF       = str_replace    ( "$(PREFER)" , -1 , $JAVA                   ) ;
  $MLN       = self::ListNote ( -1 , "" , $PPP , $PHT , $INPCLASS          ) ;
  $MLN      -> AddPair        ( "onchange"    , $OCF                       ) ;
  $PFX      -> AddTag         ( $MLN                                       ) ;
  ////////////////////////////////////////////////////////////////////////////
  unset                       ( $IDs                                       ) ;
  unset                       ( $NI                                        ) ;
  ////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
public static function MaterialTable ( $DB                                   ,
                                       $TABLE                                ,
                                       $KEY                                  ,
                                       $UUID                                 ,
                                       $INPCLASS = "NameInput"             ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $PHT  = $Translations [ "Chapter::NewMaterial" ]                           ;
  $JAVA = "MaterialsChanged(this.value,$(PREFER),'{$UUID}','{$KEY}','{$INPCLASS}') ;" ;
  $PFX  = new Html  (                                                      ) ;
  $PFX -> setType   ( 4                                                    ) ;
  self::NotesEditor ( $DB                                                    ,
                      $PFX                                                   ,
                      $UUID                                                  ,
                      $JAVA                                                  ,
                      $TABLE                                                 ,
                      "URL"                                                  ,
                      "LessonMaterials"                                      ,
                      $PHT                                                   ,
                      $INPCLASS                                            ) ;
  return $PFX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function DocumentTable ( $DB                                   ,
                                       $TABLE                                ,
                                       $KEY                                  ,
                                       $UUID                                 ,
                                       $INPCLASS = "NameInput"             ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $PHT  = $Translations [ "Chapter::NewMaterial" ]                           ;
  $JAVA = "DocumentsChanged(this.value,$(PREFER),'{$UUID}','{$KEY}','{$INPCLASS}') ;" ;
  $PFX  = new Html  (                                                      ) ;
  $PFX -> setType   ( 4                                                    ) ;
  self::NotesEditor ( $DB                                                    ,
                      $PFX                                                   ,
                      $UUID                                                  ,
                      $JAVA                                                  ,
                      $TABLE                                                 ,
                      "Document"                                             ,
                      "LessonMaterials"                                      ,
                      $PHT                                                   ,
                      $INPCLASS                                            ) ;
  return $PFX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function QuizletTable ( $DB                                    ,
                                      $TABLE                                 ,
                                      $KEY                                   ,
                                      $UUID                                  ,
                                      $INPCLASS = "NameInput"              ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $PHT  = $Translations [ "Chapter::NewQuizlet" ]                            ;
  $JAVA = "QuizletsChanged(this.value,$(PREFER),'{$UUID}','{$KEY}','{$INPCLASS}') ;" ;
  $PFX  = new Html  (                                                      ) ;
  $PFX -> setType   ( 4                                                    ) ;
  self::NotesEditor ( $DB                                                    ,
                      $PFX                                                   ,
                      $UUID                                                  ,
                      $JAVA                                                  ,
                      $TABLE                                                 ,
                      "Quizlet"                                              ,
                      "LessonQuizlet"                                        ,
                      $PHT                                                   ,
                      $INPCLASS                                            ) ;
  return $PFX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function FilmsTable ( $DB                                      ,
                                    $TABLE                                   ,
                                    $KEY                                     ,
                                    $UUID                                    ,
                                    $INPCLASS = "NameInput"                ) {
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $PHT  = $Translations [ "Chapter::NewFilm" ]                               ;
  $JAVA = "FilmUrlChanged(this.value,$(PREFER),'{$UUID}','{$KEY}','{$INPCLASS}') ;" ;
  $PFX  = new Html  (                                                      ) ;
  $PFX -> setType   ( 4                                                    ) ;
  self::NotesEditor ( $DB                                                    ,
                      $PFX                                                   ,
                      $UUID                                                  ,
                      $JAVA                                                  ,
                      $TABLE                                                 ,
                      "Film"                                                 ,
                      "LessonFilm"                                           ,
                      $PHT                                                   ,
                      $INPCLASS                                            ) ;
  return $PFX                                                                ;
}
//////////////////////////////////////////////////////////////////////////////
public static function PageInfo ( $MAPS )                                    {
  ////////////////////////////////////////////////////////////////////////////
  $QSVT            = ""                                                      ;
  if ( isset ( $_SERVER['QUERY_STRING'] )                                  ) {
    $QSVT          = $_SERVER['QUERY_STRING']                                ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $PIFS            = ""                                                      ;
  if ( isset ( $_SERVER['PATH_INFO'] )                                     ) {
    $PIFS          = $_SERVER['PATH_INFO']                                   ;
    $KKK           = "PathInfo = ''"                                         ;
    $VVV           = "PathInfo = '{$PIFS}'"                                  ;
    $MAPS [ $KKK ] = $VVV                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $RURL            = $GLOBALS [ "RootURL" ]                                  ;
  $KJ              = "RequestURL = ''"                                       ;
  $VJ              = "RequestURL = '{$RURL}'"                                ;
  $MAPS [ $KJ ]    = $VJ                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $PURL            = $RURL                                                   ;
  if ( strlen ( $QSVT ) > 0                                                ) {
    $QXSTR         = "?{$QSVT}"                                              ;
    $IDX           = strrpos     ( $PURL , $QXSTR                          ) ;
    if                           ( $IDX >= 0                               ) {
      $LENX        = strlen      ( $PURL                                   ) ;
      $QLEN        = strlen      ( $QXSTR                                  ) ;
      $PA          = substr      ( $PURL , 0 , $IDX                        ) ;
      $PB          = substr      ( $PURL , $IDX + $QLEN , $LENX - $QLEN    ) ;
      $PURL        = "{$PA}{$PB}"                                            ;
    }                                                                        ;
  }                                                                          ;
  $IDX             = strrpos     ( $RURL , $PIFS                           ) ;
  if                             ( $IDX >= 0                               ) {
    $LENX          = strlen      ( $PURL                                   ) ;
    $QLEN          = strlen      ( $PIFS                                   ) ;
    $PA            = substr      ( $PURL , 0 , $IDX                        ) ;
    $PB            = substr      ( $PURL , $IDX + $QLEN , $LENX - $QLEN    ) ;
    $PURL          = "{$PA}{$PB}"                                            ;
  }                                                                          ;
  $KJ              = "PageURL = ''"                                          ;
  $VJ              = "PageURL = '{$PURL}'"                                   ;
  $MAPS [ $KJ ]    = $VJ                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $SITE            = Browser::SitePath ( )                                   ;
  $KJ              = "SitePath = ''"                                         ;
  $VJ              = "SitePath = '{$SITE}'"                                  ;
  $MAPS [ $KJ ]    = $VJ                                                     ;
  ////////////////////////////////////////////////////////////////////////////
  if ( isset ( $_SERVER['PHP_SELF'] )                                      ) {
    $PHPSELF       = $_SERVER['PHP_SELF']                                    ;
    $KKK           = "PageSelf = ''"                                         ;
    $VVV           = "PageSelf = '{$PHPSELF}'"                               ;
    $MAPS [ $KKK ] = $VVV                                                    ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return $MAPS                                                               ;
}
//////////////////////////////////////////////////////////////////////////////
public static function GenerateCheckBoxItem   ( $TEMPL                       ,
                                                $MSG                         ,
                                                $CID                         ,
                                                $CHECKED                     ,
                                                $JAVA                      ) {
  ////////////////////////////////////////////////////////////////////////////
  $CHECK = ""                                                                ;
  if ( $CHECKED ) $CHECK = " checked"                                        ;
  ////////////////////////////////////////////////////////////////////////////
  $MAPS  = array                                                             (
    "$(CHECK-ITEM-ID)"      => $CID                                          ,
    "$(CHECK-ITEM-NAME)"    => $MSG                                          ,
    "$(CHECK-ITEM-CHECKED)" => $CHECK                                        ,
    "$(CHECK-ITEM-JAVA)"    => $JAVA                                         ,
  )                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  return Strings::ReplaceByKeys ( $TEMPL , $MAPS                           ) ;
}
//////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////
?>
