<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

// @todo Replace the following lines with you own code.

global $SESSION;

//Example of using .ini
$ini = parse_ini_file(__DIR__ . '/.ini');
$camunda_url = $ini['camunda_url'];

$client = new GuzzleHttp\Client();

// Implement form for user
require_once(__DIR__ . '/forms/start_form.php');

//_______________________________________________________________________________________________________

//fetch course data from db -> need adjustment!!
//$records = $DB->get_records_select($tablename = 'students', \'company = ?', array($USER->institution));

$happy = array();  //Bence's

foreach ($records as $record) {
    $course  = $record->course;
    //$year     = $record->year;
    $wi_se    = $record->wi_se;
    $wi_sc    = $record->wi_sc;
    $wi_am    = $record->wi_am;
    $wi_ds    = $record->wi_ds;
    $wi_eg    = $record->wi_eg;
    $wi_eh    = $record->wi_eh;
    $wi_imbit = $record->wi_imbit;

    $table_all_records->data[] = array($course, $year, $wi_se, $wi_sc, $wi_am, $wi_ds, $wi_eg, $wi_eh, $wi_imbit);
/*/if ($record->course=$wi_se){
then $counter_wi_se}
else if ($record->course=$wi_sc){*/
}

//$wi_total_reg=$wi_se+$wi_sc+$wi_am+$wi_ds+$wi_eg+$wi_eh+$wi_imbit;

//fetching registration numbers per course & assigning them to variables
foreach ($students as $record) {
    $course = $record->course;
    $year = $record->year;
    $wi_se = $record->wi_se;
    $wi_sc = $record->wi_sc;
    $wi_am = $record->wi_am;
    $wi_ds = $record->wi_ds;
    $wi_eg = $record->wi_eg;
    $wi_eh = $record->wi_eh;
    $wi_imbit = $record->wi_imbit;
    if (isset($happy[$record->course])) $happy[$record->course]++; else $happy[$record->course] = 1;
    $table_all_records->data[] = array($course, $year, $wi_se, $wi_sc, $wi_am, $wi_ds, $wi_eg, $wi_eh, $wi_imbit);
}

//doughnut chart overview planned vs. registered
    $chart3 = new \core\chart_pie();
//$chart3->set_doughnut(true);
    $chart3->set_title('2020 WI courses total fill rate');
    $series_doughnut1 = new core\chart_series('Planned', $happy);
    $chart3->add_series($series_doughnut1);
    $chart3->set_labels(['Planned', 'Currently registered']);
    $CFG->chart_colorset = ['#E2001A', '#7D8990'];
    echo "<div style='padding:50%; padding-left:0; padding-top:0'>".$OUTPUT->render($chart3)."</div>";

//Stacked bar chart Planned vs Actual registration
$chart11 = new core\chart_bar();
$chart11->set_stacked(true);
$chart11->set_title('Total WI 2020 planned vs actual status');
$series_actual = new \core\chart_series('Registered no. students',
    [$wi_am_2020_reg, $wi_ds_2020_reg, $wi_eg_2020_reg, $wi_eh_2020_reg, $imbit_2020_reg, $wi_sc_2020_reg, $wi_se_2020_reg]);
//adjusting stacked bar chart to percentual (registered as % of planned)
$wi_am_2020_plan_chart = $wi_am_2020_plan-$wi_am_2020_reg;
$wi_ds_2020_plan_chart = $wi_ds_2020_plan-$wi_ds_2020_reg;
$wi_eg_2020_plan_chart = $wi_eg_2020_plan-$wi_eg_2020_reg;
$wi_eh_2020_plan_chart = $wi_eh_2020_plan-$wi_eh_2020_reg;
$imbit_2020_plan_chart = $imbit_2020_plan-$imbit_2020_reg;
$wi_sc_2020_plan_chart = $wi_sc_2020_plan-$wi_sc_2020_reg;
$wi_se_2020_plan_chart = $wi_se_2020_plan-$wi_se_2020_reg;
$series_planned = new \core\chart_series('Planned no. students',
    [$wi_am_2020_plan_chart, $wi_ds_2020_plan_chart, $wi_eg_2020_plan_chart, $wi_eh_2020_plan_chart, $imbit_2020_plan_chart, $wi_sc_2020_plan_chart, $wi_se_2020_plan_chart]);
$chart11->add_series($series_planned);
$chart11->add_series($series_actual);
$chart11->set_labels(['WI-AM', 'WI-DS', 'WI-EG', 'WI-EH', 'IMBIT', 'WI-SC', 'WI-SE']);
   $CFG->chart_colorset = ['#E2001A', '#505C64'];
//    echo "<div style='padding:50%; padding-left:0; padding-top:0'>".$OUTPUT->render($chart11)."</div>";

