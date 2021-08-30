<!DOCTYPE html>
<html lang="se">
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
		</style>
	</head>
	<body>
		<?php
			$format_time;
			if(isset($_GET['start_time']) && isset($_GET['end_time']) && isset($_GET['lunch_brake'])){
				$start_time = new DateTime(htmlspecialchars($_GET['start_time']));
				$end_time = new DateTime(htmlspecialchars($_GET['end_time']));

				$diffe = $end_time->diff($start_time);
				
				$format_time = $diffe->format("%H:%I");

				
				$subt_lunch = strtotime($format_time) - (htmlspecialchars($_GET['lunch_brake'] * 60));
				$final_time = date("H:i", $subt_lunch);

			}
		?>
		<div class="container">

			<h1>Shitty php time calculator</h1>	
			<div class="box1">
				<form action="index.php" method="GET">
					<label for="start_time">Start time</label>
					<input type="time" name="start_time" value="08:00"/>
					<label for="end_time">End Time</label>
					<input type="time" name="end_time" value="16:00"/>
					<label for="lunch_break">Lunch Break</label>
					<input type="number" name="lunch_brake" value="33"/>
					<input type="submit" name="submit" value="Calculate"/>
				</form>
				<br>

				<?= "<input id='final_time' onclick='final_time()' value='" . $final_time . "'><button onclick='final_time()'>copy time</button>" ?>
			
			</div>
		</div>
		

		<script>
			function final_time() {
				copyText = document.getElementById('final_time')
				copyText.select();
				copyText.setSelectionRange(0, 99999);
				navigator.clipboard.writeText(copyText.value);
				alert("Copied the text: " + copyText.value);
			}
			</script>
	</body>
</html>
