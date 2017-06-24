<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   mivis
 * @author    Frank Hoppe
 * @license   GNU/LPGL
 * @copyright Frank Hoppe 2016
 */


/**
 * Table tl_mivis_rechte
 */
$GLOBALS['TL_DCA']['tl_mivis_rechte'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id'    => 'primary',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('benutzer'),
			'flag'                    => 1,
            'panelLayout'             => 'filter,sort,search;limit',
			'disableGrouping'         => true,
		),
		'label' => array
		(
			'fields'                  => array('benutzer:tl_user.CONCAT(name," (",username,")")', 'status', 'vereine'),
			'format'                  => '%s %s %s',
			'showColumns'             => true,
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_mivis_rechte', 'toggleIcon') 
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},benutzer,status,vereine;{publish_legend},published',
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'benutzer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['benutzer'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.CONCAT(name," (",username,")")', 
			'eval'                    => array('chosen'=>true, 'mandatory'=>false, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'default'                 => 9,
			'options'                 => array
			(
				'1'		=> 'Administrator',
				'2'		=> 'DV-Referent',
				'3'		=> 'Verband',
				'4'		=> 'Verein - Bearbeiter',
				'5'		=> 'Verein - Leser',
				'9'		=> 'Keine Zugriffsrechte',
			),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		),
		'vereine' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['vereine'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkboxWizard',
			'foreignKey'              => 'tl_mivis_vereine.CONCAT(zps," ",name)', 
			'eval'                    => array('tl_class'=>'long', 'multiple'=>true),
			'sql'                     => "blob NULL", 
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_rechte']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'default'                 => 1,
			'eval'                    => array('doNotCopy'=>true, 'isBoolean'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array
 */
class tl_mivis_rechte extends \Backend
{

    /**
     * Generiere eine Zeile als HTML
     * @param array
     * @return string
     */
    public function listMembers($arrRow)
    {
        
        $line = '';
        $line .= '<div class="tl_content_left" style="width:170px;">';
        $line .= $arrRow['nachname'].','.$arrRow['vorname'];
		$line .= ($arrRow['titel']) ? ','.$arrRow['titel'] : '';
        $line .= '</div>';
        $line .= '<div class="tl_content_left" style="width:70px;">';
        $line .= \Samson\Helper::getDate($arrRow['geburtstag']);
        $line .= '</div>';
        $line .= '<div class="tl_content_left" style="width:110px; overflow:hidden;">';
        $line .= $arrRow['geburtsort'];
        $line .= '</div>';
        $line .= '<div class="tl_content_left" style="width:220px; overflow:hidden">';
        $line .= $arrRow['plz'].' '.$arrRow['ort'].', '.$arrRow['strasse'];
        $line .= '</div>';
        $line .= "\n";

        return($line);

    }

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
        $this->import('BackendUser', 'User');
 
        if (strlen($this->Input->get('tid')))
        {
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
            $this->redirect($this->getReferer());
        }
 
        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_mivis_rechte::published', 'alexf'))
        {
            return '';
        }
 
        $href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$row[''];
 
        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }
 
        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnPublished)
	{
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_mivis_rechte::published', 'alexf'))
		{
			$this->log('Not enough permissions to show/hide record ID "'.$intId.'"', 'tl_mivis_rechte toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
	
		$this->createInitialVersion('tl_mivis_rechte', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_mivis_rechte']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_mivis_rechte']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
			}
		}
	
		// Update the database
		$this->Database->prepare("UPDATE tl_mivis_rechte SET tstamp=". time() .", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
			->execute($intId);
		$this->createNewVersion('tl_mivis_rechte', $intId);
	}

	/**
	 * Generiert automatisch ein Alias aus Vor- und Nachname
	 * @param mixed
	 * @param \DataContainer
	 * @return string
	 * @throws \Exception
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		// Generate alias
		$autoAlias = true;
		$varValue = standardize(String::restoreBasicEntities($dc->activeRecord->nachname . '-' . $dc->activeRecord->vorname));

		$objAlias = $this->Database->prepare("SELECT id FROM tl_mivis_rechte WHERE alias=?")
								   ->execute($varValue);

		// Check whether the news alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}  
}

