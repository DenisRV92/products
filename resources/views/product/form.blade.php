<div class="form" data-id="{{$product->id}}">
    <div class="form-name">{{  $product->exists ? 'Редактировать ' . $product->name : 'Добавить продукт' }}</div>
    <form action="#" method="post">
        @csrf
        <label for="article">Артикул:</label>
        <input class="form-input {{ (config('products.role') != 'admin' && $product->exists ) ? 'readonly-input' : '' }}" type="text"
               id="article" name="article" required value="{{ $product->article }}"
               @if(config('products.role') != 'admin' && $product->exists) readonly @endif>

        <label for="name">Название:</label>
        <input class="form-input" type="text" id="name" name="name" required value="{{$product->name}}"
               autocomplete="name"><br>

        <label for="status">Статус:</label>
        <div class="select">
            <input class="update-input select__input" id="status" name="status"
                   value="{{  $product->status?->readable() ?? 'Доступен'}}">
            <div class="select__head">{{ $product->status?->readable() ?? 'Доступен' }}</div>
            <ul class="select__list">
                <li class="select__item">Доступен</li>
                <li class="select__item">Недоступен</li>
            </ul>
        </div>
        <div class="attribute">Атрибуты:</div>
        <div id="attributes">
            @if(isset($product->data))
                @foreach($product->data as $key => $value)
                    <div class="attribute-row">
                        <div class="row-left">
                            <div class="attribute-name-row">Название</div>
                            <input type="text" class="attribute-value" name="data[]" required value="{{$key}}">
                        </div>
                        <div class="row-right">
                            <div class="attribute-name-row">Значения</div>
                            <input type="text" class="attribute-name" name="data[]" required value="{{$value}}">
                            {{--                        <img src="{{asset('images/delete.svg')}}" class="remove-attribute">--}}
                        </div>
                        <img src="{{asset('images/delete.svg')}}" class="remove-attribute">
                    </div>
                @endforeach
            @endif
        </div>
        <div class="add-attribute">+ Добавить атрибут</div>

        <button class="{{$product->exists ? 'submit-update': 'submit-create'}}" type="submit">Сохранить</button>
    </form>
    <img class="close" src="{{asset('images/close.svg')}}" alt="">
</div>
<script>
    $(document).ready(function () {
        $('.form').on('click', '.add-attribute', function () {
            let attributeRow = '<div class="attribute-row">';
            attributeRow += '<div class="row-left">'
            attributeRow += '<div class="attribute-name-row">Название</div>';
            attributeRow += '<input type="text" class="attribute-value" name="data[]" required>';
            attributeRow += '</div>'
            attributeRow += '<div class="row-right">'
            attributeRow += '<div class="attribute-name-row">Значения</div>';
            attributeRow += '<input type="text" class="attribute-name" name="data[]" required>';
            attributeRow += '</div>'
            attributeRow += '<img src="/images/delete.svg" class="remove-attribute">';
            attributeRow += '</div>';

            $('#attributes').append(attributeRow);

        });

        $('#attributes').on('click', '.remove-attribute', function () {
            $(this).closest('.attribute-row').remove();
        });

        $('.select').on('click', '.select__head', function () {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                $(this).next().fadeOut();
            } else {
                $('.select__head').removeClass('open');
                $('.select__list').fadeOut();
                $(this).addClass('open');
                $(this).next().fadeIn();
            }
        });

        $('.select').on('click', '.select__item', function () {
            $('.select__head').removeClass('open');
            $(this).parent().fadeOut();
            $(this).closest('.select').find('.select__head').text($(this).text());
            $(this).closest('.select').find('#status').val($(this).text());
            $(this).closest('.select').find('#status').attr('value', $(this).text());
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('.select').length) {
                $('.select__head').removeClass('open');
                $('.select__list').fadeOut();
            }
        });
        $('.form').on('click', '.submit-update', function (event) {
            event.preventDefault();
            $('.text-danger').remove();
            let productId = $('.form').data('id');
            let form = $(this).closest('form');
            let formData = form.serialize();
            let dataAttributes = form.find('input[name="data[]"]');
            if (dataAttributes.length === 0) {
                formData += '&data=';
            }
            $.ajax({
                url: '/products/' + productId,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    renderProduct(response.product)
                    $('.form').remove()
                },
                error: function (response) {
                    renderError(response.responseJSON.errors)
                }
            });
        });
        $('.form').on('click', '.submit-create', function (event) {
            event.preventDefault();
            $('.text-danger').remove()
            let form = $(this).closest('form');
            let formData = form.serialize();
            $.ajax({
                url: '/products',
                type: 'POST',
                data: formData,
                success: function (response) {
                    renderProduct(response.product)
                    $('.form').remove()
                },
                error: function (response) {
                    renderError(response.responseJSON.errors)
                }
            });
        })
        $('.container').on('click', '.close', function () {
            $('.form').remove()
        });

        function renderProduct(product) {
            let productId = $('.form').data('id');
            if (product.status == "unavailable") {
                $('.products__item[data-id="' + productId + '"]').remove();
                return;
            }
            let productHtml = '';
            productHtml = '<div class="products__item item" data-id="' + product.id + '">';
            productHtml += '<div>' + product.article + '</div>';
            productHtml += '<div>' + product.name + '</div>';
            productHtml += '<div>' + product.status + '</div>';
            let data = product.data;
            if (data) {
                for (var key in data) {
                    productHtml += key + ': ' + data[key] + '<br>';
                }
            }
            productHtml += '</div>';
            if ($('.submit-create').length > 0) {
                $('.products').append(productHtml);
            } else {
                $('.products__item[data-id="' + productId + '"]').replaceWith(productHtml);
            }
        }

        function renderError(errors) {
            $.each(errors, function (field_name, error) {
                $(document).find('[name=' + field_name + ']').after('<p class="text-strong text-danger">' + error + '</p>')
            })
        }
    });
</script>
</body>
</html>

