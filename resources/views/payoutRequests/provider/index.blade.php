@extends('layouts.app')



@section('content')



<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.payout_request')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.payout_request')}}</li>
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
                        <h3 class="mb-0">{{trans('lang.provider_payout_request')}}</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>
                 
                </div>
            </div>
        </div> 
       </div>
       <div class="table-list">
       <div class="row">
           <div class="col-12">
            
           @if($id !='' )

            <div class="resttab-sec">

                <div class="menu-tab tabDiv">

                    <ul>

                        <li ><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>

                        </li>

                        <li><a href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a></li>

                        <li>

                        <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a></li>

                        <li>

                        <li><a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a></li>

                        <li>

                        <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>

                        <li>

                            <a href="{{route('providerPayouts.payout', $id)}}">{{trans('lang.tab_payouts')}}</a>

                        </li>

                        <li class="active">

                            <a href="{{route('payoutRequests.providers', $id)}}">{{trans('lang.tab_payout_request')}}</a>

                        </li>

                        <li>

                            <a href="{{route('users.walletstransaction',$id)}}"

                                class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>

                        </li> 
                        <?php 
                     
                            $subscription =  route("subscription.subscriptionPlanHistory", ":id");
                            $subscription =  str_replace(":id", "providerID=" . $id, $subscription);
                            ?>
                        <li> 
                            <a href="{{ $subscription }}">{{trans('lang.subscription_history')}}</a>
                        </li>

                    </ul>

                </div>

            </div>

          @endif
               <div class="card border">
                 <div class="card-header d-flex justify-content-between align-items-center border-0">
                   <div class="card-header-title">
                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.provider_payout_request')}}</h3>
                    <p class="mb-0 text-dark-2">{{trans('lang.provider_payouts_table_text')}}</p>
                   </div>    
                    
                </div>     
              
            

                 <div class="card-body">
                        <div class="table-responsive m-t-10">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">

                            @if($id == '')

                            
                            <li class="nav-item">

                                <a class="nav-link" href="{!! url('payoutRequests/vendor') !!}"><i

                                            class="mdi mdi-format-list-bulleted mr-2"></i>{{trans('lang.vendors_payout_request')}}</a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="{!! url('payoutRequests/drivers') !!}"><i

                                            class="mdi mdi-format-list-bulleted mr-2"></i>{{trans('lang.drivers_payout_request')}}</a>

                            </li>

                            @endif

                            
                            <li class="nav-item">

                                <a class="nav-link active" href="{!! url('payoutRequests/providers') !!}"><i

                                            class="mdi mdi-format-list-bulleted mr-2"></i>{{trans('lang.providers_payout_request')}}</a>

                            </li>



                        </ul>
                         <table id="example24"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                    <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll"
                                    class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label></th>
                                    @if($id == '')

                                        <th>{{ trans('lang.provider')}}</th>

                                    @endif

                                    <th>{{trans('lang.paid_amount')}}</th>

                                    <th>{{trans('lang.vendors_payout_note')}}</th>

                                    <th>{{trans('lang.date')}}</th>

                                    <th>{{trans('lang.status')}}</th>

                                    <th>{{trans('lang.withdraw_method')}}</th>

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





