<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,[
                'label' => false,
                'choices' => [
                    'Demande d\'ajout d\'un restaurant' => 'Demande d\'ajout d\'un restaurant',
                    'Contacter l\'administrateur' => 'Contacter l\'administrateur',
                    'Autre' => 'Autre',
                ]
            ])
            ->add('firstname', TextType::class , [
                'label' => false,
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
            ])
            ->add('email', TextType::class, [
                'label' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }

}