<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'Addamant' }}@yield('title')</title>
    <!-- Scripts -->
@yield('scripts')
<!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
</head>
<body>
<div class="auth">
    @yield('content')
</div>
</body>
</html>

<script>
    var fileName = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    $(document).ready(function () {
        $('#file_form').ajaxForm({
            data: {
                name: fileName,
            },
            beforeSend: function () {
                $('#success').empty();
            },
            UploadProgress: function (event, position, total, percentComplete) {
                $('.progress-bar').text(percentComplete + '%');
                $('.progress-bar').css('width', percentComplete + '%');
            },
            success: function (data) {
                if (data.errors) {
                    $('.progress-bar').text('0%');
                    $('.progress-bar').css('width', '0%');
                    let errorHtml;
                    data.errors.file.forEach(function (item) {
                        errorHtml += '<span class="text-danger"<b>' + item + '</b></span><br>';
                    });
                    $('#success').html('<span class="text-danger"<b>' + errorHtml + '</b></span>');

                }
                if (data.success) {
                    $('#success').html('<span class="text-danger"<b>' + data.success + '</b></span>')
                }
            }
        });
    });

    setInterval(function () {
        $.ajax({
            url: '/tires/get-progress',
            data: {name: fileName},
            success: function (data) {
                if (data.progress !== 0) {
                    $('.progress-bar').text(data.progress + '%');
                    $('.progress-bar').css('width', data.progress + '%');
                }
            }
        });
    }, 1000);
</script>
