<?php
  class Validator{

    protected $errorHandler;
    protected $rules = ['required', 'minlength', 'maxlength', 'email'];

    public $messages = [
      'required' => 'The :field field is required',
      'minlength' => 'The :field field must be a minimum of :satisfier length',
      'maxlength' => 'The :field field must be a maximum of :satisfier length',
      'email' => 'That is not a valid email address',

    ];

    public function __construct(ErrorHandler $errorHandler){
      $this->errorHandler = $errorHandler;
    }

    // $rules came from protected variable

    public function check($items, $rules){
      foreach($items as $item => $value){

       if(in_array($item, array_keys($rules))){
         $this->validate([
          'field' => $item,
          'value' => $value,
          'rules' => $rules[$item]
         ]);
       }

      }

      return $this; //So you can chain on methods like errors
    }

    protected function validate ($item){
      $field = $item['field'];

      //if rulename is required then it will call it inside here

      foreach($item['rules'] as $rule => $satisfier){
        // calling the rules by looping
        if(in_array($rule, $this->rules)){
          //For each of these methods, itll return true or false
          //If first rule is required, itll call the rule function

          //This takes an error string
          if(!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfier])){
            $this->errorHandler->addError(
              //replaces the placeholders
              str_replace([':field', ':satisfier'],[$field, $satisfier] , $this->messages[$rule]),
              $field
            );
          }
        }     
      }
    }

    public function fails(){
      return $this->errorHandler->hasErrors();
    }

    public function errors(){
      return $this->errorHandler;
    }
 
    //Checking if value is not empty
    protected function required($field, $value, $satisfier){
      return !empty(trim($value));
      
    }

    protected function minlength($field, $value, $satisfier){
      return mb_strlen($value) >= $satisfier;

    }

    protected function maxlength($field, $value, $satisfier){
      return mb_strlen($value) <= $satisfier;
      
    }

    protected function email($field, $value, $satisfier){
      return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
  }
