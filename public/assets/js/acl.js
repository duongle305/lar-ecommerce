$(document).ready(() => {
    let btnReloadUsers = $('#btn-reload-users');
    let tableUsers = $('#table_users');
    let href = btnReloadUsers.data('href');
    /* Reload table users */
    btnReloadUsers.click((e) => {
        e.preventDefault();
        tableUsers.DataTable().ajax.reload();
    });
    /* Setting table users */
    tableUsers.DataTable({
        processing: true,
        serverSide: true,
        ajax: href,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'actions', name: 'actions', class: 'text-xs-center', orderable: false, searchable: false}
        ],
        oLanguage: {
            sLengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
            sZeroRecords: 'Không tìm thấy dữ liệu',
            sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
            sInfoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
            sInfoFiltered: '(lọc từ tổng số _MAX_ dòng)',
            sSearch: 'Tìm kiếm:'
        }
    });
});
$(document).ready(() => {
    let btnReloadRoles = $('#btn-reload-roles');
    let tableRoles = $('#table_roles');
    let href = btnReloadRoles.data('href');
    /* Reload table permissions */
    btnReloadRoles.click((e) => {
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
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'actions', name: 'actions', class: 'text-xs-center', orderable: false, searchable: false}
        ],
        oLanguage: {
            sLengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
            sZeroRecords: 'Không tìm thấy dữ liệu',
            sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
            sInfoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
            sInfoFiltered: '(lọc từ tổng số _MAX_ dòng)',
            sSearch: 'Tìm kiếm:'
        }
    });
    /* Reset data form create new role */
    $('#modal_create_role').on('show.bs.modal', (e) => {
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
            for (let key in errors) {
                message += errors[key][0] + "\n";
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
        axios.get(editUrl).then(res => {
            let data = res.data;
            roleId.val(id);
            roleName.val(data.name);
            roleDisplayName.val(data.display_name);
            roleDDescription.val(data.description);
            Loading.close();
        }).catch(er=>{
            toastr.error(er.response.message);
            Loading.close();
        });
    });
    /* Submit update role */
    $('#form_edit_role').submit((e) => {
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
            for (let key in errors) {
                message += errors[key][0] + "\n";
            }
            toastr.error(message,'Thông báo');
            Loading.close();
        });

    });
    /* Delete role */
    $(document).on('click', '.delete', (e) => {
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
        }).then(function (isConfirm) {
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
$(document).ready(() => {
    let btnReloadPermissions = $('#btn-reload-permissions');
    let tablePermissions = $('#table_permissions');
    let href = btnReloadPermissions.data('href');
    /* Reload table permissions */
    btnReloadPermissions.click((e) => {
        e.preventDefault();
        tablePermissions.DataTable().ajax.reload();
    });
    /* Setting table permissions */
    tablePermissions.DataTable({
        processing: true,
        serverSide: true,
        ajax: href,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description'},
            {data: 'actions', name: 'actions', class: 'text-xs-center', orderable: false, searchable: false}
        ],
        language: {
            lengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
            zeroRecords: 'Không tìm thấy dữ liệu',
            info: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
            infoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
            infoFiltered: '(lọc từ tổng số _MAX_ dòng)',
            search: 'Tìm kiếm:',
        }
    });
});
$(document).ready(() => {
    /* create vue instance for create permission*/
    let permission = new Vue({
        el: '#modal_create_permission',
        data: {
            name: '',
            description:'',
            type: 'basic',
            permissionTypes: ['create'],
            nameInputs: [],
            displayNameInputs: [],
            descriptionInputs: []
        },
        watch: {
            name: function name(name) {
                this.getNameInput();
                this.getDisplayNameInput();
                this.getDescriptionInputs();
            },
            permissionTypes: function permissionTypes() {
                this.getNameInput();
                this.getDisplayNameInput();
                this.getDescriptionInputs();
            }
        },
        computed: {
            nameToSlug: function () {
                return Helpers.slug(this.name);
            }
        },
        methods: {
            getNameInput: function () {
                this.nameInputs = [];
                if (this.name.length > 0) {
                    let index = 0;
                    for (let permissionType of this.permissionTypes) {
                        switch (permissionType) {
                            case 'create':
                                this.nameInputs[index] = this.toSlug(`create ${this.getUppercaseFirst(this.name)}`);
                                break;
                            case 'update':
                                this.nameInputs[index] = this.toSlug(`update ${this.getUppercaseFirst(this.name)}`);
                                break;
                            case 'read':
                                this.nameInputs[index] = this.toSlug(`read ${this.getUppercaseFirst(this.name)}`);
                                break;
                            case 'delete':
                                this.nameInputs[index] = this.toSlug(`delete ${this.getUppercaseFirst(this.name)}`);
                                break;
                        }
                        index++;
                    }
                }
            },
            getDisplayNameInput: function () {
                this.displayNameInputs = [];
                if (this.name.length > 0) {
                    let index = 0;
                    for (let permissionType of this.permissionTypes) {
                        switch (permissionType) {
                            case 'create':
                                this.displayNameInputs[index] = `Thêm mới ${this.getUppercaseFirst(this.name)}`;
                                break;
                            case 'update':
                                this.displayNameInputs[index] = `Cập nhật ${this.getUppercaseFirst(this.name)}`;
                                break;
                            case 'read':
                                this.displayNameInputs[index] = `Xem ${this.getUppercaseFirst(this.name)}`;
                                break;
                            case 'delete':
                                this.displayNameInputs[index] = `Xóa ${this.getUppercaseFirst(this.name)}`;
                                break;
                        }
                        index++;
                    }
                }
            },
            getDescriptionInputs: function () {
                this.descriptionInputs = [];
                if (this.name.length > 0) {
                    let index = 0;
                    for (let permissionType of this.permissionTypes) {
                        switch (permissionType) {
                            case 'create':
                                this.descriptionInputs[index] = `Cho phép người dùng thêm mới ${this.getUppercaseFirst(this.name)}`;
                                break;
                            case 'update':
                                this.descriptionInputs[index] = `Cho phép người dùng cập nhật ${this.getUppercaseFirst(this.name)}`;
                                break;
                            case 'read':
                                this.descriptionInputs[index] = `Cho phép người dùng xem ${this.getUppercaseFirst(this.name)}`;
                                break;
                            case 'delete':
                                this.descriptionInputs[index] = `Cho phép người dùng xóa ${this.getUppercaseFirst(this.name)}`;
                                break;
                        }
                        index++;
                    }
                }
            },
            getUppercaseFirst: function getUcFirst(str) {
                var arr = str.split(' ');
                var result = '';
                for (var i = 0; i < arr.length; i++) {
                    result += arr[i].charAt(0).toUpperCase() + arr[i].slice(1) + ' ';
                }
                return result.trim(' ');
            },
            toSlug: function (str) {
                return Helpers.slug(str);
            },
            resetAllData: function () {
                this.name = '';
                this.type = 'basic';
                this.permissionTypes = ['create'];
                this.nameInputs = [];
                this.displayNameInputs = [];
                this.descriptionInputs = [];
            },
            submit:function (event) {
                event.preventDefault();
                let href = $(event.target).attr('href');
                if(this.type === 'basic'){
                    if(this.name === '' || this.description === ''){
                        toastr.error('Nhập đầy đủ thông tin!', 'Thông báo');
                        return false;
                    }
                } else {
                    if(this.name === ''){
                        toastr.error('Tên hiển thị không được để trống!', 'Thông báo');
                        return false;
                    }
                    if(this.permissionTypes.length < 1){
                        toastr.error('Chưa chọn loại quyền muốn tạo', 'Thông báo');
                        return false;
                    }
                }
                Loading.show();
                let permissions = [];
                if(this.type === 'advance'){
                    let index = 0;
                    for (let nameInput of  this.nameInputs){
                        permissions.push({
                            name: nameInput,
                            display_name: this.displayNameInputs[index],
                            description: this.descriptionInputs[index]
                        });
                        index++;
                    }
                } else {
                    permissions.push({name:Helpers.slug(this.name),display_name:this.name,description:this.description})
                }

                var formData = new FormData();

                formData.append("permissions", JSON.stringify(permissions));

                axios.post(href, formData).then(response => {
                    Loading.close();
                    if(response.data.code === 1){
                        toastr.success(response.data.message,'Thông báo');
                        $('#modal_create_permission').modal("hide");
                        $('#table_permissions').DataTable().ajax.reload();
                    }
                }).catch(e =>{
                    Loading.close();
                    console.log(e)
                });
            }
        }
    });

    $('#modal_create_permission').on('shown.bs.modal', (event) => {
        permission.resetAllData();
    });

    $('#modal_edit_permission').on('shown.bs.modal',(event)=>{
        Loading.show();
        $('input[name=edit_permission_name]').val('');
        $('input[name=edit_permission_display_name]').val('');
        $('textarea[name=edit_permission_description]').val('');
        axios.get($(event.relatedTarget).data('edit')).then(response=>{
            $('input[name=edit_permission_id]').val(response.data.id);
            $('input[name=edit_permission_name]').val(response.data.name);
            $('input[name=edit_permission_display_name]').val(response.data.display_name);
            $('textarea[name=edit_permission_description]').val(response.data.description);
            Loading.close();
        }).catch(error=>{
            Loading.close();
        })
    });
    /*change name while display name is change*/
    $('#edit_permission_display_name').on('input',(event)=>{
        let displayName = $(event.currentTarget).val();
        $('input[name=edit_permission_name]').val(Helpers.slug(displayName));
    });

    $('#form_edit_permission').submit((event)=>{
        event.preventDefault();
        let url = $(event.target).attr('action');
        if($('input[name=edit_permission_name]').val() === ''){
            toastr.error('Tên hiển thị không dược để trống','Thông báo');
            return false;
        }
        Loading.show();
        let formData = new FormData(event.target);
        axios.post(url,formData).then(response=>{
            Loading.close();
            toastr.success(response.data.message,'Thông báo');
            $('#modal_edit_permission').modal("hide");
            $('#table_permissions').DataTable().ajax.reload();
        }).catch(error=>{
            Loading.close();
            let errors = error.response.data.errors;
            let message = '';
            for (let key in errors) {
                message += errors[key][0] + "\n";
            }
            toastr.error(message,'Thông báo');
        })
    })

    $('')
});
