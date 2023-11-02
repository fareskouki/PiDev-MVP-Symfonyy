<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Repository\ReservationRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping\Id;

class HomePageController extends AbstractController
{

    #[Route('/home', name: 'app_home_page', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository,ProduitRepository $produitRepository): Response
    {
        return $this->render('home_page/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'produit' => $produitRepository->findAll(),
        ]);
        
    }

}
