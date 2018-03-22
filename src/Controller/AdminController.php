<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index_admin()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
//    /**
//     * @Route("/", name="profile")
//     */
//    public function profile()
//    {
//        return $this->render('blog/index.html.twig', [
//            'controller_name' => 'AdminController',
//        ]);
//    }
}
