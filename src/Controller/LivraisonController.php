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

use Dompdf\Dompdf;
use Dompdf\Options;


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








#[Route('/livraisons/pdf', name: 'app_livraison_pdf', methods: ['GET'])]
public function generatePdf(EntityManagerInterface $entityManager): Response
{
    // Fetch livraison information from the repository
    $livraisons = $entityManager
        ->getRepository(Livraison::class)
        ->findAll();

    // Render the livraisons into a PDF using a template
    $pdf = $this->renderView('livraison/livraison_pdf.html.twig', [
        'livraisons' => $livraisons,
    ]);

    // Create a new instance of Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Load HTML content into Dompdf
    $dompdf->loadHtml($pdf);

    // Set paper size and rendering options
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Stream the PDF response
    return new Response(
        $dompdf->output(),
        Response::HTTP_OK,
        [
            'Content-Type' => 'application/pdf',
        ]
    );
}
}
