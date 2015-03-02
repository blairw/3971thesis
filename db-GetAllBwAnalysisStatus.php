<?php
	// connect to mysql
	include ('../3971thesis-db/db-MysqlAccess.php');
	
	$res = $mysqli->query("
		select
			a.article_id AS article_id,
			group_concat(
				ifnull(au.author_lname,''),' ',
				ifnull(concat(left(au.author_fname,1),'.'),''),
				ifnull(concat(left(au.author_mname,1),'.'),'')
				order by aus.sequence ASC, aus.authorship_id ASC separator ', '
			) AS authors,
			jr.pub_year AS pub_year,
			a.title AS title,
			j.journal_code AS journal_code,
			jr.volume AS volume,
			jr.issue AS issue,
			jr.part AS part,
			a.pg_begin AS pg_begin,
			a.pg_end AS pg_end,
			a.bwanalysis_relevant,
			a.bwanalysis_synopsis,
			a.bwanalysis_empirical,
			a.bwanalysis_samplesize,
			a.bwanalysis_samplesource
		from 3971thesis_articles a
			left join 3971thesis_journal_releases jr on jr.jr_id = a.jr_id
			left join 3971thesis_journals j          on j.journal_id = jr.journal_id
			left join 3971thesis_authorship aus      on aus.article_id = a.article_id
			left join 3971thesis_authors au          on au.author_id = aus.author_id
		where j.is_basket_of_8 = 1
		group by a.article_id
		order by jr.journal_id,jr.volume,jr.issue,jr.part,a.pg_begin
	");
	
	$arr = array();
	while ($row = $res->fetch_assoc()) {
		array_push($arr, $row	);
	}
	$res->close();
	$mysqli->close();
	
	header('Content-type: application/json');
	echo json_encode($arr, JSON_PRETTY_PRINT);
	
	
?>