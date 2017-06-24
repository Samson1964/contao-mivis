<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Mivis',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Mivis\Mivis'    	=> 'system/modules/mivis/classes/Mivis.php',
	'Mivis\Transfer' 	=> 'system/modules/mivis/classes/Transfer.php',
	'Mivis\Vereine'  	=> 'system/modules/mivis/classes/Vereine.php',
	//'Mivis\BackendUser' => 'system/modules/mivis/classes/BackendUser.php',
));
