<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CopyController extends Controller
{
    /**
     * @Route("/copy", name="copy")
     */
    public function index()
    {
        return $this->render('copy/index.html.twig', [
            'controller_name' => 'CopyController',
        ]);
    }
}
