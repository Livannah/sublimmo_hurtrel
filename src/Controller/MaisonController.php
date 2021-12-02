<?php

namespace App\Controller;

use App\Repository\MaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaisonController extends AbstractController
{
    #[Route('/maisons', name: 'maisons')]
    public function showAll(MaisonRepository $maisonRepository): Response
    {
        $houses = $maisonRepository->findAll();
        return $this->render('maison/maisons.html.twig', [
            'maisons' => $houses,
        ]);
    }
}
