<nav class="navbar navbar-light bg-light p-3" style="background-color: #dfe6ee !important;">
    <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="" />
        Word Per Minute - Calculator
    </a>
    <?php
    if (isset($_SESSION['user_session'])) {
        ?>
    <div>
        <span class="navbar-text">
            <a href="logout.php">LOGOUT</a>
        </span>
    </div>
    <?php
    }
    ?>
</nav>