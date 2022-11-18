<?php
include('connections/localhost.php');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<!-- nav bar code-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">E-Fashion Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Men
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="categoryview.php?category=men top">Men Topwear</a>
                        <a class="dropdown-item" href="categoryview.php?category=men bottom">Men Bottomwear</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Women
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="categoryview.php?category=women top">Women Topwear</a>
                        <a class="dropdown-item" href="categoryview.php?category=women bottom">Women Bottomwear</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Footwear
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="categoryview.php?category=men_shoe">Men Footwear</a>
                        <a class="dropdown-item" href="categoryview.php?category=women_shoes">Women Footwear</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="categoryview.php?category=kids">Kids</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="categoryview.php?category=beauty">Beauty</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a>
                </li>

                <?php
	if (isset($_SESSION['email'])) {
		// if user is LOGGED IN.
		// if user is LOGGED IN.
		$email = mysqli_real_escape_string($conn,  $_SESSION['email']);
		$query = "SELECT COUNT(*) AS count FROM `cart` WHERE `customer_email`='$email'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$cartCount = (int) mysqli_fetch_assoc($result)["count"];

		echo '<li class="nav-item">
		<a class="nav-link active" aria-current="page" href="myaccount.php">My Account</a>
	  </li>';
	?>
                <li class="nav-item">
                    <a class="nav-link active" href="cart.php"><img src="shopping-cart-icon.png" width="20px"
                            height="20px">
                        <strong>Cart (<?= $cartCount ?>)</strong></a>

                    <?php

} else {
//if  NOT logged in
echo '<li class="nav-item">
<a class="nav-link active" aria-current="page" href="login.php">Log In</a>
</li>';

echo '<li class="nav-item">
<a class="nav-link active" onClick="loginFirst() aria-current="page" href="myaccount.php"><img src="shopping-cart-icon.png" width="20px" height="20px"><strong>Cart</strong></a>;
</li>';
}
?>
                </li>
            </ul>

        </div>
    </div>
    <?php
	if(isset($_SESSION['email'])){
		echo '<br> <br> <p class="wow">Logged in as: ' . $email . '</p>';
	}
	?>
</nav>
<!-- <nav>
    <br>
    <a href="index.php"> <strong>Home</strong> </a>
    <a href="categories.php"><strong>Categories</strong></a>
    <a href="contact.php"><strong>Contact Us</strong></a>


    <?php
	if (isset($_SESSION['email'])) {
		// if user is LOGGED IN.
		// if user is LOGGED IN.
		$email = mysqli_real_escape_string($conn,  $_SESSION['email']);
		$query = "SELECT COUNT(*) AS count FROM `cart` WHERE `customer_email`='$email'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$cartCount = (int) mysqli_fetch_assoc($result)["count"];

		echo '<a href="myaccount.php"><strong>My Account</strong></a>';
	?>
    <a class="cart-icon" href="cart.php"><img src="shopping-cart-icon.png" width="20px" height="20px">
        <strong>Cart (<?= $cartCount ?>)</strong></a>
    <?php

		echo '<br> <br> <p class="wow">Logged in as: ' . $email . '</p>';
	} else {
		//if  NOT logged in
		echo '<a href="login.php"><strong>Log In</strong></a>';

		echo '<a class="cart-icon" onClick="loginFirst()"><img src="shopping-cart-icon.png" width="20px" height="20px"><strong>Cart</strong></a>';
	}
	?>

</nav> -->
<!-- end of nav bar-->



<script type="application/javascript">
function loginFirst() {
    //this will take non-logged in user to Login Page
    window.alert("Please login first!");
    window.location.replace("login.php");
}
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script> -->