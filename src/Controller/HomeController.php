<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $fullName = $request->get('fullName');
            $email = $request->get('email');
            $message = $request->get('message');

            $this->sendEmail($mailer, $fullName, $email, $message);

            return $this->redirectToRoute("home");
        }
        return $this->render('home/contact.html.twig');
    }

    public function sendEmail($mailer, $FullName, $email, $message)
    {
        $email = (new Email())
            ->from($email)
            ->to('you@example.com')
            ->subject('Contact from Ms/Msr'. $FullName)
            ->text($message);

        $mailer->send($email);
    }
}
