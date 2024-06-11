@extends('layouts.app')
@section('title', 'Create Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-food-menu' style="color: rgb(182, 119, 36);"></i>
        <div>{{ __('messages.category.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.category.title') }} Creation</span>

        <form action="{{ route('admin.categories.store') }}" method="post" id="category_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.category.fields.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.category.fields.group') }}</label>
                        <select name="group_id" id="group_id" class="form-select select2" data-placeholder="---Please Select---">
                            <option value=""></option>
                            @foreach ($groups as $group)
                                <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreCategoryRequest', '#category_create') !!}

@endsection
