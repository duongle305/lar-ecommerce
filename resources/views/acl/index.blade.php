@extends('layouts.app')
@section('acl_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Nhân viên</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab2">Vai trò & Quyền</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <h5 class="mb-2">Nhân viên</h5>
                                <div class="table-responsive">
                                    <table id="table_users" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th>E-mail</th>
                                            <th>Vai trò</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div id="tab2" class="tab-pane">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="mb-2">Vai trò</h5>
                                            </div>
                                            <div class="col-lg-6 text-xs-right">
                                                <button class="btn btn-success" data-toggle="modal" data-target="#modal_create_role">Thêm mới</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="table_roles" class="table table-striped table-bordered" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên</th>
                                                    <th>Tên hiển thị</th>
                                                    <th>Mô tả</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="mb-2">Quyền</h5>
                                            </div>
                                            <div class="col-lg-6 text-xs-right">
                                                <button class="btn btn-success" data-toggle="modal" data-target="#modal_create_permission">Thêm mới</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="table_permissions" class="table table-striped table-bordered" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên</th>
                                                    <th>Tên hiển thị</th>
                                                    <th>Mô tả</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create role -->
    <div id="modal_create_role" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_create_role" action="{{ route('acl.roles.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Sửa</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_name">Tên</label>
                                    <input class="form-control" name="name" id="create_role_name">
                                    <small class="form-text text-muted">Tên phải là chữ thường không dấu vd: <code>administrator</code></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_display_name">Tên hiển thị</label>
                                    <input class="form-control" name="display_name" id="create_role_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_role_description">Mô rả</label>
                            <textarea class="form-control" name="description" id="create_role_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Thêm mới') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit role -->
    <div id="modal_edit_role" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_role" action="{{ route('acl.roles.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Sửa</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_role_id" id="edit_role_id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_role_name">Tên</label>
                                    <input class="form-control bg-faded" id="edit_role_name" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_role_display_name">Tên hiển thị</label>
                                    <input class="form-control" name="display_name" id="edit_role_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_role_description">Mô rả</label>
                            <textarea class="form-control" name="description" id="edit_role_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-check"></i> {{ __('Lưu thay đổi') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal create permission -->
    <div id="modal_create_permission" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_create_role" action="{{ route('acl.roles.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Tạo mới Quyền</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_name">Tên</label>
                                    <input class="form-control" name="name" id="create_role_name">
                                    <small class="form-text text-muted">Tên phải là chữ thường không dấu vd: <code>administrator</code></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_display_name">Tên hiển thị</label>
                                    <input class="form-control" name="display_name" id="create_role_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_role_description">Mô rả</label>
                            <textarea class="form-control" name="description" id="create_role_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Thêm mới') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/JSZip/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/pdfmake/build/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/pdfmake/build/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(()=>{
            $('#table_users').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('acl.users') }}',
                columns:[
                    { data: 'DT_RowIndex',name: 'DT_RowIndex', orderable: false, searchable: false},
                    { data: 'name', name:'name'},
                    { data: 'email', name:'email'},
                    { data: 'role', name:'role'},
                    { data: 'actions',name:'actions', class:'text-xs-center', orderable: false, searchable: false}
                ],
                oLanguage: {
                    sLengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
                    sZeroRecords: 'Không tìm thấy dữ liệu',
                    sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
                    sInfoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
                    sInfoFiltered: '(lọc từ tổng số _MAX_ dòng)',
                    sSearch:'Tìm kiếm:'
                }
            });

        });
        $(document).ready(()=>{
            $('#table_roles').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('acl.roles') }}',
                columns:[
                    { data: 'DT_RowIndex',name: 'DT_RowIndex', orderable: false, searchable: false},
                    { data: 'name', name:'name'},
                    { data: 'display_name', name:'display_name'},
                    { data: 'description', name:'description'},
                    { data: 'actions',name:'actions', class:'text-xs-center', orderable: false, searchable: false}
                ],
                oLanguage: {
                    sLengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
                    sZeroRecords: 'Không tìm thấy dữ liệu',
                    sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
                    sInfoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
                    sInfoFiltered: '(lọc từ tổng số _MAX_ dòng)',
                    sSearch:'Tìm kiếm:'
                }
            });
            $('#modal_create_role').on('show.bs.modal', (e)=>{
                $('#form_create_role').trigger('reset');
            });
            $('#form_create_role').submit((e)=>{
                e.preventDefault();
                let storeUrl = $(e.target).attr('action');
                let formData = new FormData(e.target);
                axios.post(storeUrl, formData).then(res=>{
                    toastr.success(res.data.message,'Thông báo');
                    $('#table_roles').DataTable().ajax.reload();
                    $('#modal_create_role').modal('hide');
                }).catch(er=>{
                    let errors = er.response.data.errors;
                    let message = '';
                    for(let key in errors){
                        message += errors[key][0]+"\n";
                    }
                    toastr.error(message,'Thông báo');
                });
            });
            $('#modal_edit_role').on('show.bs.modal',(e)=>{
                let id = $(e.relatedTarget).data('id');
                let editUrl = $(e.relatedTarget).data('edit');
                let roleId = $('#edit_role_id');
                let roleName = $('#edit_role_name');
                let roleDisplayName = $('#edit_role_display_name');
                let roleDDescription = $('#edit_role_description');
                $('#form_edit_role').trigger('reset');
                axios.get(editUrl).then(res=>{
                    let data = res.data;
                    roleId.val(id);
                    roleName.val(data.name);
                    roleDisplayName.val(data.display_name);
                    roleDDescription.val(data.description);
                }).catch(er=>{
                    toastr.error(er.response.message);
                });
            });
            $('#form_edit_role').submit((e)=>{
                e.preventDefault();
                let updateUrl = $(e.target).attr('action');
                let formData = new FormData(e.target);
                axios.post(updateUrl, formData).then(res=>{
                    toastr.success(res.data.message,'Thông báo');
                    $('#table_roles').DataTable().ajax.reload();
                    $('#modal_edit_role').modal('hide');
                }).catch(er=>{
                    let errors = er.response.data.errors;
                    let message = '';
                    for(let key in errors){
                        message += errors[key][0]+"\n";
                    }
                    toastr.error(message,'Thông báo');
                });

            });
        });
        $(document).ready(()=>{
            $('#table_permissions').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('acl.permissions') }}',
                columns:[
                    { data: 'DT_RowIndex',name: 'DT_RowIndex', orderable: false, searchable: false},
                    { data: 'name', name:'name'},
                    { data: 'display_name', name:'display_name'},
                    { data: 'description', name:'description'},
                    { data: 'actions',name:'actions', class:'text-xs-center', orderable: false, searchable: false}
                ],
                language: {
                    lengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
                    zeroRecords: 'Không tìm thấy dữ liệu',
                    info: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
                    infoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
                    infoFiltered: '(lọc từ tổng số _MAX_ dòng)',
                    search:'Tìm kiếm:',
                }
            });
        });
    </script>
@endsection
