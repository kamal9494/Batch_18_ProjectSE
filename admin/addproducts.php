<?php
ob_start();
session_start();
if (!isset($_SESSION['admin'])) {
  echo "<script>alert('Please login first!') </script>";
  echo "<script>open('adminlogin.php', '_self') </script>";
}
include('../connections/localhost.php');
?>


<!doctype html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css" type="text/css">
  <title>ADMIN | Add Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
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
<center>

<h2 class="h-auto"> Add New Product</h2>
  
<div class="min">
  <form  method="post" enctype="multipart/form-data">
  <div class="form-row">
  <div class="form-group spp col-md-13">
    <label for="exampleFormControlInput1">Product Name</label>
    <input name="name" type="text" class="form-control" id="exampleFormControlInput1"  required>
  </div>
  <div class="form-group spp col-md-5">
    <label for="exampleFormControlInput1">Price</label>
    <input name="price" type="number" class="form-control" id="exampleFormControlInput1" required>
  </div>
</div>


  <div class="form-group spp">
    <label for="exampleFormControlSelect1">Category</label>
    <select name="category" class="form-control" id="exampleFormControlSelect1" required>
    <?php
        $query = "SELECT `name` FROM `categories`;";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <option><?= $row['name'] ?></option>
        <?php
        }
        ?>
    </select>
  </div>

  <label class="form-label spp" for="customFile">Select Image (max file size: 2 MB)</label>
  <input name=MAX_FILE_SIZE value=2000000 type=hidden>
<input name="product_image" type="file" class="form-control spp" id="customFile" accept=".jpg, .jpeg, .png" required/>
<button type="submit" class="btn btn-primary btn-lg btn-block spp" name="insert">Insert</button>
</form>
</div>
</center>






  <!-- <nav style="margin-top: 0">
    <a href="adminlogout.php">Logout</a>
    <a href="addcategory.php">Categories</a>
    <a href="#">Products</a>
    <a href="vieworders.php">View Orders</a>
  </nav> -->

  

  <!-- START UPLOAD FILE CODE BELOW -->
  <div class="msg">
    <?php

    global $conn;
    if (isset($_POST['insert'])) {

      $productname = mysqli_real_escape_string($conn, $_POST['name']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);

      $productname = strtoupper(trim($productname)); //converts to UPPER CASE


      //-----------------------------here below START image file upload process -----------//
      $fileName = $_FILES['product_image']['name'];
      $filetype = $_FILES['product_image']['type'];
      $fileTemp = $_FILES['product_image']['tmp_name'];
      $fileSize = $_FILES['product_image']['size'];
      $uploadError = $_FILES['product_image']['error'];


      if ($uploadError != 0) {
        if ($uploadError == 2) echo ("Sorry, your file size exceeds limit. \n");
        exit("Upload failed.");
      }

      // Check if file is an actual image/photo file. VERY INTELLIGENT & ACCURATE. 
      //  USE this if PHOTOS are the only file uploads required. WON'T work with PDF, DOC etc.
      if (exif_imagetype($fileTemp) != IMAGETYPE_JPEG && exif_imagetype($fileTemp) != IMAGETYPE_PNG) {
        exit("Invalid file type. Upload failed.");
      }

      //CHECKS file type by simply reading the file extension. QUICK, BUT NOT RECOMMENDED.
      // This Can be fooled easily if User modifies file extension before upload.
      if ($filetype != "image/jpeg" && $filetype != "image/png") {
        exit("Invalid file type. Upload failed.");
      }


      $target_dir = "../uploads/";
      $target_file = $target_dir . basename($fileName);

      //check if file exists
      if (file_exists($target_file)) {
        die("Sorry, File already exists. Upload failed.");
      }

      // check file size
      if ($fileSize > 2000000) {
        // In bytes.  Adjust the amount as you wish
        die("Sorry, file is over 2MB. Upload failed");
      } else {
        // everything is OK. Can now proceed to save the file.

        // FIRST, remove all special characters and spaces in file name
        $pattern = "/[^ 0-9a-zA-Z_\.]+/";
        $date = date_create("now", new DateTimeZone("Asia/Shanghai"));
        $newFileName = "PROD_" . date_format($date, "Ymdhisu") . "." . pathinfo($fileName, PATHINFO_EXTENSION);

        // THEN, move file to final destination
        move_uploaded_file($fileTemp, "../uploads/$newFileName") or die("Upload failed");

        //----------------- here above END of file upload process--------//

        // FINALLY add everything you got into database:
        $insert_product = "INSERT INTO `products`(`productname`, `price`, `category`, `product_image`) VALUES ( ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($insert_product)) {
          //all is good, proceed.
          $stmt->bind_param("siss", $productname, $price, $category, $newFileName);
          $stmt->execute();
          echo "<script>alert('Product added successfully!')</script>";
          echo "<script>window.open('addproducts.php','_self')</script>";
        } else {
          echo "Upload failed " . mysqli_error($conn);
        }
      }
    }
    ?>
  </div>
  <!-- END UPLOAD FILE ABOVE-->


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>