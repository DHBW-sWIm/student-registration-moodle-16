<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

global $SESSION;

echo $OUTPUT->heading('Student Registration Prototype');

// Implement form for user
// view.php gets start_form class which extends moodleform

require_once(__DIR__ . '/forms/start_form.php');

$mform = new start_form();

$mform->render();


$tablename = 'students';
$records = $DB->get_records_select($tablename,  $params=null);
$table_all_records = new html_table();
$table_all_records->head = array('First Name', 'Surname', 'Email Address', 'Date of Birth', 'Course', 'Company');

// bind data to html table
foreach ($records as $record) {
    $firstname = $record->firstname;
    $surname = $record->surname;
    $email = $record->email;
    $birthdate = $record->gmdate("d-m-Y", birthdate);
    $course = $record->course;
    $company = $record->company;
    $table_all_records->data[] = array($firstname, $surname, $email, $birthdate, $course, $company);
}

// print table
echo html_writer::table($table_all_records);


//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    $SESSION->formdata = $fromform;

    $record = new stdClass();
    $record->firstname = $fromform->firstname;
    $record->surname = $fromform->surname;
    $record->email = $fromform->email;
    $record->birthdate = $fromform->birthdate;
    $record->course = $fromform->course;
    $record->company = $fromform->company;

    $lastinsertid = $DB->insert_record('students', $record, false);
    $table_all_records.refresh();
    $mform = new start_form();
    $mform->render();

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
echo $OUTPUT->footer();
