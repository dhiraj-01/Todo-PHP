<?php 
    include('default.html');
    include('database.php');

    if(loggedin()) {
        header("location:todo.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> New User </title>
    </head>
    <body>
        <p style="white-space:pre">  Already have an account <a href="login.php" title="Login" style="color: red;text-decoration: none"> Login </a> </p>
    
        <?php error(); ?>

        <form action="adduser.php" method="POST">
            <center>
            <fieldset>
                <legend style="color: blue;"> New User </legend>
                <table>
                    <tr>
                        <td> <pre>User Name </pre> </td>
                        <td> <input type="text" name="username" placeholder=" Dhiraj" autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <td> <pre>Password </pre> </td>
                        <td> <input type="password" required name="password1" placeholder=" *******"> </td>
                    </tr>
                    <tr>
                        <td> <pre>Confirm Password </pre></td>
                        <td> <input type="password" required name="password2" placeholder=" *******"> </td>
                    </tr>
                    <tr>
                        <td>
                            <?php                            
                                $capcode = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
                                $capcode = substr(str_shuffle($capcode), 0, 6);
                                $_SESSION['captcha'] = $capcode;
                                echo '<div class = "unselectable">'.$capcode.'</div>';
                            ?>
                        </td>
                        <td> <input type="text" name="captcha" placeholder=" Enter captcha"  autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <td> <input type="reset" value="Reset"> </td>
                        <td> <input type="submit" value="Submit"> </td>
                    </tr>
                </table>
            </fieldset>

            </center>

        </form>
    </body>
</html>