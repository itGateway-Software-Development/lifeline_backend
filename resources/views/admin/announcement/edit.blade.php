@extends('layouts.app')
@section('title', 'Edit Announcement')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-cart-add' style="color: rgb(78, 161, 57);" ></i>
        <div>Announcement Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Announcement Edition</span>

        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="post" id="announcement_edit" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control" onchange="showPrevie(this);">
                        <img width="150" src="{{url('storage/images/'.$announcement->image)}}" class="mt-3" style="object-fit: cover;" alt="" id="image">
                    </div>
                </div>

                <div class="col-md-10 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">Content </label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control cke-editor content">{{$announcement->content}}</textarea>
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
    {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAnnouncementRequest', '#announcement_edit') !!} --}}
    <script>
        let showPrevie = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#image').attr('src', e.target.result).width(150).height(150);
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
