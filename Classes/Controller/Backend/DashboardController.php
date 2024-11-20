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

namespace Slavlee\PopupPower\Controller\Backend;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slavlee\PopupPower\Domain\Model\Configuration;
use Slavlee\PopupPower\Domain\Repository\ConfigurationRepository;
use Slavlee\PopupPower\Domain\Repository\PopupContentRepository;
use Slavlee\PopupPower\Domain\Service\LicenseService;
use Slavlee\PopupPower\Event\AssignVarsForDashboardEvent;
use Slavlee\PopupPower\Utility\PopupPowerUtility;
use Slavlee\PopupPower\Utility\TYPO3\RepositoryUtility;
use Slavlee\PopupPower\Utility\TYPO3\RootlineUtility;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

#[AsController]
final class DashboardController extends ActionController
{
    public function __construct(
        private readonly ModuleTemplateFactory $moduleTemplateFactory,
        private readonly ConfigurationRepository $configurationRepository,
        private readonly UriBuilder $backendUriBuilder,
        private readonly PageRepository $pageRepository,
        private readonly PopupContentRepository $popupContentRepository,
        private readonly LicenseService $licenseService
    ) {
        RepositoryUtility::disableRespectStoragePage($popupContentRepository);
    }

    /**
     * Start page of the dashboard
     * @return ResponseInterface
     */
    public function showAction(): ResponseInterface
    {
        $currentPageId = (int)$this->request->getQueryParams()['id'];

        // Init module template
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        // Gather info
        $moduleTemplate->assign('currentPageId', $currentPageId);
        $moduleTemplate->assign('noPageSelected', $currentPageId ? false : true);

        $configuration = null;

        if ($currentPageId > 0) {
            $configuration = $this->configurationRepository->findByPid($currentPageId)->current();

            // if there is no configuration,
            // then create blank one to give option to
            // override configuration
            // and get page id with the closest configuration
            if (!$configuration) {
                if ($this->licenseService->isValid(Configuration::class)) {
                    // Create new configuration object
                    // for form to override given setting
                    $configuration = GeneralUtility::makeInstance(Configuration::class);
                    $configuration->setPid($currentPageId);
                    $moduleTemplate->assign('configuration', $configuration);
                }
                // Get closest configuration to link to it
                $rootlineIds = RootlineUtility::getPageIds($currentPageId);
                $configurationClosest = $this->configurationRepository->findByRootline($rootlineIds)->current();
                if ($configurationClosest) {
                    $moduleTemplate->assign('pageClosest', $this->pageRepository->getPage($configurationClosest->getPid()));
                }
                $moduleTemplate->assign('configurationClosest', $configurationClosest);
            } else {
                $moduleTemplate->assign('configuration', $configuration);
            }

            $moduleTemplate->assign('isProVersionInstalled', PopupPowerUtility::isProVersionInstalled());
            $moduleTemplate->assign('popupContentPages', $this->popupContentRepository->findAll());
        }

        if ($configuration) {
            /**
             * @var AssignVarsForDashboardEvent $event
             */
            $event = $this->eventDispatcher->dispatch(new AssignVarsForDashboardEvent($configuration));
            $moduleTemplate->assignMultiple($event->getFluidVars());
        }

        return $moduleTemplate->renderResponse('Backend/Dashboard/Show');
    }

    /**
     * Remove a dashboard settings
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function removeConfiguration(ServerRequestInterface $request): ResponseInterface
    {
        RepositoryUtility::ignoreEnabledFields($this->configurationRepository, ['disabled']);
        $configuration = $this->configurationRepository->findByUid($request->getQueryParams()['configurationId']);

        if ($configuration) {
            $this->configurationRepository->remove($configuration);
            $this->configurationRepository->persistAll();
        }

        return $this->redirectToUri(
            $this->backendUriBuilder->buildUriFromRoutePath(
                '/module/web/popuppower/dashboard',
                [
                    'id' => $request->getQueryParams()['id'],
                ]
            )
        );
    }

    /**
     * Save a dashboard settings
     * @param Configuration $configuration
     * @param int $currentPageId
     * @return ResponseInterface
     */
    public function saveAction(Configuration $configuration, int $currentPageId): ResponseInterface
    {
        if (isset($this->request->getParsedBody()['remove'])) {
            return $this->redirectToUri(
                $this->backendUriBuilder->buildUriFromRoutePath(
                    '/module/web/popuppower/dashboard/remove',
                    [
                        'id' => $currentPageId,
                        'configurationId' => $configuration->getUid(),
                    ]
                )
            );
        }

        if ($configuration->_isNew()) {
            $this->configurationRepository->add($configuration);
        } else {
            $this->configurationRepository->update($configuration);
        }

        return $this->redirectToUri(
            $this->backendUriBuilder->buildUriFromRoutePath(
                '/module/web/popuppower/dashboard',
                [
                    'id' => $currentPageId,
                ]
            )
        );
    }
}
