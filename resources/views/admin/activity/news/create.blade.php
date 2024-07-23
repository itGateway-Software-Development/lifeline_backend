@extends('layouts.app')
@section('title', 'Create New & Events')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-news' style="color: rgb(82, 138, 223);"></i>
        <div>{{ __('messages.news.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.news.title') }} Creation</span>

        <form action="{{ route('admin.new-events.store') }}" method="post" id="news_create">
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
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create</button>
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

            ClassicEditor
                .create( document.querySelector( '#content' ) )
                .catch( error => {
                console.error( error );
            });
        })
    </script>
@endsection
