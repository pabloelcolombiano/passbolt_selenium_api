<?php
/**
 * Feature : Setup
 * As an anonymous user, I need to be able to see the setup page with an invitation to install the plugin.
 * As AN and freshly self registered user, I receive an email that invite me to setup passbolt.
 *
 * @copyright (c) 2017 Passbolt SARL
 * @licence GNU Affero General Public License http://www.gnu.org/licenses/agpl-3.0.en.html
 */
class SetupTest extends PassboltSetupTestCase {

	/**
	 * @group saucelabs
	 * Scenario:  As AN and freshly self registered user, I receive an email that invite me to setup passbolt.
	 */
	public function testCanSeeRegistrationEmail() {
		$this->resetDatabaseWhenComplete();
		// Register John Doe as a user.
		$this->getUrl('register');
		$this->inputText('ProfileFirstName','John');
		$this->inputText('ProfileLastName','Doe');
		$this->inputText('UserUsername','johndoe@passbolt.com');
		$this->click('#disclaimer');
		$this->pressEnter();
		$this->waitUntilUrlMatches('register' . DS . 'thankyou');
		// Get last email.
		$this->getUrl('seleniumTests/showLastEmail/' . urlencode('johndoe@passbolt.com'));
		// Assert the title of the email is "Welcome to passbolt, john!"
		$this->assertMetaTitleContains('Welcome to passbolt, John!');
		// Assert I can see the text "You just opened an account on passbolt"
		$this->assertPageContainsText('You just opened an account on passbolt at');
	}

	/**
	 * @group saucelabs
	 * Scenario:  I can see the setup page with instructions to install the plugin
	 * Given      I am an anonymous user with no plugin on the registration page
	 * And        I follow the registration process and click on submit
	 * And        I click on the link get started in the email I received
	 * Then       I should reach the setup page
	 * And        the url should look like /setup/install/5569df1d-7bec-4c0c-a09d-55e2c0a895dc/d45c0bf1e00fb8db60af1e8b5482f9f3
	 * And        I should see the text "Welcome to passbolt! Let's take 5 min to setup your system."
	 * And        I should see the text "An add-on is required to use passbolt."
	 * And        I should see that the second menu item on the left is deactivated
	 */
	public function testCanSeeSetupPage() {
		// Reset database at the end of test.
		$this->resetDatabaseWhenComplete();

		// Register John Doe as a user.
		$this->getUrl('register');
		$this->inputText('ProfileFirstName','John');
		$this->inputText('ProfileLastName','Doe');
		$this->inputText('UserUsername','johndoe@passbolt.com');
        $this->click('#disclaimer');
		$this->pressEnter();
		$this->waitUntilUrlMatches('register' . DS . 'thankyou');
		// Get last email.
		$this->getUrl('seleniumTests/showLastEmail/' . urlencode('johndoe@passbolt.com'));
		// Follow the link in the email.
		$this->followLink('get started');
		// Wait until I am sure that the page is loaded.
		$this->waitUntilISee('.plugin-check-wrapper', '/Plugin check/');
		// Assert that url matches or regular expression
		$this->assertUrlMatch('/\/setup\/install\/[a-z0-9\-]{36}\/[a-z0-9\-]{36}/');
		// Assert that title equals what it should.
		$this->assertTitleEquals('Welcome to passbolt! Let\'s take 5 min to setup your system.');
		// Assert that there is a warning message regarding plugin.
		$this->assertElementContainsText(
			$this->findByCss('.plugin-check-wrapper .plugin-check.error'),
			'An add-on is required to use passbolt.'
		);
	}

	/**
	 * Scenario :   I cannot see the setup page if user id and token are incorrect.
	 * Given        I try to access the setup page with wrong information in the url
	 * Then         I should reach an error page with text "Token not found"
	 */
	public function testCannotSeeSetupPageWithInvalidInformation() {
		// Access url with wrong user id and token.
		$this->getUrl('setup/install/5569df1d-7bec-4c0c-a09d-55e2c0a895dc/d45c0bf1e00fb8db60af1e8b5482f9f3');
		$this->assertPageContainsText('The authentication token is not valid');
	}
}