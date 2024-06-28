<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Варианты оплаты");
?>
<p class="fs-16">

	<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"AREA_FILE_RECURSIVE" => "",
		"EDIT_MODE" => "",
		"EDIT_TEMPLATE" => "",
		"PATH" => SITE_DIR . "/buyer/payment_variants/text.php"),
		false
	); ?>

</p>

<img class="mt-25" src="/local/templates/main/img/payment_variants.png" alt=""/>

<ul class="payment-block">
    <li>

		<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "",
			"AREA_FILE_RECURSIVE" => "",
			"EDIT_MODE" => "",
			"EDIT_TEMPLATE" => "",
			"PATH" => SITE_DIR . "/buyer/payment_variants/text2.php"),
			false
		); ?>

    </li>

    <li>
		<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "",
			"AREA_FILE_RECURSIVE" => "",
			"EDIT_MODE" => "",
			"EDIT_TEMPLATE" => "",
			"PATH" => SITE_DIR . "/buyer/payment_variants/text3.php"),
			false
		); ?>


    </li>
</ul>

<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"AREA_FILE_SUFFIX" => "",
	"AREA_FILE_RECURSIVE" => "",
	"EDIT_MODE" => "",
	"EDIT_TEMPLATE" => "",
	"PATH" => SITE_DIR . "/buyer/payment_variants/text4.php"),
	false
); ?>


<br/>
<br/>
<br/>
<div class="payment-images">
    <img src="/local/templates/main/img/visa.png" alt=""/>
    <img src="/local/templates/main/img/mastercard.png" alt=""/>
    <img src="/local/templates/main/img/maestro.png" alt=""/>
    <img src="/local/templates/main/img/mir.png" alt=""/>
</div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
