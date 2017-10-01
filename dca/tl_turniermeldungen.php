<?php

class tl_turniermeldungen extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
    }	
	 
public function checkMeldungState($row, $label){
	
	$style = "";
	
	if($row['state'] == 'NEW'){
		//meldungen die in 4 wochen anstehen orange markieren
		if(($row['date']-time()) <= (60*60*24*7*4)){
			$style = "color:#000000;";
			}
		}
		
	if($row['state'] == 'BES'){
		$style = "color:#0DFF00;";
		}	
		
		
	if($row['state'] == 'CONF'){
		$style = "color:#FFA600;";
		}
	if($row['state'] == 'REJ'){
		$style = "color:#FF0000;";
		}
		
		$label = str_replace('#style#',$style,$label);
		
		//Überprüfe ob es Paaranmerkungen gibt
		if(strlen($row['comment_couple'])>0){
			$comment_couple = '<tr><td colspan=3>
			<strong>Paaranmerkung:</strong><br>
			'.$row['comment_couple'].'
			</td></tr>';
			$label = str_replace('#comment_couple#',$comment_couple,$label);	
			}else{
			$label = str_replace('#comment_couple#','',$label);	
				}
				
		//Überprüfe ob es Sportwartanmerkungen gibt
		if(strlen($row['comment_admin'])>0){
			$comment_couple = '<tr><td colspan=3>
			<strong>Sportwartanmerkung:</strong><br>
			'.$row['comment_admin'].'
			</td></tr>';
			$label = str_replace('#comment_admin#',$comment_couple,$label);	
			}else{
			$label = str_replace('#comment_admin#','',$label);	
				}		
		//Namen des Paares einfügen
		$herr = $this->Database->prepare("SELECT b.firstname, b.lastname FROM tl_turniermeldungen m, tl_turnierpaare p, tl_member b WHERE m.pid = p.id AND p.herr_id = b.id AND p.id = ".$row['pid']) 
                         ->execute();
		$label = str_replace('#herr#',$herr->firstname." ".$herr->lastname,$label);	
		
		$dame = $this->Database->prepare("SELECT b.firstname, b.lastname FROM tl_turniermeldungen m, tl_turnierpaare p, tl_member b WHERE m.pid = p.id AND p.dame_id = b.id AND p.id = ".$row['pid']) 
                         ->execute();
		$label = str_replace('#dame#',$dame->firstname." ".$dame->lastname,$label);	
			 	
	return $label;
	}	 
 
 public function meldungAction($row, $href, $label, $title, $icon, $attributes)
    {
		
		$link = "";
		if(($row['date']-time()) <= (60*60*24*7*4)){
		$link = '<a href="' . $this->addToUrl($href . '&id=' . $row['id'], 1) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
		}
		
		return $link;
    }
 
 public function onloadTurniermeldungAction(){
	 
	 if (Input::get('mode') == 'offen'){
		 $this->Database->prepare("UPDATE tl_turniermeldungen 
                                   SET state = 'NEW' 
                                   WHERE id =".Input::get('id')) 
                         ->execute();
		 }
	if (Input::get('mode') == 'gemeldet'){
		 $this->Database->prepare("UPDATE tl_turniermeldungen 
                                   SET state = 'CONF' 
                                   WHERE id =".Input::get('id')) 
                         ->execute();
		 }
	if (Input::get('mode') == 'bestätigt'){
		 $this->Database->prepare("UPDATE tl_turniermeldungen 
                                   SET state = 'BES' 
                                   WHERE id =".Input::get('id')) 
                         ->execute();
		 }		 	
	if (Input::get('mode') == 'abgelehnt'){
		 $this->Database->prepare("UPDATE tl_turniermeldungen 
                                   SET state = 'REJ' 
                                   WHERE id =".Input::get('id')) 
                         ->execute();
		 }	  
	 
	 }
	 
	public function checkDate($varValue){
		
		if(!$varValue){
		return time();
		}else{
		return $varValue;	
			}
		}	 
 
  public function getCouples() 
    { 
        $couples = array(); 
        // Get all the active couples 		  
        $objCouples = $this->Database->prepare("Select p.id From tl_turnierpaare p, tl_member m WHERE p.aktiv = 1 AND p.herr_id = m.id ORDER BY m.firstname
") 
                                      ->execute(); 
        $i = 0;
		while ($objCouples->next()) 
        {
            $couples[$i] =$objCouples->id; 
			$i++;
        } 
 
        return $couples; 
    }
	
	public function getCouplesReference($dc){
		  $reference = array();
	  
	  $objCouples = $this->Database->prepare("SELECT * FROM tl_turnierpaare ORDER BY id") 
                                      ->execute(); 
	while($objCouples->next()){
		
		$herr = $this->Database->prepare("SELECT * FROM tl_member WHERE id =?") 
                                      ->execute($objCouples->herr_id);
		$dame = $this->Database->prepare("SELECT * FROM tl_member WHERE id =?") 
                                      ->execute($objCouples->dame_id);  
		
		$id = $objCouples->id;
		$reference[$id] = $herr->firstname." ".$herr->lastname." - ".$dame->firstname." ".$dame->lastname;
		}								  
	  $GLOBALS['TL_LANG']['tl_turniermeldungen']['paarReference'] = $reference; 
		}	
	
	
} 
/**
 * Table tl_turniermeldungen
 */
$GLOBALS['TL_DCA']['tl_turniermeldungen'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'ptable' => 'tl_turnierpaare',
		'enableVersioning' => true,
		'onload_callback' => array(
            array(
                'tl_turniermeldungen',
                'onloadTurniermeldungAction'
            ),
			array('tl_turniermeldungen','getCouplesReference'),
			),
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		),
	),
	
	
	// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('date ASC', 'place', 'class'),
			'panelLayout' => 'filter,search',
			'filter'		=> array(array('date>=?', time()-(60*60*24)))
		),
		
		
		
		'label'             => array
		(
			'fields' => array('place','class','dtv_nr'),
			'format' => '
			<table>
			<tr>
			<td width="150" style="#style#">%s</td>
			<td width="80" style="#style#">%s<br>(<strong>%s</strong>)</td>
			<td style="#style#">#herr#<br>#dame#</td>
			</tr>
			#comment_couple#
			#comment_admin#
			</table>',
			'label_callback' => array('tl_turniermeldungen', 'checkMeldungState')
		),
		
		
		'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		
		
		
		'operations'        => array
		(
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'offen'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['offen'],
				'href'  => 'mode=offen',
				'button_callback'  => array('tl_turniermeldungen', 'meldungAction'),
				'icon'  => 'system/modules/turnierpaare/assets/images/black-ball.png'
			),
			'gemeldet'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['gemeldet'],
				'href'  => 'mode=gemeldet',
				'button_callback'  => array('tl_turniermeldungen', 'meldungAction'),
				'icon'  => 'system/modules/turnierpaare/assets/images/orange-ball.png'
			),
			'bestätigt'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['bestätigt'],
				'href'  => 'mode=bestätigt',
				'button_callback'  => array('tl_turniermeldungen', 'meldungAction'),
				'icon'  => 'system/modules/turnierpaare/assets/images/green-ball.png'
			),
			'abgelehnt'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['abgelehnt'],
				'href'  => 'mode=abgelehnt',
				'button_callback'  => array('tl_turniermeldungen', 'meldungAction'),
				'icon'  => 'system/modules/turnierpaare/assets/images/red-ball.png'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['show'],
				'href'       => 'act=show',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'default'       => '{turniermeldungen_plaar_legend},pid;{turniermeldungen_turnier_legend},date,place,class,dtv_nr,state;{turniermeldungen_anmerkungen_legend}, comment_couple,comment_admin'
),


