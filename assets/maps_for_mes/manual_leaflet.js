/* types of layers */
var internetlayer =
        L.tileLayer('http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png', {id: 'mapid',
            maxZoom: 15,
            minZoom: 6
        });

baselayer =
        L.tileLayer('http://172.26.200.45/tile/map/{x}/{y}/{z}.png', {id: 'mapid',
            maxZoom: 14,
            minZoom: 6
        });



yandexlayerRoad =
        L.tileLayer('\/\/vec0{s}.maps.yandex.net\/tiles?l=map\u0026x={x}\u0026y={y}\u0026z={z}', {id: 'mapid',

            attribution: "Map data \u0026copy; \u003Ca target=\u0022attr\u0022 href=\u0022http:\/\/maps.yandex.ru\u0022\u003EYandex.Maps\u003C\/a\u003E",
            "subdomains": [1, 2, 3],

            maxZoom: 17,
            minZoom: 6

        });



var map = L.map('mapid', {attributionControl: false,
    layers: [internetlayer]
});
map.setView([53.894551, 27.556915], 12);

/* types of layers */
var baseMaps = {
    "Интернет-карта": internetlayer,
    "Базовая карта": baselayer,
    //      "Yandex карта (спутник)": yandexlayerSatellite,
    // "Yandex карта (дороги)": yandexlayerRoad
};
L.control.layers(baseMaps).addTo(map);
var internetMaps = {
    "<span style='color: gray'>Интернет-карта</span>": internetlayer,
    "Базовая карта": baselayer
};


var yandexMapsRoad = {
    "<span style='color: gray'>yandex-карта-дороги</span>": yandexlayerRoad,
    "Yandex карта (дороги)": yandexlayerRoad
};



/*-------------  contur --------------*/

//$.getJSON('assets/maps_for_mes/data/geo_brest.json', function (geojson) {
//    L.geoJson(geojson, {
////        onEachFeature: function (feature, layer) {
////            layer.bindPopup(feature.properties.name);
////        },
//        style: function (feature) {
//
//            return {
//                fillColor: 'rgb(219, 226, 131)',
//                weight: 3.5,
////                opacity: 2,
//                color: 'rgba(31, 120, 4)', //Outline color
//                fillOpacity: 0.2
//            };
//        }
//
//    }).addTo(map).bringToBack();
//});


//$.getJSON('assets/maps_for_mes/data/geo_gomel.json', function (geojson) {
//    L.geoJson(geojson, {
//
//        style: function (feature) {
//
//            return {
//                fillColor: 'rgb(255, 247, 177)',
//                weight: 3.5,
////                opacity: 2,
//                color: 'rgba(2, 107, 245)', //Outline color
//                fillOpacity: 0.2
//            };
//        }
//
//    }).addTo(map).bringToBack();
//});


//$.getJSON('assets/maps_for_mes/data/geo_min_obl.json', function (geojson) {
//    L.geoJson(geojson, {
//
//        style: function (feature) {
//
//            return {
//                fillColor: 'rgb(245, 180, 210)',
//                weight: 3.5,
//                color: 'rgba(247, 124, 181)', //Outline color
//                fillOpacity: 0.2
//            };
//        }
//
//    }).addTo(map).bringToBack();
//});


//$.getJSON('assets/maps_for_mes/data/geo_mogilev.json', function (geojson) {
//    L.geoJson(geojson, {
//        style: function (feature) {
//
//            return {
//                fillColor: 'rgb(251, 217, 202)',
//                weight: 3.5,
//                color: 'rgba(120, 83, 4)', //Outline color
//                fillOpacity: 0.3
//            };
//        }
//
//    }).addTo(map).bringToBack();
//});

//$.getJSON('assets/maps_for_mes/data/geo_vitebsk.json', function (geojson) {
//    L.geoJson(geojson, {
//
//        style: function (feature) {
//
//            return {
//                fillColor: 'rgb(210, 205, 231)',
//                weight: 3.5,
//                color: 'rgba(154, 137, 226)', //Outline color
//                fillOpacity: 0.2
//            };
//        }
//
//    }).addTo(map).bringToBack();
//});


//$.getJSON('assets/maps_for_mes/data/geo_grodno.json', function (geojson) {
//    L.geoJson(geojson, {
//
//        style: function (feature) {
//
//            return {
//                fillColor: 'rgb(253, 213, 165)',
//                weight: 3.5,
//                zIndex: -1,
//                color: 'rgba(8, 129, 150)', //Outline color
//                fillOpacity: 0.2
//            };
//        }
//
//    }).addTo(map).bringToBack();
//});


//$.getJSON('assets/maps_for_mes/data/geo_rb_all.json', function (geojson) {
//    L.geoJson(geojson, {
//
//        style: function (feature) {
//
//            return {
//                //fillColor: 'blue',
//                zIndex: 2500,
//                weight: 5,
//                opacity: 4,
//                color: 'rgb(140, 10, 10,0.8)', //Outline color
//                fillOpacity: 0};
//        }
//
//    }).addTo(map);
//});


$(document).ready(function () {
    border_rb(1);
    // border_region(1);
    border_local(1);
});


var border_rb_array_part = [];
var border_rb_array = [];
var border_rb_between_array = [];


function border_rb(is_show = 1) {

    if (is_show === 1) {

        var border_color = 'rgb(140, 10, 10,0.8)';
        $.getJSON('assets/maps_for_mes/data/geo_rb.json', function (geojson) {
            border_rb_array = L.geoJson(geojson, {

                style: function (feature) {

                    return {
                        //fillColor: 'blue',
                        zIndex: 2500,
                        weight: 5,
                        opacity: 4,
                        color: border_color, //Outline color
                        fillOpacity: 0};
                }

            }).addTo(map);
        });


        $.getJSON('assets/maps_for_mes/data/geo_rb_all.json', function (geojson) {
            border_rb_between_array = L.geoJson(geojson, {

                style: function (feature) {

                    return {
                        //fillColor: 'blue',
                        zIndex: 2500,
                        weight: 5,
                        opacity: 4,
                        color: 'rgb(140, 10, 10,0.8)', //Outline color
                        fillOpacity: 0};
                }

            }).addTo(map);
        });



        var polyline = new L.Polyline([
            [54.997414, 26.208512],
            [54.992065, 26.229858],
            [54.981079, 26.246337],
            [54.970092, 26.246337],
            [54.964599, 26.262817],
            [54.948120, 26.262817],
            [54.948343799937774, 26.28410339355469]
        ], {
            color: border_color,
            weight: 5
        }).addTo(map);

        border_rb_array_part = polyline;


    } else {//remove border RB


        map.removeLayer(border_rb_array_part);
        map.removeLayer(border_rb_array);
        map.removeLayer(border_rb_between_array);

}
}







