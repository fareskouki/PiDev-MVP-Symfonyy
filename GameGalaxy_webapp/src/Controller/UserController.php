<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    #[Route('/liste',name:'liste')]
    public function getusers(UserRepository $userRepository,SerializerInterface $serializerInterface)
    {
        $user=$userRepository->findAll();
        $json=$serializerInterface->serialize($user,'json',['groups'=>'user']);
        dump($user);
        die;
    }
    #[Route('/adduser',name:'addusers')]
    public function adduser(Request $request,SerializerInterface $serializerInterface,EntityManager  $em)
    {
    $content=$request->getContent();
    $data=$serializerInterface->deserialize($content,User::class,'json');
    $em->persist($data);
    $em->flush();
    return new Response('User Added Successfuly');
    }
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager): Response
    {
      
      
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_ADMIN"]);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
      return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher,UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
 #[Route('/editprofil/mob',name:'app_editprof',methods: ['POST'])]
    public function api_EditProfile(UserRepository $userRepository,NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request)
    {
        $user = new User();
        $user = $userRepository->findOneBy(['id' => $request->get('id')]);
        if ( $user ){
             
            $user->setEmail($request->get('email'));
            $user->setRoles(["ROLE_".$request->get('roles')]);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "user has been updated"
            ]);
        }else{
            return new JsonResponse([
                'error' => "error updating , please try again"
            ]);
        }
    }

        
    }
    
    
    
    

    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


   

   
   
   
   

   
   
   
   
   
   
   
   

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   


   
   


