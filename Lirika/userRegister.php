<html>

<head>
</head>

<body>
    <?php

    $date = date("d-m-Y");
    //get input values from form
    extract($_POST);
    ?>
    <p>Date: <b>
            <?php print($date) ?>
        </b></p>
    <table>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td><b>
                    <?php print($adName) ?>
                </b></td>
        </tr>
        4
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><b>
                    <?php print($adpsw) ?>
                </b></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><b>
                    <?php print($adEmail) ?>
                </b></td>
        </tr>
    </table>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lirikalogin";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO user (username, email, psw) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $adName, $adEmail, $adpsw);


    if ($stmt->execute()) {
        echo "Account created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    $stmt->close();
    $conn->close();

    ?>
    <br>

    <button class="login" onclick="redirectTouserlogin()">Login</button>


    <script>
        function redirectTouserlogin() {

            window.location.href = 'userlogin.html';
        }
    </script>
</body>

</html>