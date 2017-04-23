@if(Session::has('info'))
    <script>
        $(document).ready(function (){
            $.notify("{{ session('info') }}", '{{ strtolower(session('type')) }}');
        });
    </script>
@endif
