<?php

namespace App\Form;

use App\Entity\Mangas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('cover', FileType::class)
            ->add('synopsis')
            ->add('genre')
            ->add('availability', ChoiceType::class, array(
                'choices'  => array(
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ),
            ))
            ->add('updatedAt', ChoiceType::class, array(
                'choices' => array(
                    'now' => new \DateTime('now'),
                    'tomorrow' => new \DateTime('+1 day'),
                    '1 week' => new \DateTime('+1 week'),
                    '1 month' => new \DateTime('+1 month'),
                ),
                'preferred_choices' => function ($value, $key) {
                    // prefer options within 3 days
                    return $value <= new \DateTime('+3 days');
                },
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mangas::class,
        ]);
    }
}
