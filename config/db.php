<?php
$host = '127.0.0.1';
$port = '3306';
$dbname = 'prompt_repository';
$username = 'root';
$password = '';

try{
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname",$username,$password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Connected successfully!";

}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}

?>