<?php

namespace App\Controller;

use App\Repository\MaisonRepository;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/maison-{id}', name: 'maison')]
    public function show(MaisonRepository $maisonRepository, int $id)
    {
        $house = $maisonRepository->find($id);
        return $this->render('maison/maison.html.twig', [
            'maison' => $house
        ]);
    }

    #[Route('/admin/maisons', name: 'admin_maisons')]
    public function showAllAdmin(MaisonRepository $maisonRepository)
    {
        $houses = $maisonRepository->findAll();
        return $this->render('admin/maisons.html.twig', [
            'maisons' => $houses
        ]);
    }

    #[Route('admin/maison/delete/{id}', name: 'admin_maison_delete')]
    public function delete(MaisonRepository $maisonRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $house = $maisonRepository->find($id);
        throw new \Exception('TODO: gérer la suppression des images du dossier img');
        $manager = $managerRegistry->getManager();
        $manager->remove($house);
        $manager->flush();
        return $this->redirectToRoute('admin_maisons');
    }
}
