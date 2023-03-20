<nav class="navbar navbar-light bg-light p-3" style="background-color: #dfe6ee !important;">
    <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="" />
        Word Per Minute - Calculator
    </a>
    <div class="">
        <?php if (isset($_SESSION['user_session'])) { ?>
            <span class="navbar-text mx-3 text-capitalize">
                <a href="index.php"> <i class="fa fa-home"></i> Home </a>
            </span>
        <?php } ?>
        <span class="navbar-text mx-3 text-capitalize">
            <a href="learn.php"> <i class="fas fa-chalkboard-teacher"></i> Learn </a>
        </span>
        <span class="navbar-text mx-3 text-capitalize">
            <a href="works.php"> <i class="fas fa-briefcase"></i> How Its Works </a>
        </span>
        <?php if (isset($_SESSION['user_session'])) { ?>
            <span class="navbar-text text-capitalize">
                <a href="logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
            </span>
        <?php } ?>
    </div>
</nav>