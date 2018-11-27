$(document).ready(()=>{
    let menuId = $('#menu_id').val();
    $('#menu-items').nestable().on('change', function(e){
        let list = e.length ? e : $(e.target);
        let data = list.nestable('serialize');
        axios.put('nestable-menu-builder/update',{items: data}).then(resp=>{
            toastr.clear();
            toastr.success(resp.data.message,'Thông báo');
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
        });
    });
    function parseNestable(items){
        let html = '<ol class="dd-list">';
        for(let item of items){
            html+=`
                <li class="dd-item dd3-item" data-id="${item.id}">
                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">${item.title}</div>
                    ${item.children&&item.children.length ? parseNestable(item.children):''}
                </li>
            `;
        }
        html+= '</ol>';
        return html;
    }
    axios.get('nestable-menu-builder/'+menuId).then(resp=>{
        $('#menu-items').html(parseNestable(resp.data));
    }).catch(err=>{});
});