<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row padding20">
    <?php if ($this->session->flashdata("msg_sukses") != "") { ?>
        <div class="row" id="notif">
            <div class="padding10 bg-green fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_sukses"); ?></div>
        </div>
    <?php } else if ($this->session->flashdata("msg_eror") != "") { ?>
        <div class="row" id="notif">
            <div class="padding10 bg-red fg-white text-light"><span class="mif-warning"></span> <?php echo $this->session->flashdata("msg_eror"); ?></div>
        </div>
    <?php } ?>
    <h2 class="text-light fg-orange" style="margin-top: 2px;"> <?php echo config_item('APP_FULL_NAME'); ?> (<?php echo config_item('APP_SHORT_NAME'); ?>)</h2>
    <hr class="thin bg-orange">
    <div class="row grid">
        <div class="cell colspan4">
            <img src="<?php echo base_url(); ?>_temp/img/logo_pa_pku.png" class="place-left margin10" style="height: 230px">            
        </div>
        <div class="cell colspan8" style="margin-top: 60px">
            <h1 class="text-light fg-darkGreen"><?php echo config_item('APP_COMPANY_NAME'); ?></h1>
            <h4 class="text-light fg-darkGreen"><?php echo config_item('APP_COMPANY_ADDRES'); ?></h4>
            <h6 class="text-light fg-darkGreen"><?php echo config_item('APP_COMPANY_WEBMAIL'); ?></h6>
        </div>
    </div>
<!--    <div class="row">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>-->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#notif").fadeOut(7000);
    });
    
    // Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['Work', 8],
  ['Friends', 2],
  ['Eat', 2],
  ['TV', 3],
  ['Gym', 2],
  ['Sleep', 7]
]);

  // Optional; add a title and set the width and height of the chart
//  var options = {
//          title: 'My Daily Activities'
//        };
        //code 3D
var options = {
          title: 'My Daily Activities',
          is3D: true,
        };
//code 2 D tapi ada label
//var options = {
//        legend: 'none',
//        pieSliceText: 'label',
//        title: 'Swiss Language Use (100 degree rotation)',
//        pieStartAngle: 100,
//      };
  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
//  var chart = new google.visualization.BarChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>