<?php
$thisJournalId = (
	isset($_GET['id']) && is_int((int) $_GET['id'])
	? $_GET['id']
	: '-1');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Journal Releases</title>
		<script>
			var selectedJournalId = <?php echo $thisJournalId; ?>;
		</script>
		<meta charset="utf-8">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--jquery-->
		<script src="frameworks/jquery-1.11.2.min.js"></script>
		<!--bootstrap-->
		<script src="frameworks/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="frameworks/bootstrap-3.3.2-dist/css/bootstrap.min.css">
		<!--select2-->
		<script src="frameworks/select2-3.5.2/select2.min.js"></script>
		<link rel="stylesheet" href="frameworks/select2-3.5.2/select2.css" />
		<link rel="stylesheet" href="frameworks/select2-3.5.2/select2-bootstrap.css" />
		<!--font-awesome-->
		<link rel="stylesheet" href="frameworks/font-awesome-4.3.0/css/font-awesome.min.css">
		<!--underscore-->
		<script src="frameworks/underscore-min.js"></script>
		<!--other-->
		<script src="common.js"></script>
		<script src="ui-ListJournalReleases.logic.js"></script>
		<link rel="stylesheet" href="common.css">
		<link rel="icon" type="image/png" href="frameworks/fugue-subset/document-smiley.png?v=2" />
	</head>
	<body onload="bodyDidLoad()">
		<h1 id="h1ForJournalName">Releases</h1>
		<p id="pForJournalDetails"></p>
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Year</th>
					<th>Month</th>
					<th>Release Details</th>
					<th>Article Count</th>
					<th>External Link</th>
				</tr>
			</thead>
			<tbody id="tbodyForJournalReleasesTable">
			</tbody>
		</table>
	</body>
</html>
