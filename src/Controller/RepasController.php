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
use SensioLabs\Security\SecurityChecker;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\User;


use Symfony\Component\Mailer\Mailer ;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class RepasController extends AbstractController
{
 
     

 


 


     





 
    #[Route('/repas/{id}', name: 'app_repas')]
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $repas = $entityManager
            ->getRepository(Repas::class)
            ->findOneById($id);
        
        if (!$repas) {
            throw $this->createNotFoundException('Meal not found');
        }
    
        $recetteId = $repas->getIdRecette();
        $recette =  $entityManager
            ->getRepository(Recette::class)
            ->find($recetteId);
        
        if (!$recette) {
            throw $this->createNotFoundException('Recipe not found');
        }
    
        $informationPersonneles = $entityManager
            ->getRepository(InformationPersonnele::class)
            ->findOneByUser($this->getUser());
    
        $mealName = $repas->getNom();
        $recipeName = $recette->getNom();
    
        $user = $this->getUser();
        $userEmail = $user->getEmail();

        $verificationCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $htmlContent = "
        <html>
        <head>
        <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }
        li {
            margin-bottom: 10px;
            font-size: 16px;
        }
        strong {
            font-weight: bold;
        }
        .thank-you {
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
        </head>
        <body>
            <div class='container'>
                <h2>Dear {$user->getEmail()},</h2>
                <p>Here are the details of your meal reservation:</p>
                <ul>
                    <li><strong>Meal Name:</strong> $mealName</li>
                    <li><strong>Recipe Name:</strong> $recipeName</li>
                    <!-- Include other meal and recipe details as needed -->
                </ul>
                <p class='thank-you'>Thank you for choosing us.</p>
                <p>Your verification code is: <strong>$verificationCode</strong></p>
                <p>Best regards,<br> Your Team</p>
            </div>
        </body>
        </html>
    ";
    
        $transport = Transport::fromDsn('smtp://tester44.tester2@gmail.com:hpevdqbvclzebhxa@smtp.gmail.com:587');
        $mailer = new Mailer($transport);
    
        // Create the email message
        $email = (new Email())
            ->from('tester44.tester2@gmail.com')
            ->to($userEmail)
            ->subject('reservation complete')
            ->html($htmlContent);
    
        // Send the email
        $mailer->send($email);
    
        return $this->render('repas/index.html.twig', [
            'controller_name' => 'RepasController',
            'repas' => $repas,
            'adresse' => $informationPersonneles->getAdresse()
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
