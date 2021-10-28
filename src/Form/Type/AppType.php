<?php

namespace App\Form\Type;

use App\Form\DataTransformer\AppModelTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppType extends AbstractType
{
    public function __construct(
        private AppModelTransformer $modelTransformer,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->modelTransformer);

        $builder->add('days', Type\CollectionType::class, [
            'entry_type' => DayType::class,
            'entry_options' => [
                // Tips to know where we are
                'operation' => $options['operation'],
                'context' => $options['context'],
            ],
            'allow_add' => false,
            'allow_delete' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'app';
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
