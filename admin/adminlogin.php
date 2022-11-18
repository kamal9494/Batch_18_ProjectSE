<?php
ob_start();
session_start();
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>ADMIN LOGIN</title>
    <link rel="stylesheet" href="styleadmin.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
</head>

<body>
<div class="boxy">
        <?php
		$msg = '';


		if (
			isset($_POST['login']) && !empty($_POST['username']) &&
			!empty($_POST['password'])
		) {

			if (
				$_POST['username'] == 'admin' &&
				$_POST['password'] == 'admin123'
			) {
				$_SESSION['valid'] = true;
				$_SESSION['admin'] = 'admin';


				//Access granted! take me to Admin Dashboard.
				header('location: vieworders.php');
			} else {
				$msg = '<p style="color: red">Wrong username or password, Try Again!</p>';
			}
		}
		?>

    </div>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <form action="adminlogin.php" method="post" enctype="multipart/form-data">
						<div class="card-body p-5 text-center">
                            <h1 align="center" style="font-family:'Gill Sans', 'Gill Sans MT', 'sans-serif'"> e-Fashion
                                Store</h1>
                            <h3 class="mb-5" style="color:red">Admin Login</h3>

                            <div class="form-outline mb-4">
                                <!-- <label class="form-label" for="typeEmailX-2" style>Email</label> -->
                                <input name="username" type="username" id="typeEmailX-2" class="form-control form-control-lg"
                                    placeholder="Enter username" required/>
                            </div>

                            <div class="form-outline mb-4">
                                <input name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg"
                                    placeholder="Enter password" required/>
                                <!-- <label class="form-label" for="typePasswordX-2">Password</label> -->
                            </div>

                            <!-- Checkbox -->

                            <button name="login" class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                        </div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>