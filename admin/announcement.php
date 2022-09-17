<?php
    include "../includes/cdn.php";
    include "../database/connections.php";

    session_start();

    // check if user is admin
    if($_SESSION["role"] != "1"){
        echo"<script> window.location.href = '../404'</script>";
    }

    // create announcement
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      // for error
      $titleErr = $contentErr = '';
      // value
      $title = $content = '';
      // date
      $dateCreated = date("l jS \of F Y h:i:s A");

      // for title
      if(empty($_POST['title'])){
        $titleErr = "Unknown title";
      }else{
        $title = $_POST['title'];
      }
      
      // for content
      if(empty($_POST['content'])){
       $contentErr = 'Unknown Content';
      }else{
        $content = $_POST['content'];
      }

      if($content && $title){
         //  insertion query
        $insertQuery = "INSERT INTO announcement(title, postcreated, content) VALUES ('$title', '$dateCreated' ,'$content')";
        
        if (mysqli_query($connections, $insertQuery)) {
          echo '
              <script type="text/javascript">
  
              $(document).ready(function(){
                      
                swal({
                  title: "Post created",
                  text: "Post was successfully inserted",
                  icon: "success",
                  })
              });
                      
              </script>';
        } 
      
      }else {
        echo '
            <script type="text/javascript">

            $(document).ready(function(){
                    
              swal({
                title: "Title and Content unknown",
                text: "Error in making post",
                icon: "error",
                })
            });
                    
            </script>';
      }
      
      
      
    }


    // display post
    $getDataQuery = mysqli_query($connections, "SELECT * FROM announcement");

    // delete row

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Admin | Announcement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script>
      function deleteStorage(){
        localStorage.clear();
      }
      
    </script>
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
        <div class="container">
          <div class="container border border-warning p-3 rounded">
          <form method="POST">
            <h3>Create Announcement</h3>
            
            <span class="text-danger"><?php $titleErr ?></span>

            <div class="form-group">
              <label for="title">Title</label>
              <input name="title" type="text" class="form-control" id="title" placeholder="Title" value="<?php $title; ?>">
            </div>

            <span class="text-primary"><?php $contentErr ?></span>

            <div class="form-group">
              <label for="textareacontent">Content</label>
              <textarea name="content" class="form-control" id="textareacontent" rows="3" placeholder="What's on your mind?"><?php $content; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Post</button>
          </form>
          </div>
          <hr>

          <!-- post -->
          <div class="container">
          <?php
            while($row = mysqli_fetch_array($getDataQuery)){
                $titledb = $row["title"];
                $contentdb = $row["content"];
                $postcreated = $row["postcreated"]; 
              ?>
            
              <div class="card bg-light mb-3">
                <div class="card-header bg-primary text-white">
                  <h4 class="text text-white"><?php echo $titledb; ?></h4>
                  <div class="text text-white"><?php echo $postcreated; ?></div>
                </div>
                
                <div class="card-body">
                  <p class="card-text text-dark"><?php echo $contentdb; ?></p>
                </div>
                <div class="card-footer text-dark">
                    <a href="updateannouncement?edit=<?php echo $row["id"]?>" class="btn btn-primary">Edit</a>
                    <a href="deleteannouncement?delete=<?php echo $row["id"]?>" class="btn btn-danger btn-del">Delete</a>

                </div>
              </div>
              <?php
                }    
              ?>
            </div>
          </div>

          <!-- flash -->
          <?php if(isset($_GET["m"])){
            echo '<script>
            swal("Post Deleted", "Post has been deleted", "success")
            .then((value) => {
              window.location.href = "announcement";
            });
            </script>';
          } ?>

          <?php 
            if(isset($_GET["update"])){
              echo '<script>
              swal("Post Updated", "Post has been Updated", "success")
              .then((value) => {
                window.location.href = "announcement";
              });
              </script>';
            }
          ?>
		</div>
    <script src="../sideNav/js/jquery.min.js"></script>
    <script src="../sideNav/js/popper.js"></script>
    <script src="../sideNav/js/bootstrap.min.js"></script>
    <script src="../sideNav/js/main.js"></script>
    <script type="text/javascript">
      var alerted = localStorage.getItem('alerted') || '';
      if (alerted != 'yes') {
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          title: 'Signed in successfully'
        })
        localStorage.setItem('alerted','yes');
      }
    </script>

    <!-- sweet alert delete modal -->
    <script type="text/javascript">
      $('.btn-del').on('click', function(e){
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
              document.location.href = href;
          }
    })
      })
    </script>
  </body>
</html>

<?php

?>

