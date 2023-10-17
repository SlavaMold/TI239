<?php session_start();
    if(isset($_COOKIE['login'])){
        setcookie('token', true, 0, '/');
        setcookie('login', $_COOKIE['login'], 0, '/');
        header('Location: admin/admin_auth.php');
    } 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login in</title>
</head>
<style>
    body{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    h2{
        color: rgb(226, 130, 28);
    }
    form{
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        
    }
    button{
        background-color: rgb(69, 102, 235);
        height: 25px;
        border-radius: 10px;
        border: none;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s;
    }
    button:hover{
        background-color: #912626;
        cursor: pointer;
        border-radius: 5px;
        color: #ffffff;
        font-size: 16px;
      
    }
    .form_group{
        padding: 10px;
    }
    input{
        width: auto;
        height: 20px;
    }
    h3{
        color:red;
    }

    @media (min-width:2000px) {
         h3{
              font-size: 30px;
           }

           input{
                    width: auto;
                    height: 40px;
                    font-size: 36px;
                } 
         button{
            font-size: 28px;
            height: 60px;
         } 

         h2{
            font-size: 40px;
         } 
    }

</style>
<body>

    <h2>  Подтвердите вход</h2>
    <form action="admin/admin_auth.php" method="POST">
    <div class="form_group">
         <input type="text" placeholder="login" name="login">           
    </div>
    <div class="form_group">
    <input type="text" placeholder="password" name="password">
    </div>
    <button type="submit"> войти </button>
</form>
<?php 
    if(isset($_SESSION['message'])){
        echo '<h3>' . $_SESSION['message'] . '</h3>';
    }
    unset($_SESSION['message']);
?>

</body>
</html>