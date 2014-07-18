<?php
    include 'db_connection.php';
    include 'email.php';

    /**
     * wrap the session_start() of php in a more secured way
     * the session is simultaneously regenerates
     */
    function securedSessionStart() {
        $sessionName = 'controlPanel';

        // For Development
        $secure = false;

        // This stops JavaScript being able to access the session id.
        $httpOnly = true;

        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../panel.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }

        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params(  $cookieParams["lifetime"],
                                    $cookieParams["path"],
                                    $cookieParams["domain"],
                                    $secure,
                                    $httpOnly);

        // Sets the session name to the one set above.
        session_name($sessionName);
        session_start();            // Start the PHP session
        session_regenerate_id();    // regenerated the session, delete the old one.
    }

    function login($username, $pass) {
        $con = makeConnection();

        $query = "SELECT id, password, salt
                  FROM secure_login
                  WHERE username = :username";

        try {
            $statement = $con->prepare($query);
            $statement->bindParam(':username', $username);

            $statement->execute();

            $statement->bindColumn('id',$user_id);
            $statement->bindColumn('password',$password);
            $statement->bindColumn('salt',$salt);

            $statement->fetch();

            // hash the password with the unique salt.
            $hashedPassword = hash('sha512', $pass . $salt);

            if($statement->rowCount() == 1) {

                if (checkForBruteForceAttack($user_id) == true) {
                    sendErrorToAdmin("control_panel_functions.php - Brute Force Alert","There where too many attempts to login by user - $user_id");

                } else {

                    if ($password === $hashedPassword) {
                        // Password is correct!

                        $user_browser = $_SERVER['HTTP_USER_AGENT'];

                        // for future use
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $_SESSION['user_id'] = $user_id;
                        $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
                        $_SESSION['username'] = $username;

                        $_SESSION['login_string'] = hash('sha512',$password . $user_browser);

                        // Login successful.
                        return true;

                    } else {
                        // Password is not correct
                        // Record this attempt in the database
                        $now = time();
                        $query = "INSERT INTO login_attempts (user_id, time)
                                  VALUES (:user_id, :time)";

                        $statement = $con->prepare($query);
                        $statement->bindParam(':user_id', $user_id);
                        $statement->bindParam(':time', $now);

                        $statement->execute();

                        return false;
                    }
                }
            }

        } catch ( PDOException $e) {
            sendErrorToAdmin("control_panel_functions.php - DB ERROR: $e->getCode()",$e->getMessage());
        }

        echo 'could not login... please contact admin!';
        return false;
    }

    function checkForBruteForceAttack($user_id) {
        $con = makeConnection();

        // Get timestamp of current time
        $now = time();

        // All login attempts are counted from the past 1 hour.
        $recently_attempts = $now - (1 * 60 * 60);
                                // 1 hours : 60 min : 60 sec

        $query = "SELECT time
                  FROM login_attempts
                  WHERE user_id = :id
                  AND time > :attempts";

        try {
            $statement = $con->prepare($query);
            $statement->bindParam(':id', $user_id);
            $statement->bindParam(':attempts', $recently_attempts);

            $statement->execute();

            if($statement->rowCount() > 5)
                return true;

        } catch (PDOException $e) {
            sendErrorToAdmin("control_panel_functions.php - DB ERROR: $e->getCode()",$e->getMessage());
        }

        return false;
    }

    function loggedIn() {

        if (isset(  $_SESSION['user_id'],
                    $_SESSION['username'],
                    $_SESSION['login_string'])) {

            $con = makeConnection();

            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];

            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            $query = "SELECT password
                      FROM secure_login
                      WHERE id = :id";

            try {
                $statement = $con->prepare($query);
                $statement->bindParam(":id",$user_id);
                $statement->execute();

                $statement->bindColumn('password',$password);
                $statement->fetch();

                if($statement->rowCount() == 1) {

                    $login_check = hash('sha512', $password . $user_browser);

                    if ($login_check == $login_string) {
                        // Logged In!!!!
                        return true;
                    }
                }

            } catch (PDOException $e) {
                sendErrorToAdmin("control_panel_functions.php - DB ERROR: $e->getCode()",$e->getMessage());
            }
        }

        // Not logged in
        return false;
    }

