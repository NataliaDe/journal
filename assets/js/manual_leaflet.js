
/* types of layers */
var internetlayer =
        L.tileLayer('http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png', {id: 'mapid',
            maxZoom: 14,
            minZoom: 6
        });

baselayer =
        L.tileLayer('http://172.26.200.45/tile/map/{x}/{y}/{z}.png', {id: 'mapid',
            maxZoom: 14,
            minZoom: 6
// L.tileLayer('/journal/assets/tiles/{z}/{x}/{y}.png', {id:'mapid',
//            maxZoom: 14,
//            minZoom: 6
        });



var map = L.map('mapid', {attributionControl: false,
    layers: [internetlayer]
});
map.setView([53.900000, 27.566670], 6);
//        L.control.attribution({prefix:''}).addAttribution('<a href="http://maps.sputnik.ru/">Спутник</a> | &copy; Ростелеком | &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>').addTo(map);
//        L.tileLayer('http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png', {
//            maxZoom: 19
//        }).addTo(map);
// L.control.attribution({prefix:''}).addAttribution('<a href="http://maps.sputnik.ru/">Спутник</a> | &copy; Ростелеком | &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>').addTo(map);
//        L.tileLayer('http://172.26.200.45/tile/map/{x}/{y}/{z}.png', {
//            maxZoom: 14,
//            minZoom: 6
//        }).addTo(map);
// L.tileLayer('/journal/assets/Tiles/{z}/{x}/{y}.png', {
//            maxZoom: 19
//        }).addTo(map);

/* types of layers */
var baseMaps = {
    "Интернет-карта": internetlayer,
    "Базовая карта": baselayer
};
L.control.layers(baseMaps).addTo(map);
var baseMaps = {
    "<span style='color: gray'>Интернет-карта</span>": internetlayer,
    "Базовая карта": baselayer
};






/*------ Legend specific -------*/
var legend = L.control({position: "bottomleft"});



legend.onAdd = function (map) {
    var div = L.DomUtil.create("div", "legend");
//  div.innerHTML += "<h4>Обозначения</h4>";
//  div.innerHTML += '<i style="background: #477AC2"></i><span>Water</span><br>';
//  div.innerHTML += '<i style="background: #448D40"></i><span>Forest</span><br>';
//  div.innerHTML += '<i style="background: #E6E696"></i><span>Land</span><br>';
//  div.innerHTML += '<i style="background: #E8E6E0"></i><span>Residential</span><br>';
//  div.innerHTML += '<i style="background: #FFFFFF"></i><span>Ice</span><br>';
//  div.innerHTML += '<i class="icon" style="background-image: url(https://d30y9cdsu7xlg0.cloudfront.net/png/194515-200.png);background-repeat: no-repeat;"></i><span>Grænse</span><br>';

    div.innerHTML += "<h4>Обозначения</h4>";
    div.innerHTML += '<img src="assets/images/leaflet/fire.png"></i><span>Пожар</span><br>';
    div.innerHTML += '<img src="assets/images/leaflet/other.png"></i><span>Другие загорания</span><br>';
    div.innerHTML += '<img src="assets/images/leaflet/help.png"></i><span>Помощь организациям, населению</span><br>';
    div.innerHTML += '<img src="assets/images/leaflet/priroda.png"></i><span>ЛТТ</span><br>';
//  div.innerHTML += '<i style="background: #FFFFFF"></i><span>Ice</span><br>';
//  div.innerHTML += '<i class="icon" style="background-image: url(https://d30y9cdsu7xlg0.cloudfront.net/png/194515-200.png);background-repeat: no-repeat;"></i><span>Grænse</span><br>';


    return div;
};

legend.addTo(map);
/*------ END Legend specific ------*/




var greenIcon = L.icon({
    iconUrl: 'assets/images/leaflet/coffee.png',
    //shadowUrl: 'assets/images/leaflet/coffee-shadow.png',

    iconSize: [50, 64], // size of the icon
    shadowSize: [50, 64], // size of the shadow
    iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62], // the same for the shadow
    popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
});
//L.marker([53.901105, 27.546855], {icon: greenIcon}).addTo(map);

