<?php

    session_start();
    include "includes/cdn.php";
    include "database/connections.php"; 
    
    $email = $password = "";
    $emailErr = $passwordErr = "";

    if(isset($_SESSION["id"])){

        $user_id = $_SESSION["id"];

        $query_get_data = mysqli_query($connections, "SELECT * FROM user WHERE id = '$user_id'");

        $get_account_type = mysqli_fetch_assoc($query_get_data);

        $account_type = $get_account_type["role"];

        if($account_type == "1"){
            echo "<script> window.location.href = 'admin/announcement'</script>";
        }else{
            echo "<script> window.location.href = 'student/announcement'</script>";
        }
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // for email
        if(empty($_POST["email"])){
            $emailErr = "Email is required!";
        }else{
            $email = $_POST["email"];
        }

        // for password
        if(empty($_POST["password"])){
            $passwordErr = "Password is required!";
        }else{
            $password = $_POST["password"];
        }

        if($email && $password){
            
            $checkEmail = mysqli_query($connections, "SELECT * FROM user WHERE email = '$email'");

            $checkEmailRow = mysqli_num_rows($checkEmail);

            if($checkEmailRow > 0){

                while($row = mysqli_fetch_assoc($checkEmail)){
                    $user_id = $row["id"];
                    $db_user_password = $row["password"];
                    $db_user_role = $row["role"];
                }

                if(md5($password) == $db_user_password){
                    session_start();

                    $_SESSION["role"] = $db_user_role;
                    $_SESSION["id"] = $user_id;

                    if($db_user_role == "1"){
                        echo "<script> window.location.href = 'admin/announcement'</script>";
                    }else{
                        echo "<script> window.location.href = 'student/announcement'</script>";
                    }
                }else{
                    echo '
                    <script type="text/javascript">

                    $(document).ready(function(){
                    
                        swal({
                            title: "Login Failed",
                            text: "Email and Password does not match!",
                            icon: "error",
                          })
                    });
                    
                    </script>';
                }
            }else{
                $emailErr = "Email is not registered";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    
    

    <style>
        .text-center{
            font-family: "Audiowide";
            padding: 5px;
        }

        .form-label{
            font-family: "Roboto";
        }

        .btn{
            font-family: "Roboto";
        }
    </style>
</head>
<body>
    <div class="container form-div d-flex justify-content-center align-items-center">
        <div class="container border border-primary p-5 rounded">
            <form method="POST">
                <h1 class="text-center">Login</h1>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input name = "email" type="email" class="form-control" value="<?php echo $email ?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
                    <small id="emailhelp" class="form-text text-danger"><?php echo $emailErr ?></small>
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
                    <small id="passwordhelp" class="form-text text-danger"><?php echo $passwordErr ?></small>
                </div>
                <br>
                <div class="d-grid gap-2">
                <button id="btn" type="submit" class="btn btn-primary">Login</button>
                <span class="text-center">or</span>
                <button id="btn" type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
</svg> Log in with Google</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

