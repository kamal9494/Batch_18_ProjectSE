<?php
ob_start();
session_start();
include('connections/localhost.php');
?>

<?php include("includes/header.php"); ?>


<?php include("includes/navbar.php"); ?>


<body>
	<?php
	global $conn;
	if (!isset($_GET['category']) || empty(trim($_GET['category']))) {
		header("location: categories.php");
	} else {

		$category = htmlspecialchars(stripslashes(strip_tags($_GET['category'])));
		$category = mysqli_real_escape_string($conn, $category);
		
		$_SESSION['category'] = $category; // for later use.

		$query = "SELECT * FROM `products` WHERE category = '$category'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

		$count = mysqli_num_rows($result);
		if ($count == 0) exit("No Products Found of this Category."); ?>
		<h2 class="h-auto"> <?php echo $category ?></h2>
		<div class="container-grid">
			<?php
			while ($row = mysqli_fetch_array($result)) {
			?>
				<div class="card" style="width: 18rem;margin: 15px 10px">
					<!-- START OF single item box -->
					<img class="card-img-top"  src="<?php echo basename('uploads/') . "/" .  $row['product_image']; ?>">
					<div class="card-body">
					<div><h5 class="card-title"><?php echo $row['productname'] ?></h5> </div>
					<div>
						<p class="card-text" style="color: crimson"><strong><?php echo "&#8377; " . $row['price'] ?></strong> </p>
					</div>
					<br>

					<?php
					if (!isset($_SESSION['email'])) {
						//if user is NOT logged in 
						echo '<div><button class="btn btn-primary" onClick="taketoLogin()">Add to Cart<button></div>';
					} else {
					?>
						<div> <a href="addtocart.php?id=<?php echo $row['productID'] ?>"><button class="btn btn-primary">Add to Cart</button></a></div>
					<?php  }  ?>
					</div>
				</div>
				<!-- END OF single item box -->
		<?php
			}
		}
		?>
		</div>
		</div>


		<br>
		<?php include("includes/footer.php"); ?>
		<br>
		<script type="application/javascript">
			function taketoLogin() {
				//this JS takes someone to Login page if not logged in.
				window.alert("Please login first!");
				window.location.replace("login.php");
			}
		</script>
</br>
</br>
</body>
</html>