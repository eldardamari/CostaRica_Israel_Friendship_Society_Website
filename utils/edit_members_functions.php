<?php

function get_members_names() {

    $con = makeConnection();
    $query = "SELECT id, name FROM members;";

    $result = prepareAndExecuteQuery($con,$query);
    return $result;
}

function set_variables( &$name, &$email, &$position, &$tel_number, 
                        &$title, &$about_me)

{ // need to sanitaize
    $name           = htmlspecialchars($_REQUEST['full_name']);
    $name           = filter_var($name,FILTER_SANITIZE_STRING);

    $email          = htmlspecialchars($_REQUEST['email']);
    $email          = filter_var($email,FILTER_SANITIZE_EMAIL);
    
    $position       = htmlspecialchars($_REQUEST['position']);
    $position       = filter_var($position,FILTER_SANITIZE_STRING);

    $tel_number     = htmlspecialchars($_REQUEST['mobile']);
    $tel_number     = filter_var($tel_number,FILTER_SANITIZE_NUMBER_INT);

    $title          = htmlspecialchars($_REQUEST['title']);
    $title          = filter_var($title,FILTER_SANITIZE_STRING);
    
    $about_me        = htmlspecialchars($_REQUEST['about_me']);
    $about_me        = filter_var($about_me,FILTER_SANITIZE_STRING);
}

function get_old_user_data($email) 
{
    $con = makeConnection();
    $query = 'SELECT * FROM members
              WHERE email="'.$email.'";';

    $result = prepareAndExecuteQuery($con,$query);

    return $result[0];
}

function get_old_user_data_byID($id) 
{
    $con = makeConnection();
    $query = 'SELECT * FROM members
              WHERE id="'.$id.'";';

    $result = prepareAndExecuteQuery($con,$query);
    return $result[0];
}


function removeMember($userId,$pic_path) {

    $old_pic_name = get_old_user_data_byID($userId)["pic_path"];

    $con = makeConnection();
    $con->beginTransaction();

    try {
        $sql = "DELETE FROM members WHERE id=:id";

        $statement = $con->prepare($sql);
        $statement->bindParam(':id',$userId, PDO::PARAM_INT);
        $statement->execute();

        $sql = "DELETE FROM aboutme WHERE id=:id";

        $statement = $con->prepare($sql);
        $statement->bindParam(':id',$userId, PDO::PARAM_INT);
        $statement->execute();

        $con->commit();

    } catch (PDOException $e) {
        $con->rollback();
        return false;
    }
    unlink($pic_path.$old_pic_name);
    return true;
}





$add_mode   = (isset($_REQUEST['add_member_request'])   ? true : false);
$edit_mode  = (isset($_REQUEST['edit_member_request']) 
            || isset($_REQUEST['edit_member_request'])  ? true : false);


$profile_pic_exist  = false;

$name = $email = $position = $tel_number = $title = $about_me = ""; 
$pic_path   = "/Library/WebServer/Documents/costaRicaIsrael/img/members/";


    if(isset($_POST['deleteMember'])) {
        if(removeMember($_POST['deleteMember'],$pic_path)){
            echo '<p class="form_granted">&emsp;Memeber was removed successfully!
                                        <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';
        } else {
            echo "<p class='text form_error'>&emsp;
            Error: Failed to delete memeber...please try again.";
        }
        goto form;

//        header('refresh:2;url='.$_SERVER['PHP_SELF'].'?0');
    }


        if($add_mode || $edit_mode) {

        if ($_FILES['profile_pic']['error'] != UPLOAD_ERR_NO_FILE) {
            if (!check_file($_FILES["profile_pic"]["name"]))
                goto form;
            $profile_pic_exist = true;
        }
        
         set_variables( $name, $email, $position, $tel_number, 
                        $title, $about_me);
        
        if (spamCheck($email) == false) {
            echo "<p class='text form_error'>&emsp;Invalid email</p>";
            goto form;
        }


    $con = makeConnection();


    if($profile_pic_exist) {
        $pic_name = uniqid('member_').getFileExtension($_FILES["profile_pic"]["name"]);
        if($edit_mode)
            $old_pic_name = get_old_user_data($email)["pic_path"]; 
    }

    $con->beginTransaction();

    try {
        $sql = ($add_mode == true ?
            "INSERT INTO members(name,email,position,tel_number,pic_path)
            VALUES (:name, :email, :position, :tel_number, :pic_path)"
            :
            "UPDATE members 
                SET name        =:name,
                    email       =:email,
                    position    =:position,".
                    ($profile_pic_exist ? 'pic_path     =:pic_path, ' : ' ')."
                    tel_number  =:tel_number
                    WHERE email=:email;");;

        $statement = $con->prepare($sql);

        $statement->bindParam(':name',      $name, PDO::PARAM_STR);
        $statement->bindParam(':email',     $email, PDO::PARAM_STR);
        $statement->bindParam(':position',  $position, PDO::PARAM_STR);
        $statement->bindParam(':tel_number',$tel_number, PDO::PARAM_INT);
        if($profile_pic_exist)
            $statement->bindParam(':pic_path'    ,$pic_name     ,PDO::PARAM_STR);
        $statement->execute();

        if($add_mode)
            $userId = $con->lastInsertId();

        $sql = ($add_mode == true ?
            'INSERT INTO aboutme(id,title,aboutme_text)
            VALUES (:id, :title, :about_me);'
        :
            "UPDATE aboutme
                SET title           =:title,
                    aboutme_text    =:about_me 
                    WHERE id=:id;");;
 
        $statement = $con->prepare($sql);

        if($add_mode)
            $statement->bindParam(':id',    $userId, PDO::PARAM_INT);
        if($edit_mode) {
            $statement->bindParam(':id',    get_old_user_data($email)["id"], PDO::PARAM_INT);
        }

        $statement->bindParam(':title',     $title, PDO::PARAM_STR);
        $statement->bindParam(':about_me',  $about_me, PDO::PARAM_STR);
        $statement->execute();


        $con->commit();

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "<p class='text form_error'>&emsp;
            The e-mail: $email is already subscribed</p>";
        } else {
            echo "<p class='text form_error'>&emsp;
            #1 Failed updating database..please try again.";
        }
        $con->rollback();
        goto form;
    }

    $sql_verify = "SELECT email FROM members WHERE email=:email";
    try {
        $statement_verify = $con->prepare($sql_verify);
        $statement_verify->bindParam(':email', $email, PDO::PARAM_STR);
        $statement_verify->execute();
        $result = $statement_verify->fetchAll();

        // check if insert sucsseced
        if ($result[0]["email"] == $email) {

            if($profile_pic_exist) {
                unlink($pic_path.$old_pic_name);

                try {
                    if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$pic_path.$pic_name)) {
                        throw new Exception('Could not move file');
                    }
                } catch (Exception $e) {
                    echo "<p class='text form_error'>&emsp;
                    Error moving profile pic file.. please try again</p>";
                    goto form;
                }
            }

        } else {

            echo "<p class='text form_error'>&emsp;Failed
                updating database..  please check if
                email address is not used by other member.";
                goto form;
        }

    } catch (PDOException $e) {
        var_dump($e->getMessage());
        echo "<p class='text form_error'>&emsp;#3
            Failed updating database..please try again.";
        goto form;
    }

        echo '<p class="form_granted">&emsp;Memeber '.($add_mode ? 'added' : 'edited').' successfully!
            <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';
        }
form:
