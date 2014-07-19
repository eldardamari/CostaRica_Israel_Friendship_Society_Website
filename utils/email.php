<?php

    function getAdminMail() {
        return "costarica.israel.association@gmail.com";
    }

    function spamCheck($field) {
        // Sanitize e-mail address
        $field=filter_var($field, FILTER_SANITIZE_EMAIL);

        // Validate e-mail address
        if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function sendWelcomeMail($email, $firstName, $lastName, $subscribed) {
        $subject = "Welcome To Costa-Rica Israel Friendship Association";

        $content =  '<html><body>'.
                    '<div style="text-align: center; font-size: 300%; font-weight: 900; color: rgba(65,110,225,0.9);">
                        Welcome To Costa-Rica Israel Friendship Association </div> <br> <hr>
                        <div style="text-align: center; font-size: 200%; font-weight: 550; color: #348017;">
                             You have been subscribed successfully!</div>
                             <div>
                    <table width=80% align="center" style="border-style:solid; border-width:medium; border-color:#E8E8E8;"> <tr> <td>
                        <div style="text-align: left; font-size: 100%; font-weight: 225;">
                            <p><b><u>Summary</u></b></p></div>
                        <ul>
                    <li><p><b>First name:</b> '.$firstName.'</p></li>'.
                    '<li><p><b>Last name:</b> '.$lastName.'</p></li>'.
                    '<li><p><b>E-Mail:</b> '.$email.'</p></li>'.
                    '<li><p><b>Subscribed for:</b>&emsp;'.$subscribed.'</p></li>'.
                    '</ul>'.
                    '</td></tr></table></div></body></html>';

        $adminEmail = getAdminMail();
        $sent = mail($email, $subject, $content, "From: $adminEmail\r\nContent-Type: text/html; charset=ISO-8859-1\r\n");

        return $sent;
    }

    function sendMailToMember($memberEmail, $subject, $content, $fromEmail) {
        $replyInfo = "\n\n\te-mail to reply sender: $fromEmail";
        $sent = mail($memberEmail, $subject, $content.$replyInfo, "From: $fromEmail\n");
    }

    function sendErrorToAdmin($subject,$message) {
        $adminEmail = getAdminMail();
        return mail($adminEmail, $subject, $message, "From: $adminEmail\n");
    }