var border_local_brest_array = [];
var border_local_vitebsk_array = [];
var border_local_gomel_array = [];
var border_local_grodno_array = [];
var border_local_min_obl_array = [];
var border_local_mogilev_array = [];
var border_local_minsk_array = [];
function border_local(is_show = 1) {

    if (is_show === 1) {

        var border_color = 'rgb(140, 10, 10,0.8)';

        $.getJSON('assets/maps_for_mes/data/geo_brest.json', function (geojson) {
            border_local_brest_array = L.geoJson(geojson, {
                style: function (feature) {

                    return {
                        fillColor: 'rgb(219, 226, 131)',
                        weight: 3.5,
//                opacity: 2,
                        color: 'rgba(31, 120, 4)', //Outline color
                        fillOpacity: 0.2
                    };
                }

            }).addTo(map).bringToBack();
        });


        $.getJSON('assets/maps_for_mes/data/geo_gomel.json', function (geojson) {
            border_local_gomel_array = L.geoJson(geojson, {

                style: function (feature) {

                    return {
                        fillColor: 'rgb(255, 247, 177)',
                        weight: 3.5,
//                opacity: 2,
                        color: 'rgba(2, 107, 245)', //Outline color
                        fillOpacity: 0.2
                    };
                }

            }).addTo(map).bringToBack();
        });


        $.getJSON('assets/maps_for_mes/data/geo_min_obl.json', function (geojson) {
            border_local_min_obl_array = L.geoJson(geojson, {

                style: function (feature) {

                    return {
                        fillColor: 'rgb(245, 180, 210)',
                        weight: 3.5,
                        color: 'rgba(247, 124, 181)', //Outline color
                        fillOpacity: 0.2
                    };
                }

            }).addTo(map).bringToBack();
        });


        $.getJSON('assets/maps_for_mes/data/geo_mogilev.json', function (geojson) {
            border_local_mogilev_array = L.geoJson(geojson, {
                style: function (feature) {

                    return {
                        fillColor: 'rgb(251, 217, 202)',
                        weight: 3.5,
                        color: 'rgba(120, 83, 4)', //Outline color
                        fillOpacity: 0.3
                    };
                }

            }).addTo(map).bringToBack();
        });

        $.getJSON('assets/maps_for_mes/data/geo_vitebsk.json', function (geojson) {
            border_local_vitebsk_array = L.geoJson(geojson, {

                style: function (feature) {

                    return {
                        fillColor: 'rgb(210, 205, 231)',
                        weight: 3.5,
                        color: 'rgba(154, 137, 226)', //Outline color
                        fillOpacity: 0.2
                    };
                }

            }).addTo(map).bringToBack();
        });


        $.getJSON('assets/maps_for_mes/data/geo_grodno.json', function (geojson) {
            border_local_grodno_array = L.geoJson(geojson, {

                style: function (feature) {

                    return {
                        fillColor: 'rgb(253, 213, 165)',
                        weight: 3.5,
                        zIndex: -1,
                        color: 'rgba(8, 129, 150)', //Outline color
                        fillOpacity: 0.2
                    };
                }

            }).addTo(map).bringToBack();
        });



    } else {//remobe border RB
        map.removeLayer(border_local_brest_array);
        map.removeLayer(border_local_gomel_array);
        map.removeLayer(border_local_min_obl_array);
        map.removeLayer(border_local_mogilev_array);
        map.removeLayer(border_local_vitebsk_array);
        map.removeLayer(border_local_grodno_array);
}
}





/*---------------- contur ------------------*/




/*-------------------- name of locals  ------------------*/

