@props(['align' => 'right'])

@php
$menuAlign = $align === 'left' ? '' : 'dropdown-menu-end';
@endphp

<div class="dropdown">
    <div role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu {{ $menuAlign }} shadow-sm">
        {{ $content }}
    </div>
</div>
