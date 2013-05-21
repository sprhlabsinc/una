<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 *
 * @defgroup    DolphinView Dolphin Studio Representation classes
 * @ingroup     DolphinStudio
 * @{
 */
defined('BX_DOL') or die('hack attempt');

bx_import('BxDolStudioPermissionsLevels');
bx_import('BxTemplStudioFormView');

class BxBaseStudioPermissionsLevels extends BxDolStudioPermissionsLevels {
    public static $iBinMB = 1048576;

    function __construct($aOptions, $oTemplate = false) {
        parent::__construct($aOptions, $oTemplate);

        $this->_aOptions['actions_single']['edit']['attr']['title'] = _t('_adm_prm_btn_level_edit');
        $this->_aOptions['actions_single']['delete']['attr']['title'] = _t('_adm_prm_btn_level_delete');
    }
    public function performActionAdd() {
        $sAction = 'add';

        $aForm = array(
            'form_attrs' => array(
                'id' => 'adm-prm-level-create',
                'action' => BX_DOL_URL_ROOT . 'grid.php?o=' . $this->_sObject . '&a=' . $sAction,
                'method' => BX_DOL_STUDIO_METHOD_DEFAULT,
                'enctype' => 'multipart/form-data',
            ),
            'params' => array (
                'db' => array(
                    'table' => 'sys_acl_levels',
                    'key' => 'ID',
                    'uri' => '',
                    'uri_title' => '',
                    'submit_name' => 'do_submit'
                ),
            ),
            'inputs' => array (            
                'Active' => array(
                    'type' => 'hidden',
                    'name' => 'Active',
                    'value' => 'yes',
                    'db' => array (
                        'pass' => 'Xss',
                    ),
                ),
                'Purchasable' => array(
                    'type' => 'hidden',
                    'name' => 'Purchasable',
                    'value' => 'no',
                    'db' => array (
                        'pass' => 'Xss',
                    ),
                ),
                'Removable' => array(
                    'type' => 'hidden',
                    'name' => 'Removable',
                    'value' => 'yes',
                    'db' => array (
                        'pass' => 'Xss',
                    ),
                ),
                'Name' => array(
                    'type' => 'text_translatable',
                    'name' => 'Name',
                    'caption' => _t('_adm_prm_txt_level_name'),
                    'info' => _t('_adm_prm_dsc_level_name'),
                    'value' => '_adm_prm_txt_level',
                    'required' => '1',
                    'db' => array (
                        'pass' => 'Xss',
                    ),
                    'checker' => array (
                        'func' => 'LengthTranslatable',
                        'params' => array(3, 100, 'Name'),
                        'error' => _t('_adm_prm_err_level_name'),
                    ),
                ),
                'Description' => array(
                    'type' => 'textarea_translatable',
                    'name' => 'Description',
                    'caption' => _t('_adm_prm_txt_level_description'),
                    'info' => _t('_adm_prm_dsc_level_description'),
                    'value' => '_adm_prm_txt_level',
                    'db' => array (
                        'pass' => 'XssHtml',
                    )
                ),
                'QuotaSize' => array(
                    'type' => 'text',
                    'name' => 'QuotaSize',
                    'caption' => _t('_adm_prm_txt_level_quota_size'),
                    'info' => _t('_adm_prm_dsc_level_quota_size'),
                    'value' => '0',
                	'required' => '1',
                    'db' => array (
                        'pass' => 'Float',
                    ),
                    'checker' => array (
                        'func' => 'preg',
                        'params' => array('/^[0-9\.]+$/'),
                        'error' => _t('_adm_prm_err_level_quota_size'),
                    ),
                ),
                'QuotaMaxFileSize' => array(
                    'type' => 'text',
                    'name' => 'QuotaMaxFileSize',
                    'caption' => _t('_adm_prm_txt_level_quota_max_file_size'),
                    'info' => _t('_adm_prm_dsc_level_quota_max_file_size'),
                    'value' => '',
                	'required' => '1',
                    'db' => array (
                        'pass' => 'Float',
                    ),
                    'checker' => array (
                        'func' => 'preg',
                        'params' => array('/^[0-9\.]+$/'),
                        'error' => _t('_adm_prm_err_level_quota_max_file_size'),
                    ),
                ),
                'QuotaNumber' => array(
                    'type' => 'text',
                    'name' => 'QuotaNumber',
                    'caption' => _t('_adm_prm_txt_level_quota_number'),
                    'info' => _t('_adm_prm_dsc_level_quota_number'),
                    'value' => '0',
                	'required' => '1',
                    'db' => array (
                        'pass' => 'Int',
                    ),
                    'checker' => array (
                        'func' => 'preg',
                        'params' => array('/^[0-9]+$/'),
                        'error' => _t('_adm_prm_err_level_quota_number'),
                    ),
                ),
                'Icon' => array(
                    'type' => 'file',
                    'name' => 'Icon',
                    'caption' => _t('_adm_prm_txt_level_icon'),
                    'value' => '',
                    'checker' => array (
                        'func' => '',
                        'params' => '',
                        'error' => _t('_adm_prm_err_level_icon'),
                    ),
                ),
                'controls' => array(
                    'name' => 'controls', 
                    'type' => 'input_set',
                    array(
                        'type' => 'submit',
                        'name' => 'do_submit',
                        'value' => _t('_adm_prm_btn_level_add'),
                    ),
                    array (
                        'type' => 'reset',
                        'name' => 'close',
                        'value' => _t('_adm_prm_btn_level_cancel'),
                        'attrs' => array(
                            'onclick' => "$('.bx-popup-applied:visible').dolPopupHide()",
                            'class' => 'bx-def-margin-sec-left',
                        ),
                    )
                )
            )
        );

        $oForm = new BxTemplStudioFormView($aForm);
        $oForm->initChecker();

        if($oForm->isSubmittedAndValid()) {
            if(($iId = $this->getAvailableId()) === false) {
                $this->_echoResultJson(array('msg' => _t('_adm_prm_err_level_id')), true);
                return;
            }

            $mixedIcon = 'acl-unconfirmed.png';
            if(!empty($_FILES['Icon']['tmp_name'])) {
                bx_import('BxDolStorage');
                $oStorage = BxDolStorage::getObjectInstance(BX_DOL_STORAGE_OBJ_IMAGES);
    
                $mixedIcon = $oStorage->storeFileFromForm($_FILES['Icon'], false, 0); 
                if($mixedIcon === false) {
                    $this->_echoResultJson(array('msg' => _t('_adm_prm_err_level_icon') . $oStorage->getErrorString()), true);
                    return;
                }

                $oStorage->afterUploadCleanup($mixedIcon, 0);
            }

            $fQuotaSize = round($oForm->getCleanValue('QuotaSize'), 1);
            BxDolForm::setSubmittedValue('QuotaSize', self::$iBinMB * $fQuotaSize, $aForm['form_attrs']['method']);

            $fQuotaMaxFileSize = round($oForm->getCleanValue('QuotaMaxFileSize'), 1);
            BxDolForm::setSubmittedValue('QuotaMaxFileSize', self::$iBinMB * $fQuotaMaxFileSize, $aForm['form_attrs']['method']);

            $iId = (int)$oForm->insert(array('ID' => $iId, 'Icon' => $mixedIcon, 'Order' => $this->oDb->getLevelOrderMax() + 1));
            if($iId != 0)
                $aRes = array('grid' => $this->getCode(false), 'blink' => $iId);
            else
                $aRes = array('msg' => _t('_adm_prm_err_level_create'));

            $this->_echoResultJson($aRes, true);
        }
        else {
            bx_import('BxTemplStudioFunctions');
            $sContent = BxTemplStudioFunctions::getInstance()->popupBox('adm-prm-level-create-popup', _t('_adm_prm_txt_level_create_popup'), $this->_oTemplate->parseHtmlByName('prm_add_level.html', array(
                'form_id' => $aForm['form_attrs']['id'],
                'form' => $oForm->getCode(true),
                'object' => $this->_sObject,
                'action' => $sAction
            )));

            $this->_echoResultJson(array('popup' => array('html' => $sContent, 'options' => array('closeOnOuterClick' => false))), true);
        }
    }

    public function performActionEdit() {
        $sAction = 'edit';

        $aIds = bx_get('ids');
        if(!$aIds || !is_array($aIds)) {
            $iId = (int)bx_get('id');
            if(!$iId) {
                $this->_echoResultJson(array());
                exit;
            }

            $aIds = array($iId);
        }

        $iId = $aIds[0];

        $aLevel = array();
        $iLevel = $this->oDb->getLevels(array('type' => 'by_id', 'value' => $iId), $aLevel);
        if($iLevel != 1 || empty($aLevel)){
            $this->_echoResultJson(array());
            exit;
        }

        $aForm = array(
            'form_attrs' => array(
                'id' => 'adm-prm-level-edit',
                'action' => BX_DOL_URL_ROOT . 'grid.php?o=' . $this->_sObject . '&a=' . $sAction,
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            ),
            'params' => array (
                'db' => array(
                    'table' => 'sys_acl_levels',
                    'key' => 'ID',
                    'uri' => '',
                    'uri_title' => '',
                    'submit_name' => 'do_submit'
                ),
            ),
            'inputs' => array (
            	'id' => array(
                    'type' => 'hidden',
                    'name' => 'id',
                    'value' => $iId,
                    'db' => array (
                        'pass' => 'Int',
                    ),
                ),
                'Description' => array(
                    'type' => 'textarea_translatable',
                    'name' => 'Description',
                    'caption' => _t('_adm_prm_txt_level_description'),
                	'info' => _t('_adm_prm_dsc_level_description'),
                    'value' => $aLevel['description'],
                    'db' => array (
                        'pass' => 'XssHtml',
                    ),
                ),
                'QuotaSize' => array(
                    'type' => 'text',
                    'name' => 'QuotaSize',
                    'caption' => _t('_adm_prm_txt_level_quota_size'),
                	'info' => _t('_adm_prm_dsc_level_quota_size'),
                    'value' => round($aLevel['quota_size'] / self::$iBinMB, 1),
                	'required' => '1',
                    'db' => array (
                        'pass' => 'Float',
                    ),
                    'checker' => array (
                        'func' => 'preg',
                        'params' => array('/^[0-9\.]+$/'),
                        'error' => _t('_adm_prm_err_level_quota_size'),
                    ),
                ),
                'QuotaMaxFileSize' => array(
                    'type' => 'text',
                    'name' => 'QuotaMaxFileSize',
                    'caption' => _t('_adm_prm_txt_level_quota_max_file_size'),
                	'info' => _t('_adm_prm_dsc_level_quota_max_file_size'),
                    'value' => round($aLevel['quota_max_file_size'] / self::$iBinMB, 1),
                	'required' => '1',
                    'db' => array (
                        'pass' => 'Float',
                    ),
                    'checker' => array (
                        'func' => 'preg',
                        'params' => array('/^[0-9\.]+$/'),
                        'error' => _t('_adm_prm_err_level_quota_max_file_size'),
                    ),
                ),
                'QuotaNumber' => array(
                    'type' => 'text',
                    'name' => 'QuotaNumber',
                    'caption' => _t('_adm_prm_txt_level_quota_number'),
                    'info' => _t('_adm_prm_dsc_level_quota_number'),
                    'value' => $aLevel['quota_number'],
                	'required' => '1',
                    'db' => array (
                        'pass' => 'Int',
                    ),
                    'checker' => array (
                        'func' => 'preg',
                        'params' => array('/^[0-9]+$/'),
                        'error' => _t('_adm_prm_err_level_quota_number'),
                    ),
                ),
                'Icon' => array(
                    'type' => 'file',
                    'name' => 'Icon',
                    'caption' => _t('_adm_prm_txt_level_icon'),
                    'value' => '',
                    'checker' => array (
                        'func' => '',
                        'params' => '',
                        'error' => _t('_adm_prm_err_level_icon'),
                    ),
                ),
                'controls' => array(
                    'name' => 'controls', 
                    'type' => 'input_set',
                    array(
                        'type' => 'submit',
                        'name' => 'do_submit',
                        'value' => _t('_adm_prm_btn_level_save'),
                    ),
                    array (
                        'type' => 'reset',
                        'name' => 'close',
                        'value' => _t('_adm_prm_btn_level_cancel'),
                        'attrs' => array(
                            'onclick' => "$('.bx-popup-applied:visible').dolPopupHide()",
                            'class' => 'bx-def-margin-sec-left',
                        ),
                    )
                )
            )
        );

        bx_import('BxTemplStudioFormView');
        $oForm = new BxTemplStudioFormView($aForm);
        $oForm->initChecker();

        if($oForm->isSubmittedAndValid()) {
            $mixedIcon = 0;
            if(!empty($_FILES['Icon']['tmp_name'])) {
                bx_import('BxDolStorage');
                $oStorage = BxDolStorage::getObjectInstance(BX_DOL_STORAGE_OBJ_IMAGES);
    
                if(is_numeric($aLevel['icon']) && (int)$aLevel['icon'] != 0 && !$oStorage->deleteFile((int)$aLevel['icon'], 0)) {
                    $this->_echoResultJson(array('msg' => _t('_adm_prm_err_level_icon_remove')), true);
                    return;
                }

                $mixedIcon = $oStorage->storeFileFromForm($_FILES['Icon'], false, 0); 
                if($mixedIcon === false) {
                    $this->_echoResultJson(array('msg' => _t('_adm_prm_err_level_icon') . $oStorage->getErrorString()), true);
                    return;
                }

                $oStorage->afterUploadCleanup($mixedIcon, 0);
            }

            $fQuotaSize = round($oForm->getCleanValue('QuotaSize'), 1);
            BxDolForm::setSubmittedValue('QuotaSize', self::$iBinMB * $fQuotaSize, $aForm['form_attrs']['method']);

            $fQuotaMaxFileSize = round($oForm->getCleanValue('QuotaMaxFileSize'), 1);
            BxDolForm::setSubmittedValue('QuotaMaxFileSize', self::$iBinMB * $fQuotaMaxFileSize, $aForm['form_attrs']['method']);

            if($oForm->update($iId, (int)$mixedIcon != 0 ? array('Icon' => $mixedIcon) : array()) !== false)
                $aRes = array('grid' => $this->getCode(false), 'blink' => $iId);
            else
                $aRes = array('msg' => _t('_adm_prm_err_level_edit'));

            $this->_echoResultJson($aRes, true);
        }
        else {
            bx_import('BxTemplStudioFunctions');
            $sContent = BxTemplStudioFunctions::getInstance()->popupBox('adm-prm-level-edit-popup', _t('_adm_prm_txt_level_edit_popup', _t($aLevel['name'])), $this->_oTemplate->parseHtmlByName('prm_add_level.html', array(
                'form_id' => $aForm['form_attrs']['id'],
                'form' => $oForm->getCode(true),
                'object' => $this->_sObject,
                'action' => $sAction
            )));

            $this->_echoResultJson(array('popup' => array('html' => $sContent, 'options' => array('closeOnOuterClick' => false))), true);
        }
    }

    public function performActionDelete() {
        $iAffected = 0;
        $aIds = bx_get('ids');
        if(!$aIds || !is_array($aIds)) {
            $this->_echoResultJson(array());
            exit;
        }

        $aIdsAffected = array ();
        foreach($aIds as $iId) {
            if(!$this->delete($iId))
                continue;

            $aIdsAffected[] = $iId;
            $iAffected++;
        }

        $this->_echoResultJson($iAffected ? array('grid' => $this->getCode(false), 'blink' => $aIdsAffected) : array('msg' => _t('_adm_prm_err_level_delete')));
    }

    protected function _addJsCss() {
        parent::_addJsCss();
        $this->_oTemplate->addJs(array('jquery.form.js'));

        bx_import('BxTemplStudioFormView');
        $oForm = new BxTemplStudioFormView(array());
        $oForm->addCssJs();
    }
    protected function _getCellSwitcher ($mixedValue, $sKey, $aField, $aRow) {
        bx_import('BxDolAcl');
        if(in_array($aRow['ID'], array(MEMBERSHIP_ID_NON_MEMBER, MEMBERSHIP_ID_STANDARD, MEMBERSHIP_ID_UNCONFIRMED, MEMBERSHIP_ID_PENDING, MEMBERSHIP_ID_SUSPENDED)))
            return parent::_getCellDefault('', $sKey, $aField, $aRow);;

        return parent::_getCellSwitcher($mixedValue, $sKey, $aField, $aRow);
    }
    protected function _getCellIcon ($mixedValue, $sKey, $aField, $aRow) {
        $mixedValue = $this->_oTemplate->getImage($mixedValue, array('class' => 'bx-prm-level-icon bx-def-border'));
        return parent::_getCellDefault($mixedValue, $sKey, $aField, $aRow);
    }

    protected function _getCellActionsList ($mixedValue, $sKey, $aField, $aRow) {
        $aActions = array();
        $iActions = $this->oDb->getActions(array('type' => 'by_level_id', 'value' => $aRow['ID']), $aActions);

        $mixedValue = $this->_oTemplate->parseHtmlByName('bx_a.html', array(
            'href' => BX_DOL_URL_STUDIO . 'builder_permissions.php?page=actions&level=' . $aRow['ID'],
            'title' => _t('_adm_prm_txt_manage_actions'),
            'bx_repeat:attrs' => array(),
            'content' => _t('_adm_prm_txt_n_actions', $iActions)
        ));

        return parent::_getCellDefault ($mixedValue, $sKey, $aField, $aRow);
    }

    protected function _getCellQuotaSize ($mixedValue, $sKey, $aField, $aRow) {        
        return parent::_getCellDefault ($mixedValue > 0 ? _t_format_size($mixedValue) : '&infin;', $sKey, $aField, $aRow);
    }

    protected function _getCellQuotaNumber ($mixedValue, $sKey, $aField, $aRow) {        
        return parent::_getCellDefault ($mixedValue > 0 ? $mixedValue : '&infin;', $sKey, $aField, $aRow);
    }

    protected function _getCellQuotaMaxFileSize ($mixedValue, $sKey, $aField, $aRow) {
        return parent::_getCellDefault ($mixedValue > 0 ? _t_format_size($mixedValue) : '&infin;', $sKey, $aField, $aRow);
    }

    protected function _getActionDelete ($sType, $sKey, $a, $isSmall = false, $isDisabled = false, $aRow = array()) {
        if ($sType == 'single' && $aRow['Removable'] != 'yes')
            return '';

        return  parent::_getActionDefault($sType, $sKey, $a, false, $isDisabled, $aRow);
    }

    protected function getAvailableId() {
        $aLevels = array();
        $this->oDb->getLevels(array('type' =>'all_order_id'), $aLevels, false);

        $iId = 1;
        foreach($aLevels as $aLevel) {
            if($iId != (int)$aLevel['id'])
                break;

            $iId++;
        }

        return $iId <= BX_DOL_STUDIO_PERMISSIONS_LEVEL_ID_INT_MAX ? $iId : false;
    }
}
/** @} */
