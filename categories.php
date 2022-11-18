<?php
ob_start();
session_start();
include('connections/localhost.php');
?>

<?php include( "includes/header.php" ); ?>

<?php include( "includes/navbar.php" ); ?>

<body>

    <div class="cat1">
        <div>
            <a href="categoryview.php?category=men top">
                <img src="https://assets.ajio.com/medias/sys_master/root/20220531/9IyW/6295531baeb26921aff9a691/-473Wx593H-441139480-grey-MODEL.jpg"
                    class="category" width="200" height="200">
                <p class="category">Men</p>
            </a>
        </div>

        <div>
            <a href="categoryview.php?category=women bottom">
                <img src="https://assets.ajio.com/medias/sys_master/root/20220409/FEoF/6250a59af997dd03e251efd3/-473Wx593H-464099250-black-MODEL.jpg"
                    class="category" width="200" height="200">
                <p class="category">Women</p>
            </a>
        </div>

        <div>
            <a href="categoryview.php?category=kids">
                <img src="https://assets.ajio.com/medias/sys_master/root/20220616/6hH1/62ab67b1aeb26921af2d2ecc/-473Wx593H-4924115870-multi-MODEL.jpg"
                    class="category" width="200" height="200">
                <p class="category">Kids</p>
            </a>
        </div>
    </div>

    <div class="cat1">
        <div>
            <a href="categoryview.php?category=men_shoe">
                <img src="https://assets.ajio.com/medias/sys_master/root/20220930/xWT0/6336078eaeb269659c1b21f3/-473Wx593H-465080284-olive-MODEL.jpg"
                    class="category" width="200" height="200">
                <p class="category">Footwear</p>
            </a>
        </div>

        <div>
            <a href="categoryview.php?category=men top">
                <img src="https://assets.ajio.com/medias/sys_master/root/20210806/0JhK/610c59d07cdb8cb824edd54e/-473Wx593H-462745357-blue-MODEL.jpg"
                    class="category" width="200" height="200">
                <p class="category">Shirts</p>
            </a>
        </div>

        <div>
            <a href="categoryview.php?category=women top">
                <img src="https://assets.ajio.com/medias/sys_master/root/20210724/Q2WA/60fb2920f997ddb3123704e1/-473Wx593H-441126109-green-MODEL.jpg"
                    class="category" width="200" height="200">
                <p class="category">Tops</p>
            </a>
        </div>
    </div>
    <br>
    <?php include( "includes/footer.php" ); ?>
    <br>



</body>

</html>