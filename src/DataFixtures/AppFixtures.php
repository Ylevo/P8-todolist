<?php

namespace App\DataFixtures;

use App\Factory\TaskFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createSequence([
            [
                'email' => 'admin@foobar.net',
                'username' => 'Admin',
                'roles' => ["ROLE_ADMIN"]
            ],
            [
                'email' => 'test@test.net',
                'username' => 'Test User'
            ]
        ]);

        UserFactory::createMany(3);
        TaskFactory::createMany(10);
        TaskFactory::createSequence([
            ['author' => UserFactory::find(['email' => 'test@test.net']), 'isDone' => false],
            ['author' => UserFactory::find(['email' => 'admin@foobar.net']), 'isDone' => false],
            ['author' => null, 'isDone' => false]
        ]);
        TaskFactory::createMany(5, ['author' => null]);


        $manager->flush();
    }
}
