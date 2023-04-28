<?php

namespace App\Controller;

use App\Entity\PersonaFisica;
use App\Entity\Ruolo;
use App\Entity\Utente;
use App\Enum\StatoWorkflow;
use App\Form\RegistrationFormType;
use App\Repository\PersonaFisicaRepository;
use App\Repository\RuoloRepository;
use App\Repository\UtenteRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             UserAuthenticatorInterface $userAuthenticator,
                             AppAuthenticator $authenticator,
                             UtenteRepository $utenti,
                             PersonaFisicaRepository $personeFisiche,
                             RuoloRepository $ruoli
        ): Response
    {

        $user = new Utente();
        $persona = new PersonaFisica();
        $form = $this->createForm(RegistrationFormType::class, [$user, $persona]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ruoloGuest = $ruoli->findBy(['codice' => 'ROLE_GUEST']);
            // dd($ruoloGuest);

            $persona->setNome($form->get('nome')->getData())
                ->setCognome($form->get('cognome')->getData())
                ->setCf($form->get('codiceFiscale')->getData())
                ->setDataNascita($form->get('dataNascita')->getData())
                ->setLuogoNascita($form->get('luogoNascita')->getData())
                ->setProvinciaNascita($form->get('provinciaNascita')->getData());

            $personeFisiche->save($persona, true);
            // dd($persona);

            $password = $userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData());

            $user
                ->setEmail($form->get('email')->getData())
                ->setPassword($password)
                ->setPasswordPrecedente($password)
                ->setTelefono($form->get('telefono')->getData())
                ->setStato(StatoWorkflow::IN_LAVORAZIONE->value)
                ->setRuolo($ruoloGuest[0])
                ->setPersonaFisica($persona)
            ;

            $utenti->save($user, true);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
