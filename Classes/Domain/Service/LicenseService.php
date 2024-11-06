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

namespace Slavlee\PopupPower\Domain\Service;

use Slavlee\PopupPower\Domain\Model\Configuration;
use Slavlee\PopupPower\Domain\Model\Dto\LicenseData;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LicenseService
{
    /**
     * Return license information for given scope
     * @param string $scope
     * @return LicenseData
     */
    public function get(string $scope): LicenseData
    {
        $licenseData = new LicenseData();

        switch ($scope) {
            case Configuration::class:
                if (ExtensionManagementUtility::isLoaded('popup_power_pro')) {
                    $licenseData->limit = 9999;
                } else {
                    $licenseData->limit = 3;
                }
                break;
        }

        return $licenseData;
    }

    /**
     * Check if a scope is valid
     * @param string $scope
     * @return bool
     */
    public function isValid(string $scope): bool
    {
        $isValid = true;

        switch ($scope) {
            case Configuration::class:
                $service = GeneralUtility::makeInstance(ClosestConfigurationService::class);
                $licenseData = $this->get($scope);
                $isValid = isset($licenseData->limit) && $licenseData->limit > $service->countAll();
                break;
        }

        return $isValid;
    }
}
