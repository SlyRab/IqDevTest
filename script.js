const requestFile = "calc.php";

function Initialize(){
    Validation();

    $(".deposit-form").submit(FormSubmitHandler);

    $("#deposit-sumAdd-checkbox").checked = true;
}

function DepositDataBuilder(depositFormData){
    let termMode = depositFormData.get("term-mode");
    let term = depositFormData.get("term");

    if(termMode == "year"){
        term *= 12;
    }

    let depositData = {
        startDate: depositFormData.get("startDate"),
        sum: depositFormData.get("sum"),
        term: term,
        percent: depositFormData.get("percent"),
        sumAdd: depositFormData.get("sumAdd"),
    };

    return depositData;
}

function FormSubmitHandler(event){
    event.preventDefault();
    let depositFormData = new FormData(event.target);

    let depositJson = DepositDataBuilder(depositFormData);

    $.ajax({
        type: "POST",
        url: requestFile,
        dataType: 'json',
        data: depositJson,
        success: function(response)
        {
            if(response.sum){
                console.log("success");
                $("#deposit-result").parent().show();
                $("#deposit-result").text("₽ " + response.sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
            }
        }
    });
}

function Validation(){
    jQuery.validator.addMethod("customDateValidator",
    function(value, element) {
        if (!value.match(/^\d\d.\d\d.\d\d\d\d$/)){
            return false; 
        }
        return true;
    },
    "Please enter a valid date"
    );


    var validator = $("form[name=deposit-form]").validate({
        rules: {
            startDate: {
                required: true,
                customDateValidator: true,
            },
            term: {
                normalizer: function( value ) {
                    let result = value;

                    if(isNaN(result)){
                        return result;
                    }

                    let multiple = $("#deposit-form__select-term-mode").val() == "year" ? 12 : 1;
                    console.log(String(result * multiple));

                    return String(result * multiple);
                },
                required: true,
                number: true,
                max: 60,
                min: 1,
            },
            sum:{
                required: true,
                number: true,
                min: 1000,
                max: 3000000,
            },
            percent:{
                required: true,
                digits: true,
                min: 3,
                max: 100,
            },
            sumAdd:{
                required: true,
                number: true,
                min: 0,
                max: 3000000,
            }
        },
        messages:{
            startDate: {
                required: "Пожалуйста, введите дату открытия",
                customDateValidator: "Неверный формат даты",
            },
            term:{
                required: "Пожалуйста, введите срок вклада",
                number: "Неверный формат",
                max: "Не более 5-и лет",
                min: "Не менее одного месяца",
            },
            sum: {
                required: "Пожалуйста, введите сумму вклада",
                number: "Неверный формат",
                min: "Не менее 1000",
                max: "Не более 1000000",
            },
            percent:{
                required: "Пожалуйста, введите процентную ставку",
                digits: "Неверный формат",
                min: "не менее 3",
                max: "не более 100",
            },
            sumAdd: {
                required: "Пожалуйста, введите сумму вклада",
                number: "Неверный формат",
                min: "Не менее 0",
                max: "Не более 1000000",
            },
        },
        errorClass: "invalid",
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo( element.closest(".deposit-form__element").children(".deposit-form__element__errors") );        
        },
    });

    $("#deposit-form__select-term-mode").change(function(){
        validator.element("#deposit-form__term");
    });
    
    $("#deposit-sumAdd-checkbox").change(function(){
        $("#deposit-sumAdd").toggle();
        $("#deposit-sumAdd-input").val(0);
        validator.element("#deposit-sumAdd-input");
    });
}

new AirDatepicker('#deposit-form__datepicker');
$(document).ready(Initialize());
