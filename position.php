<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
 
    $userid = $_POST['UserID'];
	$score = $_POST['Score'];
	$gamesplayed = $_POST['GamesPlayed'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
	
 	$response["scores"] = array();
	$scores = array();
	
    // Best Score
	/*$result = mysqli_query($db->conn, "
	SELECT Count(id) AS IDCount
	FROM (SELECT Max(scores.id) AS MaxID1
			FROM (SELECT Max(scores.id) AS MaxID
				FROM scores
				GROUP BY scores.UserID) AS fq INNER JOIN scores ON fq.MaxID = scores.ID
			GROUP BY scores.BestScore, scores.GamesPlayed, scores.UserID
			HAVING (scores.BestScore>'$score' OR scores.GamesPlayed>'$gamesplayed')) AS sq INNER JOIN scores ON sq.MaxID1 = scores.ID
		GROUP BY scores.BestScore
		HAVING (scores.BestScore>='$score');");*/
	$result = mysqli_query($db->conn, "
		SELECT Max(scores.ID) AS MaxOfID1, fq.UserID AS ui, scores.BestScore, scores.GamesPlayed
		FROM (SELECT Max(scores.ID) AS MaxOfID, scores.UserID
		FROM scores
		GROUP BY scores.UserID) AS fq INNER JOIN scores ON fq.MaxOfID = scores.ID
		GROUP BY fq.UserID, scores.BestScore, scores.GamesPlayed
		ORDER BY scores.BestScore DESC , scores.GamesPlayed DESC;");

	// check for empty result
	if (mysqli_num_rows($result) > 0) {
		// looping through all results
		// products node
		$subtotal = 0;
		$counter = 0;
		while ($row = mysqli_fetch_array($result)) {
			$counter++;
			if ($row["ui"] = $userid){
				$scores["Position"] = $counter;
				$scores["Score"] = $row["scores.BestScore"];
				
			}
		}
		// success
		//$response["success"] = 1;
	 
		// echoing JSON response
		//echo json_encode($response);
	} else {
		// no scores found
		$response["success"] = 0;
		$response["message"] = "No scores found";
	 
		// echo no users JSON
		echo json_encode($response);
	}
	// Most games played
	$result = mysqli_query($db->conn, "
	SELECT Count(id) AS IDCount
	FROM (SELECT Max(scores.id) AS MaxID1
			FROM (SELECT Max(scores.id) AS MaxID
				FROM scores
				GROUP BY scores.UserID) AS fq INNER JOIN scores ON fq.MaxID = scores.ID
			GROUP BY scores.GamesPlayed, scores.UserID
			HAVING scores.GamesPlayed>'$gamesplayed') AS sq INNER JOIN scores ON sq.MaxID1 = scores.ID
		GROUP BY scores.GamesPlayed
		HAVING (scores.GamesPlayed>='$gamesplayed');");
	// check for empty result
	if (mysqli_num_rows($result) > 0) {
		// looping through all results
		// products node
		$subtotal = 0;
		while ($row = mysqli_fetch_array($result)) {
			$subtotal = $subtotal + $row["IDCount"];
		}
		$scores["GamesPlayed"] = $subtotal;
	} else {
		// no scores found
		$response["success"] = 0;
		$response["message"] = "No scores found";
	 
		// echo no users JSON
		echo json_encode($response);
	}
	
		
	array_push($response["scores"], $scores);
	// success
	$response["success"] = 1;
	// echoing JSON response
	echo json_encode($response);
?>