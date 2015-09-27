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

            $('button[data-click=delete]').on('click', swalAlertDelete);

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
//            swal({
//                title: "Are you sure?",
//                text: "You will not be able to recover this imaginary file!",
//                type: "warning",
//                showCancelButton: true,
//                confirmButtonColor: "#DD6B55",
//                confirmButtonText: "Yes, delete it!",
//                cancelButtonText: "No, cancel plx!",
//                closeOnConfirm: false,
//                closeOnCancel: false },
//                 function(isConfirm){
//                    if (isConfirm) {
//                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
//                    } else {
//                        swal("Cancelled", "Your imaginary file is safe :)", "error");
//                    }
//                 }
//            );
            swal({
                title: "Προσοχή!",
                text: "Η διαγραφή του χρήστη είναι οριστική",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ναι, διέγραψέ τον",
                cancelButtonText: "Ακύρωση",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                closeOnCancel: true },
                function(){
//                     setTimeout(function(){
//                                 swal({
//                                    title: 'title',
//                                    text: 'body',
//                                    timer : 2000,
//                                    showConfirmButton: false
//                                 });
//                     }, 2000);
                    $.ajax({
                        type : method,
                        url : form.prop('action'),
                        data: data,
                        success : function(data){
                            setTimeout(function(){
                                location.reload(true);
                             }, 2000);
                        },
                        error: function (request, status, error) {
                           $('body').html(request.responseText);
                       }
                    });
                }
            );

        }
    </script>