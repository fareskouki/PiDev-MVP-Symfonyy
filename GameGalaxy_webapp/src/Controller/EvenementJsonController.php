<?php

namespace App\Controller;



use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EvenementJsonController extends AbstractController
{
    #[Route('/evenement/json', name: 'app_evenement_json')]
    public function index(): Response
    {
        return $this->render('evenement_json/index.html.twig', [
            'controller_name' => 'EvenementJsonController',
        ]);
    }


    #[Route('/AddEvenementJSON', name:'AddEvenementJSON', methods:['GET','POST'])]
function AddEvenementJSON(Request $request,EvenementRepository $evenementRepository)
    {
    $evenement= new Evenement();
    $nom = $request->query->get('nom');
    //$date = $request->query->get('date');
    $description = $request->query->get('description');
    $type = $request->query->get('type');
    $duree = $request->query->get('duree');
    $capacite = $request->query->get('capacite');

    $evenement->setNom($nom);
    //$evenement->setDate(null);
    $evenement->setDescription($description);
    $evenement->setType($type);
    $evenement->setDuree($duree);
    $evenement->setCapacite($capacite);

    $evenementRepository->save($evenement, true);
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($evenement);
    return new JsonResponse($formatted);
}


    #[Route('/ListEvenementJSON', name: 'ListEvenementJSON', methods: ['GET'])]
    function ListEvenementJSON(EvenementRepository $evenementRepository, SerializerInterface $serializer): JsonResponse
    {

        $evenements = $evenementRepository->findAll();
        $json = $serializer->serialize($evenements, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            'attributes' => ['id',
             'nom',
              'date' => function ($datetime) {
                return $datetime->format('Y-m-d H:i:s');
            },
             'description', 'duree', 'capacite', 'type'],
        ]);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/DeleteEvenementJSON/{id}', name:'DeleteEvenementJSON', methods:['DELETE'])]
function DeleteEvenementJSON( Evenement $evenement,EvenementRepository $evenementRepository): JsonResponse
    {
        $evenementRepository->remove($evenement, true);

    $data = [
        'status' => 200,
        'message' => 'Evenement has been deleted',
    ];

    return new JsonResponse($data);
}

#[Route('/UpdateEvenement/{id}', name:'UpdateEvenement', methods:['PUT', 'GET'])]
function updateBlogJSON(Request $request, Evenement $evenement,EvenementRepository $evenementRepository): JsonResponse
    {
        $nom = $request->query->get('nom');
    $date = $request->query->get('date');
    $description = $request->query->get('description');
    $type = $request->query->get('type');
    $duree = $request->query->get('duree');
    $capacite = $request->query->get('capacite');

    $evenement->setNom($nom);
    //$evenement->setDate($date);
    $evenement->setDescription($description);
    $evenement->setType($type);
    $evenement->setDuree($duree);
    $evenement->setCapacite($capacite);
    
    $evenementRepository->save($evenement, true);
    
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
    
        return new JsonResponse($formatted);
}
}
