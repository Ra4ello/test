<?php

namespace Drupal\drupalup_simple_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Our simple form class.
 */
class SimpleForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupalup_simple_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
    ];

    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
    ];

    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
    ];

     $form['number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Number of fingers on the leg'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    if(is_numeric($form_state->getValue('number')) && ($form_state->getValue('number') >= 0 && $form_state->getValue('number') <= 12)){

        $uri = 'modules/custom/drupalup_simple_form/employee_data.json'; 

        if(file_exists($uri)){

          $current_data = file_get_contents($uri);
          $array_data = json_decode($current_data,true);
          $extra = array(
            'firstname'   => $form_state->getValue('firstname'),
            'lastname'    => $form_state->getValue('lastname'),
            'Email'       => $form_state->getValue('email'),
            'number'      => $form_state->getValue('number')
             );

           $array_data[] = $extra;

           $final_data = json_encode($array_data);

          if(file_put_contents($uri,$final_data)){    
            drupal_set_message('Дані Успішно записано');
          }
        }else{
          drupal_set_message('Json файл не знайдено');
        }

      }else{
        drupal_set_message('Не коректно введені кількість пальців');
      }
  }

}
