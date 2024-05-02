<?php

namespace App\Controller;

use App\Entity\Commande;
use DateTime;
use App\Entity\Livraison;
use App\Entity\Repas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    #[Route('/commandesetlivraison', name: 'commandesetlivraison', methods: ['POST'])]
    public function create(Request $request,EntityManagerInterface $entityManager): Response
    {         
      $user = $this->getUser();
        $commande = new Commande();
        $commande->setUser($user); // Set the user ID
        $commande->setPrix(50); //$repas->getPrix()
        $commande->setEtat("En cours");
        $commande->setIdRepas(5);   //$repas->getId()
        $entityManager->persist($commande);
        $entityManager->flush();

        $livraison = new Livraison();
       

        $livraison->setUser($user); // Set the user ID
        $livraison->setIdCommande($commande->getId());
        $livraison->setAdresse($request->request->get('adresse'));
      

        $livraison->setDate(new DateTime());
        $livraison->setNumTelLivreur(4856);

        $entityManager->persist($livraison);
        $entityManager->flush();

      //  return new Response('Livraison created!', Response::HTTP_CREATED);

        return $this->redirectToRoute('app_home');
    
}
    
}
