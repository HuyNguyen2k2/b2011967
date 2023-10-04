<?php
$conn = new mysqli("localhost",  "root", '', "qlbanhang");
    if(isset($_POST['submit'])){
        $file_name = $_FILES['upload']['name'];
        $array_file = explode('.', $_FILES['upload']['name']);
        $file_type = strtolower(end($array_file));
        $file_destination = "csv/".$file_name;
        $file_tmp_name = $_FILES['upload']['tmp_name'];
        if($file_type === 'csv'){
            move_uploaded_file($file_tmp_name,$file_destination);
            $file = file($file_destination);
            foreach ($file as $key => $value)
                {
                    if($key < sizeof($file) - 1)
                    $csv[$key] = str_getcsv($value);
                }
            foreach ($file as $key => $value)
                {
                    if($key < sizeof($file) - 1){   
                        // echo $file[$key];
                        $file_array = explode(',', $file[$key]);
                        // echo $file_array[0];
                        // echo '<br>';
                            $date = date_create($file_array[2]);
                            $sql = "INSERT INTO customers (fullname, email, birthday, password, img_profile) 
	                        VALUES ('".$file_array[0] ."', '".$file_array[1] ."', '".$date ->format('Y-m-d') ."','".md5($file_array[3])."','".$file_array[4]."' )";
                            $conn->query($sql);   
                    }
                }
                
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload file csv</title>
</head>
<body>
   <form method = 'POST' action = './upload-csv.php'  enctype="multipart/form-data">
    <input type = 'file' name = 'upload'/>
    <input type = 'submit' name = 'submit'/>
   </form> 
</body>
</html>