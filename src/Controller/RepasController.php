<?php

namespace App\Controller;

use DateTime;
use App\Entity\Repas;
use App\Entity\Recette;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\InformationPersonnele;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RepasController extends AbstractController
{
    #[Route('/repas/{id}', name: 'app_repas')]
    public function details(int $id,EntityManagerInterface $entityManager): Response
    {
        $repas = $entityManager
        ->getRepository(Repas::class)
        ->findOneById($id);
        $recette =  $entityManager
        ->getRepository(Recette::class)
        ->findById($repas->getIdRecette());
        $informationPersonneles = $entityManager
        ->getRepository(InformationPersonnele::class)
        ->findOneByUser($this->getUser());
        return $this->render('repas/index.html.twig', [
            'controller_name' => 'RepasController',
            'repas' => $repas,
            'adresse'=> $informationPersonneles->getAdresse()
        ]);
    }
    #[Route('/commandesetlivraison/{id}', name: 'commandesetlivraison', methods: ['POST'])]
    public function create(int $id,Request $request,EntityManagerInterface $entityManager): Response
    {        
        $repas = $entityManager
        ->getRepository(Repas::class)
        ->findOneById($id);
        $recette =  $entityManager
        ->getRepository(Recette::class)
        ->findOneById($repas->getIdRecette());
//dd($recette);
      $user = $this->getUser();
        $commande = new Commande();
        $commande->setUser($user); // Set the user ID
        $commande->setPrix($recette->getPrix()); //$repas->getPrix()
        $commande->setEtat("En cours");
        $commande->setIdRepas($repas->getId());   //$repas->getId()
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

        return new Response('Livraison created!', Response::HTTP_CREATED);
    }
}
