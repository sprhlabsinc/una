<?php defined('BX_DOL') or die('hack attempt');
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 *
 * @defgroup    Timeline Timeline
 * @ingroup     DolphinModules
 *
 * @{
 */

bx_import('BxBaseModNotificationsInstaller');

class BxTimelineInstaller extends BxBaseModNotificationsInstaller
{
    function __construct($aConfig)
    {
        parent::__construct($aConfig);
        $this->_aTranscoders = array ('bx_timeline_photos_preview', 'bx_timeline_photos_view');
        $this->_aStorages = array ('bx_timeline_photos');
        $this->_aPageTriggers = array ('trigger_page_persons_view_entry', 'trigger_page_organizations_view_entry');
    }
}

/** @} */
