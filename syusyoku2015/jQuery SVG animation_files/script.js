$(function(){
  //SVG
  $('#box_svg').lazylinepainter(
  {
    "svgData": pathObj,
    "strokeWidth":0.6,//線の太さ
    "strokeColor":"#4e4134"//線の色
  }).lazylinepainter('paint');
});