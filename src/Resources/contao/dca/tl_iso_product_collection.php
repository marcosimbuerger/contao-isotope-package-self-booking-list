<?php

use MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection\ButtonCallback;
use MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection\DcaCallback;

// Calls the 'DC_TableExtension' of the 'contao-data-container-extension' module.
$GLOBALS['TL_DCA']['tl_iso_product_collection']['config']['dataContainer'] = 'TableExtension';

// Callbacks.
$GLOBALS['TL_DCA']['tl_iso_product_collection']['config']['onload_callback'][] = [DcaCallback::class, 'onLoad'];
$GLOBALS['TL_DCA']['tl_iso_product_collection']['select']['buttons_callback'][] = [ButtonCallback::class, 'addPrintPackageSelfBookingListButton'];

// Palettes.
$GLOBALS['TL_DCA']['tl_iso_product_collection']['palettes']['default'] = str_replace
(
    '{details_legend},details,',
    '{details_legend},details,shipment_tracking,',
    $GLOBALS['TL_DCA']['tl_iso_product_collection']['palettes']['default']
);

// Fields.
$GLOBALS['TL_DCA']['tl_iso_product_collection']['fields']['shipment_tracking'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['shipment_tracking'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory'=>FALSE, 'maxlength'=>255, 'tl_class'=>'clr w50'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
