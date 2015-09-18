<script>
// GLOBAL VARS


//**************************************************************************
//JQUERY ON BOOK FORM
    $("#title").on('keyup', titleLength);

    $("#authors").select2({
        placeholder : 'Επέλεξε συγγραφέα',
        width : '75%',
        allowClear : true
    }).on('change',{
      dewey_parameter : false,  // δείχνει ότι η συνάρτηση καλείται από το checkbox dewey
      author_trigger : true // δείχνει αν η συνάρτηση καλείται από την αλλαγή του authors
    }, showSubCategorySelect);


    $("#author-add").on({
        mouseover : onMouseOverFunction,
        mouseout  : onMouseOutFunction,
        mousemove : onMouseMoveFunction
    },{title : 'Προσθήκη νέου συγγραφέα', body : 'με αυτό το κουμπί μπορείτε να προσθέσετε συγγραφέα που δεν είναι καταχωρημένος στη λίστα'});

    $("#modal_cancel_author_button").on('click', resetAuthorModalForm);
    $("#modal_save_author_button").on('click', ajaxAddAuthor);

    $('#dewey').on('change', {
        cat_number : 0,  // επίπεδο combobox 1
        dewey_parameter : true,   // δείχνει ότι άλλαξε το checkbox
        author_trigger : false // δείχνει αν η συνάρτηση καλείται από την αλλαγή του authors
    },showSubCategorySelect);


    $(".book-categories").on('change',{
        dewey_parameter : false,  // δείχνει ότι η συνάρτηση καλείται από το checkbox dewey
        author_trigger : false // δείχνει αν η συνάρτηση καλείται από την αλλαγή του authors
    }, showSubCategorySelect)
    .select2({
           placeholder : "Επέλεξε κατηγορία",
           width :'75%',
           minimumResultsForSearch : -1
       });

    $("#FourthLevelbutton_modal").on('show.bs.modal', onOpen4categoryModal);

    $("#modal_save_fourth_button").on('click', create4category);

    $("#editor").select2({
        placeholder : "Επέλεξε Εκδότη",
        width : '75%',
        allowClear : true
    });

    $("#modal_cancel_editor_button").on('click', resetEditorModalForm);
    $("#modal_save_editor_button").on('click', ajaxAddEditor);

    $("#editor-add").on({
        mouseover : onMouseOverFunction,
        mouseout  : onMouseOutFunction,
        mousemove : onMouseMoveFunction
    },{title : 'Προσθήκη νέου Εκδότη', body : 'με αυτό το κουμπί μπορείτε να προσθέσετε ΕΚΔΟΤΗ που δεν είναι καταχωρημένος στη λίστα'});

    $("#quantity").on('keyup', checkQuantity);

    $("#year").on('keyup', checkYearValue);

    $("#tags").select2({
        placeholder : "Επέλεξε ετικέτα",
        width : '75%'
    });

//**************************************************************************
//      A  J  A  X      C A L L S
//**************************************************************************
    function ajaxAddAuthor(){
        $.ajax({
            url : '/book/ajax/addNewAuthor',
            type: 'post',
            dataType : 'json',
            data :{
                lastname : $("#author-modal-lastname").val(),  // τα δεδομένα που στέλνει
                firstname : $("#author-modal-firstname").val(),
                _token : $('input[name=_token]').val()
            },
            success : successAddAuthor,
            error: swalAlertValidatorError
        });
    }

    function ajaxAddEditor(){
        $.ajax({
            url : '/book/ajax/addNewEditor',
            type: 'post',
            dataType : 'json',
            data :{
                name : $("#editor-modal-name").val(),  // τα δεδομένα που στέλνει
                _token : $('input[name=_token]').val()
            },
            success : successAddEditor,
            error: swalAlertValidatorError
        });
    }

    function create4category(){
        $.ajax({
            url : '/book/ajax/create4category',
            type: 'post',
            dataType : 'json',
            data :{
                level : 4,
                dewey : 1,
                type : 1,
                cat_id : $("#fourthButton-modal-id").val(),  // ο κωδικός της 4ης κατηγορίας για αποθήκευση
                name : $("#fourthButton-modal-name").val(),  // το όνομα της 4ης κατηγορίας για αποθήκευση
                parent_id : $("#FourthLevelbutton_modal").data('category').parent_id,  // βλέπει τον κωδικό του γονέα
                dataoption : $("#FourthLevelbutton_modal").data('category').dataexist,  // ελέγχει με τα data εαν υπάρχει το option της 4ης κατηγορίας
                _token : $('input[name=_token]').val()
            },
            success : successAdd4category,
            error: swalAlertValidatorError
        });
    }

