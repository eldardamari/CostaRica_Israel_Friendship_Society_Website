<script src="/costaRicaIsrael/js/nav_bar.js"></script>
<div id="main_header">
    <div id="container_upper">
        <div id="left_box_logo">
            <a href="./"><img id="logo" src="img/logo.png" alt="CR_IL_logo" width="90" height="45"></a>
        </div>
        <a href="./">
            <div id="right_box_text">
                <div id="company_he" dir="rtl"> אגודת ידידות ישראל - קוסטה ריקה </div>
                <div id="company_en" dir="rtl"> Israel - Costa Rica Friendship Association </div>
            </div>
        </a>
    </div>
    <nav>
        <ul>
            <?php
                if (isset($_SESSION['username'])) {
                    echo "<li><strong>Hello ". $_SESSION['username']."!</strong></li>";
            ?>
                <li>
                    <a href="edit_member.php" lang="en">Edit Members</a>
                </li>
                <li>
                    <a href="edit_events.php" lang="en">Edit Events</a>
                </li>
                <li>
                    <a href="edit_meetings.php" lang="en">Edit Meetings</a>
                </li>
                <li>
                    <a href="edit_subscriptions.php" lang="en">Edit Subscriptions</a>
                </li>
                <li>
                    <a href="edit_winners.php" lang="en">Edit Winners</a>
                </li>
                <li>
                    <a href="utils/logout.php" lang="en"><u>Logout</u></a>
                </li>
                <li id="language">
                    <a href="#" onclick="setLanguage('en')"> English </a>
                </li>
            <?php
                } else {
                    echo    '<li><a href="index.php" lang="en">Home</a></li>'.
                            '<li><a href="login.php" lang="en">Login</a></li>';
                }
            ?>
        </ul>
    </nav>
</div>
