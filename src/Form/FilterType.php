<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isDone', ChoiceType::class, [
                'choices'  => [
                    'Yes' => true,
                    'No' => false
                    
                ],          
                //'attr' => ['class' => 'prout'],
                'mapped' => false,
                'required' => false
                
                
            ])
            ->add('category', EntityType::class, [
                'class' =>Category::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('createdAt', ChoiceType::class, [
                'choices'  => [
                    'ASC' => true,
                    'DESC' => false
                    
                ],

            ])
            ->add('send', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
