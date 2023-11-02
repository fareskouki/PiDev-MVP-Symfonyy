<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlogRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BlogJsonController extends AbstractController
{
    

    #[Route('/addblogJSON', name:'addblogJSON', methods:['GET','POST'])]
    function addblogJSON(Request $request)
        {
        $blog = new Blog();
        $title = $request->query->get('title');
        $content = $request->query->get('content');
        $image = $request->query->get('image');
    
        $blog->setTitle($title);
        $blog->setContent($content);
        $blog->setImage($image);
    
        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($blog);
        return new JsonResponse($formatted);
    }
    

#[Route('/showblogJSON', name:'showblogJSON', methods:['GET'])]
function showblogJSON(BlogRepository $blogRepository, SerializerInterface $serializer): JsonResponse
    {
    $repository= $this->getDoctrine()->getRepository(blog::class);
    $blogs = $blogRepository->findAll();
    $json = $serializer->serialize($blogs, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        },
        'attributes' => ['id', 'title', 'content', 'image'],
    ]);

    return new JsonResponse($json, Response::HTTP_OK, [], true);
}

#[Route('/deleteblogJSON/{id}', name:'deleteblogJSON', methods:['DELETE'])]
function deleteBlogJSON(Request $request, Blog $blog): JsonResponse
    {
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($blog);
    $entityManager->flush();

    $data = [
        'status' => 200,
        'message' => 'Blog has been deleted',
    ];

    return new JsonResponse($data);
}

#[Route('/updateblogJSON/{id}', name:'updateblogJSON', methods:['PUT', 'GET'])]
function updateBlogJSON(Request $request, Blog $blog): JsonResponse
    {
        $title = $request->query->get('title');
        $content = $request->query->get('content');
        $image = $request->query->get('image');
    
        $blog->setTitle($title);
        $blog->setContent($content);
        $blog->setImage($image);
    
        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);
        $em->flush();
    
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($blog);
    
        return new JsonResponse($formatted);
}

}
