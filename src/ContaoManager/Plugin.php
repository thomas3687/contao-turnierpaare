<?php

declare(strict_types=1);

namespace ThomasBilich\Turnierpaarverwaltung\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use ThomasBilich\Turnierpaarverwaltung\TurnierpaarverwaltungBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(TurnierpaarverwaltungBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}