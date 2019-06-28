<?php

/**
 * Defines backup_demandplanning_activity_task class
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/demandplanning/backup/moodle2/backup_demandplanning_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the demandplanning instance
 *
 * @package   mod_demandplanning
 * @category  backup
 * @copyright 2016 Your Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_demandplanning_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the demandplanning.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_demandplanning_activity_structure_step('demandplanning_structure', 'demandplanning.xml'));
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

        // Link to the list of demandplannings.
        $search = '/(' . $base . '\/mod\/demandplanning\/index.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@demandplanningINDEX*$2@$', $content);

        // Link to demandplanning view by moduleid.
        $search = '/(' . $base . '\/mod\/demandplanning\/view.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@demandplanningVIEWBYID*$2@$', $content);

        return $content;
    }
}
