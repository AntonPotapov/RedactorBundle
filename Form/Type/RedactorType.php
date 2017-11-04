<?php

namespace Stp\RedactorBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\FormView,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormInterface;

use Stp\RedactorBundle\Model\RedactorService;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
class RedactorType extends AbstractType
{

    /**
     * @var \Stp\RedactorBundle\Model\RedactorService
     */
    protected $redactorService;

    /**
     * @param \Stp\RedactorBundle\Model\RedactorService $redactorService
     */
    function __construct(RedactorService $redactorService)
    {
        $this->redactorService = $redactorService;
    }

    /**
     * @param OptionsResolver|OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'redactor' => false
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormView      $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array                                 $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $config = $this->redactorService->getWebConfiguration($form->getConfig()->getAttribute('redactor'));
        $view->vars['redactor_config'] = $config;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->setAttribute('redactor', $options['redactor']);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'redactor';
    }

}