var data_points = {
    "type": "FeatureCollection",
    "name": "test-points-short-named",
    "crs": {"type": "name", "properties": {"name": "urn:ogc:def:crs:OGC:1.3:CRS84"}},
    "features": [

        {"type": "Feature", "properties": {"name": "Барановичский"},
            "geometry": {"type": "Point", "coordinates": [25.999145507812504, 53.192870243632626]}},

        {"type": "Feature", "properties": {"name": "Каменецкий"},
            "geometry": {"type": "Point", "coordinates": [23.679944264508876, 52.414159481317036]}},

        {"type": "Feature", "properties": {"name": "Пружанский"},
            "geometry": {"type": "Point", "coordinates": [24.319029182388434, 52.60699463722231]}},

        {"type": "Feature", "properties": {"name": "Ивацевичский"},
            "geometry": {"type": "Point", "coordinates": [25.311637839181948, 52.693225433682024]}},

        {"type": "Feature", "properties": {"name": "Брестский"},
            "geometry": {"type": "Point", "coordinates": [23.791429623140573, 52.0442160826447]}},

        {"type": "Feature", "properties": {"name": "Малориторский"},
            "geometry": {"type": "Point", "coordinates": [24.131708005401766, 51.731589705750615]}},

        {"type": "Feature", "properties": {"name": "Жабинковский"},
            "geometry": {"type": "Point", "coordinates": [24.057153035683335, 52.148621763869215]}},

        {"type": "Feature", "properties": {"name": "Кобринский"},
            "geometry": {"type": "Point", "coordinates": [24.39012361295039, 52.30011939317118]}},

        {"type": "Feature", "properties": {"name": "Березовский"},
            "geometry": {"type": "Point", "coordinates": [25.009663234053527, 52.456196403561236]}},
        {"type": "Feature", "properties": {"name": "Дрогичинский"},
            "geometry": {"type": "Point", "coordinates": [24.995332127158655, 52.230801148234555]}},

        {"type": "Feature", "properties": {"name": "Ивановский"},
            "geometry": {"type": "Point", "coordinates": [25.472670753233885, 52.04576531212062]}},
        {"type": "Feature", "properties": {"name": "Пинский"},
            "geometry": {"type": "Point", "coordinates": [26.169958575303433, 52.14575537821044]}},

        {"type": "Feature", "properties": {"name": "Столинский"},
            "geometry": {"type": "Point", "coordinates": [26.899511642950372, 51.951890082019325]}},
        {"type": "Feature", "properties": {"name": "Лунинецкий"},
            "geometry": {"type": "Point", "coordinates": [26.800350563288916, 52.38887681986495]}},
        {"type": "Feature", "properties": {"name": "Ганцевичский"},
            "geometry": {"type": "Point", "coordinates": [26.57517463174806, 52.736475886182795]}},
        {"type": "Feature", "properties": {"name": "Ляховичский"},
            "geometry": {"type": "Point", "coordinates": [26.167505789276152, 52.899909107335844]}},

        {"type": "Feature", "properties": {"name": "Житковичский"},
            "geometry": {"type": "Point", "coordinates": [27.70180813906401, 52.39005772162877]}},
        {"type": "Feature", "properties": {"name": "Лельчицкий"},
            "geometry": {"type": "Point", "coordinates": [28.102746428634752, 51.86404617067233]}},

        {"type": "Feature", "properties": {"name": "Ельский"},
            "geometry": {"type": "Point", "coordinates": [28.866176870420137, 51.74517695581721]}},
        {"type": "Feature", "properties": {"name": "Петриковский"},
            "geometry": {"type": "Point", "coordinates": [28.563015206058328, 52.29693149371051]}},
        {"type": "Feature", "properties": {"name": "Мозырский"},
            "geometry": {"type": "Point", "coordinates": [29.040845770341285, 51.946211049773474]}},
        {"type": "Feature", "properties": {"name": "Калинковичский"},
            "geometry": {"type": "Point", "coordinates": [29.32989190321674, 52.23142804797572]}},
        {"type": "Feature", "properties": {"name": "Октябрьский"},
            "geometry": {"type": "Point", "coordinates": [28.842841974850185, 52.62178589679713]}},
        {"type": "Feature", "properties": {"name": "Наровлянский"},
            "geometry": {"type": "Point", "coordinates": [29.57536411107744, 51.55810016135083]}},
        {"type": "Feature", "properties": {"name": "Хойникский"},
            "geometry": {"type": "Point", "coordinates": [29.863517057260687, 51.845192531222786]}},
        {"type": "Feature", "properties": {"name": "Брагинский"},
            "geometry": {"type": "Point", "coordinates": [30.249590971143707, 51.72336404965732]}},
        {"type": "Feature", "properties": {"name": "Лоевский"},
            "geometry": {"type": "Point", "coordinates": [30.59561822951138, 52.025160557850405]}},
        {"type": "Feature", "properties": {"name": "Речицкий"},
            "geometry": {"type": "Point", "coordinates": [30.134083501811485, 52.2500363815532]}},
        {"type": "Feature", "properties": {"name": "Гомельский"},
            "geometry": {"type": "Point", "coordinates": [30.915595483116952, 52.237737972126276]}},
        {"type": "Feature", "properties": {"name": "Добрушский"},
            "geometry": {"type": "Point", "coordinates": [31.517410012491766, 52.37631391266739]}},
        {"type": "Feature", "properties": {"name": "Ветковский"},
            "geometry": {"type": "Point", "coordinates": [31.22463748518744, 52.63377026889921]}},

        {"type": "Feature", "properties": {"name": "Светлогорский"},
            "geometry": {"type": "Point", "coordinates": [29.56816891091932, 52.55627522009155]}},
        {"type": "Feature", "properties": {"name": "Жлобинский"},
            "geometry": {"type": "Point", "coordinates": [29.91380768995001, 52.80815926722855]}},
        {"type": "Feature", "properties": {"name": "Рогачевский"},
            "geometry": {"type": "Point", "coordinates": [30.150645990392974, 53.18285692996159]}},
        {"type": "Feature", "properties": {"name": "Буда-Кошелевский"},
            "geometry": {"type": "Point", "coordinates": [30.496211365959965, 52.71944635163485]}},
        {"type": "Feature", "properties": {"name": "Чечерский"},
            "geometry": {"type": "Point", "coordinates": [30.968187242570412, 52.900308894275355]}},
        {"type": "Feature", "properties": {"name": "Кормянский"},
            "geometry": {"type": "Point", "coordinates": [30.86464568414911, 53.12353903863985]}},

        {"type": "Feature", "properties": {"name": "Солигорский"},
            "geometry": {"type": "Point", "coordinates": [27.435647038055972, 52.613784500024984]}},
        {"type": "Feature", "properties": {"name": "Любанский"},
            "geometry": {"type": "Point", "coordinates": [28.107747654489526, 52.71221577912675]}},
        {"type": "Feature", "properties": {"name": "Слуцкий"},
            "geometry": {"type": "Point", "coordinates": [27.602455563523684, 53.096694496120485]}},
        {"type": "Feature", "properties": {"name": "Стародорожский"},
            "geometry": {"type": "Point", "coordinates": [28.279784818169464, 52.993930794619274]}},
        {"type": "Feature", "properties": {"name": "Клецкий"},
            "geometry": {"type": "Point", "coordinates": [26.633807087173714, 52.96680353084263]}},
        {"type": "Feature", "properties": {"name": "Несвижский"},
            "geometry": {"type": "Point", "coordinates": [26.676031659886455, 53.28730932433769]}},
        {"type": "Feature", "properties": {"name": "Копыльский"},
            "geometry": {"type": "Point", "coordinates": [27.146705184508487, 53.16826402636006]}},
        {"type": "Feature", "properties": {"name": "Узденский"},
            "geometry": {"type": "Point", "coordinates": [27.25021339956441, 53.40444371643798]}},
        {"type": "Feature", "properties": {"name": "Столбцовский"},
            "geometry": {"type": "Point", "coordinates": [26.630347386076547, 53.766212551116084]}},
        {"type": "Feature", "properties": {"name": "Дзержинский"},
            "geometry": {"type": "Point", "coordinates": [27.22184819319979, 53.63592459522003]}},
        {"type": "Feature", "properties": {"name": "Минский"},
            "geometry": {"type": "Point", "coordinates": [27.49149333658571, 54.01891404899421]}},
        {"type": "Feature", "properties": {"name": "Пуховичский"},
            "geometry": {"type": "Point", "coordinates": [28.037399400876602, 53.42589116399191]}},
        {"type": "Feature", "properties": {"name": "Червенский"},
            "geometry": {"type": "Point", "coordinates": [28.41367845123888, 53.75958271238335]}},
        {"type": "Feature", "properties": {"name": "Березинский"},
            "geometry": {"type": "Point", "coordinates": [29.047851562500004, 53.891391285752874]}},
        {"type": "Feature", "properties": {"name": "Смолевичский"},
            "geometry": {"type": "Point", "coordinates": [28.170085965330074, 54.07158556363806]}},
        {"type": "Feature", "properties": {"name": "Воложинский"},
            "geometry": {"type": "Point", "coordinates": [26.71045335451342, 54.02911635160998]}},
        {"type": "Feature", "properties": {"name": "Молодечненский"},
            "geometry": {"type": "Point", "coordinates": [26.980973651347362, 54.21309239315867]}},
        {"type": "Feature", "properties": {"name": "Вилейский"},
            "geometry": {"type": "Point", "coordinates": [27.081298828125004, 54.597527852113885]}},
        {"type": "Feature", "properties": {"name": "Логойский"},
            "geometry": {"type": "Point", "coordinates": [27.8373234232168, 54.38197824690591]}},
        {"type": "Feature", "properties": {"name": "Борисовский"},
            "geometry": {"type": "Point", "coordinates": [28.475113941123634, 54.3666409841558]}},
        {"type": "Feature", "properties": {"name": "Крупский"},
            "geometry": {"type": "Point", "coordinates": [29.133706707063123, 54.46030735273144]}},
        {"type": "Feature", "properties": {"name": "Мядельский"},
            "geometry": {"type": "Point", "coordinates": [26.924405090850993, 54.85501645777829]}},

        {"type": "Feature", "properties": {"name": "Глусский"},
            "geometry": {"type": "Point", "coordinates": [28.707275390625004, 52.84591235390171]}},
        {"type": "Feature", "properties": {"name": "Бобруйский"},
            "geometry": {"type": "Point", "coordinates": [29.289550781250004, 53.037910202051876]}},
        {"type": "Feature", "properties": {"name": "Осиповичский"},
            "geometry": {"type": "Point", "coordinates": [28.751220703125004, 53.370220573956786]}},
        {"type": "Feature", "properties": {"name": "Кировский"},
            "geometry": {"type": "Point", "coordinates": [29.454345703125004, 53.27506837459297]}},
        {"type": "Feature", "properties": {"name": "Кличевский"},
            "geometry": {"type": "Point", "coordinates": [29.3939208984375, 53.57946149373232]}},
        {"type": "Feature", "properties": {"name": "Быховский"},
            "geometry": {"type": "Point", "coordinates": [30.206909179687504, 53.537042913738745]}},
        {"type": "Feature", "properties": {"name": "Славгородский"},
            "geometry": {"type": "Point", "coordinates": [30.942993164062504, 53.40625729970218]}},
        {"type": "Feature", "properties": {"name": "Краснопольский"},
            "geometry": {"type": "Point", "coordinates": [31.420898437500004, 53.26849833145894]}},
        {"type": "Feature", "properties": {"name": "Костюковичский"},
            "geometry": {"type": "Point", "coordinates": [32.09106445312501, 53.16982647814065]}},
        {"type": "Feature", "properties": {"name": "Хотимский"},
            "geometry": {"type": "Point", "coordinates": [32.52502441406251, 53.41280615440963]}},
        {"type": "Feature", "properties": {"name": "Климовичский"},
            "geometry": {"type": "Point", "coordinates": [32.08007812500001, 53.563151688426984]}},
        {"type": "Feature", "properties": {"name": "Чериковский"},
            "geometry": {"type": "Point", "coordinates": [31.393432617187504, 53.6348677883201]}},
        {"type": "Feature", "properties": {"name": "Кричевский"},
            "geometry": {"type": "Point", "coordinates": [31.624145507812504, 53.771442468556074]}},
        {"type": "Feature", "properties": {"name": "Чаусский"},
            "geometry": {"type": "Point", "coordinates": [31.036376953125004, 53.875202055794965]}},
        {"type": "Feature", "properties": {"name": "Могилевский"},
            "geometry": {"type": "Point", "coordinates": [30.206909179687504, 53.79740645735382]}},
        {"type": "Feature", "properties": {"name": "Белыничский"},
            "geometry": {"type": "Point", "coordinates": [29.729003906250004, 53.94638778530838]}},
        {"type": "Feature", "properties": {"name": "Круглянский"},
            "geometry": {"type": "Point", "coordinates": [29.750976562500004, 54.23955053156179]}},
        {"type": "Feature", "properties": {"name": "Шкловский"},
            "geometry": {"type": "Point", "coordinates": [30.349731445312504, 54.14313233476031]}},
        {"type": "Feature", "properties": {"name": "Дрибинский"},
            "geometry": {"type": "Point", "coordinates": [30.981445312500004, 54.05616356873164]}},
        {"type": "Feature", "properties": {"name": "Мстиславский"},
            "geometry": {"type": "Point", "coordinates": [31.618652343750004, 53.96254944195083]}},
        {"type": "Feature", "properties": {"name": "Горецкий"},
            "geometry": {"type": "Point", "coordinates": [30.926513671875, 54.34535094489879]}},

        {"type": "Feature", "properties": {"name": "Докшицкий"},
            "geometry": {"type": "Point", "coordinates": [27.960205078125004, 54.87028529268185]}},
        {"type": "Feature", "properties": {"name": "Лепельский"},
            "geometry": {"type": "Point", "coordinates": [28.718261718750004, 54.93661015660588]}},
        {"type": "Feature", "properties": {"name": "Чашникский"},
            "geometry": {"type": "Point", "coordinates": [29.163208007812504, 54.70558168515836]}},
        {"type": "Feature", "properties": {"name": "Толочинский"},
            "geometry": {"type": "Point", "coordinates": [29.772949218750004, 54.422126065167866]}},
        {"type": "Feature", "properties": {"name": "Оршанский"},
            "geometry": {"type": "Point", "coordinates": [30.245361328125004, 54.61661705439048]}},
        {"type": "Feature", "properties": {"name": "Дубровенский"},
            "geometry": {"type": "Point", "coordinates": [30.953979492187504, 54.559322587438636]}},
        {"type": "Feature", "properties": {"name": "Сенненский"},
            "geometry": {"type": "Point", "coordinates": [29.899291992187504, 54.82600799909498]}},
        {"type": "Feature", "properties": {"name": "Лиозненский"},
            "geometry": {"type": "Point", "coordinates": [30.701293945312504, 54.99337311367355]}},
        {"type": "Feature", "properties": {"name": "Бешенковичский"},
            "geometry": {"type": "Point", "coordinates": [29.509277343750004, 55.0217245215306]}},
        {"type": "Feature", "properties": {"name": "Витебский"},
            "geometry": {"type": "Point", "coordinates": [30.371704101562504, 55.294756169220264]}},
        {"type": "Feature", "properties": {"name": "Шумилинский"},
            "geometry": {"type": "Point", "coordinates": [29.448852539062504, 55.3322691334024]}},
        {"type": "Feature", "properties": {"name": "Городокский"},
            "geometry": {"type": "Point", "coordinates": [30.130004882812504, 55.658996099428364]}},
        {"type": "Feature", "properties": {"name": "Ушачский"},
            "geometry": {"type": "Point", "coordinates": [28.734741210937504, 55.17259379606185]}},
        {"type": "Feature", "properties": {"name": "Глубокский"},
            "geometry": {"type": "Point", "coordinates": [27.877807617187504, 55.22432367289142]}},
        {"type": "Feature", "properties": {"name": "Поставский"},
            "geometry": {"type": "Point", "coordinates": [27.064819335937504, 55.163181143473714]}},
        {"type": "Feature", "properties": {"name": "Шарковщинский"},
            "geometry": {"type": "Point", "coordinates": [27.57156372070313, 55.3791104480105]}},
        {"type": "Feature", "properties": {"name": "Браславский"},
            "geometry": {"type": "Point", "coordinates": [26.982421875000004, 55.52863052257191]}},
        {"type": "Feature", "properties": {"name": "Миорский"},
            "geometry": {"type": "Point", "coordinates": [27.803649902343754, 55.6078327003827]}},
        {"type": "Feature", "properties": {"name": "Верхнедвинский"},
            "geometry": {"type": "Point", "coordinates": [28.108520507812504, 55.91842985630817]}},
        {"type": "Feature", "properties": {"name": "Россонский"},
            "geometry": {"type": "Point", "coordinates": [28.948974609375004, 55.8444821875883]}},
        {"type": "Feature", "properties": {"name": "Полоцкий"},
            "geometry": {"type": "Point", "coordinates": [29.025878906250004, 55.58144971869657]}},

        {"type": "Feature", "properties": {"name": "Островецкий"},
            "geometry": {"type": "Point", "coordinates": [26.114501953125004, 54.7943516039205]}},
        {"type": "Feature", "properties": {"name": "Сморгонский"},
            "geometry": {"type": "Point", "coordinates": [26.455078125000004, 54.532238849162084]}},
        {"type": "Feature", "properties": {"name": "Ошмянский"},
            "geometry": {"type": "Point", "coordinates": [25.900268554687504, 54.34535094489879]}},
        {"type": "Feature", "properties": {"name": "Ивьевский"},
            "geometry": {"type": "Point", "coordinates": [25.911254882812504, 54.01099683495081]}},
        {"type": "Feature", "properties": {"name": "Вороновский"},
            "geometry": {"type": "Point", "coordinates": [25.158691406250004, 54.11416300731598]}},
        {"type": "Feature", "properties": {"name": "Лидский"},
            "geometry": {"type": "Point", "coordinates": [25.328979492187504, 53.91081008725412]}},
        {"type": "Feature", "properties": {"name": "Новогрудский"},
            "geometry": {"type": "Point", "coordinates": [25.784912109375004, 53.6348677883201]}},
        {"type": "Feature", "properties": {"name": "Кореличский"},
            "geometry": {"type": "Point", "coordinates": [26.229858398437504, 53.45534913802113]}},
        {"type": "Feature", "properties": {"name": "Дятловский"},
            "geometry": {"type": "Point", "coordinates": [25.372924804687504, 53.4357192066942]}},
        {"type": "Feature", "properties": {"name": "Щучинский"},
            "geometry": {"type": "Point", "coordinates": [24.702758789062504, 53.66417110963306]}},
        {"type": "Feature", "properties": {"name": "Гродненский"},
            "geometry": {"type": "Point", "coordinates": [24.060058593750004, 53.77793497204605]}},
        {"type": "Feature", "properties": {"name": "Мостовский"},
            "geometry": {"type": "Point", "coordinates": [24.444580078125004, 53.45534913802113]}},
        {"type": "Feature", "properties": {"name": "Берестовицкий"},
            "geometry": {"type": "Point", "coordinates": [23.988647460937504, 53.32759237756109]}},
        {"type": "Feature", "properties": {"name": "Волковысский"},
            "geometry": {"type": "Point", "coordinates": [24.39102172851563, 53.186287573913305]}},
        {"type": "Feature", "properties": {"name": "Слонимский"},
            "geometry": {"type": "Point", "coordinates": [25.2685546875, 53.037910202051876]}},
        {"type": "Feature", "properties": {"name": "Зельвенский"},
            "geometry": {"type": "Point", "coordinates": [24.889526367187504, 53.11710851455026]}},
        {"type": "Feature", "properties": {"name": "Свислочский"},
            "geometry": {"type": "Point", "coordinates": [24.257812500000004, 52.86912972768522]}}




    ]


};



