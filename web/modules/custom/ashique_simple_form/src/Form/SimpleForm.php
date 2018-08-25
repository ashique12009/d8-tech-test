<?php
namespace Drupal\ashique_simple_form\Form;
use Drupal\Core\Form\FormBase; 
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;

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
			'#value' => $this->t('Submit')
		];

		return $form;
	}

	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		$credit_card_name = $form_state->getValue('credit_card_name');
		$credit_card_number = $form_state->getValue('credit_card_number');
		$credit_card_cvv = $form_state->getValue('credit_card_cvv');
		if ( $credit_card_name == '' ) {
			drupal_set_message(t('Credit card name cannot be empty!'), 'error');
		}
		elseif ( strlen($credit_card_number) < 16 ) {
			drupal_set_message(t('Credit card number must 16 digit number!'), 'error');
		}
		elseif ( strlen($credit_card_cvv) < 3 ) {
			drupal_set_message(t('CVV must 3 digit number!'), 'error');
		}
		else {
			// send email now
			$config = \Drupal::config('ashique_simple_form.settings');
    		$email = $config->get('email_address');

			$mailManager = \Drupal::service('plugin.manager.mail');

			$module = 'ashique_simple_form';
			$key = 'all';
			$to = $email;
			$message = '';
			$message .= 'Credit card name:' . $credit_card_name;
			$message .= ' Credit card number:' . $credit_card_number;
			$message .= ' Cvv:' . $credit_card_cvv;
			$params['message'] = $message;
			$langcode = \Drupal::currentUser()->getPreferredLangcode();
			$send = true;
			$result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
			if ( $result['result'] !== true ) {
				drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
			}
			else {
				drupal_set_message(t('Your message has been sent.'));
			}
		}
	}
}