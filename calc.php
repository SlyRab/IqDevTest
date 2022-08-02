<?php

class DepositData{
    public $startDate;
    public $sum;
    public $term;
    public $percent;
    public $sumAdd;

    function __construct($date, $depositSum, $depositTerm, $depositPercent, $depositSumAdd){
        $this->startDate = $date;
        $this->sum = $depositSum;
        $this->term = $depositTerm;
        $this->percent = $depositPercent;
        $this->sumAdd = $depositSumAdd;
    }
}

class DepositPostValidator{
    private $depositData;

    function is_valid_form_request(){
        $fields = ['startDate', 'sum', 'term', 'percent', 'sumAdd'];
        $errors = [];
        $is_valid = true;
    
        foreach($fields as $field) {
            $errors[$field] = array();
    
            if(strlen($_POST[$field]) == 0){
                array_push($errors[$field], $field . " is empty");
            }
    
            if($field == "startDate"){
                if(!strtotime($_POST[$field])){
                    array_push($errors[$field], $field . " is not a date");
                }
            }
    
            if($field == "sum"){
                if(!is_numeric($_POST[$field])){
                    array_push($errors[$field], $field . " is not a numeric");
                }
                if($_POST[$field] < 1000 || $_POST[$field] > 3000000){
                    array_push($errors[$field], $field . " should be more then 1000 and less then 3000000");
                }
            }
    
            if($field == "term"){
                if(!is_numeric($_POST[$field])){
                    array_push($errors[$field], $field . " is not a numeric");
                }
                if($_POST[$field] < 1 || $_POST[$field] > 60){
                    array_push($errors[$field], $field . " should be more then 1 month and less then 5 year");
                }
            }
    
            if($field == "percent"){
                if(!is_numeric($_POST[$field])){
                    array_push($errors[$field], $field . " is not a numeric");
                }
                if($_POST[$field] < 3 || $_POST[$field] > 100){
                    array_push($errors[$field], $field . " should be more then 3 and less then 100 ");
                }
            }
    
            if($field == "sumAdd"){
                if(!is_numeric($_POST[$field])){
                    array_push($errors[$field], $field . " is not a numeric");
                }
                if($_POST[$field] < 0 || $_POST[$field] > 3000000){
                    array_push($errors[$field], $field . " is not valid");
                }
            }
            
            if(!empty($errors[$field])){
                $is_valid = false;
            }
        }
    
        if(!$is_valid){
            return array("errors" => $errors);
        }
        
        $depositData = new DepositData(date_create_from_format("d.m.Y", $_POST['startDate']), $_POST['sum'], $_POST['term'], $_POST['percent'], $_POST['sumAdd']);
        return $depositData;
    }
}

class DepositCalculator{
    public static function calculate_deposit(DepositData $depositData)
    {
        $result = $depositData->sum;
        $sumAdd = $depositData->sumAdd;
        $date = $depositData->startDate;

        $percent = $depositData->percent / 100;
        
        for($i=0; $i <= $depositData->term - 1; $i++){
            $days = $date->format('t') - $date->format('d') + 1;
            $daysY = date('L')?366:365;

            $result += ($result + $sumAdd) * $days * $percent / $daysY;

            $date->modify("+1 month");
            $date->modify("first day of");
        }

        $result = round($result);
        return $result;
    }
}

class DepositPostHandler{

    public function OnPostRequest(){
        $validator = new DepositPostValidator();
        $responce = $validator->is_valid_form_request();
        
        if(is_a($responce, "DepositData")){
            $responce = array("sum" => DepositCalculator::calculate_deposit($responce));
        }

        echo json_encode($responce);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    header('Content-type: application/json');
    
    $postHandler = new DepositPostHandler();
    $postHandler->OnPostRequest();
}
