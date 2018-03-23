<?php

namespace App\Controller;

use App\Repository\MangasRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Mangas;

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

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('profile.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/mangalist", name="mangalist")
     */
    public function mangalist(MangasRepository $mangasRepository)
    {
        $mangas = $mangasRepository->findAll();

        return $this->render('mangalist.html.twig', [
            'controller_name' => 'BlogController',
            'mangas' => $mangas,
        ]);
    }

    /**
     * @Route("/manga", name="manga")
     */
    public function manga(MangasRepository $mangasRepository)
    {
        $mangas = $mangasRepository->findAll();

        return $this->render('manga.html.twig', [
            'controller_name' => 'BlogController',
            'mangas' => $mangas,
        ]);
    }
}
