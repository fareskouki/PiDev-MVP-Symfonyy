<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;


#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/back', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index_back.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }


    #[Route('/front', name: 'app_front_produit_index', methods: ['GET'])]
    public function indexFront(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, Request $request): Response
    {
        $categorieId = $request->query->get('categorieId');
        
        if ($categorieId) {
            // Get the categorie object based on the selected categorie id
            $categorie = $categorieRepository->find($categorieId);
            $produits = $produitRepository->findByCategorie($categorie);
        } else {
            $produits = $produitRepository->findAll();
        }
        
        $categories = $categorieRepository->findAll();
        
        return $this->render('produit/index_front.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
            'selectedcategorieId' => $categorieId,
        ]);
    }

        
    public function search(Request $request, ProduitRepository $produitRepository)
{
    $searchTerm = $request->query->get('games-search-text');
    $produits = $produitRepository->findByProductName($searchTerm);

    return $this->render('produit/index_front.html.twig', [
        'produits' => $produits,
    ]);
}


    #[Route('/{id}', name: 'app_produit_detail', methods: ['GET', 'POST'])]
    public function detail(Produit $produit ): Response
    {
            
            return $this->renderForm('produit/detail.html.twig', [
            'produit' => $produit,
            
        ]);
    }

   
    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository, SluggerInterface $slugger): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('img')->getData();

            // this condition is needed because the 'img' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($img) {
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'produits/'.$safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                // Move the file to the directory where imgs are stored
                try {
                    $img->move(
                        $this->getParameter('produits_uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imgFilename' property to store the PDF file name
                // instead of its contents
                $produit->setImg($newFilename);
            }

            $produitRepository->save($produit, true);

            

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $img = $form->get('img')->getData();

            // this condition is needed because the 'img' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($img) {
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                // Move the file to the directory where imgs are stored
                try {
                    $img->move(
                        $this->getParameter('produit_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imgFilename' property to store the PDF file name
                // instead of its contents
                $produit->setImg($newFilename);
            }
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    public function myControllerAction()
    {
        $categories = $this->getDoctrine()->getRepository(categorie::class)->findAll();
        return $this->render('my-template.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/produit/tri-par-nom', name: 'app_produit_tri_par_nom', methods: ['GET'])]
public function triParNom(ProduitRepository $produitRepository): Response
{
    $produits = $produitRepository->findBy([], ['nom_produit' => 'ASC']);
    return $this->render('produit/index.html.twig', [
        'produits' => $produits,
    ]);
}
    

//*************************************************************************** */    
 
}
