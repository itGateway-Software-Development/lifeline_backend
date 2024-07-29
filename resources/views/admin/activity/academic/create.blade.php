@extends('layouts.app')
@section('title', 'Create Academic Activity')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-spa' style="color: rgb(62, 136, 62);"></></i>
        <div>{{ __('messages.academic.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.academic.title') }} Creation</span>

        <form action="{{ route('admin.academic-activities.store') }}" method="post" id="academic_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.academic.fields.academic_title') }} <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" name="title" value="{{old('title')}}" class="title">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.academic.fields.link') }} <span class="text-danger">*</span></label>
                        <textarea name="link" id="" cols="30" rows="5" class="form-control link" placeholder="Enter youtube video link ...">{{old('link')}}</textarea>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.academic.fields.full_link') }} <span class="text-danger">*</span></label>
                        <textarea name="full_link" id="" cols="30" rows="5" class="form-control full_link" placeholder="Enter youtube video full_link ...">{{old('full_link')}}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreAcademicActivityRequest', '#academic_create') !!}
    <script>

        $(document).ready(function() {

        })
    </script>
@endsection
