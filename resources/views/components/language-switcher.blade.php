<form action="{{ route('switch.language') }}" method="POST">
    @csrf
    <select name="language" id="language-select" class="form-select" onchange="this.form.submit()">
        <option value="es" {{ session('locale') == 'es' ? 'selected' : '' }}>{{ __('Español') }}</option>
        <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>{{ __('Inglés') }}</option>
    </select>
</form>
