<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>About us</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/aboutme.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./js/aboutme.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">
            <div class="pictureWithInfo">
                <?php
                    $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

                    if($id) {
                        $con = makeConnection();

                        $sql = "SELECT id , name , title , pic_path , aboutme_text
                                FROM aboutme NATURAL JOIN members
                                WHERE id=:id";

                        try {
                            $statement = $con->prepare($sql);

                            $statement->bindParam(":id",$id);
                            $statement->execute();

                            $statement->bindColumn('id',$id_col);
                            $statement->bindColumn('name',$name);
                            $statement->bindColumn('title',$title);
                            $statement->bindColumn('pic_path',$pic_path);
                            $statement->bindColumn('aboutme_text',$text);
                            $statement->fetch();

                            if(!$id_col) {

                                $sent = sendErrorToAdmin("aboutme.php - id: $id_col was not found: ", "");
                                echo "Members is not found in db... please contact admin!";

                            } else {
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
                                        <div class="myMainInfo">
                                        <p class="pMyMainInfo"> ' . str_replace("\n","<br>",$text) . ' </p>

                                        </div>';
                            }

                        } catch (PDOException $e) {

                            $sent = sendErrorToAdmin("aboutme.php - DB ERROR: " . $e->getCode(), $e->getMessage());
                            echo "problem with statemt..: <br>";

                        }

                    } else {
                        echo "Argument is missing..: <br>";
                    }
                ?>

            </div>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
