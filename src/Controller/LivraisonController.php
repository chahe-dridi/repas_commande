<?php

namespace App\Controller;

use DateTime;
use App\Entity\Livraison;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivraisonController extends AbstractController
{
    #[Route('/livraisons', name: 'app_commande')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $livraisons = $entityManager
        ->getRepository(Livraison::class)
        ->findAll();
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'LivraisonController',
            'livraisons'=> $livraisons
        ]);
    }


    #[Route('/livraisons', name: 'livraisons', methods: ['POST'])]
    public function create(Request $request,EntityManagerInterface $entityManager): Response
    { 

        $livraison = new Livraison();
        $user = $this->getUser();

        $livraison->setUser($user); // Set the user ID
        $livraison->setIdCommande(50);
        $livraison->setAdresse($request->request->get('adresse'));
      

        $livraison->setDate(new DateTime());
        $livraison->setNumTelLivreur(4856);

        $entityManager->persist($livraison);
        $entityManager->flush();

        return new Response('Livraison created!', Response::HTTP_CREATED);
    
}
}
