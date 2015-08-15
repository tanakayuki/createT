<?php
/**
 * Created by PhpStorm.
 * User: tanakayuuki
 * Date: 2015/02/13
 * Time: 14:21
 */
?>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>

    <script type="text/javascript">
        // 1.イベントとコールバックの定義
        var socketio = io.connect('http://localhost:1337');
        var num = 3000;
        var timer ="";

        socketio.on("connected", function(name) {});
        socketio.on("publish", function (data) { addMessage(data.value); });
        socketio.on("disconnect", function () {});

        // 2.イベントに絡ませる関数の定義
        function start(name) {
            socketio.emit("connected", name);
        }

        function publishMessage() {
            var textInput = document.getElementById('msg_input');
            var msg = "[" + myName + "] " + textInput.value;
            socketio.emit("publish", {value: msg});
            textInput.value = '';
        }
        function addMessage (msg) {
            $("#me").show("1000");
            if(timer != ""){
                clearTimeout(timer);
            }
            timer = setTimeout(function(){
                $("#me").hide("show");
            },num);
            document.getElementById("me").innerHTML = new Date().toLocaleTimeString() + ' ' + msg + '<a href="aaa.html">見に行く</a>';
        }
        function addMember (msg) {
            var domMeg = document.createElement('div');
            domMeg.innerHTML = new Date().toLocaleTimeString() + ' ' + msg;
            msgArea.appendChild(domMeg);
        }
        // 3.開始処理
        var msgArea = document.getElementById("msg");
        var myName = Math.floor(Math.random()*100) + "さん";
        addMember("貴方は" + myName + "として入室しました");
        start(myName);
    </script>
    <style>
        #me{
            width:40%;
            height: 40px;
            background-color: #f8f98a;
            display: none;
            position: absolute;
            position: fixed;
            right: 0;
        }
    </style>

</head>
<body>
<input type="text" id="msg_input" style="width:200px;" />
<button onclick="publishMessage();">語る</button>
<div id="msg"></div>
<script src="/socket.io/socket.io.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<div id="me"></div>
</body>
</html>