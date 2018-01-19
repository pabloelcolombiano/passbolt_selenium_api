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
/**
 * Feature: As a user I can create passwords
 *
 * Scenarios :
 * As a logged in user I can view the create password dialog
 * As a logged in user I can open close the password dialog
 * As a logged in user I can see error messages when creating a password with wrong inputs
 * As a logged in user I can view a password I just created on my list of passwords
 * As a logged in user I can view a password I just created by using keyboard shortcuts only
 * As a logged in user I can go to next / previous field in the create password form by using the keyboard tabs
 * As a logged in user I can generate a random password automatically
 * As a logged in user I can view the password I am creating in clear text
 * As a logged in user I receive an email notification when I create a new password
 * As a logged in user I can use passbolt on multiple windows and create password
 * As a logged in user I should be able to create a password after I restart the browser
 */
namespace Tests\LU\Base;

use App\Actions\PasswordActionsTrait;
use App\Assertions\PasswordAssertionsTrait;
use App\Assertions\WorkspaceAssertionsTrait;
use App\PassboltTestCase;
use Data\Fixtures\User;
use Data\Fixtures\SystemDefaults;

class PasswordCreateTest extends PassboltTestCase
{
    use WorkspaceAssertionsTrait;
    use PasswordAssertionsTrait;
    use PasswordActionsTrait;

    /**
     * Scenario: As a logged in user I can view the create password dialog
     *
     * Given I am Ada
     * And   I am logged in as Ada
     * And   I am on password workspace
     * Then  I see the create password button
     * When  I click on create button
     * Then  I see the create password dialog
     * And   I see the title is set to "create password"
     * And   I see the name input and label is marked as mandatory
     * And   I see the url text input and label
     * And   I see the username text input and label
     * And   I see the password iframe
     * And   I see the password label is marked as mandatory
     * When  I switch to the password iframe
     * And   I see the password input
     * And   I see the security token
     * And   I see the view password button
     * And   I see the generate password button
     * And   I see the complexity meter
     * And   I see the complexity textual indicator
     * When  I switch back out of the password iframe
     * And   I see the description textarea and label
     * And   I see the save button
     * And   I see the cancel button
     * And   I see the close dialog button
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     */
    public function testCreatePasswordDialogExist()
    {
        // Given I am Ada
        $user = User::get('ada');

        // I am logged in as Carol, and I go to the user workspace
        $this->loginAs($user);

        // Then I see the create password button
        $this->assertElementContainsText(
            $this->find('.main-action-wrapper'), 'create'
        );

        // When I click on create button
        $this->click('js_wsp_create_button');

        // Then I see the create password dialog
        $this->assertVisibleByCss('.create-password-dialog');

        // And I see the title is set to "create password"
        $this->assertElementContainsText(
            $this->findByCss('.dialog'), 'Create Password'
        );

        // And I see the name text input and label is marked as mandatory
        $this->assertVisibleByCss('.create-password-dialog input[type=text]#js_field_name.required');
        $this->assertVisibleByCss('.create-password-dialog label[for=js_field_name]');

        // And I see the url text input and label
        $this->assertVisibleByCss('.create-password-dialog input[type=text]#js_field_uri');
        $this->assertVisibleByCss('.create-password-dialog label[for=js_field_uri]');

        // And I see the username field
        $this->assertVisibleByCss('.create-password-dialog input[type=text]#js_field_username');
        $this->assertVisibleByCss('.create-password-dialog label[for=js_field_username]');

        // And I see the password iframe
        $this->assertVisibleByCss('.create-password-dialog #passbolt-iframe-secret-edition');

        // And I see the password label is marked as mandatory
        $this->assertVisibleByCss('.create-password-dialog .js_form_secret_wrapper.required');

        // When I switch to the password iframe
        $this->goIntoSecretIframe();

        // And I see the input field
        $this->assertVisibleByCss('input[type=password]#js_secret');

        // And I see the security token
        $this->assertSecurityToken($user);

        // And I see the view password button
        $this->assertVisibleByCss('#js_secret_view.button');

        // And I see the generate password button
        $this->assertVisibleByCss('#js_secret_generate.button');

        // And I see the complexity meter
        // And I see the complexity textual indicator
        $this->assertComplexity('not available');

        // When I switch back out of the password iframe
        $this->goOutOfIframe();

        // And I see the description field
        $this->assertVisibleByCss('.create-password-dialog textarea#js_field_description');
        $this->assertVisibleByCss('.create-password-dialog label[for=js_field_description]');

        // And I see the save button
        $this->assertVisibleByCss('input[type=submit].button.primary');

        // And I see the cancel button
        $this->assertVisibleByCss('.create-password-dialog a.cancel');

        // And I see the close dialog button
        $this->assertVisibleByCss('.create-password-dialog a.dialog-close');
    }

