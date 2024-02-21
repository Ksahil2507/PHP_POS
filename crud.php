
<?php  

//$sql = "INSERT INTO `customer` (`id`, `name`, `number`, `address`, `note`) VALUES ('$name', '$number', '$address', '$note')";
session_start();
include 'partials/_db.php';
$insert = false;
$update = false;
$delete = false;

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `customer` WHERE `id` = $id";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset( $_POST['idEdit'])){
  // Update the record
    $id = $_POST["idEdit"];
    $name = $_POST["nameEdit"];
    $number = $_POST["numberEdit"];
    $address = $_POST["addressEdit"];
    $note = $_POST["noteEdit"];

  // Sql query to be executed
  
  $sql = "UPDATE `customer` SET `name` = '$name' ,`number` = '$number', `address` = '$address', `note` = '$note' WHERE `customer`.`id` = $id";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
}
else{
    echo "We could not update the record successfully";
}
}
else{
    $name = $_POST["name"];
    $number = $_POST["number"];
    $address = $_POST["address"];
    $note = $_POST["note"];
    $sno = $_SESSION['sno'];
    echo $sno;

  // Sql query to be executed
  $sql = "INSERT INTO `customer` (`employee_id`, `name`, `number`, `address`, `note`) VALUES ('$sno','$name', '$number', '$address', '$note')";
  $result = mysqli_query($conn, $sql);

   
  if($result){ 
      $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
  } 
}
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <?php require 'partials/_nav.php' ?>


  <title>Employee - Data List </title>

</head>

<body>
  <!-- Edit Modal -->
  <div class="container my-3">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Welcome - <?php echo $_SESSION['username']?></h4>
      <p>Hey how are you doing?</p>
      <hr>
      <p class="mb-0">Whenever you need to, be sure to logout <a href="/pos/logout.php"> using this link.</a></p>
    </div>
  </div>
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/pos/crud.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="idEdit" id="idEdit">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="nameEdit" name="nameEdit" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="name">Number</label>
              <input type="text" class="form-control" id="numberEdit" name="numberEdit" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="name">Address</label>
              <textarea class="form-control" id="addressEdit" name="addressEdit" row="3"></textarea>
            </div>

            <div class="form-group">
              <label for="desc">Note</label>
              <textarea class="form-control" id="noteEdit" name="noteEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <div class="container my-4">
    <h2>Add New Customer</h2>
    <form action="/pos/crud.php" method="POST">
      <div class="form-group">
        <label for="name"> Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
      </div>
      
      <div class="form-group">
        <label for="name"> Number</label>
        <input type="number" class="form-control" id="number" name="number" aria-describedby="emailHelp">
      </div>

      <div class="form-group">
        <label for="name"> Address </label>
        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label for="desc">Note</label>
        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Employee</button>
    </form>
  </div>

  <div class="container my-4">


    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Name</th>
          <th scope="col">Number</th>
          <th scope="col">Address</th>
          <th scope="col">Note</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sno2 = $_SESSION['sno'];
          $sql = "SELECT * FROM `customer` where employee_id = $sno2";
          $result = mysqli_query($conn, $sql);
          $id = 0;
          while($row = mysqli_fetch_assoc($result)){
            $id = $id + 1;
            echo "<tr>
            <th scope='row'>". $id . "</th>
            <td>". $row['name'] . "</td>
            <td>". $row['number'] . "</td>
            <td>". $row['address'] . "</td>
            <td>". $row['note'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=".$row['id'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['id'].">Delete</button>  </td>
          </tr>";
        } 
          ?>


      </tbody>
    </table>
  </div>
  <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        name = tr.getElementsByTagName("td")[0].innerText;
        number = tr.getElementsByTagName("td")[1].innerText;
        address = tr.getElementsByTagName("td")[2].innerText;
        note = tr.getElementsByTagName("td")[3].innerText;
        console.log(name, note, number, address);
        nameEdit.value = name;
        numberEdit.value = number;
        addressEdit.value = address;
        noteEdit.value = note;
        idEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        id = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/pos/crud.php?delete=${id}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>
