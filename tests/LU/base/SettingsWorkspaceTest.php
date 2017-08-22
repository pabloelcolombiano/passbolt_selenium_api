
<?php
/**
 * Feature : Settings Workspace
 *
 * - As a user I should be able to search a user by keywords
 *
 * @copyright (c) 2017 Passbolt SARL
 * @licence GNU Affero General Public License http://www.gnu.org/licenses/agpl-3.0.en.html
 */
class SettingsWorkspaceTest extends PassboltTestCase
{

    /**
	 * @group saucelabs
     * Scenario :   As a user I should be able to search a password by keywords from the settings workspace
     * Given        I am logged in as Ada, and I go to the password workspace
     * When         I fill the "app search" field with "Betty"
     * And          I click "search"
     * Then         I should see the view filtered with my search
     * And          I should see the breadcrumb with the following:
     *                    | All items
     *                    | Search : shared resource
     */
    public function testSearchByKeywords()
    {
		$searchUser = 'Betty';
		$hiddenUsers = [
			'Betty Holbderton',
			'Carol Shaw',
			'Dame Steve Shirley',
			'Edith Clarke',
			'Frances Allen',
			'Grace Hopper',
			'Hedy Lamarr',
			'Irene Greif',
			'Jean Bartik',
			'Kathleen Antonelli',
			'Lynn Jolitz',
			'Marlyn Wescoff'
		];
		$breadcrumb = ['All users', 'Search : ' . $searchUser];

		// Given I am Ada
		$user = User::get('ada');
		$this->setClientConfig($user);

		// And I am logged in on the user workspace
		$this->loginAs($user);

		// Go to user workspace
		$this->gotoWorkspace('settings');

		// I fill the "app search" field with "Betty"
		$this->inputText('js_app_filter_keywords', $searchUser);
		$this->click("#js_app_filter_form button[value='search']");
        $this->waitUntilISee('#js_passbolt_people_workspace_controller');
		$this->waitCompletion();

		// I should see the view filtered with my search
		$userBrowser = $this->findByCss('#js_wsp_users_browser .tableview-content');
		$this->waitUntilISee($userBrowser, "/$searchUser/");
		for ($i=0; $i< count($hiddenUsers); $i++) {
			$this->assertElementNotContainText(
				$userBrowser,
				$hiddenUsers[$i]
			);
		}

		// I should see the breadcrumb with the following:
		// 	| All users
		//	| Search : User Test
		$this->assertBreadcrumb('users', $breadcrumb);
    }

}
