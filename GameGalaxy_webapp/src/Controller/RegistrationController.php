<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_USER"]);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            
            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route("/signupmob",name:"app")]
    public function signupMob(Request $request,UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $email=$request->query->get("email");
        $Pseudo=$request->query->get("Pseudo");
        $password=$request->query->get("password");
        $roles=$request->query->get("roles");
       //$date_naissance=$request->query->get("date_naissance");
        //$address=$request->query->get("addresse");
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return new Response("Email non valid");
        }
        $user=new User();
        $user->setEmail($email);
        $user->setPseudo($Pseudo);
        $user->setpassword($passwordEncoder->encodePassword($user,$password));
       //$user->setDateNaissance($date_naissance);
        //$user->setAddresse($address);
        
        $user->setRoles(array($roles));
        try{
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new JsonResponse("Account is created");
        }catch(\Exception $ex)
        {
            return new Response("exception ",$ex->getMessage());
        }
}

#[Route("/signinpmob",name:"signinpmob")]
public function signinMob(Request $request)
{
    $email=$request->query->get("email");
    $password=$request->query->get("password");
    $em=$this->getDoctrine()->getManager();
    $user=$em->getRepository(User::class)->findOneBy(['email'=>$email]);
    if($user){
        if(password_verify($password,$user->getPassword()))
        {
            $serializer =new Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize($user);
            return new JsonResponse($formatted);
        }else
        {
            return new Response ("password not found");

        }
    }
        else {
            return new Response ("User Not Found");
        }
    }
    
    
}