//         var data =[
//
//            { "_id" : { "$oid" : "55282f3b5c0dd1178d37f7a6" }, "date" : { "$date" : 1428707691703 }, "location" : { "type" : "Point", "coordinates" : [ 53.855383, 27.546803 ] }, "name" : "","new_icon":"assets/images/leaflet/coffee.png" },
//
//            { "_id" : { "$oid" : "55282f405c0dd1178d37f7a7" }, "date" : { "$date" : 1428707696350 }, "location" : { "type" : "Point", "coordinates" : [ 11, 2.4 ] }, "name" : "","new_icon":"assets/images/leaflet/teapot.png" },
//
//            { "_id" : { "$oid" : "55282f4a5c0dd1178d37f7a8" }, "date" : { "$date" : 1428707706604 }, "location" : { "type" : "Point", "coordinates" : [ 1, 2.4 ] }, "name" : "" ,"new_icon":"assets/images/leaflet/coffee.png"},
//
//            { "_id" : { "$oid" : "5528334b5c0dd1178d37f7a9" }, "date" : { "$date" : 1428708731758 }, "location" : { "type" : "Point", "coordinates" : [ 12, 2.4 ] }, "name" : "","new_icon":"assets/images/leaflet/menu.png" },
//
//            { "_id" : { "$oid" : "552833515c0dd1178d37f7aa" }, "date" : { "$date" : 1428708737813 }, "location" : { "type" : "Point", "coordinates" : [ 22, 2.4 ] }, "name" : "" ,"new_icon":"assets/images/leaflet/menu.png"},
//
//            { "_id" : { "$oid" : "552833515c0dd1178d37f7bb" }, "date" : { "$date" : 1428708737814 }, "location" : { "type" : "Point", "coordinates" : [ 24, 4.4 ] }, "name" : "point_GT_1318","new_icon":"assets/images/leaflet/teapot.png" },
//
//            { "_id" : { "$oid" : "552833515c0dd1178d37f7cc" }, "date" : { "$date" : 1428708737814 }, "location" : { "type" : "Point", "coordinates" : [ 24, 4.4 ] }, "name" : "point_GT_1319","new_icon":"assets/images/leaflet/coffee.png" },
//
//            { "_id" : { "$oid" : "55a624c09bf770b58a355f07" }, "location" : { "type" : "Point", "coordinates" : [ 1, 1 ] }, "alt" : 1, "date" : { "$date" : 1441927937814 }, "channel_id" : { "$oid" : "556721a52a2e7febd2744201" }, "json" : { "description" : "testGT-1332", "image_url":"http://www.dunbartutoring.com/wp-content/themes/thesis/rotator/sample-1.jpg"},"new_icon":"assets/images/leaflet/teapot.png" },
//
//            { "_id" : { "$oid" : "55a624c69bf770b58a355f08" }, "location" : { "type" : "Point", "coordinates" : [ 1, 1 ] }, "alt" : 2, "date" : { "$date" : 1441927937814 }, "channel_id" : { "$oid" : "556721a52a2e7febd2744201" }, "json" : { "description" : "testGT-1332", "image_url":"https://www.drupal.org/files/hr10_sample_image_02_original.jpg" },"new_icon":"assets/images/leaflet/teapot.png" },
//
//            { "_id" : { "$oid" : "55a624cb9bf770b58a355f09" }, "location" : { "type" : "Point", "coordinates" : [ 1, 1.2 ] }, "alt" : 1, "date" : { "$date" : 1442014337814 }, "channel_id" : { "$oid" : "556721a52a2e7febd2744202" }, "json" : { "description" : "testGT-1332", "image_url":"http://www.dunbartutoring.com/wp-content/themes/thesis/rotator/sample-1.jpg" } ,"new_icon":"assets/images/leaflet/teapot.png"},
//
//            { "_id" : { "$oid" : "55a624ce9bf770b58a355f0a" }, "location" : { "type" : "Point", "coordinates" : [ 1.3, 1 ] }, "alt" : 2, "date" : { "$date" : 1441927937814 }, "channel_id" : { "$oid" : "556721a52a2e7febd2744202" }, "json" : { "description" : "testGT-1332", "image_url":"http://www.dunbartutoring.com/wp-content/themes/thesis/rotator/sample-1.jpg"},"new_icon":"assets/images/leaflet/teapot.png" }
//
//        ];


function show() {

//$.getJSON("/journal/maps/getjson", function(data) { addDataToMap(data, map); });
    $.ajax({
        type: "POST",
        url: "/journal/maps/getjson",
        dataType: 'json',
        data: {action: 'showCountRigs'},
        cache: false,
        success: function (responce) {
            addDataToMap(responce, map);
        }
    });

}


