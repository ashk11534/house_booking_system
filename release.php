<?php
    ob_start();
    include("db_connect.php");
    session_start();
?>

<?php
    $apartment_id_release = $_SESSION["apartment_id_release"];
    $sql_rel = "UPDATE apartment SET tenant_id=NULL WHERE id=$apartment_id_release";
    $res_rel = mysqli_query($conn, $sql_rel);
    if($res_rel == true){
        unset($_SESSION["apartment_id_release"]);
        header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard.php");
    }

    ob_end_flush();
?>