<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control py-2',
                    'placeholder' => 'Enter your email'
                ],
                'label' => 'Email'
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control py-2',
                    'placeholder' => 'Enter your password'
                ],
                'label' => 'Password'
            ])
            ->add('remember_me', CheckboxType::class, [
                'required' => false,
                'label' => 'Remember me',
                'mapped' => false,
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign in',
                'attr' => [
                    'class' => 'btn w-100 py-2 rounded-3 text-white',
                    'style' => 'background-color: #6c5ce7;'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => false,
        ]);
    }
}