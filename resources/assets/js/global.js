$.msg = function(subject, text, style){

    var styles = {
        success : 'alert alert-block alert-success flyover flyover-centered',
        info: 'alert alert-info flyover flyover-centered',
        warning : 'alert alert-warning flyover flyover-centered',
        danger: 'alert alert-danger flyover flyover-centered'
    }

    var html = '<button type="button" class="close" data-dismiss="alert">' +
        '<span aria-hidden="true">&times;</span>' +
        '<span class="sr-only">Close</span>' +
        '</button>'+
        '<h4>'+subject+'</h4><p><strong>'+subject+':</strong>&MediumSpace;'+text+'</p>';
    /* +'<div class="progress"><div id="messageProgressBar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%"><span class="sr-only">0</span> </div> </div>'*/
    
    $('<div>')
        .attr('id','div_message_alert')
        .addClass(styles[style])
        .attr('role', 'alert')
        .html(html)
        .appendTo($('#alert-message'))
        .fadeIn('slow', function(){
            progressBar($("#messageProgressBar"));
            $(this).addClass('in');

        })
        .animate({opacity: 1}, 2300,function(){
            $(this).removeClass('in');
        })
        .fadeOut(function(){
            $(this).remove();
        })
};


$.fn.bootstrapShowValidation = function (value){
    if (value == 'success'){
        this.addClass('has-'+value+' has-feedback')
            .append('<span class="glyphicon glyphicon-ok form-control-feedback span-icon"></span>');
    }else if (value == 'error'){
        this.addClass('has-'+value+' has-feedback')
            .append('<span class="glyphicon glyphicon-remove form-control-feedback span-icon"></span>');
    }else if(value == 'warning'){
        this.addClass('has-'+value+' has-feedback')
            .append('<span class="glyphicon glyphicon-warning-sign form-control-feedback span-icon"></span>');
    }
};
$.fn.bootstrapRemoveValidation = function(){
    this.removeClass('has-success has-feedback')
        .removeClass('has-error has-feedback')
        .removeClass('has-warning has-feedback');

    if (this.find($("span[class$=span-icon]")).length != 0){
        this.find($("span[class$=span-icon]")).remove();
    }
}