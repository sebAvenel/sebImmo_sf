<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use PhpParser\Parser\Multiple;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getHeatChoices()
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'select2options']

            ])
            ->add('city')
            ->add('address')
            ->add('sold')
            ->add('postal_code')
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Image à la une',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    private function getHeatChoices(): array
    {
        $heatArray = Property::HEAT;
        $heatArrayFlip = array_flip($heatArray);

        return $heatArrayFlip;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
