<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\Commande1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;






use Symfony\Component\Mailer\Mailer ;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;





#[Route('/commande/client')]
class CommandeClientController extends AbstractController
{
    #[Route('/', name: 'app_commande_client_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande_client/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/new', name: 'app_commande_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_client/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_client_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande_client/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_client/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_client_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }







    #[Route('/{id}/send-confirmation-email', name: 'app_send_confirmation_email', methods: ['POST'])]
public function sendConfirmationEmail(Commande $commande): Response
{
    // Check if the order status is "En cours"
    if ($commande->getEtat() === 'En cours') {
        // Generate a random 6-digit verification code
        $verificationCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = $this->getUser();
        $userEmail = $user->getEmail();

        // Email content with the verification code
        $htmlContent = "
            <html>
            <head>
                <style>
                    /* Your CSS styles */
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Dear {$commande->getUser()->getEmail()},</h2>
                    <p>Your order confirmation:</p>
                    <ul>
                        <li><strong>Order ID:</strong> {$commande->getId()}</li>
                        <!-- Include other order details as needed -->
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

        // You might want to save the verification code in the database or session for later verification by the user

        // Redirect to the confirmation page with the verification code
        return $this->redirectToRoute('app_confirm_order_verification', [
            'id' => $commande->getId(),
            'verificationCode' => $verificationCode,
        ]);
    } else {
        // Add flash message for orders with a status other than "En cours"
        $this->addFlash('error', 'Confirmation email cannot be sent for orders with a status other than "En cours".');

        // Redirect back to the order index page
        return $this->redirectToRoute('app_commande_client_index');
    }
}

#[Route('/{id}/confirm-order-verification/{verificationCode}', name: 'app_confirm_order_verification', methods: ['GET'])]
public function confirmOrderVerification(Commande $commande, $verificationCode): Response
{
    return $this->render('commande_client/new.html.twig', [
        'commande' => $commande,
        'verificationCode' => $verificationCode,
    ]);
}

#[Route('/{id}/confirmorder', name: 'app_confirm_order', methods: ['POST'])]
public function confirmOrder(Request $request, Commande $commande): Response
{
    $verificationCode = $request->request->get('verificationCode');
    $storedVerificationCode = $request->request->get('storedVerificationCode');

    // Check if the verification code matches the one sent to the user's email
    if ($verificationCode === $storedVerificationCode) {
        // Update the order status to "confirmed"
        $commande->setEtat('confirmer');
        $this->getDoctrine()->getManager()->flush();

        // Add flash message for successful confirmation
        $this->addFlash('success', 'Order confirmed successfully.');
    } else {
        // Add flash message for incorrect verification code
        $this->addFlash('error', 'Incorrect verification code. Please try again.');
        return $this->redirectToRoute('app_confirm_order_verification', [
            'id' => $commande->getId(),
            'verificationCode' => $storedVerificationCode,
        ]);
    }

    // Redirect back to the order index page
    return $this->redirectToRoute('app_commande_client_index');
}











}





















 
