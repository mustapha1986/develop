<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
use App\Repository\AdressRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/adress")
 */
class AdressController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @Route("/", name="app_adress_index", methods={"GET"})
     */
    public function index(AdressRepository $adressRepository): Response
    {
        return $this->render('adress/index.html.twig', [
            'adresses' => $adressRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_adress_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AdressRepository $adressRepository, ValidatorInterface $validator): Response
    {
        $adress = new Adress();
        $errors = $validator->validate($adress);

        $this->logger->info('vérifier les erreurs par le validateur Symfony');
        if (count($errors) > 0) {
            $$this->logger->error('erreur généré et envoyé à la vue validation');
            $errorsString = (string)$errors;
            return $this->render('adress/validation.html.twig', [
                'errors' => $errorsString,
            ]);
        }

        $form = $this->createForm(AdressType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adressRepository->add($adress);
            return $this->redirectToRoute('app_adress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adress/new.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adress_show", methods={"GET"})
     */
    public function show(Adress $adress): Response
    {
        return $this->render('adress/show.html.twig', [
            'adress' => $adress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_adress_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Adress $adress, AdressRepository $adressRepository): Response
    {
        $form = $this->createForm(AdressType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adressRepository->add($adress);
            return $this->redirectToRoute('app_adress_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adress/edit.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adress_delete", methods={"POST"})
     */
    public function delete(Request $request, Adress $adress, AdressRepository $adressRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $adress->getId(), $request->request->get('_token'))) {
            $adressRepository->remove($adress);
        }

        return $this->redirectToRoute('app_adress_index', [], Response::HTTP_SEE_OTHER);
    }
}