//Felix - YoY bar chart
$chart12 = new \core\chart_bar();
$past = new \core\chart_series('Jahr 2018', [12, 14, 18, 32, 40, 47, 178, 245, 380, 420, 430, 442 ]);
$actual = new \core\chart_series('Jahr 2019', [0,0,0,0,0, 38, 182, 237, 390, 410, 442,0]);
$chart12->add_series($past);
$chart12->add_series($actual);
$chart12->set_labels([date('F', strtotime('-11 month')), date('F', strtotime('-10 month')), date('F', strtotime('-9 month')), date('F', strtotime('-8 month')), date('F', strtotime('-7 month')), date('F', strtotime('-6 month')), date('F', strtotime('-5 month')), date('F', strtotime('-4 month')), date('F', strtotime('-3 month')), date('F', strtotime('-2 month')), date('F', strtotime('-1 month')), date(“F”) ]);
   $CFG->chart_colorset = ['#E2001A', '#505C64'];
//    echo "<div style='padding:50%; padding-left:0; padding-top:0'>".$OUTPUT->render($chart12)."</div>";
echo "<style>.grid-container{display:grid; grid-template-columns: 25% 25% 25% 25%; background-color: #7D8990; padding:10px;} </style><div class='grid-container'> <div>".$OUTPUT->render($chart11)."</div><div>".$OUTPUT->render($chart12)."</div><div>";

//doughnut chart WI-AM
$chart5 = new \core\chart_pie();
$chart5->set_doughnut(true);
$chart5->set_title('WI-AM course fill');
$series_doughnut2 = new core\chart_series($wisc_curr_reg, $wisc_max_cap);
$chart5->add_series($series_doughnut2);
$chart5->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-DS
$chart7 = new \core\chart_pie();
$chart7->set_doughnut(true);
$chart7->set_title('WI-DS course fill');
$series_doughnut2 = new core\chart_series($wids_curr_reg, $wids_max_cap);
$chart7->add_series($series_doughnut2);
$chart7->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-EG
$chart8 = new \core\chart_pie();
$chart8->set_doughnut(true);
$chart8->set_title('WI-EG course fill');
$series_doughnut2 = new core\chart_series($wieg_curr_reg, $wieg_max_cap);
$chart8->add_series($series_doughnut2);
$chart8->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-EH
$chart9 = new \core\chart_pie();
$chart9->set_doughnut(true);
$chart9->set_title('WI-EH course fill');
$series_doughnut2 = new core\chart_series($wieh_curr_reg, $wieh_max_cap);
$chart9->add_series($series_doughnut2);
$chart9->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart IMBIT
$chart10 = new \core\chart_pie();
$chart10->set_doughnut(true);
$chart10->set_title('IMBIT course fill');
$series_doughnut2 = new core\chart_series($imbit_curr_reg, $imbit_max_cap);
$chart10->add_series($series_doughnut2);
$chart10->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-SC
    $chart2 = new \core\chart_pie();
    $chart2->set_doughnut(true);
    $chart2->set_title('WI-SC course fill');
    $series_doughnut2 = new core\chart_series($wisc_curr_reg, $wisc_max_cap);
    $chart2->add_series($series_doughnut2);
    $chart2->set_labels(['Currently registered', 'Maximum capacity']);
//echo "<div style='padding:50%; padding-left:0'>" . $OUTPUT->render($chart2) . "</div>";

//doughnut chart WI-SE
    $chart4 = new \core\chart_pie();
    $chart4->set_doughnut(true);
    $chart4->set_title('WI-SE course fill');
    $series_doughnut2 = new core\chart_series($wisc_curr_reg, $wisc_max_cap);
    $chart4->add_series($series_doughnut2);
    $chart4->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-AM
    $chart6 = new \core\chart_pie();
    $chart6->set_doughnut(true);
    $chart6->set_title('WI-AM course fill');
    $series_doughnut2 = new core\chart_series($wisc_curr_reg, $wisc_max_cap);
    $chart6->add_series($series_doughnut2);
    $chart6->set_labels(['Currently registered', 'Maximum capacity']);

echo "<style>.grid-container{display:grid; grid-template-columns: 25% 25% 25% 25%; background-color: #dce2e6; padding:10px;} </style><div class='grid-container'> <div>".$OUTPUT->render($chart2)."</div><div>".$OUTPUT->render($chart4)."</div><div>".$OUTPUT->render($chart5)."</div><div>".$OUTPUT->render($chart6)."</div></div>".$OUTPUT->render($chart7)."</div></div>".$OUTPUT->render($chart8)."</div></div>".$OUTPUT->render($chart9)."</div></div>".$OUTPUT->render($chart10)."</div></div>";

// Finish the page.
echo $OUTPUT->footer();
