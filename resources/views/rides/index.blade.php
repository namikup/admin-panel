@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.rides')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.rides')}}</li>
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
                        <span class="icon mr-3"><img src="{{ asset('images/rides.png') }}"></span>
                        <h3 class="mb-0">{{trans('lang.rides')}}</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>

                    <div class="d-flex top-title-right align-self-center">
                        <div class="select-box pl-3">
                            <select class="form-control status_selector filteredRecords">
                                <option value="" selected>{{trans("lang.status")}}</option>
                                <option value="Order Placed">{{trans("lang.order_placed")}}</option>
                                <option value="Order Accepted">{{trans("lang.order_accepted")}}</option>
                                <option value="Order Rejected">{{trans("lang.order_rejected")}}</option>
                                <option value="Driver Pending">{{trans("lang.driver_pending")}}</option>
                                <option value="Driver Rejected">{{trans("lang.driver_rejected")}}</option>
                                <option value="Order Shipped">{{trans("lang.order_shipped")}}</option>
                                <option value="In Transit">{{trans("lang.in_transit")}}</option>
                                <option value="Order Completed">{{trans("lang.order_completed")}}</option>
                            </select> 
                        </div>
                        <div class="select-box pl-3">
                                    <select class="form-control rides_selector filteredRecords">
                                        <option value="">{{trans("lang.rides")}}</option>
                                        <option value="ride">{{trans("lang.ride")}}</option>
                                        <option value="intercity">{{trans("lang.intercity")}}</option>
                                    </select>
                                </div>
                        <div class="select-box pl-3">
                            <div id="daterange"><i class="fa fa-calendar"></i>&nbsp;
                                <span></span>&nbsp; <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg--1">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                       <div class="card-box-with-content">
                                        <h4 class="text-dark-2 mb-1 h4 order_count" id="order_count"></h4>
                                        <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_rides')}}</p>
                                       </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/total_rides.png') }}"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg--5">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                       <div class="card-box-with-content">
                                        <h4 class="text-dark-2 mb-1 h4 placed_count" id="placed_count"></h4>
                                        <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_order_placed')}}</p>
                                       </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/order_placed.png') }}"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg--6">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                       <div class="card-box-with-content">
                                        <h4 class="text-dark-2 mb-1 h4 accepted_count" id="accepted_count"></h4>
                                        <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_order_accepted')}}</p>
                                       </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/order_accepted.png') }}"></span>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg--8">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                       <div class="card-box-with-content">
                                        <h4 class="text-dark-2 mb-1 h4 order_completed" id="order_completed"></h4>
                                        <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_order_completed')}}</p>
                                       </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/order_completed.png') }}"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

       </div>
       <div class="table-list">
       <div class="row">
           <div class="col-12">
           <?php if ($id != '') { ?>
                    <div class="menu-tab vendorMenuTab">
                        <ul>
                            <li>
                                <a href="{{route('drivers.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="{{route('drivers.vehicle',$id)}}">{{trans('lang.vehicle')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('drivers.ride',$id)}}">{{trans('lang.order_plural')}}</a>
                            </li>
                            <li>
                                <a href="{{route('driver.payouts',$id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li>
                                <a href="{{route('payoutRequests.drivers.view',$id)}}" >{{trans('lang.tab_payout_request')}}</a>
                            </li>
                            <li>
                                <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                             </li>

                        </ul>
                    </div>
                    <?php } ?>
               <div class="card border">
                 <div class="card-header d-flex justify-content-between align-items-center border-0">
                   <div class="card-header-title">
                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.rides')}}</h3>
                    <p class="mb-0 text-dark-2">{{trans('lang.rides_table_text')}}</p>
                   </div>             
                 </div>
                 <div class="card-body">
                         <div class="table-responsive m-t-10">
                         <table id="example24" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      
                                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>
                                        <th class="delete-all">
                                            <input type="checkbox" id="is_active">
                                            <label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a>
                                            </label>
                                        </th>
                                        <?php }?>

                                        <th>{{trans('lang.order_id')}}</th>
                                        <th>{{trans('lang.order_user_id')}}</th>
                                        <?php if ($id == '') { ?>
                                        <th class="driverClass">{{trans('lang.driver_plural')}}</th>
                                        <?php } ?>
                                        <th>{{trans('lang.ridetype')}}</th>
                                        <th>{{trans('lang.address')}}</th>
                                        <th>{{trans('lang.amount')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.status')}}</th>
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

                var database = firebase.firestore();
                var id = '<?php echo $id; ?>';
                var sosId = '<?php echo @$sosId; ?>';
                var offest = 1;
                var pagesize = 10;
                var end = null;
                var endarray = [];
                var start = null;
                var user_number = [];
                var data = '';
                var user_permissions = '<?php echo @session('user_permissions') ?>';
                user_permissions = JSON.parse(user_permissions);
                var checkDeletePermission = false;
                if ($.inArray('rides.delete', user_permissions) >= 0) {
                    checkDeletePermission = true;
                }

             


                if (id != '') {
                    getDriverInfo(id);
                    var wallet_route = "{{route('users.walletstransaction','id')}}";
                    $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+id));
                    var ref = database.collection('rides').where('driverID', '==', id).orderBy('createdAt', 'desc');
                } else if (sosId != '') {
                    var ref = database.collection('rides').where('id', '==', sosId).orderBy('createdAt', 'desc');

                } else {
                    var ref = database.collection('rides').orderBy('createdAt', 'desc');

                }
                var alldriver = database.collection('users').where("id", "==", id).orderBy('createdAt', 'desc');
                var placeholderImage = '';
                var append_list = '';
                var refCurrency = database.collection('currencies').where('isActive', '==', true);
                refCurrency.get().then(async function (snapshots) {
                    var currencyData = snapshots.docs[0].data();
                    currentCurrency = currencyData.symbol;
                    currencyAtRight = currencyData.symbolAtRight;
                });

                $('.status_selector').select2({
                    placeholder: '{{trans("lang.status")}}',  
                    minimumResultsForSearch: Infinity,
                    allowClear: true 
                });
                $('.rides_selector').select2({
                    placeholder: '{{trans("lang.rides")}}',  
                    minimumResultsForSearch: Infinity,
                    allowClear: true 
                });
                $('select').on("select2:unselecting", function(e) {
                    var self = $(this);
                    setTimeout(function() {
                        self.select2('close');
                    }, 0);
                });

                function setDate() {
                    $('#daterange span').html('{{trans("lang.select_range")}}');
                    $('#daterange').daterangepicker({
                        autoUpdateInput: false, 
                    }, function (start, end) {
                        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        $('.filteredRecords').trigger('change'); 
                    });
                    $('#daterange').on('apply.daterangepicker', function (ev, picker) {
                        $('#daterange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
                        $('.filteredRecords').trigger('change');
                    });
                    $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
                        $('#daterange span').html('{{trans("lang.select_range")}}');
                        $('.filteredRecords').trigger('change'); 
                    });
                }
                setDate(); 
                var initialRef=ref;
                $('select').change(async function() {
                    var status=$('.status_selector').val();
                    var rides=$('.rides_selector').val();
                    var daterangepicker = $('#daterange').data('daterangepicker');
                    var refData=initialRef; 

                    if(status) {
                        refData=refData.where('status','==',status);
                    }
                    
                    if(rides) {
                        refData=refData.where('rideType','==',rides);
                    }
                  
                    if ($('#daterange span').html() != '{{trans("lang.select_range")}}' && daterangepicker) {
                        var from = moment(daterangepicker.startDate).toDate();
                        var to = moment(daterangepicker.endDate).toDate();
                        if (from && to) { 
                            var fromDate = firebase.firestore.Timestamp.fromDate(new Date(from));
                            refData = refData.where('createdAt', '>=', fromDate);
                            var toDate = firebase.firestore.Timestamp.fromDate(new Date(to));
                            refData = refData.where('createdAt', '<=', toDate);
                        }
                    }
                    ref=refData;
                    $('#example24').DataTable().ajax.reload(null, false); 
                });


                $(document).ready(function () {


                    database.collection('rides').get().then((snapshot) => {
                        jQuery("#order_count").empty();
                        jQuery("#order_count").text(snapshot.docs.length);
                    });

                    database.collection('rides').where('status', 'in', ["Order Placed"]).get().then((snapshot) => {
                        jQuery("#placed_count").empty();
                        jQuery("#placed_count").text(snapshot.docs.length);
                    });

                    database.collection('rides').where('status', 'in', ["Order Accepted"]).get().then((snapshot) => {
                        jQuery("#accepted_count").empty();
                        jQuery("#accepted_count").text(snapshot.docs.length);
                    });

                    database.collection('rides').where('status', 'in', ["Order Completed"]).get().then((snapshot) => {
                        jQuery("#order_completed").empty();
                        jQuery("#order_completed").text(snapshot.docs.length);
                    });


                    var placeholder = database.collection('settings').doc('placeHolderImage');
                    placeholder.get().then(async function (snapshotsimage) {
                        var placeholderImageData = snapshotsimage.data();
                        placeholderImage = placeholderImageData.image;
                    })

                    jQuery("#data-table_processing").show();

                    $(document).on('click', '.dt-button-collection .dt-button', function () {
                        $('.dt-button-collection').hide();
                        $('.dt-button-background').hide();
                    });

                    $(document).on('click', function (event) {
                        if (!$(event.target).closest('.dt-button-collection, .dt-buttons').length) {
                            $('.dt-button-collection').hide();
                            $('.dt-button-background').hide();
                        }
                    });
                   
       
                    var fieldConfig = {
                        columns: [
                            { key: 'userName', header: "{{ trans('lang.order_user_id')}}" },
                            <?php if ($id == '') { ?>
                                { key: 'driverName', header: "{{ trans('lang.driver')}}" },
                            <?php } ?>
                           
                            { key: 'rideType', header: "{{trans('lang.ridetype')}}" },
                            { key: 'destinationLocationName', header: "{{trans('lang.address')}}" },
                            { key: 'total_price', header: "{{trans('lang.amount')}}" },
                            { key: 'createdAt', header: "{{trans('lang.date')}}" },
                            { key: 'status', header: "{{trans('lang.status')}}" },
                            
                        ],
                        fileName: "{{trans('lang.ride_list')}}",
                    };
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

                            const orderableColumns = (checkDeletePermission) ? (id === '') ? ['','id','userName','driverName','rideType','destinationLocationName','total_price','createdAt','status',''] : ['','id','userName','rideType','destinationLocationName','total_price','createdAt','status',''] : (id === '') ? ['id','userName','driverName','rideType','address','total_price','createdAt','status',''] : ['id','userName','rideType','address','total_price','createdAt','status',''];

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
                                    var total_price = parseFloat(childData.subTotal).toFixed(2);
                                    var discount = parseFloat(childData.discount).toFixed(2);
                                    total_price = total_price - discount;
                                    try {
                                        if (childData.tax) {
                                            if (childData.taxType && childData.tax) {
                                                if (childData.taxType == "percent") {
                                                    tax = (childData.tax * total_price) / 100;
                                                } else {
                                                    tax = childData.tax;
                                                }
                                                tax = parseFloat(tax).toFixed(2);
                                                if (!isNaN(tax) && tax != 0) {
                                                    total_price = total_price + parseFloat(tax);
                                                }
                                            }
                                        }
                                    } catch (error) {
                                        console.log("Tax calculation error -->",error);
                                    }

                                    var tip_amount = parseFloat(childData.tip_amount).toFixed(2);
                                    if (!isNaN(tip_amount) && tip_amount != 0) {
                                        total_price = total_price + tip_amount;
                                    }
                                    if (currencyAtRight) {
                                        total_price = parseFloat(total_price).toFixed(2) + "" + currentCurrency;
                                    } else {
                                        total_price = currentCurrency + "" + parseFloat(total_price).toFixed(2);
                                    }
                                    childData.total_price = total_price ? total_price : 0.00;
                                    var userName = childData.author ? childData.author.firstName : '';
                                    childData.userName = userName ? userName : '';
                                    var driverName = childData.driver ? childData.driver.firstName : '';
                                    childData.driverName = driverName ? driverName : '';
                                    if (searchValue) {
                                        var date = '';
                                        var time = '';
                                        if (childData.hasOwnProperty("createdAt") && childData.createdAt != '') {
                                            try {
                                                date = childData.createdAt.toDate().toDateString();
                                                time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                                            } catch (err) {

                                            }
                                        }
                                        var createdAt = date + ' ' + time ;
                                        if (
                                            (childData.id && childData.id.toLowerCase().includes(searchValue)) ||
                                            (childData.rideType && childData.rideType.toLowerCase().includes(searchValue)) ||
                                            (childData.status && childData.status.toLowerCase().includes(searchValue)) ||
                                            (childData.total_price && childData.total_price.toLowerCase().includes(searchValue)) ||
                                            (childData.destinationLocationName && childData.destinationLocationName.toLowerCase().includes(searchValue)) ||
                                            (userName && userName.toLowerCase().includes(searchValue)) ||
                                            (driverName && driverName.toLowerCase().includes(searchValue)) ||
                                            (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1)
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
                                    if (orderByField === 'createdAt' && a[orderByField] != '' && b[orderByField] != '') {
                                        try {
                                            aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                                            bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                                        } catch (err) {
                                        }
                                    }
                                    if (orderByField === 'total_price') {
                                        aValue = a[orderByField] ? parseFloat(a[orderByField].replace(/[^0-9.-]+/g, '')) : 0;
                                        bValue = b[orderByField] ? parseFloat(b[orderByField].replace(/[^0-9.-]+/g, '')) : 0;
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
                                    filteredData: filteredRecords,
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
                        order: (checkDeletePermission) ? (id === '') ? [[7, "desc"]] : [[6, "desc"]] : (id === '') ? [[6, "desc"]] : [[5, "desc"]],
                        columnDefs: [
                            {
                                targets: (checkDeletePermission) ? (id === '') ? [7] : [6] : (id === '') ? [6] : [5],
                                type: 'date',
                                render: function(data) {
                                    return data;
                                }
                            },
                            {orderable: false, targets: (checkDeletePermission) ? (id === '') ? [0,8,9] : [0,8] : (id === '') ? [7,8] : [7]},
                        ],
                        "language": {
                            "zeroRecords": "{{trans('lang.no_record_found')}}",
                            "emptyTable": "{{trans('lang.no_record_found')}}",
                            "processing": "" // Remove default loader
                        },
                        dom: 'lfrtipB',
            buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="mdi mdi-cloud-download"></i> Export as',
                        className: 'btn btn-info',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: 'Export Excel',
                                action: function (e, dt, button, config) {
                                    exportData(dt, 'excel',fieldConfig);
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: 'Export PDF',
                                action: function (e, dt, button, config) {
                                    exportData(dt, 'pdf',fieldConfig);
                                }
                            },   
                            {
                                extend: 'csvHtml5',
                                text: 'Export CSV',
                                action: function (e, dt, button, config) {
                                    exportData(dt, 'csv',fieldConfig);
                                }
                            }
                        ]
                    }
            ],
            initComplete: function() {
                $(".dataTables_filter").append($(".dt-buttons").detach());
                $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete','new-password').val('');
                $('.dataTables_filter label').contents().filter(function() {
                    return this.nodeType === 3; 
                }).remove();
            }
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

                    alldriver.get().then(async function (snapshotsdriver) {

                        snapshotsdriver.docs.forEach((listval) => {
                            database.collection('rides').where('driverID', '==', listval.id).where("status", "in", ["Order Completed"]).get().then(async function (orderSnapshots) {
                                var count_order_complete = orderSnapshots.docs.length;
                                database.collection('users').doc(listval.id).update({'orderCompleted': count_order_complete}).then(function (result) {

                                });

                            });

                        });
                    });

                });

                async function buildHTML(val) {
                    var html = [];

                    newdate = '';
                    var id = val.id;
                    var user_id = val.author.id;
                    var route1 = '{{route("rides.edit",":id")}}';
                    route1 = route1.replace(':id', id);
                    var customer_view = '{{route("users.view",":id")}}';
                    customer_view = customer_view.replace(':id', user_id);

                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>
                        html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                            'for="is_open_' + id + '" ></label></td>');
                    <?php }?>
                    html.push('<td><a href="'+route1+'" class="redirecttopage">' + val.id + '</a></td>');
                    html.push('<td><a href="'+customer_view+'" class="redirecttopage">' + val.userName + '</a></td>');
                    if ('<?php echo $id; ?>' == "") {
                        if (val.hasOwnProperty("driver")) {
                            var driverId = val.driver.id;
                            var diverRoute = '{{route("drivers.view",":id")}}';
                            diverRoute = diverRoute.replace(':id', driverId);
                            html.push('<td><a href="'+diverRoute+'" class="redirecttopage">'+ val.driverName + '</a></td>');
                        } else {
                            html.push('<td></td>');
                        }
                    }
                    if (val.hasOwnProperty('rideType')) {
                        html.push('<td>' + val.rideType + '</td>');
                    } else {
                        html.push('<td></td>');
                    }
                    html.push('<td>' + val.destinationLocationName + '</td>');

                    html.push('<td>' + val.total_price + '</td>');
                    var date = '';
                    var time = '';
                    if (val.hasOwnProperty("createdAt")) {
                        try {
                            date = val.createdAt.toDate().toDateString();
                            time = val.createdAt.toDate().toLocaleTimeString('en-US');
                        } catch (err) {

                        }
                        html.push('<td class="dt-time">' + date + ' ' + time + '</td>');
                    } else {
                        html.push('<td></td>');
                    }

                    if (val.status == 'Order Completed') {
                        html.push('<td><span class="badge badge-success">Order Completed</span></td>');
                    } else if (val.status == 'Order Rejected') {
                        html.push('<td><span class="badge badge-danger">Order Rejected</span></td>');
                    } else {
                        html.push('<td><span class="badge badge-danger">Pending</span></td>');
                    }
                    var action = '';
                    action = action + '<span class="action-btn"><a href="' + route1 + '"><i class="mdi mdi-lead-pencil"></i></a>';
                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>

                    action = action + '<a id="' + val.id + '" name="driver-delete" class="delete-btn" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a>';
                    <?php }?>
                    action = action + '</span>';

                    html.push(action);
                    return html;
                }

                $(document.body).on('click', '.redirecttopage', function () {
                    var url = $(this).attr('data-url');
                    window.location.href = url;
                });
                $(document.body).on('change', '#selected_search', function () {
                    jQuery('#ride_type').hide();
                    if (jQuery(this).val() == 'rideType') {
                        jQuery('#ride_type').show();
                        jQuery('#search').hide();

                    } else {

                        jQuery('#ride_type').hide();
                        jQuery('#search').show();

                    }
                });

                $(document).on("click", "a[name='driver-delete']", function (e) {
                    var id = this.id;
                    database.collection('rides').doc(id).delete().then(function () {
                        window.location.reload();
                    });


                });


                $("#is_active").click(function () {
                    $("#example24 .is_open").prop('checked', $(this).prop('checked'));

                });

                $("#deleteAll").click(function () {
                    if ($('#example24 .is_open:checked').length) {
                        if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                            jQuery("#data-table_processing").show();
                            $('#example24 .is_open:checked').each(function () {
                                var dataId = $(this).attr('dataId');
                                database.collection('rides').doc(dataId).delete().then(function () {
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 5000);
                                });
                            });
                        }
                    } else {
                        alert("{{trans('lang.select_delete_alert')}}");
                    }
                });

async function getDriverInfo(driverId){
   
            await database.collection('users').where("id", "==", driverId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var driver_data = snapshotss.docs[0].data();
                driverName = driver_data.firstName + " " + driver_data.lastName;
                $('.page-title').html("{{trans('lang.rides')}}  - "+driverName);
            }
        });

}

</script>

@endsection