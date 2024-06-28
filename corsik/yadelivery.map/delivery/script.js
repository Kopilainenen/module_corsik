const moduleID = "yadelivery";
const prefixClassName = "corsik_yaDeliveryMap";
const prefixModuleID = "corsik_yaDelivery";
const classNames = {
	map: `${prefixClassName}__map`,
	address: `${prefixClassName}__addressDelivery`,
	orderPrice: `${prefixClassName}__orderPrice`,
	orderWeight: `${prefixClassName}__orderWeight`,
	total: `${prefixModuleID}__total`,
	totalPrice: `${prefixModuleID}__total__price`,
	route: `${prefixModuleID}__route`,
	routeValue: `${prefixModuleID}__route__value`,
};

class YaDeliveryMapComponent {
	constructor(api) {
		this.api = api;
		this.total = {};
		this.addressInput = document.getElementById(classNames.address);
		this.setSuggestionSettings();
		this.api.afterCalculate = this.onAfterCalculate;
		this.custom = {}; //массив с данными
	}

	setSuggestionSettings = () => {
		const { typePrompts } = this.getParameters();
		const isYandexSuggestions = typePrompts === "yandex";
		const isDadataSuggestions = typePrompts === "dadata";

		this.api.setSettings({
			...this.getSettings(),
			yandex: {
				controls: true,
				options: {
					search: {
						size: "auto",
					},
				},
				suggestions: isYandexSuggestions ? this.getYandexSuggestionsSettings() : {},
			},
			dadata: {
				fields: isDadataSuggestions ? this.getDadataSuggestionsSettings() : [],
			},
		});
	};

	getDadataSuggestionsSettings = () => [
		{
			code: "ADDRESS",
			selector: `#${classNames.address}`,
		},
	];

	getYandexSuggestionsSettings = () => [
		{
			code: "ADDRESS",
			selector: `#${classNames.address}`,
			options: {
				provider: {
					// suggest: (request) => {
					// 	//Enter the restriction for your region
					// 	const restrictionRegion = "Московская область, ";
					// 	return ymaps.suggest(restrictionRegion + request);
					// },
				},
			},
		},
	];

	init = () => {
		this.initEvents();
		this.initParamsInForm();
		this.initTooltip();

		ymaps.ready(function (){
			setTimeout(function () {
				window.onCalculateRoute([58.39172621457965, 33.920758682617205], true);
			}, 300)
		})
	};

	/**
	 * result after delivery calculation
	 * @param resultCalculate
	 */
	onAfterCalculate = (resultCalculate) => {
		this.custom = resultCalculate.custom
		this.setDataForm();
		this.initTooltip();
	};

	setDataForm = () => {

		var blockType = $('.corsik_yaDeliveryMap__radioBlock'),
			blockSubType = $('.corsik_yaDeliveryMap__carsBlock'),
			priceBlock = $('.corsik_yaDeliveryMap__cost-items'),
			itemCarSelect,
			itemCarSelectType,
			priceItem,
			selectCar = true;

		blockType.empty(); //Очищаем блок с типами машин
		blockSubType.empty(); //Очищаем блок с типами машин

		for (var ruleKey in this.custom.rulesList){
			itemCarSelect = this.createSelectCarItem(this.custom.typeCars[ruleKey]);
			blockType.append(itemCarSelect); //Добавляем типы машин

			if (this.custom.selectType === ruleKey) {

				for (var subTypeCarKey in this.custom.rulesList[ruleKey]) {

					if (this.custom.selectCar){
						if (this.custom.selectCar == subTypeCarKey){
							selectCar = true;
						}
						else {
							selectCar = false;
						}
					}
					itemCarSelectType = this.createSelectCarTypeItem(this.custom.cars[subTypeCarKey], selectCar);
					blockSubType.append(itemCarSelectType); //Добавляем типы машин

					if(selectCar){
						priceBlock.empty()
						for (var priceKey in this.custom.rulesList[ruleKey][subTypeCarKey]){
							priceItem = this.createPriceItem(this.custom.rulesList[ruleKey][subTypeCarKey][priceKey])
							priceBlock.append(priceItem)
						}
					}

					selectCar = false;
				}
			}

		}
		this.initEvents();
	};

