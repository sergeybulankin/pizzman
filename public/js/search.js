ymaps.ready(init);

function init() {
    // Подключаем поисковые подсказки к полю ввода.
    var suggestView = new ymaps.SuggestView('suggest'),
        map,
        placemark;

    $("#address").on("input",function(e){
        $('#viewContainer').empty();
        geocode();
    });


    function geocode() {
        // Забираем запрос из поля ввода.
        var city = "Стерлитамак, ";
        var request = city + $('#suggest').val();

        // Геокодируем введённые данные.
        ymaps.geocode(request).then(function (res) {
            var obj = res.geoObjects.get(0),
                error, hint;

            if (obj) {
                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                    case 'exact':
                        break;
                    case 'number':
                    case 'near':
                    case 'range':
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'street':
                        error = 'Неполный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'other':
                    default:
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните адрес';
                }
            } else {
                error = 'Адрес не найден';
                hint = 'Уточните адрес';
            }

            // Если геокодер возвращает пустой массив или неточный результат, то показываем ошибку.
            if (error) {
                showError(error);
                showMessage(hint);
            } else {
                showResult(obj);
            }
        }, function (e) {
            console.log(e)
        })
    }


    function showResult(obj) {
        // Удаляем сообщение об ошибке, если найденный адрес совпадает с поисковым запросом.
        $('#address').removeClass('input_error');
        $('#notice').css('display', 'none');

        var mapContainer = $('#map'),
            bounds = obj.properties.get('boundedBy'),
        // Рассчитываем видимую область для текущего положения пользователя.
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            ),
        // Сохраняем полный адрес для сообщения под картой.
            address = [obj.getCountry(), obj.getAddressLine()].join(', '),
        // Сохраняем укороченный адрес для подписи метки.
            shortAddress = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
        // Убираем контролы с карты.
        mapState.controls = [];
        // Создаём карту.
        //createMap(mapState, shortAddress);
        definationPoint(mapState, shortAddress);
        // Выводим сообщение под картой.
        showMessage(address);
    }


    function showError(message) {
        $('#notice').text(message);
        $('#address').addClass('input_error');
        $('#notice').css('display', 'block');
        // Удаляем карту.
        if (map) {
            map.destroy();
            map = null;
        }
    }


    // сравниваем расстоянием между точками доставки и клиентом
    // и выбираем наиболее быстрый маршрут
    function definationPoint(state, caption) {
        var city = "Стерлитамак, ";

        var points = [
            "Стерлитамак, Ленина, 29а",
            "Стерлитамак, Артема, 10"
        ];

        // координаты точки доставки
        ymaps.geocode(city + caption).then(function (res) {
            var pointDelivery = res.geoObjects.get(0).geometry.getCoordinates();

            // координаты точек отправки
            ymaps.geocode(points[0]).then(function (res) {
                var point1 = res.geoObjects.get(0).geometry.getCoordinates();

                ymaps.geocode(points[1]).then(function (res) {
                    var point2 = res.geoObjects.get(0).geometry.getCoordinates();
                    // Расстояние
                    var one = ymaps.coordSystem.geo.getDistance(pointDelivery, point1);
                    var two = ymaps.coordSystem.geo.getDistance(pointDelivery, point2);

                    if (one >= two)
                    {
                        var point = points[1];
                    } else {
                        var point = points[0];
                    }

                    createMap(state, caption, point);
                });

            });
        });
    }


    function createMap(state, caption, point) {
        var city = "Стерлитамак, ";

        // Создаем модель мультимаршрута.
        var multiRouteModel = new ymaps.multiRouter.MultiRouteModel([
                city + caption,
                point
            ]),

        // Создаём выпадающий список для выбора типа маршрута.
        routeTypeSelector = new ymaps.control.ListBox({
            data: {
                content: 'Способы доставки'
            },
            items: [
                new ymaps.control.ListBoxItem({data: {content: "Курьер"},state: {selected: true}})
            ],
            options: {
                itemSelectOnClick: false
            }
        });


        ymaps.modules.require([
            'MultiRouteCustomView'
        ], function (MultiRouteCustomView) {
            // Создаем экземпляр текстового отображения модели мультимаршрута.
            // см. файл custom_view.js
            new MultiRouteCustomView(multiRouteModel);
        });


        // Если карта еще не была создана, то создадим ее и добавим метку с адресом.
        if (!map) {
            map = new ymaps.Map('map', state, {
                center: [55.750625, 37.626],
                zoom: 7,
                controls: [routeTypeSelector]
            });


            multiRoute = new ymaps.multiRouter.MultiRoute({
                // Описание опорных точек мультимаршрута.
                referencePoints: [
                    point,
                    city + caption
                ],
                // Параметры маршрутизации.
                params: {
                    // Ограничение на максимальное количество маршрутов, возвращаемое маршрутизатором.
                    results: 1
                }
            }, {
                // Внешний вид путевых точек.
                wayPointStartIconColor: "#333",
                wayPointStartIconFillColor: "#B3B3B3",
                wayPointStartIconLayout: "default#image",
                wayPointStartIconImageHref: "../images/pizza.png",
                wayPointStartIconImageSize: [32, 32],
                wayPointStartIconImageOffset: [-15, -15],
                // Задаем собственную картинку для последней путевой точки.
                wayPointFinishIconLayout: "default#image",
                wayPointFinishIconImageHref: "../images/user.png",
                wayPointFinishIconImageSize: [32, 32],
                wayPointFinishIconImageOffset: [-15, -15],

                // Внешний вид точечных маркеров под путевыми точками.
                pinIconFillColor: "#000088",
                pinActiveIconFillColor: "#B3B3B3",
                // Позволяет скрыть точечные маркеры путевых точек.
                // pinVisible:false,

                // Внешний вид линии маршрута.
                routeStrokeWidth: 2,
                routeStrokeColor: "#000088",
                routeActiveStrokeWidth: 6,
                routeActiveStrokeColor: "#06266F",

                // Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
                boundsAutoApply: true
            });

            // Добавляем мультимаршрут на карту.
            map.geoObjects.add(multiRoute);

            // Если карта есть, то выставляем новый центр карты и меняем данные и позицию метки в соответствии с найденным адресом
        } else {


            custumRoute = new ymaps.multiRouter.MultiRoute({
                // Описание опорных точек мультимаршрута.
                referencePoints: [
                    point,
                    city + caption
                ],
                // Параметры маршрутизации.
                params: {
                    // Ограничение на максимальное количество маршрутов, возвращаемое маршрутизатором.
                    results: 1
                }
            }, {
                    // Внешний вид путевых точек.
                    wayPointStartIconColor: "#333",
                    wayPointStartIconFillColor: "#B3B3B3",
                    wayPointStartIconLayout: "default#image",
                    wayPointStartIconImageHref: "../images/pizza.png",
                    wayPointStartIconImageSize: [32, 32],
                    wayPointStartIconImageOffset: [-15, -15],
                    // Задаем собственную картинку для последней путевой точки.
                    wayPointFinishIconLayout: "default#image",
                    wayPointFinishIconImageHref: "../images/user.png",
                    wayPointFinishIconImageSize: [32, 32],
                    wayPointFinishIconImageOffset: [-15, -15],

                    // Внешний вид точечных маркеров под путевыми точками.
                    pinIconFillColor: "#000088",
                    pinActiveIconFillColor: "#B3B3B3",
                    // Позволяет скрыть точечные маркеры путевых точек.
                    // pinVisible:false,

                    // Внешний вид линии маршрута.
                    routeStrokeWidth: 2,
                    routeStrokeColor: "#000088",
                    routeActiveStrokeWidth: 6,
                    routeActiveStrokeColor: "#06266F",

                    // Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
                    boundsAutoApply: true
                });

            // Добавляем мультимаршрут на карту.
            map.geoObjects.removeAll();
            map.geoObjects.add(custumRoute);
        }
    }



    function showMessage(message) {
        $('#messageHeader').text('Адрес получен');
        $('#message').text(message);
    }
}

