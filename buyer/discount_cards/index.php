<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дисконтные карты");
?>
 <p class="fs-16">
     
                      <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/discount_cards/text.php"),
	false
);?>
              
            </p>

            <div class="text-card-block">
                <div class="title">
                    
                                          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/discount_cards/text2.php"),
	false
);?>
                   
                </div>
                                          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/discount_cards/text3.php"),
	false
);?>
             

                <small>
                    
                                                              <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/discount_cards/text4.php"),
	false
);?>
                   
                </small>

                <img src="/local/templates/main/img/discount-card.png" alt=""/>
            </div>

                                                                          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/discount_cards/text5.php"),
	false
);?>
            
          
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
