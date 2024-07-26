@extends('layouts.app')
@section('title', 'Edit Photo Gallery')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-photo-album' style="color: rgb(62, 136, 62);"></i>
        <div>{{ __('messages.photo_gallery.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.photo_gallery.title') }} Edition</span>

        <form action="{{ route('admin.photo-gallery.update', $photo_gallery->id) }}" method="post" id="photo_gallery_edit">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.photo_gallery.fields.title') }}</label>
                        <select name="title" id="" class="form-select select2" data-placeholder="---Please Select---">
                            <option value=""></option>
                            <option value="academic_acitivity" {{$photo_gallery->title == 'academic_acitivity' ? 'selected' : ''}}>Academic Activities</option>
                            <option value="csr" {{$photo_gallery->title == 'csr' ? 'selected' : ''}}>CSR</option>
                            <option value="donation" {{$photo_gallery->title == 'donation' ? 'selected' : ''}}>Donation</option>
                            <option value="events" {{$photo_gallery->title == 'events' ? 'selected' : ''}}>Events</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.photo_gallery.fields.date') }}</label>
                        <select name="date" id="" class="form-select select2" data-placeholder="---Please Select---">
                            <option value=""></option>
                            @foreach ($years as $year)
                                <option value="{{$year}}" {{$year == $photo_gallery->date ? 'selected' : ''}}>{{$year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.photo_gallery.fields.photos') }}</label>
                        <div class="needslick dropzone" id="image-dropzone">

                        </div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdatePhotoGalleryRequest', '#photo_gallery_edit') !!}
    <script>
        let uploadedImageMap = {}
        Dropzone.options.imageDropzone = {
            url: "{{ route('admin.photo-gallery.storeMedia') }}",
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
                    url: "{{ route('admin.photo-gallery.deleteMedia') }}", // Change this to the appropriate delete route
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
                @if (isset($photo_gallery) && $photo_gallery->getMedia('photo_gallery')->isNotEmpty())
                    var files = {!! json_encode($photo_gallery->getMedia('photo_gallery')->toArray()) !!};
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
            }

        }
        $(document).ready(function() {

        })
    </script>
@endsection
