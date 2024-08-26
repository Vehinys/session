<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Entity\Session;
use App\Form\SessionType;
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
    public function new(
        
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
                'formAddSession' => $form,
            ]);
        }

    // Route pour afficher les détails d'une session spécifique identifiée par son 'id'
    #[Route('/session/{id}', name: 'show_session')]
    public function show(
        
        SessionRepository $repository, 
        ?Session $session = null,
        
        ): Response {

            // if (!$session instanceof Session) {
            //     throw $this->createNotFoundException('La session demandée n\'existe pas.');
            // }
            
            $programmes = $session->getProgrammes();
            
            if (!empty($programmes)) {
                // On garde la session inchangée et on récupère les programmes associés
                $programmes = $repository->findProgramsBySession($session);
            }

        // On passe la session récupérée à la vue via le tableau associatif 'session'
        return $this->render('/pages/session/show.html.twig', [
            'session' => $session
        ]);
    }

    // Route pour supprimer une session spécifique identifiée par son 'id'
    #[Route('/session/suppression/{id}', name: 'session.delete', methods: ['GET', 'POST'])]
    public function delete(
        
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

