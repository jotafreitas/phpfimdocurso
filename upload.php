<?php


/*
MYSQL
create database files;
use files;
create table path(
caminho varchar (200));
*/

$host= "127.0.0.1:3310";
$usuario = "root";
$senha = "";
$bd = "files";


$con = mysqli_connect($host, $usuario, $senha, $bd);
if ($con -> connect_errno){
echo "Falha na Conexão: (".$con->connect_errno.")".$con-> connect_error;
}
echo $con->host_info . "\n";


$upOk = 1;

$target_dir = "./ups/";
//Array usa o basename somente para pegar a última parte do caminho
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//Pega somente a extensão e converte em minúsculo
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//Define um nome único
$target_file =$target_dir.md5(uniqid()).".".$imageFileType;
echo $target_file;

// Verifica se a imagem é real
if(isset($_POST["submit"])) {

    //A função getimagesize() irá determinar o tamanho de qualquer arquivo de imagem suportado fornecido e retornar as dimensões
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);}
//     if($check !== false) {
//     //verifica se o arquivo é mesmo válido como imagem
//       echo "File is an image - " . $check["mime"] . ".";
//     //cria uma variável para utilizarmos no envio, validando que a imagem é real
//       $upOk = 1;
//     } else {
//       echo "File is not an image.";
//       $upOk = 0;
//     }
//   }



// Verifica se o arquivo já existe, consulta o caminho e o nome
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $upOk = 0;
  }


// Verifica o tamanho do arquivo
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Seu arquivo é muito grande.";
    $upOk = 0;
  }


// Permitindo formatos específicos
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $upOk = 0;
}

// Salvando o arquivo
if ($upOk == 0) {
    echo "Desculpe, seu arquivo não pode ser submetido.";
  
  } else {
    //Move o arquivo, porém com o nome aterado 

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //htmlspecialchars (preserva os caracteres não gerando conflito com o HTML)
      echo "O arquivo ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " foi enviado .";
      $query_insert = "insert into path values ('./{$target_file}');";
      $result_insert= mysqli_query($con, $query_insert); 



    } else {
      echo "Desculpe, ocorreu um erro ao submeter o arquivo.";
    }
  }

  


/*

$target_dir = "./ups/";
//$novaimagem = md5(uniqid()).strtolower(pathinfo($target_file,PATHINFO_EXTENSION));;
//$_FILES["fileToUpload"] = $novaimagem;
$file_tmp = $_FILES["fileToUpload"]["name"];

echo $$file_tmp["fileToUpload"]["name"];

//echo $_FILES["fileToUpload"]["name"];


//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $novaimagem;
//echo $target_file;
//echo $novaimagem;

//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
//echo $imageFileType;
*/