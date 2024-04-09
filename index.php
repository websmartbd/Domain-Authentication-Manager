<?php

session_start();

// Include the configuration file
include 'config.php';

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Redirect to login page if user is not authenticated
    header("Location: login.php");
    exit;
}

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT id, email, domain, active, message FROM allowed_domains";
$result = $conn->query($sql);

// Handle edit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $domain = $_POST['domain'];
    $active = $_POST['active']; // Get the selected value from the form
    $message = $_POST['message'];

    // Update user data in the database
    $update_sql = "UPDATE allowed_domains SET email='$email', domain='$domain', active=$active, message='$message' WHERE id=$id";
    if ($conn->query($update_sql) === TRUE) {
        // Redirect to user table page after successful update
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Delete user from the database
    $delete_sql = "DELETE FROM allowed_domains WHERE id=$delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        // Redirect to user table page after successful deletion
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Logout action
if (isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to login page after logout
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Domain Control Panel</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center">User Info</h2>
  <div class="d-flex justify-content-between mb-3">
    <!-- Add logout button -->
    <a href="?logout=true" class="btn btn-danger">Logout</a>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Domain</th>
          <th>Active</th>
          <th>Message</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["domain"] . "</td>";
                echo "<td>" . ($row["active"] ? "Yes" : "No") . "</td>"; // Display "Yes" or "No" based on the value of "active"
                echo "<td>" . $row["message"] . "</td>";
                echo "<td>
                        <div class='dropdown'>
                          <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Actions
                          </button>
                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#editModal{$row['id']}'>Edit</a>
                            <a class='dropdown-item' href='?delete=" . $row["id"] . "'>Delete</a>
                          </div>
                        </div>
                      </td>";
                echo "</tr>";

                // Edit Modal (similar to your original code)
                echo "<div class='modal fade' id='editModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='editModalLabel{$row['id']}' aria-hidden='true'>";
                echo "<div class='modal-dialog' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='editModalLabel{$row['id']}'>Edit Domain</h5>";
                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo "<span aria-hidden='true'>&times;</span>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                echo "<div class='form-group'>";
                echo "<label>Email:</label>";
                echo "<input type='text' name='email' value='" . $row["email"] . "' class='form-control'>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>Domain:</label>";
                echo "<input type='text' name='domain' value='" . $row["domain"] . "' class='form-control'>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>Active:</label>";
                echo "<select name='active' class='form-control'>";
                echo "<option value='1'" . ($row["active"] == 1 ? " selected" : "") . ">Yes</option>";
                echo "<option value='0'" . ($row["active"] == 0 ? " selected" : "") . ">No</option>";
                echo "</select>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>Message:</label>";
                echo "<input type='text' name='message' value='" . $row["message"] . "' class='form-control'>";
                echo "</div>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                echo "<button type='submit' name='edit' class='btn btn-primary'>Save changes</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<tr><td colspan='6'>No data available</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="text-center">
    <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add New</button>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add New Domain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="add.php"> <!-- Replace "add_data.php" with the file to handle adding data -->
          <div class="form-group">
            <label>Email:</label>
            <input type="text" name="email" class="form-control">
          </div>
          <div class="form-group">
            <label>Domain:</label>
            <input type="text" name="domain" class="form-control">
          </div>
          <div class="form-group">
            <label>Active:</label>
            <select name="active" class="form-control">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="form-group">
            <label>Message:</label>
            <input type="text" name="message" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add" class="btn btn-primary">Add Domain</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
