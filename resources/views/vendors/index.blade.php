@extends('layouts.app')



@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.vendor_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.vendor_table')}}</li>

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

                        <span class="icon mr-3"><img src="{{ asset('images/store_list.png') }}"></span>

                        <h3 class="mb-0">{{trans('lang.vendor_plural')}}</h3>

                        <span class="counter ml-3 total_count"></span>

                    </div>    

                    <div class="d-flex top-title-right align-self-center"> 



                        <div class="select-box pl-3">

                            <select class="form-control business_model_selector filteredRecords">

                                <option value="" disabled selected>{{trans('lang.business_model')}}</option>

                            </select>

                        </div>

                        <div class="select-box pl-3">

                            <select class="form-control cuisine_selector filteredRecords">

                                <option value="" disabled selected>{{trans('lang.select_categoty')}}</option>

                            </select>

                        </div> 

                        <div class="select-box pl-3">

                            <select class="form-control filteredRecords sections" id="section_id" onchange="clickLink(this.value)">

                            <option value="" disabled selected>{{trans('lang.select')}} {{trans('lang.section_plural')}}

                            </select>

                            <p style="color: red;font-size: 13px;">  {{trans('lang.rental_parcel_cab_service_are_not')}}</p>

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

                                        <h4 class="text-dark-2 mb-1 h4 rest_count">00</h4>

                                        <p class="mb-0 small text-dark-2">{{trans('lang.total_orders')}}</p>

                                       </div>

                                        <span class="box-icon ab"><img src="{{ asset('images/restaurant_icon.png') }}"></span>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card card-box-with-icon bg--5">

                                    <div class="card-body d-flex justify-content-between align-items-center">

                                       <div class="card-box-with-content">

                                        <h4 class="text-dark-2 mb-1 h4 rest_active_count">00</h4>

                                        <p class="mb-0 small text-dark-2">{{trans('lang.active_restaurants')}}</p>

                                       </div>

                                        <span class="box-icon ab"><img src="{{ asset('images/active_restaurant.png') }}"></span>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card card-box-with-icon bg--8">

                                    <div class="card-body d-flex justify-content-between align-items-center">

                                       <div class="card-box-with-content">

                                        <h4 class="text-dark-2 mb-1 h4 rest_inactive_count">00</h4>

                                        <p class="mb-0 small text-dark-2">{{trans('lang.inactive_restaurants')}}</p>

                                       </div>

                                        <span class="box-icon ab"><img src="{{ asset('images/inactive_restaurant.png') }}"></span>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card card-box-with-icon bg--6">

                                    <div class="card-body d-flex justify-content-between align-items-center">

                                       <div class="card-box-with-content">

                                        <h4 class="text-dark-2 mb-1 h4 new_joined_rest">00</h4>

                                        <p class="mb-0 small text-dark-2">{{trans('lang.new_joined_restaurants')}}</p>

                                       </div>

                                        <span class="box-icon ab"><img src="{{ asset('images/new_restaurant.png') }}"></span>

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

               <div class="card border">

                 <div class="card-header d-flex justify-content-between align-items-center border-0">

                   <div class="card-header-title">

                    <h3 class="text-dark-2 mb-2 h4">{{trans('lang.vendor_table')}}</h3>

                    <p class="mb-0 text-dark-2">{{trans('lang.store_table_text')}}</p>

                   </div>

                   <div class="card-header-right d-flex align-items-center">

                    <div class="card-header-btn mr-3">                   

                        <a class="btn-primary btn rounded-full" href="{!! route('vendors.create') !!}"><i class="mdi mdi-plus mr-2"></i>{{trans('lang.create_vendor')}}</a>

                     </div>

                   </div>                

                 </div> 

                 <div class="card-body">

                         <div class="table-responsive m-t-10">

                            <table id="storeTable"

                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"

                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>

                                    <?php if (in_array('stores.delete', json_decode(@session('user_permissions'),true))) { ?>

                                    <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll"

                                    class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label></th>

                                    <?php } ?>

                                    <th>{{trans('lang.actions')}}</th>

                                    <th>{{trans('lang.store_info')}}</th>

                                    <th>{{trans('lang.section')}}</th>

                                    <th>{{trans('lang.vendor_phone')}}</th>

                                    <th>{{trans('lang.date')}}</th>

                                    <th>{{trans('lang.wallet_history')}}</th>

                                    <th>{{trans('lang.item')}}</th>

                                    <th>{{trans('lang.order_plural')}}</th>

                                    <th>{{trans('lang.timing')}}</th>

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

        var user_permissions = '<?php echo @session('user_permissions') ?>';

        user_permissions = JSON.parse(user_permissions);



        var checkDeletePermission = false;



        var checkCopyPermission = false;



        if ($.inArray('stores.delete', user_permissions) >= 0) {



            checkDeletePermission = true;



        }



        if ($.inArray('stores.copy', user_permissions) >= 0) {



            checkCopyPermission = true;



        }



        var section_id = getCookie('section_id');



        if (section_id != '') {

            var refData = database.collection('vendors').where('section_id', '==', section_id);



        } else {

            var refData = database.collection('vendors');

        }



        var ref = refData.orderBy('createdAt', 'desc');

        var userData = [];

        var vendorData = [];

        var vendorProducts = [];



        var placeholderImage = '';

        var placeholder = database.collection('settings').doc('placeHolderImage');



        var ref_sections = database.collection('sections');



        placeholder.get().then(async function (snapshotsimage) {

            var placeholderImageData = snapshotsimage.data();

            placeholderImage = placeholderImageData.image;

        })



        database.collection('vendor_categories').where('publish', '==', true).get().then(async function (snapshots) {

            snapshots.docs.forEach((listval) => {

                var data = listval.data();

                $('.cuisine_selector').append($("<option></option>")

                    .attr("value", data.id)

                    .text(data.title));

            })

        });

     

        var initialRef=ref;

      

        $('select').change(async function() {

            var businessModelValue = $('.business_model_selector').val();

            var cuisineValue = $('.cuisine_selector').val();

            refData=initialRef;  

            if (cuisineValue) {

                refData = refData.where('categoryID', '==', cuisineValue);

            }

            if (businessModelValue) {

                var vendorSelectedIds = await subscriptionPlanVendorIds(businessModelValue);

                if (vendorSelectedIds.length > 0) {

                    refData = refData.where('id', 'in', vendorSelectedIds);

                } else{

                    refData = refData.where('id', '==', null);

                }

            }

            ref=refData;

            $('#storeTable').DataTable().ajax.reload();

    

        }); 



        async function subscriptionPlanVendorIds(businessModelValue){

            var vendorIds = []

            try {

                const querySnapshot = await database.collection('users').where('subscriptionPlanId', '==', businessModelValue).get();  

                vendorIds = querySnapshot.docs.map(doc => doc.data().vendorID).filter(vendorID => vendorID !== undefined && vendorID !== null && vendorID !== '');

            } catch (error) {

                console.error("Error fetching users:", error);

            }

            return vendorIds;

        }



       

        database.collection('subscription_plans').where('isEnable', '==', true).orderBy('name', 'asc').get().then(snapshots => {

            snapshots.docs.forEach(doc => {

                const { expiryDay, createdAt, id, name, type } = doc.data();

                if (expiryDay && createdAt) {

                    const expiryDate = new Date(createdAt.toDate());

                    expiryDate.setDate(expiryDate.getDate() + parseInt(expiryDay, 10));

                    if (type !== "free" && expiryDate > new Date()) {

                        $('.business_model_selector').append($("<option>").attr("value", id).text(name));

                    } else {

                        $('.business_model_selector').append($("<option>").attr("value", id).text(name));

                    }

                }

            });

        });



      

      



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

                { key: 'title', header: "{{trans('lang.store_info')}}" },

                { key: 'sectionName', header: "{{trans('lang.section')}}" },                              

                { key: 'exportPhone', 

                header: "{{trans('lang.phone')}}",

                cell: row => (row.hasPlusSign ? `+${row.maskedPhone}` : row.maskedPhone) },

                { key: 'createdAt', header: "{{trans('lang.date')}}" },

                { key: 'items', header: "{{trans('lang.item')}}" },

                { key: 'orders', header: "{{trans('lang.order_plural')}}" },

            ],

            

            fileName: "{{trans('lang.vendor_table')}}",

        };





        $(document).ready(function () {



            $('.business_model_selector').select2({

                placeholder: "{{trans('lang.business_model')}}",  

                minimumResultsForSearch: Infinity,

                allowClear: true  

            });

            $('.cuisine_selector').select2({

                placeholder: "{{trans('lang.select_categoty')}}",  

                minimumResultsForSearch: Infinity,

                allowClear: true  

            });

            $('.sections').select2({

                placeholder: "{{trans('lang.select')}} {{trans('lang.section_plural')}}",  

                minimumResultsForSearch: Infinity,

                allowClear: true 

            });



            $('select').on("select2:unselecting", function(e) {

                var self = $(this);

                setTimeout(function() {

                    self.select2('close');

                }, 0);

            });



            jQuery("#data-table_processing").show();

            const table = $('#storeTable').DataTable({

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



                    const orderableColumns = (checkDeletePermission) ? [ '', '', 'title', 'sectionName', 'phone', 'createdAt', '', 'items', 'orders', ''] : ['', 'title', 'sectionName', 'phonenumber', 'createdAt', '', 'items', 'orders', '']; // Ensure this matches the actual column names



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



                        var sectionNames = {};



                        const sectionDocs = await database.collection('sections').get();



                        sectionDocs.forEach(doc => {



                            sectionNames[doc.id] = doc.data().name;



                        });



                        let records = [];



                        let filteredRecords = [];







                        await Promise.all(querySnapshot.docs.map(async (doc) => {



                            let childData = doc.data();



                            childData.phone = (childData.phonenumber != '' && childData.phonenumber != null && childData.phonenumber.slice(0, 1) == '+') ? childData.phonenumber.slice(1) : childData.phonenumber;

                            childData.maskedPhone = EditPhoneNumber(childData.phone);                       

                            childData.hasPlusSign = childData.phonenumber.startsWith('+');                        

                            childData.exportPhone = childData.hasPlusSign ? `+${childData.maskedPhone}` : childData.maskedPhone;

                           



                            childData.id = doc.id; // Ensure the document ID is included in the data



                            if (childData.id) {



                                childData.orders = await getTotalOrders(childData.id);



                                childData.items = await getTotalProduct(childData.id);



                            } else {



                                childData.orders = 0;



                                childData.items = 0;



                                childData.foods = 0;



                            }



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



                                    (childData.title && childData.title.toLowerCase().toString().includes(searchValue)) ||



                                    (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) ||



                                    (childData.email && childData.email.toLowerCase().toString().includes(searchValue)) ||



                                    (childData.phoneNumber && childData.phoneNumber.toLowerCase().toString().includes(searchValue)) ||



                                    (childData.sectionName && childData.sectionName.toLowerCase().toString().includes(searchValue))





                                ) {



                                    if (childData.title != '') {



                                        filteredRecords.push(childData);



                                    }



                                }



                            } else {

                                if (childData.title != '') {



                                    filteredRecords.push(childData);



                                }

                            }



                        }));



                        filteredRecords.sort((a, b) => {



                            let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase().trim() : '';



                            let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase().trim() : '';



                            if (orderByField === 'createdAt') {



                                try {



                                    aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;



                                    bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;



                                } catch (err) {



                                }



                            }



                            if (orderByField === 'items') {



                                aValue = a[orderByField] ? parseFloat(String(a[orderByField]).replace(/[^0-9.]/g, '')) || 0 : 0;



                                bValue = b[orderByField] ? parseFloat(String(b[orderByField]).replace(/[^0-9.]/g, '')) || 0 : 0;



                            }



                            if (orderByField === 'orders') {



                                aValue = a[orderByField] ? parseFloat(String(a[orderByField]).replace(/[^0-9.]/g, '')) || 0 : 0;



                                bValue = b[orderByField] ? parseFloat(String(b[orderByField]).replace(/[^0-9.]/g, '')) || 0 : 0;



                            }







                            if (orderDirection === 'asc') {



                                return (aValue > bValue) ? 1 : -1;



                            } else {



                                return (aValue < bValue) ? 1 : -1;



                            }



                        });







                        const totalRecords = filteredRecords.length;

                        $('.total_count').text(totalRecords); 



                        let active_rest = 0;

                        let inactive_rest = 0;

                        let new_joined_rest = 0;

                        const today = new Date().setHours(0, 0, 0, 0); 

                        await Promise.all(filteredRecords.map(async (childData) => {

                            var isActive = false;

                            if (childData.author) {

                                const user_id = childData.author;

                                isActive = await vendorStatus(user_id); 

                            }

                            if (isActive) {

                                active_rest += 1;

                            } else {

                                inactive_rest += 1;

                            }

                            if (childData.createdAt && new Date(childData.createdAt.seconds * 1000).setHours(0, 0, 0, 0) === today) {

                                new_joined_rest += 1;

                            }

                        }));

                        $('.rest_count').text(totalRecords);

                        $('.rest_active_count').text(active_rest);

                        $('.rest_inactive_count').text(inactive_rest);

                        $('.new_joined_rest').text(new_joined_rest);



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



                order: (checkDeletePermission) ? [[5, 'desc']] : [[4, 'desc']],



                columnDefs: [



                    {



                        targets: (checkDeletePermission) ? 5 : 4,



                        type: 'date',



                        render: function (data) {



                            return data;



                        }



                    },



                    {orderable: false, targets: (checkDeletePermission) ? [0, 1, 6, 9] : [0, 5, 8]},



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











            ref_sections.get().then(async function (snapshots) {







                snapshots.docs.forEach((listval) => {



                    var data = listval.data();







                    if (data.serviceTypeFlag == "delivery-service" || data.serviceTypeFlag == "ecommerce-service") {



                        $('#section_id').append($("<option></option>")



                            .attr("value", data.id)



                            .text(data.name));



                    }



                })



                $('#section_id').val(section_id);



            })







        })



        async function buildHTML(val) {

            var html = [];



            newdate = '';



            var id = val.id;



            var route1 = '{{route("vendors.edit",":id")}}';



            route1 = route1.replace(':id', id);







            var route_view = '{{route("vendors.view",":id")}}';



            route_view = route_view.replace(':id', id);



            if (checkDeletePermission) {



                html.push('<span class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '" author="' + val.author + '"><label class="col-3 control-label"\n' +



                    'for="is_open_' + id + '" ></label></span>');



            }



            var actionHtml = '';



            actionHtml = actionHtml + '<span class="action-btn">';



            if (checkCopyPermission) {



                actionHtml = actionHtml + '<a href="javascript:void(0)" vendor_id="' + val.id + '" author="' + val.author + '" name="vendor-clone"><i class="mdi mdi-content-copy"></i></a>';



            }



            actionHtml = actionHtml + '<a href="' + route_view + '"><i class="mdi mdi-eye"></i></a><a href="' + route1 + '"><i class="mdi mdi-lead-pencil"></i></a>';



            if (checkDeletePermission) {



                actionHtml = actionHtml + '<a id="' + val.id + '" author="' + val.author + '" name="delete-btn" class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a>';



            }



            actionHtml = actionHtml + '</span>';



            html.push(actionHtml);



            if (val.photo != '') {



                if (val.photo) {



                    photo = val.photo;



                } else {



                    photo = placeholderImage;



                }



                html.push('<img alt="" width="100%" style="width:70px;height:70px;" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">' + '<a href="' + route_view + '" class="redirecttopage left_space">' + val.title + '</a>');







            } else {

                html.push('<img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image">' + '<a href="' + route_view + '" class="redirecttopage left_space">' + val.title + '</a>');

            }



            if (val.section_id) {



                html.push(val.sectionName);



            } else {

                html.push('');

            }



            if (val.hasOwnProperty('phonenumber')) {



                if (val.phonenumber.includes('+')) {



                    html.push('+' + EditPhoneNumber(val.phonenumber.slice(1)));



                } else {



                    html.push(EditPhoneNumber(val.phonenumber));



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







            var payoutRequests = '{{route("users.walletstransaction",":id")}}';



            payoutRequests = payoutRequests.replace(':id', 'storeID=' + val.author);







            html.push('<a href="' + payoutRequests + '">{{trans("lang.wallet_history")}}</a>');







            var vendorId = val.id;



            var url = '{{route("vendors.items",":id")}}';



            url1 = url.replace(":id", vendorId);



            html.push('<a  href="' + url1 + '">' + val.items + '</a>');

            var url = '{{route("vendors.orders",":id")}}';



            url2 = url.replace(":id", vendorId);

            html.push('<a  href="' + url2 + '" >' + val.orders + '</a>');





            var opentime = '';



            var closetime = '';

            if (val.opentime != undefined) {



                opentime = val.opentime;



            }



            if (val.closetime != undefined) {



                closetime = val.closetime;



            }

            html.push(opentime + "-" + closetime);

            var active = val.isActive;

            return html;



        }



        async function vendorStatus(id) {

            let status = true;

            await database.collection('users').doc(id).get().then((snapshots) => {

                let data = snapshots.data();

                if (data) {

                    status = data.active; 

                }

            });

            return status;

        }



        async function getSectionName(sectionId) {



            var sectionName = '';



            await database.collection('sections').where("id", "==", sectionId).get().then(async function (snapshots) {



                if (snapshots.docs.length > 0) {

                    var data = snapshots.docs[0].data();

                    sectionName = data.name;

                }



            });



            return sectionName;

        }



        async function getTotalProduct(id) {



            var totalProduct = '';



            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function (productSnapshots) {



                totalProduct = productSnapshots.docs.length;



            });



            return totalProduct;



        }

        async function getTotalOrders(id) {

            var order_total = '';



            await database.collection('vendor_orders').where('vendorID', '==', id).get().then(async function (productSnapshots) {



                order_total = productSnapshots.docs.length;



            });



            return order_total;



        }



        $("#is_active").click(function () {

            $("#storeTable .is_open").prop('checked', $(this).prop('checked'));

        });



        $("#deleteAll").click(async function () {



            if ($('#storeTable .is_open:checked').length) {



                if (confirm("{{trans('lang.selected_delete_alert')}}")) {



                    jQuery("#data-table_processing").show();







                    $('#storeTable .is_open:checked').each(async function () {



                            var dataId = $(this).attr('dataId');



                            var author = $(this).attr('author');



                            await deleteDocumentWithImage('vendors', dataId, 'photo', ['vendorMenuPhotos', 'photos'])



                            .then(() => {



                                const getStoreName = deleteStoreData(dataId);



                                setTimeout(function () {



                                    window.location.reload();



                                }, 7000);



                            })



                            .catch((error) => {



                                console.error('Error deleting document with image:', error);



                            });



                        }



                    );







                }



            } else {



                alert("{{trans('lang.select_delete_alert')}}");



            }



        });



        async function deleteStoreData(storeId) {

            await database.collection('users').where('vendorID', '==', storeId).get().then(async function (userssanpshots) {



                if (userssanpshots.docs.length > 0) {



                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';

                    var item_data = userssanpshots.docs[0].data();



                    var dataObject = {"data": {"uid": item_data.id}};





                      //delete vendor from mysql

                    await database.collection('settings').doc("Version").get().then(function(snapshot) {

                        var settingData=snapshot.data();

                        if(settingData&&settingData.storeUrl) {

                            var siteurl=settingData.storeUrl+"/api/delete-user";

                            var dataObject={"uuid": item_data.id};

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







                    jQuery.ajax({



                        url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',



                        method: 'POST',



                        contentType: "application/json; charset=utf-8",



                        data: JSON.stringify(dataObject),



                        success: async function (data) {



                            console.log('Delete user success:', data.result);



                            await deleteDocumentWithImage('users',item_data.id,'profilePictureURL');



                        },



                        error: function (xhr, status, error) {



                            var responseText = JSON.parse(xhr.responseText);



                            console.log('Delete user error:', responseText.error);



                        }



                    });



                }



            });







            await database.collection('vendor_products').where('vendorID', '==', storeId).get().then(async function (snapshots) {



                if (snapshots.docs.length > 0) {



                    for (const listval of snapshots.docs) {



                        await deleteDocumentWithImage('vendor_products', listval.id, 'photo', 'photos');



                    }



                }



            });







            await database.collection('vendor_orders').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {



                if (snapshotsItem.docs.length > 0) {



                    for (const temData of snapshotsItem.docs) {



                        await deleteDocumentWithImage('vendor_orders', temData.id);



                    }



                }



            });







            await database.collection('items_review').where('VendorId', '==', storeId).get().then(async function (snapshotsItem) {



                if (snapshotsItem.docs.length > 0) {



                    for (const temData of snapshotsItem.docs) {



                        await deleteDocumentWithImage('items_review', temData.id, '', 'photos');



                    }



                }



            });







            await database.collection('coupons').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {



                if (snapshotsItem.docs.length > 0) {



                    for (const temData of snapshotsItem.docs) {



                        await deleteDocumentWithImage('coupons', temData.id, 'image');



                    }



                }



            });







            await database.collection('favorite_vendor').where('store_id', '==', storeId).get().then(async function (snapshotsItem) {



                if (snapshotsItem.docs.length > 0) {



                    for (const temData of snapshotsItem.docs) {



                        await deleteDocumentWithImage('favorite_vendor', temData.id);



                    }



                }



            });







            await database.collection('payouts').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {



                if (snapshotsItem.docs.length > 0) {



                    for (const temData of snapshotsItem.docs) {



                        await deleteDocumentWithImage('payouts', temData.id);



                    }



                }



            });







            await database.collection('story').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {



                if (snapshotsItem.docs.length > 0) {



                    for (const temData of snapshotsItem.docs) {



                        await deleteDocumentWithImage('story', temData.id,'videoThumbnail','videoUrl');



                    }



                }



            });







        }



        $(document.body).on('click', '.redirecttopage', function () {



            var url = $(this).attr('data-url');

            window.location.href = url;



        });



        async function userPhone(author) {



            var userPhones = '';



            await database.collection('users').where("id", "==", author).get().then(async function (snapshotss) {







                if (snapshotss.docs[0]) {



                    var user = snapshotss.docs[0].data();



                    userPhones = user.phoneNumber;



                    if (user.isActive) {







                        jQuery(".active_vendor_" + author + " span").addClass('badge-danger');



                        jQuery(".active_vendor_" + author + " span").text('No');







                    } else {



                        jQuery(".active_vendor_" + author + " span").addClass('badge-success');



                        jQuery(".active_vendor_" + author + " span").text('Yes');



                    }







                } else {



                    jQuery(".phone_" + author).html('');



                    jQuery(".active_vendor_" + author + " span").addClass('badge-success');



                    jQuery(".active_vendor_" + author + " span").text('Yes');



                }



            });



            return userPhones;



        }



        function clickpage(value) {

            setCookie('pagesizes', value, 30);

            location.reload();

        }



        $(document).on("click", "a[name='delete-btn']",async function (e) {



            var id = this.id;



            var author = $(this).attr('author');



            jQuery("#data-table_processing").show();







            await deleteDocumentWithImage('vendors', id, 'photo', ['vendorMenuPhotos', 'photos'])



            .then(() => {



                return deleteStoreData(id);



            })



            .then(() => {



                setTimeout(function () {



                    window.location.reload();



                }, 7000);



            })



            .catch((error) => {



                console.error('Error:', error);



            });



        });



        function clickLink(value) {



            setCookie('section_id', value, 30);



            location.reload();



        }



        $(document).on("click", "a[name='vendor-clone']", async function (e) {



            var id = $(this).attr('vendor_id');



            var author = $(this).attr('author');

            await database.collection('users').doc(author).get().then(async function (snapshotsusers) {



                userData = snapshotsusers.data();



            });



            await database.collection('vendors').doc(id).get().then(async function (snapshotsvendors) {



                vendorData = snapshotsvendors.data();



            });



            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function (snapshotsproducts) {



                vendorProducts = [];



                snapshotsproducts.docs.forEach(async (product) => {



                    vendorProducts.push(product.data());



                });







            });











            if (userData && vendorData) {



                jQuery("#create_vendor").modal('show');



                jQuery("#vendor_title_lable").text(vendorData.title);



            }



        });

        $(document).on("click", "#create_vendor_submit", async function (e) {



            var vendor_id = database.collection("tmp").doc().id;

            if (userData && vendorData) {



                var vendor_title = jQuery("#vendor_title").val();



                var userFirstName = jQuery("#user_name").val();



                var userLastName = jQuery("#user_last_name").val();



                var email = jQuery("#user_email").val();



                var password = jQuery("#user_password").val();







                if (userFirstName == '') {







                    $(".error_top").show();



                    $(".error_top").html("");



                    $(".error_top").append("<p>{{trans('lang.user_name_required')}}</p>");



                    window.scrollTo(0, 0);







                } else if (userLastName == '') {







                    $(".error_top").show();



                    $(".error_top").html("");



                    $(".error_top").append("<p>{{trans('lang.user_last_name_required')}}</p>");



                    window.scrollTo(0, 0);







                } else if (vendor_title == '') {







                    $(".error_top").show();



                    $(".error_top").html("");



                    $(".error_top").append("<p>{{trans('lang.vendor_title_required')}}</p>");



                    window.scrollTo(0, 0);







                } else if (email == '') {







                    $(".error_top").show();



                    $(".error_top").html("");



                    $(".error_top").append("<p>{{trans('lang.user_email_required')}}</p>");



                    window.scrollTo(0, 0);



                } else if (password == '') {



                    $(".error_top").show();



                    $(".error_top").html("");



                    $(".error_top").append("<p>{{trans('lang.enter_owners_password_error')}}</p>");



                    window.scrollTo(0, 0);



                } else {







                    jQuery("#data-table_processing2").show();







                    firebase.auth().createUserWithEmailAndPassword(email, password).then(async function (firebaseUser) {



                        var user_id = firebaseUser.user.uid;







                        userData.email = email;



                        userData.firstName = userFirstName;



                        userData.lastName = userLastName;



                        userData.id = user_id;



                        userData.vendorID = vendor_id;



                        userData.createdAt = createdAt;



                        userData.wallet_amount = 0;







                        vendorData.author = user_id;



                        vendorData.authorName = userFirstName + ' ' + userLastName;



                        vendorData.title = vendor_title;



                        vendorData.id = vendor_id;



                        coordinates = new firebase.firestore.GeoPoint(vendorData.latitude, vendorData.longitude);



                        vendorData.coordinates = coordinates;



                        vendorData.createdAt = createdAt;







                        await database.collection('users').doc(user_id).set(userData).then(async function (result) {







                            await geoFirestore.collection('vendors').doc(vendor_id).set(vendorData).then(async function (result) {



                                var count = 0;



                                await vendorProducts.forEach(async (product) => {



                                    var product_id = await database.collection("tmp").doc().id;



                                    product.id = product_id;



                                    product.vendorID = vendor_id;



                                    await database.collection('vendor_products').doc(product_id).set(product).then(function (result) {



                                        count++;



                                        if (count == vendorProducts.length) {



                                            jQuery("#data-table_processing2").hide();



                                            alert('Successfully created.');



                                            jQuery("#create_vendor").modal('hide');



                                            location.reload();



                                        }



                                    });







                                });











                            });



                        })







                    }).catch(function (error) {



                        $(".error_top").show();



                        jQuery("#data-table_processing2").hide();



                        $(".error_top").html("");



                        $(".error_top").append("<p>" + error + "</p>");



                    });











                }



            }



        });





   



    </script>







@endsection



