@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-capsule' style="color: rgb(8, 184, 175);"></i>
        <div>{{ __('messages.product.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.product.title') }} Edition</span>

        <form action="{{ route('admin.products.update', $product->id) }}" method="post" id="product_edit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 ">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.price') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary text-white">MMK</span>
                            <input type="number" class="form-control" name="price"
                                value="{{ old('price', $product->price) }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4 ">
                        <label for="">{{ __('messages.product.fields.principle') }}</label>
                        <select name="principle_id" id="" class="form-control select2"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($principles as $id => $value)
                                <option value="{{ $id }}"
                                    {{ old('principle_id') || $product->principle_id == $id ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.category') }}</label>
                        <select name="category_id" id="" class="form-control select2 category_id"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($categories as $id => $value)
                                <option value="{{ $id }}" {{ old('category_id') == $id || $id == $product->category_id ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.group') }}</label>
                        <input type="text" name="" readonly class="form-control group_name" value="{{$group_name}}">
                        <input type="hidden" name="group_id" class="group_id" value="{{$product->group_id}}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.photo') }}</label>
                        <div class="needslick dropzone" id="image-dropzone">

                        </div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mt-3 mb-5">
                <button type="button" class="btn ms-3 ps-0 d-flex justify-content-start align-items-center gap-1">Product Detail Info <i class='bx bxs-down-arrow fs-6' ></i></button>

                <div class="col-12">
                    <div class="border border-2 border-info rounded p-3">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">{{ __('messages.product.fields.presentation') }}</label>
                                    <input type="text" name="presentation" class="form-control" value="{{ old('presentation', $product->presentation) }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">{{ __('messages.product.fields.group') }}</label>
                                    <input type="text" name="detail_group" class="form-control" value="{{ old('detail_group', $product->detail_group) }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">{{ __('messages.product.fields.dose') }}</label>
                                    <input type="text" name="dose" class="form-control" value="{{ old('dose', $product->dose) }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">{{ __('messages.product.fields.indication') }}</label>
                                    <textarea name="indication" id="indication" cols="30" rows="5" class="form-control cke-editor">{{old('indication', $product->indication)}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.ingredient') }}</label>
                        <div class="mb-2">
                            <span class="text-white p-1 rounded-1 cursor-pointer select-all"
                                style="font-size: 12px; background: rgb(27, 199, 170);">Select
                                All</span>
                            <span class="text-white p-1 rounded-1 cursor-pointer disselect-all"
                                style="font-size: 12px; background: rgb(27, 199, 170);">Disselect
                                All</span>
                        </div>
                        <select name="ingredients[]" id="ingredients" class="select2 form-control" multiple="multiple"
                            data-placeholder="--- Please Select ---">
                            @foreach ($ingredients as $id => $value)
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('ingredients', [])) || $product->ingredients->contains($id) ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateProductRequest', '#product_edit') !!}

    <script>
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
                @if (isset($product) && $product->getMedia('images')->isNotEmpty())
                    var files = {!! json_encode($product->getMedia('images')->toArray()) !!};
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
                .create( document.querySelector( '#indication' ) )
                .catch( error => {
                console.error( error );
            });

            $(document).on('change', '.category_id', function() {
                let category_id = $(this).val();

                $.ajax({
                    url: "/admin/product-get-group?category_id="+category_id,
                    type: 'GET',
                    success: function(res) {
                       if(res) {
                            $('.group_name').val(res.group.name);
                            $('.group_id').val(res.group.id);
                       }
                    }
                })
            })
        })
    </script>
@endsection
