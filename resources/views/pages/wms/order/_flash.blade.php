@if(session('flasher'))
    @php
        $ft = session('flasher.success') ? 'success' : 'error';
        $fm = \Illuminate\Support\Arr::first(session('flasher'));
    @endphp
    <div class="mb-4 px-4 py-3 rounded-lg border text-sm {{ $ft === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' }}">
        {{ $fm }}
    </div>
@endif
@if(isset($errors) && $errors->any())
    <div class="mb-4 px-4 py-3 rounded-lg border text-sm bg-red-50 border-red-200 text-red-800">
        <ul class="list-disc pl-4 space-y-1">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
