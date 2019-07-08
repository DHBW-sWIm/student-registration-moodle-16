<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

global $SESSION;

echo $OUTPUT->heading('Student Registration Prototype');

// Implement form for user
// v_coursereg.php gets fstudentreg class which extends moodleform

require_once(__DIR__ . '/forms/f_coursereg.php');

$mform = new fstudentreg();

$mform->render();


$tablename = 'studentregistration_students';
$records = $DB->get_records_select($tablename,  $params=null);
$table_all_records = new html_table();
$table_all_records->head = array('Course acronym', 'No. of students', 'Study program', 'Program director', 'Specialisation', 'Year group', 'Semester start');

// bind data to html table
foreach ($records as $record) {
    $courseacronym = $record->courseacronym;
    $noofstudents = $record->noofstudents;
    $studyprogram = $record->studyprogram;
    $programdirector = $record->programdirector;
    $specialisation = $record->specialisation;
    $yeargroup = $record->yeargroup;
    $semesterstart = $record->semesterstart;
    $table_all_records->data[] = array($courseacronym, $noofstudents, $studyprogram, $programdirector, $specialisation, $yeargroup, $semesterstart);
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
    $record->courseacronym = $fromform->courseacronym;
    $record->noofstudents = $fromform->noofstudents;
    $record->studyprogram = $fromform->studyprogram;
    $record->programdirector = $fromform->programdirector;
    $record->specialisation = $fromform->specialisation;
    $record->yeargroup = $fromform->yeargroup;
    $record->semesterstart = $fromform->semesterstart;

    $lastinsertid = $DB->insert_record($tablename, $record, false);
    $returnurl = new moodle_url('/mod/studentregistration/v_coursereg.php', array('id' => $cm->id));
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
echo $OUTPUT->footer();
