<?php
session_start();
$username=" ";
$email ="";
$errors=[];
//Conexão com o banco de dados
$db = mysqli_connect('localhost','root','','ftp');

//Quando o botão de registro for clicado
if(isset($_POST['register'])){
    //transforma os parametros passados do metodo POST em string compatível com mysql
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db,$_POST['password_2']);


//Garante que o formulário esteja preenchido corretamente

if(empty($username)){
    array_push($errors,"Usuário não preenchido");
}
if(empty($email)){
    array_push($errors,"Email não preenchido");
}
if(empty($password_1)){
    array_push($errors,"Senha não preenchida");
}
if(empty($password_2)){
    array_push($errors,"Confirmação de senha não preenchida");
}

if($password_1 != $password_2){
    array_push($errors, "As duas senhas estão diferentes");
}

// Caso não tenha nenhum erro salve os dados no banco de dados
if(count($errors) == 0){
    $password = md5($password_1);//Criptografar a senha antes de guardar no banco
    //Comando de inserção no banco
    $sql = "INSERT INTO users (username, passwords, email) VALUES ('$username','$password','$email') ";
    //É necessário selecionar o banco antes de executar um comando
    mysqli_select_db($db,'ftp');
    //Execução do comando em si utilizando como parâmetro a conexão
    mysqli_query($db,$sql);
    $sql = " SELECT id FROM `users` WHERE email='$email' ";
    $result = mysqli_query($db,$sql); //Pega o resultado da query para processamento
    $row = mysqli_fetch_assoc($result); //Processa o resultado da consulta em uma linha que o php transforma em array
    //Salvando os dados da sessão
    $_SESSION['id'] = $row['id'];//Seleciona a coluna dentro do array
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "Você agora está logado";
    header('location: home.php'); //redireciona para a homepage

}
}

//Login da pagina de login
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,$_POST['password']);

    //Garante que o formulário esteja preenchido
    if(empty($email)){
        array_push($errors,"Email não preenchido");
    }
    if(empty($password)){
        array_push($errors,"Senha não preenchida");
    }

    if(count($errors) == 0){
        $password = md5($password); //Criptografa a senha digitada para comparar no banco de dados
        $query = "SELECT * FROM users WHERE email='$email' AND passwords='$password'";
        mysqli_select_db($db,'ftp');
        $result = mysqli_query($db,$query);
        
        if(mysqli_num_rows($result) == 1){
            //Entra com o email e senha
            $sql = " SELECT id FROM `users` WHERE email='$email' "; //comando para pegar o id no banco
            $result = mysqli_query($db,$sql); //Pega o resultado da query para processamento
            $row = mysqli_fetch_assoc($result); //Processa o resultado da consulta em uma linha que o php transforma em array
            $_SESSION['id'] = $row['id'];//Seleciona a coluna dentro do array
            $sql = " SELECT username FROM `users` WHERE email='$email' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['success'] = "Você agora está logado";
            header('location: home.php'); //redireciona para a homepage

        }else{
            array_push($errors,"Email ou senha incorreta");
        }
    }

}



//logout
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    header('location: index.php');
}

//Upload de arquivos quando o botão for pressionado
if(isset($_POST['submit'])){
    //nome do arquivo
    $file=$_FILES['file']['name'];
    //Mover o arquivo que foi feito o upload para uma pasta
    move_uploaded_file($_FILES['file']['tmp_name'],"files/$file");
    //Nome do diretório
    $name_dir=dirname(__DIR__);
    $name_dir=$name_dir.'files'.$file;
    $id=$_SESSION['id'];
    //Inserção do nome e do caminho no banco
    $sql="INSERT INTO `files` (name,path,id_user) VALUES ('$file','$name_dir','$id')";
    mysqli_select_db($db,'ftp');
    mysqli_query($db,$sql);
    echo "<script>alert('O arquivo foi salvo com sucesso')</script>";
    

}


?>