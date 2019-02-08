<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

global $SESSION;

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

echo $OUTPUT->heading('All records:');

$tablename = 'stats';
$records = $DB->get_records($tablename);

$table2 = new html_table();
$table2->head = array('Company', 'Year', 'SE', 'SC', 'AM', 'DS', 'EG', 'EH', 'IMBIT');
//Für jeden Datensatz
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

echo $OUTPUT->single_button(new moodle_url('/mod/sefutestplugin/view.php', array('id' => $cm->id)),
    'Back', $attributes = null);
// Finish the page.
echo $OUTPUT->footer();
