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
 * Table tl_mivis_vereine
 */
$GLOBALS['TL_DCA']['tl_mivis_vereine'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_mivis_spieler'),
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' 	=> 'primary',
				'zps' 	=> 'index'
			)
		),
		'onload_callback'			  => array
		(
			array('tl_mivis_vereine', 'checkPermission')
		), 
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('zps'),
			'flag'                    => 1,
			'disableGrouping'         => true,
			'panelLayout'             => 'sort,filter,search;limit',
		),
		'label' => array
		(
			'fields'                  => array('zps', 'name'),
			'format'                  => '<b>%s</b> %s',
		),
		'global_operations' => array
		(
			'import' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['import'],
				'href'                => 'key=import',
				'icon'                => 'system/modules/mivis/assets/icons/import.png',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['edit'],
				'href'                => 'table=tl_mivis_spieler',
				'icon'                => 'edit.gif',
				'button_callback'     => array('tl_mivis_vereine', 'generateEditButton')
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_mivis_vereine', 'generateEditheaderButton')
			), 
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
				'button_callback'     => array('tl_mivis_vereine', 'generateCopyButton')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_mivis_vereine', 'generateDeleteButton')
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_mivis_vereine', 'toggleIcon') 
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'button_callback'     => array('tl_mivis_vereine', 'generateShowButton')
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
		'default'                     => '{title_legend},name,kurzname,zps;{publish_legend},published'
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
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'			=> true, 
				'maxlength'			=> 255,
				'tl_class'   		=> 'w50'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'kurzname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['kurzname'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'			=> false, 
				'maxlength'			=> 255,
				'tl_class'   		=> 'w50'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'zps' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['zps'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true, 
				'maxlength'           => 5, 
				'tl_class'   		  => 'w50',
				'unique'			  => true
			),
			'sql'                     => "varchar(5) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mivis_vereine']['published'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50','isBoolean' => true),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
	)
);

/**
 * Class tl_mivis_vereine
 *
 */
class tl_mivis_vereine extends Backend
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
	 * Check permissions to edit table tl_mivis_vereine
	 */
	public function checkPermission()
	{

		if ($this->User->isAdmin)
		{
			return;
		}

		//$this->User = Mivis::initPermissions($this->User);
		
		//echo "<pre>";		
		//print_r($this->User->news);
		//print_r($this->User->newp);
		//echo "</pre>";		


		// Set root IDs
		if (!is_array($this->User->mivis) || empty($this->User->mivis))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->mivis;
		}
        
		$GLOBALS['TL_DCA']['tl_mivis_vereine']['list']['sorting']['root'] = $root;
        
		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'mivisv'))
		{
			$GLOBALS['TL_DCA']['tl_mivis_vereine']['config']['closed'] = true;
		}
        
		// Check current action
		switch (Input::get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;
        
			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(Input::get('id'), $root))
				{
					$arrNew = $this->Session->get('new_records');
        
					if (is_array($arrNew['tl_mivis_vereine']) && in_array(Input::get('id'), $arrNew['tl_mivis_vereine']))
					{
						// Add permissions on user level
						if ($this->User->inherit == 'custom' || !$this->User->groups[0])
						{
							$objUser = $this->Database->prepare("SELECT mivis, mivisv FROM tl_user WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->id);
        
							$arrNewp = deserialize($objUser->mivisv);
        
							if (is_array($arrNewp) && in_array('create', $arrNewp))
							{
								$arrNews = deserialize($objUser->mivis);
								$arrNews[] = Input::get('id');
        
								$this->Database->prepare("UPDATE tl_user SET mivis=? WHERE id=?")
											   ->execute(serialize($arrNews), $this->User->id);
							}
						}
        
						// Add permissions on group level
						elseif ($this->User->groups[0] > 0)
						{
							$objGroup = $this->Database->prepare("SELECT mivis, mivisv FROM tl_user_group WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->groups[0]);
        
							$arrNewp = deserialize($objGroup->mivisv);
        
							if (is_array($arrNewp) && in_array('create', $arrNewp))
							{
								$arrNews = deserialize($objGroup->mivis);
								$arrNews[] = Input::get('id');
        
								$this->Database->prepare("UPDATE tl_user_group SET mivis=? WHERE id=?")
											   ->execute(serialize($arrNews), $this->User->groups[0]);
							}
						}
        
						// Add new element to the user object
						$root[] = Input::get('id');
						$this->User->mivis = $root;
					}
				}
				// No break;
        
			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'mivisv')))
				{
					$this->log('Not enough permissions to '.Input::get('act').' mivis ID "'.Input::get('id').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
        
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'mivisv'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break;
        
			default:
				if (strlen(Input::get('act')))
				{
					$this->log('Not enough permissions to '.Input::get('act').' mivis clubs', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}

    public function generateEditButton($row, $href, $label, $title, $icon, $attributes)
    {
		return ($this->User->isAdmin || $this->User->hasAccess('edit', 'mivisv')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' '; 
    }
     
    public function generateEditheaderButton($row, $href, $label, $title, $icon, $attributes)
    {
		return ($this->User->isAdmin || ($this->User->hasAccess('editheader', 'mivisv') && $this->User->canEditFieldsOf('tl_mivis_vereine'))) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' '; 
		//return ($this->User->isAdmin || ($this->User->hasAccess('editheader', 'mivisv') && $this->User->hasAccess('tl_mivis_vereine::name', 'mivisc'))) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' '; 
    }
     
    public function generateCopyButton($row, $href, $label, $title, $icon, $attributes)
    {
		return ($this->User->isAdmin || $this->User->hasAccess('copy', 'mivisv')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' '; 
    }
     
    public function generateDeleteButton($row, $href, $label, $title, $icon, $attributes)
    {
		return ($this->User->isAdmin || $this->User->hasAccess('delete', 'mivisv')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' '; 
    }
     
    public function generateShowButton($row, $href, $label, $title, $icon, $attributes)
    {
		return ($this->User->isAdmin || $this->User->hasAccess('show', 'mivisv')) ? '<a onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Details anzeigen\',\'url\':this.href});return false" href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'&amp;popup=1" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml('system/modules/mivis/assets/icons/show_.gif').' '; 
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
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_mivis_vereine::published', 'alexf'))
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_mivis_vereine::published', 'alexf'))
		{
			$this->log('Not enough permissions to show/hide record ID "'.$intId.'"', 'tl_mivis_vereine toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
	
		$this->createInitialVersion('tl_mivis_vereine', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_mivis_vereine']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_mivis_vereine']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
			}
		}
	
		// Update the database
		$this->Database->prepare("UPDATE tl_mivis_vereine SET tstamp=". time() .", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
			->execute($intId);
		$this->createNewVersion('tl_mivis_vereine', $intId);
	}
}