    /**
     * Scenario: As a logged in user I can open close the create password dialog
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the password workspace
     * When  I click on the create password button
     * Then  I see the create password dialog
     * When  I click on the cancel button
     * Then  I should not see the create password dialog
     * When  I click on the create password button
     * Then  I see the create password dialog
     * When  I click on the close dialog button
     * Then  I should not see the create password dialog
     * When  I click on the create password button
     * Then  I see the create password dialog
     * When  I press the keyboard escape key
     * Then  I should not see the create password dialog
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     */
    public function testCreatePasswordDialogOpenClose() 
    {
        // Given that I am Ada
        $user = User::get('ada');

        // And I am logged in and on the password workspace
        $this->loginAs($user);

        // When I click on the create password button
        $this->click('js_wsp_create_button');

        // Then I see the create password dialog
        $this->assertVisibleByCss('.create-password-dialog');

        // When I click on the cancel button
        $this->findByCss('.create-password-dialog a.cancel')->click();

        // Then I should not see the create password dialog
        $this->assertNotVisibleByCss('.create-password-dialog');

        // -- WITH X BUTTON --
        // When I click on the create password button
        $this->click('js_wsp_create_button');

        // Then I see the create password dialog
        $this->assertVisibleByCss('.create-password-dialog');

        // When I click on the close dialog button
        $this->findByCss('.create-password-dialog a.dialog-close')->click();

        // Then I should not see the create password dialog
        $this->assertNotVisibleByCss('.create-password-dialog');

        // -- WITH ESCAPE --
        // When I click on the create password button
        $this->click('js_wsp_create_button');

        // Then I see the create password dialog
        $this->assertVisibleByCss('.create-password-dialog');

        // When I click on the escape key
        $this->pressEscape();

        // Then I should not see the create password dialog
        $this->assertTrue($this->isNotVisible('.create-password-dialog'));
    }

    /**
     * Scenario: As a user I can see error messages when creating a password with wrong inputs
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the create password dialog
     * When  I press the enter key on the keyboard
     * Then  I see an error message saying that the name is required
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     */
    public function testCreatePasswordErrorMessages() 
    {
        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // When I click on the name input field
        $this->click('js_field_name');

        // And I press enter
        $this->pressEnter();

        // Then I see an error message saying that the name is required
        $this->assertVisibleByCss('#js_field_name_feedback.error.message');
        $this->assertElementContainsText(
            $this->find('js_field_name_feedback'), 'is required'
        );

        // And I see an error message saying that the password should not be empty
        $this->goIntoSecretIframe();
        $this->assertVisibleByCss('#js_field_password_feedback.error.message');
        $this->assertElementContainsText(
            $this->find('js_field_password_feedback'), 'This information is required'
        );
        $this->goOutOfIframe();

        // I should not see an error message for username.
        $this->assertNotVisibleByCss('#js_field_username_feedback.error.message');
    }

