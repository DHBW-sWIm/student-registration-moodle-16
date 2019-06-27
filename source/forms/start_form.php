<?php
require_once("$CFG->libdir/formslib.php");

class start_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
        global $USER;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header', 'header', 'Enter a new student:');

        $mform->addElement('text', 'firstname', 'First name:');
        $mform->setType('firstname', PARAM_TEXT);

        $mform->addElement('text', 'surname', 'Surname:');
        $mform->setType('surname', PARAM_TEXT);

        $mform->addElement('text', 'email', 'Email address:');
        $mform->setType('email', PARAM_TEXT);

        $mform->addElement('date_selector', 'birthdate', 'Birth date:');
        $mform->setType('birthdate', PARAM_TEXT);

        $mform->addElement('text', 'course', 'Course:');
        $mform->setType('course', PARAM_TEXT);

        $mform->addElement('text', 'company', 'Company:');
        $mform->setType('company', PARAM_TEXT);

        $mform->addElement('submit', 'btnSubmit', 'Submit');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_TEXT);

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
