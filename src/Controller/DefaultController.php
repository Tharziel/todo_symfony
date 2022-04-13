<?php

namespace App\Controller;


use Exception;
use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/show/{id}", name="showpage")
     */
    public function show(TaskRepository $repo, $id): Response
    {
        $task = $repo->findOneBy(['id' => $id]);
        return $this->render('default/show.html.twig', [
            'task' => $task
        ]);
    }

        /**
     * @Route("/new", name="newpage")
     */
    public function new(TaskRepository $repo, EntityManagerInterface $em, Request $request): Response
    {   
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $task->setTitle($form->getData()->getTitle());
            $task->setContent($form->getData()->getContent());
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->setDoneAt(new \DateTimeImmutable());
            $task->setIsDone(false);
            $em->persist($task);
            try{
                $em->flush();
                return $this->redirectToRoute('homepage');
            }catch(Exception $e){
                return $this->redirectToRoute('newpage');
            }

        }

        return $this->render('default/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="editpage")
     */
    public function edit(Task $task, EntityManagerInterface $em, Request $request, $id): Response
    {
       
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
 
            $em->flush();
            return $this->redirectToRoute('homepage', ['id' => $id]);
         

        }

        return $this->render('default/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="deletepage")
     */
    public function delete(Task $task, EntityManagerInterface $em, Request $request, $id): Response
    {
       
            $em->remove($task);
            $em->flush();

            return $this->redirectToRoute('homepage');
    }
}