var pointLayer = L.geoJSON(null, {
    pointToLayer: function (feature, latlng) {
        label = String(feature.properties.name) // .bindTooltip can't use straight 'feature.properties.attribute'
        return new L.CircleMarker(latlng, {
            radius: 0.1
        }).bindTooltip(label, {permanent: true, direction: "center", className: "my-labels"}).openTooltip();
    }
});
pointLayer.addData(data_points);


map.on('zoomend ', function (e) {
    if (map.getZoom() === 8 || map.getZoom() === 9 || map.getZoom() === 10) {


        var is_show = $('#show_name_local').is(":checked");
        if (is_show)
            show_name_local(1);
        //map.addLayer(pointLayer);
        $('#div_id_show_name_local').show();

    } else {
        // pointLayer.
        map.removeLayer(pointLayer);
        $('#div_id_show_name_local').hide();
    }
});




function show_name_local(is_show) {

    if (is_show === 1) {
        map.addLayer(pointLayer);
    } else {
        map.removeLayer(pointLayer);
    }
}

/*-------------------- END name of locals  ------------------*/




/*------ Legend specific -------*/
var legend = L.control({position: "bottomleft"});


legend.onAdd = function (map) {
    var div = L.DomUtil.create("div", "legend");
    div.setAttribute("style", "line-height: 18px; width: 200px;");
    div.innerHTML += "<h4>Обозначения</h4>";
    div.innerHTML += '<img src="assets/leaflet/images/marker-icon.png" style="height:27px;" ></i><span style="bottom:-4px">ПАСЧ, ПАСП</span><br><br>';
    div.innerHTML += '<img src="assets/leaflet/images/marker-icon-violet.png" style="height:27px;" ></i><span style="bottom:-4px">ПАСО</span><br><br>';
    div.innerHTML += '<img src="assets/leaflet/images/marker-icon-red.png" style="height:27px"></i><span style="bottom:-4px">Отдел</span><br>';

    return div;
};

