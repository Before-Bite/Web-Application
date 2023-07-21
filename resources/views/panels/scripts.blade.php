<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset(mix('vendors/js/ui/jquery.sticky.js'))}}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>

<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>


@if($configData['blankPage'] === false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<script>

    $(document).ready( function () {
        $('#myTable').DataTable();
        $('.al').hide();
        $('.edit_food_category').hide();
        $('.edit_name').hide();
    });

    $(".editFoodCategory").on('click',function()
    {
        var image = $(this).attr('data-image');
        var source = "{{ asset('') }}"+'/'+image;
        var html = `<img src="`+source+`" height="50" width="50">`
        $('#FoodCategoryImage').html(html);
        $('#edit-name').val($(this).attr('data-food_category_name'));
        $('#id').val($(this).attr('data-id'));
    });

    $(function() {
        $("#addNewCardValidation").validate({
            rules: {
                name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter some data",
                },
            },
          
            showErrors: function(errorMap, errorList) {
                if (submitted) {
                    $('.al').show();
                    submitted = false;
                }
            },          
            invalidHandler: function(form, validator) {
                submitted = true;
            }           
        });
    });

    $('.show_confirm').click(function(event) {
        var form =  $(this).closest("form");
        // var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            form.submit();
        }
        });
    });

    $(".editFood").on('click',function(){
        $('#edit_food_categorys').val($(this).attr('data-food_category_name'));
        $('#edit_names').val($(this).attr('data-food_name'));
        $('#id').val($(this).attr('data-id'));
    });

    $(function() {
        $("#FoodForm").validate({
            rules: {
                name: "required",
                food_category: "required",
            },
            messages: {
                name: "Please enter some data",
                food_category: "Please enter some data",
            },
          
            showErrors: function(errorMap, errorList) {
                if (submitted) {

                    // var summary = "You have the following errors: <br/>";
                    // $.each(errorList, function() { summary += " * " + this.message + "<br/>"; });
                    // $(".edit_name").html(summary);
                    $('.edit_food_category').show();
                    $('.edit_name').show();
                    submitted = false;
                }
            },          
            invalidHandler: function(form, validator) {
                submitted = true;
            }           
        });
    });

    $('.delete_food').click(function(event) {
        var form =  $(this).closest("form");
        // var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            form.submit();
        }
        });
    });
    
    $(".editResturantsPost").on('click',function(){

        var image = $(this).attr('data-dish_picture');

        var source = "{{ asset('') }}"+'/'+image;
    
        $('#review').val($(this).attr('data-review'));

        var html = `<img src="`+source+`" height="50" width="50">`
        
        $('#ddd').html(html);

        $('#id').val($(this).attr('data-id'));
    });
    
    $('.delete_Post').click(function(event) {
        var form =  $(this).closest("form");
        // var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            form.submit();
        }
        });
    });
</script>
