<?php 
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once("db-connect.php");

$password1 = $password2 = "";
$password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["password1"]))){
        $password_error = "Please enter your password";
    }
    else{
        $password1 = trim($_POST["password1"]);
    }
    if(empty(trim($_POST["password2"]))){
        $password_error = "Please enter your password";
    }
    else{
        $password2 = trim($_POST["password2"]);
    }

    if(empty($password_error)){
        if($password1 === $password2){
            $query = "UPDATE user SET password = ? WHERE username = ?";
            if($stmt = $db-> prepare($query)){
                $stmt-> bind_param("ss", $password1, $_SESSION["username"]);
                $stmt->execute();
                header("location: dashboard.php");
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Change Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
	
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
								<h2>Welcome <?php echo $_SESSION["username"]?>!</h2>
								<p>Don't want to change your password?</p>
								<a href="dashboard.php" class="btn btn-white btn-outline-white">Go back</a>
							</div>
			      </div>
						<div class="login-wrap p-4 p-lg-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Password change</h3>
			      		</div>
			      	</div>
							<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="signin-form">
			      		    <div class="form-group mb-3">
			      			<label class="label" for="password1">Password</label>
			      			<input type="password" class="form-control" placeholder="Password" name="password1" id="password1" required>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password2">Repeat password</label>
		              <input type="password" name="password2" id="password2" class="form-control" placeholder="Password" required>
		            </div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary submit px-3">Change password</button>
		            </div>
                    <?php 
                    if(!empty($password_error)){
                        echo '<div class="alert alert-danger">' . $password_error . '</div>';
                    }  
                    ?>
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

