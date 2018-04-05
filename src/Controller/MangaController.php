<?php

namespace App\Controller;

use App\Form\CollectionType;
use App\Repository\MangasRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Mangas;
use App\Entity\User;


class MangaController extends Controller
{
    /**
     * @Route("/mangalist", name="mangalist")
     */
    public function mangalist(MangasRepository $mangasRepository)
    {
        $mangas = $mangasRepository->findAll();

        return $this->render('mangas/mangalist.html.twig', [
            'controller_name' => 'MangaController',
            'mangas' => $mangas,
        ]);
    }

    /**
     * @Route("/manga/{id}", name="manga")
     */
    public function manga(MangasRepository $mangasRepository, $id)
    {
        $mangas = $mangasRepository->find($id);
        $user = $this->getUser();
        $userId = $user->getId();
        $userMangas = $mangasRepository->getUserMangas($userId);

        return $this->render('mangas/manga.html.twig', [
            'controller_name' => 'MangaController',
            'mangas' => $mangas,
            'userMangas' => $userMangas,
        ]);
    }

    /**
     * @Route("/removetest", name="removetest")
     */
    public function removetest(\Swift_Mailer $mailer)
    {
//        $data = (object) $user->getEmail();

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('projetmangatech@gmail.com')
            ->setTo('tanmba@icloud.com')
            ->setBody( $this->renderView(
            // templates/emails/registration.html.twig
                'emails/availability.html.twig'
            ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $mailer->send($message);

        return $this->redirectToRoute('mangalist');
    }

    /**
     * @Route("/addCollection/{id}", name="addCollection")
     * @param Request $request
     * @param Mangas $mangas
     * @param ObjectManager $manager
     * @return int|string
     */
   public function addMangasAction(Request $request, Mangas $mangas, ObjectManager $manager, $id, User $user, MangasRepository $mangasRepository, UserRepository $userRepository) {

       $entityManager = $this->getDoctrine()->getManager();
       $user = $this->getUser();
       $userId = $user->getId();
           /** @var Mangas $mangas */
           $mangas = $entityManager->getRepository(Mangas::class)->find($id);
           $user->addMangas($mangas);
           $entityManager->persist($user);
           $entityManager->flush();

       $userMangas = $mangasRepository->getUserMangas($userId);
       return $this->render('user/collection.html.twig', [
           'controller_name' => 'MangaController',
           'userMangas' => $userMangas
       ]);
   }
    /**
     * @Route("/removeManga/{id}", name="removeManga")
     * @param Request $request
     * @param Mangas $mangas
     * @param ObjectManager $manager
     * @return int|string
     */
   public function removeMangaAction(Request $request, Mangas $mangas, ObjectManager $manager, $id, User $user, MangasRepository $mangasRepository, UserRepository $userRepository) {

       $entityManager = $this->getDoctrine()->getManager();
       $user = $this->getUser();
       $userId = $user->getId();
           /** @var Mangas $mangas */
           $mangas = $entityManager->getRepository(Mangas::class)->find($id);
           $user->removeMangas($mangas);
           $entityManager->persist($user);
           $entityManager->flush();

       $userMangas = $mangasRepository->getUserMangas($userId);
       return $this->render('user/collection.html.twig', [
           'controller_name' => 'MangaController',
           'userMangas' => $userMangas
       ]);
   }

    /**
     * @Route("/addmanga", name="addmanga")
     */
    public function newMangas(Request $request)
    {
        $collection = new Mangas();
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $collection->getCover();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where cover are stored
            $file->move(
                $this->getParameter('cover_directory'),
                $fileName
            );

            // updates the 'cover' property to store the PDF file name
            // instead of its contents
            $collection->setCover($fileName);


            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collection);
            $entityManager->flush();


            return $this->redirectToRoute('mangalist');

        }

        return $this->render('mangas/addManga.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    /**
     * @Route("/updatemanga/{id}", name="updatemanga")
     */
    public function updateManga(Request $request, MangasRepository $mangasRepository, $id)
    {
        $collection = $mangasRepository->find($id);
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collection);
            $entityManager->flush();


            return $this->redirectToRoute('mangalist');

        }

        return $this->render('mangas/updatemanga.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}
