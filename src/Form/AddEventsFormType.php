<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Games;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEventsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('observation', TextareaType::class, [
                'label' => 'Observation',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('nb_player', IntegerType::class, [
                'label' => 'Nombre joueur',
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('game', EntityType::class, [
                'class' => Games::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'label' => 'Sélectionner un jeu',
                'placeholder' => '',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
