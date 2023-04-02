<?php 
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}

require_once("db-connect.php");

$username = $password = "";
$username_error = $password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter your username";
    }
    else{
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter your password";
    }
    else{
        $password = trim($_POST["password"]);
    }
    if(empty(trim($_POST["email"]))){
        $email_error = "Please enter your email";
    }
    else{
        $email = trim($_POST["email"]);
    }

    if(empty($username_error) && empty($password_error) && empty($email_error)){
        $query = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        if($stmt = $db-> prepare($query)){
            $stmt-> bind_param("sss", $username, $email, $password);
            $stmt-> execute();
            if($stmt-> execute()){
                header("location: login.php");
            }
            else{
                $login_error = "Invalid username or password";
            }
        }
        else{
            echo "Oops, something went wrong";
        }
        $stmt-> close();
    }
    $db-> close();
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Register Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="style.css">
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h1 class="heading-section">TO DO APP</h1>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Welcome !</h2>
								<p>Already have an account?</p>
								<a href="login.php" class="btn btn-white btn-outline-white">Sign In</a>
							</div>
			        </div>
						<div class="login-wrap p-4 p-lg-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Register</h3>
			      		</div>
			      	</div>
						<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="signin-form">
                            <div class="form-group mb-3">
                                <label class="label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Register</button>
                            </div>
                            <div class="form-group d-md-flex">
                            </div>
		                </form>
		            </div>
		            </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

