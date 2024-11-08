document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.getElementById("searchButton");
    const searchInput = document.getElementById("searchInput");
    const petTypeSelect = document.getElementById("petTypeSelect");

    searchButton?.addEventListener("click", function () {
        const query = searchInput.value;
        const petType = petTypeSelect.value;
        window.location.href = `search.php?keyword=${query}&type=${petType}`;
    });
});

function filterGallery() {
    const typeFilter = document.getElementById("typeFilter").value;
    window.location.href = `gallery.php?type=${typeFilter}`;
}
