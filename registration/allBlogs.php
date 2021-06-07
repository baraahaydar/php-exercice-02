<?php
require_once 'Dbconfig.php';

if (!$user->is_loggedin()) {
    $user->redirect('Login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Blogs.css">
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    .header {
        overflow: hidden;
        padding: 20px 10px;
    }

    .header a {
        float: left;
        color: black;
        text-align: center;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        line-height: 25px;
        border-radius: 4px;
        background-color: #FFFFFF;
        margin-right: 5px;
    }

    .header a.logo {
        font-size: 25px;
        font-weight: bold;
    }

    .header a:hover {
        color: black;
    }

    .header a.active {
        background-image: linear-gradient(to left, rgb(130, 0, 0), rgb(200, 0, 0));
        color: white;
    }

    .header-right {
        float: right;
        border-radius: 4px;
    }
    </style>
    <title>ALL Blogs</title>
</head>

<body>

    <div class="header">
        <a href="./Panel.php" class="logo">BLOGS</a>
        <div class="header-right">
            <a class="active" href="./allBlogs.php">All Blogs</a>
            <a href="./myBlogs.php">My Blogs</a>
            <a href="./addBlogs.php">New Blog</a>
        </div>
    </div>

    <div class="blogsinpage">
        <?php

$stmt = $DB_con->prepare("SELECT * FROM Blogs");
$stmt->execute();
$allBlogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$array = data($allBlogs);

function data($array)
{
    foreach ($array as $key => $val) {

        if (is_array($val)) {
            $formImg = explode("/", $val['format']);

            echo "
            <div class='bolgswidthinpage'>
            <div class='bolgswid'>
            <h1>" . $val['title'] . "</h1>
            <p>" . $val['overview'] . "</p>
            <p>" . $val['content'] . "</p>
            <div>
            <div class='divforimg'>
            <a href='" . $val['path'] . $val['name'] . "' download>
            ";

            if ($val['format'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                echo "<img src='./icons/XLSXicon.png' class='imageBlogsmal'/><br />";
            } else if ($val['format'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation") {
                echo "<img src='./icons/PPTXicon.png' class='imageBlogsmal'/><br />";
            } else if ($val['format'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                echo " <img src='./icons/DOCXicon.png' class='imageBlogsmal'/><br />";
            } else if ($val['format'] == "application/pdf") {
                echo "<img src='./icons/PDFicon.png' class='imageBlogsmal'/><br />";
            } else if ($val['format'] == "application/zip") {
                echo "<img src='./icons/ZIPicon.png' class='imageBlogsmal'/><br />";
            } else if ($formImg[0] == "image") {
                echo "<img src='" . $val['path'] . $val['name'] . "' class='imageBlog'/>";
            }else {echo "<img src='./icons/ERRicon.png' class='imageBlog'/>";}

            echo "
            </a>
            </div>
            <span class='nameFile'>" . $val['name'] . "</span><br />
            <span class='formatFile'>" . $val['format'] . "</span><br />
            <span class='sizeFile'>" . $val['size'] . " kB</span><br />
            </div>
            <span class='dateFile'>" . $val['datePublish'] . "</span>
            </div>
            </div>
            ";
        }
    }
}
?>
    </div>
</body>

</html>