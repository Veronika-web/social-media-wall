<?php 
/************************
connection for database 
*************************/
$hostname="localhost:3306";
$username="root";
$password="";
$database_name="php_DB";
/********************
create connection
*********************/
$conn=  mysqli_connect($hostname,$username,$password);
if(!$conn){
 die('could not connect:'.mysqli_error());
}
echo "connected succesfully";
//create database
$sql="CREATE DATABASE $database_name";
if(mysqli_query($conn,$sql)){
    echo"database created succefully";
}else{
    echo"error creating database:".mysqli_error($conn);
}
?>