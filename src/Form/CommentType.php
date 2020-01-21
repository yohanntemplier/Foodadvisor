<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('note', ChoiceType::class, [
                'choices'=>['1'=>'1', '2'=>'2', '3'=>'3', '4'=> '4', '5'=> '5'],
                'expanded' => false,
                'multiple'=> false,
                'required'=> false,
                'label' => false,
                'label_attr'=>[
                    'class'=>'radio-inline'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'translation_domain' => 'forms'
        ]);
    }
}
