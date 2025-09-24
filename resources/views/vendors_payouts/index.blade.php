@extends('layouts.app')



@section('content')



<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.vendors_payout_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.vendors_payout_plural')}}</li>
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
                        <span class="icon mr-3"><img src="{{ asset('images/payment.png') }}"></span>
                        <h3 class="mb-0">{{trans('lang.vendors_payout_plural')}}</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>
                </div>
            </div>
        </div> 
       </div>
       <div class="table-list">
       <div class="row">
           <div class="col-12">
                <?php if ($id != '') { ?>
                    <div class="menu-tab">

                        <ul>

                            <li>

                                <a href="{{route('vendors.view',$id)}}">{{trans('lang.tab_basic')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.items',$id)}}">{{trans('lang.tab_items')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.orders',$id)}}">{{trans('lang.tab_orders')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.reviews',$id)}}">{{trans('lang.tab_reviews')}}</a>

                            </li>

                            <li>

                                <a href="{{route('vendors.coupons',$id)}}">{{trans('lang.tab_promos')}}</a>

                            <li class="active">

                                <a href="{{route('vendors.payout',$id)}}">{{trans('lang.tab_payouts')}}</a>

                            </li>

                            <li>

                                <a href="{{route('payoutRequests.vendor.view',$id)}}">{{trans('lang.tab_payout_request')}}</a>

                            </li>

                            <li>

                                <a  class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>

                            </li>

                            <li class="dine_in_future" style="display:none;">

                                <a href="{{route('vendors.booktable',$id)}}">{{trans('lang.dine_in_future')}}</a>

                            </li>
                            <?php
                            $subscription =  route("subscription.subscriptionPlanHistory", ":id");
                            $subscription =  str_replace(":id", "storeID=" . $id, $subscription);
                            ?>
                            <li>
                                <a href="{{ $subscription }}">{{trans('lang.subscription_history')}}</a>
                            </li>

                        </ul>

                    </div>
                <?php } ?>
               <div class="card border">
                 <div class="card-header d-flex justify-content-between align-items-center border-0">
                   <div class="card-header-title">
                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.vendors_payout_plural')}}</h3>
                    <p class="mb-0 text-dark-2">{{trans('lang.vendors_payouts_table_text')}}</p>
                   </div>
                   <div class="card-header-right d-flex align-items-center">
                    <div class="card-header-btn mr-3"> 
                        <?php if ($id != '') { ?>  
                            <a class="btn-primary btn rounded-full" href="{!! route('vendorsPayouts.create') !!}/{{$id}}"><i class="mdi mdi-plus mr-2"></i>{{trans('lang.vendors_payout_create')}}</a>
                        <?php } else { ?>
                            <a class="btn-primary btn rounded-full" href="{!! route('vendorsPayouts.create') !!}"><i class="mdi mdi-plus mr-2"></i>{{trans('lang.vendors_payout_create')}}</a>
                        <?php } ?>
                    </div>
                   </div>                
                 </div>
                 <div class="card-body">
                         <div class="table-responsive m-t-10">
                         <table id="example24"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                    <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll"
                                    class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label></th>
                               
                                    <?php if ($id == '') { ?>

                                        <th>{{ trans('lang.vendor')}}</th>

                                    <?php } ?>

                                        <th>{{trans('lang.paid_amount')}}</th>

                                        <th>{{trans('lang.date')}}</th>

                                        <th>{{trans('lang.vendors_payout_note')}}</th>

                                        <th>Admin {{trans('lang.vendors_payout_note')}}</th>

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

    var offest = 1;

    var pagesize = 10;

    var end = null;

    var endarray = [];

    var start = null;

    var user_number = [];



    var intRegex = /^\d+$/;

    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    var vendorID="{{$id}}"; 

    <?php if ($id != '') { ?>




    var refData = database.collection('payouts').where('vendorID', '==', '<?php echo $id; ?>').where('paymentStatus', '==', 'Success');

    var ref = refData.orderBy('paidDate', 'desc');

    getStoreNameFunction('<?php echo $id; ?>');

    <?php } else { ?>

    var refData = database.collection('payouts').where('paymentStatus', '==', 'Success');

    var ref = refData.orderBy('paidDate', 'desc');

    <?php } ?>



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



        var inx = parseInt(offest) * parseInt(pagesize);

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
                <?php if ($id == '') { ?>
                    { key: 'title', header: "{{ trans('lang.vendor')}}" },
                <?php } ?>
             
                { key: 'amount', header: "{{ trans('lang.paid_amount')}}" },
                { key: 'createdAt', header: "{{trans('lang.date')}}" },
                { key: 'adminNote', header: "{{trans('lang.advendors_payout_note')}}" },
                { key: 'note', header: "{{trans('lang.vendors_payout_note')}}" },
            ],
            fileName: "{{trans('lang.vendors_payout_table')}}",
        };



          const table = $('#example24').DataTable({

            pageLength: 10, // Number of rows per page

            processing: false, // Show processing indicator

            serverSide: true, // Enable server-side processing

            responsive: true,

            ajax: async function (data, callback, settings) {

                const start = data.start;

                const length = data.length;

                const searchValue = data.search.value.toLowerCase();

                const orderColumnIndex = data.order[0].column;

                const orderDirection = data.order[0].dir;

                var orderableColumns = ['','title','amount','createdAt','note','adminNote','']; // Ensure this matches the actual column names

                const orderByField = orderableColumns[orderColumnIndex]; // Adjust the index to match your table

                if (searchValue.length >= 3 || searchValue.length === 0) {

                    $('#data-table_processing').show();

                }



            await ref.get().then(async function (querySnapshot) {

                if (querySnapshot.empty) {

                    $('.total_count').text(0); 

                    console.error("No data found in Firestore.");

                    $('#data-table_processing').hide(); // Hide loader

                    callback({

                        draw: data.draw,

                        recordsTotal: 0,

                        recordsFiltered: 0,

                        data: [] // No data

                    });

                    return;

                }

           

            let records = [];

            let filteredRecords = [];



            await Promise.all(querySnapshot.docs.map(async (doc) => {

                let childData = doc.data();  

                childData.id = doc.vendorID; // Ensure the document ID is included in the data

                childData.recid=doc.id;

                const vendor = await payoutVendor(childData.vendorID);

                if (!vendor) {

                    return;

                }

                childData.title = vendor;

                if (searchValue) {

                    var date = '';

                    var time = '';

                    if (childData.hasOwnProperty("paidDate")) {

                        try {

                            date = childData.paidDate.toDate().toDateString();

                            time = childData.paidDate.toDate().toLocaleTimeString('en-US');

                        } catch (err) {

                        }

                    }

                    var createdAt = date + ' ' + time;

                    if (

                        (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||

                        (childData.amount && childData.amount.toString().toLowerCase().includes(searchValue)) ||

                        (createdAt && createdAt.toString().toLowerCase().includes(searchValue)) ||

                        (childData.note && childData.note.toString().toLowerCase().includes(searchValue)) ||

                        (childData.adminNote && childData.adminNote.toString().toLowerCase().includes(searchValue)) 

                    ) {

                        filteredRecords.push(childData);

                    }

                } else {

                    filteredRecords.push(childData);

                }

            }));

  

            filteredRecords.sort((a, b) => {

                let aValue = a[orderByField];

                let bValue = b[orderByField];

                if (orderByField === "title") {
                    aValue = a[orderByField].toLowerCase().trim();
                    bValue = b[orderByField].toLowerCase().trim();
                }

                if (orderByField === 'createdAt') {

                    try {

                        aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;

                        bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;

                    } catch (err) {



                    }

                }

            

                if (orderByField === 'amount') {

                   

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



            await Promise.all(paginatedRecords.map(async (childData) => {

                if(childData.hasOwnProperty('title') || childData.title != null || childData.title!=''){

                    var getData = await buildHTML(childData);

                    records.push(getData);                  

                }

  

            }));





            $('#data-table_processing').hide(); // Hide loader

            callback({

                draw: data.draw,

                recordsTotal: totalRecords, // Total number of records in Firestore

                recordsFiltered: totalRecords, // Number of records after filtering (if any)

                filteredData: filteredRecords,

                data: records // The actual data to display in the table

            });

        }).catch(function (error) {

            console.error("Error fetching data from Firestore:", error);

            $('#data-table_processing').hide(); // Hide loader

            callback({

                draw: data.draw,

                recordsTotal: 0,

                recordsFiltered: 0,

                data: [] // No data due to error

            });

        });

    },

    <?php if($id == '') { ?>

        columnDefs: [{

            targets: 3,

            type: 'date',

            render: function (data) {

                return data;

            }

        },

            {orderable: false, targets: [0,4,6]},

        ],

        order: [3, "desc"],

    <?php } else { ?>

        columnDefs: [{

            targets: 2,

            type: 'date',

            render: function (data) {

                return data;

            }

        },

            {orderable: false, targets: [0,3,5]},

        ],

        order: [2, "desc"],

    <?php } ?>

        "language": {

            "zeroRecords": "{{trans("lang.no_record_found")}}",

            "emptyTable": "{{trans("lang.no_record_found")}}",

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



    });





    function getStoreNameFunction(vendorId) {

        var vendorName = '';

        database.collection('vendors').where('id', '==', vendorId).get().then(function (snapshots) {

            var vendorData = snapshots.docs[0].data();

            vendorName = vendorData.title;

            $(".storeTitle").text(' - ' + vendorName);

            if (vendorData.dine_in_active == true) {

                $(".dine_in_future").show();

            }
            var wallet_route = "{{route('users.walletstransaction','id')}}";

            $(".wallet_transaction").attr("href", wallet_route.replace('id', 'storeID='+vendorData.author));


        });

        return vendorName;

    }



    async function buildHTML(val) {

        var html = [];

        var count = 0;

        if (val.title) {



            var amount = '';

            var price = val.amount;



            if (intRegex.test(price) || floatRegex.test(price)) {



                price = parseFloat(price).toFixed(decimal_degits);

            } else {

                price = 0;

            }



            if (currencyAtRight) {  

                amount = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;

            } else {

                amount = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);

            }

            html.push('<input type="checkbox" id="is_open_' + val.recid + '" class="is_open" dataId="' + val.recid + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + val.recid + '" ></label>');

            var route = '{{route("vendors.view",":id")}}';

            route = route.replace(':id', val.id);

            <?php if($id == '') { ?>
                html.push('<td><a href="' + route + '">' + val.title + '</a></td>');
            <?php  } ?>

            html.push('<td>' + amount + '</td>');



            var date = '';

            var time = '';

            if (val.hasOwnProperty("paidDate")) {

                try {

                    date = val.paidDate.toDate().toDateString();

                    time = val.paidDate.toDate().toLocaleTimeString('en-US');

                } catch (err) {



                }

                html.push('<td>' + date + ' ' + time + '</td>');

            } else {

                html.push('<td></td>');

            }

            

            if (val.note != undefined && val.note != '') {

                html.push('<td>' + val.note + '</td>');

            } else {

                html.push('<td></td>');

            }

            if (val.adminNote != undefined && val.adminNote != '') {

                html.push('<td>' + val.adminNote + '</td>');

            } else {

                html.push('<td></td>');

            }
           

        }
         html.push('<span class="action-btn"><a id="' + val.recid + '" class="delete-btn" name="store_payouts-delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a></span>');    
        
        

        return html;

    }


    $("#is_active").click(function () {
        $("#example24 .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function () {
        if ($('#example24 .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#example24 .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('payouts').doc(dataId).delete().then(function () {
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

    $(document).on("click", "a[name='store_payouts-delete']", function (e) {
        var id = this.id;
        database.collection('payouts').doc(id).delete().then(function () {
            window.location.reload();
        });


    });


    async function payoutVendor(vendor) {

        var payoutVendor = '';



        await database.collection('vendors').where("id", "==", vendor).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var vendor_data = snapshotss.docs[0].data();

                payoutVendor = vendor_data.title;

            }

        });

        return payoutVendor;

    }



</script>





@endsection