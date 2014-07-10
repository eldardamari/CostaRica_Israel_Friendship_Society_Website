<!doctype html>
<html>

<body>
    <?php
        function set_con_get_query_data(&$con, $query) {
            $con = mysqli_connect("localhost", "root" , "root" , "costa_rica_israel");
            if(mysqli_connect_errno()) {
                echo "Failed to connect to MySQL, ".mysqli_connect_error(); 
                exit();
            } else {
                if (func_num_args() == 2) {
                    if ($query_data = mysqli_query($con, $query))
                        return $query_data;
                    echo "Failed with query requesst: ".$query;
                    return 0;
                }
            }
        }
        function set_con(&$con) {
            $con = mysqli_connect("localhost", "root" , "root" , "costa_rica_israel");
            if(mysqli_connect_errno()) {
                echo "Failed to connect to MySQL, ".mysqli_connect_error(); 
                exit();
            }
        }
        
        function get_query_date(&$con,$query) {
                if (func_num_args() == 2) {
                    if ($query_data = mysqli_query($con, $query))
                        return $query_data;
                    echo "Failed with query requesst: ".$query;
                    return 0;
                }
        }
?>
</body>
</html>
