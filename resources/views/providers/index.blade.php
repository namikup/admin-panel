@extends('layouts.app')



@section('content')





<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.provider_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.provider_table')}}</li>

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

                        <span class="icon mr-3"><img src="{{ asset('images/provider.png') }}"></span>

                        <h3 class="mb-0">{{trans('lang.provider_plural')}}</h3>

                        <span class="counter ml-3 total_count"></span>

                    </div>   





                    <div class="d-flex top-title-right align-self-center">

                            <div class="select-box pl-3">

                                <select class="form-control status_selector filteredRecords">

                                    <option value="">{{trans("lang.status")}}</option>

                                    <option value="active"  >{{trans("lang.active")}}</option>

                                    <option value="inactive"  >{{trans("lang.in_active")}}</option>

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

    

       </div>

       <div class="table-list">

       <div class="row">

           <div class="col-12">

               <div class="card border">

                 <div class="card-header d-flex justify-content-between align-items-center border-0">

                   <div class="card-header-title">

                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.provider_table')}}</h3>

                    <p class="mb-0 text-dark-2">{{trans('lang.provider_table_text')}}</p>

                   </div>

                   <div class="card-header-right d-flex align-items-center">

                    <div class="card-header-btn mr-3">                     

                        <a class="btn-primary btn rounded-full" href="{!! route('providers.create') !!}"><i class="mdi mdi-plus mr-2"></i>{{trans('lang.provider_create')}}</a>

                     </div>

                   </div>                

                 </div>

                 <div class="card-body">

                         <div class="table-responsive m-t-10">

                            <table id="userTable"

                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"

                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>

                                    <?php if (in_array('users.delete', json_decode(@session('user_permissions'),true))) { ?>

                                    <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll"

                                    class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label></th>

                                    <?php } ?>

                                    <th>{{trans('lang.provider_info')}}</th>

                                    <th>{{trans('lang.section')}}</th>

                                    <th>{{trans('lang.email')}}</th>

                                    <th>{{trans('lang.current_plan')}}</th>

                                    <th>{{trans('lang.expiry_date')}}</th>

                                    <th>{{trans('lang.date')}}</th>

                                    <th>{{trans('lang.total_orders')}}</th>

                                    <th>{{trans('lang.active')}}</th>

                                    <th>{{trans('lang.wallet_transaction')}}</th>

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

    var ref = database.collection('users').where("role", "in", ["provider"]).orderBy('createdAt', 'desc');

    var user_permissions = '<?php echo @session('user_permissions') ?>';



    user_permissions = JSON.parse(user_permissions);



    var checkDeletePermission = false;



    if ($.inArray('providers.delete', user_permissions) >= 0) {

        checkDeletePermission = true;

    }



    $('.status_selector').select2({

        placeholder: '{{trans("lang.status")}}',  

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

    $('.filteredRecords').change(async function() {

        var status = $('.status_selector').val();

        var daterangepicker = $('#daterange').data('daterangepicker');

        ref = database.collection('users').where("role", "in", ["customer"]);

        if ($('#daterange span').html() != '{{trans("lang.select_range")}}' && daterangepicker) {

            var from = moment(daterangepicker.startDate).toDate();

            var to = moment(daterangepicker.endDate).toDate();

            if (from && to) { 

                var fromDate = firebase.firestore.Timestamp.fromDate(new Date(from));

                ref = ref.where('createdAt', '>=', fromDate);

                var toDate = firebase.firestore.Timestamp.fromDate(new Date(to));

                ref = ref.where('createdAt', '<=', toDate);

            }

        }

        if (status) {

            ref = (status == "active") ? ref.where('active', '==', true) : ref.where('active', '==', false);

        }

        $('#userTable').DataTable().ajax.reload();

    });



    var placeholderImage = '';



    $(document).ready(function () {



        $(document.body).on('click', '.redirecttopage', function () {

            var url = $(this).attr('data-url');

            window.location.href = url;

        });

        jQuery("#data-table_processing").show();



        var placeholder = database.collection('settings').doc('placeHolderImage');

        placeholder.get().then(async function (snapshotsimage) {

            var placeholderImageData = snapshotsimage.data();

            placeholderImage = placeholderImageData.image;

        })



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

                { key: 'fullName', header: "{{trans('lang.provider_info')}}" },

                { key: 'email', header: "{{trans('lang.email')}}" },      

                { key: 'activePlanName', header: "{{trans('lang.active_subscription_plan')}}" },    

                { key: 'subscriptionExpiryDate', header: "{{trans('lang.plan_expire_at')}}" },         

                { key: 'totalOrder', header: "{{trans('lang.total_orders')}}" }, 

                { key: 'active', header: "{{trans('lang.active')}}" },

                { key: 'createdAt', header: "{{trans('lang.date')}}" },

            ],

            

            fileName: "{{trans('lang.provider_table')}}",

        };

      

        const table = $('#userTable').DataTable({

            pageLength: 10, // Number of rows per page

            processing: false, // Show processing indicator

            serverSide: true, // Enable server-side processing

            responsive: true,

            ajax:async function (data, callback, settings) {

                const start = data.start;

                const length = data.length;

                const searchValue = data.search.value.toLowerCase();

                const orderColumnIndex = data.order[0].column;

                const orderDirection = data.order[0].dir;

                const orderableColumns = (checkDeletePermission) ? ['', 'fullName','sectionName', 'email', 'subscription_plan.name','subscriptionExpiryDate','createdAt', 'totalOrder', '', '',''] : ['fullName','sectionName', 'email','subscription_plan.name', 'subscriptionExpiryDate','createdAt', 'totalOrder', '', '', '']; // Ensure this matches the actual column names

                const orderByField = orderableColumns[orderColumnIndex]; // Adjust the index to match your table



                if (searchValue.length >= 3 || searchValue.length === 0) {

                    $('#data-table_processing').show();

                }

                var sectionNames = {};

                const sectionDocs = await database.collection('sections').get();

                sectionDocs.forEach(doc => {

                    sectionNames[doc.id] = doc.data().name;

                });

                ref.get().then(async function (querySnapshot) {

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

                        childData.id = doc.id; // Ensure the document ID is included in the data              

                        childData.fullName = childData.firstName + ' ' + childData.lastName || " ";

                        if(childData.hasOwnProperty('subscription_plan') && childData.subscription_plan && childData.subscription_plan.name) {

                            childData.activePlanName = childData.subscription_plan.name;

                        }else {

                            childData.activePlanName = '';

                        }



                        var date='';

                        var time='';

                        if(childData.hasOwnProperty("subscriptionExpiryDate")) {

                            try {

                                date=childData.subscriptionExpiryDate.toDate().toDateString();

                                time=childData.subscriptionExpiryDate.toDate().toLocaleTimeString('en-US');

                            } catch(err) {

                            }

                        }

                        childData.expiryDate=date+' '+time;

                        childData.totalOrder=await orderDetails(childData.id);

                        

                        childData.sectionName = sectionNames[childData.section_id] || '';

                        if (searchValue) {

                            var date = '';

                            var time = '';

                            if (childData.hasOwnProperty("createdAt")) {

                                try {

                                    date = childData.createdAt.toDate().toDateString();

                                    time = childData.createdAt.toDate().toLocaleTimeString('en-US');

                                } catch (err) {

                                }

                            }

                            var createdAt = date + ' ' + time;

                            if (

                                (childData.fullName && childData.fullName.toLowerCase().toString().includes(searchValue)) ||

                                (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) ||

                                (childData.email && childData.email.toLowerCase().toString().includes(searchValue)) ||

                                (childData.expiryDate&&childData.expiryDate.toString().toLowerCase().indexOf(searchValue)>-1)||

                                (childData.hasOwnProperty('activePlanName')&&childData.activePlanName.toLowerCase().toString().includes(searchValue))||

                                (childData.phoneNumber && childData.phoneNumber.toString().includes(searchValue)) ||

                                (childData.totalOrder && childData.totalOrder.toString().includes(searchValue)) ||

                                (childData.sectionName && childData.sectionName.toLowerCase().toString().includes(searchValue))



                            ) {

                                filteredRecords.push(childData);

                            }

                        } else {

                            filteredRecords.push(childData);

                        }

                    }));



                    filteredRecords.sort((a, b) => {

                        let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';

                        let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';

                        if (orderByField === 'createdAt') {

                            aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;

                            bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;

                        }

                        if (orderByField === 'totalOrder') {

                            aValue = a[orderByField] ? parseInt(a[orderByField]) : 0;

                            bValue = b[orderByField] ? parseInt(b[orderByField]) : 0;

                        }

                        if(orderByField==='subscriptionExpiryDate') {

                            aValue=a[orderByField]? new Date(a[orderByField].toDate()).getTime():0;

                            bValue=b[orderByField]? new Date(b[orderByField].toDate()).getTime():0;

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



                        var getData = await buildHTML(childData);

                        records.push(getData);

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

            order: (checkDeletePermission) ? [[6, 'desc']] : [[5, 'desc']],

            columnDefs: [{

                targets: (checkDeletePermission == true) ? 6: 5,

                type: 'date',

                render: function (data) {

                    return data;

                }

            },



            {

                orderable: false,

                targets: (checkDeletePermission == true) ? [0, 8,9,10] : [7,8,9]

            },

            ],

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

        newdate = '';

        var id = val.id;

        var route1 = '{{route("providers.edit", ":id")}}';

        route1 = route1.replace(':id', id);

        var trroute1 = '{{route("users.walletstransaction", ":id")}}';

        trroute1 = trroute1.replace(':id', "providerID=" + val.id);



        var providerView = '{{route("providers.view", ":id")}}';

        providerView = providerView.replace(':id', id);



        if (checkDeletePermission) {



            html.push('<input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +

                'for="is_open_' + id + '" ></label>');

        }

        if (val.profilePictureURL == '') {



            html.push('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"> <a href="' + providerView + '" class="redirecttopage left_space">' + val.firstName + ' ' + val.lastName + '</a>');

        } else {

            html.push('<img class="rounded" style="width:50px" src="' + val.profilePictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image"> <a href="' + providerView + '" class="redirecttopage left_space">' + val.firstName + ' ' + val.lastName + '</a>');

        }

        if (val.section_id) {

            html.push(val.sectionName);

        } else {

            html.push('');

        }

        if(val.email != ''){

            html.push(shortEmail(val.email));

        }else{

            html.push('');

        }

        if(val.hasOwnProperty('subscription_plan') && val.subscription_plan && val.subscription_plan.name) {

            html.push(val.subscription_plan.name);

        } else {

            html.push('');

        }

        if(val.hasOwnProperty('subscription_plan') && val.subscription_plan) {

            if(val.expiryDate != ' '){

                html.push(val.expiryDate);

            }else{

                html.push('{{trans("lang.unlimited")}}');

            }

        } else {

            html.push('');

        }

        var date = '';

        var time = '';

        if (val.hasOwnProperty("createdAt")) {

            try {

                date = val.createdAt.toDate().toDateString();

                time = val.createdAt.toDate().toLocaleTimeString('en-US');

            } catch (err) {



            }

            html.push('<span class="dt-time">' + date + ' ' + time + '</span>');

        } else {

            html.push('');

        }



        var providerr = await orderDetails(val.id);



        html.push(providerr);



        if (val.active) {

            html.push('<label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');

        } else {

            html.push('<label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label>');

        }

        html.push('<a href="' + trroute1 + '">{{trans("lang.transaction")}}</a>');

        var actionHtml='<span class="action-btn">';

        var planRoute="{{route('subscription.subscriptionPlanHistory',':id')}}";

        planRoute=planRoute.replace(':id',val.id);

        if(val.hasOwnProperty('subscription_plan')) {

            actionHtml+='<a id="'+val.id+'"  href="'+planRoute+'"><i class="mdi mdi-crown"></i></a>';

        }

        actionHtml = actionHtml + '<a href="' + providerView + '"><i class="mdi mdi-eye"></i></a>';

        actionHtml = actionHtml + '<a href="' + route1 + '"><i class="mdi mdi-lead-pencil"></i></a>';

        if (checkDeletePermission) {

            actionHtml = actionHtml + '<a id="' + val.id + '" class="delete-btn" name="user-delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a>';

        }

        actionHtml = actionHtml + '</span>';  

        html.push(actionHtml);

        return html;

    }



    async function orderDetails(id) {

        var count_order_complete = 0;



        await database.collection('provider_orders').where('provider.author', '==', id).get().then(async function (orderSnapshots) {

            count_order_complete = orderSnapshots.docs.length;



        });



        return count_order_complete;

    }









    $("#is_active").click(function () {

        $("#userTable .is_open").prop('checked', $(this).prop('checked'));

    });



    $("#deleteAll").click(function () {

        if ($('#userTable .is_open:checked').length) {

            if (confirm("{{trans('lang.selected_delete_alert')}}")) {

                jQuery("#data-table_processing").show();

                $('#userTable .is_open:checked').each(async function () {

                    var dataId = $(this).attr('dataId');

                    deleteDocumentWithImage('users',dataId,'profilePictureURL')

                    .then(() => {

                        return deleteUserData(dataId);

                    })

                    .then(result => {

                        setTimeout(function () {

                            window.location.reload();

                        }, 7000);

                    })

                    .catch(error => {

                        console.error("Error occurred:", error);

                    });

                });

            }

        

        } else {

            alert("{{trans('lang.select_delete_alert')}}");

        }

    });



    async function deleteUserData(userId) {



        await database.collection('providers_workers').where('providerId', '==', userId).get().then(async function (snapshotsItem) {



            if (snapshotsItem.docs.length > 0) {

                snapshotsItem.docs.forEach((temData) => {

                    var item_data = temData.data();



                    var objectnew = {

                        "data": {

                            "uid": item_data.id

                        }

                    };

                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';

                    jQuery.ajax({

                        url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',

                        method: 'POST',

                        contentType: "application/json; charset=utf-8",

                        data: JSON.stringify(objectnew),

                        success: async function (data) {

                            await deleteDocumentWithImage('providers_workers',item_data.id,'profilePictureURL');    

                            console.log('Delete user worker success:', data.result);



                        },

                        error: function (xhr, status, error) {

                            var responseText = JSON.parse(xhr.responseText);

                            console.log('Delete user worker error:', responseText.error);

                        }

                    });

                });

            }



        });



        await database.collection('wallet').where('user_id', '==', userId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {

                snapshotsItem.docs.forEach((temData) => {

                    var item_data = temData.data();



                    database.collection('wallet').doc(item_data.id).delete().then(function () {



                    });

                });

            }



        });

        await database.collection('favorite_provider').where('provider_id', '==', userId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {

                snapshotsItem.docs.forEach((temData) => {

                    var item_data = temData.data();



                    database.collection('favorite_provider').doc(item_data.id).delete().then(function () {



                    });

                });

            }



        });

        await database.collection('providers_services').where('author', '==', userId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {

                for (const temData of snapshotsItem.docs) {

                    await deleteDocumentWithImage('providers_services',temData.id,'authorProfilePic','photos');

                }

            }





        });



        await database.collection('providers_coupons').where('providerId', '==', userId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {

                for (const temData of snapshotsItem.docs) {

                    await deleteDocumentWithImage('providers_coupons',temData.id,'image');

                }

            }



        });



        await database.collection('payouts').where('vendorID', '==', userId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {

                snapshotsItem.docs.forEach((temData) => {

                    var item_data = temData.data();



                    database.collection('payouts').doc(item_data.id).delete().then(function () {



                    });

                });

            }



        });



           //delete provider from mysql

           await database.collection('settings').doc("Version").get().then(function(snapshot) {

                        var settingData=snapshot.data();

                        if(settingData&&settingData.providerUrl) {

                            var siteurl=settingData.providerUrl+"/api/delete-user";

                            var dataObject={"uuid": userId};

                            jQuery.ajax({

                                url: siteurl,

                                method: 'POST',

                                contentType: "application/json; charset=utf-8",

                                data: JSON.stringify(dataObject),

                                success: function(data) {

                                    console.log('Delete user from sql success:',data);

                                },

                                error: function(error) {

                                    console.log('Delete user from sql error:',error.responseJSON.message);

                                }

                            });

                        }

                    });



        //delete user from authentication    

        var dataObject = {

            "data": {

                "uid": userId

            }

        };

        var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';

        jQuery.ajax({

            url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',

            method: 'POST',

            contentType: "application/json; charset=utf-8",

            data: JSON.stringify(dataObject),

            success: function (data) {

                console.log('Delete user success:', data.result);



            },

            error: function (xhr, status, error) {

                var responseText = JSON.parse(xhr.responseText);

                console.log('Delete user error:', responseText.error);

            }

        });

    }





    $(document).on("click", "a[name='user-delete']", async function (e) {

        var id = this.id;

        var dataId = $(this).attr('dataId');

        jQuery("#data-table_processing").show();

        deleteDocumentWithImage('users',id,'profilePictureURL')

        .then(() => {

                    return deleteUserData(id);

                })

                .then(result => {

                    setTimeout(function () {

                        window.location.reload();

                    }, 7000);

                })

                .catch(error => {

                    console.error("Error occurred:", error);

                });

    });



    $(document).on("click", "input[name='isActive']", function (e) {

        var ischeck = $(this).is(':checked');

        var id = this.id;

        if (ischeck) {

            database.collection('users').doc(id).update({

                'active': true

            }).then(function (result) { });

        } else {

            database.collection('users').doc(id).update({

                'active': false

            }).then(function (result) { });

        }

    });

</script>



@endsection