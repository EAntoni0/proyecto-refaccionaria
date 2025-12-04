
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
   
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Hecho!',
            text: "{{ session('success') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    document.addEventListener('livewire:initialized', () => {
        
        Livewire.on('swal', (data) => {
            Swal.fire(data[0]);
        });

    });

    // Si Laravel envía un mensaje de 'error'
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    @endif

    // 3. Función global para confirmar eliminación
    // Esta función la llamaremos desde los botones de la tabla
    function confirmDelete(formId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario dice que sí, enviamos el formulario manualmente
                document.getElementById(formId).submit();
            }
        });
    }
</script>