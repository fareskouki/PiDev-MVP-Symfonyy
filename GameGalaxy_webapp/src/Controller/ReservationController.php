<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\EvenementRepository;
use App\Services\QrcodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Repository\UserRepository;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/back', name: 'app_back_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index_back.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_front_reservation_index', methods: ['GET'])]
    public function indexFront(UserRepository $userRepository,ReservationRepository $reservationRepository,EvenementRepository $EvenementnRepository, QrcodeService $qrcodeService): Response
    {   $user = $this->getUser();
        $user = $userRepository->findOneBy(['email' => $user->getUserIdentifier()]);
        //dd($user->getUserIdentifier());
        $qrcodes=[];
        $count=0;
        $reservations=$reservationRepository->findByemail($user->getId () );
        
        foreach($reservations as $reservation)
        {   $count++;
            $qrcodes[$count]=$qrcodeService->qrcode($reservation->getIdMembre()." pour l'évènement suivant: ". $reservation->getIdEvenement());
        }
      
        return $this->render('reservation/index_front.html.twig', [
            'reservations' => $reservations,
            'qrcodes' => $qrcodes,
            'user'  => $user->getUserIdentifier(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository, EvenementRepository $evenementRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement = $evenementRepository->find($reservation->getIdEvenement());
            if ($evenement && $evenement->getCapacite() > 0) {
                $evenement->setCapacite($evenement->getCapacite() - 1);
                $reservationRepository->save($reservation, true);
                $evenementRepository->save($evenement, true);
                return $this->redirectToRoute('app_back_reservation_index', [], Response::HTTP_SEE_OTHER);
            } else {
                $form->addError(new FormError("L'évènement est complet!"));
            }
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_back_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $evenement = $reservation->getIdEvenement();
            $evenement->setCapacite($evenement->getCapacite() + 1);
            $reservationRepository->remove($reservation, true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
