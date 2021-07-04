<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/forget/password", name="forget_password")
     */
    public function forgetPassword(Request $request, MailerInterface $mailer, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $email = $request->get('email');
        if ($request->isMethod('POST') && $email) {

            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository(User::class)->findOneBy(['email' => $email]);
            $password = $this->randomPassword();
            $user->setPassword(
                $userPasswordHasher->hashPassword($user, $password)
            );

            $manager->flush();

            $email = (new Email())
                ->from('carcompany@gmail.com')
                ->to($email)
                ->subject('Reset Password!')
                ->text('Here is your password ' .$password. ' But later you can chang your password');

            $mailer->send($email);

            return $this->render('security/reset.html.twig');
        }
        return $this->render('security/forget_password.html.twig');
    }

    private function randomPassword(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
