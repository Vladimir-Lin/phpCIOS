<?php

namespace CIOS                                     ;
use Intervention\Image\ImageManagerStatic as Image ;

class Picture
{

public $Uuid          ;
public $Width         ;
public $Height        ;
public $MIME          ;
public $Suffix        ;
public $Image         ;
public $Icon          ;
public $Checksum      ;
public $Raw           ;
public $IconRaw       ;
public $FileSize      ;
public $Filename      ;
public $Upload        ;
public $Removal       ;
public $CheckSize     ;
public $MaxLimit      ;
public $PictureOrders ;
public $PictureTable  ;
public $PictureDepot  ;
public $ThumbTable    ;
public $ThumbDepot    ;
public $MainTable     ;
//////////////////////////////////////////////////////////////////////////////

public function __construct()
{
  $this -> Clear ( ) ;
}

public function __destruct()
{
}

public function Clear()
{
  $this -> Uuid          = 0                       ;
  $this -> Width         = 0                       ;
  $this -> Height        = 0                       ;
  $this -> MIME          = ""                      ;
  $this -> Suffix        = ""                      ;
  $this -> Image         = ""                      ;
  $this -> Icon          = ""                      ;
  $this -> Checksum      = 0                       ;
  $this -> Raw           = ""                      ;
  $this -> IconRaw       = ""                      ;
  $this -> FileSize      = -1                      ;
  $this -> Filename      = ""                      ;
  $this -> Upload        = ""                      ;
  $this -> Removal       = true                    ;
  $this -> CheckSize     = true                    ;
  $this -> MaxLimit      = 32 * 1024 * 1024        ;
  $this -> PictureOrders = "`erp`.`pictureorders`" ;
  $this -> PictureTable  = "`erp`.`pictures`"      ;
  $this -> PictureDepot  = "`erp`.`picturedepot`"  ;
  $this -> ThumbTable    = "`erp`.`thumbs`"        ;
  $this -> ThumbDepot    = "`erp`.`thumbdepot`"    ;
  $this -> MainTable     = "`erp`.`uuids`"         ;
}

public function GetUuid ( $DB )
{
  global $DataTypes                                                          ;
  $BASE         = "3800000000000000000"                                      ;
  $TYPE         = $DataTypes [ "Picture" ]                                   ;
  $this -> Uuid = $DB -> GetLast ( $this -> PictureTable , "uuid" , $BASE  ) ;
  if ( gmp_cmp ( $this -> Uuid , "0" ) == 0 ) return false                   ;
  $DB -> AddUuid    ( $this -> MainTable , $this -> Uuid , $TYPE )           ;
  $DB -> AppendUuid ( $this -> PictureOrders , $this -> Uuid )               ;
  $DB -> AppendUuid ( $this -> ThumbTable    , $this -> Uuid )               ;
  return $this -> Uuid                                                       ;
}

public function ObtainsUuid($DB)
{
  $QQ = "select `uuid` from {$this->PictureTable}"     .
        " where `filesize` = {$this->FileSize}"        .
          " and `checksum` = {$this->Checksum} ;"      .
          " ;"                                         ;
  $UU = $DB -> ObtainUuids ( $QQ )                     ;
  if ( count ( $UU ) <= 0 ) return false               ;
  //////////////////////////////////////////////////////
  $UX   = implode ( " , " , $UU )                      ;
  $QQ   = "select `uuid` from {$this -> PictureDepot}" .
          " where `uuid` in ( {$UX} )"                 .
          " and ( `file` = ? )"                        .
          " order by `ltime` desc ;"                   ;
  $qq   = $DB -> Prepare    ( $QQ                    ) ;
  $qq  -> bind_param        ( 's' , $this -> Raw     ) ;
  $qq  -> execute           (                        ) ;
  $kk   = $qq -> get_result (                        ) ;
  //////////////////////////////////////////////////////
  if ( $DB -> hasResult ( $kk ) )                      {
    $rr           = $kk -> fetch_array ( MYSQLI_BOTH ) ;
    $this -> Uuid = $rr [ 0 ]                          ;
    return true                                        ;
  }                                                    ;
  //////////////////////////////////////////////////////
  return false                                         ;
}

public function UpdateImage ( $DB )
{
  $QQ = "update {$this->PictureTable} set"          .
            " `suffix` = '{$this->Suffix}' ,"       .
          " `filesize` = {$this->FileSize} ,"       .
          " `checksum` = {$this->Checksum} ,"       .
             " `width` = {$this->Width} ,"          .
            " `height` = {$this->Height}"           .
        " where `uuid` = {$this->Uuid} ;"           ;
  $DB -> Query ( $QQ )                              ;
  ///////////////////////////////////////////////////
  $QQ   = "insert into {$this -> PictureDepot}"     .
          " ( `uuid` , `file` ) values"             .
          " ( {$this->Uuid} , ? ) ;"                ;
  $qq   = $DB -> Prepare ( $QQ                    ) ;
  $qq  -> bind_param     ( 's' , $this -> Raw     ) ;
  $qq  -> execute        (                        ) ;
}

public function UpdateThumb ( $DB )
{
  $ICONSIZE = strlen ( $this -> IconRaw )           ;
  $IWIDTH   = $this -> Icon -> width  ( )           ;
  $IHEIGHT  = $this -> Icon -> height ( )           ;
  $QQ = "update {$this->ThumbTable} set"            .
          " `filesize` = {$this->FileSize} ,"       .
          " `iconsize` = {$ICONSIZE} ,"             .
            " `format` = 'png' ,"                   .
             " `width` = {$this->Width} ,"          .
            " `height` = {$this->Height} ,"         .
         " `iconwidth` = {$IWIDTH} ,"               .
        " `iconheight` = {$IHEIGHT}"                .
        " where `uuid` = {$this->Uuid} ;"           ;
  $DB -> Query ( $QQ )                              ;
  ///////////////////////////////////////////////////
  $QQ   = "insert into {$this -> ThumbDepot}"       .
          " ( `uuid` , `thumb` ) values"            .
          " ( {$this->Uuid} , ? ) ;"                ;
  $qq   = $DB -> Prepare ( $QQ                    ) ;
  $qq  -> bind_param     ( 's' , $this -> IconRaw ) ;
  $qq  -> execute        (                        ) ;
}

public function Import ( $DB )
{
  if ( $this -> GetUuid ( $DB ) === false ) return false ;
  $this -> UpdateImage ( $DB )                           ;
  $this -> UpdateThumb ( $DB )                           ;
  return true                                            ;
}

public function ObtainsDetails( $DB )
{
  $QQ = "select `suffix`,`filesize`,`checksum`,`width`,`height` from {$this->PictureTable}" .
        " where `uuid` = {$this->Uuid} ;"                  ;
  $qq = $DB -> Query ( $QQ )                               ;
  if ( $DB -> hasResult ( $qq ) )                          {
    $rr               = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this -> Suffix   = $rr [ "suffix"   ]                 ;
    $this -> MIME     = "image/" . $this -> Suffix         ;
    $this -> Width    = $rr [ "width"    ]                 ;
    $this -> Height   = $rr [ "height"   ]                 ;
    $this -> Checksum = $rr [ "checksum" ]                 ;
    $this -> FileSize = $rr [ "filesize" ]                 ;
    return true                                            ;
  }                                                        ;
  return false                                             ;
}

public function ObtainsImage( $DB )
{
  $QQ = "select `file` from {$this->PictureDepot}"    .
        " where `uuid` = {$this->Uuid} ;"             ;
  $qq = $DB -> Query ( $QQ )                          ;
  if ( $DB -> hasResult ( $qq ) )                     {
    $rr          = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this -> Raw = $rr [ 0 ]                          ;
    return true                                       ;
  }                                                   ;
  return false                                        ;
}

public function ObtainsIcon( $DB )
{
  $QQ = "select `thumb` from {$this->ThumbDepot}"         .
        " where `uuid` = {$this->Uuid} ;"                 ;
  $qq = $DB -> Query ( $QQ )                              ;
  if ( $DB -> hasResult ( $qq ) )                         {
    $rr              = $qq -> fetch_array ( MYSQLI_BOTH ) ;
    $this -> IconRaw = $rr [ 0 ]                          ;
    return true                                           ;
  }                                                       ;
  return false                                            ;
}

public function MakeImage()
{
  $this -> Image = Image::make( $this -> Raw ) ;
}

public function MakeIcon()
{
  $this -> Icon = Image::make( $this -> IconRaw ) ;
}

public function FixIcon()
{
  $img  = Image::canvas ( 128 , 128                ) ;
  $img -> insert        ( $this -> Icon , "center" ) ;
  return $img -> encode ( "png"                    ) ;
}

public function ResizeIcon($WIDTH,$HEIGHT)
{
  $img  = Image::canvas  ( 128           , 128      ) ;
  $img -> insert         ( $this -> Icon , "center" ) ;
  $img  = $img -> resize ( $WIDTH        , $HEIGHT  ) ;
  return $img  -> encode ( "png"                    ) ;
}

public function ResizeImage($WIDTH,$HEIGHT)
{
  $img  = $this -> Image -> resize            (
             $WIDTH                           ,
             $HEIGHT                          ,
             function ( $constraint )         {
               $constraint -> aspectRatio ( ) ;
             }                              ) ;
  return $img -> encode ( "png" )             ;
}

public function ImageContentType()
{
  return "Content-Type: {$this->MIME}" ;
}

public function ImageContentLength()
{
  $FILESIZE = $this -> FileSize        ;
  return "Content-Length: {$FILESIZE}" ;
}

public function EchoIcon()
{
}

public function EchoFixIcon()
{
}

public function fromUpload($KEY,$UploadPath)
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $AA = array ( )                                                            ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! is_array ( $_FILES ) )                                              {
    $AA [ "Answer"  ] = "Empty"                                              ;
    return $AA                                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> Upload = $_FILES [ $KEY ] [ "tmp_name" ]                          ;
  if ( strlen ( $this -> Upload ) <= 0 )                                     {
    $AA [ "Answer"  ] = "Empty"                                              ;
    return $AA                                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! is_uploaded_file ( $this -> Upload ) )                              {
    $AA [ "Problem" ] = "No upload file"                                     ;
    $AA [ "Answer"  ] = "No"                                                 ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $this -> CheckSize )                                                  {
    $FSIZE = $_FILES [ $KEY ] [ "size" ]                                     ;
    if ( $FSIZE > $this -> MaxLimit )                                        {
      $AA [ "Message" ] = "File size {$FSIZE} bytes is too big."             ;
      $AA [ "Answer"  ] = "No"                                               ;
      return $AA                                                             ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this->Filename   = $_FILES[ $KEY ] [ "name" ]                             ;
  $UFILE            = $this -> Filename                                      ;
  $tmpFile          = tempnam     ( $UploadPath , "img"                    ) ;
  $imageType        = pathinfo    ( $UFILE , PATHINFO_EXTENSION            ) ;
  $imageType        = strtolower  ( $imageType                             ) ;
  if                              ( strlen ( $imageType ) > 0              ) {
    unlink                        ( $tmpFile                               ) ;
    $tmpFile        = str_replace ( ".tmp" , "." . $imageType , $tmpFile   ) ;
    $this -> Suffix = $imageType                                             ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! move_uploaded_file ( $this -> Upload , $tmpFile ) )                 {
    $AA [ "Problem" ] = "Upload failure"                                     ;
    $AA [ "Answer"  ] = "No"                                                 ;
    unlink ( $tmpFile )                                                      ;
    return $AA                                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ! file_exists ( $tmpFile ) )                                          {
    $AA [ "Problem" ] = "File disappears"                                    ;
    $AA [ "Answer"  ] = "No"                                                 ;
    unlink ( $tmpFile )                                                      ;
    return $AA                                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $check  = getimagesize ( $tmpFile )                                        ;
  if ( $check === false )                                                    {
    $AA [ "Problem" ] = "File is not an image"                               ;
    $AA [ "Answer"  ] = "No"                                                 ;
    unlink ( $tmpFile )                                                      ;
    return $AA                                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> MIME     = $check [ "mime" ]                                      ;
  $this -> FileSize = filesize                 ( $tmpFile     )              ;
  $this -> Raw      = file_get_contents        ( $tmpFile     )              ;
  $this -> Image    = Image::make              ( $tmpFile     )              ;
  $this -> Icon     = Image::make              ( $tmpFile     )              ;
  $this -> Width    = $this -> Image -> width  (              )              ;
  $this -> Height   = $this -> Image -> height (              )              ;
  $this -> Checksum = sprintf ( "%u" , crc32   ( $this -> Raw ) )            ;
  ////////////////////////////////////////////////////////////////////////////
  if ( ( $this -> Width > 128 ) or ( $this -> Height > 128 ) )               {
    if ( $this -> Width > $this -> Height )                                  {
      $this -> Icon -> resize                                                (
        128                                                                  ,
        null                                                                 ,
        function ( $constraint ) { $constraint -> aspectRatio ( ) ; }      ) ;
    } else                                                                   {
      $this -> Icon -> resize                                                (
        null                                                                 ,
        128                                                                  ,
        function ( $constraint ) { $constraint -> aspectRatio ( ) ; }      ) ;
    }                                                                        ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $this -> IconRaw = $this -> Icon -> encode ( 'png' )                       ;
  ////////////////////////////////////////////////////////////////////////////
  if ( $this -> Removal ) unlink ( $tmpFile )                                ;
  ////////////////////////////////////////////////////////////////////////////
  $AA [ "Answer"  ] = "Yes"                                                  ;
  ////////////////////////////////////////////////////////////////////////////
  return $AA                                                                 ;
}

public function UploadForm($FORM="uploadForm",$INPUT="uploadImage",$PERCENT="uploadPercent",$LABEL="inputImage")
{
  ////////////////////////////////////////////////////////////////////////////
  global $Translations                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $MSG    = $Translations [ "Picture::Upload" ]                              ;
  ////////////////////////////////////////////////////////////////////////////
  $HTF    = new HtmlTag              (                                     ) ;
  $HTF   -> setSplitter              ( "\n"                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增FORM
  ////////////////////////////////////////////////////////////////////////////
  $HTF   -> setTag                   ( "form"                              ) ;
  $HTF   -> AddPair                  ( "id"      , $FORM                   ) ;
  $HTF   -> AddPair                  ( "method"  , "POST"                  ) ;
  $HTF   -> AddPair                  ( "enctype" , "multipart/form-data"   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HTX    = $HTF   -> addHtml        (                                     ) ;
  $TBODY  = $HTX   -> ConfigureTable ( 0 , 0 , 0                           ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> AddPair                  ( "align"    , "center"               ) ;
  $HD    -> setSplitter              ( "\n"                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  $LBL    = $HD -> addHtml           ( "label"                             ) ;
  $LBL   -> setSplitter              ( "\n"                                ) ;
  $LBL   -> AddPair                  ( "id"       , $LABEL                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC    = "UploadImage('{$FORM}') ;"                                       ;
  $VNP    = $LBL -> addInput         (                                     ) ;
  $VNP   -> AddPair                  ( "type"     , "file"                 ) ;
  $VNP   -> AddPair                  ( "id"       , $INPUT                 ) ;
  $VNP   -> AddPair                  ( "name"     , $INPUT                 ) ;
  $VNP   -> AddPair                  ( "style"    , "display: none;"       ) ;
  $VNP   -> AddPair                  ( "onchange" , $JSC                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $LMSG   = $LBL -> addHtml          ( "i"                                 ) ;
  $LMSG  -> AddPair                  ( "class" , "fa fa-photo"             ) ;
  $LMSG  -> AddText                  ( "&nbsp;{$MSG}"                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> AddPair                  ( "align"  , "right"                  ) ;
  $HD    -> addDiv                   ( ""       , $PERCENT                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HR     = $TBODY -> addTr          (                                     ) ;
  $HD     = $HR    -> addTd          (                                     ) ;
  $HD    -> AddPair                  ( "valign" , "top"                    ) ;
  $MDIV   = $HD    -> addDiv         ( ""       , "UploadBar"              ) ;
  $UDIV   = $MDIV  -> addDiv         ( ""       , "UploadProgress"         ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTF                                                                ;
}

public function ShortForm($FORM="uploadForm",$INPUT="uploadImage",$LABEL="uploadButton")
{
  ////////////////////////////////////////////////////////////////////////////
  $LBL    = new HtmlTag              (                                     ) ;
  $LBL   -> setTag                   ( "label"                             ) ;
  $LBL   -> setSplitter              ( "\n"                                ) ;
  $LBL   -> AddPair                  ( "id"       , $LABEL                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $HTF    = new HtmlTag              (                                     ) ;
  $HTF   -> setSplitter              ( "\n"                                ) ;
  $LBL   -> AddTag                   ( $HTF                                ) ;
  ////////////////////////////////////////////////////////////////////////////
  // 新增FORM
  ////////////////////////////////////////////////////////////////////////////
  $HTF   -> setTag                   ( "form"                              ) ;
  $HTF   -> setSplitter              ( "\n"                                ) ;
  $HTF   -> AddPair                  ( "id"      , $FORM                   ) ;
  $HTF   -> AddPair                  ( "method"  , "POST"                  ) ;
  $HTF   -> AddPair                  ( "enctype" , "multipart/form-data"   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $JSC    = "UploadImage('{$FORM}') ;"                                       ;
  $VNP    = $HTF -> addInput         (                                     ) ;
  $VNP   -> setSplitter              ( "\n"                                ) ;
  $VNP   -> AddPair                  ( "type"     , "file"                 ) ;
  $VNP   -> AddPair                  ( "id"       , $INPUT                 ) ;
  $VNP   -> AddPair                  ( "name"     , $INPUT                 ) ;
  $VNP   -> AddPair                  ( "style"    , "display: none;"       ) ;
  $VNP   -> AddPair                  ( "onchange" , $JSC                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $LBL                                                                ;
}

}
//////////////////////////////////////////////////////////////////////////////
?>
