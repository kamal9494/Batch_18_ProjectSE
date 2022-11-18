<?php
ob_start();
session_start();
include('connections/localhost.php');

?>

<?php include("includes/header.php");
?>

<?php include("includes/navbar.php");
?>

<body>

  <div class="login-page">
  <div class="msg">
		<?php
		if (isset($_POST['login'])) {
			global $conn;

			$email = trim(mysqli_real_escape_string($conn, $_POST['email']));
			$password = trim(mysqli_real_escape_string($conn, $_POST['password']));

			if (empty($email) || empty($password)) {
				echo "Must fill all fields";
				exit;
			}

			filter_var($email, FILTER_VALIDATE_EMAIL) or die("Email not valid");


			$query = "SELECT `password` FROM `customers` WHERE `email`= '$email'";
			$query_run = mysqli_query($conn, $query);
			$result = mysqli_fetch_assoc($query_run)["password"] or exit("User does not exist");
			
			if (!password_verify($password, $result)) {
				exit("Wrong email or password!...Try again.");
			} else {
				$getname = "SELECT `name` FROM `customers` WHERE `email`='$email'";
				$query_two = mysqli_query($conn, $getname);
				$name = mysqli_fetch_assoc($query_two)["name"];

				$_SESSION['valid'] = true;
				$_SESSION['email'] = $email;
				$_SESSION['name'] = $name;

				if (isset($_SESSION['category'])) {
					// take us back to where we were (before logged in)
					$categoryName = stripslashes(strip_tags($_SESSION['category']));
					unset($_SESSION['category']);
					header("location:categoryview.php?category=$categoryName");
				} else {
					//otherwise take us to our dashboard.
					header("location:myaccount.php");
				}
			}
		}
		?>
	</div>




    <section class="vh-100">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6 text-black">

            <div class="px-5 ms-xl-4">
              <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
              <span class="h1 fw-bold mb-0">
                <h2>Welcome!</h2>
                <p>Create your account.<br> For Free!</p>
              </span>
            </div>

            <div class="d-flex align-items-center h-custom-1 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

              <form style="width: 23rem;" action="login.php" method="post" enctype="multipart/form-data">

                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log In</h3>
                <div class="form-outline mb-4">
                  <input name="email" type="email" id="form2Example18" placeholder="Enter email id"
                    class="form-control form-control-lg" required/>
                </div>

                <div class="form-outline mb-4">
                  <input name="password" type="password" id="form2Example28" placeholder="Enter password"
                    class="form-control form-control-lg" required/>
                </div>

                <div class="pt-1 mb-4">
                  <button name="login" class="btn btn-info btn-lg btn-block" type="submit">Login</button>
                </div>
                <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a><br>Don't have an
                  account? <a href="register.php" class="link-info">Register here</a></p>
              </form>

            </div>

          </div>
          <div class="col-sm-6 px-0 d-none d-sm-block">
            <img src="login.png" alt="Login image" class="w-100 vh-100"
              style="object-fit: cover; object-position: left;">
          </div>
        </div>
      </div>
    </section>
  </div>

<!-- php -->
	<!-- end of form-->
	
	


	<?php include("includes/footer.php"); ?>
</body>

</html>