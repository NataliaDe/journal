
        var map = L.map('mapid', {attributionControl: false});
        map.setView([53.900000, 27.566670], 13);
//        L.control.attribution({prefix:''}).addAttribution('<a href="http://maps.sputnik.ru/">Спутник</a> | &copy; Ростелеком | &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>').addTo(map);
//        L.tileLayer('http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png', {
//            maxZoom: 19
//        }).addTo(map);
       // L.control.attribution({prefix:''}).addAttribution('<a href="http://maps.sputnik.ru/">Спутник</a> | &copy; Ростелеком | &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>').addTo(map);
        L.tileLayer('http://172.26.200.45/tile/map/{x}/{y}/{z}.png', {
            maxZoom: 19
        }).addTo(map);
// L.tileLayer('/journal/assets/Tiles/{z}/{x}/{y}.png', {
//            maxZoom: 19
//        }).addTo(map);


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


function show (){

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

$.getJSON("/journal/maps/getjson", function(data) { addDataToMap(data, map); });

 var theMarker = {};
function addDataToMap(data, map) {

/* remove old markers */
if (theMarker !== undefined) {
 map.removeLayer(theMarker);
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
            if(data[i].hasOwnProperty('name'))
                var content_popup=data[i].name;

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









