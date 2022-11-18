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
          <a class="nav-link active" aria-current="page" href="#">Products</a>
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

<!-- LIST OF ALL PRODUCTS, PAGED -->
<h2 class="h-auto">List of Products</h2>
  <div class="listproducts">
    <?php

    global $conn;
    //find out how many products in DB
    $sql = "SELECT COUNT(*) as count from `products`";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $totalcount = (int) mysqli_fetch_assoc($result)["count"];

    //decide how many items to show per page.
    $result_per_page = 20;
    $num_of_pages = ceil($totalcount / $result_per_page);

    ?>

    <?php
    //get current page from URL params
    if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
      $currentpage = 1;
    } else {
      $currentpage = (int) $_GET['page'];
    }

    // print all page numbers, horizontally ---->
    echo 'PAGES: ';
    for ($i = 1; $i <= $num_of_pages; $i++) {
      if ($i === $currentpage) {
        echo '<strong class="activeLink">'. $i .'</strong>';
        continue;
      }
    ?>
      <a href="addproducts.php?page=<?= $i ?>"><?= $i ?></a> |
    <?php   } ?>
    <!-- end of for loop-->

    <?php
     // retrieve results from using LIMIT and OFFSET
    $start_from = ($currentpage - 1) * $result_per_page;
    $sql = "SELECT * FROM `products` LIMIT $start_from, $result_per_page";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    ?>
  </div>
  <br />
  <table class="table table-bordered" width="800px" border="1px">
    <thead>
      <tr class="table-active" style="text-align: center;">
        <th style="color:black;" scope="col">ID</th>
        <th style="color:black;" scope="col">Name</th>
        <th style="color:black;" scope="col">Category</th>
        <th style="color:black;" scope="col">Price</th>
        <th style="color:black;" scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_array($result)) {
      ?>
        <tr style="text-align: center;">
          <td><?= $row['productID'] ?></td>
          <td><?= $row['productname'] ?></td>
          <td><?= $row['category'] ?></td>
          <td><?= $row['price'] ?></td>
          <td style="text-align: center;">
            <a href="editproducts.php?product=<?= $row['productID'] ?>"><button class="btn btn-danger">Edit</button></a>
            <a href="deleteproducts.php?product=<?= $row['productID'] ?>"><button onClick="return confirmDelete()" class="btn btn-danger">Delete</button></a>
          </td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>



  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete?");
    }
  </script>
  <!-- END OF LIST OF PRODUCTS -->


</body>

</html>