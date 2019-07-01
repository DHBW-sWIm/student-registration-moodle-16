<?php

require __DIR__ . '/vendor/autoload.php';
require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');

$id = required_param('id', PARAM_INT); // Course.

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);

$params = array(
    'context' => context_course::instance($course->id)
);
$event = \mod_studreg\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$strname = get_string('modulenameplural', 'mod_studreg');
$PAGE->set_url('/mod/studreg/index.php', array('id' => $id));
$PAGE->navbar->add($strname);
$PAGE->set_title("$course->shortname: $strname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('incourse');

echo $OUTPUT->header();
echo $OUTPUT->heading($strname);

if (!$studregs = get_all_instances_in_course('studreg', $course)) {
    notice(get_string('nonewmodules', 'studreg'), new moodle_url('/course/v_studentreg.php', array('id' => $course->id)));
}

$usesections = course_format_uses_sections($course->format);

$table_inserted_record = new html_table();
$table_inserted_record->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_' . $course->format);
    $table_inserted_record->head = array($strsectionname, $strname);
    $table_inserted_record->align = array('center', 'left');
} else {
    $table_inserted_record->head = array($strname);
    $table_inserted_record->align = array('left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($modinfo->instances['studreg'] as $cm) {
    $row = array();
    if ($usesections) {
        if ($cm->sectionnum !== $currentsection) {
            if ($cm->sectionnum) {
                $row[] = get_section_name($course, $cm->sectionnum);
            }
            if ($currentsection !== '') {
                $table_inserted_record->data[] = 'hr';
            }
            $currentsection = $cm->sectionnum;
        }
    }

    $class = $cm->visible ? null : array('class' => 'dimmed');

    $row[] = html_writer::link(new moodle_url('v_studentreg.php', array('id' => $cm->id)),
        $cm->get_formatted_name(), $class);
    $table_inserted_record->data[] = $row;
}

echo html_writer::table($table_inserted_record);

echo $OUTPUT->footer();
