@php
    $imagePath = $entry->avatar;
@endphp

@if ($entry->avatar)
    <div style="position: relative; display: inline-block; margin-bottom: 15px;">
        <img src="{{ asset('storage/' . $imagePath) }}"
             alt="Текущее изображение"
             style="max-width: 220px; max-height: 220px; object-fit: contain; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
    </div>
@else
    <p class="text-muted mb-3">Изображение отсутствует</p>
@endif
