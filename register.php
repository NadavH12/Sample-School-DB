<?php
session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo
            "<form action=\"register.php\" method=\"get\"> 
                <table>
                    <caption>Registration Form</caption>
                    <tr>
                        <td><label for=\"user\">Username</label></td>
                        <td><input type=\"text\" id=\"user\" name=\"user\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"pass\">Password</label></td>
                        <td><input type=\"password\" id=\"pass\" name=\"pass\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"conf_pass\">Confirm Password</label></td>
                        <td><input type=\"password\" id=\"conf_pass\" name=\"conf_pass\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"full_name\">Full Name</label></td>
                        <td><input type=\"text\" id=\"full_name\" name=\"full_name\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"dob\">Date of Birth</label></td>
                        <td><input type=\"date\" id=\"dob\" name=\"dob\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"gender\">Gender</label></td>
                        <td>
                            Male<input type=\"radio\" id=\"male\" name=\"male\">
                            Female<input type=\"radio\" id=\"female\" name=\"female\">
                            Other<input type=\"radio\" id=\"other\" name=\"other\">
                        </td>
                    </tr>
                    <tr>
                        <td><label for=\"email\">Email</label></td>
                        <td><input type=\"email\" id=\"email\" name=\"email\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"mobile\">Mobile</label></td>
                        <td><input type=\"tel\" id=\"mobile\" name=\"mobile\"></td>
                    </tr>
                    <tr>
                        <td><label for=\"address\">Address</label></td>
                        <td><textarea id=\"address\" name=\"address\" rows=\"4\" cols=\"21\"></textarea></td>
                    </tr>
                    <tr>
                        <td><label for=\"state\">State</label></td>
                        <td>
                            <select name=\"state\" id=\"state\">
                                <option value=\"\">Select a State</option>
                                <option value=\"alabama\">Alabama</option>
                                <option value=\"alaska\">Alaska</option>
                                <option value=\"arizona\">Arizona</option>
                                <option value=\"arkansas\">Arkansas</option>
                                <option value=\"oregon\">Oregon</option>
                                <option value=\"washington\">Washington</option>
                            </select>    
                        </td>
                    </tr>
                    <tr>
                        <td><label for=\"city\">City</label></td>
                        <td><input type=\"text\" id=\"city\" name=\"city\"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type=\"submit\" formmethod=\"post\">submit</button>
                            <button onclick=\"location.href = './index.php';\">back</button>
                        </td>
                    </tr>   
                </table>
            </form> 
        ";
    }

    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        stateCode();
        getGender();

        $db_size = $_SESSION["db_size"];

        $insert_row_sql = "insert into account values (" . $db_size . ",\"" . $_REQUEST["user"] . "\",\"" . $_REQUEST["pass"] . "\",\"" . $_REQUEST["full_name"] . "\",\"" . $_REQUEST["dob"] . "\"," . $_REQUEST["gender"] . ",\"". $_REQUEST["email"] ."\",\"". $_REQUEST["mobile"] ."\",\"" . $_REQUEST["address"] . "\",\"" . $_REQUEST["state"] ."\",\"". $_REQUEST["city"] . "\"," . 0 . ")";

        try {
            $info_missing = 0;
            
            if ($_REQUEST["user"] == "") {
                $info_missing++;
                echo "Missing Username<br>";
            }
            if ($_REQUEST["pass"] == ""){
                $info_missing++;
                echo "Missing Password<br>";
            }
            if ($_REQUEST["full_name"] == "") {
                $info_missing++;
                echo "Missing Full Name<br>";
            }
            if ($_REQUEST["dob"] == "") {
                $info_missing++;
                echo "Missing Date of Birth<br>";
            }
            if ($_REQUEST["gender"] == "") {
                $info_missing++;
                echo "Missing Gender<br>";
            }
            if ($_REQUEST["email"] == "") {
                $info_missing++;
                echo "Missing Email<br>";
            }
            if ($_REQUEST["state"] == "") {
                $info_missing++;
                echo "Missing State<br>";
            }
            if ($_REQUEST["city"] == "") {
                $info_missing++;
                echo "Missing City<br>";
            }
            
            if($info_missing == 0) {
                $db = new PDO('sqlite:account.db');
                $success = $db->exec($insert_row_sql);

                if ($success === 1) {
                    $_SESSION["db_size"]++;
                    header("Location: index.php");
                }
            }

        } catch (Exception $e) {
            echo "". $e->getMessage();
        }
    }

    function stateCode(){
        $state = $_REQUEST["state"];
        if($state == "alabama"){
            $_REQUEST["state"] = "AL";
        } else if($state == "alaska"){
            $_REQUEST["state"] = "AK";
        }else if($state == "arizona"){
            $_REQUEST["state"] = "AZ";
        } else if($state == "arkansas"){
            $_REQUEST["state"] = "AR";
        }else if($state == "oregon"){
            $_REQUEST["state"] = "OR";
        } else {
            $_REQUEST["state"] = "WA";
        }
    }

    function getGender(){
        if($_REQUEST["male"] == "on")
            $_REQUEST["gender"] = 1;
        else if($_REQUEST["female"] == "on")
            $_REQUEST["gender"] = 2;
        else {
            $_REQUEST["gender"] = 0;
        }
    }
?>

<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
    </body>
</html>