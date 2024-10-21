@extends('layouts.app')
@section('title', 'Edit Department')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-city' style="color: rgb(16, 184, 10);"></i>
        <div>{{ __('messages.departments.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.departments.title') }} Edition</span>

        <form action="{{ route('admin.departments.update', $department->id) }}" method="post" id="department_edit">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.departments.fields.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{old('name', $department->name)}}" class="name" placeholder="Eg. HR">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.departments.fields.description') }} <span style="font-size: 10px;">(Optional)</span></label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control description">{{$department->description}}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateDepartmentRequest', '#department_edit') !!}

@endsection
