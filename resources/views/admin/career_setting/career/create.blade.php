@extends('layouts.app')
@section('title', 'Create Career')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-briefcase-alt-2' style="color: rgb(16, 184, 10);"></i>
        <div>{{ __('messages.careers.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.careers.title') }} Creation</span>

        <form action="{{ route('admin.careers.store') }}" method="post" id="career_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.careers.fields.position') }} <span class="text-danger">*</span></label>
                        <select name="position_id" id="" class="form-control select2 position_id"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.careers.fields.department') }} <span class="text-danger">*</span></label>
                        <select name="department_id" id="" class="form-control select2 department_id"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.careers.fields.location') }} <span class="text-danger">*</span></label>
                        <select name="location_id" id="" class="form-control select2 location_id"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.careers.fields.posts') }} <span class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control" name="posts" value="{{old('posts')}}" class="posts" placeholder="Eg. 2">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.careers.fields.careers_title') }} <span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" name="title" value="{{old('title')}}" class="title" placeholder="Eg. Open Position for Store Department">
                    </div>
                </div>

                <div class="col-md-8  col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.careers.fields.requirements') }} <span class="text-danger">*</span></label>
                        <textarea name="requirements" id="requirements" cols="30" rows="5" class="form-control cke-editor requirements"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreCareerRequest', '#career_create') !!}

    <script>
        $(document).ready(function() {

            ClassicEditor
                .create( document.querySelector( '#requirements' ) )
                .catch( error => {
                console.error( error );
            });
        })
    </script>
@endsection
