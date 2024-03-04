<?php
session_start();
include 'partials/_db.php';

// Include autoloader 
require_once 'vendor/autoload.php';     


// Reference the Dompdf namespace 
use Dompdf\Dompdf;


// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

// print($rows);

$sno2 = $_SESSION['sno'];
$sql = "SELECT * FROM `users` where eno = $sno2";
$result = mysqli_query($conn, $sql);
$id = 0;

$html = '
<h2>Hello</h2>
<table>
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
</table>

';
while ($row = mysqli_fetch_assoc($result)) {
    $id = $id + 1;
    $html =  "<tr>
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

// Load HTML content 
$dompdf->loadHtml($html);


// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF 
$dompdf->render();

// Output the generated PDF to Browser 
$dompdf->stream();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Hello</h2>
    <h2>Welcome - <?php $_SESSION['username']?></h2>

</body>
<script>
      invoice = document.getElementsByClassName('invoice');
        Array.from(invoice).forEach((element) => {
            element.addEventListener("click", (e) => {
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
            })
        })
</script>
</html>
