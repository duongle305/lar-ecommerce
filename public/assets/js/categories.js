$(document).ready(function(){
    $('#categories').nestable().on('change', function(e){
        let list = e.length ? e : $(e.target);
        let data = list.nestable('serialize');
        axios.put('categories/nestable/update',{items: data}).then(resp=>{
            toastr.clear();
            toastr.success(resp.data.message,'Thông báo');
        }).catch(feedback);
    });
    function parseNestable(items){
        let html = '<ol class="dd-list">';
        for(let item of items){
            html+=`
                <li class="dd-item dd3-item" data-id="${item.id}">
                    ${item.children&&item.children.length > 0 ? '<button data-action="collapse" type="button" style="display: block;">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>':''}
                    <div class="dd-handle dd3-handle"></div>
                    <div class="dd3-content">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-weight: 400;">${item.title}</span>
                            <div>
                                <button class="btn btn-warning btn-sm" data-id="${item.id}" data-toggle="modal" data-target="#modal_edit_category"><i class="ti-pencil"></i> Sửa</button>                  
                                <button class="btn btn-danger btn-sm delete" data-id="${item.id}"><i class="ti-trash"></i> Xóa</button> 
                            </div>
                        </div>
                    </div>
                    ${item.children&&item.children.length > 0 ? parseNestable(item.children):''}
                </li>
            `;
        }
        html+= '</ol>';
        return html;
    }
    function loadCategories(){
        return axios.get('categories/nestable').then(resp=>{
            return resp;
        })
    }
    loadCategories().then(function(resp){
        $('#categories').html(parseNestable(resp.data));
    }).catch(feedback);

    /* create new category */
    $('#form_create_category').submit(function(e){
        e.preventDefault();
        let action  = $(e.target).attr('action');
        let formData = new FormData(e.target);
        Loading.show();
        axios.post(action, formData).then(resp=>{
            Loading.close();
            $(e.target).trigger('reset');
            toastr.success(resp.data.message,'Thông báo');
            loadCategories().then(function(resp){
                $('#categories').html(parseNestable(resp.data));
            }).catch(feedback);
        }).catch(feedback);
    });
    /* edit category */
    $('#modal_edit_category').on('show.bs.modal',function(e){
        Loading.show();
        let categoryId = $(e.relatedTarget).data('id');
        let title = $('#edit_title');
        let note = $('#edit_note');
        $('#edit_category_id').val(categoryId);
        axios.get('categories/edit/'+categoryId).then(resp=>{
            title.val(resp.data.title);
            note.val(resp.data.note);
            Loading.close();
        }).catch(feedback);
    });
    $('#form_edit_category').submit(function(e){
        e.preventDefault();
        Loading.show();
        let action = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(action, formData).then(resp=>{
            toastr.success(resp.data.message,'Thông báo');
            $('#modal_edit_category').modal('hide');
            loadCategories().then(function(resp){
                $('#categories').html(parseNestable(resp.data));
            }).catch(feedback);
            Loading.close();
        }).catch(feedback);
    });
    $(document).on('click','.delete', function(e){
        let categoryId =  $(e.target).data('id');
        console.log(categoryId);
        if(categoryId === undefined) categoryId = $(e.target).parent().data('id');
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
                axios.delete('categories/delete/'+categoryId).then(res=>{
                    swal({
                        title: 'Deleted!',
                        text: res.data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    loadCategories().then(function(resp){
                        $('#categories').html(parseNestable(resp.data));
                    }).catch(feedback);
                }).catch(feedback)
            }
        })
    });
});