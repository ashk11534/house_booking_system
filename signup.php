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
                if(isset($_SESSION["login_failure_message"])){
                    ?>
                        <p><?php echo $_SESSION["login_failure_message"]; ?></p>
                    <?php
                    unset($_SESSION["login_failure_message"]);
                }
                if(isset($_SESSION["user_exists_message"])){
                    ?>
                        <p><?php echo $_SESSION["user_exists_message"]; ?></p>
                    <?php
                    unset($_SESSION["user_exists_message"]);
                }
            ?>
            <div class="container d-flex flex-column align-items-center">
                <div class="log-in-owner card p-4 text-center bg-dark text-light" style="width:30rem;">
                    <h1>Signup As Owner</h1>
                    <form action="" method="POST">
                        <input type="email" name="email" placeholder="Enter Your Email" class="d-block w-100 mt-2">
                        <input type="password" name="password" placeholder="Enter Your Password" class="d-block w-100 mt-2">
                        <input class="btn btn-success mt-2" type="submit" name="submit-button-owner" value="Sign Up">
                    </form>
                </div>
                <div class="log-in-tenant card mt-3 p-4 text-center bg-dark text-light" style="width:30rem;">
                    <h1>Signup As Tenant</h1>
                    <form action="" method="POST">
                        <input type="text" name="name" placeholder="Name" required class="d-block w-100 mt-2">
                        <input type="tel" name="phone_number" placeholder="phone number [019xx-xxxxxx]" pattern="[0-9]{5}-[0-9]{6}" required class="d-block w-100 mt-2">
                        <input type="email" name="email" placeholder="Enter Your Email" class="d-block w-100 mt-2">
                        <input type="password" name="password" placeholder="Enter Your Password" class="d-block w-100 mt-2">
                        <input class="btn btn-success mt-2" type="submit" name="submit-button-tenant" value="Sign Up">
                    </form>
                </div>
            </div>
          
</body>

</html>
<?php
    if(isset($_POST["submit-button-owner"])){
        if(isset($_POST["email"]) && isset($_POST["password"])){
            $email = $_POST["email"];
            $password = md5($_POST["password"]);
            $sql_search = "SELECT * FROM owner WHERE email='$email'";
            $res_search = mysqli_query($conn, $sql_search);
            if($res_search == true){
                $count = mysqli_num_rows($res_search);
                if($count > 0){
                    $_SESSION["user_exists_message"]= "This user already exists";
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/signup.php");
                }
                else{
                    $sql = "INSERT INTO owner(email, password) VALUES('$email', '$password')";
                    $res = mysqli_query($conn, $sql);
    
                    if($res == true){
                        $_SESSION["signup_success_message"] = "You can now login";
                        header("location:". "http://localhost/PHP_PROJECTS/Rent_House/login.php");
                    }
                }
            }
            
            
        }
        // header("location:". "http://localhost/PHP_PROJECTS/Rent_House/index.php"); 
    }
    if(isset($_POST["submit-button-tenant"])){
        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["name"]) && isset($_POST["phone_number"])){
            $name = $_POST["name"];
            $phone_number = $_POST["phone_number"];
            $email = $_POST["email"];
            $password = md5($_POST["password"]);
            $sql_search = "SELECT * FROM tenant WHERE email='$email'";
            $res_search = mysqli_query($conn, $sql_search);
            if($res_search == true){
                $count = mysqli_num_rows($res_search);
                if($count > 0){
                    $_SESSION["user_exists_message"]= "This user already exists";
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/signup.php");
                }
                else{
                    $sql = "INSERT INTO tenant(email, password, name, phone_number) VALUES('$email', '$password', '$name', '$phone_number')";
                    $res = mysqli_query($conn, $sql);
    
                    if($res == true){
                        $_SESSION["signup_success_message"] = "You can now login";
                        header("location:". "http://localhost/PHP_PROJECTS/Rent_House/login.php");
                    }
                }
            }
            
            
        }
        // header("location:". "http://localhost/PHP_PROJECTS/Rent_House/index.php"); 
    }
   
?>
