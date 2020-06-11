<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
      body{
        margin: 0;
      }
      .cmap{
        margin: 10px;
        padding: 0px;
      }
      .udiv {
        margin: 0;
        padding: 0;
        display:flex; 
        align-content:flex-start; 
        flex-direction:column; 
        flex-wrap:wrap; 
        overflow:auto;
        float: left;
      }
      body {
        margin: 0;
      }
      .container {
        float: left;
        width: 670px;
        height: 652px;
      }
      .container2 {
        float: left;
        margin: 15px;
        padding: 0;
        display:flex; 
        align-content:flex-start; 
        flex-direction:column; 
        flex-wrap:wrap; 
        overflow:auto;
      }
      iframe { 
      -moz-transform: scale(0.85, 0.85);  
      -webkit-transform: scale(0.85, 0.85); 
      -o-transform: scale(0.85, 0.85); 
      -ms-transform: scale(0.85, 0.85); 
      transform: scale(0.85, 0.85); 
      -moz-transform-origin: top left; 
      -webkit-transform-origin: top left; 
      -o-transform-origin: top left; 
      -ms-transform-origin: top left; 
      transform-origin: top left; 
      float: left;
    }
    .nav-container{
      display: flex;
      flex-direction: row;
      width: 100%;
      margin: 0;
      padding: 0;
      background-color: darkslategray;
      list-style-type: none;
    }
    .nav-item{
      padding: 15px;
      cursor: pointer;
    }
    .nav-item a{
      text-align: center;
      text-decoration: none;
      color: white;
    }
    .nav-item:hover{
      background-color: green;
    }
    table{
      border : 1px solid black;
      border-collapse : collapse;
    }
    th, td{
      width : 80px;
      text-align : center;
      border : 1px solid black;
    }
    .area {
      position: absolute;
      background: #fff;
      border: 1px solid #888;
      border-radius: 3px;
      font-size: 12px;
      top: -5px;
      left: 15px;
      padding:2px;
    }
    </style>
    <title>COVID-19</title>
</head>
<body>
    <ul id="nav-ul"class="nav-container">
      <li class="nav-item"><a style="text_align:left">코로나 맵</a></li>
      <li class="nav-item"><a style="text_align:right">기준</a></li>
    </ul>
  </nav>
<!-- 지도를 표시할 div 입니다 -->
<div id="udiv" class="udiv">
  <ul class="cmap">
      <div id="map" class="container"></div>
  </ul>
  <ul class="cmap">
      <iframe longdesc="covid simulation" width="1024" height="668" frameborder="0" scrolling="no" name="NeBoard" onLoad="ResizeFrame('NeBoard');" id="img" src="https://unity-technologies.github.io/unitysimulation-coronavirus-example-player/"></iframe>
  </ul>
  <ul>
    <div class="flourish-embed flourish-bar-chart-race" data-src="visualisation/2675613" data-url="https://flo.uri.sh/visualisation/2675613/embed"><script src="https://public.flourish.studio/resources/embed.js"></script></div>
  </ul>
</div>
<div class="container2">
  <?php
    ini_set("allow_url_fopen",1);
    include "simple_html_dom.php";
    //include "korea.geojson";
    $data = file_get_html("http://ncov.mohw.go.kr/bdBoardList_Real.do?brdId=1&brdGubun=13&ncvContSeq=&contSeq=&board_id=&gubun=");
    ?><table><?php
    foreach($data->find("table") as $ul){
        foreach($ul->find("tr") as $li){ ?>
            <tr>
            <?php
            foreach($li->find("td,th") as $al){
                echo $al;
            }
            ?>
            </tr>
            <?php
        }
    }?>
    </table>
</div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=f6e4b36ec6c88cd63ebbe33a1dda73f2"></script>
<script>

var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new kakao.maps.LatLng(36.189320, 128.003166), // 지도의 중심좌표
        level: 13 // 지도의 확대 레벨
        
    };
