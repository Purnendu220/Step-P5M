<script src="<?php echo base_url() ?>assets/admin/chart/js/Chart.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/chart/js/utils.js"></script>
<?php 
$config = $this->db->where('fld_slug','session_complete')->get('tbl_config')->row();

$startDate 						=		date('Y-m-d',strtotime($config->fld_start_date));
$endDate 						=		$config->fld_end_date;
if( $endDate 		==		'0000-00-00 00:00:00' ){ 
		$today 		=		date('Y-m-d');
		$dateAry 	=		getDatesFromRange($startDate,$today,'Y-m-d');
		$xAccess 	=		$dateAry;
}else{
$endDate			=		date('Y-m-d',strtotime($config->fld_end_date));
		$today 		=		$endDate;
		$dateAry 	=		getDatesFromRange($startDate,$today,'Y-m-d');
		$xAccess 	=		$dateAry;
}
$yAccess			=	array();
foreach ($xAccess as $key => $value) {
		$this->db->like('fld_starting_date',$value);
		$this->db->where('fld_status','0');
		$session = $this->db->select('fld_session_code')->get('tbl_session')->result();
		// echo $this->db->last_query();
		// echo "<pre>";		print_r($session);
		$time 		=	'00:00:00';
		foreach ($session as $key => $value) {
			$this->db->where('fld_session_id',$value->fld_session_code);
			$sessionData =	$this->db->select('fld_total_time')->get('tbl_user_steps')->row();
			$time 		 =	addTwotIme($time,$sessionData->fld_total_time);

		}

		$yAccess[]					=		gettotalTimeMinit($time);
}
 $yMax =max($yAccess);
 $yValue = $yMax/9;
 $yValue=  (int) $yValue;
 $yAccess 							=		json_encode($yAccess);
$xAccess 							=		json_encode($xAccess);

$totalArray                         =       getTotalTimeArray();
$total_time                         =       getTotalTime( $totalArray );
$total_TimeMinit                    =       gettotalTimeMinit($total_time);
//$total_TimeMinit					=		200000;
if( $total_TimeMinit < 100 ){
	$stepSize 						=	5;
}elseif( $total_TimeMinit < 500 ){
	$stepSize 						=	100;
}elseif( $total_TimeMinit < 1000 ){
	$stepSize 						=	200;
}elseif( $total_TimeMinit < 2000 ){
	$stepSize 						=	300;
}elseif( $total_TimeMinit < 3000 ){
	$stepSize 						=	400;
}elseif( $total_TimeMinit < 4000 ){
	$stepSize 						=	500;
}elseif( $total_TimeMinit < 5000 ){
	$stepSize 						=	600;
}elseif( $total_TimeMinit < 6000 ){
	$stepSize 						=	700;
}elseif( $total_TimeMinit < 7000 ){
	$stepSize 						=	800;
}
elseif( $total_TimeMinit < 8000 ){
	$stepSize 						=	900;
}
elseif( $total_TimeMinit < 9000 ){
	$stepSize 						=	1000;
}elseif( $total_TimeMinit < 10000 ){
	$stepSize 						=	1500;
}else{
	$stepSize 						=	10000;
}
?>

<script>
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		var randomScalingFactor = function() {
			return Math.round(Math.random() * <?php echo $total_TimeMinit; ?>);
		};

		var config = {
			type: 'line',
			data: {
				labels: <?php echo $xAccess; ?>,//['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					label: 'Total Days / Time ( Minutes )',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: <?php echo $yAccess; ?> /*[
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					]*/,
					fill: false,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						},
						ticks: {
							min: 0,
							max: <?php echo $yMax; ?>,

							// forces step size to be 5 units
							stepSize: <?php echo $yValue; ?>
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas_new').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myLine.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + config.data.datasets.length,
				backgroundColor: newColor,
				borderColor: newColor,
				data: [],
				fill: false
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				var month = MONTHS[config.data.labels.length % MONTHS.length];
				config.data.labels.push(month);

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
				});

				window.myLine.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myLine.update();
		});

	</script>