<?php
    include_once 'control_panel_functions.php';
    securedSessionStart();

    function searchDir($base_dir, $p="", $allowed_depth=-1) {

        $f = "folder,jpg,png,gif,bmp,jpeg,tiff";

        if(loggedIn()) {

            $contents = array();

            $base_dir = trim($base_dir);
            $p = trim($p);
            $f = trim($f);

            if($base_dir == "")
                $base_dir="img";

            if(substr($base_dir, -1) != "/")
                $base_dir.="/";

            $p = str_replace(array("../","./"), "", trim($p,"./"));
            $p = $base_dir.$p;

            if(!is_dir($p))
                $p = dirname($p);

            if(substr($p,-1) != "/")
                $p .= "/";

            if($allowed_depth > -1) {
                $allowed_depth = count(explode("/", $base_dir)) + $allowed_depth-1;
                $p = implode("/",array_slice(explode("/", $p), 0, $allowed_depth));

                if(substr($p,-1) != "/")
                    $p.="/";
            }

            $filter = ($f == "") ? array() : explode(",", strtolower($f));

            $files = @scandir($p);

            if(!$files)
                return array("contents"=>array(), "currentPath"=>$p);

            for ($i=0 ; $i < count($files) ; $i++) {
                $fName = $files[$i];
                $fPath = $p.$fName;

                $isDir = is_dir($fPath);
                $add = false;
                $fType = "folder";

                if(!$isDir) {
                    // file is an image
                    $ft = strtolower(substr($files[$i],strrpos($files[$i],".")+1));
                    $fType = $ft;
                    if($f != "") {
                        if(in_array($ft, $filter)) $add=true;

                    } else {
                        $add = true;
                    }

                } else {
                    // file is a directory
                    if($fName == ".")continue;
                    $add = true;

                    if($f != "") {
                        if(!in_array($fType,$filter)) $add=false;
                    }

                    if($fName == "..") {
                        if($p == $base_dir)
                            $add = false;
                        else
                            $add = true;

                        $tempar = explode("/",$fPath);
                        array_splice($tempar,-2);
                        $fPath = implode("/",$tempar);

                        if(strlen($fPath) <= strlen($base_dir))
                            $fPath="";
                    }
                }

                if($fPath != "")
                    $fPath = substr($fPath, strlen($base_dir));
                if($add)
                    $contents[] = array("fPath"=>$fPath, "fName"=>$fName, "fType"=>$fType);
            }

            $p = (strlen($p) <= strlen($base_dir))? $p="" : substr($p, strlen($base_dir));

            return array("contents"=>$contents, "currentPath"=>$p);
        } else {
            header('Location: login.php');
        }
    }

    $p = isset($_POST['path']) ? $_POST['path'] : "";

    $base = isset($_POST['base']) ? $_POST['base'] : "";

    echo json_encode(searchDir("../img/".$base, $p, -1));