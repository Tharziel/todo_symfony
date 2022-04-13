<?php

namespace App\Controller;

use Exception;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    /**
     * @Route("/cat", name="homecategory")
     */
    public function list(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/show/{id}", name="showcategory")
     */
    public function show(CategoryRepository $repo, $id): Response
    {
        $category = $repo->findOneBy(['id' => $id]);
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

        /**
     * @Route("/new", name="newcategory")
     */
    public function new(CategoryRepository $repo, EntityManagerInterface $em, Request $request): Response
    {   
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $category->setName($form->getData()->getName());
           
            $em->persist($category);
            try{
                $em->flush();
                return $this->redirectToRoute('homecategory');
            }catch(Exception $e){
                return $this->redirectToRoute('newcategory');
            }

        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="editcategory")
     */
    public function edit(Category $category, EntityManagerInterface $em, Request $request, $id): Response
    {
       
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
 
            $em->flush();
            return $this->redirectToRoute('homecategory', ['id' => $id]);
         

        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="deletecategory")
     */
    public function delete(Category $category, EntityManagerInterface $em, Request $request, $id): Response
    {
       
            $em->remove($category);
            $em->flush();

            return $this->redirectToRoute('homecategory');
    }
}
