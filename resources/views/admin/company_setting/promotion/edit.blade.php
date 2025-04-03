@extends('layouts.app')
@section('title', 'Edit Promotion')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-gift' style="color: rgb(78, 161, 57);" ></i>
        <div>{{ __('messages.promotions.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.promotions.title') }} Edition</span>

        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="post" id="promotion_edit" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.promotion_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{old('title', $promotion->title)}}" class="title">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.main_img') }}</label>
                        <input type="file" name="main_img" class="form-control" onchange="showPreviewMain(this);" required>
                        <img width="150" src="{{url('storage/images/'.$promotion->main_img)}}" class="mt-3" style="object-fit: cover;" alt="" id="preview_img">
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.photo') }}</label>
                        <div class="needslick dropzone" id="image-dropzone">

                        </div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.content') }} <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control cke-editor content">{{$promotion->content}}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdatePromotionRequest', '#promotion_edit') !!}
    <script>
        let showPreviewMain = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview_img').attr('src', e.target.result).width(150).height(150);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        let uploadedImageMap = {}
        Dropzone.options.imageDropzone = {
            url: "{{ route('admin.products.storeMedia') }}",
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
                let name = file.name || uploadedImageMap[file.name];
                $('input[name="images[]"][value="' + name + '"]').remove();

                $.ajax({
                    url: "{{ route('admin.products.deleteMedia') }}", // Change this to the appropriate delete route
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
            init: function() {
                @if (isset($promotion) && $promotion->getMedia('promotion_images')->isNotEmpty())
                    var files = {!! json_encode($promotion->getMedia('promotion_images')->toArray()) !!};
                    var server_url = "{{ url('/media/') }}";

                    files.forEach(file => {
                        var mockFile = {
                            name: file.file_name, // Ensure this matches the actual file name attribute
                            size: file.size,
                            accepted: true
                        };

                        // Add the file to Dropzone's files array
                        this.files.push(mockFile);

                        // Emit the Dropzone events
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, server_url + '/' + file.id + '/' + file.file_name);
                        this.emit("complete", mockFile);

                        // Append hidden input to the form
                        $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">');

                        // Ensure the thumbnail image styles are set correctly
                        var thumbnailElement = mockFile.previewElement.querySelector(".dz-image img");
                        thumbnailElement.style.maxWidth = "100%";
                        thumbnailElement.style.height = "auto";
                    });
                @endif

            },


        }

        $(document).ready(function() {

            ClassicEditor
                .create( document.querySelector( '#content' ) )
                .catch( error => {
                console.error( error );
            });
        })
    </script>
@endsection
