<?php
    ob_start();
    include("db_connect.php");
    session_start();
?>

<?php
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="stylesheet" href="css/update.css">
    </head>
    <body>
        <div class="main-content">
            <div class="left">
            <form action="" method="POST" enctype="multipart/form-data" class="main-form">
                <input type="text" name="category" placeholder="Enter Category" required>
                <textarea cols="30" rows="10" placeholder="Write description[0-255 character]"  name="description" required></textarea>
                <input type="text" name="address" placeholder="Enter Address" required>
                <input type="tel" name="whatsapp_number" placeholder="whatsapp number [019xx-xxxxxx]" pattern="[0-9]{5}-[0-9]{6}" required>
                <input type="file" name="apartment_image" required>
                <input type="hidden" name="apartment_id" value="<?php echo $_SESSION["apartment_id_update"];?>">
                <input class="btn btn-outline-success mx-2" type="submit" name="submit-button" value="Update Apartment" required>
            </form>
            </div>
        </div>
    </body>
    </html>
    
<?php
    if(isset($_POST["submit-button"])){
        if(isset($_POST["category"]) && isset($_POST["description"]) && isset($_POST["address"]) && isset($_POST["whatsapp_number"]) && isset($_FILES["apartment_image"]) && isset($_POST["apartment_id"])){
            $apartment_id = $_POST["apartment_id"];
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
                $sql = "UPDATE apartment SET category='$category', description='$description', address='$address', whatsapp_number='$whatsapp_number', image_name='$image_name' WHERE id=$apartment_id";
                $res = mysqli_query($conn, $sql);
                if($res == true){
                    unset($_SESSION["apartment_id_update"]);
                    header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard.php");
                }
            }

        }
    }
    ob_end_flush();
?>