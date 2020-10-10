<?php

namespace MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection;

use Contao\StringUtil;

/**
 * Class ButtonCallback.
 *
 * @package MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection
 */
class ButtonCallback {

    /**
     * Add print "package self booking list" button.
     *
     * @param array $buttons
     *   The buttons.
     *
     * @return array
     *   The edited buttons array.
     */
    public function addPrintPackageSelfBookingListButton(array $buttons): array {
        $buttons[PackageSelfBookingListPrinter::PACKAGE_SELF_BOOKING_LIST_BUTTON_ID] = '<button type="submit" name="print_package_self_booking_list" id="print_package_self_booking_list" class="tl_submit">' . StringUtil::specialchars($GLOBALS['TL_LANG']['tl_iso_product_collection'][PackageSelfBookingListPrinter::PACKAGE_SELF_BOOKING_LIST_BUTTON_ID][0]) . '</button>';
        return $buttons;
    }

}
