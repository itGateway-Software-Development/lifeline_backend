@extends('layouts.app')
@section('title', 'Edit Location')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-city' style="color: rgb(16, 184, 10);"></i>
        <div>{{ __('messages.locations.title') }} Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.locations.title') }} Edition</span>

        <form action="{{ route('admin.locations.update', $location->id) }}" method="post" id="location_edit">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.locations.fields.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{old('name', $location->name)}}" class="name" placeholder="Eg. Yangon">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.locations.fields.description') }} <span style="font-size: 10px;">(Optional)</span></label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control description">{{$location->description}}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateLocationRequest', '#location_edit') !!}

@endsection
