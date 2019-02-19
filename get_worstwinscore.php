<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
$userid = $_POST['UserID'];
$limit = $_POST['Limit'];
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$result = mysqli_query($db->conn, "SELECT id, UserID, NickName, GamesPlayed, WorstWinScore, Country, State, created_at FROM scores AS v INNER JOIN (SELECT MAX(id) AS MaxID FROM scores GROUP BY UserID) AS v2 ON v.id = v2.MaxID ORDER BY WorstWinScore, GamesPlayed DESC, id") or die(mysqli_error($db->conn));
 
// check for empty result
if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["scores"] = array();
	$counter = 0;
	$ishit = 0;
 
    while ($row = mysqli_fetch_array($result)) {
		$counter++;
        // temp user array
		if ($counter <= $limit){
			$scores = array();
			$scores["id"] = $row["id"];
			$scores["UserID"] = $row["UserID"];
			$scores["NickName"] = $row["NickName"];
			$scores["GamesPlayed"] = $row["GamesPlayed"];
			$scores["ScoreValue"] = number_format($row["WorstWinScore"]*10);
			$scores["created_at"] = $row["created_at"];
			$scores["Country"] = $row["Country"];
			$scores["State"] = $row["State"];
			$scores["RawData"] = $row["WorstWinScore"]*10;
			$scores["Position"] = $counter;
			if ($row["UserID"] == $userid){
				$ishit = 1;
			}	 
			// push single product into final response array
			array_push($response["scores"], $scores);
		} else {
			if ($ishit == 1){
				break;
			} else {
				if ($row["UserID"] == $userid){
					$scores = array();
					$scores["id"] = $row["id"];
					$scores["UserID"] = $row["UserID"];
					$scores["NickName"] = $row["NickName"];
					$scores["GamesPlayed"] = $row["GamesPlayed"];
					$scores["ScoreValue"] = number_format($row["WorstWinScore"]*10);
					$scores["created_at"] = $row["created_at"];
					$scores["Country"] = $row["Country"];
					$scores["State"] = $row["State"];
					$scores["RawData"] = $row["WorstWinScore"]*10;
					$scores["Position"] = $counter;
					array_push($response["scores"], $scores);
					break;
				}
			}
			
		}
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