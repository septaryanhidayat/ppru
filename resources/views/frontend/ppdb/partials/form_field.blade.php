@php
    $key = $field['key'] ?? '';
    $label = $field['label'] ?? '';
    $type = $field['type'] ?? 'text';
    $required = !empty($field['required']);
    $placeholder = $field['placeholder'] ?? '';
    $options = $field['options'] ?? [];
@endphp

@if($type === 'select')
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <div class="relative">
            <select name="{{ $key }}" id="{{ $key }}" {{ $required ? 'required' : '' }} class="w-full bg-white text-xs font-semibold text-slate-800 rounded-xl px-3.5 py-3 pr-8 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-[#00913e] shadow-xs cursor-pointer transition">
                <option value="" class="text-slate-400 font-normal">{{ $placeholder ?: 'Pilih ' . $label . '...' }}</option>
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
        </div>
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'textarea')
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <textarea name="{{ $key }}" id="{{ $key }}" rows="3" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" class="w-full bg-white text-xs text-slate-800 font-medium rounded-xl px-3.5 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-[#00913e] shadow-xs transition leading-relaxed">{{ old($key) }}</textarea>
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'file')
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <div class="p-4 bg-emerald-50/50 border-2 border-dashed border-emerald-300 rounded-2xl transition hover:border-[#00913e] hover:bg-emerald-50">
            <input type="file" name="{{ $key }}" id="{{ $key }}" {{ $required ? 'required' : '' }} accept=".pdf,image/*" class="w-full text-xs text-slate-700 font-medium file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-[#00913e] file:text-white hover:file:bg-[#007a34] file:cursor-pointer file:shadow-md transition">
            
            @if($key === 'payment_proof')
                <p class="text-[11px] text-slate-700 font-semibold mt-2.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-receipt text-emerald-700"></i>
                    <span>Rekening Resmi {{ $formSettings['bank_name'] ?? 'BSI' }}: <strong class="text-slate-900 font-black">{{ $formSettings['bank_account'] ?? '7011304251' }}</strong> a.n. <strong class="text-slate-900 font-black">{{ $formSettings['bank_holder'] ?? 'YL. Fatmawati' }}</strong></span>
                </p>
            @else
                <p class="text-[11px] text-slate-600 font-medium mt-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-file-pdf text-[#00843d]"></i>
                    <span>Format yang didukung: PDF, JPG, PNG, WebP (Maksimal 5 MB)</span>
                </p>
            @endif
        </div>
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'number')
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <input type="number" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" class="w-full bg-white text-xs font-semibold text-slate-800 rounded-xl px-3.5 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-[#00913e] shadow-xs transition">
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'date')
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <input type="date" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} class="w-full bg-white text-xs font-semibold text-slate-800 rounded-xl px-3.5 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-[#00913e] shadow-xs transition cursor-pointer">
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

@elseif($type === 'tel')
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <input type="tel" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder ?: '08xxxxxxxxxx' }}" class="w-full bg-white text-xs font-semibold text-slate-800 rounded-xl px-3.5 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-[#00913e] shadow-xs transition">
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

@else
    <div class="space-y-1.5">
        <label for="{{ $key }}" class="block font-black text-slate-800 text-xs leading-snug">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-red-500 font-bold ml-0.5">*</span>
            @else
                <span class="text-slate-400 font-normal text-[10.5px] ml-1 whitespace-nowrap">(Opsional)</span>
            @endif
        </label>
        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}" {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" class="w-full bg-white text-xs font-semibold text-slate-800 rounded-xl px-3.5 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-[#00913e] shadow-xs transition">
        @error($key) <p class="text-red-500 text-[11px] font-semibold mt-1">{{ $message }}</p> @enderror
    </div>
@endif
