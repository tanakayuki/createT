
    <script src="./js/jquery.glide.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/glide.css">
    <style>
        .slider{
            padding: 5% 0 10% 0;
        }
    </style>
    <div class="slider">
    <ul class="slides">
        <li class="slide"><img src="./images/image1.jpg"></li>
        <li class="slide"><img src="./images/image2.jpg"></li>
    </ul>
</div>
<script>
    $('.slider').glide({
        autoplay: 3000,
        animationDuration: 1000,
        arrows: false,
        keyboard: true,
        navigation:true
    });
</script>
