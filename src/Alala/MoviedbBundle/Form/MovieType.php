<?php

namespace Alala\MoviedbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MovieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tmdbId')
            ->add('title', TextType::class)
            ->add('year', DateType::class)
            ->add('description', TextareaType::class)
            ->add('moviePeoples', CollectionType::class, [
                'entry_type' => MoviePeoplesType::class,
                'entry_options' =>[
                    'label' => false,
                    'required' => false
                ],
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alala\MoviedbBundle\Entity\Movie'
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
