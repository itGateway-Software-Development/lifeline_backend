@extends('layouts.app')
@section('title', 'Create CSR Activity')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-spa' style="color: rgb(62, 136, 62);"></></i>
        <div>{{ __('messages.csr.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.csr.title') }} Creation</span>

        <form action="{{ route('admin.csr-activities.store') }}" method="post" id="csr_create">
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
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create</button>
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

        })
    </script>
@endsection
