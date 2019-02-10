<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

include(__DIR__ . '/view_init.php');

global $SESSION;

// select table
$tablename = 'stats';

// get records
$records = $DB->get_records($tablename);

// init html table1 (compare year1 to year2)
$table1 = new html_table();
$table1->head = array('Company', 'Year', 'Total', 'SE', 'SC', 'AM', 'DS', 'EG', 'EH', 'IMBIT', 'Year', 'Total', 'SE', 'SC', 'AM', 'DS', 'EG', 'EH', 'IMBIT');
$sum1 = array('SUM', $SESSION->report_cfg->year1, 0, 0, 0, 0, 0, 0, 0, 0, $SESSION->report_cfg->year2, 0, 0, 0, 0, 0, 0, 0, 0);

// init html table2 (difference between year1 and year2)
$table2 = new html_table();
$table2->head = array('Company', 'Total', 'SE', 'SC', 'AM', 'DS', 'EG', 'EH', 'IMBIT');
$sum2 = array('SUM', 0, 0, 0, 0, 0, 0, 0, 0);

$companies = array();

foreach ($records as $record){
    array_push($companies, $record->company);
}

$companies = array_unique($companies);
echo $OUTPUT->heading(implode(',',$companies));

// bind data to html table
foreach ($companies as $comp) {
    // setting year 1
    $company = $comp;
    $year_1 = $SESSION->report_cfg->year1;
    $total_1 = 0;
    $wi_se_1 = 0;
    $wi_sc_1 = 0;
    $wi_am_1 = 0;
    $wi_ds_1 = 0;
    $wi_eg_1 = 0;
    $wi_eh_1 = 0;
    $wi_imbit_1 = 0;

    foreach ($records as $record){
        if($record->company == $company && $record->year == $year_1){
            $total_1 = $record->wi_se + $record->wi_sc + $record->wi_am + $record->wi_ds + $record->wi_eg + $record->wi_eh + $record->wi_imbit;
            $wi_se_1 = $record->wi_se;
            $wi_sc_1 = $record->wi_sc;
            $wi_am_1 = $record->wi_am;
            $wi_ds_1 = $record->wi_ds;
            $wi_eg_1 = $record->wi_eg;
            $wi_eh_1 = $record->wi_eh;
            $wi_imbit_1 = $record->wi_imbit;
        }
    }

    // setting year 2
    $year_2 = $SESSION->report_cfg->year2;
    $total_2 = 0;
    $wi_se_2 = 0;
    $wi_sc_2 = 0;
    $wi_am_2 = 0;
    $wi_ds_2 = 0;
    $wi_eg_2 = 0;
    $wi_eh_2 = 0;
    $wi_imbit_2 = 0;

    foreach ($records as $record){
        if($record->company == $company && $record->year == $year_2){
            $total_2 = $record->wi_se + $record->wi_sc + $record->wi_am + $record->wi_ds + $record->wi_eg + $record->wi_eh + $record->wi_imbit;
            $wi_se_2 = $record->wi_se;
            $wi_sc_2 = $record->wi_sc;
            $wi_am_2 = $record->wi_am;
            $wi_ds_2 = $record->wi_ds;
            $wi_eg_2 = $record->wi_eg;
            $wi_eh_2 = $record->wi_eh;
            $wi_imbit_2 = $record->wi_imbit;
        }
    }

    // calculate difference
    $total_dif = $total_1 - $total_2;
    $wi_se_dif = $wi_se_1 - $wi_se_2;
    $wi_sc_dif = $wi_sc_1 - $wi_sc_2;
    $wi_am_dif = $wi_am_1 - $wi_am_2;
    $wi_ds_dif = $wi_ds_1 - $wi_ds_2;
    $wi_eg_dif = $wi_eg_1 - $wi_eg_2;
    $wi_eh_dif = $wi_eh_1 - $wi_eh_2;
    $wi_imbit_dif = $wi_imbit_1 - $wi_imbit_2;

    // setting sum row
    $sum1[2] += $total_1;
    $sum1[3] += $wi_se_1;
    $sum1[4] += $wi_sc_1;
    $sum1[5] += $wi_am_1;
    $sum1[6] += $wi_ds_1;
    $sum1[7] += $wi_eg_1;
    $sum1[8] += $wi_eh_1;
    $sum1[9] += $wi_imbit_1;
    $sum1[11] += $total_2;
    $sum1[12] += $wi_se_2;
    $sum1[13] += $wi_sc_2;
    $sum1[14] += $wi_am_2;
    $sum1[15] += $wi_ds_2;
    $sum1[16] += $wi_eg_2;
    $sum1[17] += $wi_eh_2;
    $sum1[18] += $wi_imbit_2;

    $sum2[1] +=  $total_dif;
    $sum2[2] +=  $wi_se_dif;
    $sum2[3] +=  $wi_sc_dif;
    $sum2[4] +=  $wi_am_dif;
    $sum2[5] +=  $wi_ds_dif;
    $sum2[6] +=  $wi_eg_dif;
    $sum2[7] +=  $wi_eh_dif;
    $sum2[8] +=  $wi_imbit_dif;


    //Daten zuweisen an HTML-Tabelle
    $table1->data[] = array($company, $year_1, $total_1, $wi_se_1, $wi_sc_1, $wi_am_1, $wi_ds_1, $wi_eg_1, $wi_eh_1, $wi_imbit_1, $year_2, $total_2, $wi_se_2, $wi_sc_2, $wi_am_2, $wi_ds_2, $wi_eg_2, $wi_eh_2, $wi_imbit_2);
    $table2->data[] = array($company, $total_dif, $wi_se_dif, $wi_sc_dif, $wi_am_dif, $wi_ds_dif, $wi_eg_dif, $wi_eh_dif, $wi_imbit_dif);

}

//Daten zuweisen an HTML-Tabelle
$table1->data[] = $sum1;
$table2->data[] = $sum2;

// show report (company comparason YoY)
echo $OUTPUT->heading('Compare '.$SESSION->report_cfg->year1.' to '.$SESSION->report_cfg->year2);

// show table
echo html_writer::table($table1);

// show report (company difference YoY)
echo $OUTPUT->heading('Difference:');

// show table
echo html_writer::table($table2);

// navigate back to detail view (view_detail.php)
echo $OUTPUT->single_button(new moodle_url('/mod/sefutestplugin/view_detail.php', array('id' => $cm->id)),
    'Back', $attributes = null);

// Finish the page.
echo $OUTPUT->footer();
