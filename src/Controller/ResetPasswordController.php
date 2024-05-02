<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    /*#[Route('/reset_password', name: 'app_reset_password')]
    public function index(MailerController $mailer, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, MailerInterface $test, Request $request): Response
    {
         //$mailer->sendEmail($test,'yossrinjeh46@gmail.com','1234');
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneByEmail($form->get('email')->getData());
    
            if ($user && $user->getVerificationCode() == $form->get('verificationCode')->getData()) {
                return $this->redirectToRoute('app_change_password', ['email' => $user->getEmail()]);
            } else {
                return new Response("Invalid email or verification code!", Response::HTTP_BAD_REQUEST);
            }
        }
    
        return $this->render('reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
            'form' => $form->createView(),
        ]);
    }*/
    #[Route('/reset_password', name: 'app_reset_password')]
    public function index(MailerController $mailer, UserRepository $userRepository, MailerInterface $test, Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $userRepository->findOneByEmail($email);
    
            if ($user) {
                // Generate a 6-digit activation code
                $activationCode = $user->getVerificationCode();
                $resetUrl = $urlGenerator->generate('app_change_password', ['email' => $email, 'code' => $activationCode], UrlGeneratorInterface::ABSOLUTE_URL);
    
                // Send email with reset password URL
                $mailer->sendEmail($test, $email, $resetUrl);
                $request->getSession()->getFlashBag()->add('success', 'Password reset link has been sent to your email.');
                //dd($flashBag);
                return $this->redirectToRoute('app_reset_password');
                        } else {
                            $request->getSession()->getFlashBag()->add('error', 'User not found!');

                            return $this->redirectToRoute('app_reset_password');
                        }
        }
    
        return $this->render('reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/change/{email}/{code}', name: 'app_change_password')]
    public function change(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, string $email, string $code, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->findOneByEmail($email);
    
        if (!$user) {
            $request->getSession()->getFlashBag()->add('error', 'User not found!');

                            return $this->redirectToRoute('app_reset_password');        }
    
        // Ensure the provided code matches the user's activation code
        if ($user->getVerificationCode() != $code) {
            $request->getSession()->getFlashBag()->add('error', 'Invalid activation code');

            return $this->redirectToRoute('app_reset_password');  
        }
    
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode and set the new password
            $newPassword = $form->get('password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($encodedPassword);
    
            // Clear the activation code
            $activationCode = rand(100000, 999999);
            $user->setVerificationCode($activationCode);    
            // Persist changes
            $entityManager->persist($user);
            $entityManager->flush();
    
            // Redirect to login page
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('reset_password/change.html.twig', [
            'controller_name' => 'ChangePasswordController',
            'form' => $form->createView(),
        ]);
    }
    
    

}
