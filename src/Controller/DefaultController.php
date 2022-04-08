<?php

namespace App\Controller;


use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(TaskRepository $repo): Response
    {
        $tasks = $repo->findAll();
        return $this->render('default/home.html.twig', [
            'tasks' => $tasks
        ]);
    }
}
