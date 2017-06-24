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
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace('fop;', 'fop;{mivis_legend},mivis,mivisv,mivism;', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);


/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields']['mivis'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivis'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_mivis_vereine.CONCAT(zps," ",name)',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['mivisv'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivisv'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('edit', 'editheader', 'copy', 'create', 'delete', 'toggle', 'show'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_user_group']['mivisv_options'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['mivism'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['mivism'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('edit', 'copy', 'create', 'delete', 'toggle', 'show'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_user_group']['mivism_options'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);
