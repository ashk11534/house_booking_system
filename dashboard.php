<?php 
    ob_start();
    include("db_connect.php");
    session_start();
    unset($_SESSION["category_apartment"], $_SESSION["description_apartment"], $_SESSION["address_apartment"], $_SESSION["whatsapp_apartment"], $_SESSION["image_apartment"]);
    unset($_SESSION["tenant_searched_email"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
            <?php include("partials/nav.php"); ?>
                <form action="" method="POST">
                    <input class="btn btn-danger mx-2" type="submit" name="logout-button" value="Logout">
                </form>
            <?php include("partials/nav_end.php"); ?>
            <h1>DASHBOARD</h1>
            <hr>
            <div class="main-content">
                <div class="left">
                    <form action="" method="POST" enctype="multipart/form-data" class="main-form">
                        <input type="text" name="category" placeholder="Enter Category" required>
                        <textarea cols="30" rows="10" placeholder="Write description[0-255 character]"  name="description" required></textarea>
                        <input type="text" name="address" placeholder="Enter Address" required>
                        <input type="tel" name="whatsapp_number" placeholder="whatsapp number [019xx-xxxxxx]" pattern="[0-9]{5}-[0-9]{6}" required>
                        <input type="file" name="apartment_image" required>
                        <input class="btn btn-outline-success mx-2" type="submit" name="submit-button" value="Add Apartment" required>
                    </form>
                </div>
                <div class="right">
                    <?php
                        if(isset($_SESSION["user_owner_id"])){
                            $user_id = $_SESSION["user_owner_id"]; 
                            $sql = "SELECT * FROM apartment WHERE owner_id=$user_id ORDER BY id DESC";
                            $res = mysqli_query($conn, $sql);
                            if($res == true){
                                $count = mysqli_num_rows($res);
                                if($count > 0){
                                    ?>
                                    <div class="container">
                                        <h1>All</h1>
                                        <hr>
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
                                                        <input type="hidden" name="apartment_id" value="<?php echo $row["id"] ;?>">
                                                        <input type="submit" value="Update" name="update" class="btn btn-primary">
                                                        <input type="submit" value="Delete" name="delete" class="btn btn-danger">
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
                                    ?> 
                                    <h1>All</h1>
                                    <hr>
                                    <?php
                                    echo "<h1>No apartment found!!!</h1>";
                                }
        
                            }
                        }
                        else{
                            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/login.php");
                        }
                        
                    ?>
                </div>
                <div class="bottom">
                <?php
                        if(isset($_SESSION["user_owner_id"])){
                            $user_id = $_SESSION["user_owner_id"]; 
                            $sql = "SELECT * FROM apartment WHERE owner_id=$user_id AND tenant_id IS NOT NULL ORDER BY id DESC";
                            $res = mysqli_query($conn, $sql);
                            if($res == true){
                                $count = mysqli_num_rows($res);
                                if($count > 0){
                                    ?>
                                    <div class="container">
                                        <h1>Booked</h1>
                                        <hr>
                                        <div class="row">
                                    <?php
                                    while($row = mysqli_fetch_assoc($res)){
                                        ?>
                                        <div class="col my-2" style="flex: 0 0 0%;">
                                            <div class="card" style="width: 12rem;">
                                                <img src="<?php echo "uploads/apartment-images/".$row["image_name"] ;?>" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <form action="" method="POST">
                                                        <h5 class="card-title"><?php echo $row["category"];?></h5>
                                                        <p class="card-text"><?php echo $row["description"];?></p>
                                                        <input type="hidden" name="tenant_id" value="<?php echo $row['tenant_id']; ?>">
                                                        <input type="hidden" name="apartment_id_release" value="<?php echo $row['id']; ?>">
                                                        <input type="submit" name="details" value="Tenant-details" class="btn btn-primary">
                                                        <input type="submit" name="release" value="Release" class="btn btn-primary mt-2">
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
                                    ?> 
                                    <h1>Booked</h1>
                                    <hr>
                                    <?php
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
    if(isset($_POST["submit-button"])){
        if(isset($_POST["category"]) && isset($_POST["description"]) && isset($_POST["address"]) && isset($_POST["whatsapp_number"]) && isset($_FILES["apartment_image"])){
            $category = $_POST["category"];
            $descrip = $_POST["description"];
            $description = nl2br(htmlentities($descrip, ENT_QUOTES, 'UTF-8'));
            $address = $_POST["address"];
            $whatsapp_number = $_POST["whatsapp_number"];
            $user_id = $_SESSION["user_owner_id"];
            $apartment_image = $_FILES["apartment_image"]["name"];
            $exploded = explode('.', $apartment_image);
            $image_ext = end($exploded);
            $image_name = "apartment-image-".date("h-i-sa").rand(000, 999).".".$image_ext;
            $source_path = $_FILES["apartment_image"]["tmp_name"];
            $destination_path = "uploads/apartment-images/".$image_name;
            $uploaded = move_uploaded_file($source_path, $destination_path);

            if($uploaded == true){
                $sql = "INSERT INTO apartment(category, description, address, whatsapp_number, image_name, owner_id) VALUES('$category', '$description', '$address', '$whatsapp_number', '$image_name', $user_id)";
                $res = mysqli_query($conn, $sql);
                if($res == true){
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard.php");
                }
            }

        }
    }
    if(isset($_POST["details"])){
        if(isset($_POST["tenant_id"])){
            $tenant_id = $_POST["tenant_id"];
            $sql_tenant = "SELECT name, email, phone_number  FROM tenant WHERE id=$tenant_id";
            $res_tenant = mysqli_query($conn, $sql_tenant);
            if($res_tenant == true){
                $count_tenant = mysqli_num_rows($res_tenant);
                if($count > 0){
                    while($row_tenant = mysqli_fetch_assoc($res_tenant)){
                        $tenant_searched_name = $row_tenant["name"];
                        $tenant_searched_email = $row_tenant["email"];
                        $tenant_searched_phone = $row_tenant["phone_number"];

                        $_SESSION["tenant_searched_name"] = $tenant_searched_name;
                        $_SESSION["tenant_searched_email"] = $tenant_searched_email;
                        $_SESSION["tenant_searched_phone"] = $tenant_searched_phone;
                        header("location:". "http://localhost/PHP_PROJECTS/Rent_House/apartment_details.php");
                    }
                }
            }
            
        }
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
    if(isset($_POST["delete"])){
        if(isset($_POST["apartment_id"])){
            $apartment_id = $_POST["apartment_id"];
            $_SESSION["apartment_id_delete"] = $apartment_id;
            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/delete.php");
        }
    }
    if(isset($_POST["update"])){
        if(isset($_POST["apartment_id"])){
            $apartment_id = $_POST["apartment_id"];
            $_SESSION["apartment_id_update"] = $apartment_id;
            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/update.php");
        }
    }
    if(isset($_POST["release"])){
        if(isset($_POST["apartment_id_release"])){
            $apartment_id_release = $_POST["apartment_id_release"];
            $_SESSION["apartment_id_release"] = $apartment_id_release;
            header("location:". "http://localhost/PHP_PROJECTS/Rent_House/release.php");
        }
    }

    ob_end_flush();
?>