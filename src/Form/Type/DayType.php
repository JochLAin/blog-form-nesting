<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', Type\TextType::class, [
                'label' => 'Jour de la semaine',
                'attr' => [
                    'class' => 'form-control-plaintext',
                    'readonly' => true,
                ],
            ])
            ->add('memos', Type\CollectionType::class, [
                'entry_type' => MemoType::class,
                'entry_options' => [
                    // Tips to know where we are
                    'operation' => $options['operation'],
                    'context' => $options['context'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
			])
        ;

        $builder->get('day')->addViewTransformer(new CallbackTransformer(
            fn (mixed $value) => match ($value) {
                0 => 'Lundi',
                1 => 'Mardi',
                2 => 'Mercredi',
                3 => 'Jeudi',
                4 => 'Vendredi',
                5 => 'Samedi',
                6 => 'Dimanche',
            },
            fn (mixed $value) => match ($value) {
                'Lundi' => 0,
                'Mardi' => 1,
                'Mercredi' => 2,
                'Jeudi' => 3,
                'Vendredi' => 4,
                'Samedi' => 5,
                'Dimanche' => 6,
            },
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'day';
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Tips to know where we are
            'operation' => 'create',
            'context' => $this->getName(),
        ]);
    }
}
