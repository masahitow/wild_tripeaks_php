<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['UserID']) && isset($_POST['NickName']) && isset($_POST['Country']) && 
	isset($_POST['State']) && isset($_POST['GamesPlayed']) && isset($_POST['BestScore']) &&
	isset($_POST['LongestStreak']) && isset($_POST['Wins']) && isset($_POST['LongestWinStreak']) &&
	isset($_POST['MostCardsLeft']) && isset($_POST['WorstScore']) && isset($_POST['BestLoseScore']) &&
	isset($_POST['LongStreakOnLoss']) && isset($_POST['LongestLoseStreak']) && isset($_POST['MostCardsLeftPeak']) &&
	isset($_POST['TotalScore']) && isset($_POST['TotalWinScore']) && isset($_POST['TotalLosingScore']) &&
	isset($_POST['AverageScore']) && isset($_POST['AverageWinScore']) && isset($_POST['AverageLoseScore']) &&
	isset($_POST['WorstWinScore'])) {
 
    $userid = $_POST['UserID'];
	$nickname = $_POST['NickName'];
	$country = $_POST['Country'];
	$state = $_POST['State'];
    $gamesplayed = $_POST['GamesPlayed'];
    $bestscore = $_POST['BestScore'];
	$longeststreak = $_POST['LongestStreak'];
	$wins = $_POST['Wins'];
	$longestwinstreak = $_POST['LongestWinStreak'];
	$mostcardsleft = $_POST['MostCardsLeft'];
	$worstscore = $_POST['WorstScore'];
	$bestlosescore = $_POST['BestLoseScore'];
	$longstreakonloss = $_POST['LongStreakOnLoss'];
	$longestlosestreak = $_POST['LongestLoseStreak'];
	$mostcardsleftpeak = $_POST['MostCardsLeftPeak'];
	$totalscore = $_POST['TotalScore'];
	$totalwinscore = $_POST['TotalWinScore'];
	$totallosingscore = $_POST['TotalLosingScore'];
	$averagescore = $_POST['AverageScore'];
	$averagewinscore = $_POST['AverageWinScore'];
	$averagelosescore = $_POST['AverageLoseScore'];
	$worstwinscore = $_POST['WorstWinScore'];
	
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql inserting a new row
    $result = mysqli_query($db->conn, "INSERT INTO scores (UserID, NickName, Country, State, 
		GamesPlayed, BestScore, LongestStreak, Wins, LongestWinStreak,
		MostCardsLeft, WorstScore, BestLoseScore, LongStreakOnLoss, LongestLoseStreak, MostCardsLeftPeak,
		TotalScore, TotalWinScore, TotalLosingScore, AverageScore, AverageWinScore, AverageLoseScore, WorstWinScore) 
		VALUES('$userid', '$nickname', '$country', '$state', '$gamesplayed', '$bestscore', '$longeststreak', '$wins', '$longestwinstreak', '$mostcardsleft', 
		'$worstscore', '$bestlosescore', '$longstreakonloss', '$longestlosestreak', '$mostcardsleftpeak',
		'$totalscore', '$totalwinscore', '$totallosingscore', '$averagescore', '$averagewinscore', '$averagelosescore', '$worstwinscore')");
	//var_dump($userid);
	//var_dump($nickname);
	//var_dump($country);
 /*$result = mysqli_query($db->conn, "INSERT INTO scores (UserID, NickName, Country) VALUES('$userid', '$nickname', '$country')");*/
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Score record successfully created.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred." . mysqli_error($db->conn);
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>