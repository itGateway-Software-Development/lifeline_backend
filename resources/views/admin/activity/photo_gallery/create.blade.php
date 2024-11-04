@extends('layouts.app')
@section('title', 'Create Photo Gallery')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-photo-album' style="color: rgb(62, 136, 62);"></i>
        <div>{{ __('messages.photo_gallery.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.photo_gallery.title') }} Creation</span>

        <form action="{{ route('admin.photo-gallery.store') }}" method="post" id="photo_gallery_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.photo_gallery.fields.title') }}</label>
                        <select name="title" id="" class="form-select select2" data-placeholder="---Please Select---">
                            <option value=""></option>
                            <option value="academic_acitivity">Academic Activities</option>
                            <option value="csr">CSR</option>
                            <option value="donation">Donation</option>
                            <option value="events">Events</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.photo_gallery.fields.date') }}</label>
                        <select name="date" id="" class="form-select select2" data-placeholder="---Please Select---">
                            <option value=""></option>
                            @foreach ($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StorePhotoGalleryRequest', '#photo_gallery_create') !!}
    <script>
        let uploadedImageMap = {}
        Dropzone.options.imageDropzone = {
            url: "{{ route('admin.photo-gallery.storeMedia') }}",
            maxFilesize: 256,
            maxThumbnailFilesize: 256,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                console.log(file);
                console.log(response);

                $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                uploadedImageMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove();
                file.previewElement.remove();
                let name = file.file_name || uploadedImageMap[file.name];
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
        }
        $(document).ready(function() {

        })
    </script>
@endsection
