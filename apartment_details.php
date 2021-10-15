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
    <title>Apartment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/apartment_details.css">
</head>
<body>
            <?php include("partials/nav.php"); ?>
            <?php include("partials/nav_end.php"); ?>
            <?php
                if(isset($_SESSION["category_apartment"], $_SESSION["description_apartment"], $_SESSION["address_apartment"], $_SESSION["whatsapp_apartment"], $_SESSION["image_apartment"])){
                    ?>
                        <div class="container my-4">
                            <div class="row">
                                <div class="col" style="flex: 0 0 0%;">
                                    <div class="card d-flex flex-row" style="width: 30rem;">
                                        <img src="<?php echo "uploads/apartment-images/".$_SESSION["image_apartment"] ;?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $_SESSION["category_apartment"];?></h5>
                                            <p class="card-text"><?php echo $_SESSION["description_apartment"];?></p>
                                            <p class="card-text flex-fill"><?php echo "WhatsApp Number: ".$_SESSION["whatsapp_apartment"];?></p>
                                            <p class="card-text flex-fill"><?php echo "Address: ".$_SESSION["address_apartment"];?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
                if(isset($_SESSION["tenant_searched_name"]) && isset($_SESSION["tenant_searched_email"]) && isset($_SESSION["tenant_searched_phone"])){
                    ?>
                    <div class="container d-flex justify-content-center ">
                        <div class="card bg-secondary text-light" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $_SESSION["tenant_searched_name"];?></h5>
                                <h6 class="card-subtitle mb-2"><?php echo "Email: ".$_SESSION["tenant_searched_email"];?></h6>
                                <p class="card-text"><?php echo "Phone_number: ".$_SESSION["tenant_searched_phone"];?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
          
</body>

</html>
