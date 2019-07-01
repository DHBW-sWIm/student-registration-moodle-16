<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');

require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');
include(__DIR__ . '/view_init.php');

global $SESSION;

if(isset($SESSION->formdata)) {
    // Table form Session var (last inserted record)
    echo $OUTPUT->heading('Inserted DB record:');

    //Tabelle
    $table = new html_table();
    $table->head = array('Company', 'Year', 'SE', 'SC', 'AM', 'DS', 'EG', 'EH', 'IMBIT');

    //Datensatz zuweisen
    $company = $SESSION->formdata->company;
    $year = $SESSION->formdata->year;
    $wi_se = $SESSION->formdata->wi_se;
    $wi_sc = $SESSION->formdata->wi_sc;
    $wi_am = $SESSION->formdata->wi_am;
    $wi_ds = $SESSION->formdata->wi_ds;
    $wi_eg = $SESSION->formdata->wi_eg;
    $wi_eh = $SESSION->formdata->wi_eh;
    $wi_imbit = $SESSION->formdata->wi_imbit;

    //Daten zuweisen an HTML-Tabelle
    $table->data[] = array($company, $year, $wi_se, $wi_sc, $wi_am, $wi_ds, $wi_eg, $wi_eh, $wi_imbit);

    //Tabelle ausgeben
    echo html_writer::table($table);
}

//table to show all records
echo $OUTPUT->heading('All records:');

//set db table
$tablename = 'stats';

// get records
$records = $DB->get_records($tablename);

// init html table
$table2 = new html_table();
$table2->head = array('Company', 'Year', 'SE', 'SC', 'AM', 'DS', 'EG', 'EH', 'IMBIT');

// bind data to html table
foreach ($records as $record) {
    $company = $record->company;
    $year = $record->year;
    $wi_se = $record->wi_se;
    $wi_sc = $record->wi_sc;
    $wi_am = $record->wi_am;
    $wi_ds = $record->wi_ds;
    $wi_eg = $record->wi_eg;
    $wi_eh = $record->wi_eh;
    $wi_imbit = $record->wi_imbit;

    //Daten zuweisen an HTML-Tabelle
    $table2->data[] = array($company, $year, $wi_se, $wi_sc, $wi_am, $wi_ds, $wi_eg, $wi_eh, $wi_imbit);
}
//Tabelle ausgeben
echo html_writer::table($table2);

// navigate to reports form
echo $OUTPUT->heading('To Reports');

// Implement form for navigation to report
// view_detial.php gets report_form class which extends moodleform
require_once(__DIR__ . '/forms/report_form.php');

$mform = new report_form();

$mform->render();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    $SESSION->report_cfg = $fromform;

    $returnurl = new moodle_url('/mod/sefutestplugin/view_report.php', array('id' => $cm->id));
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

// navigate back to add records form (view.php)
echo $OUTPUT->single_button(new moodle_url('/mod/sefutestplugin/view.php', array('id' => $cm->id)),
    'Back', $attributes = null);
// Finish the page.
echo $OUTPUT->footer();
