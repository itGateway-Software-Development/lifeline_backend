@extends('layouts.app')
@section('title', 'Create Academic Activity')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-spa' style="color: rgb(62, 136, 62);"></i>
        <div>{{ __('messages.academic.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        @include('loading')
        <span class="mb-4">{{ __('messages.academic.title') }} Creation</span>

        <form action="{{ route('admin.academic-activities.store') }}" method="post" id="academic_create" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.academic.fields.academic_title') }} <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" name="title" value="{{ old('title') }}" class="title">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.academic.fields.link') }} <span class="text-danger">*</span></label>
                        <input type="file" class="form-control link" name="link">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.academic.fields.full_link') }} <span class="text-danger">*</span></label>
                        <textarea name="full_link" id="" cols="30" rows="5" class="form-control full_link" placeholder="Enter youtube video full_link ...">{{ old('full_link') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button type="button" class="btn btn-secondary back-btn">Cancel</button>
                <button type="button" class="btn btn-primary" id="submit_button">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreAcademicActivityRequest', '#academic_create') !!}

    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#submit_button').on('click', function(e) {
                e.preventDefault();
                $('.load-page').removeClass('d-none')

                // Create a FormData object to handle file uploads
                var formData = new FormData($('#academic_create')[0]);

                $.ajax({
                    url: "{{ route('admin.academic-activities.store') }}",
                    method: "POST",
                    data: formData,
                    processData: false, // prevent jQuery from processing the data
                    contentType: false, // prevent jQuery from setting content type
                    success: function(response) {
                        // Handle the success response
                        if(response.status == 'success') {
                            $('.load-page').addClass('d-none')
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                            }).then(result => {
                                if(result.isConfirmed) {
                                    window.location.href = "{{ route('admin.academic-activities.index') }}";
                                }
                            });
                        } else {
                            $('.load-page').addClass('d-none')

                            Swal.fire({
                                icon: "error",
                                title: "Fail",
                                text: response.message,
                            }).then(result => {
                                if(result.isConfirmed) {
                                    window.location.href = "{{ route('admin.academic-activities.index') }}";
                                }
                            });
                        }

                    },
                    error: function(xhr) {
                        // Handle validation errors
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                                Swal.fire({
                                    icon: "error",
                                    title: "Fail",
                                    text: errorMessage,
                                }).then(result => {
                                    if(result.isConfirmed) {
                                        window.location.href = "{{ route('admin.academic-activities.index') }}";
                                    }
                                });
                        } else {
                            Swal.fire({
                                    icon: "error",
                                    title: "Fail",
                                    text: "Something went wrong. Please try again later.",
                                }).then(result => {
                                    if(result.isConfirmed) {
                                        window.location.href = "{{ route('admin.academic-activities.index') }}";
                                    }
                                });
                        }
                    }
                });
            });

            // Optional: Back button functionality
            $('.back-btn').on('click', function() {
                window.history.back();
            });
        });
    </script>
@endsection