// Fields
	'fields'   => array
	(
		'id'     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'pid' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['pid'],
            'foreignKey' => 'tl_turnierpaare.id',
			'inputType' => 'select',
			'options_callback'  => array('tl_turniermeldungen', 'getCouples'),
			'reference' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['paarReference'], 
			'search'                  => false, 
            'sorting'                 => true,
			'filter'				=>true, 
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => array(
                'type' => 'belongsTo',
                'load' => 'lazy'
            ),
            'eval' => array(
                'doNotShow' => true
            ),
        ),
		'date'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['date'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 6,
			'filter'	=> true,
            'search'    => false,
			'load_callback' => array(array('tl_turniermeldungen','checkDate')),
			'eval'                    => array('mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard', 'minlength' => 1, 'maxlength'=>64, 'rgxp' => 'date'),
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		),
		'reg_date'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['reg_date'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 6,
            'search'    => false,
			'eval'                    => array('mandatory'=>false, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard', 'minlength' => 1, 'maxlength'=>64, 'rgxp' => 'date'),
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		),
		'place'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['place'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'adresse'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['adresse'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 11,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'telefon'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['telefon'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'verein'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['verein'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		,
		'uhrzeit'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['uhrzeit'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		,
		'country'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['country'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		,
		'class'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['class'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		,
		'state'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['state'],
			'inputType' => 'select',
			'options' => array('NEW', 'CONF', 'BES','REJ'),
			'reference' => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['stateReference'],
			'exclude'   => false,
			'sorting'   => false,
			'filter'	=> true,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		,
		'notified'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['notified'],
			'inputType' => 'checkbox',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "char(1) NOT NULL default ''"
		)
		,
		'dtv_nr'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['dtv_nr'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		,
		'comment_couple'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['comment_couple'],
			'inputType' => 'textarea',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 500,
				'tl_class'        => 'clr',
 
			),
			'sql'       => "varchar(500) NOT NULL default ''"
		)
		,
		'comment_admin'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['comment_admin'],
			'inputType' => 'textarea',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 500,
				'tl_class'        => 'clr',
 
			),
			'sql'       => "varchar(500) NOT NULL default ''"
		)
		,
		'result_submitted'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['result_submitted'],
			'inputType' => 'checkbox',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "char(1) NOT NULL default '0'"
		)
		,
		'bemerkungen'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turniermeldungen']['bemerkungen'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		)
		
       )
);

?>