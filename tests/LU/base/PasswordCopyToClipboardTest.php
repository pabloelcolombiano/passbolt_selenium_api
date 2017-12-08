<?php
use Facebook\WebDriver\WebDriverKeys;

/**
 * Feature :  As a user I can copy my password info to clipboard
 *
 * Scenarios :
 * As a user I can see the list of copy options when clicking right on a password
 * As a user I can copy my password to clipboard with a right click
 * As a user I can copy a password to clipboard using a right click, and by pressing enter in the master key dialog.
 * As a user I can copy the URI of one resource to clipboard with a right click
 * As a user I can copy the username of one resource to clipboard with a right click
 *
 * @TODO Missing scenarios
 * As a user I can copy my password to clipboard using the action bar button
 *
 * @TODO more MASTER KEY TESTS
 * As a user I can cancel and close the passphrase dialog
 * As a user I should see errors when entering the wrong master key
 *
 * @TODO Move somewhere else
 * As a user I can open the url of a resource in a new tab
 *
 * @copyright (c) 2017 Passbolt SARL
 * @licence   GNU Affero General Public License http://www.gnu.org/licenses/agpl-3.0.en.html
 */
class PasswordCopyToClipboardTest extends PassboltTestCase
{

    /**
     * @group saucelabs
     * Scenario: As a user I can copy a password using the button in the action bar
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I click a password
     * When I click on the copy button in the action bar
     * Then  I can see the master key dialog
     * When I enter my passphrase and click submit
     * Then  I can see a success message saying the password was 'copied to clipboard'
     * And      The content of the clipboard is valid
     */
    function testCopyPasswordButton() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged in on the password workspace
        $this->loginAs($user);

        // When I click on the first password in the list
        $this->clickPassword($resource['id']);

        // When I click on the link 'copy password'
        $this->click('js_wk_menu_secretcopy_button');

        // Then  I can see the master key dialog
        $this->assertMasterPasswordDialog($user);

        // When I enter my passphrase and click submit
        $this->enterMasterPassword($user['MasterPassword']);

