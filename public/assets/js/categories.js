$(document).ready(function(){
    $('.dropify').dropify();
    $('#categories').nestable().on('change', function(e){
        let list = e.length ? e : $(e.target);
        let data = list.nestable('serialize');
        axios.put('categories/nestable/update',{items: data}).then(resp=>{
            // toastr.clear();
            // toastr.success(resp.data.message,'Thông báo');
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
            $('.dropify-clear').click();
            toastr.success(resp.data.message,'Thông báo');
            loadCategories().then(function(resp){
                $('#categories').html(parseNestable(resp.data));
            }).catch(feedback);
        }).catch(feedback);
    });


    /* edit category */

    function clickRemove(element){
        let button = $(element).next();
        $(button).click();
    }
    $('#modal_edit_category').on('show.bs.modal',function(e){
        Loading.show();
        let categoryId = $(e.relatedTarget).data('id');
        let title = $('#edit_title');
        let note = $('#edit_note');

        let preview1 = $('input[name=edit_category_icon]').next().next();
        let render1 = $(preview1).children('.dropify-render');

        let preview2 = $('input[name=edit_category_icon_hover]').next().next();
        let render2 = $(preview2).children('.dropify-render');


        $(render1).removeAttr('src');
        $(render2).removeAttr('src');

        $('#edit_category_id').val(categoryId);
        axios.get('categories/edit/'+categoryId).then(resp=>{
            title.val(resp.data.title);
            note.val(resp.data.note);
            if(resp.data.icon_default){
                render1.html(`<img src="${resp.data.icon_default}" style="background:#20B9AE"/>`);
                $(render1.parent()).attr('style','background:#20B9AE').show();
            } else {
                clickRemove($('input[name=edit_category_icon]'))
            }

            if(resp.data.icon_hover){
                render2.html(`<img src="${resp.data.icon_hover}" style="background:#20B9AE"/>`);
                $(render2.parent()).attr('style','background:#20B9AE').show();
            } else {
                clickRemove($('input[name=edit_category_icon_hover]'))
            }
            Loading.close();
        }).catch(feedback);
    });

    $('input[name=edit_category_icon_hover]').change(function(event) {
        setTimeout(function () {
            let preview = $(event.target).next().next();
            $(preview).attr('style','background:#20B9AE').show();
            let render = $(preview).children('.dropify-render');
            $(render).children('img').attr('style','background:#20B9AE');
        },100);
    });

    $('input[name=edit_category_icon]').change(function(event) {
        setTimeout(function () {
            let preview = $(event.target).next().next();
            $(preview).attr('style','background:#20B9AE').show();
            let render = $(preview).children('.dropify-render');
            $(render).children('img').attr('style','background:#20B9AE');
        },100);
    });


    $('#form_edit_category').submit(function(e){
        e.preventDefault();
        Loading.show();
        let action = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(action, formData).then(resp=>{
            toastr.success(resp.data.message,'Thông báo');
            $('#modal_edit_category').modal('hide');
            clickRemove($('input[name=edit_category_icon]'));
            clickRemove($('input[name=edit_category_icon_hover]'));

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
                    if(res.data.code === 1){
                        toastr.clear();
                        toastr.error(res.data.message,'Thông báo');
                    } else {
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
                    }
                }).catch(feedback)
            }
        })
    });

});
