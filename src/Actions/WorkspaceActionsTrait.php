<?php
/**
 * Passbolt ~ Open source password manager for teams
 * Copyright (c) Passbolt SARL (https://www.passbolt.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Passbolt SARL (https://www.passbolt.com)
 * @license   https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link      https://www.passbolt.com Passbolt(tm)
 * @since     2.0.0
 */
namespace App\actions;

trait WorkspaceActionsTrait
{

    use BaseTestTrait;

    /**
     * Goto workspace
     *
     * @param $name
     */
    public function gotoWorkspace($name) 
    {
        $linkCssSelector = '';
        switch ($name) {
        case 'settings':
            $this->click('#js_app_profile_dropdown');
            $this->clickLink('my profile');
            $this->waitUntilISee('.page.settings.profile');
            return;
                break;
        default:
            $linkCssSelector = '#js_app_nav_left_' . $name . '_wsp_link a';
            break;
        }
        $this->waitUntilISee($linkCssSelector);
        $this->click($linkCssSelector);
        $this->waitCompletion();
    }

}