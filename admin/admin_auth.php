<?php 

error_reporting(0);
session_start();

require_once '../functions/connect.php'; 
require_once 'delete.php';
$login = $_POST['login'];
$password = $_POST['password'];

$_SESSION['login'] = $_POST['login'];
$_SESSION['password'] = $_POST['password'];

$adminLogin = '';

$check_admin = mysqli_query($connect, "SELECT * FROM `admins` WHERE `login` = '$login' AND `password` = '$password'" );
$adminData  = mysqli_fetch_all($check_admin , MYSQLI_ASSOC);


$toHtml= '';
$form= '<div class="forma">
                    <form name="haisenberg" action="?" method="POST" class="form-body" id="form"
                        enctype="multipart/form-data">
                        <legend>
                            <h2 class="form-title">
                                Новая запись
                            </h2>
                        </legend>

                        <div class="form-item">
                            <label class="form-label" for="formName">Дата</label>
                            <input type="date" value="" class="form-input req" id="formName" name="date" placeholder="">
                        </div>

                        <div class="form-item">
                            <label class="form-label" for="formMessage">Текст записи</label>
                            <textarea name="Message" id="formMessage" class="form-input req"> </textarea>
                        </div>

                        <div class="form-item">
                            <div class="form-label"> Отметить запись? </div>
                            <div class="options">
                                <div class="options-item">
                                    <input id="formOrdered" type="radio" checked value="ordered" name="ord"
                                        class="options-input">
                                    <label class="options-label" for="formOrdered"><span>Не отмечать</span></label>
                                </div>

                                <div class="options-item">
                                    <input id="formNoOrdered" type="radio" value="noordered" name="ord"
                                        class="options-input">
                                    <label class="options-label" for="formNoOrdered"><span>Отметить</span></label>
                                </div>

                            </div>
                        </div>

                        <div class="form-item">
                            <div class="form-label"> Прикрепить файлы </div>
                            <div class="file">
                                <div class="file-item">

                                    <input id="formImage" accept=".jpeg, .jpg, .png, .svg, .bmp, .docx, .doc, .ppt, .pdf" name="image" type="file"
                                        class="file-input" multiple>

                                    <div class="choose-button"> Выбрать </div>
                                </div>
                                <div class="file-preview" id="imagePreview"> </div>
                                <a href="#" class="delete-img">x</a>
                            </div>
                        </div>
                        
                        <button class="form-button" type="submit"> Отправить </button>
                    </form>
                    <script> formHandler(); </script>
                </div>';

