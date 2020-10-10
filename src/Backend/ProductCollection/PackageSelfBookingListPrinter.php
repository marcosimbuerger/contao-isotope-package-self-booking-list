<?php

namespace MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection;

use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\Message;
use Contao\System;
use MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Pdf\PdfGenerator;
use Isotope\Model\ProductCollection;
use Psr\Log\LogLevel;

/**
 * Class PackageSelfBookingListPrinter.
 *
 * @package MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Backend\ProductCollection
 */
class PackageSelfBookingListPrinter {

    /**
     * The package self booking list button name.
     *
     * @var string
     */
    public const PACKAGE_SELF_BOOKING_LIST_BUTTON_ID = 'print_package_self_booking_list';

    /**
     * The package self booking list action name.
     *
     * @var string
     */
    public const PACKAGE_SELF_BOOKING_LIST_ACTION_NAME = 'printPackageSelfBookingList';

    /**
     * The monolog logger.
     *
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    /**
     * The url of the current request.
     *
     * @var string
     */
    protected $currentRequestUrl;

    /**
     * The redirect url.
     *
     * @var string
     */
    protected $redirectUrl;

    /**
     * PackageSelfBookingListPrinter constructor.
     */
    public function __construct() {
        $this->logger = System::getContainer()->get('monolog.logger.contao');
        $this->currentRequestUrl = Environment::get('request');
        $this->redirectUrl = str_replace('&act=' . self::PACKAGE_SELF_BOOKING_LIST_ACTION_NAME, '', $this->currentRequestUrl);
    }

    /**
     * Print the package self booking list.
     */
    public function printPackageSelfBookingList(): void {
        if ($this->checkRequiredSettingsData() === TRUE) {
            if ($ids = $this->getSessionIds()) {
                /** @var \Contao\Model\Collection $productCollection */
                $productCollection = ProductCollection::findMultipleByIds($ids);

                /** @var \Contao\FrontendTemplate $template */
                $template = new FrontendTemplate('iso_document_package_self_booking_list');
                $template->orders = $productCollection;
                $renderedTemplate = $template->parse();

                $documentName = 'package-self-booking-list';
                if (isset($GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListDocumentName']) && !empty($GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListDocumentName'])) {
                    $documentName = str_replace(' ', '_', $GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListDocumentName']);
                }

                // Generate the PDF.
                $pdfGenerator = new PdfGenerator();
                $pdf = $pdfGenerator->generatePdf($documentName, $renderedTemplate);

                // Output to the browser.
                $pdf->Output($documentName . 'pdf', 'D');
            } else {
                $this->printErrorMessageAndRedirect('Could not load session ids.', __FUNCTION__);
            }
        }
    }

    /**
     * Check the required settings data.
     *
     * @return bool
     *   TRUE or FALSE.
     */
    protected function checkRequiredSettingsData(): bool {
        if (!isset($GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListSender']) || empty($GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListSender'])) {
            $this->printErrorMessageAndRedirect('The sender of the package self booking list is not set in the settings.', __FUNCTION__);
            return FALSE;
        }
        if (!isset($GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListCustomerNumber']) || empty($GLOBALS['TL_CONFIG']['isotopePackageSelfBookingListCustomerNumber'])) {
            $this->printErrorMessageAndRedirect('The customer number of the package self booking list is not set in the settings.', __FUNCTION__);
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Get the sessions ids (the selected entities).
     *
     * @return array
     *   The sessions ids.
     */
    protected function getSessionIds(): array {
        /** @var \Contao\Session $sessionObject */
        $sessionObject = System::getContainer()->get('session');
        $session = $sessionObject->all();
        return $session['CURRENT']['IDS'];
    }

    /**
     * Print error message & redirect.
     *
     * @param string $message
     *   The error message.
     * @param string $functionName
     *   The function name.
     */
    protected function printErrorMessageAndRedirect(string $message, string $functionName): void {
        $this->logger->log(
            LogLevel::ERROR,
            $message,
            ['contao' => new ContaoContext(__CLASS__ . '::' . $functionName, TL_GENERAL)]
        );
        Message::addError($message);
        Controller::redirect($this->redirectUrl);
    }

}
