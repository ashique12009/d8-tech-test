<?php

namespace Drupal\ashique_simple_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class ModuleConfigurationForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'ashique_simple_form_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'ashique_simple_form.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('ashique_simple_form.settings');
        $form['email_address'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Email Address:'),
            '#default_value' => $config->get('email_address'),
        ];
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        $this->config('ashique_simple_form.settings')
            ->set('email_address', $values['email_address'])
            ->save();
        parent::submitForm($form, $form_state);
    }

}
