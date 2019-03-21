<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\PersonnageJouable;
use App\Form\RegistrationFormType;
use App\Security\UtilisateurAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guardHandler, UtilisateurAuthenticator $authenticator): Response
    {
        $utilisateur= new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class,$utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Utilisateur */
            $user = $form->getData();

            // encode the plain password
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();

            $baseImage = new PersonnageJouable();
            $baseImage->setImage('1.png');
            $baseImage->setPersonnageDebloque(true);
            $entityManager->persist($baseImage);

            $user->addPersonnagejouable($baseImage);
            $user->setAvatar('1.png');
            $entityManager->persist($user);
            
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
