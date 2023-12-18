<?php
    error_reporting(E_ERROR | E_PARSE);
    session_start();
    
    if($_SESSION["Attempts"] == ""){
        $_SESSION["Attempts"] = 1;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo 
                "<form action=\"login.php\" method=\"get\"> 
                    <table>
                        <caption>Login Form</caption>
                    <tr>
                        <td><label for=\"user\">Username</label></td>
                        <td><input type=\"text\" id=\"user\" name=\"user\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"pass\">Password</label></td>
                        <td><input type=\"text\" id=\"pass\" name=\"pass\"></td>
                    </tr> 
                    <tr>
                        <td></td>
                        <td>
                            <button type=\"submit\" formmethod=\"post\">submit</button>
                            <button type=\"button\" onclick=\"location.href = './index.php';\">back</button>
                    </td>
                    </tr>   
                    </table>
                </form>
                ";

    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];

        if ($user == "" && $pass == ""){
            $_SESSION["Attempts"] = $_SESSION["Attempts"] + 1;
            echo "Username and Password Missing<br>"; 
            echo "Number of attempts = " . $_SESSION["Attempts"];
        }

        else if ($user == ""){
            $_SESSION["Attempts"] = $_SESSION["Attempts"] + 1;
            echo "Username missing<br>";
            echo "Number of attempts = " . $_SESSION["Attempts"];
        }

        else if ($pass == ""){
            $_SESSION["Attempts"] = $_SESSION["Attempts"] + 1;
            echo "Password missing<br>";
            echo "Number of attempts = " . $_SESSION["Attempts"];
        }

        try {
            $db = new PDO('sqlite:account.db');

            $tableExists = tableExists($db);
            if ($tableExists == false) {
                $create_table_sql = file_get_contents('account.sql');
                $db->exec($create_table_sql);
                $_SESSION["db_size"] = 4;
            }

            $query_table_sql = "Select dob From account Where account.username=\"" . $user . "\" and account.password=\"" . $pass . "\"";
            $result = $db->query($query_table_sql)->fetch();

            //user not found case
            if ($result === false || $result === 0) {
                echo "user not found<br>";
                $_SESSION["Attempts"] = $_SESSION["Attempts"] + 1;
                echo "Number of attempts = " . $_SESSION["Attempts"];
            }

            //user found case
            else {
                $_SESSION["active_user"] = $user;
                header("Location: manage.php");
            }

        } catch (Exception $e) {
            echo "exception<br><br>";
            echo "". $e->getMessage();
        }
    }


    function tableExists($db) {
        try {
            $result = $db->query("SELECT 1 FROM" . " account " . "LIMIT 1");
        } catch (Exception $e) {
            return FALSE;
        }
        // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
        return $result !== FALSE;
    }

?>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
    </body>
</html>