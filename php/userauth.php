<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   $query = "SELECT * FROM students WHERE email = '$email';";
   $result = mysqli_query($conn, $query);

   //If email doesn't exist, then add new entries to database. 
   //If it exist, output message saying user exist
   if (mysqli_num_rows($result) > 0) {
    echo "User already exists. Please <a href='../forms/register.html'>Click Here</a> to try again.";
   }
   else {
        $insert = "INSERT INTO students (full_names, country, email, gender, password) VALUES ('$fullnames', '$country', '$email', '$gender', '$password');";
        if (mysqli_query($conn, $insert)) {
            echo "User Registered Successfully. <a href='../forms/login.html'>Click Here</a> to Login.";
        }
        else {
            echo "Error. <a href='../forms/register.html'>Click Here</a> to try again.";
        }
   }

}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
    $query = "SELECT * FROM students WHERE email = '$email' AND password = '$password';";

    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $details = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION["username"] = $details["full_names"];
            header("location: ..\dashboard.php");
        }
        else {
            // login failed
            header("location: ../forms/login.html");
        }
        mysqli_close($conn);
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
    $query = "UPDATE students SET password = '$password' WHERE email = '$email';";
    if ($conn) {
        if (mysqli_query($conn, $query)) {
            echo "Password updated successfully. <a href='../forms/login.html'>Click Here</a> to Login.";
        }
        else {
            echo "Error updating password. Please try again. ";
        }
        mysqli_close($conn);
     }
     mysqli_close($conn);
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
    $conn = db();

     //delete user with the given id from the database
    $query = "DELETE FROM students WHERE id = $id";
     if ($conn) {
        if (mysqli_query($conn, $query)) {
            echo "Student data successfully Deleted";
        }
        else {
            echo "Error deleting student data. Please try again. ";
        }
        mysqli_close($conn);
     }
 }
