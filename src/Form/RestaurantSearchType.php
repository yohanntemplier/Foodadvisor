<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                'label' => false,
                'required' => false,
            ])
            ->add('type', ChoiceType::class , [
                'label' => false,
                'required' => false,
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
            ->add('cost',ChoiceType::class,[
                'label' => false,
                'required' => false,
                'choices'=>[
                    '€' => '€',
                    '€-€€' => '€-€€',
                    '€€-€€€' => '€€-€€€',
                    '€€€' => '€€€',
                ]
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('address', null,[
                'label' => false,
                'required' => false,
            ])
            ->add('distance', ChoiceType::class,[
                'label' => false,
                'required' => false,
                'choices'=> [
                    '10Km' => 10,
                    '30Km' => 30,
                    '50Km' => 50,
                    '100Km' => 100
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RestaurantSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
