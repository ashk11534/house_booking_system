<?php 
    ob_start();
    include("db_connect.php");
    session_start();
    unset($_SESSION["category_apartment"], $_SESSION["description_apartment"], $_SESSION["address_apartment"], $_SESSION["whatsapp_apartment"], $_SESSION["image_apartment"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
            <?php include("partials/nav.php"); ?>
                <form action="" method="POST">
                    <input class="btn btn-danger mx-2" type="submit" name="logout-button" value="Logout">
                </form>
            <?php include("partials/nav_end.php"); ?>
            <h1>DASHBOARD</h1>
            <hr>
                    <?php
                        if(isset($_SESSION["user_tenant_id"])){
                            $user_id = $_SESSION["user_tenant_id"]; 
                            $sql = "SELECT * FROM apartment WHERE tenant_id=$user_id ORDER BY id DESC";
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
                                        <div class="col" style="flex: 0 0 0%;">
                                            <div class="card" style="width: 10rem;">
                                                <img src="<?php echo "uploads/apartment-images/".$row["image_name"] ;?>" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <form action="" method="POST">
                                                        <h5 class="card-title"><?php echo $row["category"];?></h5>
                                                        <p class="card-text"><?php echo $row["description"];?></p>
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
                        }
                        else{
                            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/login.php");
                        }
                        
                    ?>
                </div>
            </div>
</body>

</html>
<?php
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
?>