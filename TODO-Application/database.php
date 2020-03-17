<!DOCTYPE html>
<html>
<head>
    <style type="text/css" media="screen">
        input.largerCheckbox { 
            width: 20px; 
            height: 20px; 
        } 
    </style>
</head>
</html>

<?php
    session_start();
    if(isset($_POST['Delete']))
    {
        if(!empty($_POST['check_list']))
        {
            $tasks = $_POST['check_list'];
            $length = count($tasks);
            for ($i = 0; $i < $length; $i++) {
                deleteTodoItem($_SESSION['username'], $tasks[$i]);
            }
        }
    }
    else if(isset($_POST['Save']))
    {
        $conn = connectdatabase();
        $sql = "UPDATE todo.tasks SET done = 0";
        $result = mysqli_query($conn, $sql); 
        mysqli_close($conn);

        if(!empty($_POST['check_list']))
        {
            $tasks = $_POST['check_list'];
            $length = count($tasks);
            if($length > 0) {
                for ($i = 0; $i < $length; $i++) {
                    updateDone($tasks[$i]);
                }
            }
        }
    }

    function connectdatabase() {
        return mysqli_connect("127.0.0.1:3306", "dhiraj", "pass.1.11", "todo");
    }

    function loggedin() {
        return isset($_SESSION['username']);
    }

    function logout() {
        $_SESSION['error'] = "&nbsp; Succesfully logout !!";
        unset($_SESSION['username']);
    }

    function spaces($n) {
        for($i=0; $i<$n; $i++)
            echo "&nbsp;";
    }

    function userexist($username) 
    {
        $conn = connectdatabase();
        $sql = "SELECT * FROM todo.users WHERE username = '".$username."'"; 
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(!$result || mysqli_num_rows($result) == 0) { 
           return false;
        }
        return true;
    }

    function validuser($username, $password) 
    {
        $conn = connectdatabase();
        $sql = "SELECT * FROM todo.users WHERE username = '".$username."'AND password = '".$password."'"; 
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        if(!$result || mysqli_num_rows($result) == 0) { 
           return false;
        }
        return true;
    }

    function error() 
    {
        if(isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
    }

    function updatepassword($username, $password) {
        $conn = connectdatabase();
        $sql = "UPDATE todo.users SET password = '".$password."' WHERE username = '".$username."';";
        $result = mysqli_query($conn, $sql);

        $_SESSION['error'] = "<br> &nbsp; Password Updated !! ";
        header('location:todo.php');
    }

    function deleteaccount($username) {
        $conn = connectdatabase();
        $sql = "DELETE FROM todo.tasks WHERE username = '".$username."';";
        $result = mysqli_query($conn, $sql);

        $sql = "DELETE FROM todo.users WHERE username = '".$username."';";
        $result = mysqli_query($conn, $sql);

        $_SESSION['error'] = "&nbsp; Account Deleted !! ";
        unset($_SESSION['username']);
        header('location:login.php');
    }

    function createUser($username, $password)
    {
        if(!userexist($username))
        {
            $conn = connectdatabase();
            $sql = "INSERT INTO todo.users (username, password) VALUES ('".$username."','".$password."')";
            $result = mysqli_query($conn, $sql);

            $_SESSION["username"] = $username;
            header('location:todo.php');
        }
        else
        {
            $_SESSION['error'] = "&nbsp; Username already exists !! ";
            header('location:newuser.php');
        }
    }
    
    function isValid($username, $password, $usercaptcha)
    {
        $capcode = $_SESSION['captcha'];

        if(!strcmp($usercaptcha,$capcode))
        {
            if(validuser($username, $password))
            {
                $_SESSION["username"] = $username;
                header('location:todo.php');
            }
            else
            {
                $_SESSION['error'] = "&nbsp; Invalid Username or Password !! ";
                header('location:login.php');
            }
            mysqli_close($conn);
        }
        else
        {
            $_SESSION['error'] = "&nbsp; Invalid captcha code !! ";
            header('location:login.php');
        }
    }
    
    function getTodoItems($username) {

        $conn = connectdatabase();
        $sql = "SELECT * FROM tasks WHERE username = '".$username."'";
        
        $result = mysqli_query($conn, $sql);

        echo "<form method='POST'>";
        echo "<pre>";
        if ($result and mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {

                spaces(15);
                if($row['done']) {
                    echo "<input type='checkbox' checked class='largerCheckbox' name='check_list[]' value='".$row["taskid"] ."'>";
                }
                else {
                    echo "<input type='checkbox' class='largerCheckbox' name='check_list[]' value='".$row["taskid"] ."'>";
                }
                echo "<td> " . $row["task"] . "</td>";
                echo "<br>";
            }
        }
        echo "</pre> <hr>";
        spaces(35);
        echo "<input type='submit' name='Delete' value='Delete'/>";
        spaces(10);
        echo "<input type='submit' name='Save' value='Save'/>";
        echo "</form>";
        echo "<br><br>";
        mysqli_close($conn);
    }

    function addTodoItem($username, $todo_text) 
    {
        $conn = connectdatabase();
        $sql = "INSERT INTO todo.tasks(username, task, done) VALUES ('".$username."','".$todo_text."',0);";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
    
    function deleteTodoItem($username, $todo_id) 
    {
        $conn = connectdatabase();
        $sql = "DELETE FROM todo.tasks WHERE taskid = ".$todo_id." and username = '".$username."';";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
    }

    function updateDone($todo_id) 
    {
        $conn = connectdatabase();
        $sql = "UPDATE todo.tasks SET done = '1' WHERE (taskid = '".$todo_id."');";
        $result = mysqli_query($conn, $sql);   
        mysqli_close($conn);
    }
?>