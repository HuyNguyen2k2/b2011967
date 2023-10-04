<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);
$sql = "select id, fullname, email from customers where email = '".$_POST["email"]."' 
and password = '".md5($_POST["pass"])."'";

$result = $conn->query($sql);

session_start();

if ($result->num_rows > 0) {
 
  $row = $result->fetch_assoc();
  
  $_SESSION['user'] = $row['email'];
  $_SESSION['login_name'] = $row['fullname'];
  $_SESSION['password'] = $row['password'];
  $_SESSION['id'] = $row['id'];
  
  header('Location: homepage.php');
  
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  //Tro ve trang dang nhap sau 3 giay
  header('Refresh: 3;url=login.php');

}

$conn->close();
?>