legend.addTo(map);
/*------ END Legend specific ------*/

//$(document).on("ajaxSend", function() {
//    $("#loading").show(); // показываем элемент
//    toastr.warning('Данные успешно получены', 'Успех!', {progressBar: true, timeOut: 5000});
//}).on("ajaxStop", function(){
//    $("#loading").hide(); // скрываем элемент
//});

/* show podrazdelenia from kusis */
$('body').on('click', '#show_podr', function (e) {
    e.preventDefault();

//if ($('#is_str').is(':checked')===true)  is_str = 1; else  is_str = 0;

    var data = $('#showPodrForm').serialize();
//console.log('is_str='+$('#is_str').is(':checked'));
//data.push({name: "is_str", value: is_str});


    $.post('/journal/maps_for_mes/getjson', data, function (response) {
        // console.log(response.points);
        if (response.points.length > 0) {
            addCarFilterDataToMap(response.points, map, 1);

            toastr.success('Данные успешно получены', 'Успех!', {progressBar: true, timeOut: 5000});
        } else {
            if (markerPodr !== undefined) {
                map.removeLayer(markerPodr);
            }
            if (theMarker !== undefined) {
                map.removeLayer(theMarker);
            }

            toastr.error(response.error, 'Ошибка!', {progressBar: true, timeOut: 5000});
        }

        getNewRightTable(response.right_table);

        /* bread crumb */
        var is_name_car = $('#id_name_car_map').val();
        var is_region = $('#id_region_map').val();
        var is_grochs = $('#id_local_map').val();


        var name_car = $('#id_name_car_map option:selected').toArray().map(item => item.text).join(', ');
        var region = $('#id_region_map option:selected').toArray().map(item => item.text).join(', ');
        var grochs = $('#id_local_map option:selected').toArray().map(item => item.text).join(', ');
        var bread_crumb = 'Информация по запросу: ';

        var arr = [];

        if (is_name_car === null) {

        } else {
            arr.push(name_car);

        }
        if (is_region === null) {

        } else {
            arr.push('<u>' + region + '</u>');

        }

        if (is_grochs === null) {

        } else {
            arr.push(grochs);

        }


        if (arr.length > 0) {
            bread_crumb = bread_crumb + '' + arr.join(' - ');

            $('#bread_crumb').html(bread_crumb);
        }


        // console.log(bread_crumb);


    }, 'json');

    //getRightTable();

});


/* reset filter */
$('body').on('click', '#reset_filter', function (e) {

    if (markerPodr !== undefined) {
        map.removeLayer(markerPodr);

    }

    if (theMarker !== undefined) {
        map.removeLayer(theMarker);

    }

    $('#id_name_car_map').val('').select2({
        placeholder: "Наименование техники"
    }).trigger('chosen:updated');

    $('#id_region_map').val('').select2({
        placeholder: "Область"
    }).trigger('change');
    $('#id_local_map').empty().trigger('chosen:updated');
    $('#id_pasp_map').empty().trigger('chosen:updated');

    $('#id_ob_car_map').val('').select2({
        placeholder: "Объем цистерны, тонны"
    }).trigger('change');
    $('#id_vid_car_map').val('').select2({
        placeholder: "Вид техники"
    }).trigger('change');
    $('#id_type_car_map').val('').select2().trigger('change');


    //$('#theme_panel_inner_table').html('нет данных для отображения');
    $('#theme_panel_inner_table #table-right-maps-for-mes tbody').html('');
    $('#theme_panel_inner_table #table-right-maps-for-mes tbody').html('нет данных для отображения');
    $('#bread_crumb').html('');

    //$('#is_str').prop('checked',false);


});


/* default markers - rigs */
$.getJSON("/journal/maps_for_mes/getjson", function (data) {
    addDataToMap(data.points, map);
    //getRightTable();
    //console.log(data.right_table);
    getNewRightTable(data.right_table);
});

