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

namespace Slavlee\PopupPower\Controller;

use Slavlee\PopupPower\Utility\TYPO3\RootlineUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Slavlee\PopupPower\Domain\Repository\ConfigurationRepository;
use Psr\Http\Message\ResponseInterface;

final class PopupController extends ActionController
{
    public function __construct(
        private readonly ConfigurationRepository $configurationRepository
    ) {
    }

    /**
     * Show the popup, when enabled
     * @return ResponseInterface
     */
    public function showAction(): ResponseInterface
    {
        $rootlineIds = RootlineUtility::getPageIds($GLOBALS['TSFE']->id);
        $configurationClosest = $this->configurationRepository->findByRootline($rootlineIds)->current();

        // if there is no configuration, then render nothing
        if (!$configurationClosest || $configurationClosest->getHidden()) {
            return $this->htmlResponse($this->view->render('Nothing'));
        }

        return $this->htmlResponse();
    }

    /**
     * If popup is disabled,
     * then we show nothing
     * @return ResponseInterface
     */
    public function nothingAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }
}
