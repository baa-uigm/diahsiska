<div class='d-flex gap-2'>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class='fa-solid fa-user-pen fs-5'></i>
    </button>
    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('study.destroy', $study->id) }}"
        method="POST">
        @csrf
        @method('DELETE')
        <button type='submit' class='btn btn-danger px-2'><i class='fa-solid fa-trash fs-5'></i></button>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("editButton").addEventListener("click", function() {
            let studyId = "{{ $study->id }}";
            $.ajax({
                type: 'GET',
                url: 'study/' + studyId + '/edit',
                success: function(response) {
                    $('#editModal').find('.modal-body').html(response);
                }
            });
        });
    });
</script>
