<script>
	$(document).ready(function() {


		//  GRAFIK CANVASJS
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			theme: "light2",
			// title: {
			// 	text: "Penjualan 7 Hari Terakhir",
			// 	fontSize: 20,
			// },
			axisX: {
				valueFormatString: "DD MMM",
				intervalType: "day"
			},
			axisY: {
				prefix: "Rp",
			},
			toolTip: {
				shared: true
			},
			legend: {
				cursor: "pointer",
			},
			data: [{
					type: "column",
					name: "Penjualan",
					showInLegend: true,
					xValueFormatString: "DD MMM, YYYY",
					yValueFormatString: "Rp #,##0",
					dataPoints: [
						<?php foreach ($chartlast as $h) :  ?> 
						{
								x: new Date('<?= $h["tanggal"] ?>'),
								y: <?= $h["total"] ?>
							},
						<?php endforeach ?>
					]
				},
				{
					type: "area",
					name: "Laba",
					markerBorderColor: "white",
					markerBorderThickness: 2,
					showInLegend: true,
					yValueFormatString: "Rp #,##0",
					dataPoints: [
						<?php foreach ($chartlast as $h) :  ?> 
						{
								x: new Date('<?= $h["tanggal"] ?>'),
								y: <?= $h["untung"] ?>
						},
						<?php endforeach ?>
					]
				}
			]
		});
		// END

		var chartMostSale = new CanvasJS.Chart("chartMostSale", {
			theme: "light2",
			exportFileName: "5 Barang terlaris - <?= date('d-m-Y') ?>",
			exportEnabled: true,
			animationEnabled: true,
			title: {
				text: "Terlaris <?= date("M Y") ?>"
			},
			legend: {
				// cursor: "pointer",
				// itemclick: explodePie
			},
			data: [{
				// type: "doughnut",
				// startAngle: -90,
				// innerRadius: 40,
				// legendText: "5 Barang Terlaris",
				// showInLegend: true,
				toolTipContent: "<b>{label}: {y} Terjual</b>",
				indexLabel: "{y}",
				type: "column",
				dataPoints: [
											<?php foreach($mostsale->result() as $m) : ?>
										{ y: <?= $m->jumlah ?>, label: "<?= $m->name_product ?>"},
										<?php endforeach ?>
				]
			}]
		});
		
		setTimeout(()=> chart.render(),500);
		setTimeout(()=> chartMostSale.render(),500);
	

	});
</script>