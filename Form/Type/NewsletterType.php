<?php

namespace AW\NewsletterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NewsletterType.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class NewsletterType extends AbstractType
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email()
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'aw_newsletter';
    }
}
