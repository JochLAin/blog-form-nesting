<?php

namespace App\Form\Type;

use App\Entity\Memo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', Type\TextType::class, [
                'label' => 'Titre du mémo',
            ])
            ->add('description', Type\TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('done', Type\CheckboxType::class, [
                'label' => 'Terminé ?',
                'required' => false,
            ])
        ;

        if ($options['context'] !== 'app') {
            $builder->add('day', Type\ChoiceType::class, [
                'label' => 'Jour de la semaine',
                'choices' => [
                    'Lundi' => 0,
                    'Mardi' => 1,
                    'Mercredi' => 2,
                    'Jeudi' => 3,
                    'Vendredi' => 4,
                    'Samedi' => 5,
                    'Dimanche' => 6,
                ],
            ]);
        }
    }

    public function getBlockPrefix(): string
    {
        return 'memo';
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Memo::class,
            // Tips to know where we are
            'operation' => 'create',
            'context' => $this->getName(),
        ]);
    }
}
