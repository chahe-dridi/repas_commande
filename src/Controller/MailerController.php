<?php

namespace App\Controller;

use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mime\Address;
use Twig\Environment as TwigEnvironment;
class MailerController extends AbstractController
{
    
    public function sendEmail(MailerInterface $mailer ,String $to, String $activationCode): Response
    {
        // Create a transport
        $transport = Transport::fromDsn('smtp://karat6657@gmail.com:Jd0z7k2DxNbn6QZ8@smtp-relay.brevo.com:587');

        // Create a Mailer
        $mailer = new Mailer($transport);

        // Create an Email object
        $email = (new Email())
            ->from('no-reply@cookConnect.tn')
            ->to(new Address($to))
            ->subject('Reset PAssword');

        // Set the HTML part using a Twig template
        $email->html($this->renderView('mailer/index.html.twig', [
            'username' => 'foo',
            'address'=>$to,
            'activationCode'=>$activationCode
        ]));

        // Alternatively, you can set the text part using a Twig template
        // $email->text($this->renderView('emails/signup.txt.twig', [
        //     'expiration_date' => new \DateTime('+7 days'),
        //     'username' => 'foo',
        // ]));

        // Send the email
        $mailer->send($email);

        return new Response('Email sent successfully!');
    }

}
