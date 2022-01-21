<?php

namespace App\Controller;
use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartementController extends AbstractController
{
    /**
     * @Route("/departement/{departement}", name="departement")
     */
    public function index(string $departement, CallApiService $callApiService): Response
    {
        //dd($callApiService->getDepartementData($departement));
        return $this->render('departement/index.html.twig', [
            'data' => $callApiService->getDepartementData($departement),
        ]);
    }
}
