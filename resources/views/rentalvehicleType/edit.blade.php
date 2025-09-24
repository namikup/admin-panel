@extends('layouts.app')



@section('content')

<div class="page-wrapper">

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">{{trans('lang.edit_rental_vehicle_type')}}</h3>

		</div>



		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

				<li class="breadcrumb-item"><a

						href="{!! route('rentalvehicleType') !!}">{{trans('lang.rental_vehicle_type')}}</a></li>

				<li class="breadcrumb-item active">{{trans('lang.edit_rental_vehicle_type')}}</li>

			</ol>

		</div>



		<div class="card-body">


			<div class="error_top"></div>



			<div class="row vendor_payout_create">

				<div class="vendor_payout_create-inner">

					<fieldset>

						<legend>{{trans('lang.rental_vehicle_type')}}</legend>

						<div class="form-group row width-50">

							<label class="col-3 control-label">{{trans('lang.name')}}</label>

							<div class="col-7">

								<input type="text" class="form-control name" id="name">

								<div class="form-text text-muted">{{trans('lang.user_name_help')}}</div>



							</div>

						</div>



						<div class="form-group row width-50">

							<label class="col-3 control-label">{{trans('lang.capacity')}}</label>

							<div class="col-7">

								<input type="text" class="form-control capacity" id="capacity">

								<div class="form-text text-muted">{{trans('lang.capacity_help')}}</div>



							</div>

						</div>

						<div class="form-group row width-50">

							<label class="col-3 control-label">{{trans('lang.short_description')}}</label>

							<div class="col-7">

								<input type="text" class="form-control short_description" id="short_description">

								<div class="form-text text-muted">{{trans('lang.short_description_help')}}</div>



							</div>

						</div>

						<div class="form-group row width-50">

							<label class="col-3 control-label">{{trans('lang.description')}}</label>

							<div class="col-7">

								<textarea class="form-control description" id="description" rows="2"></textarea>

								<div class="form-text text-muted">{{trans('lang.description_help')}}</div>



							</div>

						</div>

						<div class="form-group row width-50">

							<label class="col-3 control-label">{{trans('lang.supported_vehicle')}}</label>

							<div class="col-7">

								<textarea class="form-control supported_vehicle" id="supported_vehicle"

									rows="2"></textarea>

								<div class="form-text text-muted">{{trans('lang.supported_vehicle_help')}}</div>



							</div>

						</div>

						<div class="form-group row width-100">

							<label class="col-3 control-label">{{trans('lang.icon')}}</label>

							<input type="file" onChange="handleFileSelect(event)" class="col-7">

							<div class="placeholder_img_thumb user_image"></div>

							<div id="uploding_image"></div>

						</div>



						<div class="form-group row width-100">

							<div class="form-check">

								<input type="checkbox" class="vehicle_type_active" id="vehicle_type_active">

								<label class="col-3 control-label"

									for="vehicle_type_active">{{trans('lang.active')}}</label>



							</div>





						</div>

					</fieldset>





				</div>

			</div>

		</div>



		<div class="form-group col-12 text-center btm-btn">

			<button type="button" class="btn btn-primary  edit-setting-btn"><i class="fa fa-save"></i> {{

				trans('lang.save')}}</button>

			<a href="{!! url('rentalvehicleType') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{

				trans('lang.cancel')}}</a>

		</div>



	</div>



</div>



@endsection



