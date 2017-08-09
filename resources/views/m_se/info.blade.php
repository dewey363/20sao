<div class="col-xs-12">
    <div class="panel panel-default contentLeft">
        <div class="panel-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="./">首页</a>
                    </li>
                    <li>
                        <a href="{{route('se.category', ['id' => $info->type_id])}}">{{$info['typeName']}}</a>
                    </li>
                    <li class="active">{{$info->title}}</li>
                </ol>
            </div>
        </div>
        <div class="panel-body dataInfo">
            <div class="panel-body">
                <div class="row">
                    <div id="player" style="width: 100%;"></div>
                </div>
            </div>
            <div class="panel-body dataList">
                <!--热门推荐start-->
                <div class="row header">
                    <div class="col-xs-8">
                        <h4 class="title">
                            <span class="hotThumb"></span>
                            <a href="">你可能喜欢</a>
                        </h4>
                    </div>
                </div>
                @if($data['isMobile'])
                    <div class="list-group">
                    @foreach($rands as $item)
                        @if($loop->index %2 == 0)
                            <div class="row list-group-item shipin">
                                <div class="col-xs-6">
                                    <a href="{{route('se.info', $item->id)}}" @if($data['isMobile']) target="_blank"@endif class="thumbnail">
                                        <img src="{{route('se.getThumb', $item->id)}}" />
                                    </a>
                                    <a href="{{route('se.info', $item->id)}}" @if($data['isMobile']) target="_blank"@endif>
                                        <div class="title">{{$item->title}}</div>
                                    </a>
                                </div>
                                @elseif($loop->index %2 == 1)
                                    <div class="col-xs-6">
                                        <a href="{{route('se.info', $item->id)}}" @if($data['isMobile']) target="_blank"@endif class="thumbnail">
                                            <img src="{{route('se.getThumb', $item->id)}}" />
                                        </a>
                                        <a href="{{route('se.info', $item->id)}}" @if($data['isMobile']) target="_blank"@endif>
                                            <div class="title">{{$item->title}}</div>
                                        </a>
                                    </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @else
                    <div class="list-group">
                        @foreach($randPc as $item)
                            @if($loop->index %4 == 0)
                                <div class="row list-group-item shipin">
                                    <div class="col-sm-3">
                                        <a href="{{route('se.info', $item->id)}}" class="thumbnail">
                                            <img src="{{route('se.getThumb', $item->id)}}" />
                                        </a>
                                        <a href="{{route('se.info', $item->id)}}">
                                            <div class="title">{{$item->title}}</div>
                                        </a>
                                    </div>
                                    @elseif($loop->index %4 == 3)
                                        <div class="col-sm-3">
                                            <a href="{{route('se.info', $item->id)}}" class="thumbnail">
                                                <img src="{{route('se.getThumb', $item->id)}}" />
                                            </a>
                                            <a href="{{route('se.info', $item->id)}}" >
                                                <div class="title">{{$item->title}}</div>
                                            </a>
                                        </div>
                                </div>
                                    @else
                                        <div class="col-sm-3">
                                            <a href="{{route('se.info', $item->id)}}" class="thumbnail">
                                                <img src="{{route('se.getThumb', $item->id)}}" />
                                            </a>
                                            <a href="{{route('se.info', $item->id)}}" >
                                                <div class="title">{{$item->title}}</div>
                                            </a>
                                        </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.breadcrumb').css('background-color','#000');
        $('.dplayer-bezel,.dplayer-mask').css('background-color', 'none');
    })
    var dp = new DPlayer({
        element: document.getElementById('player'),
        theme: '#ddd',
        video: {
            url: '{{$info->file_url}}',
            type: 'auto'
        },
    });
</script>