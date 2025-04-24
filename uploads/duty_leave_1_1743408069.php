<html>
<html>
<body>
    <form action="" method="post">
    Name:<input type="text" name="n1">
    Number: <input type="number" name="n2">
    <input type="submit" value="SUBMIT" name="b"><br>
    </form>
</body>
</html>
<?php
if(isset($_POST['b']))
{
    $name=$_POST['n1'];
    $number=$_POST['n2'];

$connection = new mysqli("localhost", "root", "", "fruit");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo "Connected successfully<br>";
$stmt = $connection->prepare("INSERT INTO data VALUES ('$name','$number')");
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$sql = "SELECT name,number FROM data";
        $stmt = $connection->query($sql);

        if ($stmt->num_rows > 0) {
            echo "<table border =1><tr><th>Name</th><th>Number</th></tr>";
            while($row = $stmt->fetch_assoc()) {
                echo "<tr><td>".$row["name"]."</td><td>".$row["number"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";   
        }

$stmt->close();
$connection->close();}
?>
