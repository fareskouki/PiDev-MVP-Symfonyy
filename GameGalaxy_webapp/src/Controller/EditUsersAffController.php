<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EditUsersAffController extends AbstractController
{
    #[Route('/edit/{id}', name: 'app_edit_users_aff', methods: ['GET'])]
    public function index(User $user): Response
    {
    
        return $this->render('edit_users_aff/index.html.twig', [
           'user'=>$user,
        ]);
    }
}
