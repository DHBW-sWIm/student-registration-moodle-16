<?php
require_once("$CFG->libdir/formslib.php");

class flecturehours extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header', 'header', 'Add new Entry:');

        $mform->addElement('text', 'fname', 'First Name');
        $mform->setType('fname', PARAM_TEXT);

        $mform->addElement('text', 'lname', 'Last Name');
        $mform->setType('lname', PARAM_TEXT);

        $mform->addElement('text', 'company', 'Company');
        $mform->setType('company', PARAM_TEXT);

        $mform->addElement('text', 'hours', 'Enter the numbers of hours');
        $mform->setType('hours', PARAM_INT);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Submit');

    }

    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}
