<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div style="margin-bottom: 2px;background: {{config('captcha.background')}}"c>
    <img src="{{ $route }}" id="cap"
         alt="https://github.com/karim-007/laravel-captcha"
         style="cursor:pointer;width:{{ $width }}px;height:{{ $height }}px;"
         title="{{ $title }}"
         onclick="this.setAttribute('src','{{ $route }}?_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}"
    ><i style="cursor:pointer;width:30px;height:30px; color: {{config('captcha.colors')}}" class="material-icons" onclick="document.getElementById('cap').setAttribute('src','{{ $route }}?_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}"
    >refresh</i>
</div>

