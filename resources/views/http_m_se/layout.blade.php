<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('m_se')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('m_se')}}/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="{{asset('m_se')}}/css/index.css">
    <link rel="stylesheet" href="{{asset('dplay')}}/dplay.css">
    <script src="{{asset('m_se')}}/js/jquery.min.js"></script>
    <script src="{{asset('m_se')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('m_se')}}/js/jquery.pjax.js"></script>
    <script src="{{asset('m_se')}}/js/index.js"></script>
    <script src="{{asset('dplay')}}/dplay.js"></script>
</head>
<body>
<div class="">
    <header>
        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs nav-list">
                    <li class="presentation">
                        <a href="{{route('se.index')}}">久久色首页</a>
                    </li>
                    @foreach($data['category'] as $item)
                        <li class="presentation">
                            <a href="{{route('se.category', $item->id)}}">{{$item->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a href="{{route('se.index')}}">
                    <h5 class="text-center" style="color: red">一秒钟记住久久色：www.99se99se.com</h5>
                </a>
            </div>
            <div class="col-xs-12">
                <form action="{{route('se.search')}}" method="get" class="searchForm input-group">
                    <input name="title" type="text" class="form-control"
                           placeholder="{{$title or $data['title']}}" value="{{$title or $data['title']}}">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">搜索</button>
                    </span>
                </form>
            </div>
        </div>
    </header>
    <div class="row main" id="pjax-container">
        @yield('body')
    </div>
</div>
</body>
</html>