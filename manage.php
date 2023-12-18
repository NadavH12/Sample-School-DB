<?php
    session_start();
    error_reporting(E_ERROR | E_PARSE);

    echo "<p>Welcome </p> <h4>";

    $user =  $_SESSION["active_user"];
    $db = new PDO('sqlite:account.db');
    $query = "SELECT fullname,permission FROM account WHERE username = '" . $user . "';";
    $res = $db->query($query)->fetch();
    $name = $res["fullname"];
    $perms = $res["permission"];

    echo $name .  " |</h4> <a href=\"./logout.php\">Log out</a><br><br>";

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_GET['id'] == "" ) {
            if($perms == 0) {
                echo "<form action=\"./manage.php\" method=\"get\"> 
                        <table>
                            <tr>
                                <td class=\"mng_header\">ID</td>
                                <td class=\"mng_header\">Username</td>
                                <td class=\"mng_header\">Full Name</td>
                                <td class=\"mng_header\">Data Birth</td>
                                <td class=\"mng_header\">Gender</td>
                                <td class=\"mng_header\">Email</td>
                                <td class=\"mng_header\">Mobile</td>
                                <td class=\"mng_header\">Address</td>
                                <td class=\"mng_header\">State</td>
                                <td class=\"mng_header\">City</td>
                                <td class=\"mng_header\"> </td>
                            </tr>
                ";

                $stmt = $db->query("SELECT id,username,fullname,dob,gender,email,mobile,address,state,city FROM account WHERE permission = 1");
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $row = getGenderText($row);

                    echo "<tr>";
                    foreach ($row as $element) {
                        echo "<td>" . $element . "</td>";
                    }

                    $id = $row["id"];
                    echo "<td><button type=\"button\" onclick=\"location.href = './manage.php?id=" . $id . "';\" class=\"x\"><img src=\"./assets/cross_red.png\"/></button></td></tr>";
                }
                echo "<tr><td colspan=\"11\"><button class=\"back2\" type=\"button\" onclick=\"location.href = './index.php';\">back</button></td></tr>";
            
            } else {
                echo "Sorry but this account does not have permission to manage users";
            }
                            
        } else {
            $id_to_del = $_GET["id"];
            $stmt = $db->query("DELETE FROM account WHERE id = '" . $id_to_del . "';");
            $_GET["id"] = "";
            header('Location: manage.php');
        }
    }

    function getGenderText($row) { 
        $gender = $row["gender"];
        if ($gender == 0) {
            $row["gender"] = "other";
        } else if ($gender == 1) {
            $row["gender"] = "male";
        } else {
            $row["gender"] = "female";
        }
        return $row;
    }
?>

<html>
    <head>
        <title>Manage</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
    </body>
</html>