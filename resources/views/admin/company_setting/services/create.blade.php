@extends('layouts.app')
@section('title', 'Create Services')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-donate-heart' style="color: rgb(235, 92, 82);"></i>
        <div>{{ __('messages.services.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.services.title') }} Creation</span>

        <form action="{{ route('admin.services.store') }}" method="post" id="service_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.services.fields.service_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}" class="title">
                    </div>
                </div>

                <div class="col-md-10 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.services.fields.content') }} <span class="text-danger">*</span></label>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreServiceRequest', '#service_create') !!}
    <script>
        $(document).ready(function() {

            ClassicEditor
                .create( document.querySelector( '#content' ) )
                .catch( error => {
                console.error( error );
            });
        })
    </script>
@endsection
