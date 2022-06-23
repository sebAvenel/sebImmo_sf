<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('city')
            ->add('address')
            ->add('sold')
            ->add('postal_code');
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
