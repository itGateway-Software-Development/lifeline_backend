@extends('layouts.app')
@section('title', 'Create Promotion')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-gift' style="color: rgb(78, 161, 57);" ></i>
        <div>{{ __('messages.promotions.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.promotions.title') }} Creation</span>

        <form action="{{ route('admin.promotions.store') }}" method="post" id="promotion_create" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.promotion_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}" class="title">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.main_img') }}</label>
                        <input type="file" name="main_img" class="form-control" onchange="showPreviewMain(this);" required>
                        <img src="" class="mt-3" style="object-fit: cover;" alt="" id="preview_img">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.info_img') }}</label>
                        <input type="file" name="info_img" class="form-control" onchange="showPreviewInfo(this);" required>
                        <img src="" class="mt-3" style="object-fit: cover;" alt="" id="preview_img_info">
                    </div>
                </div>

                <div class="col-md-10 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.promotions.fields.content') }} <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control cke-editor content"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StorePromotionRequest', '#promotion_create') !!}
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

        let showPreviewInfo = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview_img_info').attr('src', e.target.result).width(150).height(150);
                }

                reader.readAsDataURL(input.files[0]);
            }
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
