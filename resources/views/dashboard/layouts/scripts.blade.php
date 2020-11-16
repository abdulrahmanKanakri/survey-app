<!-- jQuery -->
<script src="{{asset('assets/AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('assets/AdminLTE/dist/js/adminlte.js')}}"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- Excel Stuff -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<script>
    const showAlert = (type, msg, icon = null) => {
        Swal.fire({
            icon: icon ?? type,
            title: type,
            text: msg
        })
    }

    const deleteAlert = (btn) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                btn.previousElementSibling.submit()
            }
        })
    }
    
    // Set the filtered value to the filters
    function setQueryValuesIntoFilters() {
        let parsedUrl = new URL(window.location.href);
        const survey = parsedUrl.searchParams.get("filters[survey]");
        const username = parsedUrl.searchParams.get("filters[username]");
        if(survey)
            document.querySelector('input[name="filters[survey]"]').value = survey;
        if(username)
            document.querySelector('input[name="filters[username]"]').value = username;
    }
</script>