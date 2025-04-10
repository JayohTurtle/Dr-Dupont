
document.addEventListener("DOMContentLoaded", function () {
    const message = document.getElementById("error-message");
    if (message) {
        setTimeout(() => {
            message.style.display = "none";
        }, 1500);
    }
});
