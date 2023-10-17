<?php 

require_once 'functions/connect.php'; 

$get_data_from_commits = mysqli_query($connect, "SELECT * FROM `commits` WHERE 1");
$data = mysqli_fetch_all($get_data_from_commits , MYSQLI_ASSOC);

if(isset($_COOKIE['token'])){

	if($_COOKIE['token'] == 1){
		
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>TI-239</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/g.css">

</head>
<script type="text/javascript" src="js/main-admin.js"></script>

	<body>
		<header>
				<div class="container-header">
					<div class="header-line">
						<div class="header-logo">
                    		<img src="imgs/header.png" class="header-logo-img">
                		</div>

                		<div class="nav">
                    			 <div class="article2">
    								<a class="underline-one" href="../login.php">Вход выполнен</a>
  								</div>
                		</div>
					</div>
						<div class="burger-menu"><div class="header-burger"><span></span></div>
                    	
                </div>
				</div>
		 </header>

		 <div class="content">
		 	<div class="container">
		 		<div class="divide-line-uh">
		 			<span>Основная Информация</span>
		 		</div>
		 		<div class="schedule-wrap">
		 			<img src="imgs/schedule.png" class="schedule">
		 		</div>

		 		<div class="hot-panel">
		 			<div class="h-p-element"> 
		 				<div class="doc-icon-wrap"> <img src="documents/pdf.png" class="main-doc-icon"> </div>
		 				<div class="docdownload"> 
		 					<a href="schedule.pdf" class="download-documents" download>Скачать Расписание <img src="imgs/download.png" class="download-icon"></a> 
		 					
		 				</div>
		 			</div> 
		 		</div>


		 		<div class="divide-line"> 
		 			<div class="sort-commits"> 
		 				<span> Сортировать записи: </span>
		 				<div class="sort-types"> 
		 					<ul>
		 						<li id="all" class="sort-type"> Всё </li>
		 						<li id="week" class="sort-type"> За эту неделю</li>
		 						<li id="date" class="sort-type"> Выбор даты</li>
		 						<li id="signed" class="sort-type"> Отмеченные</li>
		 					</ul>
		 				</div>
		 			</div>
		 		</div>

		 		<?php
		 			function printAttached($filename, $filepath, $datarow, $path){
										for($i = 0; $i < strlen($datarow['attached']); $i++){ 
											if($datarow['attached'][$i] != '|'){
												$filename .= $datarow['attached'][$i];	
											}
											else{
												$filepath = $path . $filename;
												echo '<div class="attached-wrap">';
												echo '<img src="imgs/file.png" class="doc-icon">';

												echo '<a href="' . $filepath . '" class="download-documents" download>';
												echo '<img src="imgs/download.png" class="download-icon">' . $filename . '</a>';
												echo '</div>';
												$filename = '';
												$filepath = '';
												}
												
											}
										}
		 		?>

		 		<?php foreach ($data as $datarow) {

		 	    ?>

		 		<div class="weekly-list-wrap <?php if($datarow['noted'] == 1) echo 'noted' ?>"> 
		 			<div class="weekly-list-head">
		 				<span> <?php echo 'Запись от: ' . $datarow['date'] ?> </span>
		 				<span> <?php echo $datarow['time']; ?> </span>  
		 				<div class="weekly-list-func"> 
		 					<ul>
		 						<li id="redact"> <button class="redact-comm" id='<?php echo $datarow['id']; ?>'> Редактировать </button> </li>
		 						<li id="delete"> <button class="delete-comm" id='<?php echo $datarow['id']; ?>'> Удалить </button> </li>
		 						<li id="note"> <form method="POST" action="" class="note-comm" id='<?php echo $datarow['id']; ?>'>
		 						<input type="hidden" name="id" value="<?php echo $datarow['id'] ?>"/>
                 				<input type="submit" name="note" value="Отметить"> </form></li>

		 					</ul>
		 				</div>
		 			</div>
		 			<div class="weekly-list-body">

		 				<div class="main-text">
		 					<?php echo $datarow['text'] ?>
		 				</div>

		 				<div class="attached">
		 					<div class="attached-file"> 
		 						<div class="doc-icon-wrap"> 
		 						</div> 
		 						<?php
		 							
		 						 if(!empty($datarow['attached'])){ 
		 								$filename = '';
		 								$filepath = '';
		 								$path = 'admin/uploaded/' . $datarow['id'] . '/';
		 								printAttached($filename, $filepath, $datarow, $path);
									}?>
		 					</div>
		 					<div class="imgs"> </div>
		 					<div class="links"> </div>
		 				</div>
		 			</div>

		 			<div class="weekly-list-author">
		 				<div class="author">
		 					<span> Автор: <?php echo $datarow['author']; ?> </span>
		 					<?php
		 					$author = $datarow['author']; 
		 					$avatar = mysqli_query($connect, "SELECT * FROM `admins` WHERE `login` = '$author'"); 
		 					$avatar = mysqli_fetch_all($avatar , MYSQLI_ASSOC);
		 						foreach ($avatar as $key) {
		 							echo '<img src="' . $key['avatar'] . '">';
		 						}
		 					?>
		 				</div>
		 			</div>


		 		</div>

		 	<?php } ?>

		 	</div>
		 </div>


		 <footer> 
		 	<div class="container-footer">
		 		<div class="summary">
		 			<span class="secur">
		 			©TI239 All Rights Secured. 
		 		</span>
		 		<span> 
		 			Developed by Veaceslav Todorov (fullstack).
		 		</span>
		 		<span> 
		 			Special for TI-239, love you guys!
		 		</span>
		 	</div>
		 </footer>
	</body> 
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<?php

	}
}

