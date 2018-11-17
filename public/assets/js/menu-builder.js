$(document).ready(()=>{
    let tableMenus = $('#table_menus');
    let btnReloadMenus = $('#btn-reload-menus');
    let href = btnReloadMenus.data('href');
    let formCreateMenu = $('#form_create_menu');
    let modalEditMenu = $('#modal_edit_menu');
    let formEditMenu = $('#form_edit_menu');
    /* Reload table menus */
    btnReloadMenus.click((e)=>{
        e.preventDefault();
        Loading.show();
        tableMenus.DataTable().ajax.reload();
        Loading.close();
    });
    tableMenus.DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url: href,
            error: function (xhr, error, thrown) {
                if(xhr.status === 500){
                    let resp = xhr.responseJSON;
                    toastr.error(resp.message,'Thông báo');
                    tableMenus.DataTable().ajax.reload();
                }
            }
        },
        columns:[
            { data: 'DT_RowIndex',name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name:'name'},
            { data: 'note', name:'note'},
            { data: 'actions',name:'actions', orderable: false, searchable: false}
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

    formCreateMenu.submit((e)=>{
       e.preventDefault();
       Loading.show();
       let action = $(e.target).attr('action');
       let formData = new FormData(e.target);
       axios.post(action, formData).then(res=>{
           toastr.success(res.data.message,'Thông báo');
           tableMenus.DataTable().ajax.reload();
           $(e.target).trigger('reset');
           Loading.close();
       }).catch(err=>{
           let resp = err.response;
           if(resp.status === 403){
               let errors = resp.data.errors;
               let message = '';
               for(let key in errors){
                   message += errors[key][0]+"\n";
               }
               toastr.error(message,'Thông báo');
           }
           if(resp.status === 500){
               toastr.error(resp.data.message,'Thông báo');
           }
           Loading.close();
       });
    });

    modalEditMenu.on('show.bs.modal',(e)=>{
        Loading.show();
        $('#form_edit_menu').trigger('reset');
        let menuId = $('#edit_menu_id');
        let menuName = $('#edit_menu_name');
        let menuNote = $('#edit_menu_note');
        let editHref = $(e.relatedTarget).data('edit');
        axios.get(editHref).then(resp=>{
            let data = resp.data;
            menuId.val(data.id);
            menuName.val(data.name);
            menuNote.val(data.note);
            Loading.close();
        }).catch(err => {
            let resp = err.response;
            if(resp.status === 500){
                toastr.error(resp.data.message,'Thông báo');
            }
            Loading.close();
        })
    });

    formEditMenu.submit((e)=>{
        Loading.show();
        e.preventDefault();
        let action = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(action, formData).then(resp=>{
            toastr.success(resp.data.message,'Thông báo');
            tableMenus.DataTable().ajax.reload();
            modalEditMenu.modal('hide');
            Loading.close();
        }).catch(err=>{
            let resp = err.response;
            if(resp.status === 403){
                let errors = resp.data.errors;
                let message = '';
                for(let key in errors){
                    message += errors[key][0]+"\n";
                }
                toastr.error(message,'Thông báo');
            }
            if(resp.status === 500){
                toastr.error(resp.data.message,'Thông báo');
            }
            Loading.close();
        });
    });

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
                    swal({
                        title: 'Deleted!',
                        text: res.data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    tableMenus.DataTable().ajax.reload();
                }).catch(er=>{
                    swal({
                        title: 'Cancelled',
                        text: er.response.message,
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