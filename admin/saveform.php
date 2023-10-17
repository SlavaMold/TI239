<?php 

require_once '../functions/connect.php'; 

if($_POST['acc'] == "resp"){

$date = $_POST['date'];
$text = $_POST['Message'];
$author = $_COOKIE['login'];

if($_POST['ord'] == "ordered"){
    $noted = '0';
}
else{
    $noted = '1';
}

$filetosave = '';

$time = date("H:i:s");

if(!empty($_FILES['files']['tmp_name'])){
    for($g = 0; $g < count($_FILES['files']['tmp_name']); $g++){
         $filetosave.= $_FILES['files']['name'][$g];
        $filetosave.= '|';
    }
}


$connect->query("INSERT INTO `commits`(`id`, `date`, `time`, `noted`, `text`, `attached`, `author`) VALUES (NULL,'$date','$time', $noted ,'$text', '$filetosave', '$author')");


$last_id = $connect->insert_id;

$upload_path = __DIR__ . '/uploaded/' . "$last_id";   
    if(!file_exists($upload_path)){
         mkdir($upload_path, 0777, true);
    }
$upload_path.= '/'; 

if(!empty($_FILES['files']['tmp_name'])){
    for($key = 0; $key < count($_FILES['files']['tmp_name']); $key++){
        $user_filename = $_FILES['files']['name'][$key];
        $user_basename = pathinfo($user_filename, PATHINFO_FILENAME);
        $user_extension = pathinfo($user_filename, PATHINFO_EXTENSION);

        $server_filename = $user_basename . "." . $user_extension;
        $server_filepath =  $upload_path . $server_filename;
        
        $i = 0;
        while (file_exists($server_filepath)) {
            $i++;
            $server_filepath = $upload_path . $user_basename . "($i)" . "." . $user_extension;
        }
        if(copy($_FILES['files']['tmp_name'][$key], $server_filepath)){
            $response['status'] = 'ok';
        }
 
    }
}
else{
    $response['status'] = 'ok';
}

echo json_encode($response);
}
else{
    die('<a href="../index.php"> return back </a>');
}
?>
