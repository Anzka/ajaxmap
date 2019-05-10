<?php

namespace DWenzel\Ajaxmap\Configuration;

use TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Interface SettingsInterface
 */
interface SettingsInterface
{
    /**
     * Key for icon registration
     */
    const ICON_NAME_KEY = 'name';
    const ICON_PROVIDER_CLASS_KEY = 'iconProviderClass';
    const ICON_OPTIONS_KEY = 'options';

    /**
     * icon identifiers
     */
    const ICON_IDENTIFIER_LOCATION_TYPE = 'ajaxmap-location-type';
    const ICON_IDENTIFIER_MAP = 'ajaxmap-map';
    const ICON_IDENTIFIER_PLACE = 'ajaxmap-place';
    const ICON_IDENTIFIER_PLACEGROUP = 'ajaxmap-place-group';
    const ICON_IDENTIFIER_REGION = 'ajaxmap-region';

    /**
     * Icons to register via API
     */
    const ICONS_TO_REGISTER = [
        self::ICON_IDENTIFIER_LOCATION_TYPE => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'map-marker'
            ]
        ],
        self::ICON_IDENTIFIER_MAP => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'map'
            ]
        ],
        self::ICON_IDENTIFIER_PLACE => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'map-pin'
            ]
        ],
        self::ICON_IDENTIFIER_PLACEGROUP => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'clone'
            ]
        ],
        self::ICON_IDENTIFIER_REGION => [
            self::ICON_PROVIDER_CLASS_KEY => FontawesomeIconProvider::class,
            self::ICON_OPTIONS_KEY => [
                self::ICON_NAME_KEY => 'square'

            ]
        ],

    ];
}