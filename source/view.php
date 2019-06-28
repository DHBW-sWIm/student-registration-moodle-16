<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

// @todo Replace the following lines with you own code.

global $SESSION;

echo $OUTPUT->heading('Start');

echo('Example of using HTTP Request to get Camunda User Object via REST API and print out in table');

$users = get_all_camunda_users();
//Tabelle mit camunda
$table = new html_table();
$table->head = array('ID', 'Firstname', 'Name');
foreach ($users as $user) {
    $table->data[] = array($user['id'], $user['firstName'], $user['lastName']);
}
echo html_writer::table($table);

// Implement form for user
require_once(__DIR__ . '/forms/start_form.php');

$mform = new start_form();

$mform->render();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    $SESSION->formdata = $fromform;

    //======================================================================
    // GET AND PROCESS FORM DATA
    //======================================================================

    $variables = [
            'student_name' => camunda_string($fromform->student_name),
            'student_matnr' => camunda_string($fromform->student_matnr),
            'student_reason' => camunda_string($fromform->student_reason),
            'student_length' => camunda_date_from_form($fromform->student_length)
    ];
    // start process with key and data variables (method from locallib.php)
    start_process('bpx-mvp-process', $variables);

    $SESSION->TESTING->variables = $variables;

    // redirect user
    $returnurl = new moodle_url('/mod/recordhours/view_end.php', array('id' => $cm->id));
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
