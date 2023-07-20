<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testHomepageAnonymous(): void
    {
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('#username', 'Username input check');
    }

    public function testHomepageUserLogged(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->client->loginUser($userRepository->findOneBy(['email' => 'test@test.net']));
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('a[href="/tasks/create"]', 'Tasks creation link check');
        $this->assertSelectorNotExists('a[href="/users"]', 'Users list link check');
    }

    public function testHomepageAdminLogged(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->client->loginUser($userRepository->findOneBy(['email' => 'admin@foobar.net']));
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('a[href="/users"]', 'Users list link check');
    }

}