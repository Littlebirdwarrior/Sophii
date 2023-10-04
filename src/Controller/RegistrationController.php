<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        //creation nouvel utilisateur
        $user = New User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        //explique les prérequis à la validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $user->getEmail();
            // Verifie si l'utilisateur est déjà en database
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            // Si l'email existe deja, envois un message
            if($existingUser) {
                $errorMessage = 'Votre email a déjà été enregisté';
                $this->addFlash('verify_email_error' , $errorMessage);
                return $this->redirectToRoute('app_register');
            } else {
                // fonction qui hash le passwprd
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                //l'envois en pase de donnée
                $entityManager->persist($user);
                $entityManager->flush();
            }

            // envois un mail à l'user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('admin@admin.com', 'Admin'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            //redirige sur la home après connexion
            return $this->redirectToRoute('app_home');
        }

        //renvois au password de connexion
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    //verifier l'email
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // envoyer un email de confirmation
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre email a été vérifié.');

        return $this->redirectToRoute('app_register');
    }
}
