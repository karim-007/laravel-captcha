<img src="{{ $route }}"
     alt="https://github.com/karim-007/laravel-captcha"
     style="cursor:pointer;width:{{ $width }}px;height:{{ $height }}px;"
     title="{{ $title }}"
     onclick="this.setAttribute('src','{{ $route }}?_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}"
>