<div class="modal fade" id="bankdetailsModal" tabindex="-1" role="dialog"

     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered location_modal">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title locationModalTitle">{{trans('lang.bankdetails')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form class="">

                    <div class="form-row">

                        <input type="hidden" name="providerId" id="providerId">

                        <div class="form-group row">

                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.bank_name')}}</label>

                                <div class="col-12">

                                    <input type="text" name="bank_name" class="form-control" id="bankName">

                                </div>

                            </div>

                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.branch_name')}}</label>

                                <div class="col-12">

                                    <input type="text" name="branch_name" class="form-control" id="branchName">

                                </div>

                            </div>

                            <div class="form-group row width-100">

                                <label class="col-4 control-label">{{

                                    trans('lang.holer_name')}}</label>

                                <div class="col-12">

                                    <input type="text" name="holer_name" class="form-control" id="holderName">

                                </div>

                            </div>

                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.account_number')}}</label>

                                <div class="col-12">

                                    <input type="text" name="account_number" class="form-control" id="accountNumber">

                                </div>

                            </div>

                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{

                                    trans('lang.other_information')}}</label>

                                <div class="col-12">

                                    <input type="text" name="other_information" class="form-control" id="otherDetails">

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary save-form-btn" id="submit_accept">

                        {{trans('lang.accept')}}</a>

                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">

                        {{trans('close')}}</a>

                    </button>

                </div>

            </div>

        </div>



    </div>

</div>



<div class="modal fade" id="cancelRequestModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title locationModalTitle">{{trans('lang.cancel_payout_request')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div id="data-table_processing_modal" class="dataTables_processing panel panel-default"

                        style="display: none;">{{trans('lang.processing')}}

                </div>

                <form class="">

                    <div class="form-row">

                        <div class="form-group row">

                            <div class="form-group row width-100">

                                <label class="col-12 control-label">{{trans('lang.notes')}}</label>

                                <div class="col-12">

                                    <textarea name="admin_note" class="form-control" id="admin_note" cols="5" rows="5"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

                <div class="modal-footer">

                    <button type="button" class="btn btn-primary save-form-btn" id="submit_cancel">

                        {{trans('lang.submit')}}</a>

                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">

                        {{trans('lang.close')}}</a>

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="payoutResponseModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">{{trans('lang.payout_response')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="payout-response"></div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">

                    {{trans('lang.close')}}</a>

                </button>

            </div>

        </div>

    </div>

</div>



@endsection





@section('scripts')



<script type="text/javascript">



    var id = '<?php echo $id; ?>';

    var database = firebase.firestore();

  



    var intRegex = /^\d+$/;

    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;



    if (id != "") {

        var refData = database.collection('payouts').where('vendorID', '==', id);

        getProviderName(id);
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID=' + id));


    } else {

        var refData = database.collection('payouts').where('paymentStatus', '==', 'Pending').where('role','==','provider');

    }



    var email_templates = database.collection('email_templates').where('type', '==', 'payout_request_status');



    var emailTemplatesData = null;



    var ref = refData.orderBy('paidDate', 'desc');



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



        email_templates.get().then(async function (snapshots) {



            emailTemplatesData = snapshots.docs[0].data();



        });



        $(document.body).on('click', '.redirecttopage', function () {

            var url = $(this).attr('data-url');

            window.location.href = url;

        });



       

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
                
                { key: 'amount', header: "{{ trans('lang.total_amount')}}" },
                { key: 'note', header: "{{trans('lang.note')}}" },
                { key: 'paidDate', header: "{{trans('lang.date')}}" },
                { key: 'paymentStatus', header: "{{trans('lang.payment_status')}}" },
                { key: 'withdrawMethod', header: "{{trans('lang.withdraw_method')}}" },
                
                
            ],
            fileName: "{{trans('lang.provider')}}  {{trans('lang.payment_plural')}}",
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

                @if($id == '')

                    const orderableColumns =  ['','title', 'amount', 'note', 'paidDate', 'paymentStatus','withdrawMethod','']; // Ensure this matches the actual column names

                @else

                    const orderableColumns =  ['','', 'amount', 'note', 'paidDate', 'paymentStatus','withdrawMethod',''];

                @endif

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

                childData.recid=doc.id;

                const provider = await payoutProvider(childData.vendorID);

                if (!provider) {

                    return;

                }

                childData.title = provider;

                var date = '';

                var time = '';

                if (childData.hasOwnProperty("paidDate") && childData.paidDate != '') {

                    try {

                        date = childData.paidDate.toDate().toDateString();

                        time = childData.paidDate.toDate().toLocaleTimeString('en-US');

                    } catch (err) {

                    }

                }

                

                var paidDate = date + ' ' + time;





                if (searchValue) {

                    

                    if (

                        (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||

                        (childData.amount && childData.amount.toString().toLowerCase().includes(searchValue)) ||

                        (childData.note && childData.note.toString().toLowerCase().includes(searchValue)) ||

                        (paidDate && paidDate.toString().toLowerCase().indexOf(searchValue) > -1) ||

                        (

                            (childData.paymentStatus && childData.paymentStatus.toString().toLowerCase().includes(searchValue))

                            ||

                            (childData.withdrawMethod && childData.withdrawMethod.toString().toLowerCase().includes(searchValue)) 

                        ) 

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



                 if (orderByField === 'paidDate' && a[orderByField] != '' && b[orderByField] != '') {

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

    columnDefs: [

        { orderable: false, targets: (id === "" ? [0, 5,6,7] : [0, 4,5,6]) },

    ],

    <?php if($id == '') { ?>

        order: [4, "desc"],

    <?php } else { ?>
        order: [3, "desc"],
        
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



    async function getProviderName(providerId) {

        var snapshots = await database.collection('users').doc(providerId).get();

        if(snapshots.exists){

            var providerData = snapshots.data();

            var providerName = providerData.firstName+' '+providerData.lastName;

            $('.providerTitle').html('{{trans("lang.payout_request")}} - ' + providerName);

        }

    }



    async function buildHTML(val) {

        var html = [];

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

        if (id == "") {

            var route_url = '{{route("providers.view",":id")}}';

            route_url = route_url.replace(':id', val.vendorID);

            html.push('<td><a href="' + route_url + '" class="redirecttopage ">'+val.title+'</a></td>');

        }

        

        html.push('<td>' + amount + '</td>');

        var date = val.paidDate.toDate().toDateString();

        var time = val.paidDate.toDate().toLocaleTimeString('en-US');

        html.push('<td>' + val.note + '</td>');

        html.push('<td>' + date + ' ' + time + '</td>');



        if (val.paymentStatus == 'Pending' || val.paymentStatus == 'In Process') {

            html.push('<span class="order_placed"><span>' + val.paymentStatus + '</span></span>');

        }else if (val.paymentStatus == 'Reject' || val.paymentStatus == 'Failed') {

            html.push('<span class="order_rejected"><span>' + val.paymentStatus + '</span></span>');

        }else if (val.paymentStatus == 'Success') {

            html.push('<span class="order_completed"><span>' + val.paymentStatus + '</span></span>');

        } else{

            html.push('');

        }



        if (val.withdrawMethod) {

            var selectedwithdrawMethod = (val.withdrawMethod == "bank") ? "Bank Transfer" : val.withdrawMethod;

            html.push('<td><span style="text-transform:capitalize">' + selectedwithdrawMethod + '</span></td>');

        } else {

            html.push('');

        }



        actionHtml = '';

        actionHtml = actionHtml + '<span class="action-btn">';



            if (val.paymentStatus != "Reject" && val.paymentStatus != "Success") {

                actionHtml = actionHtml + '<a id="' + val.id + '" name="vendor_view" data-auth="' + val.vendorID + '" data-amount = "' + amount + '" href="javascript:void(0)" data-toggle="modal" data-target="#bankdetailsModal" class="btn btn-info mb-2">Manual Pay</a>';

            }



            if (val.withdrawMethod && val.withdrawMethod != "bank" && val.paymentStatus != "Reject" && val.paymentStatus != "Success") {

                actionHtml = actionHtml + '<br>';

                actionHtml = actionHtml + '<a id="' + val.id + '" name="vendor_pay"  data-auth="' + val.vendorID + '" data-amount="' + price + '" data-method="'+val.withdrawMethod+'" href="javascript:void(0)" class="btn btn-success mb-2 direct-click-btn">Pay Online</a>';

            }



            if (val.paymentStatus != "Reject" && val.paymentStatus != "Success") {

                actionHtml = actionHtml + '<br>';

                actionHtml = actionHtml + '<a id="' + val.id + '" name="vendor_reject_request" data-toggle="modal" data-target="#cancelRequestModal" data-auth="' + val.vendorID + '" data-amount = "' + amount + '" data-price="' + price + '" href="javascript:void(0)" class="btn btn-primary mb-2">Cancel Request</a>';

            }



            if (val.paymentStatus == "In Process") {

                actionHtml = actionHtml + '<br>';

                actionHtml = actionHtml + '<a id="' + val.id + '" name="vendor_check_status" data-auth="' + val.vendorID + '" data-amount="' + price + '" data-method="'+val.withdrawMethod+'" href="javascript:void(0)" class="btn btn-dark mb-2">Check Payment Status</a>';

            }

        actionHtml = actionHtml + '</span>';

        actionHtml = actionHtml + '<span class="action-btn"><a id="' + val.recid + '" class="delete-btn" name="provider_payouts-delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a></span>';

        html.push(actionHtml);

       

        return html;

    }





    async function getProviderBankDetails() {

        var providerId = $('#providerId').val();

        await database.collection('users').where("id", "==", providerId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var user_data = snapshotss.docs[0].data();

                if (user_data.userBankDetails) {

                    $('#bankName').val(user_data.userBankDetails.bankName);

                    $('#branchName').val(user_data.userBankDetails.branchName);

                    $('#holderName').val(user_data.userBankDetails.holderName);

                    $('#accountNumber').val(user_data.userBankDetails.accountNumber);

                    $('#otherDetails').val(user_data.userBankDetails.otherDetails);

                }

            }

        });

    }



    $(document).on("click", "a[name='vendor_view']", function (e) {

        $('#bankName').val("");

        $('#branchName').val("");

        $('#holderName').val("");

        $('#accountNumber').val("");

        $('#otherDetails').val("");

        var id = this.id;

        var auth = $(this).attr('data-auth');

        var amount = $(this).attr('data-amount');

        $('#providerId').val(auth);

        getProviderBankDetails();

        $('#submit_accept').attr('data-id',id).attr('data-amount',amount).attr('data-auth',auth);

    });



    $(document).on("click", "a[name='vendor_pay']", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var data = {};

        data['payoutId'] = this.id;

        data['method'] = $(this).data('method');

        data['amount'] = $(this).data('amount');

        data['user'] =  await getUserData($(this).data('auth'));

        data['settings'] = await getPaymentSettings();

        if(data['method'] != "undefined"){

            $.ajax({

                type: 'POST',

                data: {

                    data: btoa(JSON.stringify(data)),

                },

                url: "{{url('pay-to-user')}}",

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                success: function (response) {

                    if(response.success == true){

                        $(".success_top").show().html("");

                        $(".success_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                        database.collection('payouts').doc(data['payoutId']).update({'paymentStatus': response.status,'payoutResponse' : response.result}).then(async function (result) {

                            if (data['user'] && data['user'] != undefined){

                                var emailData = await sendMailToRestaurant(data['user'], data['payoutId'], 'Approved', data['amount']);

                                if(emailData){

                                    window.location.reload();

                                }

                            }

                        });

                    }else{

                        $(".error_top").show().html("");

                        $(".error_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                        setTimeout(function(){

                            window.location.reload();

                        },5000);

                    }

                }

            });

        }

    });



    $(document).on("click", "a[name='vendor_check_status']", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var data = {};

        data['payoutId'] = this.id;

        data['method'] = $(this).data('method');

        data['amount'] = $(this).data('amount');

        data['user'] =  await getUserData($(this).data('auth'));

        data['settings'] = await getPaymentSettings();

        data['payoutDetail'] = await getPayoutDetail(data['payoutId']);

        if(data['method'] != "undefined"){

            $.ajax({

                type: 'POST',

                data: {

                    data: btoa(JSON.stringify(data)),

                },

                url: "{{url('check-payout-status')}}",

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                success: function (response) {

                    if(response.success == true){

                        $(".success_top").show().html("");

                        $(".success_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                    }else{

                        $(".error_top").show().html("");

                        $(".error_top").append("<p>"+response.message+"</p>");

                        window.scrollTo(0, 0);

                    }

                    $(this).prop('disabled',false).css({'cursor':'pointer','opacity':'1'});



                    if(response.result && response.status){

                        database.collection('payouts').doc(data['payoutId']).update({'paymentStatus': response.status,'payoutResponse' : response.result});

                        $("#payoutResponseModal .payout-response").html(JSON.stringify(JSON.parse(JSON.stringify(response.result)),null,4));

                        $("#payoutResponseModal").modal('show');

                    }

                }

            });

        }

    });



    async function sendMailToProvider(user, id, status, amount) {



        var formattedDate = new Date();

        var month = formattedDate.getMonth() + 1;

        var day = formattedDate.getDate();

        var year = formattedDate.getFullYear();



        month = month < 10 ? '0' + month : month;

        day = day < 10 ? '0' + day : day;



        formattedDate = day + '-' + month + '-' + year;



        var subject = emailTemplatesData.subject;



        subject = subject.replace(/{requestid}/g, id);

        emailTemplatesData.subject = subject;



        var message = emailTemplatesData.message;

        message = message.replace(/{username}/g, user.firstName + ' ' + user.lastName);

        message = message.replace(/{date}/g, formattedDate);

        message = message.replace(/{requestid}/g, id);

        message = message.replace(/{status}/g, status);

        message = message.replace(/{amount}/g, amount);

        message = message.replace(/{usercontactinfo}/g, user.phoneNumber);



        emailTemplatesData.message = message;



        var url = "{{url('send-email')}}";



        return await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [user.email]);

    }



    async function getUserData(vendorId) {

        var data = '';

        await database.collection('users').where("id", "==", proivderId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                data = snapshotss.docs[0].data();

            }

        });

        if(data.id){

            await database.collection('withdraw_method').where("userId", "==", data.id).get().then(async function (snapshotss) {

                if (snapshotss.docs.length) {

                    data['withdrawMethod'] = snapshotss.docs[0].data();

                }

            });

        }

        return data;

    }



    async function getPaymentSettings() {

        var settings = {};

        await database.collection('settings').get().then(async function (snapshots) {

            snapshots.forEach((doc) => {

                if(doc.id == "flutterWave"){

                    settings["flutterwave"] = doc.data();

                }

                if(doc.id == "paypalSettings"){

                    settings["paypal"] = doc.data();

                }

                if(doc.id == "razorpaySettings"){

                    settings["razorpay"] = doc.data();

                }

                if(doc.id == "stripeSettings"){

                    settings["stripe"] = doc.data();

                }

            });

        });

        return settings;

    }



    async function getPayoutDetail(payoutId) {

        var snapshot = await database.collection('payouts').doc(payoutId).get();

        return snapshot.data();

    }



    $(document).on("click", "a[name='vendor_reject_request']", function (e) {

        $('#admin_note').val("");

        var id = this.id;

        var auth = $(this).attr('data-auth');

        var amount = $(this).attr('data-amount');

        var price = $(this).attr('data-price');

        $('#submit_cancel').attr('data-id',id).attr('data-amount',amount).attr('data-price',price).attr('data-auth',auth);

    });



    $(document).on("click", "#submit_cancel", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var id = $(this).data('id');

        var auth = $(this).data('auth');

        var user = await getUserData(auth);

        var priceadd = $(this).data('price');

        var amount = $(this).data('amount');

        var admin_note = $("#admin_note").val();

        jQuery("#data-table_processing").show();

        database.collection('users').where("vendorID", "==", auth).get().then(function (resultprovider) {

            if (resultprovider.docs.length) {

                var provider = resultprovider.docs[0].data();

                var wallet_amount = 0;

                if (isNaN(provider.wallet_amount) || provider.wallet_amount == undefined) {

                    wallet_amount = 0;

                } else {

                    wallet_amount = provider.wallet_amount;

                }

                price = parseFloat(wallet_amount) + parseFloat(priceadd);

                if (!isNaN(price)) {

                    database.collection('payouts').doc(id).update({'paymentStatus': 'Reject','adminNote':admin_note}).then(function (result) {

                        database.collection('users').doc(provider.id).update({'wallet_amount': price}).then(async function (result) {

                            var wId = database.collection('temp').doc().id;

                            database.collection('wallet').doc(wId).set({

                                'amount': parseFloat(priceadd),

                                'date': firebase.firestore.FieldValue.serverTimestamp(),

                                'id': wId,

                                'isTopUp': false,

                                'order_id': id,

                                'payment_method': 'Wallet',

                                'payment_status': 'Refund success',

                                'transactionUser': 'vendor',

                                'user_id': provider.id,

                                'note': 'Refund by admin'

                            });

                            if (user && user != undefined) {

                                var emailData = await sendMailToProvider(user, id, 'Disapproved', amount);

                                if (emailData) {

                                    window.location.reload();

                                }

                            } else {

                                window.location.reload();

                            }

                        });

                    });

                }

            } else {

                alert('Provider not found.');

            }

        });

    });



    $(document).on("click", "#submit_accept", async function (e) {

        $(this).prop('disabled',true).css({'cursor':'default','opacity':'0.5'});

        var id = $(this).data('id');

        var auth = $(this).data('auth');

        var user = await getUserData(auth);

        var amount = $(this).data('amount');

        jQuery("#data-table_processing").show();

        database.collection('payouts').doc(id).update({'paymentStatus': 'Success'}).then(async function (result) {

            if (user && user != undefined) {

                var emailData = await sendMailToProvider(user, id, 'Approved', amount);

                if (emailData) {

                    window.location.reload();

                }

            } else {

                window.location.reload();

            }

        });

    });



    async function payoutProvider(provider) {

        var payoutProvider = '';

        var route = '{{route("providers.view",":id")}}';

        route = route.replace(':id', provider);

        await database.collection('users').where("id", "==", provider).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var provider_data = snapshotss.docs[0].data();

                payoutProvider = provider_data.firstName+' '+ provider_data.lastName;

                jQuery(".provider_" + provider).attr("data-url", route).html(payoutProvider);

            } else {

                jQuery(".provider_" + provider).attr("data-url", route).html('');

            }

        });

        return payoutProvider;

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

    $(document).on("click", "a[name='provider_payouts-delete']", function (e) {
        var id = this.id;
        database.collection('payouts').doc(id).delete().then(function () {
            window.location.reload();
        });


    });




</script>







@endsection