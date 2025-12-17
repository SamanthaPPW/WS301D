<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Races
        $racesData = json_decode(
            file_get_contents($this->getParameter('kernel.project_dir') . '/public/data/races.json'),
            true
        );

        // Créneaux (JSON)
        $allCreneaux = json_decode(
            file_get_contents($this->getParameter('kernel.project_dir') . '/public/data/allcreneaux.json'),
            true
        );

        // Prix
        $prixParPoils = json_decode(
            file_get_contents($this->getParameter('kernel.project_dir') . '/public/data/prix.json'),
            true
        );

        // Formulaire
        $reservation = new Reservations();
        $form = $this->createForm(ReservationType::class, $reservation, [
            'race_choices' => $this->getRaceChoices($racesData),
            'all_creneaux' => $allCreneaux
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reservation);
            $em->flush();

            return $this->redirectToRoute('app_reservation_show', [
                'id' => $reservation->getId()
            ]);
        }

        return $this->render('services/index.html.twig', [
            'form' => $form->createView(),
            'racesData' => $racesData,
            'allCreneaux' => $allCreneaux,
            'prixParPoils' => $prixParPoils
        ]);
    }

    private function getRaceChoices(array $racesData): array
    {
        $choices = [];

        foreach ($racesData as $animal => $races) {
            foreach ($races as $race => $typePoils) {
                $choices[$race] = $race;
            }
        }

        return $choices;
    }

    #[Route('/reservation/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('services/show.html.twig', [
            'reservation' => $reservation
        ]);
    }


}
