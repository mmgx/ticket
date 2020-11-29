@extends('layouts.base')

@section('custom_styles')
    <style>
        .canvas-holder {
            width: 100%;
            height: 500px;
            position: relative;
        }
    </style>
@endsection

@section('custom_head_scripts')
    <script src="{{ asset('js/scheme-designer.min.js') }}"></script>
    <script>
        let places = [];
        var schemeData = {!! $schemeData !!}
    </script>
@endsection

@section('top_content')

    <div class="container" style="max-width: 800px;">
        <div style="text-align: center;">
            <h2>Схема зала</h2>

            <div class="canvas-holder" style="">
                <canvas id="canvas1" style="border: 1px solid #ccc;">
                    Ваш браузер не поддерживает элемент canvas.
                </canvas>
            </div>

            <div class="well">
                <div class="row" >
                    <div class="col-sm-2" style="margin-bottom: 5px;">
                        <button type="button" class="btn btn-primary btn-sm" onclick="schemeDesigner.getZoomManager().zoomToCenter(10)">+</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="schemeDesigner.getZoomManager().zoomToCenter(-10)">-</button>
                    </div>

                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-info btn-sm" onclick="schemeDesigner.getScrollManager().toCenter(); schemeDesigner.requestRenderAll();">
                            Прокрутить к центру
                        </button>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" id="book" class="btn btn-primary btn-sm" onclick="booking(places, {{ $eventId }})">
                            Купить билеты
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/scheme.js') }}"></script>


@endsection

@section('bottom_scripts')
@endsection
