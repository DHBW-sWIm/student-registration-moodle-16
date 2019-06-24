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

$mform = new start_form();

$chart = new \core\chart_line();
$series1 = new \core\chart_series('Jahr 2018',[23,45,75,111,132,420]);
$series2 = new \core\chart_series('Jahr 2019',[22,41,63,121,224,420]);
$chart->add_series($series1);
$chart->add_series($series2);
$chart->set_labels(['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni']);
echo "<div style='padding:50%; padding-left:0; padding-top:0'>".$OUTPUT->render($chart)."</div>";


$mform->render();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    $SESSION->formdata = $fromform;
    $returnurl = new moodle_url('/mod/dmtestplugin/view_detail.php', array('id' => $cm->id));
    redirect($returnurl);
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    // Set default data (if any)
    // Required for module not to crash as a course id is always needed
    $formdata = array('id' => $id);
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
}

// Finish the page.
echo $OUTPUT->footer();
