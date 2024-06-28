<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Доставка из магазина");
?>

<? $APPLICATION->IncludeComponent("corsik:yadelivery.map", "delivery", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"PERSON_TYPE" => "1",
		"ADD_ZONE_PRICE" => "Y",	// Добавить стоимость доставки по зоне к стоимости доставки по километражу
		"START_PRICE" => "",	// Первоначальная стоимость доставки
		"SELECT_WAREHOUSE" => "4",
		"DISPLAY_MAP" => "PAGE",
		"TYPE_PROMPTS" => "DADATA",
		"AJAX_MODE" => "Y"
	),
	false
); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>