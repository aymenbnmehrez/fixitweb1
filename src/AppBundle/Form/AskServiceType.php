<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskServiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateType::class)->add('duration', ChoiceType::class, [
            'choices'  => [
                '' => '',
                '00h30min' => '00h30min',
                '01h30min' => '01h30min',
                '02h00min' => '02h00min',
                '02h30min' => '02h30min',
                '03h00min' => '03h00min',
                '03h30min' => '03h30min',
                '04h00min' => '04h0min',
                'one Day' => 'one Day',
                'two Days' => 'two Days',

            ],
        ])->add('description', TextareaType::class)
            ->add('service_name', ChoiceType::class, [
            'choices'  => [
                '' => '',
                'change a faucet' => 'change a faucet',
                'water leak repear' => 'water leak repear',

            ],
        ])->add('started_at', ChoiceType::class, [
            'choices'  => [
                '' => '',
                '08:00 GMT' => '08:00 GMT',
                '09:00 GMT' => '09:00 GMT',
                '10:00 GMT' => '10:00 GMT',
                '11:00 GMT' => '11:00 GMT',
                '12:00 GMT' => '12:00 GMT',
                '13:00 GMT' => '13:00 GMT',
                '14:00 GMT' => '14:00 GMT',
                '15:00 GMT' => '15:00 GMT',
                '16:00 GMT' => '16:00 GMT',

            ],
        ])->add('price')->add('Confirm',SubmitType::class);;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AskService'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_askservice';
    }


}