        // Then  I can see a success message telling me the password was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // And the content of the clipboard is valid
        $this->assertClipboard($resource['password']);
    }

    /**
     * Scenario: As a user I can see the list of copy options when clicking right on a password
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I right click on the first password in the list
     * Then  I can see the contextual menu
     * And I can see the first option is 'Copy username' and is enabled
     * And I can see next option is 'Copy password' and is enabled
     * And I can see next option is 'Copy URI' and is enabled
     */
    function testCopyContextualMenuView() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged in on the password workspace
        $this->loginAs($user);

        // When I right click on the first password in the list
        $this->rightClickPassword($resource['id']);

        // Then  I can see the contextual menu
        $e = $this->findById('js_contextual_menu');

        // And I can see the first option is 'Copy username' and is enabled
        $this->assertElementContainsText($e, 'Copy username');

        // And I can see next option is 'Copy password' and is enabled
        $this->assertElementContainsText($e, 'Copy password');

        // And I can see next option is 'Copy URI' and is enabled
        $this->assertElementContainsText($e, 'Copy URI');
    }

    /**
     * Scenario: As a user I can copy a password to clipboard using a right click
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I select the first password in the list
     * And I right click
     * Then  I can see the contextual menu
     * When I click on the link 'copy password'
     * Then  I can see the master key dialog
     * When I enter my passphrase and click submit
     * Then  I can see a success message saying the password was 'copied to clipboard'
     * And      The content of the clipboard is valid
     */
    public function testCopyPasswordToClipboardViaContextualMenu() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged on the password workspace
        $this->loginAs($user);

        // When I select the first password in the list
        $this->click('multiple_select_checkbox_' . $resource['id']);

        // And I right click
        $this->rightClickPassword($resource['id']);

        // Then  I can see the contextual menu
        $this->assertVisible('js_contextual_menu');

        // When I click on the link 'copy password'
        $this->click('#js_password_browser_menu_copy_password a');

        // Then  I can see the master key dialog
        $this->assertMasterPasswordDialog($user);

        // When I enter my passphrase and click submit
        $this->enterMasterPassword($user['MasterPassword']);

        // Then  I can see a success message telling me the password was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // And the content of the clipboard is valid
        $this->assertClipboard($resource['password']);
    }

    /**
     * Scenario: As a user I can copy a password to clipboard using a right click, and by pressing enter in the master key dialog.
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I select the first password in the list
     * And I right click
     * Then  I can see the contextual menu
     * When I click on the link 'copy password'
     * Then  I can see the master key dialog
     * When I enter my passphrase and press enter
     * Then  I can see a success message saying the password was 'copied to clipboard'
     * And      The content of the clipboard is valid
     */
    public function testCopyPasswordToClipboardViaContextualMenuAndEnterKey() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged on the password workspace
        $this->loginAs($user);

        // When I select the first password in the list
        $this->click('multiple_select_checkbox_' . $resource['id']);

        // And I right click
        $this->rightClickPassword($resource['id']);

        // Then  I can see the contextual menu
        $this->assertVisible('js_contextual_menu');

        // When I click on the link 'copy password'
        $this->click('#js_password_browser_menu_copy_password a');

        // Then  I can see the master key dialog
        $this->assertMasterPasswordDialog($user);

        // When I enter the master key.
        $this->goIntoMasterPasswordIframe();
        $this->inputText('js_master_password', $user['MasterPassword']);
        // And I press enter.
        $this->find('js_master_password')->sendKeys(WebDriverKeys::ENTER);
        $this->goOutOfIframe();

        // Then  I can see a success message telling me the password was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // And the content of the clipboard is valid
        $this->assertClipboard($resource['password']);
    }

    /**
     * Scenario: As a user I can copy the URI of one resource to clipboard with a right click
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I right click on the first password in the list
     * And I click on the 'Copy URI' in the contextual menu
     * Then  I can see a success message saying the URI was copied to clipboard
     * And      The content of the clipboard is valid
     */
    function testCopyURIToClipboardViaContextualMenu() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged in on the password workspace
        $this->loginAs($user);

        // When I right click on the first password in the list
        $this->rightClickPassword($resource['id']);

        // When I click on the 'Copy URI' in the contextual menu
        $this->click('#js_password_browser_menu_copy_uri a');

        // Then  I can see a success message saying the uri was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // And the content of the clipboard is valid
        $this->assertClipboard($resource['uri']);
    }

    /**
     * Scenario: As a user I can copy the username of one resource to clipboard with a right click
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I right click on the first password in the list
     * And I click on the 'Copy username' in the contextual menu
     * Then  I can see a success message saying the username was copied to clipboard
     * And      The content of the clipboard is valid
     */
    function testCopyUsernameToClipboardViaContextualMenu() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged in on the password workspace
        $this->loginAs($user);

        // When I right click on the first password in the list
        $this->rightClickPassword($resource['id']);

        // When I click on the link 'copy URI' in the contextual menu
        $this->click('#js_password_browser_menu_copy_username a');

        // Then  I can see a success message saying the username was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // And the content of the clipboard is valid
        $this->assertClipboard($resource['username']);
    }

    /**
     * Scenario: As a user I can copy my password to clipboard by clicking on the password preview in the table view
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I click on a password link of the first row of the table view
     * And I enter my passphrase
     * Then     the password is copied to clipboard
     */
    public function testCopyPasswordToClipboardViaGridSecretCopy() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged in on the password workspace
        $this->loginAs($user);

        // When I click on a password link of the first row of the table view
        $this->click('grid_secret_copy_' . $resource['id']);

        // And I enter my passphrase
        $this->enterMasterPassword($user['MasterPassword']);

        // Then  I can see a success message saying the username was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // Then the password is copied to clipboard
        $this->assertClipboard($resource['password']);

    }

    /**
     * Scenario: As a user I can copy my password to clipboard by clicking on the password preview in the sidebar
     *
     * Given I am Ada
     * And I am logged in on the password workspace
     * When I click on the resource row in the grid
     * And I click on a the copy secret password link in the sidebar
     * And I enter my passphrase
     * Then     the password is copied to clipboard
     */
    public function testCopyPasswordToClipboardViaSidebarSecretCopy() 
    {
        // Given I am Ada
        $user = User::get('ada');
        $resource = Resource::get(array('user' => 'ada'));


        // And I am logged in on the password workspace
        $this->loginAs($user);

        // When I click on the resource row in the grid
        $this->clickPassword($resource['id']);

        // And I click on a the copy secret password link in the sidebar
        $this->click('sidebar_secret_copy_' . $resource['id']);

        // And I enter my passphrase
        $this->enterMasterPassword($user['MasterPassword']);

        // Then  I can see a success message saying the username was copied to clipboard
        $this->assertNotification('plugin_clipboard_copy_success');

        // Then the password is copied to clipboard
        $this->assertClipboard($resource['password']);

    }
}