<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?User $normalUser = null;
    private ?User $adminUser = null;
    private ?TaskRepository $taskRepository = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->normalUser = $userRepository->findOneBy(['email' => 'test@test.net']);
        $this->adminUser = $userRepository->findOneBy(['email' => 'admin@foobar.net']);
        $this->taskRepository = static::getContainer()->get(TaskRepository::class);
    }

    public function testTasksPage(): void
    {
        $this->client->loginUser($this->normalUser);
        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('a[href="/tasks/create"]', 'Tasks create link check');
    }

    public function testTasksPageNotLogged(): void
    {
        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('#username', 'Username input check');
    }

    public function testCreateTask(): void
    {
        $this->client->loginUser($this->normalUser);
        $this->client->request('GET', '/tasks/create');
        $this->client->submitForm('Ajouter', [
            'task[title]' => 'New task',
            'task[content]' => 'Task content'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }

    public function testEditTask(): void
    {
        $this->client->loginUser($this->normalUser);
        $taskId = $this->taskRepository->findOneBy(['author' => $this->normalUser])->getId();
        $this->client->request('GET', "/tasks/${taskId}/edit");
        $this->client->submitForm('Modifier', [
            'task[title]' => 'Task edit',
            'task[content]' => 'Task content edit'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }

    public function testToggleTask(): void
    {
        $this->client->loginUser($this->normalUser);
        $taskId = $this->taskRepository->findOneBy(['author' => $this->normalUser])->getId();
        $this->client->request('GET', "/tasks/${taskId}/toggle");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }

    public function testDeleteOwnedTask(): void
    {
        $this->client->loginUser($this->normalUser);
        $taskId = $this->taskRepository->findOneBy(['author' => $this->normalUser])->getId();
        $this->client->request('GET', "/tasks/${taskId}/delete");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }

    public function testDeleteNotOwnedTask(): void
    {
        $this->client->loginUser($this->normalUser);
        $taskId = $this->taskRepository->findOneBy(['author' => $this->adminUser])->getId();
        $this->client->request('GET', "/tasks/${taskId}/delete");
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteAnonymousTask(): void
    {
        $this->client->loginUser($this->normalUser);
        $taskId = $this->taskRepository->findOneBy(['author' => null])->getId();
        $this->client->request('GET', "/tasks/${taskId}/delete");
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteAnonymousTaskByAdmin(): void
    {
        $this->client->loginUser($this->adminUser);
        $taskId = $this->taskRepository->findOneBy(['author' => null])->getId();
        $this->client->request('GET', "/tasks/${taskId}/delete");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('div.alert-success', 'Success message check');
    }


}