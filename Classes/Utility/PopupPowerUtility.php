<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 extension: popup_power.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Slavlee\PopupPower\Utility;

use Slavlee\PopupPower\Domain\Model\Configuration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class PopupPowerUtility
{
    /**
     * Convert Configuration to settings json for PopupPower JS Module
     * @param Configuration $configuration
     * @return string
     */
    public static function configurationToJsModuleSettings(Configuration $configuration): string
    {
        $settings = [
            'behaviourAppearance' => $configuration->getBehaviourAppearance(),
            'delay' => $configuration->getDelay(),
            'identifier' => (string)$configuration->getUid(),
        ];

        return \json_encode($settings);
    }

    /**
     * Return true, if popup_power_pro is installed
     * @return bool
     */
    public static function isProVersionInstalled(): bool
    {
        return ExtensionManagementUtility::isLoaded('popup_power_pro');
    }
}