var theMarker = {};
var markerPodr = {};
function addDataToMap(data, map) {

    /* remove old markers */
    if (theMarker !== undefined) {
        //map.removeLayer(theMarker);
    }


    var dataLayer = L.geoJson(data);
    dataLayer.addTo(map);

    var featureArr = [];

    for (var i in data) {

        var geojsonFeature = {

            "type": "Feature",

            "geometry": data[i].location,

            properties: {
//      title: 'Title',
//      description: 'Text, text...',
//      image: 'http://link...',
                icon: {
                    iconUrl: data[i].new_icon,
                    iconSize: [50, 64],
                    iconAnchor: [0, 0],
                    popupAnchor: [0, 0],
                    className: 'dot'
                }
            },

            "customizeView": Math.floor(Math.random() * 2) // случайно 0 или 1

        };


        if (data[i].hasOwnProperty('cnt_cars') && data[i].hasOwnProperty('cnt_cars') !== '' && data[i].hasOwnProperty('cnt_cars') !== 0) {
            var cnt_cars = data[i].cnt_cars;
        } else {
            var cnt_cars = 0;
        }



        if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {

            //geojsonFeature.properties.icon = new L.NumberedIconRed({number: data[i].ppp});

            if (data[i].hasOwnProperty('show_number_pasp') && data[i].show_number_pasp === 1) {//extra marker
                if (data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1) {//show name: PASO, ROSN....
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'red',
                        shape: 'circle',
                        prefix: 'fa',
                        //number: data[i].extra_pasp_num,
                        number_cars: cnt_cars,
                        name_pasp: data[i].extra_pasp_num
                    });
                } else {
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'red',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars
                    });
                }
            } else {
                geojsonFeature.properties.icon = new L.NumberedIconRed({number: cnt_cars});
            }


        } else if (data[i].hasOwnProperty('is_paso') && data[i].is_paso === 1) {//paso


            //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: data[i].ppp});

            if (data[i].hasOwnProperty('show_number_pasp') && data[i].show_number_pasp === 1) {

                if (data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1) {//show name: PASO, ROSN....
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'violet',
                        shape: 'circle',
                        prefix: 'fa',
                        //number: data[i].extra_pasp_num,
                        number_cars: cnt_cars,
                        name_pasp: data[i].extra_pasp_num
                    });
                } else {
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'violet',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars

                    });
                }
            } else {
                geojsonFeature.properties.icon = new L.NumberedIconViolet({number: cnt_cars});
            }
        } else {


            //var numberMarker = new L.NumberedDivIcon({number: data[i].ppp});
            if (data[i].hasOwnProperty('show_number_pasp') && data[i].show_number_pasp === 1) {
                if (data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1) {//show name: PASO, ROSN....
                    var numberMarker = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'blue',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars
                    });

                } else {
                    var numberMarker = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'blue',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars
                    });
                }
            } else {
                var numberMarker = new L.NumberedDivIcon({number: cnt_cars});
            }


            geojsonFeature.properties.icon = numberMarker;
        }


//
//        if (data[i].hasOwnProperty('cnt_cars') && data[i].hasOwnProperty('cnt_cars') !== '' && data[i].hasOwnProperty('cnt_cars') !== 0) {
//
//            if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
//                //geojsonFeature.properties.icon = new L.NumberedIconRed({number: data[i].cnt_cars});
//                //geojsonFeature.properties.icon = new L.NumberedIconRed({number: data[i].ppp});
//                geojsonFeature.properties.icon =  L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'red',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars
//                });
//
//            } else if (data[i].hasOwnProperty('is_paso') && data[i].is_paso === 1) {//paso
//                //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: data[i].cnt_cars});
//                //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: data[i].ppp});
//                geojsonFeature.properties.icon = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'violet',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    //number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars,
//                    name_pasp: data[i].extra_pasp_num
//                });
//            } else {
//
//                //var numberMarker = new L.NumberedDivIcon({number: data[i].cnt_cars});
//                //var numberMarker = new L.NumberedDivIcon({number: data[i].ppp});
//
//                if(data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1){//show name: PASO, ROSN....
//                var numberMarker = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'blue',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    //number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars,
//                    name_pasp: data[i].extra_pasp_num
//                });
//
//                }
//                else{
//                   var numberMarker = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'blue',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars
//                });
//                }
//
//
//                geojsonFeature.properties.icon = numberMarker;
//            }
//
//        } else {
//            if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
//
//                //geojsonFeature.properties.icon = new L.NumberedIconRed({number: '0'});
//
//                geojsonFeature.properties.icon =  L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'red',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: 0
//
//                });
//
//            } else if (data[i].hasOwnProperty('is_paso') && data[i].is_paso === 1) {
//                //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: '0'});
//                geojsonFeature.properties.icon = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'violet',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: 0
//
//                });
//            } else {
//
//                //var numberMarker = new L.NumberedDivIcon({number: '0'});
//                var numberMarker = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'blue',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: 0
//
//                });
//                geojsonFeature.properties.icon = numberMarker;
//            }
//        }




        var content_popup = '';
        if (data[i].hasOwnProperty('address'))
            var content_popup = '<b>' + data[i].address + '</b>';


        if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
            if (data[i].hasOwnProperty('note_otdel') && data[i].note_otdel !== '') {
                var content_popup = content_popup + ' <i>(' + 'отдел' + ' ' + data[i].note_otdel + ')</i>';
            } else
                var content_popup = content_popup + ' <i>(' + 'отдел' + ')</i>';
        }


        if (data[i].hasOwnProperty('disloc') && data[i].hasOwnProperty('disloc') !== '') {
            var content_popup = content_popup + '</br>' + data[i].disloc;
        }

//            if(data[i].hasOwnProperty('mark') && data[i].hasOwnProperty('mark') !== '') {
//                var content_popup=content_popup+'</br>'+'<b>'+ data[i].mark+'</b>';
//            }


        if (data[i].hasOwnProperty('dateduty'))
            var content_popup = content_popup + '</br>дата дежурства: ' + data[i].dateduty;

        if (data[i].hasOwnProperty('ch'))
            var content_popup = content_popup + ' (смена ' + data[i].ch + ')';


        if (data[i].hasOwnProperty('all_mark') && data[i].hasOwnProperty('all_mark') !== '') {
            var content_popup = content_popup + '</br>' + '<b>' + data[i].all_mark + '</b>';
        }



        if (data[i].hasOwnProperty('ss_url_text') && data[i].hasOwnProperty('ss_url_text') !== '')
            var ss_url_text = data[i].ss_url_text;

        if (data[i].hasOwnProperty('ss_url'))
            //var content_popup = content_popup + '</br>' + '<a href="' + data[i].ss_url + '" target="_blank">' + ss_url_text + ' </a>';
            var content_popup = content_popup + '</br>' + '<a href="#" class="btn-show-modal-ss" data-toggle="modal" data-target="#modal-show-ss" data-url="' + data[i].ss_url + '">' + ss_url_text + ' </a>';




        geojsonFeature.popupContent = content_popup;
        featureArr.push(geojsonFeature);

    }

    function onEachFeature(feature, layer) {

        if (feature.hasOwnProperty('popupContent'))
            layer.bindPopup(feature.popupContent);

        if (feature.hasOwnProperty('properties') && feature.properties.hasOwnProperty('icon') && feature.properties.icon.hasOwnProperty('iconUrl') && feature.properties.icon.iconUrl !== 'undefined' && feature.properties.icon.iconUrl !== undefined) {
            layer.setIcon(L.icon(feature.properties.icon));
        }



    }

    var geojsonMarkerOptions = {

        radius: 8, //радиус в пикселях

        fillColor: "#ff7800",

        color: "#000",

        weight: 1,

        opacity: 1,

        fillOpacity: 0.8

    };

    function pointToLayer(feature, latlng) {

        // if(feature.customizeView)
//theMarker.push(L.marker(latlng)) ;

        // Creates a red marker with the coffee icon


        return  L.marker(latlng, {icon:
                    feature.properties.icon
                    //new L.NumberedDivIcon({number: '1'})
        });

        //  else

        //return L.circleMarker(latlng, geojsonMarkerOptions);
        // return L.marker(latlng, {icon: greenIcon});

    }
    ;




    var s = L.geoJson(featureArr, {

        onEachFeature: onEachFeature,

        pointToLayer: pointToLayer

    }).addTo(map);

    theMarker = s;

}


