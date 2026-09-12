@php
    $key = $field['key'] ?? '';
    $label = $field['label'] ?? '';
    $type = $field['type'] ?? 'text';
    $required = !empty($field['required']);
    $placeholder = $field['placeholder'] ?? '';
    $options = $field['options'] ?? [];
@endphp

@if($type === 'select')
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <select name="{{ $key }}" id="{{ $key }}" {{ $required ? 'required' : '' }} class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            <option value="">{{ $placeholder ?: 'Pilih ' . $label . '...' }}</option>
            @php
                $opts = $options;
                if (empty($opts)) {
                    if ($key === 'wave') $opts = $formSettings['waves'] ?? [];
                    elseif ($key === 'track') $opts = $formSettings['tracks'] ?? [];
                    elseif ($key === 'program_type') $opts = $formSettings['programs'] ?? [];
                }
            @endphp
            @foreach($opts as $opt)
                <option value="{{ $opt }}" {{ old($key) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'textarea')
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <textarea name="{{ $key }}" id="{{ $key }}" rows="3" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old($key) }}</textarea>
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'file')
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-800 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <div class="p-4 bg-emerald-50/50 border-2 border-dashed border-emerald-300 rounded-2xl transition hover:border-[#00913e] hover:bg-emerald-50">
            <input type="file" name="{{ $key }}" id="{{ $key }}" {{ $required ? 'required' : '' }} accept=".pdf,image/*" class="w-full text-xs text-slate-700 font-medium file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-[#00913e] file:text-white hover:file:bg-[#007a34] file:cursor-pointer file:shadow-md transition">
            
            @if($key === 'payment_proof')
                <p class="text-[11px] text-slate-700 font-semibold mt-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-receipt text-emerald-700"></i>
                    <span>Rekening Resmi {{ $formSettings['bank_name'] ?? 'BSI' }}: <strong class="text-slate-900 font-black">{{ $formSettings['bank_account'] ?? '7011304251' }}</strong> a.n. <strong class="text-slate-900 font-black">{{ $formSettings['bank_holder'] ?? 'YL. Fatmawati' }}</strong></span>
                </p>
            @else
                <p class="text-[11px] text-slate-600 font-medium mt-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-file-pdf text-[#da251c]"></i>
                    <span>Format yang didukung: PDF, JPG, PNG, WebP (Maksimal 5 MB)</span>
                </p>
            @endif
        </div>
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'number')
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <input type="number" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'date')
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <input type="date" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'tel')
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <input type="tel" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder ?: '08xxxxxxxxxx' }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>

@else
    <div>
        <label for="{{ $key }}" class="block font-bold text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @else
                <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
            @endif
        </label>
        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
        @error($key) <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
    </div>
@endif
