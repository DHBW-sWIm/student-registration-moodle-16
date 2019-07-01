<?php

/**
 * Defines backup_studreg_activity_task class
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/studreg/backup/moodle2/backup_studreg_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the studreg instance
 *
 * @package   mod_studreg
 * @category  backup
 * @copyright 2016 Your Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_studreg_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the studreg.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_studreg_activity_structure_step('studreg_structure', 'studreg.xml'));
    }

    /**
     * Encodes URLs to the index.php and v_studentreg.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, '/');

        // Link to the list of studregs.
        $search = '/(' . $base . '\/mod\/studreg\/index.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@studregINDEX*$2@$', $content);

        // Link to studreg view by moduleid.
        $search = '/(' . $base . '\/mod\/studreg\/v_studentreg.php\?id\=)([0-9]+)/';
        $content = preg_replace($search, '$@studregVIEWBYID*$2@$', $content);

        return $content;
    }
}
