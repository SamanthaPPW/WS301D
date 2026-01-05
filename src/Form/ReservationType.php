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
        $raceChoices = $options['race_choices'] ?? [];
        $allCreneaux = $options['all_creneaux'] ?? [];

        $builder
            ->add('nom_proprio', TextType::class, [
                'label' => 'Nom complet du propriétaire',
                'required' => true
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone portable du propriétaire',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du propriétaire',
                'required' => true
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse postale',
                'required' => true
            ])
            ->add('code_postal', TextType::class, [
                'label' => 'Code postal',
                'required' => true
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => true
            ])
            ->add('nom_animal', TextType::class, [
                'label' => 'Nom de votre animal',
                'required' => false
            ])
            ->add('animal', ChoiceType::class, [
                'label' => 'Type d’animal',
                'choices' => [
                    'Chien' => 'Chien',
                    'Chat' => 'Chat',
                    'Lapin' => 'Lapin'
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true
            ])
            ->add('race', ChoiceType::class, [
                'label' => "Race de l'animal",
                'choices' => $raceChoices,
                'required' => true
            ])
            ->add('comportement_animal', TextareaType::class, [
                'label' => 'Comportement de l’animal',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex : calme, joueur, craintif…'
                ]
            ])
            ->add('creneau_date', DateType::class, [
                'label' => 'Date souhaitée',
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('creneau_heure', ChoiceType::class, [
                'label' => 'Créneau horaire',
                'choices' => array_merge(...array_values($allCreneaux)),
                'placeholder' => 'Sélectionner un créneau',
                'required' => true
            ])
            ->add('commentaires', TextareaType::class, [
                'label' => 'Commentaires',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Informations supplémentaires (allergies, habitudes, etc.)'
                ]
            ])
            ->add('prestation', ChoiceType::class, [
                'label' => 'Choix des prestations',
                'choices' => [
                    'Toilettage complet' => 'toilettage_complet',
                    'Tonte avec bain' => 'tonte_bain',
                    'Tonte classique' => 'tonte_classique',
                    'Coupe aux ciseaux avec bain' => 'ciseaux_bain',
                    'Coupe aux ciseaux' => 'ciseaux',
                    'Bain avec peignage' => 'bain_peignage',
                    'Bain seul' => 'bain',
                    'Peignage' => 'peignage'
                ],
                'placeholder' => 'Sélectionner',
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer la réservation'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
            'race_choices' => [],
            'all_creneaux' => []
        ]);
    }
}
