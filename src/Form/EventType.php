<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('startTime', TimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endTime', TimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('location')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Upcoming' => 'Upcoming',
                    'Ongoing' => 'Ongoing',
                    'Completed' => 'Completed',
                    'Postponed' => 'Postponed',
                ],
                'data' => 'Upcoming', // default value
            ])
            ->add('image', FileType::class, [
                'label' => 'Event Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('club', EntityType::class, [
                'class' => Club::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}