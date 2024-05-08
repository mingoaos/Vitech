<?php
session_start();

require './dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    if(isset($_POST['dataIni']) && isset($_POST['dataFim']) && isset($_POST['assunto']) && isset($_POST['noticia']))
    {

        $dataini = mysqli_real_escape_string($con,$_POST['dataIni']);
        $datafim = mysqli_real_escape_string($con,$_POST['dataFim']);
        $assunto = mysqli_real_escape_string($con,$_POST['assunto']);
        $noticia = mysqli_real_escape_string($con,$_POST['noticia']);


        $query = "INSERT INTO noticia ('Data_inicio','Data_fim','Assunto','Noticia','Status') Values ('$dataini','$datafim','$assunto','$noticia','A');";

        $query_exec = mysqli_query($con,$query);

        if($query_exec)
        {
            $_SESSION['alert'] = "Data inserted successfully";
        } else {
            $_SESSION['alert'] = "Error: " . mysqli_error($con);
        }
        // Redirect back to the index page
        header("Location: ../");
        exit();
    }
    
    
}

?>