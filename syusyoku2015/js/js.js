/********************
*初回処理
*
*********************/
$(document).ready(function(){
    showImageCanvas();
});
/********************
*初期画像
*
*********************/
var img_on = "b.jpg";
var img = "images/base/st_white.png";

/********************
*服種別選択時の動作
*
*********************/

$(function () {
	$("#select").change(function (eo) {
		var mySelect = $("option:selected").val();
		img = "images/base/"+mySelect+"_white.png";
		$("#syu").val(mySelect);
		showImageCanvas();
	});
});

/********************
*服色選択時の色変更動作
*
*********************/

$(function () {
	$( 'input[name="color"]:radio' ).change( function() {  
		var myColor = $(this).val(); // valueを表示 
		var mySelect = $("#syu").val();
		img = "images/base/"+mySelect+"_"+myColor+".png";
		$("#color").val(myColor);
		showImageCanvas();
	}); 
});


/********************
*ドラッグ時の画像処理
*
*********************/
 // ドラッグ要素がドロップ要素に重なっている間
      window.addEventListener("dragover", function(evt) {
        evt.preventDefault();  // ブラウザのデフォルトの画像表示処理をOFF
      }, false);

      // ドロップ時
      window.addEventListener("drop", function(evt) {

        evt.preventDefault();  // ブラウザのデフォルトの画像表示処理をOFF
        var file = evt.dataTransfer.files[0]; // 選択されたファイルを取得

        if (!file.type.match(/^image\/(png|jpeg|gif)$/)) return; // 画像ファイル以外は処理中止

        var imgObj = new Image();
        var reader = new FileReader();

        reader.onload = function(evt) { // File APIを使用し、ローカルファイルを読み込む
          imgObj.src = evt.target.result; // 画像URLをソースに設定
		  img_on = imgObj.src;
		  showImageCanvas();
		}
        reader.readAsDataURL(file); //ファイルを読み込み、データをBase64でエンコードされたデータURLにして返す 
      });  


/********************
*canvas による画像加工
*
*********************/
function showImageCanvas(){

    var fileArray = [img, img_on];
    var xywh = [{x: 0, y: 0, w: 600, h: 600}, {x: 190, y: 170, w: 200, h: 200}];
    var numFiles = fileArray.length;
    var loadedCount = 0;
    var imageObjectArray = [];
    var canvas = document.getElementById('jsImageCoverCanvas');
    var ctx = canvas.getContext('2d');

    function loadImages(){
        var imgObj = new Image();
        imgObj.addEventListener('load',
            function(){
                loadedCount++;
                imageObjectArray.push(imgObj);
                if(numFiles === loadedCount){
                    drawImage();
                }else{
                    loadImages();
                }
            },
            false
        );
        imgObj.src = fileArray[imageObjectArray.length];
    }
    function drawImage(){
        canvas.width = 600;
        canvas.height = 600;
        for(var i in imageObjectArray){
            ctx.drawImage(imageObjectArray[i], xywh[i]['x'], xywh[i]['y'], xywh[i]['w'], xywh[i]['h']);
            imageObjectArray[i] = null;
        }
    }
    loadImages();
}

/********************
*canvas によるペア画像版
*
*********************/
function showImageCanvas_2(){

    var fileArray = [img, img_on];
    var xywh = [{x: 0, y: 0, w: 600, h: 600}, {x: 190, y: 170, w: 200, h: 200}];
    var numFiles = fileArray.length;
    var loadedCount = 0;
    var imageObjectArray = [];
    var canvas = document.getElementById('jsImageCoverCanvas_2');
    var ctx = canvas.getContext('2d');

    function loadImages(){
        var imgObj = new Image();
        imgObj.addEventListener('load',
            function(){
                loadedCount++;
                imageObjectArray.push(imgObj);
                if(numFiles === loadedCount){
                    drawImage();
                }else{
                    loadImages();
                }
            },
            false
        );
        imgObj.src = fileArray[imageObjectArray.length];
    }
    function drawImage(){
        canvas.width = 600;
        canvas.height = 600;
        for(var i in imageObjectArray){
            ctx.drawImage(imageObjectArray[i], xywh[i]['x'], xywh[i]['y'], xywh[i]['w'], xywh[i]['h']);
            imageObjectArray[i] = null;
        }
    }
    loadImages();
}

/********************
*canvas をDBに送信
*
*********************/
function CreateCanvas(){
	 // body部パラメーター
    var data = {};
    //canvasのノードオブジェクト
    var canvas = document.getElementById('jsImageCoverCanvas');
    //toDataURLでデータを取得
    var canvas = canvas.toDataURL();
	
	    // 不要な情報を取り除く
    canvasData = canvas.replace(/^data:image\/png;base64,/, '');
//toDataURL('image/png').replace(/^.*,/, '');
    data.image = canvasData;

    $.ajax({
        url: 'test.php',
        type: 'POST',
        success: function() {
            // 成功時の処理
        },
        data: data,
        dataType: 'json'
    });
}

/********************
*確定ダイアログ
*
*********************/
jQuery( function() {
  jQuery( '#edi' ) . click( function() {
		//$("#Form").prepend('<input id="edi2" type="hidden"  name="edi" value="aa"/>');
		jQuery( '#jquery-ui-dialog' ) . dialog( 'open' );
        return false;
    } );
	
  jQuery( '#jquery-ui-dialog' ) . dialog( {
         autoOpen: false,
  title: '作成確定',
  closeOnEscape: false,
  modal: true,
  buttons: {
    "確定": function(){
	  CreateCanvas();
	  $("#Form").submit();
	  $(this).dialog('close');  
    }
    ,"キャンセル": function(){
      $(this).dialog('close');
	  //$("#edi2").remove();
	   return false;
    }
  }
    });
});