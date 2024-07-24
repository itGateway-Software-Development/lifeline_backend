@extends('layouts.app')
@section('title', 'Edit Services')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-donate-heart' style="color: rgb(235, 92, 82);"></i>
        <div>{{ __('messages.services.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.services.title') }} Edition</span>

        <form action="{{ route('admin.services.update', $service->id) }}" method="post" id="service_edit">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.services.fields.service_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{old('title', $service->title)}}" class="title">
                    </div>
                </div>

                <div class="col-md-10 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.services.fields.content') }} <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control cke-editor content">{{$service->content}}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateServiceRequest', '#service_edit') !!}
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
