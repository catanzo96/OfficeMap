<?php

namespace App\Controller;

use App\Entity\Model\UtenteModel;
use App\Entity\PersonaFisica;
use App\Enum\StatoWorkflow;
use App\Repository\PersonaFisicaRepository;
use App\Repository\RuoloRepository;
use App\Repository\UtenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestioneController extends AbstractController
{
    public function __construct(private readonly UtenteRepository $utenteRepository, private readonly RuoloRepository $ruoloRepository) {
    }
    #[Route('/gestione/utenti', name: 'app_gestione_utenti')]
    public function gestioneUtenti(): Response
    {
//        dd($personeFisiche->findAllWithInfo();
        return $this->render('gestione/gestione_utenti.html.twig', [
            'utenti' => $this->utenteRepository->findAll(),
        ]);
    }

    #[Route('/gestione/utenti/model', name: 'app_gestione_utenti_model', methods: 'GET')]
    public function modificaUtente(): Response
    {
//        dd(StatoWorkflow::cases());
        $listaUtenti = [];
        foreach ($this->utenteRepository->findAll() as $utente)
        {
            $listaUtenti[] = new UtenteModel($utente);
        }
        return $this->json($listaUtenti);
    }

    #[Route('/gestione/utenti/accettaGuest/{id}', name: 'app_gestione_utenti_accettaGuest')]
    public function accettaGuest(int $id): Response
    {
        // dd($id);
        $ruoloUser = $this->ruoloRepository->findBy(['codice' => 'ROLE_USER']);
        $user = $this->utenteRepository->find($id);
        // dd($ruoloUser);
        $user->setStato(StatoWorkflow::ATTIVO->value)
        ->setRuolo($ruoloUser[0]);
        $this->utenteRepository->save($user, true);

        return $this->redirect('/test');
    }
}