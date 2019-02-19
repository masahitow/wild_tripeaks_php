<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$result = mysqli_query($db->conn, "SELECT *FROM scores ORDER BY BestScore DESC") or die(mysqli_error($db->conn));
 
// check for empty result
if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["scores"] = array();
 
    while ($row = mysqli_fetch_array($result)) {
        // temp user array
        $scores = array();
        $scores["id"] = $row["id"];
        $scores["UserID"] = $row["UserID"];
		$scores["NickName"] = $row["NickName"];
        $scores["GamesPlayed"] = $row["GamesPlayed"];
        $scores["BestScore"] = $row["BestScore"];
        $scores["created_at"] = $row["created_at"];
		$scores["Country"] = $row["Country"];
		$scores["State"] = $row["State"];
 
        // push single product into final response array
        array_push($response["scores"], $scores);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>