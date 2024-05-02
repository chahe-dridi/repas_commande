<?php

namespace App\Controller;

use App\Entity\InformationPersonnele;
use App\Form\InformationPersonneleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/profile')]
class InformationPersonneleController extends AbstractController
{
    #[Route('/', name: 'app_information_personnele_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if($this->getUser()){
        $informationPersonneles = $entityManager
            ->getRepository(InformationPersonnele::class)
            ->findOneByUser($this->getUser());

        return $this->render('information_personnele/index.html.twig', [
            'information_personnele' => $informationPersonneles,
        ]);
    }else{
        return $this->redirectToRoute('app_login');
    }
    }
 #[Route('/edit', name: 'app_information_personnele_edit', methods: ['POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {   
        if($this->getUser()){
        $informationPersonneleId = $request->request->get('id');

        $informationPersonnele = $entityManager->getRepository(InformationPersonnele::class)->find($informationPersonneleId);

        if (!$informationPersonnele) {
            $informationPersonnele = new InformationPersonnele();
        }
        if( $request->request->get('nom') && $request->request->get('prenom') && $request->request->get('sexe') && $request->request->get('taille') && $request->request->get('poids') && $request->request->get('numTel') && $request->request->get('adresse')){
        $informationPersonnele->setNom($request->request->get('nom'));
        $informationPersonnele->setPrenom($request->request->get('prenom'));
        $informationPersonnele->setSexe($request->request->get('sexe'));
        $informationPersonnele->setTaille($request->request->get('taille'));
        $informationPersonnele->setPoids($request->request->get('poids'));
        $informationPersonnele->setMaladie($request->request->get('maladie'));
        $informationPersonnele->setNumTel($request->request->get('numTel'));
        $informationPersonnele->setAdresse($request->request->get('adresse'));
        $informationPersonnele->setUser($this->getUser());
        $entityManager->persist($informationPersonnele);
        $entityManager->flush();
        if ($request->files->get('image')) {
            $file = $request->files->get('image');
            $filePath = $file->getPathname();
        
            // Generate a unique name for the file
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        
            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('your_images_directory'),
                $fileName
            );
        
            $user = $entityManager->getRepository(User::class)->find($this->getUser());
            $user->setImage($fileName);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Profile updated successfully');

        return $this->redirectToRoute('app_information_personnele_index', [], Response::HTTP_SEE_OTHER);
    }else{
                $request->getSession()->getFlashBag()->add('error', 'all fields are required');
        return $this->redirectToRoute('app_information_personnele_index', [], Response::HTTP_SEE_OTHER);

    }
    }else{
        return $this->redirectToRoute('app_login');
    }
    }





}
