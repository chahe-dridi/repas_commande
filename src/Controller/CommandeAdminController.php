<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Repository\CommandeRepository;

 
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/commande/admin')]
class CommandeAdminController extends AbstractController
{
    #[Route('/', name: 'app_commande_admin_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande_admin/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/new', name: 'app_commande_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $commande->setUser($user);
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_admin/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_admin_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande_admin/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $commande->setUser($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_admin/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_admin_index', [], Response::HTTP_SEE_OTHER);
    }












    #[Route('/commande/pdf', name: 'app_commande_pdf', methods: ['GET'])]
    public function generatePdf(CommandeRepository $commandeRepository): Response
    {
        // Fetch command information from the repository
        $commandes = $commandeRepository->findAll();
        // Render the commandes into a PDF using a template
        $pdf = $this->renderView('commande_admin/commandes_pdf.html.twig', [
            'commandes' => $commandes,
        ]);
    
        // Create a new instance of Dompdf
        $dompdf = new Dompdf();
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
