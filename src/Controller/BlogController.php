<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/profile/blog", name="blog")
     */
    public function index()
    {
        return $this->render('test.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
