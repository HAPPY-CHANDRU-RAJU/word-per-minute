<?php
ob_start();
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user_session'])) {
    header("Location: login.php");
    exit;
}
global $conn;
$emid = $_SESSION['user_session'];

$sql1 = "SELECT * FROM `userDetails` WHERE `userId`='$emid'";
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
    <link rel="icon" href="assets/img/logo.png">
    <title>WPM - Home Page</title>
</head>

<body>
    <?php require('navbar.php'); ?>
    <br />
    <div class="container">
        <div class="row">
            <div class="alert col-sm-12 alert-info alert-dismissible  show">
                <h3 class="text-success">
                    Welcome,
                    <?php echo strtoupper($SP_User["userName"]); ?> !
                </h3>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 p-4 my-3" style="background-color: #dfe6ee;box-shadow: 0px 3px 4px 0px black;">
                <span class="timer-span">
                    <p class="text-danger" id="timer"></p>
                </span>
                <button class="btn btn-danger float-right  mx-2" id="resetBtn" name="btn">
                    <i class="fas fa-sync-alt"></i> RESET</button>
                <button class="btn btn-success float-right mx-2 " id="startBtn" name="btn"><i
                        class="far fa-play-circle"></i> START </button>
                <button class="btn btn-warning float-right  mx-2" id="stopBtn" style="display: none;" name="btn"> <i
                        class="fas fa-stop-circle"></i>STOP</button>
            </div>
            <div class="col-sm-12" style="display: flex;">
                <div class="col-sm-6">
                    <label></label>
                    <div id="questionSection" class="editor question"></div>
                </div>
                <div class="col-sm-6">
                    <label class="font-weight-bold"> Type Below <i class="fas fa-hand-point-down"></i></label>
                    <div id="typingSection" class="editor typing" contenteditable="true" onkeypress="CallBoth(event)"
                        style="">
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row" style="display: block;">
            <h1>FAQ</h1>
            <br />
            <?php require('faq.php'); ?>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        $("#resetBtn").click(function () {
            StopTime();
            currWord = 0;
            currIndex = 0;
            numErrors = 0;
            space = 0;
            errorLib = [];
            errorArray = [];
            seconds = 0;
            stopped = 0;

            $("#typingSection").empty(); //clear the text area
            tempWords = genWords(50); //get new words for tempWords
            wordLib = []; //empty the 2D char array
            wordLib = genLib(); //refill the 2D char array
            wordLen = genWordLen(tempWords);
            genParagraph(); //display the paragraph
            $("#timer").empty(""); //clear the timer
            seconds = 0;
            timer = 0;
            document.getElementByClassName("timer").innerHTML = "";
            $("#stopBtn").css("display", "none");
            $("#startBtn").css("display", "block");
        });

        $("#startBtn").click(function (event) {
            CallBoth(event)
            if (seconds >= 0) {
                $("#startBtn").css("display", "none");
                $("#stopBtn").css("display", "block");
            }
        })

        $("#stopBtn").click(function (event) {
            StopTime();
            $("#startBtn").css("display", "block");
            $("#stopBtn").css("display", "none");
        })
    </script>
</body>

</html>
<?php ob_flush(); ?>