<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Entity\Inscription;
use App\Entity\Notification;
use App\Entity\Organisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tittre')
            ->add('description')
            ->add('lieu')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('capacite')
            ->add('programme')
            ->add('organisteur_id', EntityType::class, [
                'class' => Organisateur::class,
                'choice_label' => 'id',
            ])
            ->add('notification', EntityType::class, [
                'class' => Notification::class,
                'choice_label' => 'id',
            ])
            ->add('inscription', EntityType::class, [
                'class' => Inscription::class,
                'choice_label' => 'id',
            ])
            ->add('commentaire', EntityType::class, [
                'class' => Commentaire::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