	getSettings = () => {
		const parameters = this.getParameters();

		if (_.isEmpty(parameters)) {
			return null;
		}

		const isPageMap = parameters?.displayMap === "PAGE";
		if (isPageMap) {
			parameters.selectors = {
				map: `#${classNames.map}`,
			};
		}

		return parameters;
	};

	getParameters = () => window.jsonMapsParameters;

	initEvents = () => {
		var _this = this;
		$("input[name='type_delivery']").change(function (){
			window.window.jsonMapsParameters.mapSettings.selectType = $(this).val();
			window.window.jsonMapsParameters.mapSettings.selectCar = '';
			_this.recalculateAddress();
		});

		$("input[name='car']").change(function (){
			window.window.jsonMapsParameters.mapSettings.selectCar = $(this).val();
			_this.recalculateAddress();
		});
	};

	initParamsInForm = () => {
		//window.window.jsonMapsParameters.mapSettings.selectType = 'car';
	};

	recalculateAddress = () => {
		const address = _.trim(this.addressInput.value);
		if (address) {
			window.onCalculateRoute(address, true);
		}
	};

	createSelectCarItem = (data) => {

		var label, input, infoBlock, p;

		label = $("<label>", {
			class: "corsik_radio",
			id:	data.code
		});

		input = $("<input>", {
			class: "radio__input",
			type: "radio",
			name: "type_delivery",
			value: data.code,
			checked: data.checked
		})

		label.append(input);

		infoBlock = $('<div>', {
			class: 'radio__info'
		})
		p = $("<p>", {
			class: "radio__text",
			text: data.name
		});
		infoBlock.append(p);

		label.append(infoBlock);

		return label;
	}

	createSelectCarTypeItem = (data, checked = false) => {

		var label, input, img, p, div;

		label = $("<label>", {
			class: "car",
		});

		input = $("<input>", {
			class: "car__input",
			type: "radio",
			name: "car",
			value: data.value,
			checked: data.checked || checked
		})

		label.append(input);

		div = $("<div>", {
			class: 'car__type'
		})

		img = $('<img>', {
			src: data.img
		})
		div.append(img);

		p = $("<p>", {
			class: "car__weight",
			text: data.name
		});
		div.append(p);

		label.append(div);

		return label;
	}

	createPriceItem = (data) => {

		var div, p, span, img, pPrice, spanPriceText, spanPriceCurrency;

		div = $("<div>", {
			class: "corsik_yaDeliveryMap__cost-item"
		});

		p = $("<p>", {
			class: "corsik_yaDeliveryMap__cost-text"
		});

		span = $("<span>", {
			text: data.name
		});
		p.append(span);

		img = $("<img>", {
			src: "/images/question-icon.svg",
			alt: "Иконка вопроса",
			title: data.desc,
			class: 'tooltip-block'
		})
		p.append(img);

		div.append(p);

		pPrice = $("<p>", {
			class: "corsik_yaDeliveryMap__cost-value"
		})

		spanPriceText = $("<span>", {
			class: "corsik_yaDeliveryMap__cost-number",
			text: data.price
		});

		pPrice.append(spanPriceText)

		spanPriceText = $("<span>", {
			class: "corsik_yaDeliveryMap__cost-currency",
			text: "₽"
		});

		pPrice.append(spanPriceText);

		div.append(pPrice);

		return div;
	}
	initTooltip = () => {
		$( ".tooltip-block" ).tooltip({
			classes: {
				"ui-tooltip": "tooltip-inner"
			},
			position: {
				my: "center bottom",
				at: "center top-10",
				collision: "none"
			}
		});
	}
}

BX.ready(() => {
	const getApiYaDelivery = (name) => _.get(window, [moduleID, name], null);

	try {
		const yaDelivery = getApiYaDelivery("run");
		yaDelivery(true).then(() => {
			const api = getApiYaDelivery("api");
			const component = new YaDeliveryMapComponent(api);
			api.setSettings({ isCustomCalculate: true });
			api.ready(async () => {
				component.init();
			});
		});
	} catch (e) {
		console.error(e);
	}
});