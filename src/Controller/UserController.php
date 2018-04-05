<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CollectionType;
use App\Form\ConnectionType;
use App\Repository\CopyRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function profile(UserRepository $userRepository, CopyRepository $copyRepository)
    {
        $user = $this->getUser();

        $userId = $user->getId();

        $userCopies = $copyRepository->getUserCopies($userId);

        return $this->render('user/profile.html.twig', [
            'copies' => $userCopies,
        ]);
    }

    /**
     * @Route("/collection", name="collection")
     */
    public function collection(UserRepository $userRepository, CopyRepository $copyRepository)
    {
        $user = $this->getUser();

        $userId = $user->getId();

        $userCopies = $copyRepository->getUserCopies($userId);


        return $this->render('user/collection.html.twig', [
            'userCopies' => $userCopies,
        ]);
    }

    /**
     * @Route("/form", name="form")
     */
    public function newConnection(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
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

            $data = (object) $form->getData();

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('projetmangatech@gmail.com')
                ->setTo($data->getEmail())
                ->setBody( $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig'
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

            return $this->redirectToRoute('login');


        }
        return $this->render('user/connect.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/form/add", name="formAdd")
     */
    public function addConnection(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {

        $connection = $this->getUser();
        $form = $this->createForm(ConnectionType::class, $connection);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($connection, $connection->getPlainPassword());
            $connection->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($connection);
            $entityManager->flush();

            $data = (object) $form->getData();

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('projetmangatech@gmail.com')
                ->setTo($data->getEmail())
                ->setBody( $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig'
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

            return $this->redirectToRoute('login');


        }
        return $this->render('user/addConnect.html.twig',
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
