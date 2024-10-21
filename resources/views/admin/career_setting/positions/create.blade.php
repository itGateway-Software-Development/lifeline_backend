@extends('layouts.app')
@section('title', 'Create Position')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-briefcase-alt-2' style="color: rgb(16, 184, 10);"></i>
        <div>{{ __('messages.positions.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.positions.title') }} Creation</span>

        <form action="{{ route('admin.positions.store') }}" method="post" id="position_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.positions.fields.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" class="name" placeholder="Eg. HR">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.positions.fields.description') }} <span style="font-size: 10px;">(Optional)</span></label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control description"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StorePositionRequest', '#position_create') !!}
@endsection
