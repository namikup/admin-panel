@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.subscription_history')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.subscription_history_table')}}</li>
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
                            <span class="icon mr-3"><img src="{{ asset('images/subscription.png') }}"></span>
                            <h3 class="mb-0">{{trans('lang.subscription_history')}}</h3>
                            <span class="counter ml-3 total_count"></span>
                        </div>
                        <div class="d-flex top-title-right align-self-center">
                            <div class="select-box pl-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-list">
            <div class="row">
                <div class="col-12">
                    
                    <?php if ($id != '') {
                        ?>
                        <div class="menu-tab d-none" id="vendorhistorytab">
                            <ul>
                                <li>
                                    <a class="vendor_basic" href="{{route('vendors.view',$id)}}" >{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li>
                                    <a class="vendor_item" href="{{route('vendors.items',$id)}}">{{trans('lang.tab_items')}}</a>
                                </li>
                                <li>
                                    <a class="vendor_order"  href="{{route('vendors.orders',$id)}}">{{trans('lang.tab_orders')}}</a>
                                </li>
                                <li>
                                    <a class="vendor_review" href="{{route('vendors.reviews',$id)}}">{{trans('lang.tab_reviews')}}</a>
                                </li>
                                <li>
                                    <a class="vendor_promo" href="{{route('vendors.coupons',$id)}}">{{trans('lang.tab_promos')}}</a>
                                <li>
                                    <a class="vendor_payout" href="{{route('vendors.payout',$id)}}">{{trans('lang.tab_payouts')}}</a>
                                </li>
                                <li>
                                    <a class="vendor_payout_request" href="{{route('payoutRequests.vendor.view',$id)}}">{{trans('lang.tab_payout_request')}}</a>
                                </li>
                                <li class="dine_in_future" style="display:none;">
                                    <a href="{{route('vendors.booktable',$id)}}">{{trans('lang.dine_in_future')}}</a>
                                </li>
                                <?php if (in_array('wallet-transaction', json_decode(@session('user_permissions')))) { ?>
                                    <li>    
                                        <a class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                    </li>
                                <?php }?>
                                <li class="active">
                                    <a href="{{route('subscription.subscriptionPlanHistory',$id)}}">{{trans('lang.subscription_history')}}</a>
                                </li>
                            </ul> 
                        </div>

                        <div class="menu-tab d-none" id="providerhistorytab">

                            <ul>

                                <li><a href="#" class="provider_basic">{{trans('lang.tab_basic')}}</a>

                                </li>

                                <li><a href="#" class="provider_services">{{trans('lang.services')}}</a></li>

                                <li>

                                <li><a href="#" class="provider_workers">{{trans('lang.workers')}}</a></li>

                                <li>

                                <li><a href="#" class="provider_bookings">{{trans('lang.booking_plural')}}</a></li>

                                <li>

                                <li><a href="#" class="provider_coupons">{{trans('lang.coupon_plural')}}</a></li>

                                <li>

                                    <a href="#" class="provider_payout">{{trans('lang.tab_payouts')}}</a>

                                </li>

                                <li>

                                    <a href="#" class="provider_payout_request">{{trans('lang.tab_payout_request')}}</a>

                                </li>

                                <?php if (in_array('wallet-transaction', json_decode(@session('user_permissions')))) { ?>
                                    <li>    
                                        <a class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                    </li>

                                <?php }?>

                                <li class="active">
                                    <a  class="subscription" href="#">{{trans('lang.subscription_history')}}</a>
                                </li>

                            </ul>

                        </div>

                    <?php } ?> 
                    <div class="card border">
                        <div class="card-header d-flex justify-content-between align-items-center border-0">
                            <div class="card-header-title">
                                <h3 class="text-dark-2 mb-2 h4">{{trans('lang.subscription_history')}}</h3>
                                <p class="mb-0 text-dark-2">{{trans('lang.subscription_history_table')}}</p>
                            </div>
                            <div class="card-header-right d-flex align-items-center">
                                <div class="card-header-btn mr-3">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-t-10">
                                <table id="subscriptionHistoryTable"
                                    class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                        class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                            class="do_not_delete" href="javascript:void(0)"><i
                                                                class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label>
                                                </th>
                                            <?php if ($id == '') { ?>
                                                <th>{{ trans('lang.user')}}</th>
                                            <?php } ?>
                                            <th>{{trans('lang.plan_name')}}</th>
                                            <th>{{trans('lang.plan_type')}}</th>
                                            <th>{{trans('lang.plan_expires_at')}}</th>
                                            <th>{{trans('lang.purchase_date')}}</th>
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
<script>
    var database=firebase.firestore();
    var intRegex=/^\d+$/;
    var floatRegex=/^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
    var refData=database.collection('subscription_history');
    var currentCurrency='';
    var currencyAtRight=false;
    var decimal_degits=0;
    var userId = "{{$id}}";
    var ref ='';
   

    var storeID = (window.location.href.indexOf("storeID=") > -1) ? window.location.href.split("storeID=")[1] : "";
    var providerID = (window.location.href.indexOf("providerID=") > -1) ? window.location.href.split("providerID=")[1] : "";
    var wallet_route = "{{route('users.walletstransaction','id')}}";
    var subscription_route = "{{route('subscription.subscriptionPlanHistory','id')}}";

    var refCurrency=database.collection('currencies').where('isActive','==',true);
    refCurrency.get().then(async function(snapshots) {
        var currencyData=snapshots.docs[0].data();
        currentCurrency=currencyData.symbol;
        currencyAtRight=currencyData.symbolAtRight;
        if(currencyData.decimal_degits) {
            decimal_degits=currencyData.decimal_degits;
        }
    });
    var append_list='';
       

    $(document).ready(async function() {
        if (storeID!='') {
            ref = database.collection('vendors').where("id", "==", storeID);
            await ref.get().then(async function (querysnapshots) {
                if (querysnapshots.docs.length > 0) {                        
                    var vendor = querysnapshots.docs[0].data();
                    userId = vendor.author;
                    if (vendor.dine_in_active == true) {                        
                        $(".dine_in_future").show();
                    }
                }
            });
            if(userId != ''){
                $('#vendorhistorytab').removeClass('d-none');
                var basic = "{{route('vendors.view','id')}}";
                var items = "{{route('vendors.items','id')}}";
                var vendor_orders = "{{route('vendors.orders','id')}}";
                var vendor_review = "{{route('vendors.reviews','id')}}";
                var ven_promo = "{{route('vendors.coupons','id')}}";
                var ven_payout = "{{route('vendors.payout','id')}}";
                var ven_payoutReq = "{{route('payoutRequests.vendor.view','id')}}";
                var ven_dinein = "{{route('vendors.booktable','id')}}";

                $(".vendor_basic").attr("href", basic.replace('id', storeID));
                $(".vendor_item").attr("href", items.replace('id', storeID));
                $(".vendor_order").attr("href", vendor_orders.replace('id', storeID));
                $(".vendor_review").attr("href", vendor_review.replace('id', storeID));
                $(".vendor_promo").attr("href", ven_promo.replace('id', storeID));
                $(".vendor_payout").attr("href", ven_payout.replace('id', storeID));
                $(".vendor_payout_request").attr("href", ven_payoutReq.replace('id', storeID));
                $(".vendor_booktable").attr("href", ven_dinein.replace('id', storeID));
                $(".wallet_transaction").attr("href", wallet_route.replace('id',"storeID="+ userId));
            }
        } else if (providerID!='') {
            userId = providerID;
            $('#providerhistorytab').removeClass('d-none');
            var provider_basic = "{{url('providers/view/{id}')}}";
            var provider_services = "{{url('ondemand-services/{id?}')}}";
            var provider_workers = "{{url('ondemand-workers/{id?}')}}";
            var provider_bookings = "{{url('ondemand-bookings/{id?}')}}";
            var provider_coupons = "{{url('ondemand-coupons/{id?}')}}";
            var provider_payout = "{{url('providerPayouts/{id}')}}";
            var provider_payout_request = "{{url('payoutRequests/providers/{id?}')}}";
            $(".provider_basic").attr("href", provider_basic.replace('{id}', providerID));
            $(".provider_services").attr("href", provider_services.replace('{id?}', providerID));
            $(".provider_workers").attr("href", provider_workers.replace('{id?}', providerID));
            $(".provider_bookings").attr("href", provider_bookings.replace('{id?}', providerID));
            $(".provider_coupons").attr("href", provider_coupons.replace('{id?}', providerID));
            $(".provider_payout").attr("href", provider_payout.replace('{id}', providerID));
            $(".provider_payout_request").attr("href", provider_payout_request.replace('{id?}', providerID));
            $(".wallet_transaction").attr("href", wallet_route.replace('id', "{{$id}}"));

        }

        if(userId != ''){
            refData = refData.where('user_id','==',userId);
            $(".subscription").attr("href",  subscription_route.replace('id', "{{$id}}" ));
        }
       

        $(document.body).on('click','.redirecttopage',function() {
            var url=$(this).attr('data-url');
            window.location.href=url;
        });
     

        jQuery("#overlay").show();
        const table=$('#subscriptionHistoryTable').DataTable({
            pageLength: 10,
            processing: false,
            serverSide: true,
            responsive: true,
            ajax: async function(data,callback,settings) {
                const start=data.start;
                const length=data.length;
                const searchValue=data.search.value.toLowerCase();
                const orderColumnIndex=data.order[0].column;
                const orderDirection=data.order[0].dir;
                const orderableColumns= (userId=='') ? ['','user','plan_name','plan_type','expiry_date','createdAt'] : ['','plan_name','plan_type','expiry_date','createdAt'] ;
                const orderByField=orderableColumns[orderColumnIndex];
                if(searchValue.length>=3||searchValue.length===0) {
                    $('#overlay').show();
                }
                await refData.orderBy('createdAt','desc').get().then(async function(querySnapshot) {
                    if(querySnapshot.empty) {
                        $('.total_count').text(0);
                        console.error("No data found in Firestore.");
                        $('#overlay').hide(); 
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            data: [] 
                        });
                        return;
                    }
                    let records=[];
                    let filteredRecords=[];
                    await Promise.all(querySnapshot.docs.map(async (doc) => {
                        let childData=doc.data();
                        childData.user='';
                        if(childData.user_id) {
                            childData.user=await planUsedUser(childData.user_id);
                        }
                        childData.plan_name = childData.subscription_plan.name;
                        childData.plan_type = childData.subscription_plan.type;
                        childData.id=doc.id;
                        if(searchValue) {
                            var date='';
                            var time='';
                            if(childData.expiry_date?.toDate) {
                                try {
                                    date=childData.expiry_date.toDate().toDateString();
                                    time=childData.expiry_date.toDate().toLocaleTimeString('en-US');
                                } catch(err) {
                                    console.error('Error processing expiry_date:',err);
                                }
                            }
                            childData.paidDate=date+' '+time;
                            if(childData.createdAt?.toDate) {
                                try {
                                    purchasedate=childData.createdAt.toDate().toDateString();
                                    purchasetime=childData.createdAt.toDate().toLocaleTimeString('en-US');
                                } catch(err) {
                                    console.error('Error processing expiry_date:',err);
                                }
                            }
                            childData.purchaseDate=purchasedate+' '+purchasetime;
                            if(
                                (childData.user&&(childData.user).toString().toLowerCase().includes(searchValue))||
                                (childData.subscription_plan.name&&(childData.subscription_plan.name).toLowerCase().includes(searchValue))||
                                (childData.subscription_plan.type&&(childData.subscription_plan.type).toLowerCase().includes(searchValue))||
                                (childData.paidDate && childData.paidDate.toString().toLowerCase().indexOf(searchValue) > -1) ||
                                (childData.purchaseDate && childData.purchaseDate.toString().toLowerCase().indexOf(searchValue) > -1)
                            ) {
                                filteredRecords.push(childData);
                            }
                        } else {
                            filteredRecords.push(childData);
                        }
                    }));
                    filteredRecords.sort((a,b) => {
                        let aValue=a[orderByField]? a[orderByField].toString().toLowerCase():'';
                        let bValue=b[orderByField]? b[orderByField].toString().toLowerCase():'';
                        if(orderByField==='createdAt') {
                            try {
                                aValue=a[orderByField]&&a[orderByField].toDate? new Date(a[orderByField].toDate()).getTime():0;
                                bValue=b[orderByField]&&a[orderByField].toDate? new Date(b[orderByField].toDate()).getTime():0;
                            } catch(err) {
                            }
                        }
                        if(orderDirection==='asc') {
                            return (aValue>bValue)? 1:-1;
                        } else {
                            return (aValue<bValue)? 1:-1;
                        }
                    });
                    const totalRecords=filteredRecords.length;
                    $('.total_count').text(totalRecords);
                    const paginatedRecords=filteredRecords.slice(start,start+length);
                    await Promise.all(paginatedRecords.map(async (childData) => {
                        var getData=await buildHTML(childData);
                        records.push(getData);
                    }));
                    $('#overlay').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: totalRecords,
                        recordsFiltered: totalRecords,
                        data: records
                    });
                }).catch(function(error) {
                    console.error("Error fetching data from Firestore:",error);
                    $('#overlay').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                });
            },
            order:  (userId=='') ? [5,'desc'] : [4,'desc'] ,
            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
                {
                    targets: (userId=='') ? 3 : 2,
                    type: 'date',
                    render: function(data) {
                        return data;
                    }
                },
            ],
            "language": {
                "zeroRecords": "{{trans("lang.no_record_found")}}",
                "emptyTable": "{{trans("lang.no_record_found")}}",
                "processing": ""
            },
        });
        function debounce(func,wait) {
            let timeout;
            const context=this;
            return function(...args) {
                clearTimeout(timeout);
                timeout=setTimeout(() => func.apply(context,args),wait);
            };
        }
        $('#search-input').on('input',debounce(function() {
            const searchValue=$(this).val();
            if(searchValue.length>=3) {
                $('#overlay').show();
                table.search(searchValue).draw();
            } else if(searchValue.length===0) {
                $('#overlay').show();
                table.search('').draw();
            }
        },300));
    });
    async function planUsedUser(id) {
        var planUsedUser='';
        if(id!=null&&id!=''&&id!=undefined) {
            await database.collection('users').doc(id).get().then(async function(snapshot) {
                if(snapshot&&snapshot.data()) {
                    var data=snapshot.data();
                    planUsedUser=data.firstName+' '+data.lastName;
                }
            });
        }
        return planUsedUser;
    }
    async function buildHTML(val) {
        var html=[];
        var id = val.id;
        html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
        'for="is_open_' + id + '" ></label></td>');
        if(userId=='') {
            var route='{{route("users.view", ":id")}}';
            route=route.replace(':id',val.user_id);
            var route1='{{route("subscription-plans.save", ":id")}}';
            route1=route1.replace(':id',val.subscription_plan.id);
            html.push('<a href="'+route+'" class="redirecttopage" >'+val.user+'</a>');
        }
        html.push('<a href="'+route1+'" class="redirecttopage" >'+val.subscription_plan.name+'</a>');
        if(val.subscription_plan && val.subscription_plan.type ) {
            if(val.subscription_plan.type=='free'){
                html.push('<span class="badge badge-success">'+val.subscription_plan.type.toUpperCase()+'</span>');
            }else{
                html.push('<span class="badge badge-danger">'+val.subscription_plan.type.toUpperCase()+'</span>');
            }
        } else {
            html.push('<span class="badge">-</span>');
        }
        if(val.hasOwnProperty('expiry_date')) {
            if(val.expiry_date!=null&&val.expiry_date!=''&&val.expiry_date!='-1') {
                var date=val.expiry_date.toDate().toDateString();
                var time=val.expiry_date.toDate().toLocaleTimeString('en-US');
                html.push('<span class="dt-time">'+date+' '+time+'</span>');
            } else {
                html.push("{{trans('lang.unlimited')}}")
            }
        } else {
            html.push('');
        }
        if(val.hasOwnProperty('createdAt')) {
            if(val.createdAt!=null&&val.createdAt!=''&&val.createdAt!='-1') {
                var date=val.createdAt.toDate().toDateString();
                var time=val.createdAt.toDate().toLocaleTimeString('en-US');
                html.push('<span class="dt-time">'+date+' '+time+'</span>');
            } else {
                html.push("{{trans('lang.unlimited')}}")
            }
        } else {
            html.push('');
        }
        return html;
    }
    $("#is_active").click(function () {
        $("#subscriptionHistoryTable .is_open").prop('checked', $(this).prop('checked'));
    });
    $("#deleteAll").click(function () {
        if ($('#subscriptionHistoryTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#overlay").show();
                $('#subscriptionHistoryTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    deleteDocumentWithImage('subscription_history', dataId)
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error('Error deleting document or store data:', error);
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
</script>
@endsection