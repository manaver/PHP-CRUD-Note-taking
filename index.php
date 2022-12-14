<?php
$update = false;
$delete = false;
$insert = false;


//Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

//Creating Connection
$conn = mysqli_connect($servername, $username, $password, $database);





//Die if connection was not successful
if ((!$conn)) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- adding table css -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">


  <title>iNotes-Notes taking makes easy</title>
</head>

<body>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="staticBackdropLabel">Edit thisNote</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form method="post" action="./index.php">
            <div class="container mt-4">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="form-group mb-3">
                <label for="titleEdit" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit">
              </div>
              <div class="mb-3">
                <label for="descriptionEdit" class="form-label">Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>

            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Note</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
          </li>

        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>


  <!-- Alert if note added successfully -->
  <?php

  // updating the record in the database
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
      // Inserting updated data into the database
      $snoEdit = $_POST['snoEdit'];
      $titleEdit = $_POST["titleEdit"];
      $descriptionEdit = $_POST["descriptionEdit"];

      // sql query to be executed
      $sql = "UPDATE `inotes` SET `title` = '$titleEdit', `description` = '$descriptionEdit' WHERE `inotes`.`sno` = '$snoEdit';";

      $result = mysqli_query($conn, $sql);

      if ($result) {
        $update = true;
      } else {
        echo "We could not update the record";
      }
    } else {
      //Inserting data into the database
      $title = $_POST["title"];
      $desc = $_POST["description"];

      //sql query to be executed
      $sql = "INSERT INTO `inotes` (`title`, `description`) VALUES ('$title', '$desc')";
      $result = mysqli_query($conn, $sql);

      if (!$result) {
        $insert = true;
      } else {
        echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Success!</strong> Your note has been added successfully
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
      }
    }
  }

  //Deleting the record

  if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `inotes` WHERE `inotes`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);
    $delete = true;
  }

  // Success Messages
  if ($update) {
    echo
    "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your record has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
  }
  if ($insert) {
    echo
    "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your record has been inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
  }
  if ($delete) {
    echo
    "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your record has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
  }
  ?>


  <!-- Form For data collection -->
  <form method="post" action="./index.php">
    <div class="container mt-4">
      <h2 class="text-center">Add a Note</h2>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </div>
  </form>

  <!-- Displaying form data -->
  <div class="container my-5">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sno.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `inotes`";
        $result = mysqli_query($conn, $sql);
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $count++;
          echo "
          <tr>
          <th scope='row'>" . $count . "</th>
          <td>" . $row['title'] . "</td>
          <td>" . $row['description'] . "</td>
          <td>
          <a href='#' class='edit btn btn-primary text-white' id=" . $row['sno'] . ">Edit</a>
          <a href='#' class='delete btn btn-primary text-white' id=d" . $row['sno'] . ">Delete</a>
          </td>
        </tr>";
        }
        ?>
      </tbody>
    </table>


    <!-- Modal Edit and Delete button js -->
    <script>
      edits = document.getElementsByClassName("edit");
      Array.from(edits).forEach((element) => {
        element.addEventListener('click', (e) => {
          // console.log('edit',e.target.parentNode.parentNode);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          // console.log(title + "" + description);
          titleEdit.value = title;
          descriptionEdit.value = description;

          $('#editModal').modal('toggle');
          console.log(e.target.id);
          snoEdit.value = e.target.id;
        });
      })


      //Js for delete modal
      deletes = document.getElementsByClassName("delete");
      Array.from(deletes).forEach((element) => {
        element.addEventListener('click', (e) => {
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoDelete = e.target.id.substr(1, );

          if (confirm("Are You sure to delete!")) {
            console.log("Yes");
            $delete = true;
            window.location = `/crud/index.php?delete=${snoDelete}`;
          } else {
            console.log("No");
          }

        });
      })
    </script>
    <!-- Adding jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Adding table js -->
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <!-- Calling table function -->
    <script>
      $(document).ready(function() {
        $('#myTable').DataTable();
      });
    </script>
  </div>
  <hr>



  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>