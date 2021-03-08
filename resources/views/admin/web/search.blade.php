@extends('admin.layouts.master')

@section('title')
Search results
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.dashboard') }}"><button class="btn btn-primary mb-3">
        Dashboard
    </button></a>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Tát cả kết quả
            </h6>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
            <div class="row">
                <div class="col-12">
                    <p>
                        <b>Sản phẩm</b>
                        <br/>
                        @foreach($products as $product)
                        <a href="{{ route('product.view', ['id' => $product->id]) }}">{{ $product->name }}</a>
                        </br>
                        @endforeach
                    </p>
                </div>
            </div>
            <hr/>
            @endif

            @if($orders->count() > 0)
            <div class="row">
                <div class="col-12">
                    <p>Đơn hàng</b>
                        <br/>
                        @foreach($orders as $order)
                        <a href="{{ route('order.view', ['id' => $order->id]) }}">{{ $order->cus_name }}</a>
                        </br>
                        @endforeach
                    </p>
                </div>
            </div>
            <hr/>
            @endif

            @if($contacts->count() > 0)
            <div class="row">
                <div class="col-12">
                    <p>Liên hệ</b>
                        <br/>
                        @foreach($contacts as $contact)
                        <a href="{{ route('contact.view', ['id' => $contact->id]) }}">{{ $contact->name }}</a>
                        </br>
                        @endforeach
                    </p>
                </div>
            </div>
            <hr/>
            @endif

            @if($posts->count() > 0)
            <div class="row">
                <div class="col-12">
                    <p>Bài viết</b>
                        <br/>
                        @foreach($posts as $post)
                        <a href="{{ route('post.view', ['id' => $post->id, 'slug' => Str::slug($post->title)]) }}">{{ $post->title }}</a>
                        </br>
                        @endforeach
                    </p>
                </div>
            </div>
            <hr/>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('contactLi').classList.add('active');
</script>
@endsection
