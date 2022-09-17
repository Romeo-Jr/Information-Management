<?php
    include "../includes/cdn.php";
    include "../database/connections.php";

    session_start();

    // check if user is admin
    if($_SESSION["role"] != "1"){
        echo"<script> window.location.href = '../404'</script>";
    }

    // get value
    $fName = $mName = $lName = $suffix = $birthday = $age = $gender = $citizenship = $mothername = $fathername = $motheroccupation = $fatheroccupation = $profilepath = "";
    // get error value
    $fNameErr = $mNameErr = $lNameErr = $suffixErr = $birthdayErr = $ageErr = $genderErr = $citizenshipErr = $mothernameErr = $fathernameErr = $motheroccupationErr = $fatheroccupationErr = $profilepathErr = "" ;
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(empty($_POST["fname"])){
            $fNameErr = "First name is missing";
        }else{
            $fName = $_POST["fname"];
        }

        if(empty($_POST["mname"])){
            $mNameErr = "Middle name is missing";
        }else{
            $mName = $_POST["mname"];
        }

        if(empty($_POST["lname"])){
            $lNameErr = "Last name is missing";
        }else{
            $lName = $_POST["lname"];
        }

        if(empty($_POST["age"])){
            $ageErr = "Age is missing";
        }else{
            $age = $_POST["age"];
        }

        if(empty($_POST["gender"])){
            $genderErr = "Gender is missing";
        }else{
            $gender = $_POST["gender"];
        }

        if(empty($_POST["citizenship"])){
            $citizenshipErr = "Citizenship is missing";
        }else{
            $citizenship = $_POST["citizenship"];
        }

        if(!empty($_POST["sname"])){
            $suffix = $_POST["sname"];
        }
        if(empty($_POST["mtname"])){
            $mothernameErr = "Mother's name is missing";
        }else{
            $mothername = $_POST["mtname"];
        }

        if(empty($_POST["ftname"])){
            $fathernameErr = "Father's name is missing";
        }else{
            $fathername = $_POST["ftname"];
        }

        if(empty($_POST["bday"])){
            $birthdayErr = "Birthday is missing";
        }else{
            $birthday = date('Y-m-d', strtotime($_POST["bday"]));
        }

        if(empty($_POST["ftoccupation"])){
            $fatheroccupationErr = "Father's Occupation is missing";
        }else{
            $fatheroccupation = $_POST["ftoccupation"];
        }

        if(empty($_POST["mtoccupation"])){
            $motheroccupationErr = "Mother's Occupation is missing";
        }else{
            $motheroccupation = $_POST["mtoccupation"];
        }

        if(empty($_FILES["fileToUpload"]["name"])){
            $profilepathErr = "Empty file";
        }else{
            $target_dir = "upload/image";
            $target_file = rand(1000, 10000)."-".$_FILES["fileToUpload"]["name"];
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
            //   echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
            } else {
            //   echo "File is not an image.";
            $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                // echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                // echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            
            

        }
        
        if($fName && $mName && $lName && $birthday && $age && $gender && $citizenship && $mothername && $fathername && $motheroccupation && $fatheroccupation){
            
            $insertQuery = mysqli_query($connections, "INSERT INTO studentinfo (firstname, midllename, lastname, suffix, birthday, age, gender, citizenship, mothername, fathername, motheroccupation, fatheroccupation, profilephoto) VALUES('$fName', '$mName', '$lName', '$suffix', '$birthday', '$age', '$gender', '$citizenship', '$mothername', '$fathername', '$motheroccupation', '$fatheroccupation', '$target_file')");
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                // echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir."/".$target_file)) {
                // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } else {
                // echo "Sorry, there was an error uploading your file.";
                }
            }

            if($insertQuery){
                echo '<script type="text/javascript">
                swal("Student Added", "Student Info was successfully inserted", "success")
                .then((value) => {
                    window.location.href = "studentinfo";
                });
              </script>';
            }
            
        }else{

            echo '<script type="text/javascript">
                swal("Invalid Student Info", "Error in adding Student Info", "error")
                .then((value) => {
                    window.location.href = "studentinfo";
                });
              </script>';

        }
    
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Student</title>
</head>
<body>
    <div class="container p-3">
        <h1 class="text-center m-4">Student</h1>
        <div class="row p-2">
                <form method="post" enctype="multipart/form-data">
                    <div class="d-flex justify-content-lg-between flex-wrap ">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputfname">First Name</label>
                                <input name="fname" type="text" class="form-control" value="<?php echo $fName ?>" id="fname" aria-describedby="fnamelHelp">
                                <small id="fnamelHelp" class="form-text text-danger"><?php echo $fNameErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputfname">Middle Name</label>
                                <input name="mname" type="text" class="form-control" value="<?php echo $mName ?>" id="mName" aria-describedby="mNamelHelp">
                                <small id="mNamelHelp" class="form-text text-danger"><?php echo $mNameErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputfname">Last Name</label>
                                <input name="lname" type="text" class="form-control" value="<?php echo $lName ?>" id="lName" aria-describedby="lNamelHelp">
                                <small id="lNamelHelp" class="form-text text-danger"><?php echo $lNameErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputsuffix">Suffix Name</label>
                                <input name="sname" type="text" class="form-control" id="suffix" aria-describedby="suffixlHelp">
                                <small id="suffixlHelp" class="form-text text-danger"><?php echo $suffixErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputbday">Birthday</label>
                                <input name="bday" type="date" id="birthday" class="form-control" name="birthday">
                                <small id="bdaylHelp" class="form-text text-danger"><?php echo $birthdayErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputage">Age</label>
                                <input name="age" type="text" class="form-control" value = "<?php echo $age ?>" id="age" aria-describedby="agelHelp">
                                <small id="agelHelp" class="form-text text-danger"><?php echo $ageErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-control" id="gender">
                                    <option selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputcitizenship">Citizenship Name</label>
                                <input name="citizenship" type="text" class="form-control" value = "<?php echo $citizenship ?>" id="citizenship" aria-describedby="citizenshiplHelp">
                                <small id="citizenshiplHelp" class="form-text text-danger"><?php echo $citizenshipErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputmothername">Mother's Name</label>
                                <input name="mtname" type="text" class="form-control" value = "<?php echo $mothername ?>" id="mothername" aria-describedby="mothernamelHelp">
                                <small id="mothernamelHelp" class="form-text text-danger"><?php echo $mothernameErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputmotheroccupation">Mother's Occupation</label>
                                <input name="mtoccupation" type="text" class="form-control" value = "<?php echo $motheroccupation ?>" id="motheroccupation" aria-describedby="motheroccupationlHelp">
                                <small id="motheroccupationlHelp" class="form-text text-danger"><?php echo $motheroccupationErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputfathername">Father's Name</label>
                                <input name="ftname" type="text" class="form-control" value = "<?php echo $fathername ?>" id="fathername" aria-describedby="fathernamelHelp">
                                <small id="fathernamelHelp" class="form-text text-danger"><?php echo $fathernameErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputfatheroccupation">Father's Occupation</label>
                                <input name="ftoccupation" type="text" class="form-control" value = "<?php echo $fatheroccupation ?>" id="fatheroccupation" aria-describedby="fatheroccupationlHelp">
                                <small id="fatheroccupationlHelp" class="form-text text-danger"><?php echo $fatheroccupationErr ?></small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                                <input name="fileToUpload" type="file" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                            <small id="fatheroccupationlHelp" class="form-text text-danger"><?php echo $profilepathErr ?></small>
                        </div>
                        
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </form>
            </div>
        </div>
        
</body>
</html>