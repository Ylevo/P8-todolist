<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private ?User $testUser = null;

    public function setUp(): void
    {
        $this->testUser = new User();
    }

    public function testId()
    {
        $this->assertNull($this->testUser->getId());
    }

    public function testUsername()
    {
        $this->testUser->setUsername("Username");
        $this->assertSame("Username", $this->testUser->getUsername());
    }

    public function testPassword()
    {
        $this->testUser->setPassword('password');
        $this->assertSame('password', $this->testUser->getPassword());
    }

    public function testEmail()
    {
        $this->testUser->setEmail("test@test.net");
        $this->assertSame("test@test.net", $this->testUser->getEmail());
    }

    public function testRoles()
    {
        $this->assertSame(["ROLE_USER"], $this->testUser->getRoles());
    }

    public function testUserIdentifier()
    {
        $this->testUser->setEmail("test@test.net");
        $this->assertSame($this->testUser->getEmail(), $this->testUser->getUserIdentifier());
    }

    public function testTask()
    {
        $testTask = new Task();
        $this->testUser->addTask($testTask);
        $this->assertCount(1, $this->testUser->getTasks());
        $this->testUser->removeTask($testTask);
        $this->assertCount(0, $this->testUser->getTasks());
    }
}