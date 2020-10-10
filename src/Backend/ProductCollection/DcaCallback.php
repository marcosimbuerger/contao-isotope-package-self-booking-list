<?php

namespace MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection;

use Contao\Backend;
use Contao\DC_Table;
use Contao\Environment;
use Contao\Input;

/**
 * Class DcaCallback.
 *
 * @package MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection
 */
class DcaCallback extends Backend {

    /**
     * Called by onload_callback.
     *
     * @param \Contao\DC_Table $dataContainer
     *   The Contao data container (DC).
     */
    public function onLoad(DC_Table $dataContainer): void {
        // Is available after button submission.
        if (Input::post('FORM_SUBMIT') === 'tl_select') {
            if (isset($_POST[PackageSelfBookingListPrinter::PACKAGE_SELF_BOOKING_LIST_BUTTON_ID])) {
                // Replace default 'select' action with 'print' action.
                $this->redirect(str_replace('act=select', 'act=' . PackageSelfBookingListPrinter::PACKAGE_SELF_BOOKING_LIST_ACTION_NAME, Environment::get('request')));
            }
        }

        // Is available after button redirect (see lines above).
        if (Input::get('act') === PackageSelfBookingListPrinter::PACKAGE_SELF_BOOKING_LIST_ACTION_NAME) {
            $dataContainer->{PackageSelfBookingListPrinter::PACKAGE_SELF_BOOKING_LIST_ACTION_NAME} = function() {
                $packageSelfBookingListPrinter = new PackageSelfBookingListPrinter();
                return $packageSelfBookingListPrinter->printPackageSelfBookingList();
            };
        }
    }

}
