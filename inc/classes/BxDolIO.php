<?php defined('BX_DOL') or die('hack attempt');
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 *
 * @defgroup    DolphinCore Dolphin Core
 * @{
 */

class BxDolIO extends BxDol
{
    function __construct() 
    {
        parent::__construct();
    }

    public static function isExecutable($sFile)
    {
        clearstatcache();

        $aPathInfo = pathinfo(__FILE__);
        $sFile = $aPathInfo['dirname'] . '/../../' . $sFile;

        return (is_file($sFile) && is_executable($sFile));
    }

    public static function isWritable($sFile, $sPrePath = '/../../')
    {
        clearstatcache();

        $aPathInfo = pathinfo(__FILE__);
        $sFile = $aPathInfo['dirname'] . '/../../' . $sFile;

        return is_readable($sFile) && is_writable($sFile);
    }

    public static function getPermissions($sFileName)
    {
        $sPath = isset($GLOBALS['logged']['admin']) && $GLOBALS['logged']['admin'] ? BX_DIRECTORY_PATH_ROOT : '../';

        clearstatcache();
        $hPerms = @fileperms($sPath . $sFileName);
        if($hPerms == false) return false;
        $sRet = substr( decoct( $hPerms ), -3 );
        return $sRet;
    }
}

/** @} */
