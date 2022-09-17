<?php
    include "includes/cdn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found!</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">

    <script>
        function goBack(){
            window.history.back()

        }
    </script>

    <style>
        .h1{
            font-family: "Oswald";
        }
        .btn{
            font-family: "Oswald";
        }
    </style>
</head>
<body>
    <div class="container form-div d-flex justify-content-center align-items-center">
        <div class="container text-center">
            <img src="image/404.png" alt="404">
            <h1 class="h1">Page not found</h1>
            <button class="btn btn-warning w-50" onclick="goBack()">Back</button>
        </div>
    </div>
</body>
</html>