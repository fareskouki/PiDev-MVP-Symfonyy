<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    #[Route('/profiluser', name: 'app_profil2')]
    public function profiluser(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('profil/index2.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    #[Route('/edit_profile', name:'app_mod_pro', methods: ['GET', 'POST'])]
    public function editprof(Request $request,EntityManagerInterface $entityManager ):Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/Editprofile1.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
 
 
 
 
 
 
 
 
 
 
 
 

    
}
}