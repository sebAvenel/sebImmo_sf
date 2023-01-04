<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserRegistrationByAdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => ['attr' => ['placeholder' => 'mot de passe'], 'label' => false],
                'second_options' => ['attr' => ['placeholder' => 'Confirmation mot de passe'], 'label' => false],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'empty_data' => '',
            ))
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Rôles' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Editeur' => 'ROLE_EDITOR',
                        'Administrateur' => 'ROLE_ADMIN',
                        'Super administrateur' => 'ROLE_SUPER_ADMIN',
                    ],
                ],
            ])
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    // transform the array to a string
                    return implode(', ', $rolesAsArray);
                },
                function ($rolesAsString) {
                    // transform the string back to an array
                    return explode(', ', $rolesAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
