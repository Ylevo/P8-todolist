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
        UserFactory::createOne(
            [
                'email' => 'admin@foobar.net',
                'username' => 'Admin',
                'roles' => ["ROLE_ADMIN"]
            ]
        );

        UserFactory::createMany(3, ['roles' => ["ROLE_USER"]]);
        TaskFactory::createMany(10);
        TaskFactory::createMany(5, ['author' => null]);


        $manager->flush();
    }
}
