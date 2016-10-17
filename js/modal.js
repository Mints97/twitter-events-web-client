function displayModal(modalId) {
    var modal = document.getElementById(modalId);
    
    modal.style.display = "block";
    
    loadTwitterWidgets(modalId + "Data");

    // Get the <span> element that closes the modal
    var span = document.getElementById(modalId + "Close");
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}