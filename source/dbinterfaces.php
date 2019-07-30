<?php

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
    public function dbaccess($tablename, $paramvalue);
    public function dbinsert($tablename, $record, $paramvalue);

}