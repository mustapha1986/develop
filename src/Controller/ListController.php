<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/companies", name="app_companies")
 */
class ListController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_companies")
     */
    public function index(): Response
    {
        // liste des ESN
        $companies = [];

        return $this->render('list/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/list", name="app_list")
     */
    public function list(): Response
    {
        // liste des ESN
        $companies = [
            'Apple' => '$1.16 trillion USD',
            'Samsung' => '$298.68 billion USD',
            'Microsoft' => '$1.10 trillion USD',
            'Alphabet' => '$878.48 billion USD',
            'Intel Corporation' => '$245.82 billion USD',
            'IBM' => '$120.03 billion USD',
            'Facebook' => '$552.39 billion USD',
            'Hon Hai Precision' => '$38.72 billion USD',
            'Tencent' => '$3.02 trillion USD',
            'Oracle' => '$180.54 billion USD',
        ];
        return $this->render('list/list.html.twig', [
            'companies' => $companies,
        ]);
    }
}
