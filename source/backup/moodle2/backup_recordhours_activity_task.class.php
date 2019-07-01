<?php

/**
 * Defines backup_recordhours_activity_task class
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/recordhours/backup/moodle2/backup_recordhours_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the recordhours instance
 *
 * @package   mod_recordhours
 * @category  backup
 * @copyright 2016 Your Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_recordhours_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the recordhours.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_recordhours_activity_structure_step('recordhours_structure', 'recordhours.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, '/');

        // Link to the list of recordhourss.
        $search = '/(' . $base . '\/mod\/recordhours\/index.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@recordhoursINDEX*$2@$', $content);

        // Link to recordhours view by moduleid.
        $search = '/(' . $base . '\/mod\/recordhours\/view.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@recordhoursVIEWBYID*$2@$', $content);

        return $content;
    }
}
