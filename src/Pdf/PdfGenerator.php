<?php

namespace MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Pdf;

use Contao\Environment;
use TCPDF;

/**
 * Class PdfGenerator.
 *
 * @package MarcoSimbuerger\IsotopePackageSelfBookingListBundle\Pdf
 */
class PdfGenerator {

    /**
     * The TCPDF config.
     *
     * @var array
     */
    private $tcpdfConfig;

    /**
     * The TCPDF object.
     *
     * @var \TCPDF
     */
    private $tcpdf;

    /**
     * PdfGenerator constructor.
     */
    public function __construct() {
        // TCPDF configuration.
        $this->tcpdfConfig = [];
        $this->tcpdfConfig['a_meta_dir'] = 'ltr';
        $this->tcpdfConfig['a_meta_charset'] = $GLOBALS['TL_CONFIG']['characterSet'];
        $this->tcpdfConfig['a_meta_language'] = substr($GLOBALS['TL_LANGUAGE'], 0, 2);
        $this->tcpdfConfig['w_page'] = 'page';

        // Include TCPDF config.
        define('K_TCPDF_EXTERNAL_CONFIG', true);
        define('K_PATH_MAIN', TL_ROOT . '/vendor/tecnickcom/tcpdf/');
        define('K_PATH_URL', Environment::get('base') . 'vendor/tecnickcom/tcpdf/');
        define('K_PATH_FONTS', K_PATH_MAIN . 'fonts/');
        define('K_PATH_CACHE', TL_ROOT . '/system/tmp/');
        define('K_PATH_URL_CACHE', TL_ROOT . '/system/tmp/');
        define('K_PATH_IMAGES', K_PATH_MAIN . 'images/');
        define('K_BLANK_IMAGE', K_PATH_IMAGES . '_blank.png');
        define('PDF_PAGE_FORMAT', 'A4');
        define('PDF_PAGE_ORIENTATION', 'P');
        define('PDF_CREATOR', 'Contao Open Source CMS');
        define('PDF_AUTHOR', Environment::get('url'));
        define('PDF_HEADER_TITLE', $GLOBALS['TL_CONFIG']['websiteTitle']);
        define('PDF_HEADER_STRING', '');
        define('PDF_HEADER_LOGO', '');
        define('PDF_HEADER_LOGO_WIDTH', 30);
        define('PDF_UNIT', 'mm');
        define('PDF_MARGIN_HEADER', 0);
        define('PDF_MARGIN_FOOTER', 0);
        define('PDF_MARGIN_TOP', 10);
        define('PDF_MARGIN_BOTTOM', 10);
        define('PDF_MARGIN_LEFT', 15);
        define('PDF_MARGIN_RIGHT', 15);
        define('PDF_FONT_NAME_MAIN', 'freeserif');
        define('PDF_FONT_SIZE_MAIN', 12);
        define('PDF_FONT_NAME_DATA', 'freeserif');
        define('PDF_FONT_SIZE_DATA', 12);
        define('PDF_FONT_MONOSPACED', 'freemono');
        define('PDF_FONT_SIZE_MONOSPACED', 10); // PATCH
        define('PDF_IMAGE_SCALE_RATIO', 1.25);
        define('HEAD_MAGNIFICATION', 1.1);
        define('K_CELL_HEIGHT_RATIO', 1.25);
        define('K_TITLE_MAGNIFICATION', 1.3);
        define('K_SMALL_RATIO', 2/3);
        define('K_THAI_TOPCHARS', false);
        define('K_TCPDF_CALLS_IN_HTML', false);

        $this->tcpdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
    }

    /**
     * Generate the pdf document
     *
     * @return \TCPDF
     *   The TCPDF object.
     */
    public function generatePdf(string $siteTitle, string $htmlTemplate): TCPDF {
        // Set document information.
        $this->tcpdf->SetCreator(PDF_CREATOR);
        $this->tcpdf->SetAuthor(PDF_AUTHOR);
        $this->tcpdf->SetTitle($siteTitle);

        // Prevent font subsetting (huge speed improvement).
        $this->tcpdf->setFontSubsetting(false);

        // Remove default header/footer.
        $this->tcpdf->setPrintHeader(false);
        $this->tcpdf->setPrintFooter(false);

        // Set margins.
        $this->tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // Set auto page breaks.
        $this->tcpdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // Set image scale factor.
        $this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set some language-dependent strings.
        $this->tcpdf->setLanguageArray($this->tcpdfConfig);

        // Initialize document and add a page.
        $this->tcpdf->AddPage();

        // Set font.
        $this->tcpdf->SetFont(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN);

        // Write the HTML content.
        $this->tcpdf->writeHTML($htmlTemplate, true, 0, true, 0);

        $this->tcpdf->lastPage();

        return $this->tcpdf;
    }
}