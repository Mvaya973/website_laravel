@props(['name', 'show' => false])

<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-labelledby="{{ $name }}-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>

@if ($show)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('{{ $name }}')).show();
        });
    </script>
@endif
