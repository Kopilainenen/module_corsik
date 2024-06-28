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
		ymaps.ready(function (){
			setTimeout(function () {
				window.onCalculateRoute([58.39172621457965, 33.920758682617205], true);
			}, 300)
		});

		this.api.setResult({ TOTAL: window.jsonMapsParameters.TOTAL });
	};

	/**
	 * result after delivery calculation
	 * @param resultCalculate
	 */
	onAfterCalculate = (resultCalculate) => {
		setTimeout(function () {
			orderForm.setDateDelivery(resultCalculate.custom.dateList);
			orderForm.setTimeDelivery(resultCalculate.custom.rulesList);
			orderForm.outZone = false;
			if(resultCalculate.delivery.price == -1) {
				orderForm.outZone = true;
			}

			orderForm.refreshOrder();
		}, 300)

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

	recalculateAddress = () => {
		const address = _.trim(this.addressInput.value);
		if (address) {
			window.onCalculateRoute(address, true);
		}
	}
}
let componentDelivery;

function initMap(){
	const getApiYaDelivery = (name) => _.get(window, [moduleID, name], null);

	try {
		const yaDelivery = getApiYaDelivery("run");
		yaDelivery(true).then(() => {
			const api = getApiYaDelivery("api");
			componentDelivery = new YaDeliveryMapComponent(api);
			api.setSettings({ isCustomCalculate: true });
			api.ready(async () => {
				componentDelivery.init();
			});
		});
	} catch (e) {
		console.error(e);
	}
}
BX.ready(() => {
	initMap();
});