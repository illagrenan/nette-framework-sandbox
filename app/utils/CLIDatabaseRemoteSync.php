<?php

final class CLIDatabaseRemoteSync extends Nette\Object
{

    /**
     * @var string
     */
    private static $syncFlagFilename = "/remote-database-sync-needed.temp";

    /**
     * @var string
     */
    private static $cliID = "cli";

    private function __construct()
    {
        
    }

    /**
     * @return boolean
     */
    public static function syncWithRemoteDatabase()
    {
        return (bool) (file_exists(TEMP_DIR . self::$syncFlagFilename));
    }

    /**
     * @return boolean
     */
    public static function isCLI()
    {
        return (bool) (php_sapi_name() == self::$cliID);
    }

}
