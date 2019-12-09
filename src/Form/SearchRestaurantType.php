<?php

namespace App\Form;

use App\Repository\RestaurantRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchRestaurantType extends AbstractType
{
    const NAME = 'name';
    const TYPE = 'type';

    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository  = $restaurantRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add(self::NAME, SearchType::class, ['label' => false,
                'required' => false])
            ->add(self::TYPE, ChoiceType::class, [
                'choices' => $this->restaurantRepository->findType(),
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
                'required' => false,
                'placeholder' => '',
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method'=> 'get',
            'csrf_protection'=> false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}