
$(".range-field input").change(function (e) {
    let count_excel=$(this).val()/$("#modal1").attr( "count-one-exel")
    count_excel = Math.ceil(count_excel)
    $(".excel-counter").text(count_excel);

    let count_price = count_excel*$("#modal1").attr( "priceDefault");
    $(".price-counter").text(Math.ceil(count_price));

    $(".limit-counter").text(count_excel);


    let user_limit = $("#modal1").attr( "tariffLimit");
    let user_balance = $("#modal1").attr( "balance");

    // тарифа нет
    if(count_price > user_balance){
        $('.submit-button-netTariff').text('Пополнить');
    }
    else{
        $('.submit-button-netTariff').text('Скачать');
    }


    // у тарифа зокнчился лимит
    if(count_price > user_balance){
        $('.submit-button-netLimit').text('Пополнить');
    }
    else{
        $('.submit-button-netLimit').text('Скачать');
    }

    // лимит у тарифа не закончился
    if(count_excel > user_limit){
        $('.submit-button-normTariff').text('Пополнить');
    }
    else{
        $('.submit-button-normTariff').text('Скачать');
    }


})


