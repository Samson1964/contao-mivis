<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = str_replace('fop;', 'fop;{mivis_legend},mivis,mivisv,mivism;', $GLOBALS['TL_DCA']['tl_user']['palettes']['extend']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = str_replace('fop;', 'fop;{mivis_legend},mivis,mivisv,mivism;', $GLOBALS['TL_DCA']['tl_user']['palettes']['custom']);


/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user']['fields']['mivis'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivis'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_mivis_vereine.CONCAT(zps," ",name)',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['mivisv'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivisv'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('edit', 'editheader', 'copy', 'create', 'delete', 'toggle', 'show'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_user']['mivisv_options'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['mivism'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivism'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('edit', 'copy', 'create', 'delete', 'toggle', 'show'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_user']['mivism_options'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

//$GLOBALS['TL_DCA']['tl_user']['fields']['mivisc'] = array
//(
//	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivisc'],
//	'exclude'                 => true,
//	'inputType'               => 'checkbox',
//	'options_callback'        => array('tl_user_mivis', 'getExcludedFields'),
//	'eval'                    => array('multiple'=>true, 'size'=>36),
//	'sql'                     => "blob NULL"
//);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_user_mivis extends \Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	} 
	
	/**
	 * Return all excluded fields as HTML drop down menu
	 *
	 * @return array
	 */
	public function getExcludedFields()
	{
		$included = array();

		foreach (ModuleLoader::getActive() as $strModule)
		{
			$strDir = 'system/modules/' . $strModule . '/dca';

			if (!is_dir(TL_ROOT . '/' . $strDir))
			{
				continue;
			}

			foreach (scan(TL_ROOT . '/' . $strDir) as $strFile)
			{
				// Ignore non PHP files and files which have been included before
				if (substr($strFile, -4) != '.php' || in_array($strFile, $included))
				{
					continue;
				}

				$included[] = $strFile;
				$strTable = substr($strFile, 0, -4);

				System::loadLanguageFile($strTable);
				$this->loadDataContainer($strTable);
			}
		}

		$arrReturn = array();

		// Get all excluded fields
		foreach ($GLOBALS['TL_DCA'] as $k=>$v)
		{
			if($k == 'tl_mivis_vereine' || $k == 'tl_mivis_spieler')
			{
				if (is_array($v['fields']))
				{
					foreach ($v['fields'] as $kk=>$vv)
					{
						if ($vv['exclude'] || $vv['orig_exclude'])
						{
							$arrReturn[$k][specialchars($k.'::'.$kk)] = $vv['label'][0] ?: $kk;
						}
					}
				}
			}
		}

		ksort($arrReturn);

		return $arrReturn;
	} 

}
 