@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.showFlashMessage('success', '{{ session("success") }}');
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.showFlashMessage('error', '{{ session("error") }}');
    });
</script>
@endif

@if (session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.showFlashMessage('warning', '{{ session("warning") }}');
    });
</script>
@endif

@if (session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.showFlashMessage('info', '{{ session("info") }}');
    });
</script>
@endif

@if (session('status') === 'profile-updated')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.showFlashMessage('success', 'Profile berhasil diperbarui');
    });
</script>
@endif
