<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('pictures', HiddenType::class)
            ->add('cost', ChoiceType::class,[
                'choices'=>[
                    '€' => '€',
                    '€-€€' => '€-€€',
                    '€€-€€€' => '€€-€€€',
                    '€€€' => '€€€',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
