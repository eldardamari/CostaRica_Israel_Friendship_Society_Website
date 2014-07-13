<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/aboutme.css">
    <?php require './con_util.php' ?>

    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
</head>

<body>

    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

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


                echo '<span class="myPic"><img id="profilePic" src="./img/' . $pic_path .'"
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
                        <span>


                </div>
            </div> ';

                } else {
                    printf("problem wit statemt..: \n");
                    exit();
                }
                } else {
                    printf("Argument is missing..: \n");
                    exit();
                }
?>

    <script src="/costaRicaIsrael/js/footer.js"></script>

</body>
</html>
