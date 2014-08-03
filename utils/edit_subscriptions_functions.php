<?php

function removeDocument($documentPath,$table) {

    $splitPath = explode("/", $documentPath);
    end($splitPath);
    $contest_num = prev($splitPath);

    $file_name = end($splitPath);
    $result = false;

    $con = makeConnection();
    $query = "DELETE FROM ".$table." 
            WHERE file_name=:file_name";

    try {
        $statement = $con->prepare($query);
        $statement->bindParam(':file_name' ,$file_name  ,PDO::PARAM_STR);
        $statement->execute();

        $file = glob($documentPath);
        if($file != null)
        $result = unlink($file[0]);
        return true;

    } catch (PDOException $e) {
        return false;
    }
}

function set_variables(&$type, &$year, &$month, &$catalog)
{
    $type   = htmlspecialchars($_REQUEST['subscription']);
    $type   = filter_var($type,FILTER_SANITIZE_STRING);

    $year   = htmlspecialchars($_REQUEST['year']);
    $year   = filter_var($year,FILTER_SANITIZE_NUMBER_INT);

    $month  = (int)htmlspecialchars($_REQUEST['month']);
    $month  = filter_var($month,FILTER_SANITIZE_NUMBER_INT);
    
    $catalog  = htmlspecialchars($_REQUEST['catalog']);
    $catalog  = filter_var($catalog,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
}

function uploading_document($type, $year, $month, $file_path, $file_name, &$file_full_path)
{
        $file_full_path =  $file_path.'/'.$file_name;
        if (!move_uploaded_file($_FILES["uploaded_document"]["tmp_name"],$file_full_path)) {
            throw new Exception('Could not move file');
        }
}

function execute_query(&$con, &$sql, $year, $month, $catalog, $file_name)
{

    $statement = $con->prepare($sql);

    $statement->bindParam(':year'       ,$year      ,PDO::PARAM_INT);
    $statement->bindParam(':month'      ,$month     ,PDO::PARAM_INT);
    $statement->bindParam(':catalog'    ,$catalog   ,PDO::PARAM_INT);
    $statement->bindParam(':file_name'  ,$file_name ,PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

function sendEmails($file_path, $table) {

    $con = makeConnection();
    $query = "SELECT first_name , email FROM subscription 
                WHERE ".$table." = 1";

    $result = prepareAndExecuteQuery($con,$query);
    $failed = array();

    foreach($result as $data) {
        if(!sendSubscriptionMail($data["first_name"],$data["email"],$table,$file_path))
            array_push($failed,$data["email"]);
    }
    return true;
}

$add_mode   = (isset($_REQUEST['add_subscription_request'])   ? true : false);
$edit_mode  = (isset($_REQUEST['edit_subscription_request']) 
            || isset($_REQUEST['edit_subscription_request'])  ? true : false);

$type = $year = $month = $catalog = "";
$file_full_path = "";

    //send emails
    if(isset($_POST['sendMail'])) {
        if(sendEmails($_POST['sendMail'],$_POST['subscription'])) {
                $edit_mode = true;
                echo "<p class='form_granted email_sent'> Success, email send successfully!</p>";
            goto form;
        }
        else
            echo "<p class='form_error'> Failed to send emails...plase try again </p>";
        goto form;
    }

    //delete document
    if(isset($_POST['deletePhoto'])) {
        if(removeDocument($_POST['deletePhoto'],$_POST['subscription'])) {
                $edit_mode = true;
                echo "<p class='form_granted'> Success, document was removed</p>";
            goto form;
        }
        else
            echo "<script>alert('Failure, could not delete photo');</script>";
        goto form;
    }

    //add documents
    if($add_mode || $edit_mode) {

        if ($_FILES['uploaded_document']['error'] != UPLOAD_ERR_NO_FILE) {
            if (!check_document("uploaded_document"))
                goto form;
        }



        set_variables($type, $year, $month, $catalog);

        $con = makeConnection();
        $num_of_pictures_in_db = 0;


        $file_name = $type .'_' .$year .'_' .get_month($month) .'_('. $catalog .')'. getFileExtension($_FILES["uploaded_document"]["name"]);
        $file_path   = "img/documents/".$type;
//        $file_path   = "/Library/WebServer/Documents/costaRicaIsrael/img/documents/".$type;

        try {
            try {
            uploading_document($type, $year, $month, $file_path, $file_name, $file_full_path);

            } catch (Exception $e) {
                echo "<p class='text form_error'>&emsp;
                Error moving document file.. please try again</p>";
                goto form;
            }

        $sql = ($add_mode == true ?
            "INSERT INTO 
            ".$type." (year, month, catalog, file_name)
             VALUES (:year, :month, :catalog, :file_name);" 
             :
             "");
        try {

            execute_query($con, $sql, $year, $month, $catalog, $file_name);

        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "<p class='text form_error'>&emsp;
                Error: duplicate data in databse, please check for correct input.<br>
                    - Try insert catalog number with . (i.e 4 -> 4.1 )<br>
                    - Or delete document from Edit Subscription option.</p>";
            } else {
                echo "<p class='text form_error'>&emsp; 
                INSET mode Failed updating database..please try again.";
            }

            // Remove document
            unlink($file_full_path);
            goto form;
        }

        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "<p class='text form_error'>&emsp;
                The Publish is already subscribed, use EDIT to change winner's data.</p>";
            } else {
                echo "<p class='text form_error'>&emsp; 
                Failed updating database..please try again.";
            }
            goto form;
        }

        echo '<p class="form_granted document_added">&emsp;'.$type . ' ' .($add_mode ? 'added' : 'edited').' successfully!
            <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';
        }
    form:
