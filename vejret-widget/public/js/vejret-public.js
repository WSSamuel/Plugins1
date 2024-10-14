(function ($) {
	'use strict';
	$(function () {
		String.prototype.capitalize = function () {
			return this.charAt(0).toUpperCase() + this.slice(1)
		};
		var weatherWidget = document.getElementById("weather-widget-vejret");
		if (weatherWidget) {
			var city = weatherWidget.getAttribute("data-city");
			var country = weatherWidget.getAttribute("data-country");
			var days = weatherWidget.getAttribute("data-days");
			var language = weatherWidget.getAttribute("data-language") || "danish";
			var isCurrent = weatherWidget.getAttribute("data-current");
			var isWind = weatherWidget.getAttribute("data-wind");
			var isSunrise = weatherWidget.getAttribute("data-sunrise");
			var backgroundColor = weatherWidget.getAttribute("data-background");
			if (!backgroundColor || backgroundColor == '' || backgroundColor == '#becffb') {
				backgroundColor = 'linear-gradient(to left, #d3dfff, #fbfcff)';
			}
			var textColor = weatherWidget.getAttribute("data-text-color");
			if (!textColor || textColor == '') {
				textColor = 'black';
			}
			var widgetInputWidth = weatherWidget.getAttribute("data-width");
			var location_for_rest = city.replace(" ", "_") + "," + country;
			location_for_rest = location_for_rest;
			loadXMLDoc(location_for_rest);
		}

		function loadXMLDoc() {
			var xhr = new XMLHttpRequest();
			xhr.onload = function () {
				// Process our return data
				if (xhr.status >= 200 && xhr.status < 300) {
					// Runs when the request is successful
					handleResponse(JSON.parse(xhr.responseText));
				} else {
					// Runs when it's not
					console.log(xhr.responseText);
				}
			};
			xhr.open('GET', 'https://www.vejreti.com/weather/rests/publicWeatherForLocation.php?city=' + encodeURIComponent(city) + '&country=' + encodeURIComponent(country) + '&place=' + location_for_rest + '&domain=' + document.location + '&language=' + language);
			xhr.send();
		}


		function handleResponse(response) {
			//console.log(response);
			var deepLink = response.deepLink;
			var title = "Vejret i " + city.capitalize();
			if (language == "english") {
				title = "Weather in " + city.capitalize();
			}
			var temp = response.temp + '&#176;';
			var tempType = "C";
			var sunrise = "Sunrise: " + response.sunrise;
			if (language == "english") {
				sunrise = "Sunrise: " + response.sunrise;
			}
			var sunset = "Sunset: " + response.sunset;
			if (language == "english") {
				sunset = "Sunset: " + response.sunset;
			}
			var imageURL = response.icon;
			var humidity = "Fugtighed: " + response.humidity + "%";
			if (language == "english") {
				humidity = "Humidity: " + response.humidity + "%";
			}
			var windspeedKmph = "Vindhastighed: " + response.windspeedKmph + "Kmph";
			if (language == "english") {
				windspeedKmph = "Wind Speed: " + response.windspeedKmph + "Kmph";
			}
			var chanceofrain = "Chance for regn: " + response.chanceofrain + "%";
			if (language == "english") {
				chanceofrain = "Chance for rain: " + response.chanceofrain + "%";
			}
			var daysForecast = response.days;
			var description = response.description;


			// set tight if user asked for not 100%
			if (widgetInputWidth == 'tight') {
				$(weatherWidget).addClass('tight');
			} else {
				$(weatherWidget).addClass('maxwidth');
			}

			// get widget width
			var widgetWidth = $(weatherWidget).width();
			var widthClass = "regular";
			if (widgetWidth < 200) {
				widthClass = "super-small";
			} else if (widgetWidth < 300) {
				widthClass = "small";
			}


			// wrap deep link
			var mainDeepLinkElm = document.createElement("a");
			mainDeepLinkElm.setAttribute("href", deepLink);

			//mainWrapElm
			var mainWrapElm = document.createElement("div");
			mainWrapElm.setAttribute("class", 'main_wrap ' + widthClass);
			mainWrapElm.setAttribute("style", "background: " + backgroundColor + " ;color:" + textColor);

			//title
			var titleElm = document.createElement("div");
			titleElm.innerHTML = title;
			titleElm.setAttribute("class", "weather_title");
			mainWrapElm.appendChild(titleElm);

			if (isCurrent == "on") {
				// center wrap
				var centerWrapElm = document.createElement("div");
				centerWrapElm.setAttribute("class", "weather_center_wrap");

				// temp wrap
				var tempWrap = document.createElement("div");
				tempWrap.setAttribute("class", "weather_temp_wrap");

				// temp
				var tempElm = document.createElement("span");
				tempElm.innerHTML = temp;
				tempElm.setAttribute("class", "weather_temp");
				tempWrap.appendChild(tempElm);

				// temp type
				var tempTypeElm = document.createElement("span");
				tempTypeElm.innerHTML = tempType;
				tempTypeElm.setAttribute("class", "weather_temp_type");
				tempWrap.appendChild(tempTypeElm);

				// image
				var imageWrapElm = document.createElement("div");
				var imageElm = document.createElement("img");
				imageElm.setAttribute("src", imageURL);

				imageElm.setAttribute("class", "weather_image");
				imageWrapElm.setAttribute("class", "weather_image_wrap");
				imageWrapElm.appendChild(imageElm);

				centerWrapElm.appendChild(imageWrapElm);
				centerWrapElm.appendChild(tempWrap);
				mainWrapElm.appendChild(centerWrapElm);


				// description
				var descriptionElm = document.createElement("div");
				descriptionElm.innerHTML = description;
				descriptionElm.setAttribute("class", "weather_description");
				mainWrapElm.appendChild(descriptionElm);
			}

			if (isSunrise == 'on') {
				// sunrise
				var sunriseElm = document.createElement("div");
				sunriseElm.innerHTML = sunrise;
				sunriseElm.setAttribute("class", "weather_sunrise"); //");
				mainWrapElm.appendChild(sunriseElm);

				// sunset
				var sunsetElm = document.createElement("div");
				sunsetElm.innerHTML = sunset;
				sunsetElm.setAttribute("class", "weather_sunset"); //");
				mainWrapElm.appendChild(sunsetElm);
			}


			if (isWind == 'on') {
				var weatherDataElm = document.createElement("div");
				weatherDataElm.setAttribute("class", "weather_data_wrap"); //"");

				// humidity
				var humidityElm = document.createElement("div");
				humidityElm.innerHTML = humidity;
				humidityElm.setAttribute("class", "weather_humidity"); //");
				weatherDataElm.appendChild(humidityElm);
				// wind
				var windElm = document.createElement("div");
				windElm.innerHTML = windspeedKmph;
				windElm.setAttribute("class", "weather_wind"); //");
				weatherDataElm.appendChild(windElm);
				// rain
				var chanceofrainElm = document.createElement("div");
				chanceofrainElm.innerHTML = chanceofrain;
				chanceofrainElm.setAttribute("class", "weather_rain"); //");
				weatherDataElm.appendChild(chanceofrainElm);

				// add to dom
				mainWrapElm.appendChild(weatherDataElm);
			}


			// days
			if (Number(days) > 0) {
				var daysWrap = document.createElement("div");
				daysWrap.setAttribute("class", "weather_days_wrap"); //"");

				for (var i = 0; i < Number(days); i++) {
					var dayElm = document.createElement("div");
					var dayElmWidth = "33.3%";
					if (Number(days) == 2 || Number(days) == 4) {
						dayElmWidth = "50%";
					}
					dayElm.setAttribute("class", "weather_day_wrap"); //"width: " + dayElmWidth + "; text-align: center;margin: 10px 0px;");
					// day name
					var dayNameElm = document.createElement("div");
					dayNameElm.innerHTML = daysForecast[i].dayName;
					dayNameElm.setAttribute("class", "weather_day_name"); //"");
					dayElm.appendChild(dayNameElm);

					// day image
					var dayImageWrapElm = document.createElement("div");
					var dayImageElm = document.createElement("img");
					dayImageElm.setAttribute("class", "weather_day_image"); //"");
					dayImageElm.setAttribute("src", daysForecast[i].icon);
					dayImageWrapElm.setAttribute("class", "weather_day_image_wrap"); //"");
					dayImageWrapElm.appendChild(dayImageElm);
					dayElm.appendChild(dayImageWrapElm);

					// day temp
					var dayTempElm = document.createElement("div");
					dayTempElm.innerHTML = daysForecast[i].min + "/" + daysForecast[i].max + '&#176;' + "C";
					dayTempElm.setAttribute("class", "weather_day_temp"); //"");
					dayElm.appendChild(dayTempElm);


					daysWrap.appendChild(dayElm);
				}
				mainWrapElm.appendChild(daysWrap);
			}

			mainDeepLinkElm.prepend(mainWrapElm);

			weatherWidget.prepend(mainDeepLinkElm);
		}

	});

})(jQuery);
