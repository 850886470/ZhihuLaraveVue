@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">发布问题</div>

                    <div class="card-body">
                        <form action="/questions" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{$errors->has('title') ? ' has-error':''}}">
                                <label for="title">标题</label>
                                <input value="{{old('title')}}" placeholder="标题" name="title" type="text" class="form-control">
                                @if ($errors->has('title'))
                                    <span class="help-block has-error">
                                        <strong>{{$errors->first('title')}}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <select name="topics[]" class="form-control js-example-placeholder-multiple js-states form-control" multiple="multiple">

                                </select>
                            </div>

                            <div class="form-group{{$errors->has('title') ? ' has-error':''}} ">
                                <label for="body">描述</label>
                                <!-- 编辑器容器 -->
                                <script style="height: 220px;" class="ue_editor" id="container" name="body" type="text/plain">{!! old('body')  !!}</script>

                                @if($errors->has('body'))
                                    <span class="help-block has-error">
                                        <strong >{{$errors->first('body')}}</strong>
                                    </span>
                                @endif
                            </div>

                            <button class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('js')
    <script>
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
            //ue.execCommand('serverparam', '_token', laravel.csrfToken); // 设置 CSRF token.
        });



    </script>
    <script>
        $(document).ready(function () {
            function formatTopic (topic) {

                return "<div class='select2-result-repository clearfix'>" +

                "<div class='select2-result-repository__meta'>" +

                "<div class='select2-result-repository__title'>" +

                topic.name ? topic.name : "Laravel"   +

                    "</div></div></div>";

            }


            function formatTopicSelection (topic) {

                return topic.name || topic.text;

            }


            $(".js-example-placeholder-multiple").select2({

                tags: true,

                placeholder: '选择相关话题',

                minimumInputLength: 2,

                ajax: {

                    url: '/api/topics',

                    dataType: 'json',

                    delay: 250,

                    method:'get',

                    data: function (params) {

                        return {

                            q: params.term

                        };

                    },

                    processResults: function (data, params) {

                        return {

                            results: data

                        };

                    },

                    cache: true

                },

                templateResult: formatTopic,

                templateSelection: formatTopicSelection,

                escapeMarkup: function (markup) { return markup; }

            });
        })
    </script>
@endsection

