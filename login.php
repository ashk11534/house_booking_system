<?php 
    include("db_connect.php"); 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
            <?php include("partials/nav.php"); ?>
            <?php include("partials/nav_end.php"); ?>
            <?php 
                if(isset($_SESSION["signup_success_message"])){
                    ?>
                    <p><?php echo $_SESSION["signup_success_message"]; ?></p>
                    <?php
                    unset($_SESSION["signup_success_message"]);
                } 
            ?>
            <div class="container d-flex flex-column align-items-center">
                <div class="log-in-owner card p-4 text-center bg-dark text-light" style="width:30rem;">
                    <h3>Login As Owner</h3>
                    <form action="" method="POST">
                        <input type="email" name="email" placeholder="Enter Your Email" class="d-block w-100 mt-2">
                        <input type="password" name="password" placeholder="Enter Your Password" class="d-block w-100 mt-2">
                        <input class="btn btn-success mt-2" type="submit" name="submit-button-owner" value="Login">
                    </form>
                </div>
                <div class="log-in-tenant card mt-3 p-4 text-center bg-dark text-light" style="width:30rem;">
                    <h3>Login As Tenant</h3>
                    <form action="" method="POST">
                        <input type="email" name="email" placeholder="Enter Your Email" class="d-block w-100 mt-2">
                        <input type="password" name="password" placeholder="Enter Your Password" class="d-block w-100 mt-2">
                        <input class="btn btn-success mt-2" type="submit" name="submit-button-tenant" value="Login">
                    </form>
                </div>
            </div>
          
</body>

</html>
<?php
    if(isset($_POST["submit-button-owner"])){
        if(isset($_POST["email"]) && isset($_POST["password"])){
            $email = $_POST["email"];
            $sql = "SELECT * FROM owner WHERE email='$email'";
            $res = mysqli_query($conn, $sql);

            if($res == true){
                $count = mysqli_num_rows($res);
                if($count > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $owner_id = $row["id"];
                        $_SESSION["owner_id"] = $owner_id;
                        header("location:". "http://localhost/PHP_PROJECTS/Rent_House");
                    }
                }
                else{
                    $_SESSION["login_failure_message"] = "Login failed. Please signup first.";
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/signup.php");  
                }
            }
        }
        // header("location:". "http://localhost/PHP_PROJECTS/Rent_House/index.php"); 
    }
    if(isset($_POST["submit-button-tenant"])){
        if(isset($_POST["email"]) && isset($_POST["password"])){
            $email = $_POST["email"];
            $sql = "SELECT * FROM tenant WHERE email='$email'";
            $res = mysqli_query($conn, $sql);

            if($res == true){
                $count = mysqli_num_rows($res);
                if($count > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $tenant_id = $row["id"];
                        $_SESSION["tenant_id"] = $tenant_id;
                        header("location:". "http://localhost/PHP_PROJECTS/Rent_House");
                    }
                    
                }
                else{
                    $_SESSION["login_failure_message"] = "Login failed. Please signup first.";
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/signup.php");  
                }
            }
        }
    }
   
?>
