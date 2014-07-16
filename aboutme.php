<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/aboutme.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <?php require './con_util.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">
            <div class="pictureWithInfo">
                <?php
                    $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

                    if($id) {
                        $con;
                        set_con($con);

                        if($query = $con->prepare(
                            "SELECT id , name , title , pic_path , aboutme_text
                            FROM aboutme NATURAL JOIN members
                            WHERE id=?")) {

                        $query->bind_param("i",$id);
                        $query->execute();
                        $query->bind_result($id_col,$name,$title,$pic_path,$text);
                        $query->fetch();

                        if(!$id_col) {
                            echo "Members is not found in db... please contact admin!";
                            exit();
                        }

                        echo   '<span class="myPic"><img id="profilePic" src="./img/members/' . $pic_path .'"
                                    alt="Stuff Pfofile Picture" width="150" height="200">
                                </span>
                                <span class="myHeaderInfo">
                                    <h2 class="myName"> ' . $name . ' </h2>
                                    <span class="myJob">
                                        <p class="pMyjob"> ' . $title . ' </p>
                                    </span>
                                </span>
                                </div>
                                <span class="myMainInfo">
                                    <p class="pMyMainInfo"> ' . $text . ' </p>
                                <span>';

                        } else {
                            printf("problem with statemt..: \n");
                            exit();
                        }

                    } else {
                        printf("Argument is missing..: \n");
                        exit();
                    }
                ?>

            </div>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
