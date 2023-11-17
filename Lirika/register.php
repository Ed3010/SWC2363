<html>

<head>
</head>

<body>
    <?php

    $date = date("d-m-Y");
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


    $sql = "INSERT INTO lirikaadmin (username, email, psw) VALUES (?, ?, ?)";
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
    <form>
        <input type="button" name="printButton" onClick="window.print()" value="Print">
    </form>
</body>

</html>