<?php

namespace App\Form;

use App\Entity\Work;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', SearchType::class, [
                'required' => false,
                'mapped' => false
            ])
            /*&
            ->add('title')
            ->add('longTitle')
            ->add('shortTitle')
            ->add('source')
            ->add('totalWords')
            ->add('totalParagraphs')
            ->add('genreType')
            ->add('year')
            */
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Work::class,
        ]);
    }
}
