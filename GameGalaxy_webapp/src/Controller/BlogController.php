<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Form\BlogType;
use App\Form\CommentType;
use App\Repository\BlogRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Dompdf\Dompdf;
use App\Entity\User;

use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/back', name: 'app_blog_index', methods: ['GET', 'POST'])]
    function index(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/index_back.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }

    //add blog

    #[Route('/new', name: 'app_blog_new', methods: ['GET', 'POST'])]

    function new(Request $request, BlogRepository $blogRepository): Response
    {
        $blog = new Blog;
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->IsSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            // On boucle sur les images
            foreach ($image as $image) {
                // On génère un nouveau nom de fichier
                $fichier = 'blogs/' . md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('blogs_uploads_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $blog->setImage($fichier);
            }
            $blog->setCreatedAt(new \DateTime());
            // $date = new DateTime();
            // $currentDate = $date->format('Y-m-d');
            $blogRepository->save($blog, true);
            return $this->redirectToRoute('app_blog_index', []);
        }
        return $this->render('blog/new.html.twig', [
            'blog' => $form->createView(),

        ]);
    }

    #[Route('/blog/{id}/like', name: 'likeblog')]
    public function likeBlog(Request $request, Blog $blog, BlogRepository $blogRepo): Response
    {
        if (!$blog) {
            throw $this->createNotFoundException('The blog does not exist.');
        }

        $blog->incrementLikes();
        $blogRepo->save($blog,true);

        return $this->redirectToRoute('app_front_blog_index');
    }




    #[Route('/back/{id}', name: 'app_back_blog_show', methods: ['GET', 'POST'])]
    function showBack(BlogRepository $blogRepository): Response
    {

        $blog = $blogRepository->findAll();
        return $this->render('blog/show_back.html.twig', [
            'blog' => $blog,

        ]);
    }

    //afficher le détail blog
    /* #[Route('/front/{id}', name: 'app_front_blog_show')]
    function blogdetail(Request $request, BlogRepository $blogRepository, $id): Response
    {
        $blog = $blogRepository->find($id);
        $comments = new Comment;
        $commentForm = $this->createForm(CommentType::class, $comments);
        $commentForm->handleRequest($request);

        // Filter bad words

        $badWords = ['fuck', 'Fuck off', 'piss off', 'bugger off', 'Bloody hell', 'Bastard', 'Bollocks', 'Motherfucker', 'Son of a bitch', 'Asshole', 'ass'];
        $filteredContent = str_ireplace($badWords, '****', $comments->getContent());
        $comments->setContent($filteredContent);

        // Validate comment form
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comments->setBbid($blog);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comments);
            $em->flush();

            // Redirect to prevent accidental form resubmission
            return $this->redirectToRoute('app_front_blog_show', ['id' => $id]);
        }

        $commentsList = $blog->getComments();

        return $this->render('blog/show_front.html.twig', [
            'blog' => $blog,
            'commentForm' => $commentForm->createView(),
            'commentsList' => $commentsList,
        ]);
    }*/

    // afficher liste des blog front
   #[Route('/front', name: 'app_front_blog_index')]
    public function listBlogFront(BlogRepository $blogRepository, Request $request): Response
    {
        $blogs = $blogRepository->findAll();
        $likes = [];
        $comments = [];
        foreach ($blogs as $blog) {
            $likes[$blog->getId()] = $blog->getLikes();
        }

        // $blogsQuery = $blogRepository->createQueryBuilder('b')
        //     ->orderBy('b.createdAt', 'DESC')
        //     ->getQuery();

        // $pagination = $paginator->paginate(
        //     $blogsQuery,
        //     $request->query->getInt('page', 1),
        //     3 // limit per page
        // );

        return $this->render('blog/index_front.html.twig', [
            'blogs' => $blogs,
            'comments' => $comments,
            'likes' => $likes,
            //'pagination' => $pagination
        ]);
    }

    //detail blog for user (Front)

    #[Route('/front/{id}', name: 'app_front_blog_show')]
    function listblogdetail(CommentRepository $commentRepository, BlogRepository $blogRepository, $id,UserRepository $userRepository, Request $request): Response
    {
        $user = $this->getUser();
        $user = $userRepository->findOneBy(['email' => $user->getUserIdentifier()]);
        $blog = $blogRepository->find($id);
        
        $comment = new Comment();
        $comment->setBbid($blog);
        $comment->setIduscomm($user);
        $commentForm = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('app_front_blog_show', ['id' => $blog->getId()]),
        ]);
        $commentForm->remove('bbid');
        $commentForm->remove('iduscomm');
        $commentForm->handleRequest($request);
        
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $commentRepository->save($comment, true);

            $this->getDoctrine()->getManager()->flush();
    
            return $this->redirectToRoute('app_front_blog_show', ['id' => $blog->getId()], Response::HTTP_SEE_OTHER);
        }
        if (!$blog) {
            throw $this->createNotFoundException('The blog does not exist.');
        }
       /* $commentForm = $this->createForm(CommentType::class);
        return $this->render('blog/show_front.html.twig', [
            'blog' => $blog,
            'commentForm' => $commentForm->createView(),
        ]);*/
        return $this->render('blog/show_front.html.twig', [
            'blog' => $blog,
            'commentForm' => $commentForm->createView(),
            
        ]);
    }


    #[Route('/{id}/edit', name: 'app_blog_edit')]
    function updateblog(Request $request, ManagerRegistry $doctrine, Blog $blog): Response
    {
        $fichier = "null";
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->IsSubmitted()) {
            $image = $form->get('image')->getData();

            // On boucle sur les images
            foreach ($image as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
            }
            // On stocke l'image dans la base de données (son nom)
            $blog->setImage($fichier);
            $em = $doctrine->getManager();
            //persist=ajouter
            $em->persist($blog);
            //flush=push
            $em->flush();
            return $this->redirectToRoute('showblog', []);
        }
        return $this->renderForm('blog/edit.html.twig', [
            'blog' => $form,

        ]);
    }

    #[Route('/{id}/delete', name: 'app_blog_delete', methods: ['POST'])]

    function deleteblog(Blog $blog, BlogRepository $blogRepository, Request $request,): Response
    {
        if ($this->isCsrfTokenValid('delete' . $blog->getId(), $request->request->get('_token'))) {
            $blogRepository->remove($blog, true);
        }
        return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    }
}
