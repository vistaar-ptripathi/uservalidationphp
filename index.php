<?php
$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "employee";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("connection failed" . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql_select = "SELECT * FROM `registration` WHERE `sno`=$sno";
  $result_select = mysqli_query($conn, $sql_select);
  $row_select = mysqli_fetch_assoc($result_select);

  $name = $row_select['name'];
  $address = $row_select['address'];
  $email = $row_select['email'];
  $pass = $row_select['password'];
  $mobile = $row_select['mobile'];

  $sql_insert_archive = "INSERT INTO `archivedata` ( `name`, `address`, `email`, `password`, `mobile`) VALUES ('$name', '$address', '$email', '$pass', '$mobile')";
  $result_insert_archive = mysqli_query($conn, $sql_insert_archive);

  // Delete the selected data from the original table
  $sql_delete = "DELETE FROM `registration` WHERE `sno`=$sno";
  $result_delete = mysqli_query($conn, $sql_delete);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['snoEdit'])) {

    $sno = $_POST['snoEdit'];
    $name = $_POST['NameEdit'];
    $address = $_POST['addressEdit'];
    $email = $_POST['emailEdit'];
    $pass = $_POST['passEdit'];
    $mobile = $_POST['mobileEdit'];
    $sql = "UPDATE `registration` SET `name` = '$name', `address` = ' $address', `email` = '$email', `password` = '$pass', `mobile` = '$mobile' WHERE `registration`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    } else {
      echo '<div class="alert alert-danger" role="alert">
          <div class="alert-heading"><strong>we are facing some technical issue and your data not inserted successfully</strong>
           </div>';
    }
  } else {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $mobile = $_POST['mobile'];
    $sql = "INSERT INTO `registration` ( `name`, `address`, `email`, `password`, `mobile`) VALUES ('$name', '$address', '$email', '$pass', '$mobile')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
    } else {
      echo '<div class="alert alert-danger" role="alert">
          <div class="alert-heading"><strong>we are facing some technical issue and your data not inserted successfully</strong>
           </div>';
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crud Php</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</head>

<body>


  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit data</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="registrationForm1" action="/uservalidationphp/index.php" method="post">
            <input type="hidden" name="snoEdit" id="snoEdit">

            <div class="form-group">
              <label for="fullName">Full Name</label>
              <input type="text" name="NameEdit" id="NameEdit" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea id="addressEdit" name="addressEdit" required></textarea>
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="emailEdit" name="emailEdit" required>
            </div>
            <div class="form-group">
              <label for="password">password</label>
              <input type="text" id="passEdit" name="passEdit" required>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="number" id="mobileEdit" name="mobileEdit" required>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Update Details</button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>



  <?php
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your data has been delete successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your data has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your data has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <div class="container" class="m-300">
    <h1>Employee Registration</h1>
    <form id="registrationForm" action="/uservalidationphp/index.php" method="post">
      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" name="name" id="fullName" required>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" required></textarea>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">password</label>
        <input type="password" id="pass" name="pass" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="number" id="phone" name="mobile" required>
      </div>

      <div class="form-group">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>
  <div class="container" my-4>


    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Address</th>
          <th scope="col">Email</th>
          <th scope="col">password</th>
          <th scope="col">mobile</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `registration`";
        $result = mysqli_query($conn, $sql);
        $num = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
          <th scope='row'>" . $num . "</th>
          <td>" . $row['name'] . "</td>
          <td>" . $row['address'] . "</td>
          <td>" . $row['email'] . "</td>
          <td>" . $row['password'] . "</td>
          <td>" . $row['mobile'] . "</td>
          <td> <button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button>
          </td>
        </tr>";
          $num++;
        }

        ?>


        </tr>
      </tbody>
    </table>
    </div script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous">

    
    <div class="container" my-4>
    <h1> Archive data</h1>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Address</th>
          <th scope="col">Email</th>
          <th scope="col">Password</th>
          <th scope="col">Mobile</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `archivedata`";
        $result = mysqli_query($conn, $sql);
        $num = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
        <td>" . $num . "</td>
        <td>" . $row['name'] . "</td>
        <td>" . $row['address'] . "</td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['password'] . "</td>
        <td>" . $row['mobile'] . "</td>
      </tr>";
          $num++;
        }
        ?>
      </tbody>
    </table>


  </div script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous">
  </script>


  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener('click', (e) => {
        tr = e.target.parentNode.parentNode;
        name = tr.getElementsByTagName('td')[0].innerText;
        address = tr.getElementsByTagName('td')[1].innerText;
        email = tr.getElementsByTagName('td')[2].innerText;
        pass = tr.getElementsByTagName('td')[3].innerText;
        mobile = tr.getElementsByTagName('td')[4].innerText;

        NameEdit.value = name;
        addressEdit.value = address;
        emailEdit.value = email;
        passEdit.value = pass;
        mobileEdit.value = mobile;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');

      })
    });


    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener('click', (e) => {
        sno = e.target.id.substr(1, );


        if (confirm("Are you want to Delete this Details")) {
          console.log("yes");
          window.location = `/uservalidationphp/index.php?delete=${sno}`;
        } else {
          console.log("no");
        }
      })
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      let table = new DataTable('#myTable');
    });
  </script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</body>

</html>