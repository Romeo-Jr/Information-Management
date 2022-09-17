<?php 

    include '../database/connections.php';
    include '../includes/cdn.php';

    session_start();
        // check if user is admin
        if($_SESSION["role"] != "1"){
          echo"<script> window.location.href = '../404'</script>";
      }

    $id = $_GET["edit"];

    $getData = mysqli_query($connections, "SELECT * FROM announcement WHERE id = '$id'");

    while($row = mysqli_fetch_assoc($getData)){
      $titleDB = $row["title"];
      $contentDB = $row["content"];
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $postcreated = date("l jS \of F Y h:i:s A");
      $updatedTitle = $_POST["updateTitle"];
      $updatedContent = $_POST["updateContent"];

      $updateDB = mysqli_query($connections, "UPDATE announcement SET title='$updatedTitle', content='$updatedContent', postcreated='$postcreated'");

      if($updateDB){
        header('location: announcement?update='.$id);
      }

    }

?>

<div class="container w-50">
  <div class="container form-div d-flex justify-content-center align-items-center">
          <div class="container">
              <form method="POST">
                  <h1 class="text-center">Update Post</h1>
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Title</label>
                      <input name ="updateTitle" type="text" class="form-control" value="<?php echo $titleDB ?>" id="title" aria-describedby="title">                      
                  </div>
                  
                  <div class="form-group">
                    <label for="textareacontent">Content</label>
                    <textarea name="updateContent" class="form-control" id="textareacontent" rows="3" placeholder="What's on your mind?"><?php echo $contentDB; ?></textarea>
                  </div>
                  <br>
                  <div class="d-grid gap-2">
                  <button id="btn" type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
              </form>
          </div>
      </div>
</div>
        