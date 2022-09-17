<?php
    include "../includes/cdn.php";
    include "../database/connections.php";

    session_start();

    // check if user is admin
    if($_SESSION["role"] != "1"){
        echo"<script> window.location.href = '../404'</script>";
    }

    $getStudentInfo = mysqli_query($connections, "SELECT * FROM studentinfo");


?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Admin | Student Info</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script>
      function deleteStorage(){
        localStorage.clear();
      }
      
    </script>

    <style>
        .tbl-container{
            max-width: fit-content;
            max-height: fit-content;
        }

        .tbl-fixed{
            overflow-x: scroll;
            overflow-y: scroll;
            max-height: fit-content;
            height: 70vh;
            width: 140vh;
        }
    </style>
  </head>
  <body>
     <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" onclick="deleteStorage()" href="../logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../sideNav/images/logo.jpg);"></a>
	        <ul class="list-unstyled components mb-5">
	          <li>
	              <a href="/practice/admin/announcement">Announcement</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Student</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="studentinfo">Information</a>
                </li>
                <li>
                    <a href="#">Grade</a>
                </li>
                <li>
                    <a href="#">Attendance</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="../logout" data-toggle="modal" data-target="#logoutModal" >Logout</a>
	          </li>
	        </ul>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
                </button>
                <h6>Student Information System</h6>
          </div>
        </nav>  

        <!-- banner -->
        <div class="jumbotron jumbotron-fluid bg-primary">
            <div class="container">
                <h1 class="h1 text-center">Student Information</h1>
                <p class="lead"></p>
            </div>
        </div>

        <div class="container p-3 m-2">
            <a href="addstudent"><button type="button" class="btn btn-primary">+ Add Student</button></a>
        </div>

        <div class="container tbl-container">
            <div class="row tbl-fixed">
            <table class="table table-sm table-striped table-condensed">
            <thead class="table-dark">
                <tr>
                <th scope="col">Profile</th>
                <th scope="col">ID</th>
                <th scope="col">Firstname</th>
                <th scope="col">Middlename</th>
                <th scope="col">Lastname</th>
                <th scope="col">Suffix</th>
                <th scope="col">Birthday</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
                <th scope="col">Citizenship</th>
                <th scope="col">Mother's Name</th>
                <th scope="col">Mother's Occupation</th>
                <th scope="col">Father's Name</th>
                <th scope="col">Father's Occupation</th>
                <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($row = mysqli_fetch_assoc($getStudentInfo)){
                        $col1 = $row["profilephoto"];
                        $col2 = $row["id"];
                        $col3 = $row["firstname"];
                        $col4 = $row["midllename"];
                        $col5 = $row["lastname"];
                        $col6 = $row["suffix"];
                        $col7 = $row["birthday"];
                        $col8 = $row["age"];
                        $col9 = $row["gender"];
                        $col10 = $row["citizenship"];
                        $col11 = $row["mothername"];
                        $col12 = $row["motheroccupation"];
                        $col13 = $row["fathername"];
                        $col14 = $row["fatheroccupation"];
                    
                ?>
                <tr>
                    <th scope="row"><img class="img-thumbnail" src="upload/image/<?php echo $col1 ?>" alt="profile"></th>
                    <td><?php echo $col2 ?></td>
                    <td><?php echo $col3 ?></td>
                    <td><?php echo $col4 ?></td>
                    <td><?php echo $col5 ?></td>
                    <td><?php echo $col6 ?></td>
                    <td><?php echo $col7 ?></td>
                    <td><?php echo $col8 ?></td>
                    <td><?php echo $col9 ?></td>
                    <td><?php echo $col10 ?></td>
                    <td><?php echo $col11 ?></td>
                    <td><?php echo $col12 ?></td>
                    <td><?php echo $col13 ?></td>
                    <td><?php echo $col14 ?></td>
                    <td><a href="#" ><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg></a> | <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="green" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg></a></td>
                </tr>
                
                <?php
                    }
                ?>
            </tbody>
            </table>
            </div>
        </div>
	</div>

    <script src="../sideNav/js/jquery.min.js"></script>
    <script src="../sideNav/js/popper.js"></script>
    <script src="../sideNav/js/bootstrap.min.js"></script>
    <script src="../sideNav/js/main.js"></script>


  </body>
</html>

<?php

?>

