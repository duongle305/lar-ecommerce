$(document).ready(function () {
    let tableCustomers = $('#table_customers');
    let btnReloadCustomers = $('#btn-reload-customers');

    tableCustomers.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: btnReloadCustomers.data('href'),
            error: function (xhr, error, thrown) {
                if (xhr.status === 500) {
                    let resp = xhr.responseJSON;
                    toastr.error(resp.message, 'Thông báo');
                    tableBrands.DataTable().ajax.reload();
                }
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'avatar', name: 'avatar'},
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
    })
});
$(document).ready(function () {
    let isAddAddress = false;
    let isChangeassword = false;
    let provinceSelected = null;
    let districtSelected = null;
    let wardSelected = null;
    let modalCreateCustomer = $('#modal_create_customer');
    let createCustomerName = $('input[name=create_customer_name]');
    let createCustomerEmail = $('input[name=create_customer_email]');
    let createCustomerGender = $('select[name=create_customer_gender]');
    let createCustomerBirthday = $('input[name=create_customer_birthday]');
    let createCustomerCheckAddAddress = $('input[name=create_customer_check_add_address]');
    let createCustomerProvince = $('select[name=create_customer_province]');
    let createCustomerDistrict = $('select[name=create_customer_district]');
    let createCustomerWard = $('select[name=create_customer_ward]');
    let createCustomerHouseStreet =$('input[name=create_customer_house_street]');
    let createCustomerCheckChangePass = $('input[name=create_customer_check_change_pass]');
    let createCustomerPassword =$('input[name=create_customer_password]');
    let createCustomerConfirmPassword = $('input[name=create_customer_confirm_password]');

    createCustomerProvince.select2({
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/customers/get-provinces',
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
                            text: `${item.type} ${item.name}`,
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
    /*province selected*/
    createCustomerProvince.on('select2:select',event=>{
        provinceSelected = event.params.data.id;
        createCustomerDistrict.val(null).trigger('change');
        createCustomerWard.val(null).trigger('change');
    });

    createCustomerDistrict.select2({
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/customers/get-districts',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
                    province_id : provinceSelected,
                    keyword : params.term,
                    page : params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: `${item.type} ${item.name}`,
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
    /*district selected*/
    createCustomerDistrict.on('select2:select',event=>{
        districtSelected = event.params.data.id;
        createCustomerWard.val(null).trigger('change');
    });

    createCustomerWard.select2({
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/customers/get-wards',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
                    district_id : districtSelected,
                    keyword : params.term,
                    page : params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: `${item.type} ${item.name}`,
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
    /*ward selected*/
    createCustomerWard.on('select2:select',event=>{
        wardSelected = event.params.data.id
    });

    modalCreateCustomer.on('show.bs.modal',event=>{
        $('.add-address').hide();
        $('.add-pass').hide();
        provinceSelected = null;
        districtSelected = null;
        wardSelected = null;
        createCustomerCheckAddAddress.attr('checked',false);
        createCustomerCheckChangePass.attr('checked',false);
        createCustomerName.val('');
        createCustomerEmail.val('');
        createCustomerGender.val('M');
        createCustomerBirthday.val('');
        createCustomerProvince.val(null).trigger('change');
        createCustomerDistrict.val(null).trigger('change');
        createCustomerWard.val(null).trigger('change');
        createCustomerHouseStreet.val('');
        createCustomerPassword.val('');
        createCustomerConfirmPassword.val('');
    });

    createCustomerCheckAddAddress.change(event=>{
       if($(event.target).is(':checked')){
           $('.add-address').show();
       } else {
           $('.add-address').hide();
       }
    });

    createCustomerCheckChangePass.change(event=>{
        if($(event.target).is(':checked')){
            $('.add-pass').show();
        } else {
            $('.add-pass').hide();
        }
    });

    $('#form_create_customer').submit(event=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).attr('action');
        let formData = new FormData(event.target);
        axios.post(url,formData).then(response=>{
            Loading.close();
            if(response.data.code === 1){
                toastr.success(response.data.message,'Thông báo');

            }
        }).catch(error=>{
            Loading.close();
            if(error.response.status == 403){
                let html = '';
                let errors = error.response.data.errors;
                for (let key in errors){
                    html+=errors[key]+"<br>";
                }
                toastr.error(html,'Thông báo');
                return false;
            }
        })

    });
});
