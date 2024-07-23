@extends('layouts.app')
@section('title', 'Edit News & Events')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-news' style="color: rgb(82, 138, 223);"></i>
        <div>{{ __('messages.news.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.news.title') }} Edition</span>

        <form action="{{ route('admin.new-events.update', $newEvent->id) }}" method="post" id="news_edit">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.news_title') }} <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" name="title" value="{{old('title', $newEvent->title)}}" class="title">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.date') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control news_date bg-transparent" value="{{$newEvent->date}}" name="date" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-lg-8 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.news.fields.content') }} <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control cke-editor content" placeholder="Write content ...">{{old('content', $newEvent->content)}}</textarea>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateNewsRequest', '#news_edit') !!}
    <script>
        let uploadedImageMap = {}
        Dropzone.options.imageDropzone = {
            url: "{{ route('admin.media.storeMedia') }}",
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
            init: function() {
                @if (isset($newEvent) && $newEvent->getMedia('news_events')->isNotEmpty())
                    var files = {!! json_encode($newEvent->getMedia('news_events')->toArray()) !!};
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
            let news_date = $('.news_date');
            if(news_date) {
                news_date.flatpickr({
                    dateFormat: "Y-m-d",
                })
            }

            ClassicEditor
                .create( document.querySelector( '#content' ) )
                .catch( error => {
                console.error( error );
            });
        })
    </script>
@endsection
