<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Form\ResPasswordType;
use App\Repository\UserRepository;
use App\Service\SendMaileservice;
use App\Service\SendMailservice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;

use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use SymfonyCasts\Bundle\VerifyEmail\Controller\VerifyEmailControllerTrait;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SecurityController extends AbstractController
{
    
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            return $this->redirectToRoute('home_page/index.html.twig');
        }

        return $this->render('security/login.html.twig',
         ['last_username' => $lastUsername, 
         'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
   public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



    
    #[Route(path:'/forgot_pass',name:'app_forgot_pass')]
    public function forgotpass(Request $request,/*SendMaileservice $mail,*/UserRepository $userRepository,EntityManagerInterface $entitymanager,TokenGeneratorInterface $tokenGeneratorInterface):Response
    { 
        $form=$this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $user= $userRepository->findOneByEmail($form->get('email')->getData());
           
            if($user){
                //génér token de réalisation
                $token=$tokenGeneratorInterface->generateToken();
                $user->setResetToken($token);
                   $entitymanager->persist($user);
                   $entitymanager->flush(); 
                   //on génere le lien
                   $url=$this->generateUrl('reset_pass',['token'=>$token],UrlGeneratorInterface::ABSOLUTE_URL);


                   //creation donneés mail
                   $context=compact('url','user');
                   $email=(new Email());
                   $transport=new GmailSmtpTransport('gamegalaxy.noreply@gmail.com','jebjupbvaoaeagvp');

                   $loader = new FilesystemLoader('../templates');
                   $twig = new Environment($loader);
                   $html = $twig->render('email/reset_pass.html.twig',['url'=> $url]);
       
                   $email = (new Email())
                       ->from('gamegalaxy.noreply@gmail.com')
                       ->to($user->getEmail())
                       ->subject('Réanilisation De Mot De passe')
                       ->html($html);


                   $mailer=new Mailer($transport);
                   $mailer->send($email);
                   //envoi du mail
                 /* $mail->send(
                    'gamegalaxy.noreply@gmail.com',
                    $user->getEmail(),
                    'Réanilisation',
                    'reset_pass',
                    $context

                   );*/

                   $this->addFlash('success','Email Envoye');
                   return $this->redirectToRoute('app_login');
            }
            //$user est null
            $this->addFlash('danger','un probléme est survenu');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/ForgotPass.html.twig',[
            'RequestPass'=>$form->createView()
        ]);
    }

   #[Route('/reset_pwd/{token}',name:'reset_pass')]
    public function resetpass(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entitymanager,
        UserPasswordHasherInterface $paswwordhasher
    ):Response{
        $user=$userRepository->findOneByResetToken($token);
        if($user){
            $form=$this->createForm(ResPasswordType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
               $user->setResetToken('');
                $user->setPassword(
                    $paswwordhasher->hashPassword(
                        $user,$form->get('password')->getData()
                    )
                    );
                    $entitymanager->persist($user);
                    $entitymanager->flush();
                    return $this->redirectToRoute('app_login');
            }
            return $this->render('security/reset_password.html.twig',[
                'passForm'=>$form->createView()
            ]);

        }
        $this->addFlash('danger','Jeton Invalide');
        return $this->redirectToRoute('app_login');
    }
}
