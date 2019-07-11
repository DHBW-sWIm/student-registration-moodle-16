<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

global $SESSION;

echo $OUTPUT->heading('Record planned lecture hours');

// Implement form for user
require_once(__DIR__ . '/forms/f_lecturehours.php');

$mform = new flecturehours();

$mform->render();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    $SESSION->formdata = $fromform;
//Insert Entry Fields

    $tablename = 'studentregistration_hours';

    $record = new stdClass();
    $record->firstname = $fromform->fname;
    $record->surname   = $fromform->surname;
    $record->company   = $fromform->company;
    $record->hours     = $fromform->hours;
    $record->exams     = $fromform->exams;
    $record->papers     = $fromform->papers;

/*    // insert $record
    $lastinsertid = $DB->insert_record($tablename, $record, false);

    // get all records
    $records = $DB->get_records($tablename, $params=null);
    $table_all_records = new html_table();
    $table_all_records->head = array('First Name', 'Last Name', 'Company', 'Recorded Hours');

    // bind data to html table
    foreach ($records as $record) {
        $firstname = $record->firstname;
        $surname   = $record->surname;
        $company   = $record->company;
        $hours     = $record->hours;

        $table_all_records->data[] = array($firstname, $surname, $company, $hours);
    }

    // display records
    echo html_writer::table($table_all_records);*/

    // redirect user
    $returnurl = new moodle_url('/mod/studentregistration/v_lecturehours.php', array('id' => $cm->id));
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
