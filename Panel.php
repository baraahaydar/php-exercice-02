<?php
require_once 'Dbconfig.php';

if (!$user->is_loggedin()) {
    $user->redirect('Login.php');
}

$userID = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE userID=:userID");
$stmt->execute(array(":userID" => $userID));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['btn-logout'])) {
    if ($user->logout()) {
        $user->redirect('Home.php');
    }
    ;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome <?php print($userRow['email']);?></title>
</head>

</head>

<body>

    <div class="header">
        <a href="./Panel.php" class="logo active">BLOGS</a>
        <div class="header-right">
            <a href="./allBlogs.php">All Blogs</a>
            <a href="./myBlogs.php">My Blogs</a>
            <a href="./addBlogs.php">New Blog</a>
        </div>
    </div>

    <div>

        <div>
            <form method='post'>
                <button type='submit' name="btn-logout">Logout</button>
            </form>
        </div>

    </div>

    <div>
        welcome : <?php print($userRow['username']);?>
    </div>
</body>

</html>