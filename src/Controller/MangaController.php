<?php

namespace App\Controller;

use App\Form\CollectionType;
use App\Repository\MangasRepository;
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

        return $this->render('mangas/manga.html.twig', [
            'controller_name' => 'MangaController',
            'mangas' => $mangas,
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
