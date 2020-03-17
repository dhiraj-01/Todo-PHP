<?php 
    include('database.php');
    include('default.html');

    if(!loggedin()){
        header("location:login.php");
    }

	$username = $_SESSION['username'];
 	echo '<br> <a href="logout.php" align="right" title="Logout" style="color: red; text-decoration: none">&nbsp; Logout </a>';

 	echo '<a href="changepassword.php" align="right" title="change password" style="color: blue; text-decoration: none">&nbsp; Change Password </a>';

 	echo '<a href="deleteaccount.php" align="right" title="delete account" style="color: blue; text-decoration: none">&nbsp; Delete Account </a> <br>';

 	error();
	echo "<br> <center id='user'> Welcome ".ucwords($username)."</center> <br>";

	if(isset($_POST['addtask']))
	{
	    if(!empty($_POST['description']))
	    {
	        addTodoItem($_SESSION['username'], $_POST['description']);
	        header("Refresh:0");   
	    }
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title> TODO </title>
</head>
<body>
	<br>
	<form action="todo.php" method="POST">
		<?php spaces(30); ?>
		<input type="text" size="50" placeholder=" Title" name="description" autocomplete="off"/>	
        <input type="submit" name="addtask" value="Add"/>
    </form>
</body>
</html>

<?php
    getTodoItems($username);
 ?>
