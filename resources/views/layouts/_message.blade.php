<script type="text/javascript">
    $(function () {
        toastr.options = {"iconClasses": {
                error: 'toast toast-just-text toast-error',
                info: 'toast toast-just-text toast-info',
                success: 'toast toast-just-text toast-success',
                warning: 'toast toast-just-text toast-warning'
            }
        }

    @if (Session::has('message'))
        toastr.info("{{ Session::get('message') }}")
    @endif

    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}")
    @endif

    @if (Session::has('danger'))
        toastr.error("{{ Session::get('danger') }}")
    @endif
    })

</script>