@section('scripts')



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script type="text/javascript">



	var database = firebase.firestore();

	var photo = "";

	var fileName = "";

	var oldImageFile = "";

	var placeholderImage = '';

	var id = "<?php echo $id; ?>";

	var ref = database.collection('rental_vehicle_type').where('id', '==', id);

	var storageRef = firebase.storage().ref('images');

	var storage = firebase.storage();



	var placeholder = database.collection('settings').doc('placeHolderImage');



	placeholder.get().then(async function (snapshotsimage) {

		var placeholderImageData = snapshotsimage.data();

		placeholderImage = placeholderImageData.image;

	})



	$(document).ready(function () {

		jQuery("#data-table_processing").show();



		ref.get().then(async function (snapshots) {



			var vehicleType = snapshots.docs[0].data();

			$(".name").val(vehicleType.name);

			$('.capacity').val(vehicleType.capacity);

			$('.short_description').val(vehicleType.short_description);

			$('.description').text(vehicleType.description);

			$('.supported_vehicle').text(vehicleType.supported_vehicle);

            $(".vehicle_type_active").prop("checked", vehicleType.isActive);



			photo = vehicleType.rental_vehicle_icon;

			if (photo != '') {

				oldImageFile = vehicleType.rental_vehicle_icon;

				$(".user_image").append('<img class="rounded" style="width:50px" src="' + photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">');

			} else {



				$(".user_image").append('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');

			}





			jQuery("#data-table_processing").hide();



		});

	});



	$(".edit-setting-btn").click(function () {



		var name = $(".name").val();

		var capacity = $('.capacity').val();

		var short_description = $('.short_description').val();

		var description = $('.description').val();

		var supported_vehicle = $('.supported_vehicle').val();



		var active = $(".vehicle_type_active").is(":checked");





		if (name == '') {

			$(".error_top").show();

			$(".error_top").html("");

			$(".error_top").append("<p>{{trans('lang.name_error')}}</p>");

			window.scrollTo(0, 0);



		} else if (capacity == '') {

			$(".error_top").show();

			$(".error_top").html("");

			$(".error_top").append("<p>{{trans('lang.capacity_error')}}</p>");

			window.scrollTo(0, 0);



		} else if (short_description == '') {

			$(".error_top").show();

			$(".error_top").html("");

			$(".error_top").append("<p>{{trans('lang.short_description_error')}}</p>");

			window.scrollTo(0, 0);



		} else if (description == '') {

			$(".error_top").show();

			$(".error_top").html("");

			$(".error_top").append("<p>{{trans('lang.description_error')}}</p>");

			window.scrollTo(0, 0);



		} else if (supported_vehicle == '') {

			$(".error_top").show();

			$(".error_top").html("");

			$(".error_top").append("<p>{{trans('lang.supported_vehicle_error')}}</p>");

			window.scrollTo(0, 0);



		} else {

			jQuery("#data-table_processing").show();

			storeImageData().then(IMG => {

				database.collection('rental_vehicle_type').doc(id).update({

					'id': id, 'name': name, 'capacity': capacity, 'short_description': short_description, 'description': description, 'supported_vehicle': supported_vehicle, 'rental_vehicle_icon': IMG, 'isActive': active,

				}).then(function (result) {

					jQuery("#data-table_processing").hide();

					window.location.href = '{{ route("rentalvehicleType") }}';

				});

			}).catch(err => {

				jQuery("#data-table_processing").hide();

				$(".error_top").show();

				$(".error_top").html("");

				$(".error_top").append("<p>" + err + "</p>");

				window.scrollTo(0, 0);

			});

		}



	});



	function handleFileSelect(evt) {

		var f = evt.target.files[0];

		var reader = new FileReader();



		reader.onload = (function (theFile) {

			return function (e) {



				var filePayload = e.target.result;

				var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));



				var val = f.name;

				var ext = val.split('.')[1];

				var docName = val.split('fakepath')[1];

				var filename = (f.name).replace(/C:\\fakepath\\/i, '')



				var timestamp = Number(new Date());

				var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;

				fileName = filename;

				photo = filePayload;

				$(".user_image").empty();

				$(".user_image").append('<img class="rounded" style="width:50px" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">');



			};

		})(f);

		reader.readAsDataURL(f);

	}

	async function storeImageData() {

		var newPhoto = '';

		try {

			if (oldImageFile != "" && photo != oldImageFile) {

				var oldImageUrl = await storage.refFromURL(oldImageFile);

				imageBucket = oldImageUrl.bucket;

				var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";

				if (imageBucket == envBucket) {

					await oldImageUrl.delete().then(() => {

						console.log("Old file deleted!")

					}).catch((error) => {

						console.log("ERR File delete ===", error);

					});

				} else {

					console.log('Bucket not matched');

				}

			}

			if (photo != oldImageFile) {

				photo = photo.replace(/^data:image\/[a-z]+;base64,/, "")

				var uploadTask = await storageRef.child(fileName).putString(photo, 'base64', { contentType: 'image/jpg' });

				var downloadURL = await uploadTask.ref.getDownloadURL();

				newPhoto = downloadURL;

				photo = downloadURL;



			} else {

				newPhoto = photo;

			}

		} catch (error) {

			console.log("ERR ===", error);

		}

		return newPhoto;

	}



</script>

@endsection

