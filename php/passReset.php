<?php
    session_start();
    if (isset($_SESSION['reset']) && $_SESSION['reset'] == true){
        ?>
            <form action="auth.php" method="post">
                <label for="usrname">Username</label>
                <input type="text" name="usrname" id="usrname" value="<?php echo $_GET['login']; ?>" readonly>
                <label for="passwd">Password</label>
                <input type="text" name="passwd" id="passwd">
                <input type="hidden" name="submit" value="Reset">
                <input type="submit" value="Reset">
            </form>
        <?php
        unset($_SESSION['reset']);
    }
?>