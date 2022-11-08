<?php 
    $conn = mysqli_connect('localhost','root','','');

    function alert($message){
        echo "<script>alert($message);</script>";
    }

    function query($query){
        global $conn;

        $result = mysqli_query($conn, $query);
        $rows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rows = $row;
        }
        
        return $rows;
    }

    function insert($query){
        global $conn;

        // Ambil data

        $query = "INSERT INTO <table> VALUES ('','','','','','')";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function update($data){
        global $conn;

        // Ambil Data

        $query = "UPDATE <table> SET 
                    <var> = <value>, 
                    <var> = <value> 
                WHERE <var> = <value>";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function delete($id){
        global $conn;

        $query = "DELETE FROM <table> WHERE <var> = <value>";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

?>