@extends('layouts.app')
@section('title', 'Create New & Events')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-news' style="color: rgb(82, 138, 223);"></i>
        <div>{{ __('messages.news.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        @include('loading')

        <span class="mb-4">{{ __('messages.news.title') }} Creation</span>

        <form action="{{ route('admin.new-events.store') }}" method="post" id="news_create" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.news_title') }} <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" name="title" value="{{old('title')}}" class="title">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.date') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control news_date bg-transparent" name="date" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.content') }}</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control cke-editor content"></textarea>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.photos') }} <span class="text-danger">*</span></label>
                        <div class="needslick dropzone" id="image-dropzone">

                        </div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreNewsRequest', '#news_create') !!}
    <script>
        let uploadedImageMap = {}
        Dropzone.options.imageDropzone = {
            url: "{{ route('admin.media.storeMedia') }}",
            maxFilesize: 256,
            maxThumbnailFilesize: 256,
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
                    url: "{{ route('admin.media.deleteMedia') }}", // Change this to the appropriate delete route
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
            let news_date = $('.news_date');
            if(news_date) {
                news_date.flatpickr({
                    dateFormat: "Y-m-d",
                })
            }

            let contentEditor;
                ClassicEditor
                    .create(document.querySelector('#content'))
                    .then(editor => {
                        contentEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });

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
                var formData = new FormData($('#news_create')[0]);
                formData.append('content', contentEditor.getData());

                $.ajax({
                    url: "{{ route('admin.new-events.store') }}",
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
                                    window.location.href = "{{ route('admin.new-events.index') }}";
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
                                    window.location.href = "{{ route('admin.new-events.index') }}";
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
                                        window.location.href = "{{ route('admin.new-events.index') }}";
                                    }
                                });
                        } else {
                            Swal.fire({
                                    icon: "error",
                                    title: "Fail",
                                    text: "Something went wrong. Please try again later.",
                                }).then(result => {
                                    if(result.isConfirmed) {
                                        window.location.href = "{{ route('admin.new-events.index') }}";
                                    }
                                });
                        }
                    }
                });
            });
        })
    </script>
@endsection
