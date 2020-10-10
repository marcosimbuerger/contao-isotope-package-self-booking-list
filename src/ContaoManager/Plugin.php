<?php

namespace MarcoSimbuerger\IsotopePackageSelfBookingListBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MarcoSimbuerger\IsotopePackageSelfBookingListBundle\ContaoIsotopePackageSelfBookingListBundle;

/**
 * Class Plugin.
 *
 * @package MarcoSimbuerger\IsotopePackageSelfBookingListBundle\ContaoManager
 */
class Plugin implements BundlePluginInterface {

    /**
     * {@inheritdoc}.
     */
    public function getBundles(ParserInterface $parser) {
        return [
            BundleConfig::create(ContaoIsotopePackageSelfBookingListBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    'isotope',
                ]),
        ];
    }
}
