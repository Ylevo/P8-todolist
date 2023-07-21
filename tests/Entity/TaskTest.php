<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private ?Task $testTask = null;

    public function setUp(): void
    {
        $this->testTask = new Task();
    }

    public function testId()
    {
        $this->assertNull($this->testTask->getId());
    }

    public function testCreatedAt()
    {
        $date = new \DateTimeImmutable();
        $this->testTask->setCreatedAt($date);
        $this->assertSame($date, $this->testTask->getCreatedAt());
    }

    public function testTitle()
    {
        $this->testTask->setTitle("Test title");
        $this->assertSame("Test title", $this->testTask->getTitle());
    }

    public function testContent()
    {
        $this->testTask->setContent("Test content");
        $this->assertSame("Test content", $this->testTask->getContent());
    }

    public function testIsDone()
    {
        $this->assertFalse($this->testTask->isDone());
        $this->testTask->toggle(true);
        $this->assertTrue($this->testTask->isDone());
    }

    public function testAuthor()
    {
        $testUser = new User();
        $this->testTask->setAuthor($testUser);
        $this->assertSame($testUser, $this->testTask->getAuthor());
    }
}