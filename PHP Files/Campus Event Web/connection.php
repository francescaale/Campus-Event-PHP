<html>
<body>

<?php
$host = "localhost";
$username = "root";
$pass = "";
$db = "coursework";

$con = mysqli_connect($host, $username, $pass, $db);

if (mysqli_connect_errno())
{
 echo "failed to connect: " . mysqli_connect_error();
}
//(lecture 2)
?>

</body>
</html>