<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

global $SESSION;

//Example of using .ini
$ini = parse_ini_file(__DIR__ . '/.ini');
$camunda_url = $ini['camunda_url'];

$client = new GuzzleHttp\Client();

// Implement form for user
require_once(__DIR__ . '/forms/start_form.php');



//Variables
$wi_am_2020_plan = 31;
$wi_ds_2020_plan = 32;
$wi_eg_2020_plan = 28;
$wi_eh_2020_plan = 34;
$imbit_2020_plan = 33;
$wi_sc_2020_plan = 27;
$wi_se_2020_plan = 29;

$wi_am_2020_reg = 29;
$wi_ds_2020_reg = 28;
$wi_eg_2020_reg = 24;
$wi_eh_2020_reg = 26;
$imbit_2020_reg = 28;
$wi_sc_2020_reg = 26;
$wi_se_2020_reg = 22;


//Stacked bar chart Planned vs Actual registration
$chart11 = new core\chart_bar();
$chart11->set_stacked(true);
$chart11->set_title('Total WI 2020 planned compared to actual status');
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
$series_planned = new \core\chart_series('Remaining no. of students',
    [$wi_am_2020_plan_chart, $wi_ds_2020_plan_chart, $wi_eg_2020_plan_chart, $wi_eh_2020_plan_chart, $imbit_2020_plan_chart, $wi_sc_2020_plan_chart, $wi_se_2020_plan_chart]);
$chart11->add_series($series_actual);
$chart11->add_series($series_planned);
$chart11->set_labels(['WI-AM', 'WI-DS', 'WI-EG', 'WI-EH', 'IMBIT', 'WI-SC', 'WI-SE']);
   $CFG->chart_colorset = ['#E2001A', '#505C64'];

//Felix - YoY bar chart
$chart12 = new \core\chart_bar();
$chart12->set_title('Year over year comparison of actual registrations');
$past = new \core\chart_series('Year 2018', [12, 14, 18, 32, 40, 47, 178, 245, 380, 420, 430, 442 ]);
$actual = new \core\chart_series('Year 2019', [0,0,0,0,0, 38, 182, 237, 390, 410, 442,0]);
$chart12->add_series($past);
$chart12->add_series($actual);
$chart12->set_labels([date('F', strtotime('-11 month')), date('F', strtotime('-10 month')), date('F', strtotime('-9 month')), date('F', strtotime('-8 month')), date('F', strtotime('-7 month')), date('F', strtotime('-6 month')), date('F', strtotime('-5 month')), date('F', strtotime('-4 month')), date('F', strtotime('-3 month')), date('F', strtotime('-2 month')), date('F', strtotime('-1 month')), date('F') ]);
$CFG->chart_colorset = ['#E2001A', '#505C64'];

//Variables for pie charts
$wiam_curr_reg = 25;
$wiam_max_cap = 30;

$wids_curr_reg = 24;
$wids_max_cap = 31;

$wieg_curr_reg = 27;
$wieg_max_cap = 35;

$wieh_curr_reg = 21;
$wieh_max_cap = 34;

$imbit_curr_reg = 28;
$imbit_max_cap = 32;

$wisc_curr_reg = 29;
$wisc_max_cap = 31;

$wise_curr_reg = 21;
$wise_max_cap = 25;

$wiam_curr_reg = 17;
$wiam_max_cap = 21;

//doughnut chart WI-AM
$chart5 = new \core\chart_pie();
$chart5->set_doughnut(true);
$chart5->set_title('WI-AM course fill');
$series_doughnut5 = new core\chart_series("WI-AM course fill",[$wiam_curr_reg, $wiam_max_cap]);
$chart5->add_series($series_doughnut5);
$chart5->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-DS
$chart7 = new \core\chart_pie();
$chart7->set_doughnut(true);
$chart7->set_title('WI-DS course fill');
$series_doughnut7 = new core\chart_series("WI-DS course fill" , [$wids_curr_reg, $wids_max_cap]);
$chart7->add_series($series_doughnut7);
$chart7->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-EG
$chart8 = new \core\chart_pie();
$chart8->set_doughnut(true);
$chart8->set_title('WI-EG course fill');
$series_doughnut8 = new core\chart_series("WI-EG course fill",[$wieg_curr_reg, $wieg_max_cap]);
$chart8->add_series($series_doughnut8);
$chart8->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-EH
$chart9 = new \core\chart_pie();
$chart9->set_doughnut(true);
$chart9->set_title('WI-EH course fill');
$series_doughnut9 = new core\chart_series("WI-EH course fill",[$wieh_curr_reg, $wieh_max_cap]);
$chart9->add_series($series_doughnut9);
$chart9->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart IMBIT
$chart10 = new \core\chart_pie();
$chart10->set_doughnut(true);
$chart10->set_title('IMBIT course fill');
$series_doughnut10 = new core\chart_series("IMBIT course fill",[$imbit_curr_reg, $imbit_max_cap]);
$chart10->add_series($series_doughnut10);
$chart10->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-SC
$chart2 = new \core\chart_pie();
$chart2->set_doughnut(true);
$chart2->set_title('WI-SC course fill');
$series_doughnut2 = new core\chart_series("WI-SC course fill",[$wisc_curr_reg, $wisc_max_cap]);
$chart2->add_series($series_doughnut2);
$chart2->set_labels(['Currently registered', 'Maximum capacity']);

//doughnut chart WI-SE
$chart4 = new \core\chart_pie();
$chart4->set_doughnut(true);
$chart4->set_title('WI-SE course fill');
$series_doughnut4 = new core\chart_series("WI-SE course fill",[$wise_curr_reg, $wise_max_cap]);
$chart4->add_series($series_doughnut4);
$chart4->set_labels(['Currently registered', 'Maximum capacity']);


echo "<style>.grid-container{display:grid; grid-template-columns: 50% 50%; background-color: #FFFFFF; padding:10px;} </style><div class='grid-container'> <div>".$OUTPUT->render($chart11)."</div><div>".$OUTPUT->render($chart12)."</div></div>";
echo "<style>.grid-container2{display:grid; grid-template-columns: 25% 25% 25% 25%; background-color: #DCE2E6; padding:10px;} </style><div class='grid-container2'> <div>".$OUTPUT->render($chart5)."</div><div>".$OUTPUT->render($chart7)."</div><div>".$OUTPUT->render($chart8)."</div><div>".$OUTPUT->render($chart9)."</div></div>";
echo "<style>.grid-container3{display:grid; grid-template-columns: 25% 25% 25% 25%; background-color: #DCE2E6; padding:10px;} </style><div class='grid-container3'> <div>".$OUTPUT->render($chart10)."</div><div>".$OUTPUT->render($chart2)."</div><div>".$OUTPUT->render($chart4)."</div></div>";

// Finish the page.
echo $OUTPUT->footer();
