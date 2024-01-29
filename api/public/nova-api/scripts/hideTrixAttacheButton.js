addEventListener("trix-initialize", function(event) {
    var element = event.target;
    if (!element.hasAttribute("data-has-upload")) {
        var toolbarElement = element.toolbarElement;
        var groupElement = toolbarElement.querySelector(".trix-button-group--file-tools");
        groupElement.style.display = 'none';
    }
});
