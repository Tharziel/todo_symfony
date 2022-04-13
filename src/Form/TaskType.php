<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints'=>[
                    new NotBlank([
                        'message' => 'Veuillez saisir un titre'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 70,
                        'minMessage' => 'Votre titre doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre titre ne doit pas contenir plus de {{ limit }} caractères.'
                        ])
                ]
            ])

            ->add('content', TextType::class, [
                'constraints'=>[
                    new NotBlank([
                        'message' => 'Veuillez saisir un contenu'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre contenu doit contenir au moins {{ limit }} caractères.'
                        ])
                ]
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choix catégorie'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
