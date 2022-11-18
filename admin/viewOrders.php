<?php
ob_start();
session_start();
if ( !isset( $_SESSION[ 'admin' ] ) ) {
	echo "<script>alert('Please login first!') </script>";
	echo "<script>open('adminlogin.php', '_self') </script>";
}
include( '../connections/localhost.php' );
?>



<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
<title>ADMIN | View products</title>
<link rel="stylesheet" href="../style.css" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" style="color: crimson;" href="#">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="addproducts.php">Add Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="vieworders.php">Orders</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li> -->
      </ul>
      
    </div>
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" style="color:red;" aria-current="page" href="adminlogout.php"><strong>Logout</strong></a>
        </li>
      </ul>
  </div>
</nav>

<h2 class = "h-auto"> View Orders Placed</h2>
<?php
	
	$query = "SELECT * \n"
    . "FROM `orders` \n"
    . "INNER JOIN `products` ON orders.product_id = products.productID \n"
	. "ORDER BY `date_added` DESC";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	$count = mysqli_num_rows($result);
	if ($count == 0) exit('<p align="center"> No Orders Placed Yet! </p>'); 
	
	?>


<table class="table table-bordered" width="800" border="1px">
  <tbody>
    <tr style="text-align: center;">
      <th scope="col">Order #</th>
      <th scope="col">Customer Email</th>
      <th scope="col">Product Name</th>
      <th scope="col">Recieved Cash ( &#8377;)</th>
      <th scope="col">Date Ordered</th>
      <th scope="col">Customer Address</th>
    </tr>
    <?php
			global $i; 
	  		$i = 0; //counter
	  		date_default_timezone_set('Asia/Shanghai'); //change this according to your location
			while ($row = mysqli_fetch_array($result)) {
				$i = ++$i ;
			?>
    <tr style="text-align: center;">
      <td><?php echo $i ?></td>
      <td><?php echo $row['customer_email'] ?></td>
      <td><?php echo $row['productname'] ?></td>
      <td align="center"><?php echo $row['price'] ?></td>
      <td><?php echo date_format(new DateTime($row['date_added']), "Y-M-d H:i")  ?></td>
      <td><?php echo $row['address'] ?></td>
    </tr>
  </tbody>
  <?php  }	?>
</table>




</body>
</html>