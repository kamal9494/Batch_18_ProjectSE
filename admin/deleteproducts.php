<?php
ob_start();
session_start();
include("../connections/localhost.php");
global $conn;

if (isset($_SESSION['admin']) && isset($_GET['product'])){
    $cart_id = htmlspecialchars(stripslashes(trim($_GET['product'])));
	$cart_id = mysqli_real_escape_string($conn, $cart_id);


	$removeQuery = "DELETE FROM `products` WHERE `productID`='$cart_id'";

	$result = mysqli_query($conn, $removeQuery) or die(mysqli_error($conn));

	if ($result === TRUE) {
		echo "<script>window.location.replace('products.php')</script>";
	}
}