$(document).ready(()=>{
    let menuId = $('#menu_id').val();
    $('#menu-items').nestable().on('change', function(e){
        let list = e.length ? e : $(e.target);
        let data = list.nestable('serialize');
        axios.put('nestable-menu-builder/update',{items: data}).then(resp=>{
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
                                <button class="btn btn-warning btn-sm" data-id="${item.id}" data-toggle="modal" data-target="#modal_edit_menu_item"><i class="ti-pencil"></i> Sửa</button>                  
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
    function loadMenu(){
        return axios.get('nestable-menu-builder/'+menuId).then(resp=>{
            return resp;
        })
    }
    loadMenu().then(function(resp){
        $('#menu-items').html(parseNestable(resp.data));
    }).catch(feedback);
    $('#btn-reset-create-menu').click(function(){
        $('#form_create_menu_item').trigger('reset');
        $('#link_type').trigger('change');
    });
    $('#link_type').on('change',function(event){
        let ipRoute = $('#route');
        let ipParameters = $('#parameters');
        let ipUrl = $('#url');
        let linkType = $(event.target).val();
        ipRoute.val('');
        ipParameters.val('');
        ipUrl.val('');
        if(linkType === 'route'){
            ipRoute.parent().slideDown();
            ipParameters.parent().slideDown();
            ipUrl.parent().slideUp();
        }else{
            ipRoute.parent().slideUp();
            ipParameters.parent().slideUp();
            ipUrl.parent().slideDown();
        }
    });
    $('#form_create_menu_item').submit(function(e){
        e.preventDefault();
        Loading.show();
        let url = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(url,formData).then(resp=>{
            Loading.close();
            $(e.target).trigger('reset');
            $('#link_type').trigger('change');
            toastr.success(resp.data.message,'Thông báo');
            loadMenu().then(function(resp){
                $('#menu-items').html(parseNestable(resp.data));
            }).catch(feedback);
        }).catch(feedback);
    });

    /* edit menu item */
    $('#edit_link_type').on('change',function(event){
        let ipRoute = $('#edit_route');
        let ipParameters = $('#edit_parameters');
        let ipUrl = $('#edit_url');
        let linkType = $(event.target).val();
        ipRoute.val('');
        ipParameters.val('');
        ipUrl.val('');
        if(linkType === 'route'){
            ipRoute.parent().slideDown();
            ipParameters.parent().slideDown();
            ipUrl.parent().slideUp();
        }else{
            ipRoute.parent().slideUp();
            ipParameters.parent().slideUp();
            ipUrl.parent().slideDown();
        }
    });
    $('#modal_edit_menu_item').on('show.bs.modal',function(e){
        let menuItemId = $(e.relatedTarget).data('id');
        let title = $('#edit_title');
        let iconClass = $('#edit_icon_class');
        let linkType = $('#edit_link_type');
        let url = $('#edit_url');
        let route = $('#edit_route');
        let parameters = $('#edit_parameters');
        let target = $('#edit_target');
        $('#edit_menu_item_id').val(menuItemId);
        Loading.show();
        axios.get('edit/'+menuItemId).then(res=>{
            title.val(res.data.title);
            iconClass.val(res.data.icon_class);
            res.data.url ? linkType.val('url') : linkType.val('route');
            linkType.trigger('change');
            url.val(res.data.url);
            route.val(res.data.route);
            parameters.val(res.data.parameters);
            target.val(res.data.target);
            Loading.close();
        }).catch(feedback);
    });
    $('#form_edit_menu_item').submit(function(e){
        e.preventDefault();
        Loading.show();
        let action = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(action,formData).then(res=>{
            $(e.target).trigger('reset');
            $('#edit_link_type').trigger('change');
            toastr.success(res.data.message,'Thông báo');
            $('#modal_edit_menu_item').modal('hide');
            loadMenu().then(function(resp){
                $('#menu-items').html(parseNestable(resp.data));
            }).catch(feedback);
            Loading.close();
        }).catch(feedback)
    });
    $(document).on('click','.delete', function(e){
        let menuItemId =  $(e.target).data('id');
        if(menuItemId === undefined) menuItemId = $(e.target).parent().data('id');
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
                axios.delete('delete/'+menuItemId).then(res=>{
                    swal({
                        title: 'Deleted!',
                        text: res.data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    loadMenu().then(function(resp){
                        $('#menu-items').html(parseNestable(resp.data));
                    }).catch(feedback);
                }).catch(feedback)
            }
        })
    });
});