/* add podr to map AFTER FILTER !!!!!!!!!!!!!!!!!! */
function addCarFilterDataToMap(data, map, mark_podr = 0) {

    /* remove old markers */
    if (theMarker !== undefined) {
        map.removeLayer(theMarker);
    }

    if (markerPodr !== undefined) {
        map.removeLayer(markerPodr);
    }


    var dataLayer = L.geoJson(data);
    dataLayer.addTo(map);

    var featureArr = [];

    for (var i in data) {

        var geojsonFeature = {

            "type": "Feature",

            "geometry": data[i].location,

            properties: {
//      title: 'Title',
//      description: 'Text, text...',
//      image: 'http://link...',
                icon: {
                    iconUrl: data[i].new_icon,
                    iconSize: [50, 64],
                    iconAnchor: [0, 0],
                    popupAnchor: [0, 0],
                    className: 'dot'
                }
            },

            "customizeView": Math.floor(Math.random() * 2) // случайно 0 или 1

        };


        if (data[i].hasOwnProperty('new_icon') && data[i].hasOwnProperty('new_icon') !== '') {
            geojsonFeature.properties.icon = {
                iconUrl: data[i].new_icon,
                iconSize: [50, 64],
                iconAnchor: [0, 0],
                popupAnchor: [0, 0],
                className: 'dot'
            };
        }




        if (data[i].hasOwnProperty('cnt_cars') && data[i].hasOwnProperty('cnt_cars') !== '' && data[i].hasOwnProperty('cnt_cars') !== 0) {
            var cnt_cars = data[i].cnt_cars;
        } else {
            var cnt_cars = 0;
        }



        if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
            //geojsonFeature.properties.icon = new L.NumberedIconRed({number: data[i].ppp});

            if (data[i].hasOwnProperty('show_number_pasp') && data[i].show_number_pasp === 1) {
                if (data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1) {//show name: PASO, ROSN....
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'red',
                        shape: 'circle',
                        prefix: 'fa',
                        //number: data[i].extra_pasp_num,
                        number_cars: cnt_cars,
                        name_pasp: data[i].extra_pasp_num
                    });
                } else {
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'red',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars
                    });
                }

            } else {
                geojsonFeature.properties.icon = new L.NumberedIconRed({number: cnt_cars});
            }


        } else if (data[i].hasOwnProperty('is_paso') && data[i].is_paso === 1) {//paso

            //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: data[i].ppp});


            if (data[i].hasOwnProperty('show_number_pasp') && data[i].show_number_pasp === 1) {
                if (data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1) {//show name: PASO, ROSN....
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'violet',
                        shape: 'circle',
                        prefix: 'fa',
                        //number: data[i].extra_pasp_num,
                        number_cars: cnt_cars,
                        name_pasp: data[i].extra_pasp_num
                    });
                } else {
                    geojsonFeature.properties.icon = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'violet',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars

                    });
                }
            } else {
                geojsonFeature.properties.icon = new L.NumberedIconViolet({number: cnt_cars});
            }
        } else {

            //var numberMarker = new L.NumberedDivIcon({number: data[i].ppp});

            if (data[i].hasOwnProperty('show_number_pasp') && data[i].show_number_pasp === 1) {
                if (data[i].hasOwnProperty('extra_pasp_name_or_number') && data[i].extra_pasp_name_or_number === 1) {//show name: PASO, ROSN....
                    var numberMarker = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'blue',
                        shape: 'circle',
                        prefix: 'fa',
                        //number: data[i].extra_pasp_num,
                        number_cars: cnt_cars,
                        name_pasp: data[i].extra_pasp_num
                    });

                } else {
                    var numberMarker = L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        markerColor: 'blue',
                        shape: 'circle',
                        prefix: 'fa',
                        number: data[i].extra_pasp_num,
                        number_cars: cnt_cars
                    });
                }

            } else {
                var numberMarker = new L.NumberedDivIcon({number: cnt_cars});
            }


            geojsonFeature.properties.icon = numberMarker;
        }




//
//        if (data[i].hasOwnProperty('cnt_cars') && data[i].hasOwnProperty('cnt_cars') !== '' && data[i].hasOwnProperty('cnt_cars') !== 0) {
//
//            if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
//
//                //geojsonFeature.properties.icon = new L.NumberedIconRed({number: data[i].cnt_cars});
//                //geojsonFeature.properties.icon = new L.NumberedIconRed({number: data[i].ppp});
//                geojsonFeature.properties.icon =  L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'red',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars
//                });
//
//            } else if (data[i].hasOwnProperty('is_paso') && data[i].is_paso === 1) {
//                //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: data[i].cnt_cars});
//                //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: data[i].ppp});
//                geojsonFeature.properties.icon = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'violet',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars
//                });
//            } else {
//
//                //var numberMarker = new L.NumberedDivIcon({number: data[i].cnt_cars});
//                 //var numberMarker = new L.NumberedDivIcon({number: data[i].ppp});
//                var numberMarker = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'blue',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: data[i].cnt_cars
//                });
//                geojsonFeature.properties.icon = numberMarker;
//            }
//
//        } else {
//            if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
//
//                //geojsonFeature.properties.icon = new L.NumberedIconRed({number: '0'});
//                geojsonFeature.properties.icon =  L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'red',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: 0
//                });
//
//            } else if (data[i].hasOwnProperty('is_paso') && data[i].is_paso === 1) {
//                //geojsonFeature.properties.icon = new L.NumberedIconViolet({number: '0'});
//                geojsonFeature.properties.icon = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'violet',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: 0
//                });
//            } else {
//
//                //var numberMarker = new L.NumberedDivIcon({number: '0'});
//                var numberMarker = L.ExtraMarkers.icon({
//                    icon: 'fa-number',
//                    markerColor: 'blue',
//                    shape: 'circle',
//                    prefix: 'fa',
//                    number: data[i].extra_pasp_num,
//                    number_cars: 0
//                });
//                geojsonFeature.properties.icon = numberMarker;
//            }
//        }

        var content_popup = '';

        if (data[i].hasOwnProperty('address'))
            var content_popup = '<b>' + data[i].address + '</b>';


        if (data[i].hasOwnProperty('is_otdel') && data[i].is_otdel === 1) {
            if (data[i].hasOwnProperty('note_otdel') && data[i].note_otdel !== '') {
                var content_popup = content_popup + ' <i>(' + 'отдел' + ' ' + data[i].note_otdel + ')</i>';
            } else
                var content_popup = content_popup + ' <i>(' + 'отдел' + ')</i>';
        }


        if (data[i].hasOwnProperty('disloc') && data[i].hasOwnProperty('disloc') !== '') {
            var content_popup = content_popup + '</br>' + data[i].disloc;
        }

