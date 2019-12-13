<?php

namespace App\Form;

use App\Entity\Caracteristic;
use App\Entity\Paiement;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class , [
                'choices'=> [
                    'Fast Food' => 'Fast Food',
                    'Asiatique' => 'Asiatique',
                    'Indien' => 'Indien',
                    'Grill' => 'Grill',
                    'Mexicain' => 'Mexicain',
                    'Cafétéria' => 'Cafétéria',
                    'Pizzeria' => 'Pizzeria',
                    'Grec' => 'Grec',
                    'Autre' => 'Autre',]
                ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('site')
            ->add('caracteristics', EntityType::class, [
                'class' => Caracteristic::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('paiements', EntityType::class, [
                'class' => Paiement::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('pictures', HiddenType::class)
            ->add('cost', ChoiceType::class,[
                'choices'=>[
                    '€' => '€',
                    '€-€€' => '€-€€',
                    '€€-€€€' => '€€-€€€',
                    '€€€' => '€€€',
                ]
            ])
            ->add('phone')
            ->add('openingTime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
