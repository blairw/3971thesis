<?php
	if (isset($_GET['id']) && is_int((int) $_GET['id'])) {
		// only continue if id is set and it is an int
		$selectedId = $_GET['id'];
	} else {
		// send them to the index page whatever it may be
		header('Location: ./');
	}
	
	$narr = array(
		'articleDetails' => array(),
		'authors' => array(),
		'groups' => array(),
		'theories' => array(),
	);
	// connect to mysql
	include ('../3971thesis-db/db-MysqlAccess.php');
	
	//
	// ARTICLE DETAILS
	//
	$resArticle = $mysqli->query("
		SELECT *
		FROM
			3971thesis_articles a
			LEFT JOIN 3971thesis_journal_releases jr ON jr.jr_id = a.jr_id
			LEFT JOIN 3971thesis_journals j ON j.journal_id = jr.journal_id
		WHERE a.article_id = ".$selectedId."
	");
	while ($rowArticle = $resArticle->fetch_assoc()) {
		$narr['articleDetails'] = $rowArticle;
	}
	$resArticle->close();
	
	//
	// AUTHOR DETAILS
	//
	$resAuthors = $mysqli->query("
		SELECT *
		FROM 3971thesis_authorship aus
			LEFT JOIN 3971thesis_authors au ON au.author_id = aus.author_id
		WHERE aus.article_id = ".$selectedId."
		ORDER BY aus.sequence ASC, aus.authorship_id ASC
	");
	while ($rowAuthors = $resAuthors->fetch_assoc()) {
		array_push($narr['authors'], $rowAuthors);
	}
	$resAuthors->close();
	
	//
	// GROUP DETAILS
	//
	$resGroups = $mysqli->query("
		SELECT *
		FROM 3971thesis_membership m
		LEFT JOIN 3971thesis_groups g ON g.group_id = m.group_id
		WHERE m.article_id = ".$selectedId."
	");
	while ($rowGroups = $resGroups->fetch_assoc()) {
		array_push($narr['groups'], $rowGroups);
	}
	$resGroups->close();
	
	
	//
	// THEORY DETAILS
	//
	$resTheory = $mysqli->query("
		SELECT *
		FROM 3971thesis_theory_usage tu
		LEFT JOIN 3971thesis_theory t ON t.theory_id = tu.theory_id
		WHERE tu.article_id = ".$selectedId."
	");
	while ($rowTheory = $resTheory->fetch_assoc()) {
		array_push($narr['theories'], $rowTheory);
	}
	$resTheory->close();


	$mysqli->close();
	header('Content-type: application/json');
	echo json_encode($narr, JSON_PRETTY_PRINT);
	
	
?>
