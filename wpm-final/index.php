<?php
ob_start();
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user_session'])) {
  header("Location: login.php");
  exit;
}

$emid = $_SESSION['user_session'];

$ql1 = "SELECT * FROM `userDetails` WHERE `userId`='$emid'";
$res1 = $conn->prepare($sql1);
$res1->execute();
$SP_User = $res1->fetch();

?>
<!DOCTYPE html>
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
    <link rel="icon" href="assets/image/logo.png">
    <title>Login - </title>
</head>


<body>
    <?php require('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="">
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
                    <img src="assets/image/logo-rct.png" style="height: 50px;margin-bottom: 15px;" />

                    <div class="form-group">
                        <div class="input-group">
                            <!-- <span class="input-group-addon"><span class="fa fa-envelope"></span></span> -->
                            <input type="email" name="email" class="form-control" placeholder="Your Email"
                                value="<?php echo $email; ?>" maxlength="40" required />
                        </div>
                        <span class="text-danger xs-font">
                            <?php echo $emailError; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <!-- <span class="input-group-addon"><span class="fa fa-lock"></span></span> -->
                            <input type="password" name="pass" class="form-control" placeholder="Your Password"
                                maxlength="15" required />
                        </div>
                        <span class="text-danger xs-font">
                            <?php echo $passError; ?>
                        </span>
                    </div>
                    <div class="form-group small clearfix">
                        <label class="checkbox-inline"><input type="checkbox"> Remember me</label>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <input type="hidden" name="token" value="<?php echo _token(); ?>" />
                    <button type="submit" class="btn btn-primary btn-block btn-lg btn-login" name="btn-login">LOG IN
                    </button>
                    <p class="login-footer  ">
                        Copyrights &copy; All Rights Reserved<br><a href="#"><b>
                                <?php echo $APP_NAME; ?> 2022
                            </b></a>
                    </p>
                </form>

            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>

</html>
<?php ob_flush(); ?>