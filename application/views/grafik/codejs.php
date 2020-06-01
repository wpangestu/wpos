<script>
  $(document).ready(function() {

    $('#tglrangepick').daterangepicker({
      ranges: {
        'Hari ini': [moment(), moment()],
        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
        'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      // autoApply: true,
      locale: {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
          "Mg",
          "Sn",
          "Sl",
          "Rb",
          "Ka",
          "Ju",
          "Sa"
        ],
        "monthNames": [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",
          "Oktober",
          "November",
          "Desember"
        ],
        "firstDay": 1
      }
    });

    $('.yearpick').datepicker({
      format: 'yyyy',
      autoclose: true,
      language: 'id',
      maxViewMode: 0,
      minViewMode: 2,
    });

    $('.monthpick').datepicker({
      format: 'M yyyy',
      autoclose: true,
      language: 'id',
      maxViewMode: 2,
      minViewMode: 1,
    });

    $('.input-daterange').datepicker();

    $('#btn_grafik_hari').on('click', function() {
      let tgl = $('#tglrangepick').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() . 'grafik/sale_json'; ?>",
        data: {
          tglrange: tgl
        },
        dataType: "json",

        success: function(msg) {

          if (msg.success == true) {
            // console.log(msg.dataChart)
            $('#harian').html('<div id="chartContainer" style="height: 370px; width: 100%;"></div>');
            var dpTotal = [];
            var dpLaba = [];
            for (var i = 0; i < msg.dataChart.length; i++) {
              dpTotal.push({
                x: new Date(msg.dataChart[i].tanggal),
                y: parseInt(msg.dataChart[i].total)
              });
              dpLaba.push({
                x: new Date(msg.dataChart[i].tanggal),
                y: parseInt(msg.dataChart[i].untung)
              });
            }
            // console.log(dpTotal[0]);
            // chart.options.data[0].dataPoints = dpTotal;
            // chart.options.data[1].dataPoints = dpLaba;
            // chart.render();
            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              theme: "light2",
              title: {
                text: "Penjualan Harian"
              },
              axisX: {
                intervalType:"day",
                valueFormatString: "DD MMM",
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
                  dataPoints: dpTotal
                },
                {
                  type: "area",
                  name: "Laba",
                  markerBorderColor: "white",
                  markerBorderThickness: 2,
                  showInLegend: true,
                  yValueFormatString: "Rp #,##0",
                  dataPoints: dpLaba
                }
              ]
            });
            chart.render();
          } else {
            $('#harian').html('<center><b><i class="fa fa-warning"></i> Data Tidak Ditemukan</b><center>')
          }
        }
      });
    })

    $('#btn_grafik_bln').click(function(){
      let sm = $('#startmonth').val();
      let em = $('#endmonth').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() . 'grafik/sale_json_month'; ?>",
        data: {
          start: sm,
          end : em
        },
        dataType: "json",
        success: function(msg) {

          if (msg.success == true) {
            // console.log(msg.dataChart)
            $('#bulanan').html('<div id="chartMonth" style="height: 370px; width: 100%;"></div>');
            var dpTotal = [];
            var dpLaba = [];
            for (var i = 0; i < msg.dataChart.length; i++) {
              dpTotal.push({
                x: new Date(msg.dataChart[i].bulan),
                y: parseInt(msg.dataChart[i].total)
              });
              dpLaba.push({
                x: new Date(msg.dataChart[i].bulan),
                y: parseInt(msg.dataChart[i].untung)
              });
            }

            var chart = new CanvasJS.Chart("chartMonth", {
              animationEnabled: true,
              theme: "light2",
              title: {
                text: "Penjualan Bulanan"
              },
              axisX: {
                interval:1,
                valueFormatString: "MMM",
                intervalType: "month"
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
                  xValueFormatString: "MMM, YYYY",
                  yValueFormatString: "Rp #,##0",
                  dataPoints: dpTotal
                },
                {
                  type: "area",
                  name: "Laba",
                  markerBorderColor: "white",
                  markerBorderThickness: 2,
                  showInLegend: true,
                  yValueFormatString: "Rp #,##0",
                  dataPoints: dpLaba
                }
              ]
            });
            chart.render();
          } else {
            $('#bulanan').html('<center><b><i class="fa fa-warning"></i> Data Tidak Ditemukan</b><center>')
          }
        }
      });
    })

    $('#btn_chart_year').click(function(){
      let sm = $('#startyear').val();
      let em = $('#endyear').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() . 'grafik/sale_json_year'; ?>",
        data: {
          start: sm,
          end : em
        },
        dataType: "json",
        success: function(msg) {

          if (msg.success == true) {
            console.log(msg.dataChart)
            $('#tahunan').html('<div id="chartYear" style="height: 370px; width: 100%;"></div>');
            var dpTotal = [];
            var dpLaba = [];
            for (var i = 0; i < msg.dataChart.length; i++) {
              dpTotal.push({
                x: new Date(msg.dataChart[i].tahun),
                y: parseInt(msg.dataChart[i].total)
              });
              dpLaba.push({
                x: new Date(msg.dataChart[i].tahun),
                y: parseInt(msg.dataChart[i].untung)
              });
            }

            var chartY = new CanvasJS.Chart("chartYear", {
              animationEnabled: true,
              theme: "light2",
              title: {
                text: "Penjualan Tahunan",
              },
              axisX: {
                interval:1,
                valueFormatString: "YYYY",
              },
              axisY: {
                prefix: "Rp",
              },
              toolTip: {
                shared: true,
              },
              legend: {
                cursor: "pointer",
              },
              data: [{
                  type: "column",
                  name: "Penjualan",
                  showInLegend: true,
                  xValueFormatString: "YYYY",
                  yValueFormatString: "Rp #,##0",
                  dataPoints: dpTotal
                },
                {
                  type: "area",
                  name: "Laba",
                  markerBorderColor: "white",
                  markerBorderThickness: 2,
                  showInLegend: true,
                  yValueFormatString: "Rp #,##0",
                  dataPoints: dpLaba
                }
              ]
            });
            chartY.render();
          } else {
            $('#tahunan').html('<center><b><i class="fa fa-warning"></i> Data Tidak Ditemukan</b><center>')
          }
        }
      });  
    })


    // GRAFIK HARIAN
    var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Penjualan Harian"
      },
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
            <?php foreach ($chart->result() as $h) :  ?> {
                // x: new Date(<?= dateformatkoma($h->tanggal) ?>),
                x: new Date('<?= $h->tanggal ?>'),
                y: <?= $h->total ?>
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
            <?php foreach ($chart->result() as $h) :  ?> {
                // x: new Date(<?= dateformatkoma($h->tanggal) ?>),
                x: new Date('<?= $h->tanggal ?>'),
                y: <?= $h->untung ?>
              },
            <?php endforeach ?>
          ]
        }
      ]
    });
    chart.render();


    // GRAFIK BULANAN
    var chartBln = new CanvasJS.Chart("chartMonth", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Penjualan Bulanan"
      },
      axisX: {
        interval:1,
        valueFormatString: "MMM",
        intervalType: "month"
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
          xValueFormatString: "MMM, YYYY",
          yValueFormatString: "Rp #,##0",
          dataPoints: [
            <?php foreach ($c_bulan->result() as $h) :  ?> {
                // x: new Date(<?= monthkoma($h->bulan) ?>),
                x: new Date('<?= $h->bulan ?>'),
                y: <?= $h->total ?>,
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
            <?php foreach ($c_bulan->result() as $h) :  ?> {
                // x: new Date(<?= monthkoma($h->bulan) ?>),
                x: new Date('<?= $h->bulan ?>'),
                y: <?= $h->untung ?>,
              },
            <?php endforeach ?>
          ]
        }
      ]
    });

    // GRAFIK TAHUNAN
    chartBln.render();
    var chartThn = new CanvasJS.Chart("chartYear", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Penjualan Tahunan"
      },
      axisX: {
        valueFormatString: "YYYY",
        intervalType: "year"
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
          xValueFormatString: "YYYY",
          yValueFormatString: "Rp #,##0",
          dataPoints: [
            <?php foreach ($c_tahun->result() as $h) :  ?> {
                x: new Date('<?= $h->tahun ?>'),
                y: <?= $h->total ?>,
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
            <?php foreach ($c_tahun->result() as $h) :  ?> {
                x: new Date('<?= $h->tahun ?>'),
                y: <?= $h->untung ?>,
              },
            <?php endforeach ?>
          ]
        }
      ]
    });
    chartThn.render();
  });
