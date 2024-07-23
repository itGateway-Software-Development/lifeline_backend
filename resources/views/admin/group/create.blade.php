@extends('layouts.app')
@section('title', 'Create Group')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-pie-chart-alt-2' style="color: rgb(14, 97, 41);"></i>
        <div>{{ __('messages.group.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.group.title') }} Creation</span>

        <form action="{{ route('admin.groups.store') }}" method="post" id="group_create" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.group.fields.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.group.fields.photo') }}</label>
                        <input type="file" name="photo" class="form-control" onchange="showPreview(this);" required>
                        <img src="" class="mt-3" style="object-fit: cover;" alt="" id="preview_img">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreGroupRequest', '#group_create') !!}
    <script>
        let showPreview = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview_img').attr('src', e.target.result).width(150).height(150);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