//**************************************************************************
//   E N D   OF    A  J  A  X      C A L L S
//**************************************************************************



//################################################################################################
//INTERNAL FUNCTIONS
    //check title length
    function titleLength(){
        if ($(this).val().length >= 2){
            $("#div_title").bootstrapRemoveValidation();
            $("#div_title").bootstrapShowValidation('success');
        }else{
            $("#div_title").bootstrapRemoveValidation();
            $("#div_title").bootstrapShowValidation('error');
        }
    }

    function onMouseOverFunction(event){
            tooltip = new PNotify({
               title: event.data.title,
               text: event.data.body,
               hide: false,
               buttons: {
                   closer: false,
                   sticker: false
               },
               history: {
                   history: false
               },
               animate_speed: 100,
               opacity: .9,
               icon: "ui-icon ui-icon-comment",
        //                // Setting stack to false causes PNotify to ignore this notice when positioning.
               stack: false
           })
    }

    function onMouseOutFunction(){
        tooltip.remove();
    }

    function onMouseMoveFunction(){
        tooltip.get().css({
           'top': event.clientY + 12,
           'left': event.clientX + 12
       });
    }

    function resetAuthorModalForm(){
           $("#author-modal-lastname").val('');
           $("#author-modal-firstname").val('');
    }


    function showSubCategorySelect(event){
        var category_number; // δειχνει ποιο select box είναι 1:πρώτο, 2: δευτερο(υποκατηγορία), 3: τρίτο (υποκατηγορία) κοκ
        var value_option = null; // default value option αποό το select box που θα ενεργοποιηθεί

        if (event.data.dewey_parameter == true){//εαν επιλεγεί το checkbox dewey
            category_number = event.data.cat_number;    //τότε ο αριθμός του combobox θα γίνει 1
        }else{
            if (!event.data.author_trigger){ // εαν δεν καλείται η συνάρτηση από το change του select authors
                category_number = parseInt($(this).attr("id").substr(5,1)); // ο αριθμός του combobox ιεραρχικά
                value_option = $(this).val();
            }else{// εαν  καλείται η συνάρτηση από το change του select authors
                category_number = $("#numberOfCategories").val();
                value_option = $("#categ"+$("#numberOfCategories").val()).val();
                //alert ("author trigger true. Category Number:"+category_number+"  Value Option:"+value_option);
            }
        }
        var subcategory_number = category_number+1;  // ο αριθμός του sub combobox ιεραρχικά

        showDeweyCode(category_number);  // καλεί τη συνάρτηση  που δημιουργεί & εμφανίζει το Dewey Code

        if (!event.data.author_trigger){ // εαν η συνάρτηση δεν έχει καλεστεί από το author select box
            returnCategorySelectBox(value_option, category_number, subcategory_number); // Ajax call
        }// end if !data.event.author_trigger

    }//end of showSubCategorySelect

    function showDeweyCode(category_number){
        var deweycode = 'zero';
        if (category_number >= 1 && $("#authors :selected").val()){              // εμφανίζει την ταξινόμηση dewey μόνο στην περίπτωση που έχουν επιλεγεί πάνω από 2 combobox

            if (category_number == 4){
                deweycode = $("#categ"+category_number).data('parentId')+"."+$("#categ"+category_number+" option:selected").val() +"-"+ $("#authors :selected").text().substr(0,3).toUpperCase();
            }else{
                deweycode = $("#categ"+category_number+" option:selected").val() +"-"+ $("#authors :selected").text().substr(0,3).toUpperCase();
            }

            $("#dewey-code")
                .find($("div[class=panel-body]")).remove()
                .end()
                .append("<div class='panel-body'> <h4 class='text-center' style='letter-spacing: 0.1em'><span class='label label-success' id='dewey-code-value'>"+deweycode+"</span> </h4><input type='hidden' name='dewey_code' value="+deweycode+"> </div>")
                .removeClass('panel-primary')
                .addClass('panel-success')
                .children('.panel-heading').html('Ταξινόμηση Dewey');
        }else{
            $("#dewey-code")
                .removeClass('panel-primary')
                .removeClass('panel-success')
                .addClass('panel-default')
                .find($("div[class=panel-body]")).remove()
                .end()
                .children('.panel-heading').html('Εδώ θα εμφανιστεί η ταξινόμηση Dewey');
        } // end if category_number >= 2
    } // end function of showDeweyCode


    function returnCategorySelectBox(value_option, category_number, subcategory_number){
        $.ajax({
            url : '/book/ajax/showSubCategory',
            type : 'post',
            dataType : 'json',
            data :{
                value : value_option, // Το Value του option του combobox
                parent: category_number,  // το Id του combobox
                child: subcategory_number, // το Id του child combobox
                dewey: $("input[name=dewey]").prop('checked'),  // ελέγχει εαν είναι checked το checkbox του dewey
                parentID : $("#categ"+category_number).data('parentId'),
                _token : $('input[name=_token]').val()
            },
            success : getAjaxCategoriesComboBoxies,
            error: function (request, status, error) {
                    $('body').html(request.responseText);
                }

        });
    }

    function successAddAuthor(data){
         if (data['author']){ //εαν υπάρχει συγγραφέας
              var html  = '<option value="'+data['author']['id']+'">'+data['author']['lastname']+'&nbsp;'+data['author']['firstname']+'</option>';
              $("#authors").append(html);
         }
         swalAlert(data['sweetalert']);
    }

    function swalAlert(args){
        swal({
           title: args['title'],
           text: args['body'],
           type: args['level'],
           timer : 2000,
           showConfirmButton: false
        });
    }

    function swalAlertValidatorError(data){
        if( data.status === 422 ) {
            errors = data.responseJSON;

            errorsHtml = '<div><ul>';

            $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value + '</li>'; //showing only the first error.
            });

            errorsHtml += '</ul></div>';
        }

        swal({
           title: 'Προσοχή',
           text: errorsHtml,
           type: 'error',
           confirmButtonText: 'Κλείσιμο',
           html : true
        });
    }

    function resetEditorModalForm(){
           $("#editor-modal-name").val('');
    }
    function successAddEditor(data){
         if (data['editor']){ //εαν υπάρχει συγγραφέας
              var html  = '<option value="'+data['editor']['id']+'">'+data['editor']['name']+'</option>';
              $("#editor").append(html);
         }
         swalAlert(data['sweetalert']);
    }

    function checkQuantity(){
       $("#div_quantity").bootstrapRemoveValidation();

       if (parseInt($(this).val()) < 1 || parseInt($(this).val()) > 99){
           $("#div_quantity").bootstrapShowValidation('error');
           $(this).focus();
       }else if(parseInt($(this).val()) >= 1 || parseInt($(this).val()) <= 99){
           $("#div_quantity").bootstrapShowValidation('success');
       }
    }

    function checkYearValue(){
        var d = new Date();

        $("#div_year").bootstrapRemoveValidation();

        if (parseInt($(this).val()) < 1800 || parseInt($(this).val()) > d.getFullYear()){
            $("#div_year").bootstrapShowValidation('error');
            $(this).focus();
        }else if(parseInt($(this).val()) >= 1800 || parseInt($(this).val()) <= d.getFullYear()){
            $("#div_year").bootstrapShowValidation('success');
        }
    }

    function getAjaxCategoriesComboBoxies(data){

        var subcategory_number = data['sub'];

        for (var i=subcategory_number; i<=4; i++){
            if ($("#categ"+i).length != 0){
                $("#categ"+i).parent().remove(); //διαγράφει τα comboBox & Label των υποκατηγοριών για να ξαναδημιουργηθούν εκ νέου
            }
        }

        if (data['select']!=''){ // αν έχει επιστρέψει ajax δεδομένα τότε υπάρχουν  οι υποκατηγορίες αλλιώς είναι κενό TODO δημιουργεί το καινούργιο comboBox
            var label;
            if (subcategory_number == 1){
                label = 'Κατηγορία';
            }else{
                label = 'Υποκατηγορία';
            }
            var labelCategory = $("<label>").attr("for","categ"+subcategory_number).append(label+" "+subcategory_number+":");
            var subcategory = $("<select>").attr({id: 'categ'+subcategory_number, name : 'categ'+subcategory_number, 'data-parent-id' : data['parentID']}).empty().append("<option></option>").addClass("book-categories");
            //δημιουργεί ένα select box με Id το subcategory number βάζει ένα κενό και την κλάση book-categories
            var button4category = null;
            if(subcategory_number == 4){
                button4category = '<a class="add-new-object" id="add4category"  href="#" data-parent-id="'+data['value_option']
                    +'" data-toggle="modal" data-option="exist" data-target="#FourthLevelbutton_modal">' +
                     '<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>' +
                      ' <script>  ' +
                            ' $("#add4category").on(' +
                             '{ mouseover : onMouseOverFunction,mouseout  : onMouseOutFunction,mousemove : onMouseMoveFunction},' +
                             '{title : "Προσθήκη 4ης κατηγορίας",  ' + 'body : "με αυτό το κουμπί μπορείτε να προσθέσετε την τέταρτη κατηγορία. ' +
                         'Θα πρέπει να είστε προσεκτικοί έτσι ώστε η κατηγορία να μην υπάρχει στην υπάρχουσα λίστα"})' +
                          ' ';
            }

            $.each(data['select'], function(index, element){ // για κάθε κατηγορία από τα δεδομένα ajax επιστρέφει το index και το περιοχόμενο
                var html = '<option value="' + index + '">'+element+'</option>';  // και δημιουργεί option value
                subcategory.append(html);
            });

            $("<div>")   // φτιάχνει ένα div για να ομαδοποιήσει το label και το combobox της υποκατηγορίας
                .addClass('form-group')
                .attr('id','div-categ'+subcategory_number)
                .appendTo("#div-id-allCategories")  // το εντάσει στην γενική κατηγορία με Id div-id-allCategories
                .append(labelCategory);

            subcategory.appendTo("#div-categ"+subcategory_number) // βάζει το καινούργιο select box στο τέλος του div με ID categories
                .select2({
                    placeholder : "Επέλεξε Υποκατηγορία",
                    minimumResultsForSearch : -1,
                    width : 300
                }).on('change',{
                        dewey_parameter : false,
                        author_trigger : false // δείχνει αν η συνάρτηση καλείται από την αλλαγή του authors
                        }, showSubCategorySelect); // αναδρομή σε περίπτωση αλλαγής του καινούργιου select box καλείται πάλι η συνάρτηση
                if (button4category!=null && subcategory_number == 4){
                    $("#div-categ"+subcategory_number).append(button4category) ;
                }
        }else{// end if NOT subcategories
            if (subcategory_number == 4){
                var html = '<div class="form-group" id="div-categ4"><a id="categ4" class="btn btn-warning" href="#" data-option="not_exist" data-parent-id="'+data['value_option']  +'" data-toggle="modal" data-target="#FourthLevelbutton_modal">προσθήκη 4ης κατηγορίας</a> </div>';
                $("#div-id-allCategories").append(html);
            }
        }
        $("#numberOfCategories").val(subcategory_number-1); // δείχνει σε ποιο level είναι η κατηγορία σε περίπτωση που ενεργοποιηθεί είτε από author or checkbox
        $("#categoryID").val(data['categoryID']);
        $("#parentID").val(data['parentID']);
    }

    function onOpen4categoryModal(event){
        var button = $(event.relatedTarget);    //επιστρέφει ως jquery αντικείμενο το κουμπί
        var record = button.data();             // συλλέγει όλα τα data του κουμπιού
        var modal = $(this);
        modal.data('category',{parent_id: record.parentId, dataexist: record.option});  // δίνει στο modal json τα δεδομέναν της κατηγορίας
    }

    function successAdd4category(data){
        if (data['category4']){
            var html = '<option value="'+data['category4']['option-value']+'">'+data['category4']['option-value']+ ' - '+data['category4']['name']+'</option>';
            if (data['category4']['option-exist']){
                $("#categ4").append(html);
            }else{
                var labelCategory4 = '<label for="categ4">Υποκατηγορία 4:</label>';
                var selectOption = $("<select>")
                                        .attr({id: 'categ4', name : 'categ4', 'data-parent-id' : data['category4']['parentID']})
                                        .empty()
                                        .append("<option></option>")
                                        .append(html)
                                        .addClass("book-categories");
                var button = '<a class="add-new-object" id="add4category"  href="#" data-parent-id="'+data['value_option']
                 +'" data-toggle="modal" data-option="exist" data-target="#FourthLevelbutton_modal">' +
                  '<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>' +
                   ' <script>  ' +
                         ' $("#add4category").on(' +
                          '{ mouseover : onMouseOverFunction,mouseout  : onMouseOutFunction,mousemove : onMouseMoveFunction},' +
                          '{title : "Προσθήκη 4ης κατηγορίας",  ' + 'body : "με αυτό το κουμπί μπορείτε να προσθέσετε την τέταρτη κατηγορία. ' +
                      'Θα πρέπει να είστε προσεκτικοί έτσι ώστε η κατηγορία να μην υπάρχει στην υπάρχουσα λίστα"})' +
                       ' ';

                $("#div-categ4")
                    .empty()
                    .append(labelCategory4)
                    .append(selectOption)
                    .append(button);

                selectOption.select2({
                    placeholder : "Επέλεξε Υποκατηγορία",
                    minimumResultsForSearch : -1,
                    width : 300
                });
            }
            $("#categoryID").val(data['category4']['id']);
        }
        swalAlert(data['sweetalert']);
    }
</script>