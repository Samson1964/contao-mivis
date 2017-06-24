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
 * Namespace
 */
namespace Mivis;


/**
 * Class Transfer
 *
 * @copyright  Frank Hoppe 2016
 * @author     Frank Hoppe
 * @package    Devtools
 */
class Transfer extends \Backend
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = '';


	/**
	 * Generate the module
	 */
	protected function compile()
	{

	}

	/**
	 * MIVIS-Import
	 *
	 * @param \DataContainer $dc
	 *
	 * @return string
	 */
	public function importMIVIS(\DataContainer $dc)
	{

		if (\Input::get('key') != 'import')
		{
			return '';
		}

		$this->import('BackendUser', 'User');
		$class = $this->User->uploader;

		if(!$this->User->isAdmin || $this->User->id != 13)
		{
			return 'Zugriff verweigert!';
		}
		
		// See #4086 and #7046
		if (!class_exists($class) || $class == 'DropZone')
		{
			$class = 'FileUpload';
		}

		/** @var \FileUpload $objUploader */
		$objUploader = new $class();

		$time = time();
						
		// Import CSS
		if (\Input::post('FORM_SUBMIT') == 'tl_mivis_import')
		{
			$arrUploaded = $objUploader->uploadTo('system/tmp');

			if (empty($arrUploaded))
			{
				\Message::addError($GLOBALS['TL_LANG']['ERR']['all_fields']);
				$this->reload();
			}

			$this->import('Database');
			$arrTable = array();

			foreach ($arrUploaded as $strCsvFile)
			{
				$objFile = new \File($strCsvFile, true);

				// Get separator
				$strSeparator = '^';

				$resFile = $objFile->handle;

				while(($arrRow = @fgetcsv($resFile, null, $strSeparator)) !== false)
				{
					$arrTable[] = $arrRow;
				}
			}

			$objVersions = new \Versions($dc->table, \Input::get('id'));
			$objVersions->create();

			// Zuerst nur die Vereine importieren
			// In $row = 0 stehen die Spaltennamen
			$verein = array();
			$zps = array(); // Key ist die ZPS, Value ist die ID in tl_mivis_vereine
			for($row = 1; $row < count($arrTable); $row++)
			{
				$verein[utf8_encode($arrTable[$row][array_search('Vereins-Nr.', $arrTable[0])])] = array
				(
					'name' 		=> utf8_encode($arrTable[$row][array_search('Verein', $arrTable[0])]), 
					'kurzname' 	=> utf8_encode($arrTable[$row][array_search('Kurzname', $arrTable[0])]), 
				);
			}
			
			// Alle Vereine auf unveröffentlicht stellen
			$this->Database->prepare("UPDATE tl_mivis_vereine SET published=?")
						   ->execute('');
						   
			// Import speichern
			foreach($verein as $key => $value)
			{
				// Datensatz laden, wenn vorhanden
				$objVerein = $this->Database->prepare("SELECT * FROM tl_mivis_vereine WHERE zps=?")
						   	      ->execute($key);
				$set = array
				(
					'tstamp' 	=> $time, 
					'name' 		=> $value['name'], 
					'kurzname'	=> $value['kurzname'], 
					'zps' 		=> $key, 
					'published'	=> 1
				);
				// Update bzw. neuanlegen
				if($objVerein->id)
				{
					$this->Database->prepare("UPDATE tl_mivis_vereine %s WHERE id=?")
								   ->set($set)
								   ->execute($objVerein->id);
					$zps[$key] = $objVerein->id;
				}
				else
				{
					$objItem = $this->Database->prepare("INSERT INTO tl_mivis_vereine %s")
								    ->set($set)
								    ->execute();
					$zps[$key] = $objItem->insertId;
				}
			}
			
			// Jetzt die Mitglieder importieren
			// In $row = 0 stehen die Spaltennamen
			$mitglied = array();
			for($row = 1; $row < count($arrTable); $row++)
			{
				$status = utf8_encode($arrTable[$row][array_search('Spielgenehmigung', $arrTable[0])]);
				 
				$mitglied[utf8_encode($arrTable[$row][array_search('Vereins-Nr.', $arrTable[0])])][] = array
				(
					'dateAdded' 		=> $time, 
					'pkz' 				=> utf8_encode($arrTable[$row][array_search('pid', $arrTable[0])]), 
					'nachname'			=> utf8_encode($arrTable[$row][array_search('Name', $arrTable[0])]), 
					'vorname' 			=> utf8_encode($arrTable[$row][array_search('Vorname', $arrTable[0])]), 
					'titel' 			=> utf8_encode($arrTable[$row][array_search('Titel', $arrTable[0])]), 
					'geburtstag'		=> \Samson\Helper::setDate(utf8_encode($arrTable[$row][array_search('Geburtsdatum', $arrTable[0])])), 
					'geburtsort'		=> utf8_encode($arrTable[$row][array_search('Geburtsort', $arrTable[0])]), 
					'geschlecht'		=> utf8_encode($arrTable[$row][array_search('Geschlecht', $arrTable[0])]), 
					'nation' 			=> utf8_encode($arrTable[$row][array_search('Nation', $arrTable[0])]), 
					'fide_nation' 		=> utf8_encode($arrTable[$row][array_search('FIDE-Nation', $arrTable[0])]), 
					'fide_id' 			=> utf8_encode($arrTable[$row][array_search('FIDE-Nr.', $arrTable[0])]), 
					'gleichstellung' 	=> utf8_encode($arrTable[$row][array_search('Gleichstellung', $arrTable[0])]), 
					'datenschutz' 		=> (utf8_encode($arrTable[$row][array_search('Datenschutz', $arrTable[0])]) == 'N') ? '' : '1', 
					'strasse' 			=> utf8_encode($arrTable[$row][array_search(utf8_decode('Straße & Nr.'), $arrTable[0])]), 
					'plz' 				=> utf8_encode($arrTable[$row][array_search('PLZ', $arrTable[0])]), 
					'ort' 				=> utf8_encode($arrTable[$row][array_search('Ort', $arrTable[0])]), 
					'land' 				=> utf8_encode($arrTable[$row][array_search('Land', $arrTable[0])]), 
					'telefon1' 			=> utf8_encode($arrTable[$row][array_search('Telefon 1', $arrTable[0])]), 
					'telefon2' 			=> utf8_encode($arrTable[$row][array_search('Telefon 2', $arrTable[0])]), 
					'telefon3' 			=> utf8_encode($arrTable[$row][array_search('Telefon 3', $arrTable[0])]), 
					'telefax' 			=> utf8_encode($arrTable[$row][array_search('Fax', $arrTable[0])]), 
					'email' 			=> utf8_encode($arrTable[$row][array_search('E-Mail', $arrTable[0])]), 
					'zusatz' 			=> utf8_encode($arrTable[$row][array_search('Zusatz', $arrTable[0])]), 
					'mglnr' 			=> utf8_encode($arrTable[$row][array_search('Spieler-Nr.', $arrTable[0])]), 
					'von' 				=> \Samson\Helper::setDate(utf8_encode($arrTable[$row][array_search('Von', $arrTable[0])])), 
					'bis' 				=> \Samson\Helper::setDate(utf8_encode($arrTable[$row][array_search('Bis', $arrTable[0])])), 
					'status' 			=> ($status) ? substr($status,0,1) : '', 
					'beitrag' 			=> utf8_encode($arrTable[$row][array_search('Beitragstatus', $arrTable[0])]), 
				);
			}
			
			// Alle Mitglieder auf unveröffentlicht stellen
			$this->Database->prepare("UPDATE tl_mivis_spieler SET published=?")
						   ->execute('');
						   
			// Import speichern
			$ix = 0;
			foreach($mitglied as $verein => $item)
			{
				// $verein = ZPS, $item = Array mit Mitgliedern zu dieser ZPS
				foreach($item as $key => $value)
				{
					// $key = Index, $value = Array mit Daten zum Mitglied
					// Datensatz laden, wenn vorhanden
					$objMitglied = $this->Database->prepare("SELECT * FROM tl_mivis_spieler WHERE mglnr=? AND pid=?")
							   	                  ->execute($value['mglnr'], $zps[$verein]);
					$ix++;
					$set = array
					(
						'tstamp' 			=> $time, 
						'pid' 			    => $zps[$verein], 
						'dateAdded'			=> $value['dateAdded'],	
						'pkz' 				=> $value['pkz'],	
						'nachname'			=> $value['nachname'],	
						'vorname' 			=> $value['vorname'],	
						'alias' 			=> $varValue = standardize(\String::restoreBasicEntities($value['nachname'].'-'.$value['vorname'].'-'.$ix)),
						'titel' 			=> $value['titel'],    
						'geburtstag'		=> $value['geburtstag'],    
						'geburtsort'		=> $value['geburtsort'],    
						'geschlecht'		=> $value['geschlecht'],    
						'nation' 			=> $value['nation'],    
						'fide_nation' 		=> $value['fide_nation'],	
						'fide_id' 			=> $value['fide_id'],	
						'gleichstellung' 	=> $value['gleichstellung'],    
						'datenschutz' 		=> $value['datenschutz'],	
						'strasse' 			=> $value['strasse'],	
						'plz' 				=> $value['plz'],	
						'ort' 				=> $value['ort'],	
						'land' 				=> $value['land'],	
						'telefon1' 			=> $value['telefon1'],	
						'telefon2' 			=> $value['telefon2'],	
						'telefon3' 			=> $value['telefon3'],	
						'telefax' 			=> $value['telefax'],	
						'email' 			=> $value['email'],    
						'zusatz' 			=> $value['zusatz'],    
						'mglnr' 			=> $value['mglnr'],    
						'von' 				=> $value['von'],	
						'bis' 				=> $value['bis'],	
						'status' 			=> $value['status'],    
						'beitrag' 			=> $value['beitrag'],	
						'published'			=> 1
					);
					// Update bzw. neuanlegen
					if($objMitglied->id)
					{
						$this->Database->prepare("UPDATE tl_mivis_spieler %s WHERE id=?")
									   ->set($set)
									   ->execute($objMitglied->id);
					}
					else
					{
						$this->Database->prepare("INSERT INTO tl_mivis_spieler %s")
									   ->set($set)
									   ->execute();
					}
				}
			}
			
			//$content = '<pre>';
			//$content .= print_r($mitglied, true);
			//$content .= '</pre>';

			//$this->Database->prepare("UPDATE " . $dc->table . " SET tableitems=? WHERE id=?")
			//			   ->execute(serialize($arrTable), \Input::get('id'));

			\System::setCookie('BE_PAGE_OFFSET', 0, 0);
			$this->redirect(str_replace('&key=import', '', \Environment::get('request')));
		}

		// Return form
		return $content .'
<div id="tl_buttons">
<a href="'.ampersand(str_replace('&key=table', '', \Environment::get('request'))).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>
'.\Message::generate().'
<form action="'.ampersand(\Environment::get('request'), true).'" id="tl_table_import" class="tl_form" method="post" enctype="multipart/form-data">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_mivis_import">
<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">

<div class="tl_tbox">
  <h3>'.$GLOBALS['TL_LANG']['mivis']['source'][0].'</h3>'.$objUploader->generateMarkup().(isset($GLOBALS['TL_LANG']['mivis']['source'][1]) ? '
  <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['mivis']['source'][1].'</p>' : '').'
</div>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
  <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['mivis']['tw_import'][0]).'">
</div>

</div>
</form>';

	} 

}
