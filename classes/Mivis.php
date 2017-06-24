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
 * Class Mivis
 *
 * @copyright  Frank Hoppe 2016
 * @author     Frank Hoppe
 * @package    Devtools
 */
class Mivis extends \Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		//parent::__construct();
		//$this->import('Mivis\BackendUser', 'User');
		
	}

 	/**
	 * Verschickt eine Email an den DV-Referenten
	 * @param object/array Daten
	 * @param boolean true = Meues Mitglied, false = Änderungen
	 * @return array	Rechte
	 */
	public static function Mail($User, $data, $info, $status = false)
	{	
		if($status)
		{
			$objVerein = \Database::getInstance()->prepare("SELECT * FROM tl_mivis_vereine WHERE id = ?")
												 ->execute($data->pid);
			$titel = $objVerein->zps.' Neuanmeldung '.$data->vorname.' '.$data->nachname;
			$content = "<ul>\n";
			$content .= "<li>Name: <b>".$data->nachname."</b></li>\n";
			$content .= "<li>Vorname: <b>".$data->vorname."</b></li>\n";
			$content .= "<li>Titel: <b>".$data->titel."</b></li>\n";
			$content .= "<li>Status: <b>".$data->status."</b></li>\n";
			$content .= "<li>von: <b>".$data->von."</b></li>\n";
			$content .= "<li>bis: <b>".$data->bis."</b></li>\n";
			$content .= "<li>Geburtstag: <b>".$data->geburtstag."</b></li>\n";
			$content .= "<li>Geburtsort: <b>".$data->geburtsort."</b></li>\n";
			$content .= "<li>Geschlecht: <b>".$data->geschlecht."</b></li>\n";
			$content .= "<li>Nation: <b>".$data->nation."</b></li>\n";
			$content .= "<li>FIDE-Nation: <b>".$data->fide_nation."</b></li>\n";
			$content .= "<li>FIDE-ID: <b>".$data->fide_id."</b></li>\n";
			$content .= "<li>Gleichstellung: <b>".$data->gleichstellung."</b></li>\n";
			$content .= "<li>Datenschutz: <b>".$data->datenschutz."</b></li>\n";
			$content .= "<li>PLZ: <b>".$data->plz."</b></li>\n";
			$content .= "<li>Wohnort: <b>".$data->ort."</b></li>\n";
			$content .= "<li>Straße: <b>".$data->strasse."</b></li>\n";
			$content .= "<li>Land: <b>".$data->land."</b></li>\n";
			$content .= "<li>Telefon 1: <b>".$data->telefon1."</b></li>\n";
			$content .= "<li>Telefon 2: <b>".$data->telefon2."</b></li>\n";
			$content .= "<li>Telefon 3: <b>".$data->telefon3."</b></li>\n";
			$content .= "<li>Telefax: <b>".$data->telefax."</b></li>\n";
			$content .= "<li>E-Mail: <b>".$data->email."</b></li>\n";
			$content .= "<li>Zusatz: <b>".$data->zusatz."</b></li>\n";
			$content .= "<li>Veröffentlicht: <b>".$data->published."</b></li>\n";
			$content .= "</ul>";
			$content .= "<p>Angemeldet von ".$User->name." (".$User->username.") - ".$User->email."</p>";
			$hinweis = "<p>\n";
			$hinweis .= 'Bearbeiten: <a href="http://www.berlinerschachverband.de/contao/main.php?do=mivis_vereinsliste&table=tl_mivis_spieler&act=edit&id='.$data->id.'" target="_blank">http://www.berlinerschachverband.de/contao/main.php?do=mivis_vereinsliste&table=tl_mivis_spieler&act=edit&id='.$data->id.'</a>';
			$hinweis .= "</p>\n";
			$hinweis .= "<p>\n";
			$hinweis .= 'Diese E-Mail wurde automatisch generiert.';
			$hinweis .= "</p>\n";
		}
		else
		{
			// Geänderter Datensatz
			$objVerein = \Database::getInstance()->prepare("SELECT * FROM tl_mivis_vereine WHERE id = ?")
												 ->execute($info['pid']);
			$titel = $objVerein->zps.' Änderung '.$info['vorname'].' '.$info['nachname'];
			$content = "<ul>\n";
			$content .= $data;
			$content .= "</ul>";
			$content .= "<p>Geändert von ".$User->name." (".$User->username.") - ".$User->email."</p>";
			$hinweis = "<p>\n";
			$hinweis .= 'Bearbeiten: <a href="http://www.berlinerschachverband.de/contao/main.php?do=mivis_vereinsliste&table=tl_mivis_spieler&act=edit&id='.$info['id'].'" target="_blank">http://www.berlinerschachverband.de/contao/main.php?do=mivis_vereinsliste&table=tl_mivis_spieler&act=edit&id='.$info['id'].'</a>';
			$hinweis .= "</p>\n";
			$hinweis .= "<p>\n";
			$hinweis .= 'Diese E-Mail wurde automatisch generiert.';
			$hinweis .= "</p>\n";
		}
		
		$header = "<html lang=\"de\">\n";
		$header .= "<head>\n";
		$header .= '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
		$header .= "</head>\n";
		$header .= "<body>\n";
		$header .= "<h1>".$titel."</h1>\n";
		$footer = "</body>\n";
		$footer .= "</html>\n";
		$objEmail = new \Email();
		$objEmail->from = 'webmaster@berlinerschachverband.de';
		$objEmail->fromName = 'BSV-Mitgliederdatenbank';
		$objEmail->subject = '[BSV-Mitgliederdatenbank] '.$titel;
		$objEmail->html = $header.$content.$hinweis.$footer;
		$objEmail->sendCc(array
		(
			$User->name.' <'.$User->email.'>'
		)); 
		$objEmail->sendBcc(array
		(
			'Frank Hoppe <webmaster@berlinerschachverband.de>'
		)); 
		$objEmail->sendTo(array
		(
			'Frank Hoppe <webmaster@berlinerschachverband.de>'
		)); 
	
	}

 	/**
	 * Liefert die Zugriffsrechte des aktuellen Benutzers zurück
	 * @return array	Rechte
	 */
	public static function initPermissions($User)
	{	

		$objConfig = \Database::getInstance()->prepare("SELECT * FROM tl_mivis_rechte WHERE benutzer = ?")
											 ->execute($User->id);
				
    	// Feld für Nichtadmins ausblenden (muß mit den erlaubten Feldern übereinstimmen)
    	$GLOBALS['TL_DCA']['tl_mivis_vereine']['fields']['kurzname']['exclude'] = true;
    	// Erlaubte Felder hinzufügen
    	$User->alexf = array_merge(array('tl_mivis_vereine::name'),$User->alexf);
    	$User->modules = array_merge(array('mivis_rechte'),$User->modules);
    	$User->mivis = array(7);

		return $User;
	}

}
