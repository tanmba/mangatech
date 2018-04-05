<?php

namespace App\Controller;

use App\Entity\Copy;
use App\Form\CollectionType;
use App\Repository\CopyRepository;
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
            'mangas' => $mangas,
        ]);
    }

    /**
     * @Route("/manga/{id}", name="manga")
     */
    public function manga(CopyRepository $copyRepository, MangasRepository $mangasRepository, $id)
    {
        $mangas = $mangasRepository->find($id);
        $user = $this->getUser();
        $userId = $user->getId();
        $userCopies = $copyRepository->getUserCopies($userId);

        return $this->render('mangas/manga.html.twig', [
            'mangas' => $mangas,
            'userCopies' => $userCopies,
        ]);
    }

    /**
     * @Route("/userList/{id}", name="userList")
     */
    public function collection(CopyRepository $copyRepository, $id)
    {
        $mangaCopies = $copyRepository->getMangasCopies($id);
        return $this->render('mangas/userList.html.twig', [
            'mangaCopies' => $mangaCopies
        ]);
    }


    /**
     * @Route("/addCollection/{id}", name="addCollection")
     * @param Request $request
     * @param Mangas $mangas
     * @param ObjectManager $manager
     * @return int|string
     */
   public function addMangasAction(Request $request, Mangas $mangas, ObjectManager $manager, $id, CopyRepository $copyRepository) {

       $entityManager = $this->getDoctrine()->getManager();
       $user = $this->getUser();
       $userId = $user->getId();
           /** @var Mangas $mangas */
           $mangas = $entityManager->getRepository(Mangas::class)->find($id);
           $copy = new Copy();
           $copy->setUser($user);
           $copy->setManga($mangas);
           $entityManager->persist($copy);
           $entityManager->flush();

       $userCopies = $copyRepository->getUserCopies($userId);
       return $this->render('user/collection.html.twig', [
           'userCopies' => $userCopies
       ]);
   }

    /**
     * @Route("/borrow/{id_copy}", name="borrow")
     * @param ObjectManager $manager
     * @return int|string
     */
   public function Borrow(Request $request, $id_copy, ObjectManager $manager, CopyRepository $copyRepository, \Swift_Mailer $mailer) {


       $entityManager = $this->getDoctrine()->getManager();
       $copy=$copyRepository->find($id_copy);
       $user=$this->getUser();

       $copy->setBorrowedBy($this->getUser());
       $entityManager->persist($copy);
       $entityManager->flush();

       $data = (object) $user->getEmail();

       $message = (new \Swift_Message('Hello Email'))
           ->setFrom('projetmangatech@gmail.com')
           ->setTo($data)
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

       return $this->render('user/collection.html.twig', [
           'userCopies' => $copy
       ]);
   }

    /**
     * @Route("/removeManga/{id}", name="removeManga")
     * @param Request $request
     * @param Mangas $mangas
     * @param ObjectManager $manager
     * @return int|string
     */
   public function removeMangaAction(Request $request, $id, CopyRepository $copyRepository) {

       $entityManager = $this->getDoctrine()->getManager();
       $user = $this->getUser();
       $userId = $user->getId();
       $copy = $copyRepository->getByUserAndManga($userId, $id);
       $entityManager->remove($copy);
       $entityManager->flush();

       $userCopies = $copyRepository->getUserCopies($userId);
       return $this->render('user/collection.html.twig', [
           'userCopies' => $userCopies
       ]);
   }

    /**
     * @Route("/removeManga/{id}", name="removeManga")
     * @param Request $request
     * @param Mangas $mangas
     * @param ObjectManager $manager
     * @return int|string
     */
/*   public function BorrowMangas(Request $request, $userId, $id, CopyRepository $copyRepository) {

       $entityManager = $this->getDoctrine()->getManager();
       $copy = $copyRepository->getByUserAndManga($userId, $id);
       $entityManager->remove($copy);
       $entityManager->flush();

       $userCopies = $copyRepository->getUserCopies($userId);
       return $this->render('user/collection.html.twig', [
           'userCopies' => $userCopies
       ]);
   }*/

    /**
     * @Route("/addmanga", name="addmanga")
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

        return $this->render('mangas/addManga.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    /**
     * @Route("/updatemanga/{id}", name="updatemanga")
     */
    public function updateManga(Request $request, CopyRepository $mangasRepository, $id)
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
