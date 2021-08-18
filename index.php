<!DOCTYPE html>
<html>
  <head>
    <meta
      name="viewport"
      content="initial-scale=1,maximum-scale=1,user-scalable=no"
    />
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.js"></script>
    <script src="https://cdn.maptiler.com/mapbox-gl-js/v1.5.1/mapbox-gl.js"></script>
    <script src="https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.maptiler.com/mapbox-gl-js/v1.5.1/mapbox-gl.css"
    />
    <style>
      #map {
        position: absolute;
        top: 50px;
        right: 50px;
        bottom: 50px;
        left: 50px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <button id="show">Save Location</button>
    <button id="download"><a href="download.php?file=data.json">Download JSON File</a></button>
    <p id="data"></p>
    <script>

      //LEAFLET HARİTA YERLEŞTİRME
      var map = L.map("map").setView([0, -0.35156], 1);
      var gl = L.mapboxGL({
        attribution:
          '\u003ca href="https://www.maptiler.com/copyright/" target="_blank"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href="https://www.openstreetmap.org/copyright" target="_blank"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e',
        style:
          "https://api.maptiler.com/maps/streets/style.json?key=c49dLx7vlYqVKnDyOvY5",
      }).addTo(map);

      //var marker = L.marker([40.6757542754288, 29.924364207852836]).addTo(map);
      //marker.bindPopup("<b>Selanm ben Marker</b>").openPopup();

      //EKRANIN ORTASINDAKI GEOLOCATİON BILGILERINI AL ve KAYDET
      var button = document.getElementById("show");
      button.onclick = function () {
        var geoLoc = map.getCenter();
        const LatLng = String(geoLoc)
          .replace(/"/g, "")
          .replace(/'/g, "")
          .replace(/\(/g, "")
          .replace(/\)/g, "")
          .replace(/L/g, "")
          .replace(/a/g, "")
          .replace(/t/g, "")
          .replace(/n/g, "")
          .replace(/g/g, "")
          .split(",");

        //YENİ LOKASYON OBJESI
        const newLocation = {
          lat: LatLng[0],
          lng: LatLng[1],
          datetime: Date("2015-02-29"),
        };

        //JSON DOSYASINA YAZMAK İÇİN DATA POSTLA
        $.ajax({
          url:"writeJson.php",
          method:"post",
          value:"Append",
          data:newLocation,
          success:function(res){
            console.log(res);
          }
        })


        /*
        const fs = require("fs");
        fs.writeFile("./data.json", JSON.stringify(newLocation), (err) => {
          if (err) {
            console.log(err);
          } else {
            console.log("file succesfully written");
          }
        });
        */

        alert("Marker Başarıyla Oluşturuldu");

        //JSON DOSYASINDAN LOKASYONLARI OKU
      fetch("data.json")
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          for (var i = 0; i < data.length; i++) {
            //MARKERLARI OLUŞTUR
            var marker = L.marker([data[i].lat, data[i].lng]).addTo(map);
            marker.bindPopup("<b>" + data[i].datetime + "</b>").openPopup();

            /*document.getElementById("data").innerHTML +=
              data[i].lat +
              "=>" +
              data[i].lng +
              " " +
              data[i].datetime +
              "</br>";*/
          }
        })
        .catch(function (err) {
          console.log(err);
        });
      };
    </script>

    <script type="text/javascript">

      //SAYFA İLK AÇILDIĞINDA VAROLAN MARKERLARI OKU VE OLUŞTUR
      fetch("data.json")
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          for (var i = 0; i < data.length; i++) {
            var marker = L.marker([data[i].lat, data[i].lng]).addTo(map);
            marker.bindPopup("<b>" + data[i].datetime + "</b>").openPopup();

            /*document.getElementById("data").innerHTML +=
              data[i].lat +
              "=>" +
              data[i].lng +
              " " +
              data[i].datetime +
              "</br>";*/
          }
        })
        .catch(function (err) {
          console.log(err);
        });
    </script>
  </body>
</html>
