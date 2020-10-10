<?php

// Palettes.
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{isotope_package_self_booking_list__legend:hide},isotopePackageSelfBookingListSender,isotopePackageSelfBookingListCustomerNumber,isotopePackageSelfBookingListDocumentName;';

// Fields.
$GLOBALS['TL_DCA']['tl_settings']['fields']['isotopePackageSelfBookingListSender'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['isotopePackageSelfBookingListSender'],
    'inputType' => 'text',
    'eval'      => array('mandatory'=>TRUE, 'maxlength'=>255, 'tl_class'=>'clr w50'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['isotopePackageSelfBookingListCustomerNumber'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['isotopePackageSelfBookingListCustomerNumber'],
    'inputType' => 'text',
    'eval'      => array('mandatory'=>TRUE, 'maxlength'=>255, 'tl_class'=>'clr w50'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['isotopePackageSelfBookingListDocumentName'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['isotopePackageSelfBookingListDocumentName'],
    'inputType' => 'text',
    'eval'      => array('mandatory'=>TRUE, 'maxlength'=>255, 'tl_class'=>'clr w50'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
