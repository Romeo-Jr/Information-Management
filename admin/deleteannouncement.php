<?php
    include '../database/connections.php';
    // check if user is admin
    if($_SESSION["role"] != "1"){
        echo"<script> window.location.href = '../404'</script>";
    }
    $id = $_GET["delete"];

    $deleteQuery = mysqli_query($connections, "DELETE FROM announcement WHERE id='$id'");

    header('location: announcement?m=1');

?>