/* show podrazdelenia from kusis */
$('body').on('click', '#show_podr', function (e) {
    e.preventDefault();
    $.post('/journal/maps/getjson', $('#showPodrForm').serialize(), function (response) {

        if (response.length > 0) {
            addPodrDataToMap(response, map, 1);
            toastr.success('Данные успешно получены', 'Успех!', {progressBar: true, timeOut: 5000});
        } else {

            toastr.error(response.error, 'Ошибка!', {progressBar: true, timeOut: 5000});
        }
    }, 'json');
});


/* reset filter */
$('body').on('click', '#reset_filter', function (e) {

    if (markerPodr !== undefined) {
        map.removeLayer(markerPodr);
        $('#id_local_map').empty().trigger('chosen:updated');
        $('#div_id_local_map').css('display', 'none');
        $('#id_region_map').val('').trigger('chosen:updated');
        $('#show_closest_podr').prop('checked',false);
    }


    myFeatureGroup.clearLayers();//deleting the previous circle marker
});


/* default markers - rigs */
$.getJSON("/journal/maps/getjson", function (data) {
    addDataToMap(data, map);
});

var theMarker = {};
var markerPodr = {};
var myFeatureGroup = L.featureGroup().addTo(map);//creating a circlemarkers group

function addDataToMap(data, map) {


//var circle = L.circle([52.617675, 29.784162], {
//    color: 'red',
//    fillColor: '#f03',
//    fillOpacity: 0.3,
//    radius: 5000
//}).addTo(map);

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


        if (data[i].hasOwnProperty('new_icon') && data[i].hasOwnProperty('new_icon') !== '') {
            geojsonFeature.properties.icon = {
                iconUrl: data[i].new_icon,
                iconSize: [24, 24],
                iconAnchor: [0, 0],
                popupAnchor: [0, 0],
                className: 'dot'
            };
        }

        var content_popup = '';
        if (data[i].hasOwnProperty('reasonrig_name'))
            var content_popup = '<b>' + data[i].reasonrig_name + '</b>';


        if (data[i].hasOwnProperty('address') && data[i].hasOwnProperty('address') !== '') {
            var content_popup = content_popup + '</br>' + data[i].address;
        }

        if (data[i].hasOwnProperty('object') && data[i].hasOwnProperty('object') !== '') {
            var content_popup = content_popup + '</br>' + data[i].object;
        }



        //geojsonFeature.popupContent = data[i].name;

        //else if(data[i].hasOwnProperty('json') && data[i].json.hasOwnProperty('image_url'))
        if (data[i].hasOwnProperty('card_by_rig_url'))
            var content_popup = content_popup + '</br>' + '<a href="' + data[i].card_by_rig_url + '" target="_blank"> детализированная информация </a>';
        //geojsonFeature.popupContent = '<a href="'+ data[i].card_by_rig_url+'" > детализированная информация </a>';

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

        return  L.marker(latlng);

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


/* add podr to map */
function addPodrDataToMap(data, map, mark_podr = 0) {

    /* remove old markers */
    if (markerPodr !== undefined) {
        map.removeLayer(markerPodr);
    }

    myFeatureGroup.clearLayers();//deleting the previous circle marker



    var dataLayer = L.geoJson(data);
    dataLayer.addTo(map);

    var featureArr = [];

    for (var i in data) {


        if (data[i].hasOwnProperty('is_circle') && parseInt(data[i].is_circle) === 1) {

            var circle = L.circle([data[i].lat, data[i].lon], {
                color: '#f5901d',
                opacity: 0.4,
                fillColor: '#f5901d',
                fillOpacity: 0.1,
                radius: 5000
            }).addTo(myFeatureGroup);
        } else {



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

            var content_popup = '';
            var ss_url_text = 'ссылка';

            if (data[i].hasOwnProperty('locorg_name'))
                var content_popup = '<b>' + data[i].locorg_name + '</b>';

            if (data[i].hasOwnProperty('pasp_name'))
                var content_popup = content_popup + '<b>, ' + data[i].pasp_name + '</b>';

            if (data[i].hasOwnProperty('address_disloc'))
                var content_popup = content_popup + '</br>' + data[i].address_disloc;

            if (data[i].hasOwnProperty('ss_url_text') && data[i].hasOwnProperty('ss_url_text') !== '')
                var ss_url_text = data[i].ss_url_text;

            if (data[i].hasOwnProperty('ss_url'))
                var content_popup = content_popup + '</br>' + '<a href="' + data[i].ss_url + '" target="_blank">' + ss_url_text + ' </a>';


            geojsonFeature.popupContent = content_popup;
            featureArr.push(geojsonFeature);


// if(data[i].hasOwnProperty('is_closest_podr') && data[i].hasOwnProperty('is_closest_podr') === 1){
//           var circle = L.circle([data[i].location.coordinates[1], data[i].location.coordinates[0]], {
//    color: 'red',
//    fillColor: '#f03',
//    fillOpacity: 0.3,
//    radius: 5000
//}).addTo(map);
// }

        }

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

        return  L.marker(latlng);

        //  else

        //return L.circleMarker(latlng, geojsonMarkerOptions);
        // return L.marker(latlng, {icon: greenIcon});

    }
    ;




    var s = L.geoJson(featureArr, {

        onEachFeature: onEachFeature,

        pointToLayer: pointToLayer

    }).addTo(map);



    if (mark_podr === 1) {
        markerPodr = s;
}


}








//        $('body').on('click', '#show_closest_podr', function (e) {
//            e.preventDefault();
//
//            var data=$('#showPodrForm').serializeArray();
//            data.push({'name':"is_closest",'value':1});
//
//            $.post('/journal/maps/getjson', data, function (response) {
//
//                if (response.length>0) {
//                    addPodrDataToMap(response, map,1);
//                     toastr.success('Данные успешно получены', 'Успех!', {progressBar: true, timeOut: 5000});
//                } else {
//
//                    toastr.error(response.error, 'Ошибка!', {progressBar: true, timeOut: 5000});
//                }
//            }, 'json');
//        });




/*-------------------------  manual js --------------------------------------- */
$(document).ready(function () {  // поиск значения в выпад меню
    $(".chosen-select-deselect").chosen({
        allow_single_deselect: true,
        width: '100%'

    });
});


$('#id_region_map').on('change', function (e) {
    var ids_region = $('#id_region_map').val();
    $('#id_local_map').empty().trigger('chosen:updated');

    var current_locals = $('#current_local_map').val();
    var arr_current_local = current_locals.split(",");
    console.log(arr_current_local);

    if (ids_region !== null) {
        //get locals by region
        $.ajax({
            dataType: "json",
            url: '/journal/maps/get_locals_by_region',
            method: 'POST',
            data: {
                ids_region: ids_region
            },
            success: function (data) {

                $(data).each(function (index, value) {


                    if (arr_current_local.includes(value.id)) {
                        $("#id_local_map").append($("<option selected></option>").attr("value", value.id).text(value.name + ' (' + value.region_name + ')')).trigger('chosen:updated');
                    } else {
                        $("#id_local_map").append($("<option></option>").attr("value", value.id).text(value.name + ' (' + value.region_name + ')')).trigger('chosen:updated');
                    }


                });

//                $('.trunk-select-on-form').append('<option value="' + data.id + '">' + data.tag_name + '</option>');
//                $('.trunk-select-on-form').trigger("chosen:updated");
//                $('#tags_del_trunk').append('<option value="' + data.id + '">' + data.tag_name + '</option>');
//                $('#tags_del_trunk').trigger("chosen:updated");
//
//
//                $('#id_edit_trunk').append('<option value="' + data.id + '">' + data.tag_name + '</option>');
//                $('#id_edit_trunk').trigger("chosen:updated");
//
//                $('#tag_name').val('');
//
//                $('.md-close').click();

            },
            error: function () {
                console.log('jj');
            }
        });


        $('#id_local_map_chosen').css('width', '215px');
        //show select local
        $('#div_id_local_map').css('display', 'inline');

    } else {

        $('#div_id_local_map').css('display', 'none');
    }

});


$('#id_local_map').on('change', function (e) {
    var ids_local = $('#id_local_map').val();

    $('#current_local_map').val(ids_local);


});




$("a[data-toggle=collapse]").click(function (e) {

    if (!$(this).hasClass('clicked')) { // если класса нет
        $(this).addClass('clicked'); // добавляем класс
        $(this).children('i').removeClass('fa-chevron-circle-down');
        $(this).children('i').addClass('fa-chevron-circle-up');


        $(this).children('span').text('Скрыть фильтр');

    } else { // если есть
        $(this).removeClass('clicked'); // убираем класс
        $(this).children('i').removeClass('fa-chevron-circle-up');
        $(this).children('i').addClass('fa-chevron-circle-down');

        $(this).children('span').text('Показать фильтр');
    }
});








