@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.parcel_plural')}} {{trans('lang.coupon_plural')}} <span class="storeTitle"></span></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.parcel_plural')}} {{trans('lang.coupon_table')}}</li>
            </ol>
        </div>
        <div>
        </div>
    </div>
    <div class="container-fluid">
       <div class="admin-top-section"> 
        <div class="row">
            <div class="col-12">
                <div class="d-flex top-title-section pb-4 justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/coupon.png') }}"></span>
                        <h3 class="mb-0">{{trans('lang.parcel_plural')}} {{trans('lang.coupon_table')}}</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>
                   
                </div>
            </div>
        </div> 
       
       </div>
       <div class="table-list">
       <div class="row">
           <div class="col-12">
               <div class="card border">
                 <div class="card-header d-flex justify-content-between align-items-center border-0">
                   <div class="card-header-title">
                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.parcel_plural')}} {{trans('lang.coupon_table')}}</h3>
                    <p class="mb-0 text-dark-2">{{trans('lang.parcelcoupon_table_text')}}</p>
                   </div>             
                 </div>
                 <div class="card-body">
                         <div class="table-responsive m-t-10">
                            <table id="example24" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                <th>{{trans('lang.coupon_code')}}</th>

                                <th>{{trans('lang.coupon_discount')}}</th>

                                <th>{{trans('lang.coupon_description')}}</th>

                                <th>{{trans('lang.coupon_expires_at')}}</th>

                                <th>{{trans('lang.coupon_enabled')}}</th>

                                <th>{{trans('lang.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody id="append_list1">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">
var user_permissions = '<?php echo @session('user_permissions') ?>';

user_permissions = JSON.parse(user_permissions);

 var checkDeletePermission = false;

if ($.inArray('parcel.coupons.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
}

var database = firebase.firestore();
var offest = 1;
var pagesize = 10;
var end = null;
var endarray = [];
var start = null;

var ref = database.collection('parcel_coupons');

var currentCurrency = '';
var currencyAtRight = false;
var decimal_degits = 0;

var refCurrency = database.collection('currencies').where('isActive', '==', true);
refCurrency.get().then(async function (snapshots) {
    var currencyData = snapshots.docs[0].data();
    currentCurrency = currencyData.symbol;
    currencyAtRight = currencyData.symbolAtRight;

    if (currencyData.decimal_degits) {
        decimal_degits = currencyData.decimal_degits;
    }
});

var append_list = '';

$(document).ready(function () {

    $(document.body).on('click', '.redirecttopage', function () {
        var url = $(this).attr('data-url');
        window.location.href = url;
    });

    jQuery("#data-table_processing").show();
    const table = $('#example24').DataTable({
        pageLength: 10,
        processing: false,
        serverSide: true,
        responsive: true,
        ajax: async function (data, callback, settings) {
            const start = data.start;
            const length = data.length;
            const searchValue = data.search.value.toLowerCase();
            const orderColumnIndex = data.order[0].column;
            const orderDirection = data.order[0].dir;

            const orderableColumns = ['code','discount','description','expiresAt','',''];

            const orderByField = orderableColumns[orderColumnIndex];

            if (searchValue.length >= 3 || searchValue.length === 0) {
                $('#data-table_processing').show();
            }

            try {
                const querySnapshot = await ref.get();
                if (querySnapshot.empty) {
                    $('.total_count').text(0);
                    $('#data-table_processing').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                    return;
                }

                let records = [];
                let filteredRecords = [];

                await Promise.all(querySnapshot.docs.map(async (doc) => {
                    let childData = doc.data();
                    childData.id = doc.id;

                    var date = '';
                    var time = '';
                    if (childData.hasOwnProperty("expiresAt") && childData.expiresAt != '') {
                        try {
                            date = childData.expiresAt.toDate().toDateString();
                            time = childData.expiresAt.toDate().toLocaleTimeString('en-US');
                        } catch (err) {

                        }
                    }
                    var expiresAt = date + ' ' + time ;
                    if (searchValue) {
                        if (
                            (childData.code && childData.code.toLowerCase().includes(searchValue)) ||
                            (childData.description && childData.description.toLowerCase().includes(searchValue)) ||
                            (childData.discount && childData.discount.toLowerCase().includes(searchValue)) ||
                            (expiresAt && expiresAt.toString().toLowerCase().indexOf(searchValue) > -1)
                        ) {
                            filteredRecords.push(childData);
                        }
                    } else {
                        filteredRecords.push(childData);
                    }
                }));

                filteredRecords.sort((a, b) => {
                    let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase().trim() : '';
                    let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase().trim() : '';
                    if (orderByField === 'expiresAt' && a[orderByField] != '' && b[orderByField] != '') {
                        try {
                            aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                            bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                        } catch (err) {
                        }
                    }
                    if (orderByField === 'discount') {
                        aValue = a[orderByField] ? parseInt(a[orderByField]) : 0;
                        bValue = b[orderByField] ? parseInt(b[orderByField]) : 0;
                    }
                    if (orderDirection === 'asc') {
                        return (aValue > bValue) ? 1 : -1;
                    } else {
                        return (aValue < bValue) ? 1 : -1;
                    }
                });

                const totalRecords = filteredRecords.length;
                $('.total_count').text(totalRecords);
                const paginatedRecords = filteredRecords.slice(start, start + length);

                const formattedRecords = await Promise.all(paginatedRecords.map(async (childData) => {
                    return await buildHTML(childData);
                }));

                $('#data-table_processing').hide();
                callback({
                    draw: data.draw,
                    recordsTotal: totalRecords,
                    recordsFiltered: totalRecords,
                    data: formattedRecords
                });

            } catch (error) {
                console.error("Error fetching data from Firestore:", error);
                $('#data-table_processing').hide();
                callback({
                    draw: data.draw,
                    recordsTotal: 0,
                    recordsFiltered: 0,
                    data: []
                });
            }
        },
        order: [3, 'desc'],
        columnDefs: [
            {
                targets: 3,
                type: 'date',
                render: function(data) {
                    return data;
                }
            },
            {orderable: false, targets: [4, 5]},
        ],
        "language": {
            "zeroRecords": "{{trans('lang.no_record_found')}}",
            "emptyTable": "{{trans('lang.no_record_found')}}",
            "processing": "" // Remove default loader
        },
    });
    function debounce(func, wait) {
        let timeout;
        const context = this;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    $('#search-input').on('input', debounce(function () {
        const searchValue = $(this).val();
        if (searchValue.length >= 3) {
            $('#data-table_processing').show();
            table.search(searchValue).draw();
        } else if (searchValue.length === 0) {
            $('#data-table_processing').show();
            table.search('').draw();
        }
    }, 300));

});

async function buildHTML(val) {

    var html = [];
        var id = val.id;
        var route1 = '{{route("parcel_coupons.edit",":id")}}';
        route1 = route1.replace(':id', id);
        html.push('<a  data-url="' + route1 + '" href="'+route1+'" class="redirecttopage">' + val.code + '</a>');
        var discount_price = 0;
        if (currencyAtRight) {
            if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = parseFloat(val.discount).toFixed(decimal_degits) + "" + currentCurrency;
            }
        } else {
            if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = currentCurrency + "" + parseFloat(val.discount).toFixed(decimal_degits);
            }
        }
        html.push(discount_price);
        html.push(val.description);
        if (val.hasOwnProperty("expiresAt")) {
            try {
                date = val.expiresAt.toDate().toDateString();
                time = val.expiresAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html.push('<td class="dt-time">' + date + ' ' + time + '</td>');
        } else {
            html.push('<td></td>');
        }
        if (val.isEnabled) {
            html.push('<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>');
        } else {
            html.push('<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>');
        }
        var action = '';
        action = action + '<span class="action-btn"><a href="' + route1 + '"><i class="mdi mdi-lead-pencil"></i></a>';
        if(checkDeletePermission){
            action=action+'<a id="' + val.id + '" name="coupon_delete_btn" class="delete-btn" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a>';
        }
        action=action+'</span>';
        html.push(action);
    return html;
}

$(document).on("click","input[name='isActive']",function(e){
    var ischeck=$(this).is(':checked');
    var id=this.id;
    if(ischeck){
        database.collection('parcel_coupons').doc(id).update({'isEnabled': true}).then(function (result) {

        });
    }else{
        database.collection('parcel_coupons').doc(id).update({'isEnabled': false}).then(function (result) {

        });
    }

});




$(document).on("click", "a[name='coupon_delete_btn']", async function (e) {
    var id = this.id;
    await deleteDocumentWithImage('parcel_coupons',id,'image');
    window.location = "{{! url()->current() }}";
});

</script>

@endsection
