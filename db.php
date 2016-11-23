<?php
    $host_name  = "db643558493.db.1and1.com";
    $database   = "db643558493";
    $user_name  = "dbo643558493";
    $password   = "geymueller";


    $connect = mysqli_connect($host_name, $user_name, $password, $database);
    
    if(mysqli_connect_errno())
    {
    echo '<p>Verbindung zum MySQL Server fehlgeschlagen: '.mysqli_connect_error().'</p>';
    }
    else
    {
    echo '<p>Verbindung zum MySQL Server erfolgreich aufgebaut.</p>';
    }
?>