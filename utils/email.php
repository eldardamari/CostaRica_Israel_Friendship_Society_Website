<?php

date_default_timezone_set('Israel');
set_include_path(dirname(__FILE__)."/../");
require_once 'PHPMailer/PHPMailerAutoload.php';

    function set_connection() {

        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //hebrew char set
        $mail->CharSet = 'UTF-8';

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "costaricaisraelassociation@gmail.com";

        //Password to use for SMTP authentication
        $mail->Password = "euxyvrhev";

        return $mail;
    }

    function getAdminMail() {
        return "costarica.israel.association@gmail.com";
    }

    function getAssociationMail() {
        /*return "costarica.isr@gmail.com";*/
        return "test_need_to_chgne@rgmail.com";
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

        $mail = set_connection();
        $mail->setFrom(getAssociationMail(), getAssociationMail());
        $mail->addAddress($email, '');
        $mail->Subject = "Welcome To Costa-Rica Israel Friendship Association";


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
                            '</td></tr>
                    <tr> <td> '.printUnsubscribeMsg().'  </td> </tr>
                    </table></div></body></html>';

        $mail->msgHTML($content);

        //send the message, check for errors
        if (!$mail->send()) {
            sendErrorToAdmin("sendMailToMember","Mailer Error: " . $mail->ErrorInfo);
            return false;
        } else {
            return true;
        }
    }

    function sendMailToMember($memberEmail, $subject, $content, $fromEmail) {

        $mail = set_connection();
        $mail->setFrom($fromEmail, $fromEmail);
        $mail->addAddress($memberEmail, '');
        $mail->Subject = $subject;

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
                            <a href="mailto:'.$fromEmail.'?Subject=Re: '.$subject .'" target="_top"> Click Here</a> </p></li><br>'.
                        '</ul></td></tr></table></div></body></html>';

        $mail->msgHTML($content);

        //send the message, check for errors
        if (!$mail->send()) {
            sendErrorToAdmin("sendMailToMember","Mailer Error: " . $mail->ErrorInfo);
            return false;
        } else {
            return true;
        }
    }

    function sendErrorToAdmin($subject,$message) {

        $mail = set_connection();
        $mail->setFrom(getAdminMail(), getAdminMail());
        $mail->addAddress(getAdminMail(), '');
        $mail->Subject = $subject;
        $mail->msgHTML($message);

        $mail->send();
    }
    
    // Subscribed users ok msg - fix in page //TODO
    function sendSubscriptionMail($first_name, $email, $type, $file_path) {

        $mail = set_connection();
        $mail->setFrom(getAssociationMail(), getAssociationMail());
        $mail->addAddress($email, '');

        preg_match_all("/\(.*?\)/", $file_path, $matches);
        $catalog = trim(array_pop($matches[0]),"()");
        
        preg_match_all("/\_.*?\_/", get_file_name($file_path), $matches);
        $month = (trim(array_pop($matches[0]),"__"));

        $subject = $month . " '14 (#" .$catalog.") ". $type ." available now! - Costa-Rica Israel Friendship Association";
        $mail->Subject = $subject;

        $content =  '<html><body>'.
                '   <div style="text-align: left; font-size: 200%; font-weight: 550; color: #348017;">
                Hi '.$first_name.', a new <u>'.$type.'</u> is now available, check it out now!</div><br>
                             <div>
                    <table width=80% align="center" style="border-style:solid; border-width:medium; border-color:#E8E8E8;"> <tr> <td>
                        <div style="text-align: left; font-size: 100%; font-weight: 225;">
                            <p><b><u>Summary</u></b></p></div>
                        <ul>
                        <li><p><b>A new:</b> '.$type.'</p></li>'.
                        '<li><p><b>Month:</b> '.$month.'</p></li>'.
                        '<li><p><b>Catalog #:</b> '.$catalog.'</p></li>'.
                        '<li><p><b>File:</b> See attachment below or  
                        <a href="'.realpath(dirname(__FILE__).'/../').'/'.$file_path.'" target="_top"> download file</a> </p></li><br>'.
                        '</ul></td></tr>
                        <tr> <td> '.printUnsubscribeMsg().'  </td> </tr>
                        </table></div></body></html>';

        $mail->addAttachment(realpath(dirname(__FILE__).'/../').'/'.$file_path);
        $mail->msgHTML($content);

        //send the message, check for errors
        if (!$mail->send()) {
            sendErrorToAdmin("sendMailToMember","Mailer Error: " . $mail->ErrorInfo);
            return false;
        } else {
            return true;
        }
    }
    
function get_file_name($full_path) {
    $temp = explode("/", $full_path);
    $file_name = end($temp);
    return substr($file_name,11);
}
