
/* types of layers */
var internetlayer =
         L.tileLayer('http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png', {id:'mapid',
            maxZoom: 14,
            minZoom: 6
        });

	baselayer   =
                   L.tileLayer('http://172.26.200.45/tile/map/{x}/{y}/{z}.png', {id:'mapid',
            maxZoom: 14,
            minZoom: 6
// L.tileLayer('/journal/assets/tiles/{z}/{x}/{y}.png', {id:'mapid',
//            maxZoom: 14,
//            minZoom: 6
        });



        var map = L.map('mapid', {attributionControl: false,
                layers: [internetlayer]
        });




        map.setView([53.733699, 26.929650],7);

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





var states = [{
    "type": "Feature",
    "properties": {"party": "Republican"},
    "geometry": {
        "type": "Polygon",
        "coordinates": [[

[27.2749, 52.3913],
[27.2286, 52.3984],
[27.2286, 52.4192],
[27.1637, 52.4188],
[27.1606, 52.4514],
[27.1321, 52.4512],
[27.1304, 52.4888],
[27.0583, 52.4878],
[27.0586, 52.5148],
[27.0425, 52.5204],
[27.0600, 52.5219],
[27.0586, 52.5260],
[27.0408, 52.5302],
[27.0593, 52.5319],
[27.0549, 52.5594],
[27.0401, 52.5588],
[27.0363, 52.5874],
[27.0171, 52.5857],
[27.0047, 52.5980],
[27.0041, 52.6147],
[27.0346, 52.6166],
[27.0288, 52.6583],
[27.0157, 52.6589],
[27.0192, 52.6706],
[27.0655, 52.6751],
[27.0490, 52.7072],
[27.0216, 52.7172],
[27.0367, 52.7442],
[27.0085, 52.7787],
[26.9433, 52.7409],
[26.8884, 52.7562],
[26.8684, 52.7724],
[26.8066, 52.7670],
[26.7613, 52.7945],
[26.7593, 52.8223],
[26.7469, 52.8343],
[26.7538, 52.8509],
[26.7393, 52.8554],
[26.7359, 52.8492],
[26.7078, 52.8488],
[26.7146, 52.8393],
[26.6748, 52.8488],
[26.6666, 52.8596],
[26.6247, 52.8662],
[26.6247, 52.8720],
[26.5849, 52.8915],
[26.5533, 52.8418],
[26.5272, 52.8331],
[26.5107, 52.8596],
[26.4482, 52.8053],
[26.4441, 52.8165],
[26.3837, 52.8496],
[26.3905, 52.8679],
[26.4619, 52.9151],
[26.3940, 52.9921],
[26.4613, 53.0049],
[26.4558, 53.0433],
[26.4771, 53.0581],
[26.5210, 53.0474],
[26.5313, 53.0532],
[26.5100, 53.0862],
[26.4901, 53.0850],
[26.4668, 53.1175],
[26.4091, 53.1179],
[26.3775, 53.1307],
[26.3795, 53.1468],
[26.3610, 53.1583],
[26.3349, 53.1591],
[26.3425, 53.1690],
[26.3219, 53.1809],
[26.2896, 53.1842],
[26.2793, 53.2097],
[26.3088, 53.2163],
[26.3095, 53.2295],
[26.3239, 53.2397],
[26.3425, 53.2389],
[26.3445, 53.2603],
[26.3878, 53.2599],
[26.4022, 53.3186],
[26.3809, 53.3223],
[26.3576, 53.3645],
[26.3699, 53.3706],
[26.3857, 53.3653],
[26.4379, 53.3796],
[26.4626, 53.3919],
[26.5814, 53.4001],
[26.5574, 53.5015],
[26.5313, 53.5130],
[26.5155, 53.5032],
[26.5004, 53.5089],
[26.5505, 53.5354],
[26.4825, 53.5754],
[26.4977, 53.5811],
[26.3589, 53.6695],
[26.3699, 53.6963],
[26.3061, 53.7069],
[26.3068, 53.7195],
[26.2656, 53.7617],
[26.2738, 53.7727],
[26.2573, 53.7836],
[26.2820, 53.7946],
[26.2649, 53.8104],
[26.2408, 53.7994],
[26.2251, 53.8116],
[26.2285, 53.8282],
[26.2621, 53.8282],
[26.2388, 53.8659],
[26.3795, 53.8975],
[26.3576, 53.9270],
[26.4345, 53.9541],
[26.3947, 54.0017],
[26.3074, 53.9718],
[26.3219, 54.0590],
[26.1488, 54.0183],
[26.1406, 54.1508],
[26.0843, 54.1439],
[26.0973, 54.1142],
[26.0053, 54.1492],
[26.0589, 54.2058],
[26.2031, 54.2383],
[26.3514, 54.2098],
[26.4008, 54.2652],
[26.4510, 54.3001],
[26.4678, 54.2941],
[26.4942, 54.3057],
[26.4952, 54.3217],
[26.4867, 54.3215],
[26.5261, 54.3736],
[26.5423, 54.3706],
[26.5337, 54.3812],
[26.5378, 54.3918],
[26.5536, 54.3918],
[26.5615, 54.4081],
[26.5952, 54.4059],
[26.6504, 54.4455],
[26.6288, 54.4495],
[26.6563, 54.4918],
[26.6408, 54.4998],
[26.6463, 54.5207],
[26.6175, 54.5336],
[26.6147, 54.5633],
[26.6642, 54.5504],
[26.6635, 54.5896],
[26.6944, 54.5816],
[26.7002, 54.5934],
[26.6635, 54.6005],
[26.6820, 54.6478],
[26.6006, 54.6415],
[26.5598, 54.6984],
[26.5382, 54.7133],
[26.5529, 54.7399],
[26.5491, 54.7561],
[26.5042, 54.7619],
[26.4201, 54.8353],
[26.3366, 54.8201],
[26.3641, 54.8875],
[26.2800, 54.9350],
[26.3147, 54.9713],
[26.3387, 54.9603],
[26.3524, 54.9758],
[26.3315, 54.9802],
[26.3610, 54.9932],
[26.4898, 54.9500],
[26.5052, 54.9656],
[26.5691, 54.9400],
[26.6175, 54.9666],
[26.5907, 54.9814],
[26.6491, 54.9902],
[26.7414, 54.9575],
[26.8276, 54.9719],
[26.8245, 54.9875],
[26.7953, 54.9932],
[26.8135, 55.0184],
[26.8509, 54.9979],
[26.8739, 55.0201],
[26.9673, 54.9672],
[27.0768, 54.9812],
[27.0597, 54.9977],
[27.1318, 55.0085],
[27.1551, 54.9920],
[27.1675, 55.0074],
[27.1809, 54.9971],
[27.1894, 55.0066],
[27.2015, 55.0060],
[27.2076, 54.9914],
[27.2691, 54.9926],
[27.2770, 54.9819],
[27.2694, 54.9567],
[27.2866, 54.9589],
[27.2849, 54.9463],
[27.3168, 54.9398],
[27.3045, 54.9037],
[27.3295, 54.9015],
[27.4054, 54.8561],
[27.4981, 54.8379],
[27.4809, 54.8110],
[27.5565, 54.8118],
[27.5345, 54.7682],
[27.7034, 54.7460],
[27.7213, 54.6699],
[27.6869, 54.6532],
[27.7707, 54.6118],
[27.8668, 54.6460],
[27.9945, 54.5824],
[28.1058, 54.6222],
[28.2088, 54.6786],
[28.3942, 54.5514],
[28.4518, 54.6675],
[28.6386, 54.6619],
[28.6867, 54.6063],
[28.6661, 54.5943],
[28.6880, 54.5744],
[28.8391, 54.5641],
[28.8844, 54.5808],
[28.8652, 54.6079],
[29.0218, 54.5768],
[29.1069, 54.6421],
[29.2346, 54.6238],
[29.2085, 54.5784],
[29.2854, 54.5569],
[29.4681, 54.6198],
[29.4969, 54.5856],
[29.4063, 54.4621],
[29.4406, 54.3838],
[29.3500, 54.3614],
[29.4118, 54.3149],
[29.3349, 54.2396],
[29.4063, 54.2444],
[29.4626, 54.1849],
[29.4104, 54.1270],
[29.4475, 54.0892],
[29.4214, 54.0956],
[29.4241, 54.0384],
[29.3280, 54.0126],
[29.4090, 53.8533],
[29.3568, 53.8282],
[29.4955, 53.8055],
[29.4846, 53.7804],
[29.3857, 53.7804],
[29.3980, 53.7235],
[29.3211, 53.7463],
[29.1866, 53.6552],
[29.1069, 53.6821],
[29.0712, 53.5795],
[28.9490, 53.5754],
[28.9655, 53.5183],
[28.9133, 53.5272],
[28.8062, 53.6039],
[28.7746, 53.5974],
[28.7773, 53.5778],
[28.6235, 53.6088],
[28.4985, 53.5362],
[28.5699, 53.5215],
[28.5150, 53.5044],
[28.3406, 53.4742],
[28.4065, 53.4513],
[28.4079, 53.3973],
[28.3488, 53.3858],
[28.3585, 53.3546],
[28.4422, 53.3202],
[28.4299, 53.2759],
[28.3255, 53.2734],
[28.3310, 53.2537],
[28.0920, 53.2710],
[28.1154, 53.2175],
[28.4958, 53.1558],
[28.5658, 52.9966],
[28.5397, 52.9701],
[28.4862, 52.9834],
[28.4340, 52.9536],
[28.4834, 52.8849],
[28.4175, 52.8517],
[28.4573, 52.8177],
[28.4354, 52.7762],
[28.3667, 52.7554],
[28.3667, 52.7230],
[28.4724, 52.6747],
[28.4340, 52.6481],
[28.4381, 52.5388],
[28.3502, 52.4845],
[28.2033, 52.4761],
[28.1950, 52.4903],
[28.1346, 52.4861],
[28.1236, 52.5246],
[27.9657, 52.5028],
[27.9781, 52.4661],
[27.9520, 52.4317],
[27.8709, 52.4217],
[27.7158, 52.4309],
[27.6224, 52.4861],
[27.6320, 52.5321],
[27.3999, 52.5288],
[27.3491, 52.4895],
[27.3738, 52.4418],
[27.2749, 52.3873],
[27.2749, 52.3913]



                ]]
    }
}];

