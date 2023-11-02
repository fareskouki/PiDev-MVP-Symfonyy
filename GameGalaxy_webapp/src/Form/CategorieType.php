<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    private static $typeChoices = [
        '+5ans' => '+5ans',
        '+12ans' => '+12ans',
        '+16ans' => '+16ans',
    ];

   

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_categorie')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Enabled' => 1,
                    'Disabled' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => self::$typeChoices,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
