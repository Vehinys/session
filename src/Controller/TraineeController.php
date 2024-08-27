<?php

namespace App\Controller;

use App\Entity\Trainee;
use App\Form\TraineeType;
use App\Repository\TraineeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraineeController extends AbstractController
{
    // Route pour afficher la liste des stagiaires
    #[Route('/trainee', name: 'trainee')]
    
    public function index(
        
        TraineeRepository $repository
        
    ): Response {

        // Récupération de tous les stagiaires à partir du repository
        $trainees = $repository->findAll();

        // Rendu du template Twig en passant la liste des stagiaires
        return $this->render('/pages/trainee/index.html.twig', [
            'trainees' => $trainees,
        ]);
    }

    #[Route('/trainee/new', name: 'trainee.new', methods: ['GET', 'POST'])]
    public function new(
        
        Request $request,
        EntityManagerInterface $entityManager
        
        ): Response {

            $trainee = new Trainee();

            $form = $this->createForm(TraineeType::class, $trainee);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $trainee = $form->getData();
                $entityManager->persist($trainee);
                $entityManager->flush();

                return $this->redirectToRoute('trainee');
            }   

        return $this->render('/pages/trainee/new.html.twig', [
                'formAddTrainee' => $form,
        ]);
    }

    #[Route('/trainee/edition/{id}', name: 'trainee.edit', methods: ['GET', 'POST'])]
    public function edit(
        
        int $id, 
        TraineeRepository $repository,  
        Request $request, 
        EntityManagerInterface $manager
        
        ): Response {
        $trainee = $repository->find($id);
        if (!$trainee) {
            throw $this->createNotFoundException('Stagiaire non trouvé');
        }

        $form = $this->createForm(traineeType::class, $trainee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trainee = $form->getData();

            $manager->persist($trainee);

            $manager->flush();

            $this->addFlash(
                'success',
                'La modification à été faite avec succès de ' . $trainee->getName() . ' ' . $trainee->getFirstName()
            );
            return $this->redirectToRoute('trainee');
        }
        return $this->render('pages/trainee/edit.html.twig', [
            'formAddTrainee' => $form->createView(),
        ]);
    }

    // Route pour afficher les détails d'une session spécifique identifiée par son 'id'
    #[Route('/trainee/{id}', name: 'show_trainee')]
    public function show(
        
        TraineeRepository $repository, 
        ?Trainee $trainee,
        
        ): Response {

        // j'utilise ici une méthode personnalisée 'findProgramsBySession' qui récupère la session et ses relations (programmes)
        $trainee = $repository->findSessionsByTrainee($trainee);

        // Vérification si la session a bien été trouvée
        if (!$trainee) {
            throw $this->createNotFoundException('Le stagiaire demandée n\'existe pas.');
        }

        // On passe la session récupérée à la vue via le tableau associatif 'session'
        return $this->render('/pages/trainee/show.html.twig', [
            'trainee' => $trainee
        ]);
    }


    #[Route('/trainee/suppression/{id}', name: 'trainee.delete', methods: ['GET', 'POST'])]
    public function delete(
        
        int $id, 
        TraineeRepository $repository, 
        EntityManagerInterface $manager,
        
        ): Response {
    
        // Recherche du trainee avec l'ID fourni
        $trainee = $repository->find($id);
    
        // Vérification si le trainee existe
        if ($trainee) {
            // Si le trainee est trouvé, suppression
            $manager->remove($trainee);
            $manager->flush();

            $this->addFlash(
                'success',
                'La suppression du stagiaire à été faite avec succès  : ' . $trainee->getName()
                
            );
        } else {
            $this->addFlash(
                'warning',
                'Echec lors de la suppression du stagiaire.'
            );
        }
    
        // Redirection vers la route 'trainee'
        return $this->redirectToRoute('trainee');
    }
}
