$(document).ready(function () {
    let tableProducts = $('#table_products');
    let btnReloadProducts = $('#btn-reload-products');
    tableProducts.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: btnReloadProducts.data('href'),
            error: function (xhr, error, thrown) {
                if (xhr.status === 500) {
                    let resp = xhr.responseJSON;
                    toastr.error(resp.message, 'Thông báo');
                    tableProducts.DataTable().ajax.reload();
                }
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'title', name: 'title'},
            {data: 'state', name: 'state'},
            {data: 'brand', name: 'brand'},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {data: 'thumbnail', name: 'thumbnail'},
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
    btnReloadProducts.on('click',(event) => {
        event.preventDefault();
        Loading.show();
        tableProducts.DataTable().ajax.reload();
        Loading.close();
    });
});

$(document).ready(function () {
    let descriptionImg = [];
    let attributes = [];
    let createProductName = $('input[name=create_product_name]');
    let createProductSlug = $('input[name=create_product_slug]');
    let createProductBrand =$('select[name=create_product_brand]');
    let createProductCategory = $('select[name=create_product_category]');
    let createProductPrice = $('input[name=create_product_price]');
    let createProductDiscount = $('input[name=create_product_discount]');
    let createProductNote = $('textarea[name=create_product_note]');
    let createProductDescription = $('textarea[name=create_product_description]');
    let createProductAttributeValue = $('input[id=create_product_attribute_value]');
    let createProductAttributeName = $('input[id=create_product_attribute_name]');
    let addAttributeBtn = $('#add_attribute_btn');
    let formCreateCustomer = $('#form_create_customer');

    function uploadImage(files,input){
        let url = createProductDescription.data('url');
        var formData = new FormData();
        formData.append('image_type','0');
        formData.append("description_image", files[0]);
        axios.post(url, formData).then(res=>{
            input.summernote('editor.insertImage',res.data.image_url);
            descriptionImg.push(res,data.image_name);
        }).catch(error=>{
        });
    }

    function generateTableBody(){
        let html = '';
        attributes.forEach(function (item,index) {
            html +=`<tr>
                        <td>${item.title}</td>
                        <td>${item.value}</td>
                        <td class="text-center"><button type="button" class="btn btn-danger delete-attribute" data-index="${index}"><i class="ti-close"></i> Xóa</button></td>
                    </tr>`
        });
        $('#table_attribute_body').html(html);
    }

    createProductPrice.autoNumeric('init', {mDec: '0'});

    $('.dropify').dropify();

    createProductNote.summernote({
        height: 100,
        placeholder: 'Ghi chú sản phẩm',
        callbacks:{
            onImageUpload: function(files, editor, welEditable) {
                uploadImage(files,createProductNote);
            },
            onMediaDelete : function(target) {
                console.log(target[0].src);
            }
        }
    });

    createProductDescription.summernote({
        height: 200,
        placeholder: 'Mô tả sản phẩm',
        callbacks:{
            onImageUpload: function(files, editor, welEditable) {
                uploadImage(files,createProductDescription);
            },
            onMediaDelete : function(target) {
                console.log(target[0].src);
            }
        }
    });

    createProductBrand.select2({
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/products/get-brand',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
                    keyword : params.term,
                    page : params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: `${item.name}`,
                            id: item.id
                        }
                    }),
                    pagination: {
                        more : (params.page  * 10) < data.total
                    }
                };
            },
            cache: true
        },
        templateResult : function (repo) {
            if(repo.loading) return repo.text;
            var markup = repo.text;
            return markup;
        },
        templateSelection : function(repo) {
            return repo.text;
        },
        escapeMarkup : function(markup){ return markup; }
    });

    createProductCategory.select2({
        multiple:true,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/products/get-categories',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
                    keyword : params.term,
                    page : params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        if(item != null)
                            return {
                                text: item.title,
                                id: item.id
                            }
                    }),
                    pagination: {
                        more : (params.page  * 10) < data.total
                    }
                };
            },
            cache: true
        },
        templateResult : function (repo) {
            if(repo.loading) return repo.text;
            var markup = repo.text;
            return markup;
        },
        templateSelection : function(repo) {
            return repo.text;
        },
        escapeMarkup : function(markup){ return markup; }
    });

    createProductName.on('input',(event)=>{
        createProductSlug.val(Helpers.slug(createProductName.val()));
    });

    addAttributeBtn.click(event=>{
        event.preventDefault();
        if(createProductAttributeValue.val().length === 0 || createProductAttributeName.val().length === 0){
            toastr.clear();
            toastr.error('Chưa nhập đủ thông tin','Thông báo');
            return false;
        }
        attributes.push({'title':createProductAttributeName.val(),'value':createProductAttributeValue.val()});
        generateTableBody();
        createProductAttributeValue.val('');
        createProductAttributeName.val('');
    });

    $(document).on('click','.delete-attribute',event=>{
        event.preventDefault();
        let index = $(event.target).data('index');
        attributes.splice(index, 1);
        generateTableBody();
    });
    let manualUploader = new qq.FineUploader({
        element: document.getElementById('my-uploader'),
        template: 'qq-template',
        request: {
            customHeaders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            endpoint: '/products/upload-image'
        },
        callbacks: {
            onAllComplete: function(succeeded,failed) {
                Loading.close();
                toastr.success('Thêm sản phẩm thành công', 'Thông báo');
                location.reload();
            },
        },
        thumbnails: {
            placeholders: {
                waitingPath: '/storage/uploads/image_source/waiting-generic.png',
                notAvailablePath: '/storage/uploads/image_source/not_available-generic.png'
            }
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png','gif'],
        },
        autoUpload: false,
        debug: false
    });

    $('.reload').click(event=>{
        Loading.show();
        event.preventDefault();
        createProductName.val('');
        createProductSlug.val('');
        createProductBrand.val(null).trigger('change');
        createProductCategory.val(null).trigger('change');
        createProductPrice.val(0);
        createProductDiscount.val(0);
        createProductNote.summernote('reset');
        createProductDescription.summernote('reset');
        $('#table_attribute_body').html('');
        createProductAttributeValue.val('');
        createProductAttributeName.val('');
        attributes = [];
        if(descriptionImg.length > 0){
        }
        manualUploader.reset();
        Loading.close();
    });



    formCreateCustomer.submit(event=>{
        event.preventDefault();
        let url = $(event.target).attr('action');
        let imageBtn = document.getElementsByClassName('qq-upload-cancel');
        if(imageBtn.length < 1){
            toastr.clear();
            toastr.error('Thêm ít nhất 1 hình ảnh cho sản phẩm','Thông báo');
            return false;
        }

        Loading.show();
        let formData = new FormData(event.target);

        if(attributes.length > 0)
            formData.append('attributes',JSON.stringify(attributes));

        let categories = [];

        for (let category of createProductCategory.select2('data')){
            categories.push(category.id)
        }

        formData.append('create_product_category',JSON.stringify(categories));
        formData.append('create_product_price',createProductPrice.val().replace(/\./gi, ""));
        axios.post(url,formData).then(res=>{
            if(res.data.code === 1){
                manualUploader.setParams({
                    'image_type': 1,
                    'product_slug': Helpers.slug(createProductName.val()),
                    'product_id' : res.data.data.id
                });
                manualUploader.uploadStoredFiles();
            }
        }).catch(errors=>{
            Loading.close();
            let resp = errors.response;
            if(resp.status == 403){
                toastr.clear();
                let errors = resp.data.errors;
                let message = '';
                for(let key in errors){
                    message += errors[key][0]+"<br>";
                }
                toastr.error(message,'Thông báo');
            }
        })
    });
});
