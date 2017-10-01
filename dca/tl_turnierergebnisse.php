<?php
class tl_turnierergebnisse extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
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
	
	public function getLabel($row, $label){
		//Namen des Paares einfügen
		$herr = $this->Database->prepare("SELECT b.firstname, b.lastname FROM tl_turnierergebnisse m, tl_turnierpaare p, tl_member b WHERE m.pid = p.id AND p.herr_id = b.id AND p.id = ".$row['pid']) 
                         ->execute();
		$label = str_replace('#herr#',$herr->firstname." ".$herr->lastname,$label);	
		
		$dame = $this->Database->prepare("SELECT b.firstname, b.lastname FROM tl_turnierergebnisse m, tl_turnierpaare p, tl_member b WHERE m.pid = p.id AND p.dame_id = b.id AND p.id = ".$row['pid']) 
                         ->execute();
		$label = str_replace('#dame#',$dame->firstname." ".$dame->lastname,$label);	
			 	
	return $label;
		
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
	  $GLOBALS['TL_LANG']['tl_turnierergebnisse']['paarReference'] = $reference; 
		}	
	
	
} 
/**
 * Table tl_turnierergebnisse
 */
$GLOBALS['TL_DCA']['tl_turnierergebnisse'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'ptable' => 'tl_turnierpaare',
		'enableVersioning' => true,
		'onload_callback' => array
		(
			array('tl_turnierergebnisse', 'getCouplesReference')
		),
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid'=>'index'
			)
		),
	),
	
	
	// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('datum DESC', 'ort', 'pid'),
			'panelLayout' => 'filter,search,limit'
		),
		
		
		
		'label'             => array
		(
			'fields' => array('ort', 'platz', 'paare', 'klasse', 'kommentar'),
			'format' => '<strong>%s</strong><br><i>#herr# - #dame#</i> <strong>(%s/%s %s)</strong> %s',
			'label_callback' => array('tl_turnierergebnisse', 'getLabel')
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
				'label' => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['show'],
				'href'       => 'act=show',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'default'       => '{turnierergebnisse_plaar_legend},pid;{turnierergebnisse_platzierung_legend},platz,paare;{turnierergebnisse_datum_ort_klasse_legend}, datum,ort,klasse;{turnierergebnisse_kommentar_legend},kommentar'
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
            'label' => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['pid'],
            'foreignKey' => 'tl_turnierpaare.id',
			'inputType' => 'select',
			'options_callback'  => array('tl_turnierergebnisse', 'getCouples'),
			'reference' => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['paarReference'], 
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
		'platz'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['platz'],
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
		'paare'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['paare'],
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
		'ort'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['ort'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 11,
            'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'klasse'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['klasse'],
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
		'kommentar'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['kommentar'],
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
		/*'pid'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['pid'],
			'inputType' => 'select',
			'foreignKey'=> 'tl_turnierpaare.id',
			'options_callback'  => array('tl_turnierergebnisse', 'getCouples'),
			'search'                  => false, 
            'sorting'                 => true,
			'filter'				=>true, 
            'eval'                    => array('mandatory'=>true) ,
			'sql'       => "varchar(255) NOT NULL default ''"
		),*/
		'datum'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_turnierergebnisse']['datum'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 6,
            'search'    => false,
			'eval'                    => array('mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard', 'minlength' => 1, 'maxlength'=>64, 'rgxp' => 'date'),
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		)
		
       )
);

?>