<?php

// DO NOT TOUCH THIS FILE

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n = optional_param('n', 0, PARAM_INT);  // ... recordhours instance ID - it should be named as the first character of the module.

if ($id) {
    $cm = get_coursemodule_from_id('recordhours', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $recordhours = $DB->get_record('recordhours', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $recordhours = $DB->get_record('recordhours', array('id' => $n), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $recordhours->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('recordhours', $recordhours->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_recordhours\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $recordhours);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/recordhours/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($recordhours->name));
$PAGE->set_heading(format_string($course->fullname));

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($recordhours->intro) {
    echo $OUTPUT->box(format_module_intro('recordhours', $recordhours, $cm->id), 'generalbox mod_introbox', 'recordhoursintro');
}