else{
	?><!DOCTYPE html>
<html lang="ru">
<head>
	<title>TI-239</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/g.css">

</head>
	<body>
		<header>
				<div class="container-header">
					<div class="header-line">
						<div class="header-logo">
                    		<img src="imgs/header.png" class="header-logo-img">
                		</div>

                		<div class="nav">
                    			 <div class="article2">
    								<a class="underline-one" href="../login.php">Для Старосты</a>
  								</div>
                		</div>
					</div>
						<div class="burger-menu"><div class="header-burger"><span></span></div>
                    	
                </div>
				</div>
		 </header>

		 <div class="content">
		 	<div class="container">
		 		<div class="divide-line-uh">
		 			<span>Основная Информация</span>
		 		</div>
		 		<div class="schedule-wrap">
		 			<img src="imgs/schedule.png" class="schedule">
		 		</div>

		 		<div class="hot-panel">
		 			<div class="h-p-element"> 
		 				<div class="doc-icon-wrap"> <img src="documents/pdf.png" class="doc-icon"> </div>
		 				<div class="docdownload"> 
		 					<a href="schedule.pdf" class="download-documents" download>Скачать Расписание <img src="imgs/download.png" class="download-icon"></a> 
		 					
		 				</div>
		 			</div> 
		 		</div>


		 		<div class="divide-line"> 
		 			<div class="sort-commits"> 
		 				<span> Сортировать записи: </span>
		 				<div class="sort-types"> 
		 					<ul>
		 						<li id="all" class="sort-type"> Всё </li>
		 						<li id="week" class="sort-type"> За эту неделю</li>
		 						<li id="date" class="sort-type"> Выбор даты</li>
		 						<li id="signed" class="sort-type"> Отмеченные</li>
		 					</ul>
		 				</div>
		 			</div>
		 		</div>

		 		<?php
		 			function printAttached($filename, $filepath, $datarow, $path){
										for($i = 0; $i < strlen($datarow['attached']); $i++){ 
											if($datarow['attached'][$i] != '|'){
												$filename .= $datarow['attached'][$i];	
											}
											else{
												$filepath = $path . $filename;
												echo '<div class="attached-wrap">';
												echo '<img src="imgs/file.png" class="doc-icon">';

												echo '<a href="' . $filepath . '" class="download-documents" download>';
												echo '<img src="imgs/download.png" class="download-icon">' . $filename . '</a>';
												echo '</div>';
												$filename = '';
												$filepath = '';
												}
												
											}
										}
		 		?>

		 		<?php foreach ($data as $datarow) {

		 	    ?>

		 		<div class="weekly-list-wrap <?php if($datarow['noted'] == 1) echo 'noted' ?>"> 
		 			<div class="weekly-list-head">
		 				<span> <?php echo 'Запись от: ' . $datarow['date']; ?> </span> 
		 				<span> <?php echo $datarow['time']; ?> </span> 
		 				<div class="weekly-list-func"> 
		 					<ul>
		 						<li id="redact">Редактировать</li>
		 						<li id="delete">Удалить</li>
		 						<li id="note">Отметить</li>

		 					</ul>
		 				</div>
		 			</div>
		 			<div class="weekly-list-body">

		 				<div class="main-text">
		 					<?php echo $datarow['text'] ?>
		 				</div>

		 				<div class="attached">
		 					<div class="attached-file"> 
		 						<div class="doc-icon-wrap"> 
		 						</div> 
		 						<?php
		 							
		 						 if(!empty($datarow['attached'])){ 
		 								$filename = '';
		 								$filepath = '';
		 								$path = 'admin/uploaded/' . $datarow['id'] . '/';
		 								printAttached($filename, $filepath, $datarow, $path);
									}?>
		 					</div>
		 					<div class="imgs"> </div>
		 					<div class="links"> </div>
		 				</div>
		 			</div>

		 			<div class="weekly-list-author">
		 				<div class="author">
		 					<span> Автор: <?php echo $datarow['author']; ?> </span>
		 					<?php
		 					$author = $datarow['author']; 
		 					$avatar = mysqli_query($connect, "SELECT * FROM `admins` WHERE `login` = '$author'"); 
		 					$avatar = mysqli_fetch_all($avatar , MYSQLI_ASSOC);
		 						foreach ($avatar as $key) {
		 							echo '<img src="' . $key['avatar'] . '">';
		 						}
		 					?>
		 				</div>
		 			</div>


		 		</div>

		 	<?php } ?>
		 	</div>
		 </div>


		 <footer> 
		 	<div class="container-footer">
		 		<div class="summary">
		 			<span class="secur">
		 			©TI239 All Rights Secured. 
		 		</span>
		 		<span> 
		 			Developed by Veaceslav Todorov (fullstack).
		 		</span>
		 		<span> 
		 			Special for TI-239, love you guys!
		 		</span>
		 	</div>
		 </footer>
	</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</html>

<?php
}

if(isset($_COOKIE['whoLeave'])){
	$offline = $_COOKIE['whoLeave'];
	mysqli_query($connect, "UPDATE `admins` SET `online` = 'false' WHERE `login` = '$offline'");
}

if(isset($_POST['delete'])){
	$id = $_POST['id'];
	mysqli_query($connect, "DELETE FROM `commits` WHERE `id` = $id");

	$dirtodel = 'admin/uploaded/' . "$id";
		$files = glob("$dirtodel" . '/*'); 
			foreach($files as $file){ 
  			if(is_file($file)) {
   			 unlink($file); 
  				}
			}
		if(is_dir($dirtodel)){
			rmdir($dirtodel);
		}
	unset($_POST['delete']);
}

if(isset($_POST['note'])){
	$id = $_POST['id'];
	mysqli_query($connect, "UPDATE `commits` SET `noted`='1' WHERE id = $id");
	unset($_POST['note']);
}
///<form method="POST"> <input type="submit" action="" name="delete" value="Удалить"></form>
?>