L.geoJSON(states, {
    style: function(feature) {
        switch (feature.properties.party) {
            case 'Republican': return {color: "rgba(34, 139, 34, 0.5)"};
            case 'Democrat':   return {color: "blue"};
        }
    }
}).addTo(map);






/*------ Legend specific -------*/
var legend = L.control({ position: "bottomleft" });



legend.onAdd = function(map) {
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
  div.innerHTML += '<img src="assets/images/leaflet/priroda.png"></i><span>ЛТТ - ЧС природного характера</span><br>';
//  div.innerHTML += '<i style="background: #FFFFFF"></i><span>Ice</span><br>';
//  div.innerHTML += '<i class="icon" style="background-image: url(https://d30y9cdsu7xlg0.cloudfront.net/png/194515-200.png);background-repeat: no-repeat;"></i><span>Grænse</span><br>';


  return div;
};

legend.addTo(map);
/*------ END Legend specific ------*/


        var greenIcon = L.icon({
	iconUrl: 'assets/images/leaflet/coffee.png',
	//shadowUrl: 'assets/images/leaflet/coffee-shadow.png',

	iconSize:     [50, 64], // size of the icon
	shadowSize:   [50, 64], // size of the shadow
	iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
	shadowAnchor: [4, 62],  // the same for the shadow
	popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
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

//
//function show (){
//
////$.getJSON("/journal/maps/getjson", function(data) { addDataToMap(data, map); });
//        $.ajax({
//            type: "POST",
//            url: "/journal/maps/getjson",
//            dataType: 'json',
//            data: {action: 'showCountRigs'},
//            cache: false,
//            success: function (responce) {
//               addDataToMap(responce, map);
//            }
//        });
//
//}


/* show podrazdelenia from kusis */
        $('body').on('click', '#show_podr', function (e) {
            e.preventDefault();
            $.post('/journal/maps/getjson', $('#showPodrForm').serialize(), function (response) {

                if (response.length>0) {
                    addPodrDataToMap(response, map,1);
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
             $('#div_id_local_map').css('display','none');
             $('#id_region_map').val('').trigger('chosen:updated');
            }
        });


/* default markers - rigs */
$.getJSON("/journal/maps_for_min_obl/getjson", function(data) { addDataToMap(data, map); });

 var theMarker = {};
 var markerPodr={};
function addDataToMap(data, map) {

/* remove old markers */
if (theMarker !== undefined) {
 //map.removeLayer(theMarker);
}


    var dataLayer = L.geoJson(data);
    dataLayer.addTo(map);

     var featureArr = [];

        for(var i in data){

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

                "customizeView":Math.floor(Math.random()*2) // случайно 0 или 1

            };


 if(data[i].hasOwnProperty('new_icon') && data[i].hasOwnProperty('new_icon') !== ''){
geojsonFeature.properties.icon= {
        iconUrl: data[i].new_icon,
        iconSize: [24, 24],
        iconAnchor: [0, 0],
        popupAnchor: [0, 0],
        className: 'dot'
      };
      }

 var content_popup='';
            if(data[i].hasOwnProperty('reasonrig_name'))
                var content_popup='<b>'+data[i].reasonrig_name+'</b>';


            if(data[i].hasOwnProperty('address') && data[i].hasOwnProperty('address') !== '') {
                var content_popup=content_popup+'</br>'+data[i].address;
            }

            if(data[i].hasOwnProperty('object') && data[i].hasOwnProperty('object') !== '') {
                var content_popup=content_popup+'</br>'+ data[i].object;
            }



                //geojsonFeature.popupContent = data[i].name;

            //else if(data[i].hasOwnProperty('json') && data[i].json.hasOwnProperty('image_url'))
            if(data[i].hasOwnProperty('card_by_rig_url'))

 var content_popup=content_popup+'</br>'+'<a href="'+ data[i].card_by_rig_url+'" target="_blank"> детализированная информация </a>';
                //geojsonFeature.popupContent = '<a href="'+ data[i].card_by_rig_url+'" > детализированная информация </a>';

geojsonFeature.popupContent =content_popup;
            featureArr.push(geojsonFeature);

        }

        function onEachFeature(feature, layer) {

            if(feature.hasOwnProperty('popupContent'))

                layer.bindPopup(feature.popupContent);

if(feature.hasOwnProperty('properties') &&  feature.properties.hasOwnProperty('icon') &&  feature.properties.icon.hasOwnProperty('iconUrl') && feature.properties.icon.iconUrl !== 'undefined' && feature.properties.icon.iconUrl !== undefined ){
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

        };




      var s=  L.geoJson(featureArr, {

            onEachFeature: onEachFeature,

            pointToLayer: pointToLayer

        }).addTo(map);

        theMarker = s;

}


/* add podr to map */
function addPodrDataToMap(data, map,mark_podr=0) {

/* remove old markers */
if (markerPodr !== undefined) {
 map.removeLayer(markerPodr);
}


    var dataLayer = L.geoJson(data);
    dataLayer.addTo(map);

     var featureArr = [];

        for(var i in data){

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

                "customizeView":Math.floor(Math.random()*2) // случайно 0 или 1

            };


 if(data[i].hasOwnProperty('new_icon') && data[i].hasOwnProperty('new_icon') !== ''){
geojsonFeature.properties.icon= {
        iconUrl: data[i].new_icon,
        iconSize: [50, 64],
        iconAnchor: [0, 0],
        popupAnchor: [0, 0],
        className: 'dot'
      };
      }

    var content_popup='';
    var ss_url_text='ссылка';

            if(data[i].hasOwnProperty('locorg_name'))
                var content_popup='<b>'+data[i].locorg_name+'</b>';

            if(data[i].hasOwnProperty('pasp_name'))
                var content_popup=content_popup+'<b>, '+data[i].pasp_name+'</b>';

            if(data[i].hasOwnProperty('address_disloc'))
                var content_popup=content_popup+'</br>'+data[i].address_disloc;

           if(data[i].hasOwnProperty('ss_url_text') && data[i].hasOwnProperty('ss_url_text') !== '')
                var ss_url_text=data[i].ss_url_text;

            if(data[i].hasOwnProperty('ss_url'))
                var content_popup=content_popup+'</br>'+'<a href="'+ data[i].ss_url+'" target="_blank">'+ss_url_text+' </a>';


geojsonFeature.popupContent =content_popup;
            featureArr.push(geojsonFeature);

        }

        function onEachFeature(feature, layer) {

            if(feature.hasOwnProperty('popupContent'))

                layer.bindPopup(feature.popupContent);

if(feature.hasOwnProperty('properties') &&  feature.properties.hasOwnProperty('icon') &&  feature.properties.icon.hasOwnProperty('iconUrl') && feature.properties.icon.iconUrl !== 'undefined' && feature.properties.icon.iconUrl !== undefined ){
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

        };




      var s=  L.geoJson(featureArr, {

            onEachFeature: onEachFeature,

            pointToLayer: pointToLayer

        }).addTo(map);

/* centered */
map.fitBounds(s.getBounds());

        if(mark_podr === 1){
            markerPodr=s;
        }


}






/*-------------------------  manual js --------------------------------------- */
$(document).ready(function () {  // поиск значения в выпад меню
$(".chosen-select-deselect").chosen({
   allow_single_deselect: true,
   width: '100%'

});
});


    $('#id_region_map').on('change', function(e) {
        var ids_region=$('#id_region_map').val();
$('#id_local_map').empty().trigger('chosen:updated');

var current_locals=$('#current_local_map').val();
var arr_current_local = current_locals.split(",");
console.log(arr_current_local);

        if(ids_region !== null){
            //get locals by region
            $.ajax({
                dataType: "json",
                url: '/journal/maps/get_locals_by_region',
                method: 'POST',
                data: {
                    ids_region: ids_region
                },
             success: function (data) {

                  $(data).each(function(index, value) {


                  if(arr_current_local.includes(value.id)){
                      $("#id_local_map").append($("<option selected></option>").attr("value", value.id).text(value.name+' ('+value.region_name+')')).trigger('chosen:updated');
                  }
                  else{
                      $("#id_local_map").append($("<option></option>").attr("value", value.id).text(value.name+' ('+value.region_name+')')).trigger('chosen:updated');
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
            error:function(){
                 console.log('jj');
            }
        });


$('#id_local_map_chosen').css('width','215px');
            //show select local
            $('#div_id_local_map').css('display','inline');

        }
        else{

            $('#div_id_local_map').css('display','none');
        }

    });


    $('#id_local_map').on('change', function(e) {
        var ids_local=$('#id_local_map').val();

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

