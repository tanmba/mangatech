<?php

namespace App\Controller;

use App\Entity\Mangas;
use App\Entity\User;
use App\Form\CollectionType;
use App\Form\ConnectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/c", name="home")
     */
    public function newMangas(Request $request)
    {
        $collection = new Mangas();
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collection);
            $entityManager->flush();

            return $this->redirectToRoute('mangalist');

        }
        return $this->render('home.html.twig',
            [
                'form' => $form->createView()
            ]);
    }


    /**
     * @Route("/form", name="form")
     */
    public function newConnection(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $connection = new User();
        $form = $this->createForm(ConnectionType::class, $connection);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($connection, $connection->getPlainPassword());
            $connection->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($connection);
            $entityManager->flush();

            return $this->redirectToRoute('login');

        }
        return $this->render('connect.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
}
