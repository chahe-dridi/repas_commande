<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
      
        return $this->render('frontOffice/base.html.twig', [
            'controller_name' => 'HomeController',
            
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('frontOffice/about.html.twig');
    }
    #[Route('/contact', name: 'app_contact')]
    public function contactUs(): Response
    {
        return $this->render('frontOffice/contact.html.twig');
    }
    #[Route('/newlivraison', name: 'app_livraison')]
    public function newlivraison(): Response
    {
        return $this->render('livraison/index.html.twig');
    }
    #[Route('/backoffice', name: 'app_back')]
    public function back(UserRepository $userRepository): Response
    {
        if ($this->getUser()  && in_array('ADMIN', $this->getUser()->getRoles())){
            $userCounts = [];

            $registrationDates = $userRepository->findAllRegistrationDates();
    
            $monthLabels = [];
    
            foreach ($registrationDates as $date) {
                if ($date['date'] !== null) {
                // Extract month name from the registration date
                $monthLabels[] = $date['date']->format('F');
            }
            }
    
            $monthLabels = array_unique($monthLabels);
            $auser =  count($userRepository->findByIsactive(true));
            $iuser= count($userRepository->findByIsactive(false));
            foreach ($monthLabels as $month) {
                $users = $userRepository->findByRegistrationMonth($month);
    
                // Initialize counter for active users
                $activeCount = 0;
                $inactive=0;
                // Loop through users to count active users
                foreach ($users as $user) {
                    if ($user->isIsActive()) {
                        $activeCount++;
                       
                    }else{
                        $inactive ++;
                       
                    }
                }
    
                $activeUser[] = $activeCount;
            $inactiveUser[] = $inactive;
            }
            
            //dd($activeUser ,$inactiveUser );
            $sessionDir = ini_get('session.save_path');

            // Count session files
            $sessionFiles = glob($sessionDir . '/*');
            $sessionCount = count($sessionFiles);
            
        return $this->render('BackOffice/base.html.twig', [
            'months' => array_values($monthLabels),
            'dataActive'=>$activeUser,
            'dataInactive'=>$inactiveUser,
            'session'=>$sessionCount,
            'Actuser'=>$auser,
            'Inuser'=>$iuser,
            'cnumber'=>count($userRepository->findByRole("CLIENT"))

        ]);
        }else{
            return $this->render('frontOffice/403.html.twig');
        }
    }
}
