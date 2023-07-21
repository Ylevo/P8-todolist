<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?User $normalUser = null;
    private ?User $adminUser = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->normalUser = $userRepository->findOneBy(['email' => 'test@test.net']);
        $this->adminUser = $userRepository->findOneBy(['email' => 'admin@foobar.net']);
    }

    public function testUsersListPage(): void
    {
        $this->client->loginUser($this->adminUser);
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $adminId = $this->adminUser->getId();
        $this->assertSelectorExists("a[href='/users/${adminId}/edit']", 'Users list link check');
    }

    public function testUsersListPageNotAllowed(): void
    {
        $this->client->loginUser($this->normalUser);
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testCreateNewUser(): void
    {
        $this->client->loginUser($this->adminUser);
        $this->client->request('GET', '/users/create');
        $this->client->submitForm('Ajouter', [
            'user[username]' => 'Username surely not used',
            'user[email]' => 'notusedemail@probably.com',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[roles]' => 'ROLE_USER'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }

    public function testEditUser(): void
    {
        $this->client->loginUser($this->adminUser);
        $normalUserId = $this->normalUser->getId();
        $this->client->request('GET', "/users/${normalUserId}/edit");
        $this->client->submitForm('Modifier', [
            'user[username]' => 'Username surely not used',
            'user[email]' => 'notusedemail@probably.com',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[roles]' => 'ROLE_USER'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }
}