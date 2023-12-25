
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Live Canada Tv</title>
    <link href="https://vjs.zencdn.net/8.6.1/video-js.css" rel="stylesheet" />
</head>
<body>

    {{-- @foreach ($canadalinks as $link) --}}
    <video 
    controls
    id="my-video"
    autoplay
    crossorigin="anonymous"
    >
        <source src="{{$canadalinks[0]['streams'][0]["url"]}}.m3u8" type='application/x-mpegurl'>
    </video>

    <button onclick="play()"> Play</button>

    

    {{-- <video src="{{$canadalinks[10]['streams'][0]["url"]}}" controls autoplay></video> --}}


{{-- @endforeach --}}

{{-- <script src="https://vjs.zencdn.net/8.6.1/video.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<script>
   function play() {

        console.log('loaded');
        var video = document.getElementById('my-video');
    var videoSrc = "{{$canadalinks[10]['streams'][0]["url"]}}";
    if (Hls.isSupported()) {
        // The following hlsjsConfig is required for live-stream
        var hlsjsConfig = {
            "maxBufferSize": 0,
            "maxBufferLength": 30,
            "liveSyncDuration": 30,
            "liveMaxLatencyDuration": Infinity
        }
        var hls = new Hls(hlsjsConfig);
        hls.loadSource(videoSrc);
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function () {
            video.play();
        });
    } 
    else if (elementId.canPlayType('application/vnd.apple.mpegurl')) {
        elementId.src = videoSrc;
        elementId.addEventListener('loadedmetadata', function () {
            elementId.play();
        });
    }
    };
</script>
    
</body>
</html>
