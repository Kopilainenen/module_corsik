<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Возврат");
?>
  <img src="/local/templates/main/img/return.png" alt=""/>
<br/><br/>
           
                
                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/return/text.php"),
	false
);?>
                
           
            
                
                 <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/return/text2.php"),
	false
);?>
                
           
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
