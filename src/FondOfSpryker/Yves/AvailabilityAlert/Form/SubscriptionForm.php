<?php

namespace FondOfSpryker\Yves\AvailabilityAlert\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer;

class SubscriptionForm extends AbstractType
{
    const FIELD_PRODUCT = AvailabilityAlertSubscriptionRequestTransfer::ID_PRODUCT_ABSTRACT;
    const FIELD_EMAIL = AvailabilityAlertSubscriptionRequestTransfer::EMAIL;

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'availabilityAlertSubscriptionForm';
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->addEmailField($builder)
            ->addProductField($builder);
    }


    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addEmailField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_EMAIL, EmailType::class, [
            'label' => 'availability_alert.submit.email',
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ]
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PRODUCT, HiddenType::class, [
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ]
        ]);

        return $this;
    }
}
