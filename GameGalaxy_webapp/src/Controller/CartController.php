<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Produit;
use App\Entity\Order;
use App\Entity\Item;
use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_index', methods: ['GET'])]
    public function index(CartRepository $cartRepository, ProduitRepository $productsRepository, SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $product = $productsRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrix() * $quantite;
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/new', name: 'app_cart_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CartRepository $cartRepository): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartRepository->save($cart, true);

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cart/new.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cart_show', methods: ['GET'])]
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cart $cart, CartRepository $cartRepository): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartRepository->save($cart, true);

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cart_delete', methods: ['POST'])]
    public function delete(Request $request, Cart $cart, CartRepository $cartRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            $cartRepository->remove($cart, true);
        }

        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }


    //SESSION



    #[Route('/add/{id}', name: 'cart_add', methods: ['GET'])]
    public function add(Produit $product, SessionInterface $session, CartRepository $cartRepo, ProduitRepository $prodRepo)
    {

        $panier = $session->get("panier", []);
        $id = $product->getId();
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }


        $session->set("panier", $panier);
        $cart = $cartRepo->findOneBy(['session' => $session->getId() ]) ;
        if(!$cart) {
            $cart = new Cart();
        }
        $cart->setSession($session->getId());
        $quantity = 0;
        $total = 0;
        foreach($panier as $key => $value) {
            $tmpProd = $prodRepo->find($key);
            $cart->addIdPproduct($tmpProd);
            $quantity+=$value;
            $total += $tmpProd->getPrix()*$value;
        }
        $cart->setQuantite($quantity);
        $cart->setPrix($total);
        $cart->setTitre("Visitor Cart #".$session->getId());
        $cartRepo->save($cart,true);
        return $this->redirectToRoute("app_cart_index");
    }

    #[Route('/remove/{id}', name: 'cart_remove', methods: ['GET','POST'])]
    public function remove(Produit $product, SessionInterface $session, CartRepository $cartRepo, ProduitRepository $prodRepo)
    {

        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);
        $cart = $cartRepo->findOneBy(['session' => $session->getId() ]);
        $cart->setSession($session->getId());
        $quantity = 0;
        $total = 0;
        foreach($panier as $key => $value) {
            $tmpProd = $prodRepo->find($key);
            $cart->addIdPproduct($tmpProd);
            $quantity+=$value;
            $total += $tmpProd->getPrix()*$value;
        }
        $cart->setQuantite($quantity);
        $cart->setPrix($total);
        $cart->setTitre("Visitor Cart #".$session->getId());
        $cartRepo->save($cart,true);
        return $this->redirectToRoute("app_cart_index");
    }

    #[Route('/delete/{id}', name: 'cart_delete', methods: ['GET','POST'])]

    public function deleteSession(Produit $product, SessionInterface $session)
    {

        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }


        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart_index");
    }

    #[Route('/delete_all', name: 'cart_delete_all', methods: ['GET','POST'])]

    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("app_cart_index");
    }

    #[Route('/submit/cart', name: 'app_cart_submit', methods: ['GET'])]
    public function submitted(SessionInterface $session,OrderRepository $orderRepo, CartRepository $cartRepo, ProduitRepository $prodRepo)
    {
        echo "HERE";
        $panier = $session->get("panier", []);
        $cart = $cartRepo->findOneBy(["session"=>$session->getId()]);
        $order = new Order();
        $total = 0;
        foreach($panier as $key => $value) {
            $tmpProd = $prodRepo->find($key);
            $tmpItem = new Item();
            $tmpItem->setProduct($tmpProd);
            $tmpItem->setQuantity($value);
            $order->addItem($tmpItem);
            $total += $tmpProd->getPrix() * $value;
        }
        $order->setStatus("Pending");
        $order->setTotal($total);
        $orderRepo->save($order,true);
        $cartRepo->remove($cart);
        $session->set("panier",[]);
        return $this->redirectToRoute("app_order_index");
    }
}
