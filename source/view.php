<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

// @todo Replace the following lines with you own code.

global $SESSION;

echo $OUTPUT->heading('Record planned Lecture Hours');

echo('Table showing all planned Lecutre');

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
//Insert Entry Fields

    $record = new stdClass();
    $record->company      = $fromform->company;
    $record->year         = $fromform->lecturer;
    $record->wi_se        = $fromform->company;


    $lastinsertid = $DB->insert_record('recordhours', $record, false);

    // Create Table with contents of DB - tbd

    $tablename = 'recordedleccturehours';
    //$records = $DB->get_records_select($tablename,  $params=null);
    $table_all_records = new html_table();
    $table_all_records->head = array('Company', 'Lecutrer Name', 'Recorded Hours');

    // bind data to html table
    foreach ($records as $record) {
        $company = $record->company;
        $lecturer = $record->lecturer;
        $count_hours = $record->count_hours;


        $table_all_records->data[] = array($company, $lecturer,  $count_hours );
    }
    // print table
    echo html_writer::table($table_all_records);





    // redirect user
    $returnurl = new moodle_url('/mod/studentregistration/view_end.php', array('id' => $cm->id));
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
