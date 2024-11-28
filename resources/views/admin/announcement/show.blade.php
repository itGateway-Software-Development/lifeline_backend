@extends('layouts.app')
@section('title', 'Announcement Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-cart-add' style="color: rgb(78, 161, 57);" ></i>
        <div>Announcement Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Announcement Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>Image</th>
                    <td>
                        <img width="250" src="{{url('storage/images/'.$announcement->image)}}" alt="">
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!!  $announcement->content !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
