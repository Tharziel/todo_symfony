<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer", name="app_mailer")
     */
    public function mailer(MailerInterface $mailer, Security $security, TaskRepository $task): Response
    {   
        $user = $security->getUser();
        $title = $task->getTitle();
        $content = $task->getContent();
        $username = $user->getUsername();
        $userMail = $user->getUserIdentifier();
        $email = (new TemplatedEmail())
    ->from('antoinerobert@example.com')
    ->to('antoinerobert43@example.com')
    ->subject('Commande de machin envoyé !')
    //->text('Nous vous avons envoyé vos machin aujourd\'hui ! Ils devrait arriver demain ! Merci !')

    // path of the Twig template to render
    ->htmlTemplate('mailer/index.html.twig')

    // pass variables (name => value) to the template
    ->context([
        'username' => $username,
        'userEmail' => $userMail,
        'title' => $title,
        'content' => $content
    ])
;

        $mailer->send($email);

        return$this->redirectToRoute('homepage');

        
    }
}

