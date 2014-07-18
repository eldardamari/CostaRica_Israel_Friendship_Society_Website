<?php
    include_once 'control_panel_functions.php';
    securedSessionStart();

    if (isset($_POST['username'], $_POST['encryptedPassword'])) {
        $user = $_POST['username'];
        $pass = $_POST['encryptedPassword']; // The hashed password.

        if (login($user, $pass) == true) {
            // Login success
            header('Location: ../panel.php');
        } else {
            // Login failed
            header('Location: ../login.php?error');
        }
    }