<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

<script>

    var rows_selected = [];

    //
    // Updates "Select all" control in a data table
    //
    function updateDataTableSelectAllCtrl(table){
       var $table             = table.table().node();
       var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
       var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
       var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

       // If none of the checkboxes are checked
       if($chkbox_checked.length === 0){
          chkbox_select_all.checked = false;
          if('indeterminate' in chkbox_select_all){
             chkbox_select_all.indeterminate = false;
          }

       // If all of the checkboxes are checked
       } else if ($chkbox_checked.length === $chkbox_all.length){
          chkbox_select_all.checked = true;
          if('indeterminate' in chkbox_select_all){
             chkbox_select_all.indeterminate = false;
          }

       // If some of the checkboxes are checked
       } else {
          chkbox_select_all.checked = true;
          if('indeterminate' in chkbox_select_all){
             chkbox_select_all.indeterminate = true;
          }
       }
    }

    function numberOfCheckboxesSelected(){
        var html;
        if (rows_selected.length > 0){
//            $('#button_control').css('display', 'block');
            $('div.test').html('{!! Form::open() !!}<span>Number of selected: '+rows_selected.length+'</span>' +
                '<button id="del" type="submit" name="action" value="delete"  class="btn btn-danger btn-sm">Διαγραφή</button>' +
                '<button type="submit" name="action" value="publish" class="btn btn-success btn-sm">Δημοσίευση</button>' +
                '{!! Form::close() !!}'
            ).find("form").on('submit', function(e){
                var form = this;

                $.each(rows_selected, function(index, rowId){
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'id[]')
                            .val(rowId)
                    );
                });
            });
        }else{
            $('div.test').html('');
            $('#button_control').css('display', 'none');
        }
    }



    $(document).ready(function(){
        var table = $("#allUnpublished").DataTable({
              'columnDefs': [{
                 'width' : "5",
                 'targets': 0,
                 'searchable':false,
                 'orderable':false,
                 'className': 'dt-body-center',
                 'render': function (data, type, full, meta){
                     return '<input type="checkbox">';
                 }
              }],

              'order': [1, 'asc'],

              'rowCallback': function(row, data, dataIndex){
                 // Get row ID
                 var rowId = data[0];

                 // If row ID is in the list of selected row IDs
                 if($.inArray(rowId, rows_selected) !== -1){
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                 }
              },

            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Greek.json"
            },
            "dom": 'l<"test">frtip'
        });



        // Handle click on checkbox
        $('#allUnpublished tbody').on('click', 'input[type="checkbox"]', function(e){

          var $row = $(this).closest('tr');

          // Get row data
          var data = table.row($row).data();

          // Get row ID
          var rowId = data[0];

          // Determine whether row ID is in the list of selected row IDs
          var index = $.inArray(rowId, rows_selected);

          // If checkbox is checked and row ID is not in list of selected row IDs
          if(this.checked && index === -1){
             rows_selected.push(rowId);

          // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
          } else if (!this.checked && index !== -1){
             rows_selected.splice(index, 1);
          }

          if(this.checked){
             $row.addClass('selected');
          } else {
             $row.removeClass('selected');
          }

          // Update state of "Select all" control
          updateDataTableSelectAllCtrl(table);
          numberOfCheckboxesSelected();

          // Prevent click event from propagating to parent
          e.stopPropagation();
        });

        // Handle click on table cells with checkboxes
        $('#allUnpublished').on('click', 'tbody td, thead th:first-child', function(e){
           $(this).parent().find('input[type="checkbox"]').trigger('click');
           numberOfCheckboxesSelected();
        });

        // Handle click on "Select all" control
        $('#allUnpublished thead input[name="select_all"]').on('click', function(e){
          if(this.checked){
             $('#allUnpublished tbody input[type="checkbox"]:not(:checked)').trigger('click');
          } else {
             $('#allUnpublished tbody input[type="checkbox"]:checked').trigger('click');
          }
          numberOfCheckboxesSelected();
          // Prevent click event from propagating to parent
          e.stopPropagation();
        });

        // Handle table draw event
        table.on('draw', function(){
          // Update state of "Select all" control
          updateDataTableSelectAllCtrl(table);
        });
    });
</script>