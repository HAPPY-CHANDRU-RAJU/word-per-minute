<?php
ob_start();
session_start();
require_once 'dbconnect.php';

if (isset($_SESSION['user_session'])) {
    header("Location: index.php");
    exit;
}

$error = false;

if (isset($_POST['btn-login'], $_POST['token'])) {
    if (validate_token($_POST['token'])) {

        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);

        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);

        if (empty($pass) || (strlen($pass) < 6)) {
            $error = TRUE;
            $passError = "Please Enter Password <sub> ( Min 6 Characters ) </sub>";
        }

        if (emailVerify($email)) {
            $error = TRUE;
            $emailError = "Please Check E-mail Id";
        }

        if (!$error) {

            $password = hash('sha256', $pass);
            $sql = "SELECT * FROM `HRMSCredentials` WHERE `AdminMail`='$email';";
            $res = $conn->prepare($sql);
            $res->execute();
            $row = $res->fetch();

            if ($res->rowCount() == 1 && $row['AdminPassword'] == $password) {
                if ($row['AdminStatus'] == 'ACTIVE') {
                    $_SESSION['admin_session'] = $row['AdminID'];
                    header("Location: " . $HOME_PATH);
                } else {
                    $stat = "info";
                    $errMSG = "Please contact your Admin ";
                }
            } else {
                $stat = "danger";
                $errMSG = "Incorrect Credentials, Try again...";
            }
        }
    }
}

?>
<!DOCTYPE>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js">
    </script>
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="assets/image/logo-sq.png">
    <title>Login - WPM
    </title>
    <style>
    body {
        color: #999;
        background: rgb(18, 237, 248);
        background: -moz-linear-gradient(90deg, rgba(18, 237, 248, 1) 0%, rgba(29, 227, 247, 1) 35%, rgba(35, 208, 248, 1) 50%, rgba(36, 204, 248, 1) 53%, rgba(38, 198, 248, 1) 58%, rgba(44, 179, 249, 1) 73%, rgba(48, 167, 249, 1) 100%);
        background: -webkit-linear-gradient(90deg, rgba(18, 237, 248, 1) 0%, rgba(29, 227, 247, 1) 35%, rgba(35, 208, 248, 1) 50%, rgba(36, 204, 248, 1) 53%, rgba(38, 198, 248, 1) 58%, rgba(44, 179, 249, 1) 73%, rgba(48, 167, 249, 1) 100%);
        background: linear-gradient(90deg, rgba(18, 237, 248, 1) 0%, rgba(29, 227, 247, 1) 35%, rgba(35, 208, 248, 1) 50%, rgba(36, 204, 248, 1) 53%, rgba(38, 198, 248, 1) 58%, rgba(44, 179, 249, 1) 73%, rgba(48, 167, 249, 1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#12edf8", endColorstr="#30a7f9", GradientType=1);
        background-size: cover;
        height: 100%;
    }
    </style>
</head>

<body style="">
    <nav class="navbar navbar-light bg-light p-3">
        <a class="navbar-brand" href="#">
            <img src="assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="" />
            Word Per Minute - Calculator
        </a>
    </nav>
    <div class="row">
        <div class="login-form">
            <form action="<?php echo $LOGIN_PATH; ?>" method="post">
                <?php
                if (isset($errMSG)) {
                    ?>
                <div class="form-group">
                    <div class="alert alert-<?php echo $stat; ?>">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        <?php echo $errMSG; ?>
                    </div>
                </div>
                <?php
                }
                ?>
                <img src="assets/img/logo.png" style="height: 50px;margin-bottom: 15px;" />

                <div class="form-group">
                    <div class="input-group">
                        <!-- <span class="input-group-addon"><span class="fa fa-envelope"></span></span> -->
                        <input type="email" name="email" class="form-control login-field" placeholder="Your Email"
                            value="<?php echo $email; ?>" maxlength="40" required />
                    </div>
                    <span class="text-danger xs-font">
                        <?php echo $emailError; ?>
                    </span>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <!-- <span class="input-group-addon"><span class="fa fa-lock"></span></span> -->
                        <input type="password" name="pass" class="form-control login-field" placeholder="Your Password"
                            maxlength="15" required />
                    </div>
                    <span class="text-danger xs-font">
                        <?php echo $passError; ?>
                    </span>
                </div>
                <button type="button" class="btn btn-lg btn-success btn-login " name="btn-login">LOG IN
                </button>
            </form>

        </div>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>