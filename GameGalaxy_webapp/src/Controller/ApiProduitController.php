<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiProduitController extends AbstractController
{
    #[Route('/api', name: 'app_api_produit')]
    public function index(): Response
    {
        return $this->render('api_produit/index.html.twig', [
            'controller_name' => 'ApiProduitController',
        ]);
    }
        //add Produit JSON
        #[Route('/fares', name: 'add_produit', methods: ['GET','POST'])]
        public function ajouterproduit(Request $request){
            $produit = new Produit();
            $nom_produit = $request->query->get('nom_produit');
            $description = $request->query->get('description');
            //$img= $request->query->get('img');
            $prix = $request->query->get('prix');
            $stock = $request->query->get('stock');
            $rating = $request->query->get('rating');
        
            $produit->setNomProduit($nom_produit);
            $produit->setDescription($description);
           // $produit->setImg($img);
            $produit->setPrix($prix);
            $produit->setStock($stock);
            $produit->setRating($rating);
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            $serializer = new Serializer ([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($produit);
            return new JsonResponse($formatted);
        
        }
        
            //show avec Json
        
            #[Route('/showproduitJSON', name: 'showproduitJSON', methods: ['GET'])]
            public function listproduitJSON( SerializerInterface $serializer, ProduitRepository $produitRepository): JsonResponse
            {

                $produits = $produitRepository->findAll();
                $json = $serializer->serialize($produits, 'json', [
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    },
                    'attributes' => [
                     
                        'id','nom_produi','prix','description','stock','rating'
                    ],
                    
                ]);
        
                return new JsonResponse($json, Response::HTTP_OK, [], true);
            }
   
}