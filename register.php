<?php
ob_start();
session_start();
include('connections/localhost.php');

?>


<!doctype html>
<html lang="en">

<?php include("includes/header.php"); ?>

<?php include("includes/navbar.php"); ?>

<body>
<div class="msg">
        <?php
		// this code below for when someone presses the REGISTER button

		/** sanitize input */
		function cleanInput(string $data)
		{
			//this to clean and sanitize our input data
			$data = strip_tags(trim($data));
			$data = htmlspecialchars($data);
			$data = stripslashes($data);
			return ($data);
		}

		if (isset($_POST['register'])) {
			global $conn;

			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$phone =  mysqli_real_escape_string($conn, $_POST['phone']);
			$email =  mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$confirmPass = mysqli_real_escape_string($conn, $_POST['confirmPass']);

			$name = cleanInput($name);
			$phone = cleanInput($phone);
			$email = cleanInput($email);
			$password = cleanInput($password);

			filter_var($email, FILTER_VALIDATE_EMAIL) or die("Email not valid");
			if (strlen($password) < 8) exit("Password requires 8 or more characters");

			if ($password !== $confirmPass) {
				//this means passwords do not match
				exit("Passwords do not match");
			}

			$s = "SELECT COUNT(*) from `customers` where email= '$email'";
			$result = mysqli_query($conn, $s);
			$num = mysqli_fetch_row($result)[0];
		
 			if ($num > 0) {
				// this means the user already exists
				exit("User already exists!");
			} else {
				$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
				$reg = "INSERT INTO `customers`(`name`, `email`, `password`, `phone`, `datejoined`) 
						VALUES ('$name','$email','$hashedpassword', '$phone', NOW())";

				if (mysqli_query($conn, $reg)) {
					$_SESSION['valid'] = true;
					$_SESSION['name'] = $name;
					$_SESSION['email'] = $email;


					echo '<p style="color: green"> Registration successful! Redirecting you... </p>';
					//header('Refresh: 1; URL = myaccount.php');
				} else {
					echo "Sign up failed" . mysqli_error($conn);
				}
			}
		}
 
		?>
    </div>

    <!-- <section class="vh-100" style="background-color: #eee;"> -->
        <!-- <div class="container h-100"> -->
            <!-- <div class="row d-flex justify-content-center align-items-center h-100"> -->
                <!-- <div class="col-lg-12 col-xl-11"> -->
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign Up</p>

                                    <form action="register.php" method="post">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="name" type="text" id="form3Example1c" placeholder="Enter your Name" class="form-control" required/>
                                                <!-- <label class="form-label" for="form3Example1c">Your Name</label> -->
                                            </div>
                                        </div>

										<div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="phone" type="phone" id="form3Example3c"  placeholder="Enter Phone Number" class="form-control" required/>
                                                <!-- <label class="form-label" for="form3Example3c"></label> -->
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="email" type="email" id="form3Example3c"  placeholder="Enter Email" class="form-control" required/>
                                                <!-- <label class="form-label" for="form3Example3c"></label> -->
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="password" type="password" id="form3Example4c" placeholder="Create a Password" class="form-control" required/>
                                                <!-- <label class="form-label" for="form3Example4c">Password</label> -->
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input name="confirmPass" type="password" id="form3Example4cd" placeholder="Repeat your password" class="form-control" required/>
                                                <!-- <label class="form-label" for="form3Example4cd"></label> -->
                                            </div>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <input class="form-check-input me-2" type="checkbox" value=""
                                                id="form2Example3c" />
                                            <label class="form-check-label" for="form2Example3">
                                                I agree all statements in <a href="#!">Terms of service</a>
                                            </label>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <label class="form-check-label" for="form2Example3">
                                                Have an Account? <a href="login.php">Login here</a>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button name="register" type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="signup.png" class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    <!-- </section> -->


    <!-- <h1 class="h-auto" align="center">Create Account</h1>
    <br>
    <div class="form">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <div align="center">
                <label>Name</label>
                <input name="name" type="text" height="30" placeholder="enter name" required>
            </div>
            <br>
            <div align="center">
                <label>Phone No.</label>
                <input name="phone" type="text" maxlength="11" height="30"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                    placeholder="phone number" required>
            </div>
            <br>
            <div align="center">
                <label>Email</label>
                <input name="email" type="email" height="30" maxlength="30" placeholder="enter email" required>
            </div>
            <br>
            <div align="center">
                <label>Create Password</label>
                <input name="password" type="password" height="30" pattern=".{6,}" title="6 characters minimum"
                    maxlength="30" placeholder="6 characters or more" required>
            </div>
            <br>
            <div align="center">
                <label>Confirm Password</label>
                <input name="confirmPass" type="password" height="30" maxlength="30" pattern=".{6,}"
                    title="6 characters minimum" placeholder="repeat password" required>
            </div>
            <br>
            <div align="center">
                <input class="button" name="register" type="submit" value="REGISTER">
            </div>
        </form>
        <p>Already have an Account? <a href="login.php">Login here</a>
        </p>
    </div> -->


    <?php include("includes/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>

</html>