if(mysqli_num_rows($check_admin) > 0 || $_COOKIE['token'] == true) {?>

	<?php
	foreach ($adminData as $datarow) {
		$adminLogin = $datarow['login'];
		mysqli_query($connect, "UPDATE `admins` SET `online` = 'true' WHERE `login` = '$adminLogin'");
		setcookie('login', $adminLogin, 0, '/');
		setcookie('token', true, 0, '/');
		setcookie('whoLeave', '', 0, '/');
		// var_dump($onlineAdmins);
		}

	$check_online = mysqli_query($connect, "SELECT * FROM `admins` WHERE `online` = 'true'");
		$check_online = mysqli_fetch_all($check_online , MYSQLI_ASSOC);

		$onlineAdmins = array();
		$i = 0;

		foreach ($check_online as $key) {
				$onlineAdmins[$i] = $key['login'];
				$i++;
		}
	?>

     <head>
		<meta charset="UTF-8">
		<title>Admin panel</title>
		<link rel="stylesheet" href="../css/admin-style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
	</head>
	<body>
		<script type="text/javascript" src="../js/form.js"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<header>
		<div class="container">
			<h2>Добро пожаловать в управление TI-239!</h2>
		<div class="header"> <span> Функции </span> 

			<div class="functions">	<form method="POST" action="" class="del-all">
			<input class="create-new function" type="submit" value='Создать новую запись' name="newNote"> 
			</form>
			
			<form method="POST" action="" class="del-all">
			<input class="del-data-base function" type="submit" value='Удалить все записи' name="del-all"> 
			</form>

			<form method="POST" action="" class="del-all">
			<input class="logout function" type="submit" value="Разлогиниться" name="logout"> 
			</form>

			<form method="POST" action="" class="del-all">
			<input class="leave function" type="submit" value='На Главную' name="leave"> 
			</form>

			</div>
		</div>
	</header>

			<?php 
			if (isset($_POST['login']) & !isset($_COOKIE['login'])){
			foreach ($adminData as $datarow) {  ?>
			<div class="content">
				<div class="container">

					<div class="admins"> 
						<div class="dif"> Управление </div>
						<div class="isAdmin">
							<img class="avatar" src="../imgs/SImg.jpg">
							<?php for($i = 0; $i < count($onlineAdmins); $i++){
								if($onlineAdmins[$i] == 'Slava_Todorov') echo '<img class="online" src="../imgs/online.png">';
							} ?>
							<span> Slava Todorov </span>
							<span> <?php if($datarow['login'] == 'Slava_Todorov') echo '(Вы)'; ?> </span>

						</div>

						<div class="isAdmin">
							<img class="avatar" src="../imgs/PImg.jpg">
							<?php for($i = 0; $i < count($onlineAdmins); $i++){
								if($onlineAdmins[$i] == 'Tihanina_Polina') echo '<img class="online" src="../imgs/online.png">';
							} ?>
						     <span> Tihanina Polina </span> 
							<span> <?php if($datarow['login'] == 'Tihanina_Polina') echo '(Вы)'; ?> </span>
						</div>
					</div>

				<?php 
						};
						
					}
					if(isset($_POST['newNote'])){
						echo $form;
					}

					if (isset($_COOKIE['token'])){
						?>
						<div class="content">
						<div class="container">

						<div class="admins"> 
						<div class="dif"> Управление </div>
						<div class="isAdmin">
							<img class="avatar" src="../imgs/SImg.jpg">
							<?php for($i = 0; $i < count($onlineAdmins); $i++){
								if($onlineAdmins[$i] == 'Slava_Todorov'){echo '<img class="online" src="../imgs/online.png">';}
							} ?>
							<span> Slava Todorov </span>
							<span> <?php if($_COOKIE['login'] == 'Slava_Todorov') echo '(Вы)'; ?> </span>
						</div>

						<div class="isAdmin">
							<img class="avatar" src="../imgs/PImg.jpg">  
							<?php for($i = 0; $i < count($onlineAdmins); $i++){
								if($onlineAdmins[$i] == 'Tihanina_Polina'){echo '<img class="online" src="../imgs/online.png">';}
							} ?>
							<span> Tihanina Polina</span>
							<span> <?php if($_COOKIE['login'] == 'Tihanina_Polina') echo '(Вы)'; ?> </span>
						</div>
					</div>
					<?php } ?>

					<div class="forNotifications"> </div>

		 		</div>
			</div>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	 </body></html>
<?php 
	
} 
else{
	$_SESSION['message'] = 'Логин или пароль введены не корректно';
	header('Location: ../login.php');
}	

	if(isset($_POST['del-all'])){
		echo '<div class="confirm"> <span> Подтвердите удаление всех записей.. </span> <div class="choose"> <form method="POST" action="" class="del-all altstyle red">
			<input class="del-data-base function" type="submit" value="Подтвердить" name="confirm-del-all"> 
			</form>
			<form method="POST" action="" class="del-all altstyle green">
			<input class="del-data-base function" type="submit" value="Отмена" name="cancel-del-all"> 
			</form>
			</div> </div>';
		}

	if(isset($_POST['confirm-del-all'])){
		mysqli_query($connect, "TRUNCATE TABLE `commits`");

		$globaldir = 'uploaded/*';
		$dirrectories = glob("$globaldir");
		foreach($dirrectories as $dirrectory){ 
  			$files = glob("$dirrectory" . '/*'); 
			foreach($files as $file){ 
  				if(is_file($file)) {
   					unlink($file); 
  				}
			}
			rmdir($dirrectory);
		}
		unset($_POST['cancel-del-all']);
	}



	if(isset($_POST['leave'])){
		setcookie('login', $_COOKIE['login'], 0, '/');
		header('Location: ../index.php');
	}

	if(isset($_POST['logout'])){ 
		setcookie('whoLeave', $_COOKIE['login'], 0, '/');
		setcookie('login', '', 0, '/');
		setcookie('token', false, 0, '/');
		header('Location: ../index.php');
	}

	// if(isset($_POST['butt'])){
	// 	$toMysql = $_POST['butt'];
	// 	mysqli_query($connect, "DELETE FROM `message` WHERE `id` = '$toMysql'");
	// 	print_r($_POST);
	// 	$dirtodel = '../pages/ssp/saved/' . "$toMysql";
	// 	$files = glob("$dirtodel" . '/*'); 
	// 		foreach($files as $file){ 
  	// 		if(is_file($file)) {
   	// 		 unlink($file); 
  	// 			}
	// 		}
	// 	if(!rmdir($dirtodel)){

	// 	}
	// 	else{
			
	// 	}
	// } 

	

?>
