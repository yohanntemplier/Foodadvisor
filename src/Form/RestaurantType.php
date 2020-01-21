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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
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
            ->add('pictureFiles', FileType::class, [
                'required' => false,
                'multiple' => true
            ])
            ->add('cost', ChoiceType::class,[
                'choices'=>[
                    '€' => '€',
                    '€€' => '€€',
                    '€€€' => '€€€',
                    '€€€€' => '€€€€',
                ]
            ])
            ->add('phone')
            ->add('openingTime', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
