@extends('pc.layout.pc')
@section('css')
    <link rel="stylesheet" href="{{asset('pc/css/city.css')}}">
@endsection
@section('content')
    <div id="main">
        <div class="city bgff">
            <p class="current">
                <span>当前城市：</span>
                <span>{{session('city_name')}}</span>
            </p>
            <p class="hot mb40">
                <span>热门城市：</span>
                @if($hot_cities)
                    @foreach($hot_cities as $hot_city)
                        <a href="{{url('/').'/'.$hot_city['pinyin']}}"><span>{{$hot_city['name']}}</span></a>
                    @endforeach
                @endif
            </p>
            <ul>
                @if($cities)
                    @foreach($cities as $key=>$group)
                <li class="clear">
                    <div class="capital">{{$key}}</div>
                    <p class="single fl">
                        @if($group)
                            @foreach($group as $item)
                                <a href="{{url('/').'/'.$item['pinyin']}}">{{$item['name']}}</a>
                            @endforeach
                        @endif
                    </p>
                </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(function () {
        $('.single a').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
        })
    })
</script>
@endsection