/***
 * 定数
 */
var imglocation_left;
var imglocation_top;
var textlocation_left;
var textlocation_top;

/********************
*初回処理
*
*********************/
$(document).ready(function(){
    imglocation_left=150;
    imglocation_top=110;
    textlocation_left=150;
    textlocation_top=80;
    showImageCanvas();
});
/********************
*初期画像
*
*********************/
var img_on = "images/base.png";
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

		  showImageCanvas(imglocation_left,imglocation_top,200,200);
            //showImageCanvas2(10,0,200,200);
        }
        reader.readAsDataURL(file); //ファイルを読み込み、データをBase64でエンコードされたデータURLにして返す 
      });  


/********************
*canvas による画像加工
*
*********************/
function showImageCanvas(a,b,c,d){
    var fileArray = [img,img_on];
    var xywh = [{x: 0, y: 0, w: 600, h: 600},{x: a, y: b, w: c, h: d}];
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
        ctx.fillText("Sample String", 100, 100);
        for(var i in imageObjectArray){
            ctx.drawImage(imageObjectArray[i], xywh[i]['x'], xywh[i]['y'], xywh[i]['w'], xywh[i]['h']);
            imageObjectArray[i] = null;
        }
    }
    loadImages();
}

function addText(text,l,t){
    //var contentWH  = getTextRect(text_data , font);
    var canvas = document.getElementById('jsImageCoverCanvas');
    var ctx = canvas.getContext('2d');
    /* フォントスタイルを定義 */
    ctx.font = "18px 'ＭＳ Ｐゴシック'";
    /* 青色でstrokText */
    //ctx.strokeStyle = "blue";
    ctx.strokeText(text, l,t);
}




/********************
*canvas をDBに送信
*
*********************/

var l=0;
var t=0;

function CreateCanvas(){
	 // body部パラメーター
    //alert(l);
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


$(function(){
    /**
     * フォーカス処理
     */
    $(".wrapper").click(function(){
        $(".move_img").removeClass("select_now");
        $(".move_text").removeClass("select_now");
    });
    /**
     * 画像を動かす
     */
    $(".move_img").draggable({
        containment: '#jquery-ui-draggable-wrap',
        scroll: false,
        start: function(event, ui) {
            console.log("ドラッグ開始しました");
        },
        stop: function (e, ui) {
            //t = ui.position.top;
            //l = ui.position.left;
            //alert(' top: ' + t + ' left: ' + l);
        },
        drag: function(evt,ui){
            t = ui.position.top;
            l = ui.position.left;
            showImageCanvas(imglocation_left+l, imglocation_top+t,200,200);
        }
    });
    /**
     * 画像を動かす
     */
    $(".move_img").click(function(){
        $(this).addClass("select_now");
    });
    $(".move_img").draggable({
        containment: '#jquery-ui-draggable-wrap',
        scroll: false,
        start: function(event, ui) {
            console.log("ドラッグ開始しました");
            $(this).addClass("select_now");
        },
        stop: function (e, ui) {
            //t = ui.position.top;
            //l = ui.position.left;
            //alert(' top: ' + t + ' left: ' + l);
        },
        drag: function(evt,ui){
            t = ui.position.top;
            l = ui.position.left;
            showImageCanvas(imglocation_left+l, imglocation_top+t,200,200);
        }
    });
    /**
     * 文字を動かす
     */
    $(".move_text").click(function(){
        $(this).addClass("select_now");
    });
    $(".move_text").draggable({
        containment: '#jquery-ui-draggable-wrap',
        scroll: false,
        start: function(event, ui) {
            console.log("ドラッグ開始しました");
            $(this).addClass("select_now");
        },
        stop: function (e, ui) {
            //t = ui.position.top;
            //l = ui.position.left;
            //alert(' top: ' + t + ' left: ' + l);
        },
        drag: function(evt,ui){
            text_t = ui.position.top;
            text_l = ui.position.left;
            //showImageCanvas(imglocation_left+l, imglocation_top+t,200,200);
            //console.log(text_l);
            //console.log(text_t);
        }
    });
    $(".move_text").click(function(){
        //alert(text_l);
        addText($(".move_text p").text(),textlocation_left+text_l,textlocation_top+text_t);
    })



    $("#edit").click(function(){
        $(".move_img canvas").toggle();
        $(".move_img canvas").toggle();
    })
    $("#text_edit").click(function(){
        $(".move_img ").toggle();
    })

    $("#text_input input").each(function(){
        $(this).bind('keyup', hoge(this));
    });
    function hoge(elm){
        var v, old = elm.value;
        return function(){
            if(old != (v=elm.value)){
                old = v;
                str = $(this).val();
                $(".imageCover6 p").text(str);
            }
        }
    }


});
