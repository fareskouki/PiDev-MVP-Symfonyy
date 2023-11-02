<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Payment;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/order')]
class OrderController extends AbstractController
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;

    }

    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
            'paymentFail' => isset($_GET['paymentFail']),
            'paymentSuccess' => isset($_GET['paymentSuccess']),
        ]);
    }
    #[Route('/pay', name: 'pay_order', methods: ['GET'])]

    public function payment(PaymentRepository $paymentRepo,OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        $payment = new Payment();
        $order = $orderRepository->find($_GET['Num']);
        if(!$order->getPayment()) {
            $payment->setSessionId("  ");
            $payment->setOrderLine($order);
            $payment->setTotal($_GET['amount']);
            $date = date("m/d/Y");
            $payment->setCreatedOn(new \DateTime($date));
            $payment->setStatus("pending");
            $paymentRepo->save($payment,true);
            $payment = $paymentRepo->findOneBy(['OrderLine'=>$_GET['Num']]);
            $order->setPayment($payment);
            $orderRepository->save($order,true);
        } else {
            $payment = $order->getPayment();
        }

        $response = $this->client->request('POST', 'https://api.preprod.konnect.network/api/v1/payments/init-payment', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'body' => [
                "receiverWallet" => "6400110816c37490867f9e6f",
                "amount" => $_GET['amount'] * 1000,
                "selectedPaymentMethod" => "gateway",
                "firstName" => "Imen",
                "lastName" => "Ben Atig",
                "phoneNumber" => "+21655311029",
                "token" => "TND",
                "orderId" => $payment->getId(),
                "successUrl" => "http://127.0.0.1:8000/order/paymentsuccess/".$payment->getId(),
                "failUrl" => "http://127.0.0.1:8000/order/?paymentFail=true"
            ]
        ]);
        $content = json_decode($response->getContent(),true);
        print_r($content);
        $payment->setSessionId($content['paymentRef']);
        $paymentRepo->save($payment,true);
        return $this->redirect($content['payUrl']);

    }
    #[Route('/paymentsuccess/{id}', name: 'payment_success', methods: ['GET'])]

    public function paymentSuccess(Payment $payment,PaymentRepository $paymentRepo,OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();

        $response = $this->client->request('GET', 'https://api.preprod.konnect.network/api/v1/payments/'.$payment->getSessionId(), [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $content = json_decode($response->getContent(),true);
        print_r($content);

        if($payment->getStatus() == "pending" && $content["status"] == "completed") {
            $payment->setStatus("paid");
            $payment->setCreatedOn(new \DateTime("now"));
            $paymentRepo->save($payment, true);
            $orderLine = $payment->getOrderLine();
            $orderLine->setStatus("Confirmed");
            $orderRepository->save($orderLine, true);

            /*
            $email = (new TemplatedEmail())
                ->from(new Address('w311940@gmail.com', 'Makrent car'))
                ->to($user->getEmail())
                ->subject('Confirmation')
                ->htmlTemplate('email/successful-email.html.twig');

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {

            }*/

            return $this->redirectToRoute('app_order_index',["paymentSuccess" => true], Response::HTTP_SEE_OTHER);

        } else {
            $payment->setStatus($content["status"]);
            $payment->setCreatedOn(new \DateTime("now"));
            $paymentRepo->save($payment, true);
             return $this->redirectToRoute('app_order_index',["paymentFail" => true], Response::HTTP_SEE_OTHER);
        }
    }
    #[Route('/back/', name: 'app_order_index_back', methods: ['GET'])]
    public function indexBack(OrderRepository $orderRepository): Response
    {
        return $this->render('/order/back/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderRepository $orderRepository): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->save($order, true);

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}', name: 'app_order_show_back', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/back/show.html.twig', [
            'order' => $order,
        ]);
    }


    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show1(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->save($order, true);

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $orderRepository->remove($order, true);
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
