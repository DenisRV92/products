<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="show" data-id="{{$product->id}}">
    <div class="show-header">
        <div class="show-name">{{$product->name}}</div>
    </div>
    <div class="show-item">
        <div>Артикул</div>
        <div>{{$product->article}}</div>
    </div>
    <div class="show-item">
        <div>Название</div>
        <div>{{$product->name}}</div>
    </div>
    <div class="show-item">
        <div>Статус</div>
        <div>{{$product->status}}</div>
    </div>
    <div class="show-item">
        <div>Атрибуты</div>
        <div>
            @if(is_array($product->data))
                @foreach($product->data as $key => $value)
                    {{ $key }}: {!!  $value !!}<br>
                @endforeach
            @endif
        </div>
    </div>
    <div class="show-icon">
        <img class="edit" src="{{asset('images/Edit_fill.svg')  }}" alt="">
        <img class="delete" src="{{asset('images/delete-show.svg')  }}" alt="">
    </div>
    <img class="close" src="{{asset('images/close.svg')  }}" alt="">
</div>
<script>
    $('.products__window').on('click', '.close', function () {
        $('.show').remove()
    });
    $('.products__window').on('click', '.edit', function () {
        let productId = $('.show').data('id');
        $.ajax({
            url: '/products/' + productId + '/edit',
            method: 'GET',
            success: function (data) {
                $('.products__window').html(data);
            }
        });
    });

    $('.products__window').on('click', '.delete', function () {
        let productId = $('.show').data('id');
        $.ajax({
            url: '/products/' + productId,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('.products__item[data-id="' + productId + '"]').remove();
                $('.show').remove()
            }
        });
    });
</script>
