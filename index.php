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
        width: 870px;
        height: 652px;
      }
      .container2 {
        float: left;
        width: 400px;
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
      text-align : center;
      border : 1px solid black;
    }
    </style>
    <title>COVID-19</title>
   
</head>
<body>

    <ul id="nav-ul"class="nav-container">
      <li class="nav-item"><a href="">이재안</a></li>
      <li class="nav-item"><a href="">이재건</a></li>
      <li class="nav-item"><a href="">이희수</a></li>
      <li class="nav-item"><a href="">신재원</a></li>
    </ul>
  </nav>
<!-- 지도를 표시할 div 입니다 -->
<div id="udiv" class="udiv">
  <ul class="cmap">
      <div id="map" class="container"></div>
  </ul>
  <ul class="cmap">
      <iframe longdesc="covid simulation" width="1024" height="768" frameborder="0" scrolling="no" name="NeBoard" onLoad="ResizeFrame('NeBoard');" id="img" src="https://unity-technologies.github.io/unitysimulation-coronavirus-example-player/"></iframe>
  </ul>
  <ul>
    <div class="flourish-embed flourish-bar-chart-race" data-src="visualisation/2675613" data-url="https://flo.uri.sh/visualisation/2675613/embed"><script src="https://public.flourish.studio/resources/embed.js"></script></div>
  </ul>
</div>
<div class="container2">
  <div>
  <?php
    ini_set("allow_url_fopen",1);
    include "simple_html_dom.php";
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

<a href="http://www.busan.go.kr/corona19/index">출처 : http://www.busan.go.kr/corona19/index</a>
  </div>
  
</div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=094c4447e3c1f889a8c14319602db9d5"></script>

<script>
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new kakao.maps.LatLng(35.179791, 129.074975), // 지도의 중심좌표
        level: 9 // 지도의 확대 레벨
        
    };
var markerPosition  = {
  title : ''
}
// 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
var map = new kakao.maps.Map(mapContainer, mapOption);
var marker = new kakao.maps.Marker({
    position: markerPosition
});

map.setDraggable(false);
map.setZoomable(false);
</script>
</body>
</html>
