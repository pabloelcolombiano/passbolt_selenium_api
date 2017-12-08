<?php
/**
 * Bug PASSBOLT-1040 - Regression test
 *
 * @copyright (c) 2017 Passbolt SARL
 * @licence   GNU Affero General Public License http://www.gnu.org/licenses/agpl-3.0.en.html
 */
class PASSBOLT1040 extends PassboltTestCase
{
    /**
     * Scenario: As a user editing my password encryption should not happen if do not edit the secret
     *
     * @throws Exception
     */
    public function testNoEncryptionOnResourceNameEdit() 
    {
        // Reset database at the end of test.
        $this->resetDatabaseWhenComplete();

        // Given I am Ada
        $user = User::get('ada');
        

        // And I am logged in on the password workspace
        $this->loginAs($user);

        // And I am editing the name, description, uri, username of a password I own
        $resource = Resource::get(
            array(
            'user' => 'ada',
            'permission' => 'owner'
            )
        );
        $r['id'] = $resource['id'];
        $r['description'] = 'this is a new description';
        $r['name'] = 'newname';
        $r['username'] = 'newusername';
        $r['uri'] = 'http://newuri.com';

        $this->gotoEditPassword($r['id']);
        $this->inputText('js_field_name', $r['name']);
        $this->inputText('js_field_username', $r['username']);
        $this->inputText('js_field_uri', $r['uri']);
        $this->inputText('js_field_description', $r['description']);

        // And I click the submit button
        $this->click('.edit-password-dialog input[type=submit]');

        // And I wait until I'm sure the progress dialog didn't appear
        try {
            $this->waitUntilISee('#passbolt-iframe-progress-dialog', null, 2);
            $this->assertFalse(true, 'I should not be here, that means the progress dialog appeared');
        } catch(Exception $e) {
            //
        }

        // Then I should see a success notification message saying the password is updated.
        $this->assertNotification('app_resources_edit_success');
    }
}