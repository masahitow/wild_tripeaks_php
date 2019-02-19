<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
$userid = $_POST['UserID'];

// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get best score from scores table
//$result = mysqli_query($db->conn, "SELECT *FROM scores ORDER BY BestScore DESC, GamesPlayed DESC") or die(mysqli_error($db->conn));
//$result = mysqli_query($db->conn, "SELECT id, UserID, NickName, GamesPlayed, BestScore, Country, State, created_at FROM scores WHERE id IN (SELECT * FROM (SELECT //MAX(id) FROM scores GROUP BY UserID) a) ORDER BY BestScore DESC, GamesPlayed DESC") or die(mysqli_error($db->conn));
$result = mysqli_query($db->conn, "SELECT * FROM scores AS v INNER JOIN (SELECT MAX(id) AS MaxID FROM scores GROUP BY UserID) AS v2 ON v.id = v2.MaxID WHERE UserID = '$userid'") or die(mysqli_error($db->conn));
 
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
			$scores["Country"] = $row["Country"];
			$scores["State"] = $row["State"];
			$scores["GamesPlayed"] = $row["GamesPlayed"];
			$scores["BestScore"] = $row["BestScore"];
			$scores["LongestStreak"] = $row["LongestStreak"];
			$scores["Wins"] = $row["Wins"];
			$scores["LongestWinStreak"] = $row["LongestWinStreak"];
			$scores["MostCardsLeft"] = $row["MostCardsLeft"];
			$scores["WorstScore"] = $row["WorstScore"];
			$scores["BestLoseScore"] = $row["BestLoseScore"];
			$scores["LongStreakOnLoss"] = $row["LongStreakOnLoss"];
			$scores["LongestLoseStreak"] = $row["LongestLoseStreak"];
			$scores["MostCardsLeftPeak"] = $row["MostCardsLeftPeak"];
			$scores["TotalScore"] = $row["TotalScore"];
			$scores["TotalWinScore"] = $row["TotalWinScore"];
			$scores["TotalLosingScore"] = $row["TotalLosingScore"];
			$scores["AverageScore"] = $row["AverageScore"];
			$scores["AverageWinScore"] = $row["AverageWinScore"];
			$scores["AverageLoseScore"] = $row["AverageLoseScore"];
			$scores["WorstWinScore"] = $row["WorstWinScore"];

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