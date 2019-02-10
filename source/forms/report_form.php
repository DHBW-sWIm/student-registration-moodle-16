<?php
require_once("$CFG->libdir/formslib.php");

class report_form
{
    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'year1', 'First year to compare');
        $mform->setType('year', PARAM_INT);

        $mform->addElement('text', 'year2', 'Second year to compare');
        $mform->setType('year', PARAM_INT);

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
