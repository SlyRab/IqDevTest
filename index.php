<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/air-datepicker/air-datepicker.css">
    <title>iq dev deposit calculator</title>
</head>
<body>
    <header class="header">

        <div class="container">
            <div class="header__logo">
                <a href="/"><h1>iq dev</h1></a>
                <p>Deposit Calculator</p>
            </div>
        </div>

    </header>
    <section class="main">
        <div class="container">

            <div class="main__title">
                <h2>Депозитный калькулятор</h2>
                <p>Калькулятор депозитов позволяет расчитать ваши доходы после внесения суммы на счет в банке по определенному тарифу.</p>
            </div>

            <div class="main__deposit-form">
                <form name="deposit-form" class="deposit-form" action="calc.php" method="post">
                    <div class="deposit-form-row">

                            <div class="deposit-form__element deposit-form__element-mod_textbox">
                                <input type="text" id="deposit-form__datepicker" class="deposit-form__text-input" placeholder="" name="startDate">
                                <label for="" class="deposit-form__text-label">Дата открытия</label>
                                
                                <div class="deposit-form__element__errors">
                                        
                                </div>
                            </div>

                            <div class="deposit-form__element">
                                <div class="deposit-form__composite-element">
                                    <div class="deposit-form__composite-element__child">
                                        <input id="deposit-form__term" type="text" class="deposit-form__text-input" placeholder="" name="term">
                                        <label for="" class="deposit-form__text-label">Срок вклада</label>
                                        
                                    </div>
                                    <div class="deposit-form__composite-element__child deposit-form__composite-element__child-mod_sizing" > 
                                        <select id="deposit-form__select-term-mode" class="deposit-form__select-input" name="term-mode">
                                            <option value="month" name="month">Месяц</option>
                                            <option value="year" name="year">Год</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="deposit-form__element__errors">
                                        
                                </div>
                            </div>

                            <div class="deposit-form__element">
                                <input type="text" class="deposit-form__text-input" placeholder="" name="sum">
                                <label for="" class="deposit-form__text-label">Сумма вклада</label>
                                
                                <div class="deposit-form__element__errors">
                                        
                                </div>
                            </div>

                            <div class="deposit-form__element">
                                <input type="text" class="deposit-form__text-input" placeholder="" name="percent">
                                <label for="" class="deposit-form__text-label">Процентная ставка, % годовых</label>
                                
                                <div class="deposit-form__element__errors">
                                        
                                </div>
                            </div>

                            <div class="deposit-form__element">
                                <input type="checkbox" id="deposit-sumAdd-checkbox" class="deposit-form__checkbox-input " name="month-deposit" checked>
                                <label for="" class="deposit-form__checkbox-label">Ежемесячное пополнение вклада</label>
                            </div>     

                            <div class="deposit-form__element">
                                <div  id="deposit-sumAdd" class="deposit-form__element">
                                    <input id="deposit-sumAdd-input" type="text" class="deposit-form__text-input" placeholder="" name="sumAdd">
                                    <label for="" class="deposit-form__text-label">Сумма пополнения вклада</label>

                                    <div class="deposit-form__element__errors">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="deposit-form__element">
                                <input type="submit" class="deposit-form__submit" value="Расчитать">

                                <div class="deposit-form__element__errors">
                                        
                                </div>
                            </div>  
         
                    </div>
                </form>
                <div class="result-deposit">
                    <p>Сумма к выплате</p>
                    <span id="deposit-result" class="deposit-result"></span>
                </div>
            </div>
        </div>

    </section>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script src="assets/air-datepicker/air-datepicker.js"></script> 
<script src="script.js"></script>
</html>