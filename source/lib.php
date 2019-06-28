<?php

/**
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 *
 * All the  specific functions, needed to implement all the module
 * logic, should go to locallib.php.
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Example constant, you probably want to remove this :-)
 */
define('recordhours_ULTIMATE_ANSWER', 42);

/* Moodle core API */

/**
 * Returns the information on whether the module supports a feature
 *
 * See {@link plugin_supports()} for more info.
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown
 */
function recordhours_supports($feature) {

    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return true;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the recordhours into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param stdClass $recordhours Submitted data from the form in mod_form.php
 * @param mod_recordhours_mod_form $mform The form instance itself (if needed)
 * @return int The id of the newly inserted recordhours record
 */
function recordhours_add_instance(stdClass $recordhours, mod_recordhours_mod_form $mform = null) {
    global $DB;

    $recordhours->timecreated = time();

    // You may have to add extra stuff in here.

    $recordhours->id = $DB->insert_record('recordhours', $recordhours);

    recordhours_grade_item_update($recordhours);

    return $recordhours->id;
}

/**
 * Updates an instance of the recordhours in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param stdClass $recordhours An object from the form in mod_form.php
 * @param mod_recordhours_mod_form $mform The form instance itself (if needed)
 * @return boolean Success/Fail
 */
function recordhours_update_instance(stdClass $recordhours, mod_recordhours_mod_form $mform = null) {
    global $DB;

    $recordhours->timemodified = time();
    $recordhours->id = $recordhours->instance;

    // You may have to add extra stuff in here.

    $result = $DB->update_record('recordhours', $recordhours);

    recordhours_grade_item_update($recordhours);

    return $result;
}

/**
 * This standard function will check all instances of this module
 * and make sure there are up-to-date events created for each of them.
 * If courseid = 0, then every recordhours event in the site is checked, else
 * only recordhours events belonging to the course specified are checked.
 * This is only required if the module is generating calendar events.
 *
 * @param int $courseid Course ID
 * @return bool
 */
function recordhours_refresh_events($courseid = 0) {
    global $DB;

    if ($courseid == 0) {
        if (!$recordhourss = $DB->get_records('recordhours')) {
            return true;
        }
    } else {
        if (!$recordhourss = $DB->get_records('recordhours', array('course' => $courseid))) {
            return true;
        }
    }

    foreach ($recordhourss as $recordhours) {
        // Create a function such as the one below to deal with updating calendar events.
        // recordhours_update_events($recordhours);
    }

    return true;
}

/**
 * Removes an instance of the recordhours from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function recordhours_delete_instance($id) {
    global $DB;

    if (!$recordhours = $DB->get_record('recordhours', array('id' => $id))) {
        return false;
    }

    // Delete any dependent records here.

    $DB->delete_records('recordhours', array('id' => $recordhours->id));

    recordhours_grade_item_delete($recordhours);

    return true;
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 *
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @param stdClass $course The course record
 * @param stdClass $user The user record
 * @param cm_info|stdClass $mod The course module info object or record
 * @param stdClass $recordhours The recordhours instance record
 * @return stdClass|null
 */
function recordhours_user_outline($course, $user, $mod, $recordhours) {

    $return = new stdClass();
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * It is supposed to echo directly without returning a value.
 *
 * @param stdClass $course the current course record
 * @param stdClass $user the record of the user we are generating report for
 * @param cm_info $mod course module info
 * @param stdClass $recordhours the module instance record
 */
function recordhours_user_complete($course, $user, $mod, $recordhours) {
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in recordhours activities and print it out.
 *
 * @param stdClass $course The course record
 * @param bool $viewfullnames Should we display full names
 * @param int $timestart Print activity since this timestamp
 * @return boolean True if anything was printed, otherwise false
 */
function recordhours_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;
}

/**
 * Prepares the recent activity data
 *
 * This callback function is supposed to populate the passed array with
 * custom activity records. These records are then rendered into HTML via
 * {@link recordhours_print_recent_mod_activity()}.
 *
 * Returns void, it adds items into $activities and increases $index.
 *
 * @param array $activities sequentially indexed array of objects with added 'cmid' property
 * @param int $index the index in the $activities to use for the next record
 * @param int $timestart append activity since this time
 * @param int $courseid the id of the course we produce the report for
 * @param int $cmid course module id
 * @param int $userid check for a particular user's activity only, defaults to 0 (all users)
 * @param int $groupid check for a particular group's activity only, defaults to 0 (all groups)
 */
function recordhours_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid = 0, $groupid = 0) {
}

/**
 * Prints single activity item prepared by {@link recordhours_get_recent_mod_activity()}
 *
 * @param stdClass $activity activity record with added 'cmid' property
 * @param int $courseid the id of the course we produce the report for
 * @param bool $detail print detailed report
 * @param array $modnames as returned by {@link get_module_types_names()}
 * @param bool $viewfullnames display users' full names
 */
function recordhours_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Function to be run periodically according to the moodle cron
 *
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * Note that this has been deprecated in favour of scheduled task API.
 *
 * @return boolean
 */
function recordhours_cron() {
    return true;
}

/**
 * Returns all other caps used in the module
 *
 * For example, this could be array('moodle/site:accessallgroups') if the
 * module uses that capability.
 *
 * @return array
 */
function recordhours_get_extra_capabilities() {
    return array();
}

/* Gradebook API */

/**
 * Is a given scale used by the instance of recordhours?
 *
 * This function returns if a scale is being used by one recordhours
 * if it has support for grading and scales.
 *
 * @param int $recordhoursid ID of an instance of this module
 * @param int $scaleid ID of the scale
 * @return bool true if the scale is used by the given recordhours instance
 */
function recordhours_scale_used($recordhoursid, $scaleid) {
    global $DB;

    if ($scaleid and $DB->record_exists('recordhours', array('id' => $recordhoursid, 'grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if scale is being used by any instance of recordhours.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param int $scaleid ID of the scale
 * @return boolean true if the scale is used by any recordhours instance
 */
function recordhours_scale_used_anywhere($scaleid) {
    global $DB;

    if ($scaleid and $DB->record_exists('recordhours', array('grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Creates or updates grade item for the given recordhours instance
 *
 * Needed by {@link grade_update_mod_grades()}.
 *
 * @param stdClass $recordhours instance object with extra cmidnumber and modname property
 * @param bool $reset reset grades in the gradebook
 * @return void
 */
function recordhours_grade_item_update(stdClass $recordhours, $reset = false) {
    global $CFG;
    require_once($CFG->libdir . '/gradelib.php');

    $item = array();
    $item['itemname'] = clean_param($recordhours->name, PARAM_NOTAGS);
    $item['gradetype'] = GRADE_TYPE_VALUE;

    if ($recordhours->grade > 0) {
        $item['gradetype'] = GRADE_TYPE_VALUE;
        $item['grademax'] = $recordhours->grade;
        $item['grademin'] = 0;
    } else if ($recordhours->grade < 0) {
        $item['gradetype'] = GRADE_TYPE_SCALE;
        $item['scaleid'] = -$recordhours->grade;
    } else {
        $item['gradetype'] = GRADE_TYPE_NONE;
    }

    if ($reset) {
        $item['reset'] = true;
    }

    grade_update('mod/recordhours', $recordhours->course, 'mod', 'recordhours',
        $recordhours->id, 0, null, $item);
}

/**
 * Delete grade item for given recordhours instance
 *
 * @param stdClass $recordhours instance object
 * @return grade_item
 */
function recordhours_grade_item_delete($recordhours) {
    global $CFG;
    require_once($CFG->libdir . '/gradelib.php');

    return grade_update('mod/recordhours', $recordhours->course, 'mod', 'recordhours',
        $recordhours->id, 0, null, array('deleted' => 1));
}

/**
 * Update recordhours grades in the gradebook
 *
 * Needed by {@link grade_update_mod_grades()}.
 *
 * @param stdClass $recordhours instance object with extra cmidnumber and modname property
 * @param int $userid update grade of specific user only, 0 means all participants
 */
function recordhours_update_grades(stdClass $recordhours, $userid = 0) {
    global $CFG, $DB;
    require_once($CFG->libdir . '/gradelib.php');

    // Populate array of grade objects indexed by userid.
    $grades = array();

    grade_update('mod/recordhours', $recordhours->course, 'mod', 'recordhours', $recordhours->id, 0, $grades);
}

/* File API */

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array of [(string)filearea] => (string)description
 */
function recordhours_get_file_areas($course, $cm, $context) {
    return array();
}

/**
 * File browsing support for recordhours file areas
 *
 * @package mod_recordhours
 * @category files
 *
 * @param file_browser $browser
 * @param array $areas
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param int $itemid
 * @param string $filepath
 * @param string $filename
 * @return file_info instance or null if not found
 */
function recordhours_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    return null;
}

/**
 * Serves the files from the recordhours file areas
 *
 * @package mod_recordhours
 * @category files
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param stdClass $context the recordhours's context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 */
function recordhours_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload, array $options = array()) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        send_file_not_found();
    }

    require_login($course, true, $cm);

    send_file_not_found();
}

/* Navigation API */

/**
 * Extends the global navigation tree by adding recordhours nodes if there is a relevant content
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $navref An object representing the navigation tree node of the recordhours module instance
 * @param stdClass $course current course record
 * @param stdClass $module current recordhours instance record
 * @param cm_info $cm course module information
 */
function recordhours_extend_navigation(navigation_node $navref, stdClass $course, stdClass $module, cm_info $cm) {
    // TODO Delete this function and its docblock, or implement it.
}

/**
 * Extends the settings navigation with the recordhours settings
 *
 * This function is called when the context for the page is a recordhours module. This is not called by AJAX
 * so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav complete settings navigation tree
 * @param navigation_node $recordhoursnode recordhours administration node
 */
function recordhours_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $recordhoursnode = null) {
    // TODO Delete this function and its docblock, or implement it.
}
