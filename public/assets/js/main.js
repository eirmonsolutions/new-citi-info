document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.querySelector(".dashboard-wrapper");
    const toggleBtn = document.getElementById("menu-toggle-btn");

    if (!wrapper || !toggleBtn) return;

    // restore last state
    const saved = localStorage.getItem("sidebar-collapsed");
    if (saved === "1") wrapper.classList.add("sidebar-collapsed");

    toggleBtn.addEventListener("click", function () {
        wrapper.classList.toggle("sidebar-collapsed");

        // save state
        localStorage.setItem(
            "sidebar-collapsed",
            wrapper.classList.contains("sidebar-collapsed") ? "1" : "0"
        );
    });
});
