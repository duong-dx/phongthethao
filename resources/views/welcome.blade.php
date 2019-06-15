@extends('layouts.master')
@section('content')
<div style="font-size: 15px !important; margin-top: 10%;" class="container">
    <form action="" class="dropzone" id="myDropzone">
        @csrf
      <div class="fallback">
        <input name="file" type="file" multiple />
      </div>
    </form>
 </div>
<style type="text/css">
    .dropzone {
    border: 2px dashed #0087F7;
    border-radius: 5px;
    background: white;
    }
</style>

@endsection
@section('js')  
<script type="text/javascript">
    Dropzone.options.myDropzone = {
            url: '/images',
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 10,
            maxFilesize: 5,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            dictFileTooBig: 'Image is bigger than 5MB',
            addRemoveLinks: true,
            removedfile: function(file) {
             var name = file.name;    
             name =name.replace(/\s+/g, '-').toLowerCase();    /*only spaces*/
             $.ajax({
              type: 'POST',
              url: '{{ url('deleteImg') }}',
              headers: {
               'X-CSRF-TOKEN': '{!! csrf_token() !!}'
             },
             data: "id="+name,
             dataType: 'html',
             success: function(data) {
              $("#msg").html(data);
            }
          });
             var _ref;
             if (file.previewElement) {
              if ((_ref = file.previewElement) != null) {
                _ref.parentNode.removeChild(file.previewElement);
              }
            }
            return this._updateMaxFilesReachedClass();
          },
          previewsContainer: null,
          hiddenInputContainer: "body",
      }
</script>  
@endsection