$(document).ready(()=>{
    let btnReloadUsers = $('#btn-reload-users');
    let tableUsers = $('#table_users');
    let href = btnReloadUsers.data('href');
    /* Reload table users */
    btnReloadUsers.click((e)=>{
        e.preventDefault();
        tableUsers.DataTable().ajax.reload();
    });
    /* Setting table users */
    tableUsers.DataTable({
        processing: true,
        serverSide: true,
        ajax: href,
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
    let btnReloadRoles = $('#btn-reload-roles');
    let tableRoles = $('#table_roles');
    let href = btnReloadRoles.data('href');
    /* Reload table permissions */
    btnReloadRoles.click((e)=>{
        e.preventDefault();
        Loading.show();
        tableRoles.DataTable().ajax.reload();
        Loading.close();
    });
    /* Setting table roles */
    tableRoles.DataTable({
        processing: true,
        serverSide: true,
        ajax: href,
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
    /* Reset data form create new role */
    $('#modal_create_role').on('show.bs.modal', (e)=>{
        $('#form_create_role').trigger('reset');
    });
    /* Submit form create new role */
    $('#form_create_role').submit((e)=>{
        Loading.show();
        e.preventDefault();
        let storeUrl = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(storeUrl, formData).then(res=>{
            toastr.success(res.data.message,'Thông báo');
            $('#table_roles').DataTable().ajax.reload();
            $('#modal_create_role').modal('hide');
            Loading.close();
        }).catch(er=>{
            let errors = er.response.data.errors;
            let message = '';
            for(let key in errors){
                message += errors[key][0]+"\n";
            }
            toastr.error(message,'Thông báo');
            Loading.close();
        });
    });
    /* Show form edit role */
    $('#modal_edit_role').on('show.bs.modal',(e)=>{
        Loading.show();
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
            $('.preloader').fadeOut();
        }).catch(er=>{
            toastr.error(er.response.message);
            Loading.close();
        });
    });
    /* Submit update role */
    $('#form_edit_role').submit((e)=>{
        e.preventDefault();
        let updateUrl = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(updateUrl, formData).then(res=>{
            Loading.show();
            toastr.success(res.data.message,'Thông báo');
            $('#table_roles').DataTable().ajax.reload();
            $('#modal_edit_role').modal('hide');
            Loading.close();
        }).catch(er=>{
            let errors = er.response.data.errors;
            let message = '';
            for(let key in errors){
                message += errors[key][0]+"\n";
            }
            toastr.error(message,'Thông báo');
            Loading.close();
        });

    });
    /* Delete role */
    $(document).on('click','.delete', (e)=>{
        e.preventDefault();
        let href = $(e.target).data('delete');
        swal({
            title: 'Are you sure?',
            text: "Bạn sẽ không thể khôi phục lại điều này !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy',
            confirmButtonClass: 'btn btn-primary mr-1',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function(isConfirm) {
            if (isConfirm === true) {
                axios.delete(href).then(res=>{
                    Loading.show();
                    swal({
                        title: 'Deleted!',
                        text: res.data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    tableRoles.DataTable().ajax.reload();
                    Loading.close();
                }).catch(er=>{
                    swal({
                        title: 'Cancelled',
                        text: er.response.statusMessage,
                        type: 'error',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    Loading.close();
                })
            }
        })
    });

});
$(document).ready(()=>{
    let btnReloadPermissions = $('#btn-reload-permissions');
    let tablePermissions = $('#table_permissions');
    let href = btnReloadPermissions.data('href');
    /* Reload table permissions */
    btnReloadPermissions.click((e)=>{
        e.preventDefault();
        tablePermissions.DataTable().ajax.reload();
    });
    /* Setting table permissions */
    tablePermissions.DataTable({
        processing: true,
        serverSide: true,
        ajax: href,
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