//            if(data[i].hasOwnProperty('mark') && data[i].hasOwnProperty('mark') !== '') {
//                var content_popup=content_popup+'</br>'+'<b>'+ data[i].mark+'</b>';
//            }


        if (data[i].hasOwnProperty('dateduty'))
            var content_popup = content_popup + '</br>дата дежурства: ' + data[i].dateduty;

        if (data[i].hasOwnProperty('ch'))
            var content_popup = content_popup + ' (смена ' + data[i].ch + ')';

        if (data[i].hasOwnProperty('all_mark') && data[i].hasOwnProperty('all_mark') !== '') {
            var content_popup = content_popup + '</br>' + '<b>' + data[i].all_mark + '</b>';
        }



        if (data[i].hasOwnProperty('ss_url_text') && data[i].hasOwnProperty('ss_url_text') !== '')
            var ss_url_text = data[i].ss_url_text;

        if (data[i].hasOwnProperty('ss_url'))
            //var content_popup = content_popup + '</br>' + '<a href="' + data[i].ss_url + '" target="_blank">' + ss_url_text + ' </a>';
            var content_popup = content_popup + '</br>' + '<a href="#" class="btn-show-modal-ss" data-toggle="modal" data-target="#modal-show-ss" data-url="' + data[i].ss_url + '">' + ss_url_text + ' </a>';



        geojsonFeature.popupContent = content_popup;
        featureArr.push(geojsonFeature);

    }

    function onEachFeature(feature, layer) {

        if (feature.hasOwnProperty('popupContent'))
            layer.bindPopup(feature.popupContent);

        if (feature.hasOwnProperty('properties') && feature.properties.hasOwnProperty('icon') && feature.properties.icon.hasOwnProperty('iconUrl') && feature.properties.icon.iconUrl !== 'undefined' && feature.properties.icon.iconUrl !== undefined) {
            layer.setIcon(L.icon(feature.properties.icon));
        }

    }

    var geojsonMarkerOptions = {

        radius: 8, //радиус в пикселях

        fillColor: "#ff7800",

        color: "#000",

        weight: 1,

        opacity: 1,

        fillOpacity: 0.8

    };

    function pointToLayer(feature, latlng) {

        // if(feature.customizeView)
//theMarker.push(L.marker(latlng)) ;

        return  L.marker(latlng, {icon:
                    feature.properties.icon
                    //new L.NumberedDivIcon({number: '1'})
        });

        //  else

        //return L.circleMarker(latlng, geojsonMarkerOptions);
        // return L.marker(latlng, {icon: greenIcon});

    }
    ;




    var s = L.geoJson(featureArr, {

        onEachFeature: onEachFeature,

        pointToLayer: pointToLayer

    }).addTo(map);

    /* centered */
    map.fitBounds(s.getBounds());

    if (mark_podr === 1) {
        markerPodr = s;
}


}





/* get data for right table */
function getRightTable() {
    $.post('/journal/maps_for_mes/get_right_table', $('#showPodrForm').serialize(), function (response) {
        console.log(response.length);
        if (response.length > 0) {

            $('#theme_panel_inner_table').html(response);


        } else {
            $('#theme_panel_inner_table').html('нет данных для отображения');
        }

    });
}
function getNewRightTable(table) {

    var tbody = $('#theme_panel_inner_table #table-right-maps-for-mes tbody ');
    if (table.length > 0) {
//console.log(table);

        tbody.html('');

        $(table).each(function (index, value) {


            var tr = tbody.append($("<tr></tr>"));
            tr.append($("<td></td>").text(value.name));
            tr.append($("<td></td>").text(value.cnt));


        });



    } else {
        $('#theme_panel_inner_table #table-right-maps-for-mes tbody').html('');
        $('#theme_panel_inner_table #table-right-maps-for-mes tbody').html('нет данных для отображения');
    }
}


//
L.NumberedDivIcon = L.Icon.extend({
    options: {
        // EDIT THIS TO POINT TO THE FILE AT http://www.charliecroom.com/marker_hole.png (or your own marker)
        iconUrl: 'assets/leaflet/images/marker-icon.png',
        number: '',
        shadowUrl: null,
        iconSize: new L.Point(25, 41),
        iconAnchor: new L.Point(13, 41),
        popupAnchor: new L.Point(0, -33),
        /*
         iconAnchor: (Point)
         popupAnchor: (Point)
         */
        className: 'leaflet-div-icon'
    },

    createIcon: function () {
        var div = document.createElement('div');
        var img = this._createImg(this.options['iconUrl']);
        var numdiv = document.createElement('div');
        numdiv.setAttribute("class", "number");
        numdiv.setAttribute('style', "margin-left:10px");
        numdiv.innerHTML = this.options['number'] || '';
        div.appendChild(img);
        div.appendChild(numdiv);
        this._setIconStyles(div, 'icon');
        return div;
    },

    //you could change this to add a shadow like in the normal marker if you really wanted
    createShadow: function () {
        return null;
    }
});



L.NumberedIconGold = L.Icon.extend({
    options: {
        // EDIT THIS TO POINT TO THE FILE AT http://www.charliecroom.com/marker_hole.png (or your own marker)
        iconUrl: 'assets/leaflet/images/marker-icon-gold.png',
        number: '',

        iconSize: new L.Point(25, 41),
        iconAnchor: new L.Point(13, 41),
        popupAnchor: new L.Point(0, -33),
        /*
         iconAnchor: (Point)
         popupAnchor: (Point)
         */
        className: 'leaflet-div-icon'
    },

    createIcon: function () {
        var div = document.createElement('div');
        var img = this._createImg(this.options['iconUrl']);
        var numdiv = document.createElement('div');
        numdiv.setAttribute("class", "number");
        numdiv.setAttribute('style', "margin-left:10px");
        numdiv.innerHTML = this.options['number'] || '';
        div.appendChild(img);
        div.appendChild(numdiv);
        this._setIconStyles(div, 'icon');
        return div;
    },

    //you could change this to add a shadow like in the normal marker if you really wanted
    createShadow: function () {
        return null;
    }
});



L.NumberedIconRed = L.Icon.extend({
    options: {
        // EDIT THIS TO POINT TO THE FILE AT http://www.charliecroom.com/marker_hole.png (or your own marker)
        iconUrl: 'assets/leaflet/images/marker-icon-red.png',
        number: '',

        iconSize: new L.Point(25, 41),
        iconAnchor: new L.Point(13, 41),
        popupAnchor: new L.Point(0, -33),
        /*
         iconAnchor: (Point)
         popupAnchor: (Point)
         */
        className: 'leaflet-div-icon'
    },

    createIcon: function () {
        var div = document.createElement('div');
        var img = this._createImg(this.options['iconUrl']);
        var numdiv = document.createElement('div');
        numdiv.setAttribute("class", "number");
        numdiv.setAttribute('style', "margin-left:10px");
        numdiv.innerHTML = this.options['number'] || '';
        div.appendChild(img);
        div.appendChild(numdiv);
        this._setIconStyles(div, 'icon');
        return div;
    },

    //you could change this to add a shadow like in the normal marker if you really wanted
    createShadow: function () {
        return null;
    }
});


L.NumberedIconViolet = L.Icon.extend({
    options: {
        // EDIT THIS TO POINT TO THE FILE AT http://www.charliecroom.com/marker_hole.png (or your own marker)
        iconUrl: 'assets/leaflet/images/marker-icon-violet.png',
        number: '',

        iconSize: new L.Point(25, 41),
        iconAnchor: new L.Point(13, 41),
        popupAnchor: new L.Point(0, -33),
        /*
         iconAnchor: (Point)
         popupAnchor: (Point)
         */
        className: 'leaflet-div-icon'
    },

    createIcon: function () {
        var div = document.createElement('div');
        var img = this._createImg(this.options['iconUrl']);
        var numdiv = document.createElement('div');
        numdiv.setAttribute("class", "number");
        numdiv.setAttribute('style', "margin-left:10px");
        numdiv.innerHTML = this.options['number'] || '';
        div.appendChild(img);
        div.appendChild(numdiv);
        this._setIconStyles(div, 'icon');
        return div;
    },

    //you could change this to add a shadow like in the normal marker if you really wanted
    createShadow: function () {
        return null;
    }
});



map.on('click', function (e) {
    console.log(e.latlng);

});

