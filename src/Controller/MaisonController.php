<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Form\MaisonType;
use App\Repository\MaisonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('admin/maison/create', name: 'admin_maison_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $house = new Maison(); // création d'une nouvelle maison
        $form = $this->createForm(MaisonType::class, $house); // création du formulaire avec en paramètre la nouvelle maison
        $form->handleRequest($request); // gestionnaire de requêtes HTTP
        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg1 = $form['img1']->getData(); // récupère les informations de l'image 1
            $extensionImg1 = $infoImg1->guessExtension(); // récupère l'extension de fichier de l'image 1
            $nomImg1 = time() . '-1.' . $extensionImg1; // reconstitue un nom d'image unique pour l'image 1
            $infoImg1->move($this->getParameter('house_pictures_directory'), $nomImg1); // déplace l'image 1 dans le dossier adéquat
            $house->setImg1($nomImg1); // définit le nom de l'iamge 2 à mettre en base de données
            $infoImg2 = $form['img2']->getData();
            if ($infoImg2 !== null) {
                $extensionImg2 = $infoImg2->guessExtension(); // récupère les informations de l'image 2
                $nomImg2 = time() . '-2.' . $extensionImg2; // reconstitue un nom d'image unique pour l'image 2
                $infoImg2->move($this->getParameter('house_pictures_directory'), $nomImg2); // déplace l'image 2 dans le dossier adéquat
                $house->setImg2($nomImg2); // définit le nom de l'iamge 2 à mettre en base de données
            }
            $manager = $managerRegistry->getManager(); // récupère le manager de Doctrine
            $manager->persist($house); // dit à Doctrine qu'on va vouloir sauvegarder en bdd
            $manager->flush(); // exécute la requête
            return $this->redirectToRoute('admin_maisons');
        }

        return $this->render('admin/maisonForm.html.twig', [
            'formulaire' => $form->createView() // création de la vue du formulaire et envoi à la vue (fichier)
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
