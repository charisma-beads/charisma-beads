<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   ShopTest\Controller\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace ShopTest\Controller\Post;

use ShopTest\Framework\TestCase;

class PostUnitTest extends TestCase
{
    public function testListActionOnlyAcceptsXmlHttpRequest()
    {
        $this->getAdminUser();

        $this->dispatch('/admin/shop/post/unit/list');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/admin/shop/post/unit');
    }

    public function testListActionAjaxRequest()
    {
        $this->getAdminUser();
        $this->setAjaxRequest();
        $this->dispatch('/admin/shop/post/unit/list');
        $this->assertResponseStatusCode(202);
    }
}