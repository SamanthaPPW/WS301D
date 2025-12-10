<?php
namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType, TelType, EmailType, ChoiceType, DateType, TextareaType, SubmitType
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Toutes les races possibles (Symfony doit connaître les choix)
        $raceChoices = $options['race_choices'] ?? [];

        $builder
            ->add('nom_proprio', TextType::class, ['label' => 'Nom complet du propriétaire'])
            ->add('telephone', TelType::class, ['label' => 'Téléphone'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('adresse', TextType::class, ['label' => 'Adresse'])
            ->add('code_postal', TextType::class, ['label' => 'Code postal'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('nom_animal', TextType::class, ['label' => 'Nom de votre animal', 'required' => false])
            ->add('animal', ChoiceType::class, [
                'label' => 'Type d’animal',
                'choices' => [
                    'Chien' => 'chien',
                    'Chat' => 'chat',
                    'Lapin' => 'lapin',
                    'Autre' => 'autre'
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('race', ChoiceType::class, [
                'label' => 'Race',
                'choices' => $raceChoices,
                'required' => false,
                'expanded' => false,
            ])
            ->add('comportement_animal', TextareaType::class, [
                'label' => 'Comportement de l’animal',
                'required' => false
            ])
            ->add('creneau_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date souhaitée',
            ])
            ->add('creneau_heure', ChoiceType::class, [
                'label' => 'Créneau horaire',
                'choices' => [], // rempli dynamiquement via JS
                'required' => true
            ])


            ->add('commentaires', TextareaType::class, [
                'label' => 'Commentaires',
                'required' => false
            ])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer la réservation']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
            'race_choices' => [], // Pour passer dynamiquement via le controller
        ]);
    }
}
