<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   $builder
        ->add('description',TextareaType::class)
        ->add('provider')
        ->add('id',EntityType::class,array('class'=>'AppBundle:Categoryt','choice_label'=>'CategoryName','multiple'=>false))
        ->add('image',FileType::class,[
            // unmapped means that this field is not associated to any entity property
            'required' => false])
        ->add('Ajouter',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);    }
        /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
