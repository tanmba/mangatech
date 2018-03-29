<?php

namespace App\Form;

use App\Entity\Mangas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('cover')
            ->add('synopsis')
            ->add('genre')
            ->add('date_back', DateType::class)
            ->add('availability', ChoiceType::class, array(
                'choices'  => array(
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ),
            ));
        ;
        $builder->add('date_loan', DateType::Class, array(
            'widget' => 'choice',
            'years' => range(date('Y'), date('Y')+100),
            'months' => range(date('m'), 12),
            'days' => range(date('d'), 31),
        ));

        $builder->add('date_back', DateIntervalType::class, array(
//            'widget'      => 'integer', // render a text field for each part
             'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you

            // customize which text boxes are shown
            'with_years'  => false,
            'with_months' => true,
            'with_days'   => false,
            'with_hours'  => false,
            'months' => range(1, 4)
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mangas::class,
        ]);
    }
}
