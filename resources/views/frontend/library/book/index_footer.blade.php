    <script>
        (function($){
            var o = $({});
            $.subscribe = function(){
                o.on.apply(o, arguments);
            };
            $.unsubscribe = function(){
                o.off.apply(o, arguments);
            };
            $.publish = function(){
                o.trigger.apply (o, arguments);
            };
        }(jQuery));

        $(document).ready(function() {

            var submitAjaxRequestFavorite = function(e){
                e.preventDefault();
                var form = $(this).closest('form');
                var method = form.find('input[name="_method"]').val()|| 'POST';
                var data = form.serialize() + '&action=favorite';
                $.ajax({
                    type : method,
                    url : form.prop('action'),
                    data: data,
                    success : function(data){
//                        $.publish('form.submitted', form);
                        swalAlert(data['sweetalert']);
                        $('input[type=hidden][value='+data['itemId']+']').prev().toggleClass('btn-primary');
                    },
                    error: function (request, status, error) {
                       $('body').html(request.responseText);
                   }
                });
            };

//            $('form[data-remote]').on('submit', submitAjaxRequest);
            $('button[data-click-favorite]').on('click', submitAjaxRequestFavorite);

            $('button[data-click]').on('click', swalAlertDelete);

            $.subscribe('form.submitted', function(){
                $('.flash-box').fadeIn(500).delay(1000).fadeOut(500);
            });
         });

        function swalAlert(args){
         swal({
            title: args['title'],
            text: args['body'],
            type: args['level'],
            timer : 2000,
            showConfirmButton: false
         });
        }
        function swalAlertDelete(e){
            e.preventDefault();
            var form = $(this).closest('form');
            var data = form.serialize()+'&action=delete';

            var method = form.find('input[name="_method"]').val()|| 'POST';
            swal({
                title: "Προσοχή!",
                text: "Η διαγραφή του βιβλίου είναι οριστική",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ναι, διέγραψέ το",
                cancelButtonText: "Ακύρωση",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                closeOnCancel: true },
            function(){
                $.ajax({
                    type : method,
                    url : form.prop('action'),
                    data: data,
                    success : function(data){
                        setTimeout(function(){
                            swalAlert(data['sweetalert']);
                         }, 1000);
                    },
                    error: function (request, status, error) {
                       $('body').html(request.responseText);
                   }
                });
//                location.reload(true);
            });
        }
    </script>