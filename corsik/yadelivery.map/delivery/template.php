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

global $APPLICATION;
?>

<div class="corsik_yaDeliveryMap">
    <!-- Место для карты  -->
    <div class="corsik_yaDeliveryMap__map" id="corsik_yaDeliveryMap__map">
        
    </div>
    <!-- Поле ввода адреса доставки с тайтлом и плейсхолдером -->

    <input type="hidden" name="PERSON_TYPE" value="<?= $arParams['PERSON_TYPE'] ?>">
    <div class="corsik_yaDeliveryMap__address">
        <h1 class="corsik_yaDeliveryMap__address-header"><?= $APPLICATION->ShowTitle( false ) ?></h1>
        <div class="corsik_yaDeliveryMap__inputBlock">
            <h3 class="corsik_yaDeliveryMap__address-title">
                <?= Loc::getMessage( 'CORSIK_YADELIVERY_MAP_DELIVERY_ADDRESS' ) ?>
            </h3>
            <div class="corsik_yaDeliveryMap__inputGroup">
                <input placeholder="Введите адрес текстом или выберите на карте" type="text"
                       class="corsik_yaDeliveryMap__input <?= $isYandexPrompts ? "corsik_yaDeliveryMap_readonly" : "" ?>"
                       id="corsik_yaDeliveryMap__addressDelivery" autocomplete="new-password" autocorrect="off"
                       autocapitalize="off" spellcheck="false" style="box-sizing: border-box;">
            </div>
        </div>
    </div>

    <div class="corsik_yaDeliveryMap__options">
        <!-- радио-кнопки для выбора транспорта доставки  -->
        <div class="corsik_yaDeliveryMap__options-radio">
            <div class="corsik_yaDeliveryMap__radioBlock">

            </div><!-- блок выбора машины -->
            <div class="corsik_yaDeliveryMap__carsBlock" style="display: flex">

            </div><!-- блок выбора манипулятора -->

        </div><!-- Тарифы -->
        <div class="corsik_yaDeliveryMap__options-cost">
            <h3 class="corsik_yaDeliveryMap__cost-title">Цены на доставку</h3>
            <div class="corsik_yaDeliveryMap__cost-items">

            </div>
        </div>
    </div>
</div>
<!--/div-->


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

	],
	'TOTAL'       => [
		'ORDER_TOTAL_PRICE' => 0,
		'ORDER_WEIGHT'      => 0,
	],
] );

Asset::getInstance()->addString( "<script>window.jsonMapsParameters = $jsData </script>" );
Asset::getInstance()->addString( "<script src=\"" . $scheme . "://api-maps.yandex.ru/2.1/?apikey=" . $arResult['YANDEX_MAPS_API_KEY'] . "&lang=ru_RU\"></script>" );
Asset::getInstance()->addJs( "./lodash.min.js" );
?>
