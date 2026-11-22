<div class="sipena-recaptcha"
     style="margin: 18px 0; max-width: 100%; overflow-x: auto;">

    @if (config('recaptcha.site_key'))

        <div class="g-recaptcha"
             data-sitekey="{{ config('recaptcha.site_key') }}">
        </div>

    @else

        <p style="color: red;">
            reCAPTCHA belum dikonfigurasi.
        </p>

    @endif

    @error('g-recaptcha-response')
        <p style="color: red; font-size: 12px;">
            {{ $message }}
        </p>
    @enderror

</div>

@once
<script
    src="https://www.google.com/recaptcha/api.js?hl=id"
    async defer>
</script>
@endonce
