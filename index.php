<!DOCTYPE html>
<html lang="se" charset="UTF-8">
	<head>
		<title> Shitty php time calculator</title>
		<style>
			* {
				padding: 0;
				margin: 0;
			}
			body {
				background-color: #f4f4f4;
			}
			h1 {
				margin-top: 20px;
				padding: 10px 0 10px 0px;
				padding-bottom: 20px;
			}
			.box1 {
				padding-bottom: 20px;
				display: inline-block;
				width: 49%;
					
			}
			input {
				display: block;
				font-size: 20px;
				margin-bottom: 8px;
				width: 80%;
			}
			.container {
				width: 400px;
				margin: 0 auto;
			}
			#clickToCopy {
				color: grey;
			}

			table {
				max-height: 100px; 
				overflow: auto; 
				border-collapse: collapse;
			}
			tr {
				height: 20px;
				text-align:left;
				padding: 10px;
			}
			td {
				border-bottom: 1px solid grey;
				border-top: 1px solid grey;
				padding: 10px 2px 10px 2px;
				background: lightblue;
			}	
			#copyField {
				border-color: transparent;
				outline: 1px solid grey;
				border-radius: 2px;
				cursor: default;
			}
			#copyField::selection {
				background: white ;
			}
			#copyField::-moz-selection{
				background: white ;
			}
			
		</style>
	</head>
	<body>
		<?php 
			$file = "log.json";
			$file_not_exists = filesize($file) == 0;
			$get_log;
			if(filesize($file) == 0):
				//$get_log = json_decode(file_get_contents($file)); 
				$get_log = new stdClass();
				$get_log->start_time = "07:30";
				$get_log->end_time = "16:00";
				$get_log->lunch_break = "30";
				$get_log->date = "";
				$get_log->final_time = "";
			else:
				$get_log = json_decode(file_get_contents($file)); 
			endif;
		?>
		<div class="container">

			<h1>Shitty php time calculator</h1>	
			<div class="box1">
				<form action="calculate-time.php" method="POST">
					<label for="start_time">Start time</label>
					<input type="time" name="start_time" value="<?= $file_not_exists ? $get_log->start_time : $get_log[count($get_log) -1]->start_time ?>"/>
					<label for="end_time">End Time</label>
					<input type="time" name="end_time" value="<?= $file_not_exists ? $get_log->end_time : $get_log[count($get_log) -1]->end_time ?>"/>
					<label for="lunch_break">Lunch Break</label>
					<input type="number" name="lunch_brake" value="<?= $file_not_exists ?  $get_log->lunch_break : $get_log[count($get_log) -1]->lunch_brake ?>"/>
					<input type="submit" name="submit" value="Calculate"/>
				</form>
				<br>
				<label id="clickToCopy"><small>Click to copy</small></label>
				<input id="copyField" onclick='final_time()' value='<?= $file_not_exists ? $get_log->final_time: $get_log[count($get_log) -1]->final_time ?>'>
			</div>
			<div class="box2">
				<h1>Log</h1>

				<?php if(!filesize($file) == 0): ?>

				<table>
					<caption>blah a table</caption>
					<tr>
						<th scope="col">Start time</th>
						<th scope="col">End time</th>
						<th scope="col">Lunch break (min)</th>
						<th scope="col">Final time</th>
						<th scope="col">Date</th>
					</tr>
					<?php
						$counter = 0;
						foreach(array_reverse($get_log) as $ele => $val): 
							
							$counter++;
					?>

					<tr>
						<td><?= $val->start_time ?></td>
						<td><?= $val->end_time ?></td>
						<td><?= $val->lunch_brake ?></td>
						<td><?= $val->final_time ?></td>
						<td><?= $val->date ?></td>
					</tr>
				<?php endforeach;  echo "</table>"; echo "Total reports: " . $counter; endif; ?>
				
			</div>
		</div>
		

		<script>
			function final_time() {
				copyText = document.getElementById('copyField')
				copyText.select();
				copyText.setSelectionRange(0, 99999);
				navigator.clipboard.writeText(copyText.value);
				alert("Copied the text: " + copyText.value);
			}
		</script>
	</body>
</html>
