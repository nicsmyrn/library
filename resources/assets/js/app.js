(function(){

    $.subscribe('form.submitted', function(){
        $('.flash-box').fadeIn(500).delay(1000).fadeOut(500);
    });

})();