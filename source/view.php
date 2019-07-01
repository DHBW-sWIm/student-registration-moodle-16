<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

// @todo Replace the following lines with you own code.

global $SESSION;

echo $OUTPUT->heading('Studenten-Registrierungen nach Monaten');

// Implement form for user
require_once(__DIR__ . '/forms/start_form.php');

//Tabelle

//Datensatz zuweisen$table = new html_table();
//$table->head = array('ID', 'Name', 'Email');

//$id = $SESSION->formdata->id;
//$name = $SESSION->formdata->name;
//$email = $SESSION->formdata->email;

//Daten zuweisen an HTML-Tabelle
//$table->data[] = array($id, $name, $email);

//Tabelle ausgeben
//echo html_writer::table($table);

//Form
//$mform = new start_form();
//$mform->render();






$chart = new \core\chart_bar();
$past = new \core\chart_series('Jahr 2018', [12, 14, 18, 32, 40, 47, 178, 245, 380, 420, 430, 442 ]);
$actual = new \core\chart_series('Jahr 2019', [0,0,0,0,0, 38, 182, 237, 390, 410, 442,0]);
$chart->add_series($past);
$chart->add_series($actual);
$chart->set_labels([date('F', strtotime('-11 month')), date('F', strtotime('-10 month')), date('F', strtotime('-9 month')), date('F', strtotime('-8 month')), date('F', strtotime('-7 month')), date('F', strtotime('-6 month')), date('F', strtotime('-5 month')), date('F', strtotime('-4 month')), date('F', strtotime('-3 month')), date('F', strtotime('-2 month')), date('F', strtotime('-1 month')), date("F") ]);
echo $OUTPUT->render($chart);

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Remove SESSION data for form
    unset($SESSION->formdata);
    // Redirect to the course main page.
    $returnurl = new moodle_url('/mod/felixmod/view.php', array('id' => $cm->id));
    redirect($returnurl);

    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    // Redirect to the course result page.
    $returnurl = new moodle_url('/mod/felixmod/view_end.php', array('id' => $cm->id));
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