    /**
     * Scenario: As a user I can view a password I just created on my list of passwords
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the create password dialog
     * When  I enter 'localhost ftp' as the name
     * And   I enter 'test' as the username
     * And   I enter 'ftp://passbolt.com' as the uri
     * And   I enter 'localhost ftp test account' as the description
     * And   I enter 'ftp-password-test' as password
     * And   I click on the save button
     * Then  I see a dialog telling me encryption is in progress
     * And   I see a notice message that the operation was a success
     * And   I see the password I created in my password list
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     * @group saucelabs
     */
    public function testCreatePasswordAndView() 
    {
        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // And I enter 'localhost ftp' as the name
        $this->inputText('js_field_name', 'localhost ftp');

        // And I enter 'test' as the username
        $this->inputText('js_field_username', 'test');

        // And I enter 'ftp://localhost' as the uri
        $this->inputText('js_field_uri', 'ftp://passbolt.com');

        // I enter 'ftp-password-test' as password
        $this->inputSecret('ftp-password-test');

        // And I enter 'localhost ftp test account' as the description
        $this->inputText('js_field_description', 'localhost ftp test account');

        // When I click on the save button
        $this->click('.create-password-dialog input[type=submit]');

        // I see a notice message that the operation was a success
        $this->assertNotification('app_resources_add_success');

        // I see the password I created in my password list
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'ftp://passbolt.com'
        );
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'localhost ftp'
        );
    }

    /**
     * Scenario: As a user I can view a password I just created by using keyboard shortcuts only
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the create password dialog
     * Then  I can see that the field name has the focus
     * When  I enter 'localhost ftp' as the name
     * And   I press the tab key
     * Then  I should see that the field username has the focus
     * When  I enter 'test' as the username
     * And   I press the tab key
     * Then  I should see that the field uri has the focus
     * When  I enter 'ftp://passbolt.com' as the uri
     * And   I press the tab key
     * Then  I should see that the password field is selected
     * When  I enter 'ftp-password-test' as password
     * And   I press the tab key
     * Then  I should see that the field description is selected
     * When  I enter 'localhost ftp test account' as the description
     * And   I press enter
     * Then  I see a dialog telling me encryption is in progress
     * And   I see a notice message that the operation was a success
     * And   I see the password I created in my password list
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     */
    public function testCreatePasswordWithKeyboardShortcutsAndView() 
    {
        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // I should see that the field name has the focus.
        $this-> assertElementHasFocus('js_field_name');

        // Type localhost ftp without clicking on the field.
        $this->typeTextLikeAUser('localhost ftp');

        // Press tab key.
        $this->pressTab();

        // Then the field uri should have the focus.
        $this-> assertElementHasFocus('js_field_uri');

        // I type the uri.
        $this->typeTextLikeAUser('ftp://passbolt.com');

        // Press tab key.
        $this->pressTab();

        // Then the field username should have the focus.
        $this-> assertElementHasFocus('js_field_username');

        // I type the username.
        $this->typeTextLikeAUser('test');

        // Press tab key.
        $this->pressTab();

        // The field password should have the focus (inside the iframe).
        $this->goIntoSecretIframe();
        $this-> assertElementHasFocus('js_secret');

        // Type the password.
        $this->typeTextLikeAUser('ftp-password-test');

        // Press tab key.
        $this->pressTab();
        $this->goOutOfIframe();

        // Then the field description should have the focus.
        $this-> assertElementHasFocus('js_field_description');

        // Type description.
        $this->typeTextLikeAUser('localhost ftp test account');

        // Press tab key.
        $this->pressTab();

        // Press enter.
        $this->pressEnter();

        // I see a notice message that the operation was a success
        $this->assertNotification('app_resources_add_success');

        // I see the password I created in my password list
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'ftp://passbolt.com'
        );
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'localhost ftp'
        );
    }

    /**
     * Scenario: As a user I can go to next / previous field in the create password form by using the keyboard tabs
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the create password dialog
     * Then  I can see that the field name has the focus
     * When  I press the tab key
     * Then  I should see that the field username has the focus
     * When  I press the tab key
     * Then  I should see that the field uri has the focus
     * When  I press the tab key
     * Then  I should see that the password field has the focus
     * When  I press the tab key
     * Then  I should see that the field description has the focus
     * When  I press backtab key
     * Then  I should see that the password field has the focus
     * When  I press the backtab key
     * Then  I should see that the uri field has the focus
     * When  I press the backtab key
     * Then  I should see that the username field has the focus
     * When  I press the backtab key
     * Then  I should see that the name field has the focus.
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     */
    public function testCreatePasswordKeyboardShortcuts() 
    {
        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // I should see that the field name has the focus.
        $this->assertElementHasFocus('js_field_name');

        // Press tab key.
        $this->pressTab();

        // I should see that the field name has the focus.
        $this->assertElementHasFocus('js_field_uri');

        // Press tab key.
        $this->pressTab();

        // I should see that the field name has the focus.
        $this->assertElementHasFocus('js_field_username');

        // Press tab key.
        $this->pressTab();

        // The field password should have the focus (inside the iframe).
        $this->goIntoSecretIframe();
        $this->assertElementHasFocus('js_secret');

        // Press tab key.
        $this->pressTab();
        $this->goOutOfIframe();

        // Then the field description should have the focus.
        $this->assertElementHasFocus('js_field_description');

        // Press backtab.
        $this->pressBacktab();

        // The field password should have the focus (inside the iframe).
        $this->goIntoSecretIframe();
        $this->assertElementHasFocus('js_secret');

        // Press tab key.
        // TODO (PASSBOLT-1295) : fix the below part of the test.
        // Backtab doesn't seem to be done properly. Tab is received by the plugin, but shiftKey in the event
        // is set to false.
        //$this->pressBacktab();
        $this->goOutOfIframe();

        // I should see that the field name has the focus.
        // $this-> assertElementHasFocus('js_field_username');
        //
        // Press backtab key.
        // $this->pressBacktab();
        // I should see that the field name has the focus.
        // $this-> assertElementHasFocus('js_field_uri');
        // Press backtab key.
        // $this->pressBacktab();
        // I should see that the field name has the focus.
        // $this-> assertElementHasFocus('js_field_name');
    }

    /**
     * Scenario: As a user I can generate a random password automatically
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the create password dialog
     * When  I click the button to generate a new random password automatically
     * Then  I see the secret field populated
     * And   I see that the password complexity is set to fair
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     * @group saucelabs
     */
    public function testCreatePasswordGenerateButton() 
    {
        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // When I click the button to generate a new random password automatically
        $this->goIntoSecretIframe();
        $this->assertComplexity('not available');
        $this->click('js_secret_generate');

        // Then I see the secret field populated
        $s = $this->findById('js_secret')->getAttribute('value');
        $this->assertNotEmpty($s);

        // And I see that the password complexity is set to fair
        $this->assertTrue(strlen($s) == SystemDefaults::$AUTO_PASSWORD_LENGTH);
        $this->assertComplexity(SystemDefaults::$AUTO_PASSWORD_STRENGTH);
    }

    /**
     * Scenario: As a user I can view the password I am creating in clear text
     *
     * Given I am carol
     * And   I am logged in
     * And   I am on the create password dialog
     * When  I enter a password value
     * Then  I should not see the input field with the password in clear text
     * When  I click on the show password
     * Then  I see the input field with the password in clear text
     * When  I click on the show password
     * Then  I should not see the input field with the password in clear text
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     * @group saucelabs
     */
    public function testCreatePasswordViewButton() 
    {
        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // When I enter a password value
        $this->inputSecret('ftp-password-test');

        // Then I should not see the input field with the password in clear text
        $this->goIntoSecretIframe();
        $this->assertTrue($this->isNotVisible('#js_secret_clear'));

        // When I click on the view password
        $this->click('js_secret_view');

        // Then I see the input field with the password in clear text
        $this->assertNotVisibleByCss('#js_secret');
        $this->assertVisible('js_secret_clear');
        $this->assertTrue($this->findById('js_secret_clear')->getAttribute('value') == 'ftp-password-test');

        // When I click on the view password
        $this->click('js_secret_view');

        // Then I should not see the input field with the password in clear text
        $this->assertNotVisibleByCss('#js_secret_clear');
    }

    /**
     * Scenario: As a user I receive an email notification when I create a new password
     *
     * Given I am Ada
     * And   I am logged in
     * And   I am on the create password dialog
     * When  I enter 'localhost ftp' as the name
     * And   I enter 'test' as the username
     * And   I enter 'ftp://passbolt.com' as the uri
     * And   I enter 'localhost ftp test account' as the description
     * And   I enter 'ftp-password-test' as password
     * And   I click on the save button
     * Then  I see a dialog telling me encryption is in progress
     * And   I see a notice message that the operation was a success
     * And   I see the password I created in my password list
     * When  I access the last notification email sent
     * Then  I should see an email informing me that I have saved a new password
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     */
    public function testCreatePasswordEmailNotification() 
    {
        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        $user = User::get('ada');

        // And I am logged in
        $this->loginAs($user);

        // And I am on the create password dialog
        $this->gotoCreatePassword();

        // And I enter 'localhost ftp' as the name
        $this->inputText('js_field_name', 'localhost ftp');

        // And I enter 'test' as the username
        $this->inputText('js_field_username', 'test');

        // And I enter 'ftp://localhost' as the uri
        $this->inputText('js_field_uri', 'ftp://passbolt.com');

        // I enter 'ftp-password-test' as password
        $this->inputSecret('ftp-password-test');

        // And I enter 'localhost ftp test account' as the description
        $this->inputText('js_field_description', 'localhost ftp test account');

        // When I click on the save button
        $this->click('.create-password-dialog input[type=submit]');

        // I see a notice message that the operation was a success
        $this->assertNotification('app_resources_add_success');

        // Access last email sent to Betty.
        $this->getUrl('seleniumtests/showlastemail/' . $user['Username']);

        // The email title should be:
        $this->assertMetaTitleContains('You added the password localhost ftp');

        // I should see the resource name in the email.
        $this->assertElementContainsText('bodyTable', 'You have saved a new password');
        $this->assertElementContainsText('bodyTable', 'localhost ftp');
    }

    /**
     * Scenario: As LU I can use passbolt on multiple tabs and create password
     *
     * Given I am Ada
     * And   I am logged in
     * When  I open a new tab and go to passbolt url
     * And   I switch back to the first tab
     * And   I create a password
     * Then  I should see my newly created password
     * When  I switch to the second tab
     * And   I create a password
     * Then  I should see my newly created password
     * When  I refresh the second tab
     * Then  I should see the password I created on the first tab
     * When  I switch to the first tab and I refresh it
     * Then  I should see the password I created on the second tab
     *
     * @group LU
     * @group password
     * @group password-create
     * @group no-saucelabs
     * @group v2
     */
    public function testMultipleTabsCreatePassword() 
    {
        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // When I open a new tab, switch to it and go to passbolt url.
        $this->openNewTab('');

        // And I switch back to the first tab
        $this->switchToPreviousTab();

        // And I create a password
        $password = array(
            'name' => 'password_tab_1',
            'username' => 'password_tab_1',
            'password' => 'password_tab_1'
        );
        $this->createPassword($password);

        // Then I should see my newly created password
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'password_tab_1'
        );

        // When I switch to the second tab
        $this->switchToNextTab();

        // And I create a password
        $password = array(
            'name' => 'password_tab_2',
            'username' => 'password_tab_2',
            'password' => 'password_tab_2'
        );
        $this->createPassword($password);

        // Then I should see my newly created password
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'password_tab_2'
        );

        // When I refresh the second tab
        $this->driver->navigate()->refresh();
        $this->waitCompletion();

        // Then I should see the password I created on the first tab
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'password_tab_1'
        );

        // When I switch to the first tab and I refresh it
        $this->switchToPreviousTab();
        $this->driver->navigate()->refresh();
        $this->waitCompletion();

        // Then I should see the password I created on the second tab
        $this->assertElementContainsText(
            $this->find('js_wsp_pwd_browser'), 'password_tab_2'
        );
    }

    /**
     * Scenario: As LU I should be able to create a password after I restart the browser
     *
     * Given I am Ada
     * And   I am logged in on the passwords workspace
     * When  I restart the browser
     * Then  I should be able to create a password
     *
     * @group LU
     * @group password
     * @group password-create
     * @group no-saucelabs
     * @group skip
     */
    public function testRestartBrowserAndCreatePassword() 
    {
        $this->markTestSkipped();

        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        // And I am logged in
        $this->loginAs(User::get('ada'));

        // When restart the browser
        $this->restartBrowser();
        $this->waitCompletion();

        // Then I should be able to create a password
        $password = array(
            'name' => 'password_create_after_leaving_browser',
            'username' => 'password_create_after_leaving_browser',
            'password' => 'password_create_after_leaving_browser'
        );
        $this->createPassword($password);
    }

    /**
     * Scenario: As LU I should be able to create a password after I close and restore the passbolt tab
     *
     * Given I am Ada
     * And   I am on second tab
     * And   I am logged in on the passwords workspace
     * When  I close and restore the tab
     * Then  I should be able to create a password
     *
     * @group LU
     * @group password
     * @group password-create
     * @group v2
     * @group skip
     * PASSBOLT-2263 close and restore doesn't work with the latest chrome driver
     */
    public function testCloseRestoreTabAndCreatePassword() 
    {
        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        $user = User::get('ada');
        $this->setClientConfig($user);

        // And I am on second tab
        $this->openNewTab();

        // And I am logged in
        $this->loginAs($user, false);

        // When I close and restore the tab
        $this->closeAndRestoreTab();
        $this->waitCompletion();

        // Then I should be able to create a password
        $password = array(
            'name' => 'password_create_after_leaving_browser',
            'username' => 'password_create_after_leaving_browser',
            'password' => 'password_create_after_leaving_browser'
        );
        $this->createPassword($password);
    }

}