</script>

<!-- var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      title:{
        text: "Grafik Penjualan Harian",
        fontFamily: "arial black",
        fontColor: "#695A42"
      },
      axisX: {
        
        valueFormatString: "DD MMM",
      },
      axisY:{
        prefix: "Rp "
      },
      toolTip: {
        shared: true
      },
      data: [{
        type: "stackedArea",
        showInLegend: true,
        name: "Modal",
        xValueFormatString: "DD MMM, YYYY",
        toolTipContent: "{x}</br><span style='color:#4F81BC'><strong>{name}: </strong></span> {y}",
        dataPoints: [
          <?php foreach ($harian->result() as $h) :  ?>
            { x: new Date(<?= dateformatkoma($h->tanggal) ?>), y: <?= $h->modal ?> },
          <?php endforeach ?>
        ]
        },
        {        
          type: "stackedArea",
          showInLegend: true,
          name: "Laba",
          toolTipContent: "<span style='color:#C0504E'><strong>{name}: </strong></span> {y}<br><b>Total:<b> #total",
          dataPoints: [
            <?php foreach ($harian->result() as $h) :  ?>
              { x: new Date(<?= dateformatkoma($h->tanggal) ?>), y: <?= $h->untung ?> },
            <?php endforeach ?>
          ]
        },
    ]
    });
    chart.render(); -->