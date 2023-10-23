@extends('welcome')
@section('content')
    <div class="container">
        <div class="products">
            <div class="products__item">
                <div class="">АРТИКУЛ</div>
                <div class="">НАЗВАНИЕ</div>
                <div class="">СТАТУС</div>
                <div class="">АТРИБУТЫ</div>
            </div>
            @foreach($products as $product)
                <div class="products__item item" data-id="{{$product->id}}">
                    <div>{{$product->article}}</div>
                    <div>{{$product->name}}</div>
                    <div>{{$product->status}}</div>
                    @if(is_array($product->data))
                        @foreach($product->data as $key => $value)
                            {{ $key }}: {{ $value }}<br>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
        <div class="products__window"></div>
        <button class="product-add">Добавить</button>
    </div>
@endsection
@section('javascript')
    <script>
        $(function () {
            $(".container").on("click",'.item', function () {
                let productId = $(this).data('id');
                $.ajax({
                    url: '/products/' + productId,
                    method: 'GET',
                    success: function (data) {
                        $('.products__window').html(data);
                    }
                });
            });
            $(".container").on("click",'.product-add', function () {
                $.ajax({
                    url: '/products/create',
                    method: 'GET',
                    success: function (data) {
                        $('.products__window').html(data);
                    }
                });
            });
        });
    </script>
@endsection
