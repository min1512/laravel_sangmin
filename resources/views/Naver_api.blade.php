@extends('app')
@section('scripts')
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=lj5fd777gr"></script>
<script>
    var mapOptions = {
        center: new naver.maps.LatLng(37.3595704, 127.105399),
        zoom: 10
    };

    var map = new naver.maps.Map('map', mapOptions);
</script>
@section('content')
    <div id="map" style="width:100%;height:400px;"></div>
@endsection