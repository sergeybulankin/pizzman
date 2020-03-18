@extends('layout.index')
    @section('yandex')
        @include('components.yandex')
    @endsection()

    @section('calendar')
        <link href={{ asset('css/datepicker.css') }} type="text/css" rel="stylesheet">
        <script src={{ asset('js/datepicker.js') }} type="text/javascript"></script>
    @endsection()

    @section('search')
        @include('components.search')
    @endsection()

    @section('call')
        @include('components.call')
    @endsection()

    @section('modile-block')
        @include('components.mobile-block')
    @endsection()

    @section('fixed-navbar')
        @include('components.fixed-navbar')
    @endsection()

    @section('grey-navbar')
        @include('components.grey-navbar')
    @endsection()

    @section('shortcut-navbar')
        @include('components.shortcut-navbar')
    @endsection()

    @section('category-navbar')
        @include('components.category-navbar')
    @endsection()

    @section('delivery')
        @include('components.delivery')
    @endsection()

    @section('dadata')
        @include('components.dadata')
    @endsection()

    @section('delivery-scripts')
        <script>
            window.addEventListener("DOMContentLoaded", function() {
                [].forEach.call( document.querySelectorAll('.tel'), function(input) {
                    var keyCode;
                    function mask(event) {
                        event.keyCode && (keyCode = event.keyCode);
                        var pos = this.selectionStart;
                        if (pos < 3) event.preventDefault();
                        var matrix = "+7 (___) ___ ____",
                            i = 0,
                            def = matrix.replace(/\D/g, ""),
                            val = this.value.replace(/\D/g, ""),
                            new_value = matrix.replace(/[_\d]/g, function(a) {
                                return i < val.length ? val.charAt(i++) || def.charAt(i) : a
                            });
                        i = new_value.indexOf("_");
                        if (i != -1) {
                            i < 5 && (i = 3);
                            new_value = new_value.slice(0, i)
                        }
                        var reg = matrix.substr(0, this.value.length).replace(/_+/g,
                            function(a) {
                                return "\\d{1," + a.length + "}"
                            }).replace(/[+()]/g, "\\$&");
                        reg = new RegExp("^" + reg + "$");
                        if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
                        if (event.type == "blur" && this.value.length < 5)  this.value = ""
                    }

                    input.addEventListener("input", mask, false);
                    input.addEventListener("focus", mask, false);
                    input.addEventListener("blur", mask, false);
                    input.addEventListener("keydown", mask, false)

                });

            });
        </script>
    @endsection()

    @section('footer')
        @include('components.footer')
    @endsection()