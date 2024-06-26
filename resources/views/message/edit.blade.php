

<script>
function autoResize(textarea) {
  textarea.style.height = "auto";
  textarea.style.height = textarea.scrollHeight + "px";
}

const textarea = document.querySelector(".editHTMX");
autoResize(textarea);
</script>

<form action="{{ route("message.submitEdit")}}" hx-target="this" hx-swap="outerHTML" method="post" class="d-flex justify-content-end mb-4" >
        @csrf
        <div class="msg_cotainer_send" style="margin-right: 38px;">
            <textarea name="edit"  class="editHTMX" oninput="autoResize(this)">{{ htmlspecialchars_decode($message["content"]) }}</textarea>
            <input type="hidden" name="id" value="{{$message["id"]}}">
            <button class="submit-button"><i class="bi bi-check2"></i></button>
        </div>
 </form>

