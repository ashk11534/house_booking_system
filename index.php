<?php 
    ob_start();
    include("db_connect.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rent House</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
            <?php include("partials/nav.php"); ?>
                <?php
                    if(!isset($_SESSION["tenant_id"]) && !isset($_SESSION["owner_id"]) && !isset($_SESSION["user_owner_id"]) && !isset($_SESSION["user_tenant_id"])){
                        ?>
                        <form action="" method="POST">
                            <input class="btn btn-outline-success mx-2" type="submit" name="login-button" value="Login">
                        </form>
                        <?php
                    }
                    else{
                        ?>
                        <form action="" method="POST">
                            <input class="btn btn-outline-success mx-2" type="submit" name="dashboard-button" value="Dashboard">
                        </form>
                        <form action="" method="POST">
                            <input class="btn btn-danger" type="submit" name="logout-button" value="Logout">
                        </form>
                        <?php 
                    }
                ?>
            <?php include("partials/nav_end.php"); ?>
            <?php
                    $sql = "SELECT * FROM apartment ORDER BY id DESC";
                    $res = mysqli_query($conn, $sql);
                    if($res == true){
                        $count = mysqli_num_rows($res);
                        if($count > 0){
                            ?>
                            <div class="container">
                                <div class="row">
                            <?php
                            while($row = mysqli_fetch_assoc($res)){
                                ?>
                                <div class="col my-2" style="flex: 0 0 0%;">
                                    <div class="card" style="width: 15rem;">
                                        <img src="<?php echo "uploads/apartment-images/".$row["image_name"] ;?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <form action="" method="POST">
                                                <h5 class="card-title"><?php echo $row["category"];?></h5>
                                                <p class="card-text"><?php echo $row["description"];?></p>
                                                <input type="hidden" name="hidden_apartment_id" value="<?php echo $row['id'];?>">
                                                <input type="submit" name="details_button" class="btn btn-primary" value="See Details">
                                                <?php 
                                                if($row['tenant_id'] != NULL){
                                                    ?>
                                                   <input type="submit" name="booked_button" class="btn btn-danger" value="Booked"> 
                                                   <?php
                                                }
                                                else{
                                                    ?>
                                                    <input type="submit" name="book_button" class="btn btn-primary" value="Book">
                                                    <?php 
                                                }
                                                ?>
                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                                </div>
                            </div>
                            <?php
                        }
                        else{
                            echo "<h1>No apartment found!!!</h1>";
                        }

                    }
                 
            ?>
          
</body>
</html>

<?php

    if(isset($_POST["login-button"])){
        header("location:". "http://localhost/PHP_PROJECTS/Rent_House/login.php"); 
    }
    if(isset($_POST["logout-button"])){
        if(isset($_SESSION["user_tenant_id"])){
            unset($_SESSION["user_tenant_id"]);
        }    
        if(isset($_SESSION["user_owner_id"])){
            unset($_SESSION["user_owner_id"]);
        }  
        if(isset($_SESSION["owner_id"])){
            unset($_SESSION["owner_id"]);
        }  
        if(isset($_SESSION["tenant_id"])){
            unset($_SESSION["tenant_id"]);
        }  
        header("location:". "http://localhost/PHP_PROJECTS/Rent_House");
    }
    if(isset($_POST["dashboard-button"])){
        if(isset($_SESSION["tenant_id"])){
            $_SESSION["user_tenant_id"] = $_SESSION["tenant_id"];
            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard_tenant.php");
        }
        if(isset($_SESSION["owner_id"])){
            $_SESSION["user_owner_id"] = $_SESSION["owner_id"];
            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard.php");
        }
        
    }
    if(isset($_POST["details_button"])){
        if(isset($_POST["hidden_apartment_id"])){
            $hidden_apartment_id = (int)$_POST["hidden_apartment_id"];
            $sql_apartment = "SELECT * FROM apartment WHERE  id=$hidden_apartment_id";
            $res_apartment = mysqli_query($conn, $sql_apartment);

            if($res_apartment == true){
                $count = mysqli_num_rows($res_apartment);
                if($count > 0){
                    while($row_apartment = mysqli_fetch_assoc($res_apartment)){
                        $category_apartment = $row_apartment["category"];
                        $description_apartment = $row_apartment["description"];
                        $address_apartment = $row_apartment["address"];
                        $whatsapp_apartment = $row_apartment["whatsapp_number"];
                        $image_apartment = $row_apartment["image_name"];
                    }
                    $_SESSION["category_apartment"] = $category_apartment;
                    $_SESSION["description_apartment"] = $description_apartment;
                    $_SESSION["address_apartment"] = $address_apartment;
                    $_SESSION["whatsapp_apartment"] = $whatsapp_apartment;
                    $_SESSION["image_apartment"] = $image_apartment;
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/apartment_details.php"); 
                }
            }
        }
    }
    if(isset($_POST["book_button"])){
        if(isset($_SESSION["tenant_id"])){
            if(isset($_POST["hidden_apartment_id"])){
                $tenant_id = $_SESSION["tenant_id"];
                $hidden_apartment_id = (int)$_POST["hidden_apartment_id"];
                $sql_apartment = "UPDATE apartment SET tenant_id=$tenant_id WHERE  id=$hidden_apartment_id";
                $res_apartment = mysqli_query($conn, $sql_apartment);
    
                if($res_apartment == true){
                    $_SESSION["user_tenant_id"] = $_SESSION["tenant_id"];
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard_tenant.php");
                }
            }
        }
        else{
            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/login.php");
        }
    }
    ob_end_flush(); 
?>
