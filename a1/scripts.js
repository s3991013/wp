function navigateMenu() {
    var menu = document.getElementById("menu");
    var selectedPage = menu.value;

    if (selectedPage === "home") {
        window.location.href = "index.html";
    } else if (selectedPage === "pets") {
        window.location.href = "pets.html";
    } else if (selectedPage === "add-more") {
        window.location.href = "add.html";
    } else if (selectedPage === "gallery") {
        window.location.href = "gallery.html";
    }
}
