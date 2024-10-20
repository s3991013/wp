function navigateMenu() {
    var menu = document.getElementById("menu");
    var selectedPage = menu.value;

    if (selectedPage === "home") {
        window.location.href = "index.php";
    } else if (selectedPage === "pets") {
        window.location.href = "pets.php";
    } else if (selectedPage === "add-more") {
        window.location.href = "add.php";
    } else if (selectedPage === "gallery") {
        window.location.href = "gallery.php";
    }
}
