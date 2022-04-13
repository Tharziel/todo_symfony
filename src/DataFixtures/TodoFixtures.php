<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TodoFixtures extends Fixture implements DependentFixtureInterface
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
        $task->setCategory($this->getReference("cat" .$i));


        $manager->persist($task);
    }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
