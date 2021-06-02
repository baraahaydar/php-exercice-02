<?php
require_once 'Dbconfig.php';

if ($user->is_loggedin() != "") {
    $user->redirect('Panel.php');
}

if (isset($_POST['btn-signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $error[] = "provide username !";
    } else if ($email == "") {
        $error[] = "provide email id !";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Please enter a valid email address !';
    } else if ($password == "") {
        $error[] = "provide password !";
    } else if (strlen($password) < 1) {
        $error[] = "Password must be atleast 6 characters";
    } else {
        try
        {
            $stmt = $DB_con->prepare("SELECT username, email FROM users WHERE username=:username OR email=:email");
            $stmt->execute(array(':username' => $username, ':email' => $email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['username'] == $username) {
                $error[] = "sorry username already taken !";
            } else if ($row['email'] == $email) {
                $error[] = "sorry email id already taken !";
            } else {
                if ($user->register($username, $email, $password)) {
                    $user->redirect('SignUp.php?joined');
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style.css">
    <title>Sign up</title>
</head>

<body>
    <a href="Home.php" class="homebtn">
        < Back</a>
            <div>
                <div>

                    <form method="post">
                        <div class="container">
                            <h1>CREATE ACCOUNT.</h1>
                            <p>Please fill your information.</p>
                            <hr />

                            <?php if (isset($error)) {foreach ($error as $error) {?>

                            <div>
                                <p> <?php echo $error; ?> </p>
                            </div>

                            <?php }} else if (isset($_GET['joined'])) {?>

                            <div>
                                <p> Successfully registered <a href='Login.php'>login</a> here </p>
                            </div>

                            <?php }?>


                            <div>

                                <label for="user"><b>Username</b></label>
                                <input type="text" placeholder="Enter Username" name="username" id="user"
                                    value="<?php if (isset($error)) {echo $username;}?>" required />

                                <label for="email"><b>Email</b></label>
                                <input type="email" placeholder="Enter Your Email" name="email" id="email"
                                    value="<?php if (isset($error)) {echo $email;}?>" required />

                                <label for="pass"><b>Password</b></label>
                                <input type="password" placeholder="Enter Password" name="password" id="pass"
                                    required />

                                <label for="confirmpass"><b>Confirm Password</b></label>
                                <input type="password" placeholder="Confirm Password" name="confirmpass"
                                    id="confirmpass" required />

                            </div>
                            <hr />

                            <button type="submit" name="btn-signup" class="registerbtn">
                                Register
                            </button>

                            <p class="new1">Already have an account? <a href="Login.php">Login</a>.</p>

                        </div>

                    </form>

                </div>
            </div>

</body>

</html>