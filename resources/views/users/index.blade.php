@extends('app')

@section('content')
    @include('partials.page_header', ['title'=>"Manage Users", 'desc'=>""])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add/Update Users Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" data-toggle="modal" data-target="#userModal" class="btn btn-box-tool btn-success" style="color: white;">
                        <i class="fa fa-plus"></i> Add New User</button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-ctarget="customer_form" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped" id="data_lookup_tbl">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Password Changed</th>
                        <th>Block</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="user_form">
                        <fieldset>
                                {!! csrf_field() !!}
                                <input type="hidden" id="user_id" name="user_id">
                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="role">Role</label>
                                <div class="col-md-5">
                                    <select id="role" name="role" class="form-control">
                                        <option value="1">Lookup User</option>
                                        <option value="2">Data Entry User</option>
                                        <option value="3">Admin User</option>
                                        <option value="4">Super Admin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="name">Name</label>
                                <div class="col-md-5">
                                    <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
                                    <span class="help-block"> </span>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="mobile">Mobile</label>
                                <div class="col-md-5">
                                    <input id="mobile" name="mobile" type="text" placeholder="" class="form-control input-md" required="">
                                    <span class="help-block"> </span>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">Email</label>
                                <div class="col-md-5">
                                    <input id="email" name="email" type="text" placeholder="" class="form-control input-md" required="">
                                    <span class="help-block"> </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="block">Block</label>
                                <div class="col-md-4">
                                    <label class="radio-inline" for="block-0">
                                        <input type="radio" name="block" id="block-0" value="0">
                                        No
                                    </label>
                                    <label class="radio-inline" for="block-1">
                                        <input type="radio" name="block" id="block-1" value="1">
                                        Yes
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="password">Password</label>
                                <div class="col-md-5">
                                    <input id="password" name="password" type="text" placeholder="" class="form-control input-md" required="">
                                    <span class="help-block" id="password_help"></span>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-toggle="save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var tbl = $('#data_lookup_tbl').DataTable({
            processing: true,
            serverSide: true,
            fixedColumns: true,
            scrollX: true,
            ajax: '{{ route('datatables_ajax.users') }}',
            columns: [
                {data: 'id', name: 'id', "render":
                    function(data, type, full, meta){
                        return '<button title="Edit User ?" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#userModal" data-user_id="'+data+'" data-user_data=\''+JSON.stringify(full)+'\'><i class="fa fa-edit"></i> '+data+'</button>' +
                            ' <button title="Delete User ?" class="btn btn-xs btn-danger" onclick="delete_user(\''+data+'\')" ><i class="fa fa-remove"></i> '+data+'</button>';
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role', "render":
                    function(data){
                        if(data == 1) return "Lookup User";
                        else if(data == 2) return "Data Entry User";
                        else if(data == 3) return "Admin User";
                        else if(data == 4) return "Super Admin";
                    }
                },
                {data: 'password_changed', name: 'password_changed'},
                {data: 'block', name: 'block', "render":
                    function(data){
                        if(data == 0) return "No";
                        else if(data == 1) return "Yes";
                    }
                },
            ],
        });

        function delete_user(user_id){
            if(confirm("Confirm Delete User ?")){
                $.ajax({
                    url: "{{ route('users.delete') }}",
                    type: "POST",
                    data: {'_token':"{{ csrf_token() }}", 'user_id': user_id}
                }).done(function (res){
                    if(res.status == 'ok') $.notify('User Deleted!', 'info');
                    tbl.ajax.reload();
                });
            }
        }

        $('#userModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var user_id = button.data('user_id') // Extract info from data-* attributes
            var user_data = button.data('user_data') // Extract info from data-* attributes
            var modal = $(this)
            if(user_id == null){
                modal.find('.modal-title').text('Add New User')
                modal.find('.modal-body #user_id').val('')
                clear_validation();
            }else{
                modal.find('.modal-title').text('Update User')
                modal.find('.modal-body #user_id').val(user_id)
                modal.find('.modal-body #name').val(user_data.name)
                modal.find('.modal-body #mobile').val(user_data.mobile)
                modal.find('.modal-body #email').val(user_data.email)
                modal.find('.modal-body #role').val(user_data.role)
                modal.find('.modal-body #password_help').html("Leave password field blank if you do not want to change password.")
            }
        });

        $('[data-toggle="save"]').click(function (e){
            var save_btn = $(this);
            save_btn.attr('disabled', '');
            var form_data = $("#user_form").serializeArray();
            clear_validation();
            $.ajax({
                url: "{{ route('users.save') }}",
                type: "POST",
                data: form_data
            }).done(function (res){
                if(res.status == 'added'){
                    $.notify('User Added Successfully', "success");
                    $("#userModal").modal('hide');
                }else if(res.status == 'updated'){
                    $.notify('User Updated Successfully', "success");
                    $("#userModal").modal('hide');
                }else if(res.status == 'validation_failed'){
                    $.notify('Errors!', "error");
                    show_validation(res.validator);
                }
                save_btn.removeAttr('disabled');
            });
        });

        $('#userModal').on('hidden.bs.modal', function (event) {
            $('#user_form input[type="text"]').val('');
            $('#user_form input[type="password"]').val('');
            $("#user_form select").val(1);
            clear_validation();
            tbl.ajax.reload();
        });

        function show_validation(validator){
            $.each(validator, function (item, errors){
                $("#"+item).parent().children(1).html(errors[0]);
                $("#"+item).parent().parent().addClass('has-error');
            });
        }
        function clear_validation(){
            $(".has-error").removeClass('has-error');
            $(".help-block").html('');
        }
    </script>
@endsection