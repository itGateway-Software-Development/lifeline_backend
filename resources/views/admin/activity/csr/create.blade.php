@extends('layouts.app')
@section('title', 'Create CSR Activity')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-spa' style="color: rgb(62, 136, 62);"></></i>
        <div>{{ __('messages.csr.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        @include('loading')

        <span class="mb-4">{{ __('messages.csr.title') }} Creation</span>

        <form action="{{ route('admin.csr-activities.store') }}" method="post" id="csr_create" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.csr.fields.csr_title') }} <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" name="title" value="{{old('title')}}" class="title">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.csr.fields.date') }} <span class="text-danger">*</span></label>
                        <select name="date" id="" class="form-select select2" data-placeholder="---Please Select---">
                            <option value=""></option>
                            @foreach ($years as $year)
                                <option value="{{$year}}" {{old('date') == $year ? 'selected' : ''}}>{{$year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.csr.fields.content') }} <span class="text-danger">*</span></label>
                        <textarea name="content" id="" cols="30" rows="5" class="form-control content" placeholder="Write content ...">{{old('content')}}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.csr.fields.photos') }} <span class="text-danger">*</span></label>
                        <div class="needslick dropzone" id="image-dropzone">

                        </div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group my-4 video-group">
                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom">
                            <label for="">{{ __('messages.csr.fields.videos') }}</label>
                            <i class='bx bx-plus me-2 bg-info p-1 cursor-pointer rounded-circle text-white add-video'></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                            <input type="file" class="form-control " name="videos[]" accept="video/*">
                            <i class='bx bx-minus bg-danger p-1 cursor-pointer rounded-circle text-white remove-video'></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary" id="submit_button">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreCSRRequest', '#csr_create') !!}
    <script>
        let uploadedImageMap = {}
        Dropzone.options.imageDropzone = {
            url: "{{ route('admin.csr-activities.storeMedia') }}",
            maxFilesize: 10,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {

                $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                uploadedImageMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove();
                file.previewElement.remove();
                let name = file.file_name || uploadedImageMap[file.name];
                $('input[name="images[]"][value="' + name + '"]').remove();

                $.ajax({
                    url: "{{ route('admin.csr-activities.deleteMedia') }}", // Change this to the appropriate delete route
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        file_name: name
                    },
                    success: function(response) {
                        console.log("File deleted successfully:", response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting file:", error);
                    }
                });
            },
        }
        $(document).ready(function() {
            $(document).on('click', '.add-video', function() {
                $('.video-group').append(`
                    <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                        <input type="file" class="form-control " name="videos[]" accept="video/*">
                        <i class='bx bx-minus bg-danger p-1 cursor-pointer rounded-circle text-white remove-video'></i>
                    </div>
                `)
            })

            $(document).on('click', '.remove-video', function() {
                $(this).parent().remove();
            })

            $('#submit_button').on('click', function(e) {
                e.preventDefault();
                $('.load-page').removeClass('d-none')

                // Create a FormData object to handle file uploads
                var formData = new FormData($('#csr_create')[0]);

                $.ajax({
                    url: "{{ route('admin.csr-activities.store') }}",
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
                                    window.location.href = "{{ route('admin.csr-activities.index') }}";
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
                                    window.location.href = "{{ route('admin.csr-activities.index') }}";
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
                                        window.location.href = "{{ route('admin.csr-activities.index') }}";
                                    }
                                });
                        } else {
                            Swal.fire({
                                    icon: "error",
                                    title: "Fail",
                                    text: "Something went wrong. Please try again later.",
                                }).then(result => {
                                    if(result.isConfirmed) {
                                        window.location.href = "{{ route('admin.csr-activities.index') }}";
                                    }
                                });
                        }
                    }
                });
            });

        })
    </script>
@endsection
