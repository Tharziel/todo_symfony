<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints'=>[
                    new NotBlank([
                        'message' => 'Veuillez saisir une catégorie'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 70,
                        'minMessage' => 'Votre catégorie doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre catégorie ne doit pas contenir plus de {{ limit }} caractères.'
                        ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
