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

    if(empty($username_error) && empty($password_error)){
        $query = "SELECT user_id, password, user_id, email FROM user WHERE username = ?";
        if($stmt = $db-> prepare($query)){
            $stmt-> bind_param("s", $username);
            if($stmt-> execute()){
                $result = $stmt-> get_result();
                if($result-> num_rows == 1){
                    $row = $result->fetch_assoc();
                    $real_password = $row["password"];
                    if($password === $real_password){
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $username;
                        $_SESSION["email"] = $row["email"];

                        header("location: dashboard.php");
                    }
                    else{
                        $login_error = "Invalid username or password";
                    }
                }
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
  	<title>Login Page</title>
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
								<p>Don't have an account?</p>
								<a href="register.php" class="btn btn-white btn-outline-white">Sign Up</a>
							</div>
			      </div>
						<div class="login-wrap p-4 p-lg-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Sign In</h3>
			      		</div>
			      	</div>
							<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="signin-form">
			      		    <div class="form-group mb-3">
			      			<label class="label" for="username">Username</label>
			      			<input type="text" class="form-control" placeholder="Username" name="username" id="username" required>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
		              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
		            </div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
		            </div>
                    <?php 
                    if(!empty($login_error)){
                        echo '<div class="alert alert-danger">' . $login_error . '</div>';
                    }        
                    ?>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
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

