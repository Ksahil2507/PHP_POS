<?php

//$sql = "INSERT INTO `customer` (`id`, `name`, `number`, `address`, `note`) VALUES ('$name', '$number', '$address', '$note')";
session_start();
include 'partials/_db.php';
$insert = false;
$update = false;
$delete = false;



if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    echo $id;
    $delete = true;
    $sql = "DELETE FROM `invoice` WHERE `invoice_id` = $id";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idEdit'])) {
        // Update the record
        $id = $_POST["idEdit"];
        $iname = $_POST["editiname"];
        $ino = $_POST["editino"];
        $iaddress = $_POST["editiaddress"];
        $itemname = $_POST["edititemname"];
        $iquantity = $_POST["editiquantity"];
        $iprice = $_POST["editiprice"];
        $itotal = $_POST["edititotal"];
        $inote = $_POST["editinote"];
        $sno = $_SESSION['sno'];

        // Sql query to be executed

        $sql = "UPDATE `invoice` SET `iname` = '$iname' ,`iaddress` = '$iaddress', `itemname` = '$itemname', `iquantity` = '$iquantity', `iprice` = '$iprice', `inote` = '$inote', `ino` = '$ino', `eno` = '$sno' WHERE `invoice`.`invoice_id` = $id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            $error = mysqli_error($conn);
            echo $error;
        }
    } else {
        $iname = $_POST["iname"];
        $iaddress = $_POST["iaddress"];
        $ino = $_POST["ino"];
        $itemname = $_POST["itemname"];
        $iquantity = $_POST["iquantity"];
        $iprice = $_POST["iprice"];
        $itotal = $_POST["itotal"];
        $inote = $_POST["inote"];
        $sno = $_SESSION['sno'];
        echo $sno;



        // Sql query to be executed
        $sql = "INSERT INTO `invoice` (`iname`, `iaddress`, `ino`, `itemname`, `iquantity`, `iprice`, `inote`, `eno`) VALUES ('$iname', '$iaddress', '$ino', '$itemname', '$iquantity', '$iprice', '$inote','$sno')";
        $result = mysqli_query($conn, $sql);


        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <?php require 'partials/_nav.php' ?>


    <title>Employee - Data List </title>

</head>

<body>
    <!-- Edit Modal -->
    <div class="container my-3">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Welcome - <?php echo $_SESSION['username'] ?></h4>
            <p>Hey how are you doing?</p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to logout <a href="/pos/logout.php"> using this link.</a></p>
        </div>
    </div>
    <div class="modal fade " id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit this invoice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="/pos/invoice.php" method="POST">
                    <input type="hidden" name="idEdit" id="idEdit">
                    <div>To.</div> <br>
                    <div class="form-row">
                        <div class="col-3">
                            <input type="text" class="form-control" id="editiname" name="editiname" placeholder="to Name.">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" id="editiaddress" name="editiaddress" placeholder="to Address">
                        </div>
                    </div> <br>
                    <div class="form-row">
                        <div class="col-3">
                            <input type="text" class="form-control" id="editino" name="editino" placeholder="Item No.">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" id="edititemname" name="edititemname" placeholder="Item name">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="editiquantity" name="editiquantity" placeholder="Quantity">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="editiprice" name="editiprice" placeholder="Price">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="edititotal" name="edititotal" placeholder="Total">
                        </div>
                    </div> <br>
                    <div class="form-row">
                        <textarea type="text" class="form-control" id="editinote" name="editinote" placeholder="Discription"></textarea>
                    </div><br>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </div>
            </form>


        </div>
    </div>
    </div>

    <!-- invoice modal  -->

    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Invoice has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Invoice has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>
    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Invoice has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>
    <div class="container my-4">
        <!-- <a href="/pos/invoice.php">Create Invoice</a> -->



        <h2>Add New Invoice</h2>

        <form action="/pos/invoice.php" method="POST">
            <div>To</div> <br>
            <div class="form-row">
                <div class="col-3">
                    <input type="text" class="form-control" id="iname" name="iname" placeholder="to Name.">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="iaddress" name="iaddress" placeholder="to Address">
                </div>
            </div> <br>
            <div class="form-row">
                <div class="col-3">
                    <input type="text" class="form-control" id="ino" name="ino" placeholder="Item No.">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="itemname" name="itemname" placeholder="Item name">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="iquantity" name="iquantity" placeholder="Quantity">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="iprice" name="iprice" placeholder="Price">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="itotal" name="itotal" placeholder="Total">
                </div>
            </div> <br>
            <div class="form-row">
                <textarea type="text" class="form-control" id="inote" name="inote" placeholder="Discription"></textarea>
            </div><br>
            <div class="form-row">
                <button type="submit" class="btn btn-primary">Create </button>
            </div>
    </div>
    </form> <br><br>

    <div class="container my-4">


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">To Name</th>
                    <th scope="col">To Address</th>
                    <th scope="col">Item No.</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Note</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno2 = $_SESSION['sno'];
                $sql = "SELECT * FROM `invoice` where eno = $sno2";
                $result = mysqli_query($conn, $sql);
                $id = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $id + 1;
                    echo "<tr>
            <th scope='row'>" . $id . "</th>
            <td style='display:none;'>" . $row['invoice_id'] . "</td>
            <td>"  . $row['iname'] .  "</td>
            <td>" . $row['iaddress'] . "</td>
            <td>" . $row['ino'] . "</td>
            <td>" . $row['itemname'] . "</td>
            <td>" . $row['iquantity'] . "</td>
            <td>" . $row['iprice'] . "</td>
            <td>" . $row['inote'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=" . $row['invoice_id'] . ">Edit</button>
            <button class='delete btn btn-sm btn-primary' id=" . $row['invoice_id'] . ">Delete</button>
            <button class='invoice btn btn-sm btn-primary' id=" . $row['invoice_id'] . " >Download Invoice</button>


            </td>
            </tr>";
        }
        ?>
            </tbody>
        </table>
    </div>
    <hr>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        // $(document).ready(function() {
        //   $('#myTable').DataTable();

        // });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                invoice_id = tr.getElementsByTagName("td")[0].innerText;
                iname = tr.getElementsByTagName("td")[1].innerText;
                iaddress = tr.getElementsByTagName("td")[2].innerText;
                ino = tr.getElementsByTagName("td")[3].innerText;
                itemname = tr.getElementsByTagName("td")[4].innerText;
                iprice = tr.getElementsByTagName("td")[5].innerText;
                iquantity = tr.getElementsByTagName("td")[6].innerText;
                inote = tr.getElementsByTagName("td")[7].innerText;
                //console.log(name, note, number, address);
                idEdit.value = invoice_id;
                editiname.value = iname;
                edititemname.value = itemname;
                editiaddress.value = iaddress;
                editino.value = ino;
                editiprice.value = iprice;
                editiquantity.value = iquantity;
                editinote.value = inote;
                console.log(e.target.id)
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                id = e.target.id;
                console.log("delete ", id);

                if (confirm("Are you sure you want to delete this note!")) {
                    console.log("yes");
                    window.location = `/pos/invoice.php?delete=${id}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })

        invoice = document.getElementsByClassName('invoice');
        Array.from(invoice).forEach((element) => {
            element.addEventListener("click", (e) => {
                window.open('pdf.php')
                console.log("invoice ", invoice);
                tr = e.target.parentNode.parentNode;
                console.log("invoice ", tr);
                name = tr.getElementsByTagName("td")[0].innerText;
                number = tr.getElementsByTagName("td")[1].innerText;
                address = tr.getElementsByTagName("td")[2].innerText;
                note = tr.getElementsByTagName("td")[3].innerText;
                console.log("data", name, note, number, address);
                nameEdit.value = name;
                numberEdit.value = number;
                addressEdit.value = address;
                noteEdit.value = note;
                idEdit.value = e.target.id;
                console.log(e.target.id)
                $('#invoiceModal').modal('toggle');
            })
        })
    </script>
</body>

</html>