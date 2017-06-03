<?php
/**
 * @copyright Copyright (c) 2016 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\BagIt\Activity;

use OCP\Activity\IEvent;
use OCP\Activity\IEventMerger;
use OCP\Activity\IManager;
use OCP\Activity\IProvider;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\IUserManager;
use OCP\L10N\IFactory;

class Provider implements IProvider
{
    /** @var IFactory */
    protected $languageFactory;
    /** @var IL10N */
    protected $l;
    /** @var IURLGenerator */
    protected $url;
    /** @var IManager */
    protected $activityManager;
    /** @var IUserManager */
    protected $userManager;
    /** @var IEventMerger */
    protected $eventMerger;
    /** @var string[] cached displayNames - key is the UID and value the displayname */
    protected $displayNames = [];

    /**
     * @param IFactory $languageFactory
     * @param IURLGenerator $url
     * @param IManager $activityManager
     * @param IUserManager $userManager
     * @param IEventMerger $eventMerger
     */
    public function __construct(IFactory $languageFactory, IURLGenerator $url, IManager $activityManager, IUserManager $userManager, IEventMerger $eventMerger)
    {
        $this->languageFactory = $languageFactory;
        $this->url = $url;
        $this->activityManager = $activityManager;
        $this->userManager = $userManager;
        $this->eventMerger = $eventMerger;
    }

    /**
     * @param string $language
     * @param IEvent $event
     * @param IEvent|null $previousEvent
     * @return IEvent
     * @throws \InvalidArgumentException
     * @since 11.0.0
     */
    public function parse($language, IEvent $event, IEvent $previousEvent = null)
    {
        if ($event->getApp() !== 'bags') {
            throw new \InvalidArgumentException();
        }
        if ($this->activityManager->isFormattingFilteredObject()) {
            try {
                return $this->parseShortVersion($event);
            } catch (\InvalidArgumentException $e) {
                // Ignore and simply use the long version...
            }
        }
        return $this->parseLongVersion($event, $previousEvent);
    }

    /**
     * @param IEvent $event
     * @return IEvent
     * @throws \InvalidArgumentException
     * @since 11.0.0
     */
    public function parseShortVersion(IEvent $event)
    {
        $subject = $this->l->t('Bag Created for {file}');
        $event->setIcon($this->url->getAbsoluteURL($this->url->imagePath('bagit', 'bagit-black.svg')));
        return $event;
    }

    /**
     * @param IEvent $event
     * @param IEvent|null $previousEvent
     * @return IEvent
     * @throws \InvalidArgumentException
     * @since 11.0.0
     */
    public function parseLongVersion(IEvent $event, IEvent $previousEvent = null)
    {
        $subject = $this->l->t('Bag Created for {file}');
        $event->setIcon($this->url->getAbsoluteURL($this->url->imagePath('bagit', 'bagit-black.svg')));
        $event = $this->eventMerger->mergeEvents('files', $event, $previousEvent);
        return $event;
    }

    /**
     * @param int $id
     * @param string $path
     * @return array
     */
    protected function generateFileParameter($id, $path)
    {
        return [
            'type' => 'file',
            'id' => $id,
            'name' => basename($path),
            'path' => $path,
            'link' => $this->url->linkToRouteAbsolute('files.viewcontroller.showFile', ['fileid' => $id]),
        ];
    }
}