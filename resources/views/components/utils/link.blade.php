@props(['active' => '', 'text' => '', 'hide' => false, 'icon' => false, 'permission' => false])

<a {{ $attributes->merge(['href' => '#', 'class' => $active]) }}>{{ strlen($text) ? $text : $slot }}</a>
