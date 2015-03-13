<?php
	if (isset($_GET['id']) && is_int((int) $_GET['id'])) {
		// only continue if id is set and it is an int
		$selectedId = $_GET['id'];
	} else {
		// send them to the index page whatever it may be
		header('Location: ./');
	}
	
	// connect to mysql
	include ('../3971thesis-db/db-MysqlAccess.php');
	
	$res = $mysqli->query("
		SELECT
			a.*,
			jr.jr_id, jr.pub_year, jr.pub_month, jr.volume, jr.issue, jr.part,
			j.journal_id, j.journal_name, j.journal_code
		FROM 3971thesis_articles a
			LEFT JOIN 3971thesis_journal_releases jr on jr.jr_id = a.jr_id
				LEFT JOIN 3971thesis_journals j on j.journal_id = jr.journal_id
		WHERE jr.jr_id = ".$selectedId."
		ORDER BY a.pg_begin ASC
	");
	
	$arr = array();
	while ($row = $res->fetch_assoc()) {
		array_push($arr, $row);
	}
	$res->close();
	$mysqli->close();
	
	header('Content-type: application/json');
	echo json_encode($arr, JSON_PRETTY_PRINT);
?>
