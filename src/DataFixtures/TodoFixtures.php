<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i < 11; $i++){
        $task = new Task();
        $task->setTitle("Tâche n°$i");
        $task->setContent("Faire le ménage $i fois");
        $task->setIsDone(0);
        $task->setCreatedAt(new \DatetimeImmutable());
        $task->setDoneAt(new \DatetimeImmutable());


        $manager->persist($task);
    }
        $manager->flush();
    }
}
