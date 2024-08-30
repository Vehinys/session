<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Form\SessionType;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    // Le chemin est '/session' et le nom de la route est 'session'
    #[Route('/session', name: 'session')]
    
    public function index(
        
        SessionRepository $repository
        
    ): Response{
        // Récupération de toutes les sessions depuis le repository
        $sessions = $repository->findAll();

        // On passe les sessions récupérées à la vue via le tableau associatif 'sessions'
        return $this->render('/pages/session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    #[Route('/session/new', name: 'session.new', methods: ['GET', 'POST'])]

    public function newSession(
        
        Request $request,
        EntityManagerInterface $entityManager
        
    ): Response {

        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session');
        }   

        return $this->render('/pages/session/new.html.twig', [
            'form' => $form,
            'sessionId'=> $session->getId()
        ]);
    }

    #[Route('/session/edition/{id}', name: 'session.edit', methods: ['GET', 'POST'])]
    public function editSession(
        
        int $id, 
        SessionRepository $repository,  
        Request $request, 
        EntityManagerInterface $manager
        
        ): Response {
        $session = $repository->find($id);

        if (!$session) {
            throw $this->createNotFoundException('Session non trouvé');
        }

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        // dd($session);
        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();

            $manager->persist($session);
            $manager->flush();

            $this->addFlash(
                'success',
                'La modification à été faite avec succès de '
            );
            return $this->redirectToRoute('show_session', ['id' => $session->getId()]);

        }
        return $this->render('pages/session/edit.html.twig', [
            'form' => $form->createView(),
            'sessionId'=> $session->getId()
        ]);
    }
  

    // Route pour afficher les détails d'une session spécifique identifiée par son 'id'
    #[Route('/session/{id}', name: 'show_session')]
    public function showSession(
        
        SessionRepository $repository, 
        ?Session $session = null,
        
        ): Response {

            if (!$session instanceof Session) {
                throw $this->createNotFoundException('La session demandée n\'existe pas.');
            }
            
            $programmes = $session->getProgrammes();
            $traineesNotInSession = $session->getTrainees();

      
            
            if (!empty($programmes)) {
                // On garde la session inchangée et on récupère les programmes associés
                $programmes = $repository->findProgramsBySession($session);
            }

            $traineesNotInSession = $repository->listTraineesNotInSession($session);
            $nombreDePlacesReservees = count($session->getTrainees());


        // On passe la session récupérée à la vue via le tableau associatif 'session'
        return $this->render('/pages/session/show.html.twig', [
            'session' => $session,
            'trainees' => $traineesNotInSession,
            'nombreDePlacesReservees' => $nombreDePlacesReservees
        ]);
    }

    // Route pour supprimer une session spécifique identifiée par son 'id'
    #[Route('/session/unsubscribe/{session}/{trainee}', name: 'session.unsubscribe', methods: ['GET', 'POST'])]
    public function unsubscribeTraineeInSession(
        
        Session $session,
        Trainee $trainee,
        EntityManagerInterface $manager

        ): Response {

            $session->removeTrainee($trainee);
            $trainee->removeSession($session);

            $manager->persist($trainee);
            $manager->persist($session);
            $manager->flush();
    
        // Redirection vers la route 'session'
        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }


    // Route pour supprimer une session spécifique identifiée par son 'id'
    #[Route('/session/subscribe/{session}/{trainee}', name: 'session.subscribe', methods: ['GET', 'POST'])]
    public function subscribeTraineeInSession(
        
        Session $session,
        Trainee $trainee,
        EntityManagerInterface $manager

        ): Response {

            $session->addTrainee($trainee);
            $trainee->addSession($session);

            $manager->persist($trainee);
            $manager->persist($session);
            $manager->flush();
    
        // Redirection vers la route 'session'
        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }


    // Route pour supprimer une session spécifique identifiée par son 'id'
    #[Route('/session/suppression/{id}', name: 'session.delete', methods: ['GET', 'POST'])]

    public function deleteSession(
        
        int $id, 
        SessionRepository $repository, 
        EntityManagerInterface $manager,
        
        ): Response {
    
        // Recherche de la session avec l'ID fourni
        $session = $repository->find($id);
    
        // Vérification si la session existe
        if ($session) {
            // Si la session est trouvée, suppression
            $manager->remove($session);
            $manager->flush();
    
            $this->addFlash(
                'success',
                'Suppression avec succès de la session : ' . $session->getName()
            );
        } else {
            $this->addFlash(
                'warning',
                'Echec lors de la suppression de la session.'
            );
        }
    
        // Redirection vers la route 'session'
        return $this->redirectToRoute('session');
    }

}