<?php
namespace Drupal\ashique_simple_form\Form;
use Drupal\Core\Form\FormBase; 
use Drupal\Core\Form\FormStateInterface;

/**
* 
*/
class SimpleForm extends FormBase
{
	public function getFormId()
	{
		return 'ashique_simple_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state)
	{
		$form['credit_card_name'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Credit card name:')
		];

		$form['credit_card_number'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Credit card number:')
		];
		
		$form['credit_card_cvv'] = [
			'#type' => 'textfield',
			'#title' => $this->t('CVV:')
		];

		$form['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Calculate')
		];

		return $form;
	}

	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		$f_value = $form_state->getValue('number_1');
		$s_value = $form_state->getValue('number_2');

		drupal_set_message($f_value+$s_value);
	}
}