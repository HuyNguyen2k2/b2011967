<!DOCTYPE HTML>
<html>  
<body>

<style>
    input {
        margin-top: 10px;
    }
</style>


<?php

$conn = new mysqli("localhost",  "root", '', "qlbanhang");
if (isset($_POST['submit'])) {
    $old_pw = md5($_POST['old_pw']);
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM customers where id = $id");
    $row = $result->fetch_assoc();
    if ($old_pw == $row['password']) {
        $right = true;
        if ($_POST['new_pw'] == $_POST['retype_new_pw']) {
            $right = true;
            $new_pw = md5($_POST['new_pw']);
            $newId = $_GET['id'];
            if ($conn->query("UPDATE customers SET password = '$new_pw' WHERE id = '$newId' "))  $right = true;
        } else $error2 = true;
    } else $error1 = true;
}

?>

<form class="form-group" action="./form_sua_mk.php?<?php echo 'id='.$_GET['id'] ?>" method="POST">
<h1>Sửa mật khẩu</h1>
Nhập mật khẩu cũ: 
<input type="password" name="old_pw" class="form-control
    <?php echo $error1 ? 'is-invalid' : '' ?>
    <?php echo $right ? 'is-valid' : '' ?>
    "><br>
Nhập mật khẩu mới: 
<input type="password" name="new_pw" class="form-control
    <?php echo $error1 ? 'is-invalid' : '' ?>
    <?php echo $right ? 'is-valid' : '' ?>
    "><br>
Nhập lại mật khẩu mới: 
<input type="password" name="retype_new_pw" class="form-control
    <?php echo $error1 ? 'is-invalid' : '' ?>
    <?php echo $right ? 'is-valid' : '' ?>
    "><br>

<input type="submit" name="submit">
</form>

</body>
</html>
