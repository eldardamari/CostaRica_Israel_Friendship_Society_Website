<?php

    function getAdminMail() {
        return "costarica.israel.association@gmail.com";
    }

    function getAssociationMail() {
        /*return "costarica.isr@gmail.com";*/
        return "test_need_to_chgne@rgmail.com";
    }

    function getMailHeaders($email) {

        return  'From: Costa-Rica Israel Association <'.getAssociationMail().'> ' . "\r\n" .
                'Reply-To: '.$email. "\r\n" .
                'Content-Type: text/html; charset=utf-8 '    . "\r\n";
    }
    
    function printUnsubscribeMsg() {

        return '<div style="text-align: center; font-size: 65%; 
                            font-weight: 200; color: #348017;">
                        To stop receiving this content click: 
                            <a href=/costaRicaIsrael/unsubscribe.php target="_blank"><u>Unsubscribe</u></a> </div>';
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
        return mail($email, $subject, $content, getMailHeaders(getAssociationMail()));
    }

    function sendMailToMember($memberEmail, $subject, $content, $fromEmail) {
        $replyInfo = "\n\n\te-mail to reply sender: $fromEmail";

        $content =  '<html><body>'.
                '   <div style="text-align: left; font-size: 200%; font-weight: 550; color: #348017;">
                    Hi, you have received a private message:</div><br>
                             <div>
                    <table width=80% align="center" style="border-style:solid; border-width:medium; border-color:#E8E8E8;"> <tr> <td>
                        <div style="text-align: left; font-size: 100%; font-weight: 225;">
                            <p><b><u>Summary</u></b></p></div>
                        <ul>
                            <li><p><b>From:</b> '.$fromEmail.'</p></li>'.
                            '<li><p><b>Subject:</b> '.$subject.'</p></li>'.
                            '<li><p><b>Message:</b> '.$content.'</p></li>'.
                            '<li><p><b>Click to Reply:</b> 
                            <a href="mailto:'.$fromEmail.'?Subject=Re: '.$subject .' target="_top"> Click Here</a> </p></li><br>'.
                        '</ul>'.
                        '</td></tr>
                        <tr> <td> '.printUnsubscribeMsg().'  </td> </tr>
                        </table></div></body></html>';

        echo $content;
        /*return mail($memberEmail, $subject, $content.$replyInfo, "From: $fromEmail\r\nReply-To: $fromEmail\r\n");*/
        return mail($memberEmail, $subject, $content,  getMailHeaders($fromEmail));
    }

    function sendErrorToAdmin($subject,$message) {
        $adminEmail = getAdminMail();
        /*return mail($adminEmail, $subject, $message, "From: $adminEmail\r\n");*/
        return mail($adminEmail, $subject, $message, getMailHeaders(getAdminMail()));
 
    }
