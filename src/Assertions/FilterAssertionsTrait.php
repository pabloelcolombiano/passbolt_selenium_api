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
namespace App\assertions;

use App\BaseTestTrait;

trait FilterAssertionsTrait
{
    /**
     * Assert that a filter is selected.
     *
     * @param $filterId
     */
    public function assertFilterIsSelected($filterId) 
    {
        $this->assertElementHasClass(
            $this->find("#$filterId .row"),
            'selected'
        );
    }

    /**
     * Assert that a filter is not selected.
     *
     * @param $filterId
     */
    public function assertFilterIsNotSelected($filterId) 
    {
        $this->assertElementHasNotClass(
            $this->find("#$filterId .row"),
            'selected'
        );
    }
}