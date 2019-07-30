<?php
require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');
include(__DIR__ . '/dbinterfaces.php');


class dbcalls implements dashboard_dbcall
{

    public function dbaccess( $tablename, $paramvalue)
    {
        global $DB;
        return $DB->get_records_select($tablename,  $params=$paramvalue);

    }
}

class dbstudents implements student {

    public function dbaccess($tablename, $paramvalue)
    {
        global $DB;
        return $DB->get_records_select($tablename,  $params=$paramvalue);
    }

    public function dbinsert($tablename, $record, $paramvalue)
    {
        global $DB;
        $DB->insert_record($tablename, $record, false);
    }
}
class dbcourse implements course{

    public function dbaccess($tablename, $paramvalue)
    {
        global $DB;
        return $DB->get_records_select($tablename,  $params=$paramvalue);
    }

    public function dbinsert($tablename, $record, $paramvalue)
    {
        global $DB;
        $DB->insert_record($tablename, $record, false);
    }
}

class dblecturers implements lecturers{

    public function dbaccess($tablename,$paramvalue)
    {
        global $DB;
        return $DB->get_records_select($tablename,  $params=$paramvalue);
    }

    public function dbinsert($tablename, $record, $paramvalue)
    {
        global $DB;
        $DB->insert_record($tablename, $record, false);
    }
}