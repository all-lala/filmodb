<?php

namespace Alala\MoviedbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Alala\MoviedbBundle\Entity\Job;
use Alala\MoviedbBundle\Entity\People;

class MoviePeoplesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('people', EntityType::class, [
            'class' => People::class,
            'choice_label' => 'fullName',
            'label' => false
        ])
        ->add('job', EntityType::class, [
            'class' => Job::class,
            'choice_label' => 'libelle',
            'label' => false
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alala\MoviedbBundle\Entity\MoviePeople'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alala_moviedbbundle_movie';
    }


}
