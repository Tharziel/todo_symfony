<?php

namespace App\Controller;


use Exception;
use App\Entity\Task;
use App\Form\TaskType;
use App\Form\FilterType;
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
    public function home(TaskRepository $repo, Request $request): Response
    {

        $filter = $this->createForm(FilterType::class);
        $filter->handleRequest($request);
        $tasks = $repo ->findAll();

        if($filter->isSubmitted() && $filter->isValid()){
            $category = $filter['category']->getData();
            $order = ($filter['createdAt']->getData()? 'ASC' : 'DESC');
            $done = $filter['isDone']->getData();
            $tasks = $repo->filterTask($category, $done, $order);
           
        }



        
        return $this->render('default/home.html.twig', [
            'tasks' => $tasks,
            'filter'=> $filter->createView()
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
    public function new( EntityManagerInterface $em, Request $request): Response
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
                $this->addFlash('success', 'Tâche créée !');
                return $this->redirectToRoute('homepage');
            }catch(Exception $e){
                $this->addFlash('danger', 'Erreur lors de la création de la tâche !'); 
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
            try{
                $em->flush();
                $this->addFlash('success', 'Tâche modifié !');
                return $this->redirectToRoute('homepage', ['id' => $id]);
            }catch(Exception $e){
                $this->addFlash('danger', 'Erreur lors de la modification de la tâche !'); 
            }
            
         

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
            try{
            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'Tâche supprimée !');
            }catch(Exception $e){
            $this->addFlash('danger', 'Erreur lors de la suppression de la tâche !');
            }
            

            return $this->redirectToRoute('homepage');
    }
}
