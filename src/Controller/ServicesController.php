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
        $racesJson = file_get_contents($this->getParameter('kernel.project_dir') . '/public/data/races.json');
        $racesData = json_decode($racesJson, true);

        $durations = [
            "poils_courts" => 30,
            "poils_moderes" => 60,
            "poils_longs" => 90,
            "poils_speciaux" => 120
        ];

        // Générer tous les créneaux possibles pour chaque type de poils
        $allCreneaux = [];
        foreach ($durations as $typePoils => $duration) {
            $allCreneaux[$typePoils] = $this->generateTimeOptions($duration);
        }

        $reservation = new Reservations();
        $form = $this->createForm(ReservationType::class, $reservation, [
            'race_choices' => $this->getRaceChoices($racesData),
            'all_creneaux' => $allCreneaux
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reservation);
            $em->flush();
            $this->addFlash('success', 'Réservation enregistrée avec succès !');
            return $this->redirectToRoute('app_reservation_show', ['id' => $reservation->getId()]);
        }


        return $this->render('services/index.html.twig', [
            'form' => $form->createView(),
            'racesData' => $racesData,
            'allCreneaux' => $allCreneaux
        ]);
    }

    #[Route('/reservation/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('services/show.html.twig', [
            'reservation' => $reservation
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

    private function generateTimeOptions(int $duration): array
    {
        $options = [];

        // Plages horaires : matin et après-midi
        $timeRanges = [
            ['startHour' => 8, 'startMin' => 30, 'endHour' => 13, 'endMin' => 0],
            ['startHour' => 14, 'startMin' => 30, 'endHour' => 19, 'endMin' => 0],
        ];

        foreach ($timeRanges as $range) {
            $hour = $range['startHour'];
            $min = $range['startMin'];

            while (true) {
                $start = str_pad($hour,2,'0',STR_PAD_LEFT) . ':' . str_pad($min,2,'0',STR_PAD_LEFT);

                // Calculer la fin du créneau
                $totalMin = $hour*60 + $min + $duration;
                $endHour = intdiv($totalMin, 60);
                $endMin = $totalMin % 60;

                // Stop si on dépasse la fin de la plage
                if ($endHour > $range['endHour'] || ($endHour == $range['endHour'] && $endMin > $range['endMin'])) break;

                $end = str_pad($endHour,2,'0',STR_PAD_LEFT) . ':' . str_pad($endMin,2,'0',STR_PAD_LEFT);

                $options[] = "$start - $end";

                // Incrémenter de 30 minutes pour le prochain créneau
                $min += 30;
                if ($min >= 60) {
                    $hour++;
                    $min = $min % 60;
                }
            }
        }

        return $options;
    }


}
