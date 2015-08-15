<?php
/**
 * Created by PhpStorm.
 * User: tanakayuuki
 * Date: 2015/01/21
 * Time: 10:05
 */

$id = "111285975280463348967";

?>

    <script src="./js/jquery.xdomainajax.js"></script>
    <script>
        $(function(){
            $.ajax({
                cache:true,
                url: 'https://picasaweb.google.com/data/feed/api/user/<?php echo $id;?>?kind=album&alt=json',
                dataType: 'jsonp',
                error: function(){
                    alert("エラー");
                },
                success: function (json, type) {
                    var list = [];
                    for (var i=0; i<json.feed.entry.length; i++) {
                        var e = json.feed.entry[i];
                        if (e.gphoto$access.$t == "public") {
                            list.push({
                                thumbnail: e.media$group.media$thumbnail[0].url,
                                albumid: e.gphoto$id.$t
                            });
                        }
                    }
                    self.albums = list;
                    var text="";
                    for(var i=0;i<=list.length;i++){
                        $("#aa").append("<img id='img_"+i+"' src ="+"'"+list[i].thumbnail+"'"+">");
                    }
                }
        });


            //ウィンドウのloadイベントに下記の初期化メソッドinitを関連付ける
            window.addEventListener("load",init,true);
//初期化メソッド各要素にイベントハンドラを設定する

//ドラッグ開始時のイベントハンドラ
            function dragstart(e){
                //ドラッグ対象の要素の枠線を赤にする
                e.target.style.borderColor = "red";
                //ドラッグ対象の要素のテキストを変更する
                e.target.innerHTML = e.target.id+"をドラッグ開始";
            }
//ドラッグ中のイベントハンドラ
            function drag(e){
                //ドラッグ対象の要素の背景色を黄色にする
                e.target.style.backgroundColor = "yellow";
                //ドラッグ対象の要素のテキストを変更する（マウスカーソルの座標上表を表示）
                e.target.innerHTML = e.target.id+"をドラッグ中 ("+e.clientX+","+e.clientY+")<br>";
            }
//ドラッグ終了時のイベントハンドラ
            function dragend(e){
                //ドラッグ対象の要素の背景色を黄緑色（ページロード時の色）にする
                e.target.style.backgroundColor = "chartreuse";
                //ドラッグ対象の要素の枠線を緑色（ページロード時の色）にする
                e.target.style.borderColor = "green";
                //ドラッグ対象の要素のテキストを変更する
                e.target.innerHTML = e.target.id+"をドラッグ終了";
            }

        })
    </script>

<div id="aa">

</div>
