<?php
    ob_start();
    include("db_connect.php");
    session_start();
?>

<?php
    $apartment_id_del = $_SESSION["apartment_id_delete"];
    $sql_del = "DELETE FROM apartment WHERE id=$apartment_id_del";
    $res_del = mysqli_query($conn, $sql_del);
    if($res_del == true){
        unset($_SESSION["apartment_id_delete"]);
        header("location:". "http://localhost/PHP_PROJECTS/Rent_House/dashboard.php");
    }

    ob_end_flush();
?>