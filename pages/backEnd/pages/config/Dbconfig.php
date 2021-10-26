<?php
/**
 * dbhost, account, password, dbname
 */
class Dbconfig {
    /**
     * hostname
     */
    protected $serverName;

    /**
     * account
     */
    protected $userName;

    /**
     * password
     */
    protected $passCode;

    /**
     * dbname
     */
    protected $dbName;

    function Dbconfig() {
        $this -> serverName = '120.118.166.218';
        $this -> userName = 'root';
        $this -> passCode = 'sql13243';
        $this -> dbName = 'testdb';
    }
}
?>