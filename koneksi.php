<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "akademik";

$koneksi = mysqli_connect($host,$user,$pass,$db);
    if(!$koneksi){
        die("gagal konek db");
    }
    /*else{
        echo"berhasil konek db";
    }*/

?>