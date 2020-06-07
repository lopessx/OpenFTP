<?php include('src/server.php');?>
<!DOCTYPE html>
<html>
<head>
<title>OPEN FTP</title>
<!-- Esse link está apontando para o style.css para fazer a estilização das páginas -->
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <div class="header">
        <h2>Home Page<h2>
    </div>

    <div class="content">

    <?php if (isset($_SESSION['success'])):?>
            <div class="error success">
                <h3>
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    
                    ?>
                </h3>
            </div>

    <?php endif?>

    <?php if (isset($_SESSION['username'])):?>
        <p>Welcome <strong><?php echo $_SESSION['username'] ?>  </strong></p>
        <p><a href="home.php?logout='1'" style="color: red;">Sair</a></p>
    <?php endif?>
    </div>
</body>


</html>