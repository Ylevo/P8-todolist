<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?User $normalUser = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->normalUser = $userRepository->findOneBy(['email' => 'test@test.net']);
    }

    public function testLoginPage(): void
    {
        $this->client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('#username', 'Username input check');
    }

    public function testLoginSuccess(): void
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            '_username' => 'Admin',
            '_password' => 'password'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('a[href="/tasks/create"]', 'Tasks creation link check');
    }

    public function testLoginFail(): void
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            '_username' => 'Admin',
            '_password' => 'wrongpassword'
        ]);
        $this->assertSelectorExists('div.alert-danger', "Error message check");
    }

    public function testLogout(): void
    {
        $this->client->loginUser($this->normalUser);
        $this->client->request('GET', '/logout');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('#username', 'Username input check');
    }

    public function testAlreadyLogged(): void
    {
        $this->client->loginUser($this->normalUser);
        $this->client->request('GET', '/login');
        $this->assertSelectorExists('a[href="/tasks/create"]', 'Tasks creation link check');
    }
}