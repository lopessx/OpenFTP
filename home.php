<?php include('src/server.php');
//Conexão com o banco e seleção dos arquivos a serem mostrados na tabela
$db = mysqli_connect('localhost','root','','ftp');
mysqli_select_db($db,'ftp');
$id=$_SESSION['id'];
$sql="SELECT * FROM `files` WHERE id_user='$id'";
$con=mysqli_query($db,$sql);

?>


<!DOCTYPE html>
<html>
<head>
<title>OPEN FTP</title>
<!-- Esse link está apontando para o style.css para fazer a estilização das páginas -->
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <div class="header">
        <h2>Home<h2>
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
        <p>Bem vindo <strong><?php echo $_SESSION['username'] ?>  </strong></p>
        <p><a href="home.php?logout='1'" style="color: red;">Sair</a></p>
    <?php endif?>
    </div>

    <div class="upload">
    <form action="home.php" method="post" enctype="multipart/form-data">

        <label>Selecione uma imagem para fazer upload</label>
        <input type="file" name="file">
        <input type="submit" name="submit" value="Upload">

    </form>
    </div>

    <div class="footer">
        <h2>Arquivos<h2>
    </div>

    <div class="view">
        <table class="table" border="5">
            <tr>
                <td>Código</td>
                <td>Arquivo</td>
                <td>Caminho</td>
                <td>Código de Usuário</td>
                <td>Ação</td>
            </tr>
        <?php while ($dado = $con->fetch_array()): ?>
        <tr>
            <td> <?php echo $dado["id"];?> </td>
            <td><a href="files/<?php echo $dado["name"];?>" download="<?php echo $dado["name"];?>"> <?php echo $dado["name"];?> </a></td>
            <td> <?php echo $dado["path"];?> </td>
            <td> <?php echo $dado["id_user"];?> </td>
            <td><a href="src/editar.php?codigo=<?php echo $dado["id"]?>">Editar</a>  |
            <a href="home.php?excluir=<?php echo $dado["id"]?>" onclick="return confirm('Deseja mesmo excluir o arquivo?');">Excluir</a></td>
        </tr>
        <?php endwhile?>
        </table>


    </div>



</body>


</html>