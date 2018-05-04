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
namespace App\Actions;

trait SidebarActionsTrait
{
    /**
     * Scroll the sidebar to bottom.
     */
    public function scrollSidebarToBottom() 
    {
        $this->scrollElementToBottom('js_pwd_details');
    }

    /**
     * Post a comment.
     *
     * This expects the comment form to be shown already.
     *
     * @param $comment
     */
    public function postCommentInSidebar($comment) 
    {
        // Make sure password field is visible again.
        $this->waitUntilISee('#js_rs_details_comments form#js_comment_add_form');

        // Scroll down in sidebar.
        $this->scrollSidebarToBottom();

        // Fill up a second comment.
        $this->inputText('js_field_comment_content', $comment);

        // Click on submit.
        $this->click('#js_rs_details_comments a.comment-submit');

        // Assert that notification is shown.
        $this->assertNotification('app_comments_addPost_success');

        // Assert that the comments loaded.
        $this->waitUntilISee('#js_rs_details_comments.ready');
    }

    /**
     * Click on a secondary sidebar section header.
     *
     * @param string $name The section name
     */
    public function clickSecondarySidebarSectionHeader($name)
    {
        $this->click(".panel.aside .$name .accordion-header");
    }

}