<?php if ( ! defined( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true ) {
	die();
}

$this->setFrameMode( true );

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Corsik\YaDelivery\Helper;

/**
 * @var array $arParams
 * @var array $arResult
 */

Bitrix\Main\UI\Extension::load( [ 'popup' ] );
$context         = Main\Application::getInstance()->getContext();
$helper          = Helper::getInstance();
$scheme          = $context->getRequest()->isHttps() ? 'https' : 'http';
$isModal         = $arParams['DISPLAY_MAP'] === 'MODAL';
$typePrompts     = strtolower( $arParams['TYPE_PROMPTS'] );
$isYandexPrompts = $typePrompts === 'yandex';
?>
<div class="corsik_yaDeliveryMap">
    <input type="hidden" name="PERSON_TYPE" value="<?= $arParams['PERSON_TYPE'] ?>">
    <div class="corsik_yaDeliveryMap__inputGroup">
        <input placeholder="Введите адрес текстом или выберите на карте" type="text"
               :name="orderData.PROPS.ADDRESS_DELIVERY.FIELD_NAME" required
               class="step__input corsik_yaDeliveryMap__address-input <?= $isYandexPrompts ? "corsik_yaDeliveryMap_readonly" : "" ?>"
               id="corsik_yaDeliveryMap__addressDelivery" autocomplete="new-password" autocorrect="off"
               autocapitalize="off" spellcheck="false" style="box-sizing: border-box;">
    </div>
    <div class="corsik_yaDeliveryMap__map" id="corsik_yaDeliveryMap__map">

    </div>
</div>

<?
$jsData = CUtil::PhpToJSObject( [
	'displayMap'  => $arParams['DISPLAY_MAP'],
	'typePrompts' => $typePrompts,
	'mapSettings' => [
		'points'       => [
			'warehouse' => $arParams['SELECT_WAREHOUSE'],
		],
		'startPrice'   => $arParams['START_PRICE'],
		'addZonePrice' => $arParams['ADD_ZONE_PRICE'],
        'isOrder' => true,
        'orderPrice' => $arParams['ORDER_TOTAL_PRICE'],
        'orderWeight' => $arParams['ORDER_WEIGHT'],
        'maxLength' => $arParams['MAX_LENGTH']
	],
	'TOTAL'  => [
		'PRICE_WITHOUT_DISCOUNT_VALUE' => $arParams['ORDER_TOTAL_PRICE'],
		'ORDER_WEIGHT'      => $arParams['ORDER_WEIGHT'],
	],
] );

Asset::getInstance()->addString( "<script>window.jsonMapsParameters = $jsData </script>" );
Asset::getInstance()->addString( "<script src=\"" . $scheme . "://api-maps.yandex.ru/2.1/?apikey=" . $arResult['YANDEX_MAPS_API_KEY'] . "&lang=ru_RU\"></script>" );
Asset::getInstance()->addJs( "./lodash.min.js" );
?>
