<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<p>
    <button class="btn btn-primary btn-lg glyphicon glyphicon-refresh" type="button">
        <img src="{{ $route }}" id="cap"
             alt="https://github.com/karim-007/laravel-captcha"
             style="cursor:pointer;width:{{ $width }}px;height:{{ $height }}px;"
             title="{{ $title }}"
             onclick="this.setAttribute('src','{{ $route }}?_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}"
        ><i style="cursor:pointer;width:30px;height:30px;" class="material-icons" onclick="document.getElementById('cap').setAttribute('src','{{ $route }}?_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}"
        >refresh</i>
    </button>
</p>

