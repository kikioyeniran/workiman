<script type="text/javascript">
    $(document).on('ready', () => {
        @if($errors->count())
            Snackbar.show({
                text: "{{ $errors->first() }}",
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#721c24'
            });
        @endif
        @if(Session::has('danger'))
            Snackbar.show({
                text: "{!! Session::get('danger') !!}",
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#721c24'
            });
        @endif
        @if(Session::has('success'))
            Snackbar.show({
                text: "{!! Session::get('success') !!}",
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#155724'
            });
        @endif
        @if(Session::has('info'))
            Snackbar.show({
                text: "{!! Session::get('info') !!}",
                pos: 'top-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 5000,
                textColor: '#fff',
                backgroundColor: '#0c5460'
            });
        @endif
    })
</script>
