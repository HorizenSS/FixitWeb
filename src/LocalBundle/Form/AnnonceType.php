<?php

namespace LocalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('startdate' ,DateType::class, [
            'widget' => 'single_text',
            'required' => false

        ])
            ->add('enddate',DateType::class, [
                'widget' => 'single_text',
                'required' => false

            ])
            ->add('nom', TextType::class)
            ->add('description',TextType::class)
            ->add('prix')

            ->add('image',FileType::class, array('data_class' => null))
            ->add('type',ChoiceType::class,array(
                'choices' => array('demande'=>1, 'offre'=>0)))
            ->add('id_local')
            ->add('enregistrer',SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LocalBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'localbundle_annonce';
    }


}
