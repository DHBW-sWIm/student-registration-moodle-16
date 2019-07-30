<?php
require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

interface dashboard_dbcall{
    public function dbaccess($tablename, $paramvalue);
}
interface student {
    public function dbaccess($tablename, $paramvalue);
    public function dbinsert($tablename, $record, $paramvalue);
}

interface course {
    public function dbaccess($tablename, $paramvalue);
    public function dbinsert($tablename, $record, $paramvalue);
}

interface lecturers {
    public function dbaccess($tablename);
    public function dbinsert($tablename, $record, $paramvalue);

}
class dbcalls implements dashboard_dbcall
{

    public function dbaccess( $tablename, $paramvalue)
    {
        global $DB;
        $DB->get_records_select($tablename,  $params=$paramvalue);

    }
}

class dbstudents implements student {

    public function dbaccess($tablename, $paramvalue)
    {
        global $DB;
        $DB->get_records_select($tablename,  $params=$paramvalue);
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
        $DB->get_records_select($tablename,  $params=$paramvalue);
    }

    public function dbinsert($tablename, $record, $paramvalue)
    {
        global $DB;
        $DB->insert_record($tablename, $record, false);
    }
}

class dblecturers implements lecturers{

    public function dbaccess($tablename)
    {
        global $DB;
        $DB->get_records_select($tablename,  $params=null);
    }

    public function dbinsert($tablename, $record, $paramvalue)
    {
        global $DB;
        $DB->insert_record($tablename, $record, false);
    }
}