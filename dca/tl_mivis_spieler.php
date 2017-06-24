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
 * Table tl_mivis_spieler
 */
$GLOBALS['TL_DCA']['tl_mivis_spieler'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_mivis_vereine',
		'enableVersioning'            => true,
		'onload_callback'			  => array
		(
			array('tl_mivis_spieler', 'setRecordSession')
		), 
		'onsubmit_callback'			  => array
		(
			array('tl_mivis_spieler', 'storeDateAdded'),
			array('tl_mivis_spieler', 'getDifferences')
		), 
		'sql' => array
		(
			'keys' => array
			(
				'id'    => 'primary',
				'pid'   => 'index',
				'alias' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('alias'),
            'headerFields'            => array('name'),
			'flag'                    => 1,
            'panelLayout'             => 'filter,sort,search;limit',
			'disableGrouping'         => true,
			'child_record_callback'   => array('tl_mivis_spieler', 'listMembers'),
			'child_record_class'      => 'no_padding',
		),
		'label' => array
		(
			'fields'                  => array('nachname'),
			'format'                  => '%s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
            'cut' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['cut'],
                'href'                => 'act=paste&mode=cut',
                'icon'                => 'cut.gif'
            ),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_mivis_spieler', 'toggleIcon') 
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['show'],
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
		'__selector__'                => array(''),
		'default'                     => '{name_legend},vorname,nachname,titel,alias,pkz;{verein_legend},mglnr,status,von,bis,beitrag;{life_legend},geburtstag,geburtsort,geschlecht,nation;{fide_legend:hide},fide_nation,fide_id,gleichstellung;{daten_legend:hide},datenschutz;{adresse_legend},plz,ort,strasse,land;{kontakt_legend:hide},telefon1,telefon2,telefon3,telefax,email,zusatz;{publish_legend},published'
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
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'dateAdded' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'pkz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['pkz'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp'=>'numeric'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
		), 
		'vorname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['vorname'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'nachname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['nachname'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['alias'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_mivis_spieler', 'generateAlias')
			),
			'sql'                     => "varbinary(128) NOT NULL default ''"
		), 
		'titel' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['titel'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>10, 'tl_class'=>'w50'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'geburtstag' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['geburtstag'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp'=>'numeric'),
            'sql'                     => "int(8) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('\Samson\Helper', 'getDate')
			),
			'save_callback'           => array
			(
				array('\Samson\Helper', 'putDate')
			),		
		), 
		'geburtsort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['geburtsort'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'geschlecht' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['geschlecht'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'                 => array('M'=>'Männlich', 'W'=>'Weiblich'),
			'eval'                    => array('mandatory'=>false, 'includeBlankOption'=>true, 'maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                     => "varchar(1) NOT NULL default ''"
		),
		'nation' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['nation'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'fide_nation' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['fide_nation'],
			'filter'                  => true,
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'fide_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['fide_id'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp'=>'numeric'),
            'sql'                     => "int(15) unsigned NOT NULL default '0'"
		),
		'gleichstellung' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['gleichstellung'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                     => "varchar(1) NOT NULL default ''"
		),
		'datenschutz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['datenschutz'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'default'                 => 1,
			'eval'                    => array('isBoolean'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'strasse' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['strasse'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'plz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['plz'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>10, 'tl_class'=>'w50'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'ort' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['ort'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'land' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['land'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'telefon1' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['telefon1'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>32, 'tl_class'=>'w50'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'telefon2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['telefon2'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>32, 'tl_class'=>'w50'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'telefon3' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['telefon3'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>32, 'tl_class'=>'w50'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'telefax' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['telefax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>32, 'tl_class'=>'w50'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'email' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['email'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 12,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>64, 'rgxp'=>'email', 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'zusatz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['zusatz'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'long clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'mglnr' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['mglnr'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'rgxp'=>'numeric'),
            'sql'                     => "int(4) unsigned NOT NULL default '0'"
		), 
		'von' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['von'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp'=>'numeric'),
            'sql'                     => "int(8) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('\Samson\Helper', 'getDate')
			),
			'save_callback'           => array
			(
				array('\Samson\Helper', 'putDate')
			),		
		), 
		'bis' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['bis'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp'=>'numeric'),
            'sql'                     => "int(8) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('\Samson\Helper', 'getDate')
			),
			'save_callback'           => array
			(
				array('\Samson\Helper', 'putDate')
			),		
		), 
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'                 => array('A'=>'Aktiv', 'P'=>'Passiv', 'L'=>'Abgemeldet'),
			'eval'                    => array('mandatory'=>false, 'includeBlankOption'=>true, 'maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                     => "varchar(1) NOT NULL default ''"
		),
		'beitrag' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['beitrag'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_spieler']['published'],
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
class tl_mivis_spieler extends \Backend
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
	 * Save a copy of the current status to check if it has changed later
	 */
	public function setRecordSession(DataContainer $dc)
	{
		// Da $dc->activeRecord hier leer ist, muß die Datenbank abgefragt werden
	    $row = $this->Database->prepare("SELECT * FROM tl_mivis_spieler WHERE id=?")
	                          ->execute($dc->id)
	                          ->fetchAssoc();
		// Datensatz in Session sichern
    	foreach($row as $key => $value)
    	{	
    		if($key == 'geburtstag' || $key == 'von' || $key == 'bis')
    		{
    			$value = \Samson\Helper::getDate($value);
    		}
    		$this->Session->set('tl_mivis_spieler.'.$key, $value);
    	}
	}

	/**
	 * Prüfung auf neuen/geänderten Datensatz
	 * @param DataContainer
	 */
	public function storeDateAdded(DataContainer $dc)
	{
	    if($dc->activeRecord->dateAdded > 0)
	    {
	    	$changes = '';
	    	// Kein neuer Datensatz, deshalb Änderungen ermitteln
	    	foreach($GLOBALS['TL_DCA']['tl_mivis_spieler']['fields'] as $key => $value)
	    	{
	    		if($key != 'tstamp' && $key != 'alias')
	    		{
	    			if($dc->activeRecord->$key != $this->Session->get('tl_mivis_spieler.'.$key))
	    			{
	    				$changes .= "<li>".$value['label'][0].": <i>".$this->Session->get('tl_mivis_spieler.'.$key)."</i> &raquo; <b>".$dc->activeRecord->$key."</b></li>\n";
	    			}
	    		}
	    	}
	    	
	    	if($changes)
	    	{
	    		$info = array
	    		(
	    			'id'		=> $dc->id,
	    			'pid'		=> $dc->activeRecord->pid,
	    			'vorname'	=> $this->Session->get('tl_mivis_spieler.vorname'),
	    			'nachname'	=> $this->Session->get('tl_mivis_spieler.nachname'),
	    		);
		    	// Email verschicken
		    	Mivis::Mail($this->User, $changes, $info);
	    	}
	    	
	    }
	 	else
	 	{
	    	// Erstellungsdatum speichern
	    	$this->Database->prepare("UPDATE tl_mivis_spieler SET dateAdded=? WHERE id=?")
	    	               ->execute(time(), $dc->id);
	    	// Email verschicken
	    	Mivis::Mail($this->User, $dc->activeRecord, '', true);
		}
		
	}

	/**
	 * Status des Datensatzes feststellen
	 * @param integer
	 * @param boolean
	 */
	public function getDifferences(DataContainer $dc)
	{
		//echo '<pre>';
		//print_r($dc);
		//echo '</pre>';

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
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_mivis_spieler::published', 'alexf'))
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_mivis_spieler::published', 'alexf'))
		{
			$this->log('Not enough permissions to show/hide record ID "'.$intId.'"', 'tl_mivis_spieler toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
	
		$this->createInitialVersion('tl_mivis_spieler', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_mivis_spieler']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_mivis_spieler']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
			}
		}
	
		// Update the database
		$this->Database->prepare("UPDATE tl_mivis_spieler SET tstamp=". time() .", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
			->execute($intId);
		$this->createNewVersion('tl_mivis_spieler', $intId);
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

		$objAlias = $this->Database->prepare("SELECT id FROM tl_mivis_spieler WHERE alias=?")
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

