<?php 
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/d644c28068.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Dashboard</title>
    <style>
        .wrapper{
            width: 900px;
            margin: 0 auto;
        }
        table tr td:last-child{
            /* width: 120px; */
            display: flex;
            justify-content: space-between;
        }
        .header{
            height:80px;
            /* background-color: #2596be; */
            display: flex;
            align-items: center;
            color: #eeeee4;
            justify-content: space-between;
            padding-left: 20px;
            padding-right: 20px;
        }
        i{
            margin-right: 10px;
            margin-left: 20px;
        }
        .header > div > a{
            background-color: black;
            padding: 12px;
            padding-left: 0px;
            color: #eeeee4;
            border-radius: 10px;
            border: 0;
            margin-left: 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header sticky-top bg-primary">
        <h2 class="title">To Do App</h2>
        <div>
            <a href="logout.php" class="bg-danger"><i class="fa-solid fa-right-from-bracket fa-lg"></i>Logout</a>
            <a href="change-password.php" class="bg-success"><i class="fa-solid fa-lock fa-lg"></i>Change Password</a>
        </div>
    </div>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-15">
                    <div class="mt-5 mb-3 clearfix table-head">
                        <h2 class="pull-left">Tasks</h2>
                        <div class="table-head2">
                            <a href="task-create.php" class="btn bg-success pull-right" style="color:#eeeee4; margin-left: 170px"><i class="fa fa-plus"></i> Add New Task</a>
                        </div>
                    </div>
                </div>
                    <?php
                    
                    require_once("db-connect.php");

                        $sql = "SELECT * FROM task INNER JOIN user on user.user_id = task.user_id WHERE username = ?";
                        if($query = $db-> prepare($sql)){
                            $query-> bind_param('s', $_SESSION["username"]);
                            if($query->execute()){
                                $result = $query->get_result();
                                if($result->num_rows > 0){
                                    echo '<table class="table table-bordered table-striped">';
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>No.</th>";
                                            echo "<th>Task</th>";
                                            echo "<th>Due Date</th>";
                                            echo "<th>Status</th>";
                                            echo "<th>Category</th>";
                                            echo "<th>Updates</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_array()){
                                        echo "<tr>";
                                            echo "<td>" . $row['task_id'] . "</td>";
                                            echo "<td>" . $row['task_name'] . "</td>";
                                            echo "<td>" . $row['due_date'] . "</td>";
                                            echo "<td>" . $row['status'] . "</td>";
                                            echo "<td>" . $row['category'] . "</td>";
                                            echo "<td>";
                                                echo '<a href="task-details.php?task_id='. $row['task_id'] .'" class="mr-3" title="View Task Details" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                                echo '<a href="task-update.php?emp_no='. $row['task_id'] .'" class="mr-3" title="Update Task" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                                echo '<a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Delete Task" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="fa fa-trash"></span></a>';?>
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Deletion Confirmation</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Do you really want to delete this task ? <br> This action is irreversible
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <a href="task-delete.php?task_id=<?php echo $row['task_id']?>"><button type="button" class="btn btn-primary">Confirm</button></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set
                                $result->free();
                            } else{
                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            }

                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    $db->close();
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