// 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
var map = new kakao.maps.Map(mapContainer, mapOption),
    customOverlay = new kakao.maps.CustomOverlay({}),
    infowindow = new kakao.maps.InfoWindow({removable: true});


include "korea.geojson"
    $.getJSON("korea.geojson", function(geojson) {
 
 var data = geojson.features;
 var coordinates = [];    //좌표 저장할 배열
 var name = '';            //행정 구 이름

 $.each(data, function(index, val) {

     coordinates = val.geometry.coordinates;
     name = val.properties.CTP_KOR_NM;
     
     displayArea(coordinates, name);

 })
})


var polygons=[];                //function 안 쪽에 지역변수로 넣으니깐 폴리곤 하나 생성할 때마다 배열이 비어서 클릭했을 때 전체를 못 없애줌.  그래서 전역변수로 만듦.
 
//행정구역 폴리곤
function displayArea(coordinates, name) {

 var path = [];            //폴리곤 그려줄 path
 var points = [];        //중심좌표 구하기 위한 지역구 좌표들
 
 $.each(coordinates[0], function(index, coordinate) {        //console.log(coordinates)를 확인해보면 보면 [0]번째에 배열이 주로 저장이 됨.  그래서 [0]번째 배열에서 꺼내줌.
     var point = new Object(); 
     point.x = coordinate[1];
     point.y = coordinate[0];
     points.push(point);
     path.push(new kakao.maps.LatLng(coordinate[1], coordinate[0]));            //new kakao.maps.LatLng가 없으면 인식을 못해서 path 배열에 추가
 })
 
 // 다각형을 생성합니다 
 var polygon = new kakao.maps.Polygon({
     map : map, // 다각형을 표시할 지도 객체
     path : path,
     strokeWeight : 2,
     strokeColor : '#004c80',
     strokeOpacity : 0.8,
     fillColor : '#fff',
     fillOpacity : 0.7
 });
 
 polygons.push(polygon);            //폴리곤 제거하기 위한 배열

 // 다각형에 mouseover 이벤트를 등록하고 이벤트가 발생하면 폴리곤의 채움색을 변경합니다 
 // 지역명을 표시하는 커스텀오버레이를 지도위에 표시합니다
 kakao.maps.event.addListener(polygon, 'mouseover', function(mouseEvent) {
     polygon.setOptions({
         fillColor : '#09f'
     });

     customOverlay.setContent('<div class="area">' + name + '</div>');

     customOverlay.setPosition(mouseEvent.latLng);
     customOverlay.setMap(map);
 });

 // 다각형에 mousemove 이벤트를 등록하고 이벤트가 발생하면 커스텀 오버레이의 위치를 변경합니다 
 kakao.maps.event.addListener(polygon, 'mousemove', function(mouseEvent) {

     customOverlay.setPosition(mouseEvent.latLng);
 });

 // 다각형에 mouseout 이벤트를 등록하고 이벤트가 발생하면 폴리곤의 채움색을 원래색으로 변경합니다
 // 커스텀 오버레이를 지도에서 제거합니다 
 kakao.maps.event.addListener(polygon, 'mouseout', function() {
     polygon.setOptions({
         fillColor : '#fff'
     });
     customOverlay.setMap(null);
 });

 // 다각형에 click 이벤트를 등록하고 이벤트가 발생하면 해당 지역 확대을 확대합니다.
 kakao.maps.event.addListener(polygon, 'click', function() {
     
     // 현재 지도 레벨에서 2레벨 확대한 레벨
     var level = map.getLevel()-2;
     
     // 지도를 클릭된 폴리곤의 중앙 위치를 기준으로 확대합니다
     map.setLevel(level, {anchor: centroid(points), animate: {
         duration: 350            //확대 애니메이션 시간
     }});            

     deletePolygon(polygons);                    //폴리곤 제거      
 });
}

//map.setDraggable(false);
//map.setZoomable(false);
</script>
</body>
</html>
