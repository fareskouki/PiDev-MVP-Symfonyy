<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;

class PDFController extends AbstractController
{
    #[Route('/pdf', name: 'app_p_d_f')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PDFController',
        ]);
    }

    #[Route('/blog/{id}/pdf', name: 'generate_pdf')]
    public function generatePdf($id)
    {
        // Get the blog post from the database
        $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        // Generate the HTML content of the blog post
        $html = $this->renderView('/blog/pdf.html.twig', ['blog' => $blog]);

        // Generate the PDF file
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        // Return the PDF file as a response
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $filename = strtolower(str_replace(' ', '-', $blog->getTitle())) . '.pdf';
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
